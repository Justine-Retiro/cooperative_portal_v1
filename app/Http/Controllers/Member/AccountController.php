<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\LoanApplication;
use App\Models\Payment;
use App\Models\SharePayment;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(){
        $user = auth()->user();
        $client = Client::where('user_id', $user->id)->first();
    
        if ($client) {
            $is_from_signup = $client->user->is_from_signup;
        } else {
            $is_from_signup = false; // Default value if no client is found
        }

        // Assuming the relationship is named 'loanApplications'
        $loanApplications = $client->loanApplications()
                                    ->whereIn('application_status', ['approved', 'rejected', 'pending'])
                                    ->latest()
                                    ->get();
    
        $balance = $client->balance ? $client->balance : '0.00';
        
        // Check if there is a recent loan application and it's within the last 30 seconds
        $loanApplicationStatus = 'No recent application';
        if ($loanApplications->isNotEmpty()) {
            $recentApplication = $loanApplications->first();
            if ($recentApplication->application_status === 'pending') {
                $loanApplicationStatus = 'pending';
            } else {
                $timeSinceUpdate = now()->diffInSeconds($recentApplication->updated_at);
                
                if (in_array($recentApplication->application_status, ['approved', 'rejected'])) {
                    if ($timeSinceUpdate <= 2592000) { 
                        $loanApplicationStatus = $recentApplication->application_status;
                    }
                }
            }
        }
        $recentApplicationUpdateTimestamp = $loanApplications->isNotEmpty() ? $loanApplications->first()->updated_at : null;

        // Accounting Payments
        $payments = $user->payments()->with(['loanApplications'])->orderBy('created_at', 'desc')->get();
        $sharePayments = $user->sharePayments()->with('payment')->orderBy('created_at', 'desc')->get();

        $recentLoanApplication = $client ? $client->loanApplications()->orderBy('created_at', 'desc')->take(5)->get() : collect();

        return view('members.account', [
            'loanBalance' => $balance,
            'remarks' => $client->remarks,
            'amount_of_shares' => $client->amount_of_share,
            'loanApplicationStatus' => $loanApplicationStatus,
            'payments' => $payments,
            'sharePayments' => $sharePayments,
            'loanApplications' => $loanApplications, 
            'recentLoanApplication' => $recentLoanApplication,
            'recentApplicationUpdateTimestamp' => $recentApplicationUpdateTimestamp,
            'is_from_signup' => $is_from_signup,
        ]);
    }
    public function refreshLoanPaymentsTrail() {
        $user = auth()->user();
        $payments = $user->payments()->with(['loanApplications'])->orderBy('created_at', 'desc')->get();
        return view('members.partials.loan_payments_trail', compact('payments'))->render();
    }
    public function refreshSharePaymentsTrail() {
        $user = auth()->user();
        $sharePayments = $user->sharePayments()->with('payment')->orderBy('created_at', 'desc')->get();
        return view('members.partials.share_payments_trail', compact('sharePayments'))->render();
    }
    public function refreshRecentLoanTrail() {
        $user = auth()->user();
        $client = Client::where('user_id', $user->id)->first();
        $recentLoanApplication = $client ? $client->loanApplications()->orderBy('created_at', 'desc')->take(5)->get() : collect();
        return view('members.partials.recent_loan_trail', compact('recentLoanApplication'))->render();
    }
}
