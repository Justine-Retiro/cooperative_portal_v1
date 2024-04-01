<?php

namespace App\Http\Controllers\Admin;

use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\LoanApplication;
use App\Models\LoanApplicationPayment;
use App\Models\Payment;
use App\Models\TransactionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();
        $searchQuery = $request->query('search', '');
        $sort = $request->query('sort', 'id');
        $direction = $request->query('direction', 'asc');
    
        if (!empty($searchQuery)) {
            $query->whereHas('user', function($q) use ($searchQuery) { // Assuming 'user' is the relation name
                $q->where('first_name', 'like', "%{$searchQuery}%")
                  ->orWhere('last_name', 'like', "%{$searchQuery}%")
                  ->orWhere('account_number', 'like', "%{$searchQuery}%"); // This assumes 'account_number' is in the 'users' table
            })->orWhere('remarks', 'like', "%{$searchQuery}%")
            ->orWhere('account_status', 'like', "%{$searchQuery}%")
              ->orWhere('balance', 'like', "%{$searchQuery}%");
        }
    
        $query->orderBy($sort, $direction);
        $payments = $query->paginate(20);

        if ($request->ajax()) {
            $view = view('admin.payment.partials.payments_table', compact('payments'))->render();
            $pagination = $payments->links()->toHtml(); // Ensure pagination links are generated
            return response()->json(['html' => $view, 'pagination' => $pagination]);
        }
    
        return view('admin.payment.payment', compact('payments'));
    }

    public function edit(Request $request, $user_id){
        $client = Client::where('user_id', $user_id)->first();
        if (!$client) {
            return redirect()->route('admin.payment')->with('error', 'Client not found.');
        }
    
        $sortColumn = $request->get('sort', 'created_at'); // Default sort column changed to 'created_at'
        $sortDirection = $request->get('direction', 'desc'); // Default sort direction remains 'desc'
    
        // Ensure the sort direction is either 'asc' or 'desc'
        $sortDirection = in_array($sortDirection, ['asc', 'desc']) ? $sortDirection : 'desc'; // Default to 'desc' if invalid
    
        // Validate the sort column
        $validSortColumns = ['loan_reference', 'application_date', 'financed_amount', 'finance_charge', 'application_status', 'remarks', 'created_at']; // Added 'created_at' to valid sort columns
        if (!in_array($sortColumn, $validSortColumns)) {
            $sortColumn = 'created_at'; // Fallback to default sort column 'created_at' if invalid
        }
    
        // Retrieve all approved loan applications without pagination
        $loans = $client->loanApplications()
                         ->where('application_status', 'approved')
                         ->orderBy($sortColumn, $sortDirection)
                         ->get(); // Removed pagination
    
        return view('admin.payment.edit', compact('client', 'loans'));
    }

    public function getLoanDetails(Request $request, $user_id , $loanNo)
    {
        $loan = LoanApplication::where('loan_reference', $loanNo)
                                ->where('client_id', $user_id) 
                                ->first();
        if (!$loan) {
            return response()->json(['error' => 'Loan not found'], 404);
        }

        $balance = $loan->balance;
        $remarks = $loan->remarks;

        $clientCurrentBalance = $loan->client->balance; 

        // Determine the remarks based on loan balance
        $remarks = (floatval($balance) === 0.00) ? 'Paid' : 'Unpaid';

        return response()->json([
            'balance' => $balance,
            'currentBalance' => $clientCurrentBalance,
            'remarks' => $remarks,
        ]);
    }
    public function storePayment(Request $request)
    {
        $request->validate([
            'loanNo' => 'required|exists:loan_applications,loan_reference',
            'amount' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:255',
            'remarks' => 'required|in:Paid,Unpaid'
        ]);
        // dd($request->all());
        DB::beginTransaction();
        try {
            Log::info('Starting payment process', ['loanNo' => $request->loanNo]);

            $loan = LoanApplication::where('loan_reference', $request->loanNo)->firstOrFail();
            $client = $loan->client; // Assuming there's a 'client' relationship defined in LoanApplication
            $paymentAmount = $request->amount;
            $note = $request->note;

            $referenceNumber = 'LP' . strtoupper(Str::random(8));

            $loan->balance -= $paymentAmount;
            if ($loan->balance <= 0) {
                $loan->remarks = 'Paid';
            } else {
                $loan->remarks = 'Unpaid';
            }
            $client->balance -= $paymentAmount;
            if ($client->balance == 0.00 && !$client->loans()->where('remarks', 'Unpaid')->exists()) {
                $client->remarks = 'Paid';
            }

            if ($loan->balance < 0) {
                return back()->withErrors(['balance' => 'Payment amount exceeds the loan balance.']);
            }

            $loan->save();
            $client->save();
            $payment = Payment::create([
                'reference_no' => $referenceNumber,
                'amount_paid' => $paymentAmount,
                'current_balance' => $loan->balance,
                'account_number_id' => $client->user->id,
                'client_id' => $client->id,
                'note' => $note,
                'created_at' => now()->setTimezone('Asia/Manila'),
            ]);
            LoanApplicationPayment::create([
                'payment_id' => $payment->id,
                'current_balance' => $loan->balance,
                'loan_application_id' => $loan->id,
                'remarks' => $loan->balance == 0 ? 'Fully Paid' : 'Paid Partially',
            ]);

            TransactionHistory::create([
                'audit_description' => 'Payment for loan reference ' . $request->loanNo . ' has been recorded.',
                'transaction_type' => 'Payment',
                'transaction_status' => 'Completed',
                'account_number_id' => $client->user->id,
                'loan_application_id' => $loan->id,
                'currently_assigned_id' => auth()->user()->id,
                'transaction_date' => now()->setTimezone('Asia/Manila'),
            ]);

            DB::commit();
            Mail::to($client->user->email)->send(new InvoiceMail($client, $loan, $payment));
            return back()->with('message', 'Payment successfully recorded.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment processing error', ['error' => $e->getMessage(), 'loanNo' => $request->loanNo]);

            return back()->withErrors('An error occurred while processing the payment: ' . $e->getMessage());
        }
    }

}
