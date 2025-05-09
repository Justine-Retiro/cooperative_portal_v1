<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Mail\LoanConfirmation;
use App\Models\Client;
use App\Models\LoanApplication;
use App\Models\LoanApplicationApprovals;
use App\Models\Media;
use App\Models\TransactionHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class LoanController extends Controller
{
    public function index(){
        $user = auth()->user();
        $client = Client::where('user_id', $user->id)->first();
        $loanApplications = $client->loanApplications()
                            ->whereIn('application_status', ['approved', 'rejected', 'pending'])
                            ->latest()
                            ->get();
        $totalLoans = $loanApplications->count();
        $totalApprovedLoans = $loanApplications->where('application_status', 'approved')->count();
        $totalRejectedLoans = $loanApplications->where('application_status', 'rejected')->count();
        $totalPendingLoans = $loanApplications->where('application_status', 'pending')->count();

        return view('members.loan.loan', compact('loanApplications', 'totalLoans', 'totalApprovedLoans', 'totalRejectedLoans', 'totalPendingLoans'));
    }
    public function add(){
        $user_id = auth()->user()->id;
        $client = User::find($user_id)->clients->first();
        // Check if there is a pending loan
        $hasPendingLoan = LoanApplication::where('client_id', $client->id)
                            ->where('application_status', 'pending')
                            ->exists();
        $hasUnpaidLoan = LoanApplication::where('client_id', $client->id)
                            ->where('remarks', 'unpaid')
                            ->exists();
        return view('members.loan.add', compact('client', 'hasPendingLoan', 'hasUnpaidLoan'));
    }
    public function store(Request $request)
    {
        try {
            $clientID = User::find(auth()->user()->id)->clients->first()->id;
            $request->validate([
                'time_pay' => 'required|numeric|min:1|max:150',
            ]);
            $loan_reference = "4" . mt_rand(1000000, 9999999);
            $application = new LoanApplication();
            $application->loan_reference = $loan_reference;
            $application->customer_name = $request->input('customer_name');
            $application->age = $request->input('age');
            $application->birth_date = $request->input('birth_date');
            $application->date_employed = $request->input('date_employed');
            $application->contact_num = $request->input('contact');
            $application->college = $request->input('college');
            $application->taxid_num = $request->input('taxid_num');
            $application->loan_type = $request->input('loan_type');
            $application->work_position = $request->input('position');
            $application->retirement_year = $request->input('retirement_year');
            $application->application_date = $request->input('application_date');
            $application->time_pay = $request->input('time_pay');
            $application->application_status = 'pending'; // Assuming default status is pending
            $application->financed_amount = str_replace(',', '', $request->input('amount_before'));
            $application->finance_charge = $request->input('amount_after');
            $application->monthly_pay = $request->input('monthly_pay');
            $application->remarks = null;
            $application->note = null;
            $application->due_date = null;
            $application->account_number_id = auth()->user()->id; // Assuming the logged in user is the account holder
            $application->client_id = $clientID;
            $application->take_action_by_id = null; // Assuming no action has been taken yet
            $application->created_at = now()->setTimezone('Asia/Manila');
            $application->save();
            
            $media = new Media();

            // Handle signature
            if ($request->hasFile('signature')) {
                $signature = $request->file('signature');
                if ($signature->getSize() <= 8388608 && in_array($signature->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
                    $signatureName = time() . '_' . $signature->getClientOriginalName();
                    $targetPath = base_path('../public_html/signatures');
                    
                    if (!file_exists($targetPath)) {
                        mkdir($targetPath, 0777, true);
                    }
                    
                    $signature->move($targetPath, $signatureName);
                    $media->signature = 'signatures/' . $signatureName;
                }
            }
                
            // Handle homepay_receipt
            if ($request->hasFile('homepay_receipt')) {
                $receipt = $request->file('homepay_receipt');
                if ($receipt->getSize() <= 8388608 && in_array($receipt->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
                    $receiptName = time() . '_' . $receipt->getClientOriginalName();
                    $targetPath = base_path('../public_html/receipts');
                    
                    if (!file_exists($targetPath)) {
                        mkdir($targetPath, 0777, true);
                    }
                    
                    $receipt->move($targetPath, $receiptName);
                    $media->take_home_pay = 'receipts/' . $receiptName;
                }
            }

            $media->loan_id = $application->id;
            $media->save();

            $client = Client::find($clientID);
            $client->increment('amount_of_share', $request->input('hidden_share'));

            $transaction = new TransactionHistory();
            $transaction->audit_description = 'Loan Application Submitted';
            $transaction->transaction_type = 'Loan Application';
            $transaction->transaction_status = 'Pending';
            $transaction->transaction_date = now()->setTimezone('Asia/Manila');
            $transaction->account_number_id = auth()->user()->id;
            $transaction->loan_application_id = $application->id;
            $transaction->currently_assigned_id = null;
            $transaction->save();

            $response = new LoanApplicationApprovals;
            $response->loan_id = $application->id;
            $response->book_keeper = false;
            $response->general_manager = false;
            $response->save();

            $user = auth()->user();
            
            Mail::to($user->email)->send(new LoanConfirmation($user));

            return redirect()->route('member.loan')->with('message', 'Loan application submitted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while processing your request: ' . $e->getMessage()]);
        }
    }
    public function refreshLoanTrail(){
        $user = auth()->user();
        $client = User::find($user->id)->clients->first();
        $loanApplications = $client->loanApplications()
                            ->whereIn('application_status', ['approved', 'rejected', 'pending'])
                            ->latest()
                            ->get();
        return view('members.loan.partials.loan_trails', compact('loanApplications'));
    }

}
