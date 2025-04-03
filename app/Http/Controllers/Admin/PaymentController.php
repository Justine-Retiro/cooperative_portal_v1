<?php

namespace App\Http\Controllers\Admin;

use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Controller;
use App\Mail\SharePaymentMail;
use App\Models\Client;
use App\Models\LoanApplication;
use App\Models\LoanApplicationPayment;
use App\Models\MemberApplication;
use App\Models\Payment;
use App\Models\SharePayment;
use App\Models\Statement;
use App\Models\TransactionHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->query('search', '');
        $sort = $request->query('sort', 'id');
        $direction = $request->query('direction', 'asc');
        
        $query = Client::whereIn('id', function ($subQuery) {
            $subQuery->selectRaw('MIN(id)')
                ->from('clients')
                ->whereNull('deleted_at')
                ->groupBy('user_id');
        });
        
    
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
        $totalRecords = $payments->total();
        $recordsPerPage = $payments->perPage();
        $currentPageCount = $payments->count();

        if ($request->ajax()) {
            // Determine which pagination view to use
            $paginationView = $totalRecords > $recordsPerPage ? 'pagination::bootstrap-5' : 'admin.payment.partials.pagination';
        
            // Render the pagination links to HTML
            $paginationHtml = $totalRecords > $recordsPerPage ? 
            $payments->appends([
                'search' => $searchQuery,
            ])->links($paginationView)->toHtml() : 
            view($paginationView, [
                'count' => $currentPageCount,
                'total' => $totalRecords,
                'perPage' => $recordsPerPage,
                'currentPage' => $payments->currentPage(),
            ])->render();
    
            return response()->json([
                'html' => view('admin.payment.partials.payments_table', compact('payments'))->with('payments', $payments)->render(),
                'pagination' => $paginationHtml,
            ]);
        }
    
        return view('admin.payment.payment', compact('payments'));
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function edit(Request $request, $user_id){
        $client = Client::where('user_id', $user_id)->first();
        $user = User::find($user_id);
        if (!$client) {
            return redirect()->route('admin.payment')->with('error', 'Client not found.');
        }
        // $client = Client::with('memberApplication')->find($client->id);
        // dd($client->memberApplication);
        $client_member_application = $client->memberApplication;
    
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
    
                         
        return view('admin.payment.edit', compact('client', 'loans', 'client_member_application', 'user'));
    }

    public function storeSharePayment(Request $request, $user_id)
    {
        try {
            // \Log::info("storeSharePayment method called.");
            $client = Client::where('user_id', $user_id)->firstOrFail();

            $request->validate([
                'paymentShareAmount' => 'required|numeric|min:0',
                'note' => 'nullable|string',
                'remarksAccountShare' => 'required|string',
            ]);

            $paymentAmount = $request->paymentShareAmount;
            $newShareBalance = $client->memberApplication->balance - $paymentAmount;
            $newAccountBalance = $client->balance - $paymentAmount;

            $accountRemarks = $newAccountBalance == 0 ? 'Paid' : 'Unpaid';

            // Update and save MemberApplication balance
            $client->memberApplication->balance = $newShareBalance;
            $client->memberApplication->save();  // Ensure this save call is here

            $member_application_balance = $client->memberApplication->balance;


            if ($client->memberApplication->balance == 0) {
                $client->user->is_share_paid = true;
                $client->user->save();
            }

            // Update and save Client balance and remarks
            $client->balance = $newAccountBalance;
            $client->remarks = $accountRemarks;
            $client->save();

            $referenceNumber = 'SP' . strtoupper(Str::random(8));

            $payment = Payment::create([
                'reference_no' => $referenceNumber,
                'amount_paid' => $paymentAmount,
                'current_balance' => $newShareBalance,
                'account_number_id' => $client->user->id,
                'client_id' => $client->id,
                'note' => $request->note,
                'created_at' => now()->setTimezone('Asia/Manila'),
            ]);

            SharePayment::create([
                'payment_id' => $payment->id,
                'remarks' => $member_application_balance == 0 ? 'Fully Paid' : 'Paid Partially',
                'created_at' => now()->setTimezone('Asia/Manila'),
            ]);

            $transaction = TransactionHistory::create([
                'audit_description' => 'Payment for share holding balance has been recorded.',
                'transaction_type' => 'Payment',
                'transaction_status' => 'Completed',
                'account_number_id' => $client->user->id,
                'currently_assigned_id' => auth()->user()->id,
                'transaction_date' => now()->setTimezone('Asia/Manila'),
                'created_at' => now()->setTimezone('Asia/Manila'),
            ]);

            // Send email notification
            $paymentStatus = $newShareBalance > 0 ? 'Paid Partially' : 'Fully Paid';
            $mailData = [
                'client' => $client,
                'payment' => $payment,
                'transaction' => $transaction,
                'paymentStatus' => $paymentStatus,
            ];

            Mail::to($client->user->email)->send(new SharePaymentMail($mailData));

            return redirect()->back()->with('success', 'Payment successfully recorded.');
        } catch (\Exception $e) {
            // \Log::error("Error in storeSharePayment: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to process payment.');
        }
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
        $monthly_pay = $loan->monthly_pay;
        $remarks = $loan->remarks;

        $clientCurrentAccountBalance = $loan->client->balance; 

        // Determine the remarks based on loan balance
        $remarks = (floatval($balance) === 0.00) ? 'Paid' : 'Unpaid';

        return response()->json([
            'balance' => $balance,
            'monthly_pay' => $monthly_pay,
            'currentAccountBalance' => $clientCurrentAccountBalance,
            'remarks' => $remarks,
        ]);
    }
    public function storePayment(Request $request)
    {
        $request->validate([
            'loanNo' => 'required|exists:loan_applications,loan_reference',
            'amount' => 'required|numeric|min:0',
            'updatedAccountBalance' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:255',
        ]);
        // dd($request->all());
        DB::beginTransaction();
        try {

            $loan = LoanApplication::where('loan_reference', $request->loanNo)->firstOrFail();
            $client = $loan->client; // Assuming there's a 'client' relationship defined in LoanApplication
            $paymentAmount = $request->amount;
            $updatedAccountBalance = $request->updatedAccountBalance;
            $note = $request->note;
            $remarks = $request->remarks;
            $remarksAccount = $request->input('remarksAccount');

            $referenceNumber = 'LP' . strtoupper(Str::random(8));

            $loan->balance -= $paymentAmount;
            if ($loan->balance <= 0) {
                $loan->remarks = 'Paid';
            } else {
                $loan->remarks = 'Unpaid';
            }
            $client->balance -= $paymentAmount;
            
            if ($remarksAccount == 'Paid') {
                $client->remarks = 'paid';
            } else if ($remarksAccount == 'Unpaid') {
                $client->remarks = 'unpaid';
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
            $this->renderStatement($user_id);
            return back()->with('success', 'Payment successfully recorded.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error('Payment processing error', ['error' => $e->getMessage(), 'loanNo' => $request->loanNo]);

            return back()->withErrors('An error occurred while processing the payment: ' . $e->getMessage());
        }
    }
    public function statement()
    {
        // $loan = LoanApplication::find($loan_id);
        return view('admin.payment.pdf.statement');
    }
    public function renderStatement($user_id)
    {
        $user = User::findOrFail($user_id);
        $loanApplications = $user->loanApplications;

        $statements = $loanApplications->map(function ($loanApplication) {
            $payments = $loanApplication->payments;
            return [
                'company_name' => 'Your Company Name',
                'client_name' => $loanApplication->client->name,
                'client_address' => $loanApplication->client->address,
                'client_phone' => $loanApplication->client->phone,
                'statement_date' => now()->format('d-M-Y'),
                'statement_number' => $loanApplication->id,
                'customer_id' => $loanApplication->client->id,
                'balance_due' => $loanApplication->balance,
                'transactions' => $payments->map(function ($payment) {
                    return [
                        'issue_date' => $payment->created_at->format('d-M-Y'),
                        'due_date' => $payment->due_date->format('d-M-Y'),
                        'description' => $payment->description,
                        'reference_no' => $payment->reference_no,
                        'type' => $payment->type,
                        'total' => $payment->amount,
                    ];
                }),
            ];
        });

        return view('admin.payment.pdf.statement', ['statements' => $statements]);
    }
}
