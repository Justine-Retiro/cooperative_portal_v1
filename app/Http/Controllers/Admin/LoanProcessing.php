<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\LoanVerdict;
use App\Models\Client;
use App\Models\LoanApplication;
use App\Models\LoanApplicationApprovals;
use App\Models\TransactionHistory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LoanProcessing extends Controller
{
    public function index(){
        $user = auth()->user();
    
        // Initialize variables to store counts
        $allCount = 0;
        $pendingCount = 0;
        $approvedCount = 0;
        $rejectedCount = 0;
    
        if ($user->hasPermission(1)) {
            // For users with permission level 1
            $loanApplications = LoanApplication::whereHas('approvals', function ($query) {
                $query->where('book_keeper', true);
            })->where('application_status', '!=', 'reject')->get();
    
            // Calculate counts based on the same conditions
            $allCount = $loanApplications->count();
            $pendingCount = $loanApplications->where('application_status', 'pending')->count();
            $approvedCount = $loanApplications->where('application_status', 'approved')->count();
            $rejectedCount = $loanApplications->where('application_status', 'rejected')->count();
        } elseif ($user->hasPermission(3)) {
            // For users with permission level 3
            $overAllloanApplications = LoanApplication::whereHas('approvals', function ($query) {
                $query->where('book_keeper', true)
                    ->where('general_manager', true);
            })->get();
            $overAllRejectedloanApplications = LoanApplication::whereHas('approvals', function ($query) {
                $query->where('book_keeper', true)
                    ->where('general_manager', '!=', true);
            })->get();
            
            $pendingApplicationsQuery = LoanApplication::whereHas('approvals', function ($query) {
                $query->where('book_keeper', false)->where('general_manager', false);
            })->where('application_status', 'pending');
            $loanApplications = LoanApplication::whereHas('approvals', function ($query) {
                $query->where('book_keeper', true);
            })->where('application_status', '!=', 'reject')->get();
            // Calculate counts
            $allCount = $loanApplications->count();
            $pendingCount = $pendingApplicationsQuery->count();
            $approvedCount = $loanApplications->where('application_status', 'approved')->count();
            $rejectedCount = $loanApplications->where('application_status', 'rejected')->count();
        } else {
            $loanApplications = LoanApplication::where('application_status', 'pending')->get();
    
            $allCount = $loanApplications->count();
            $pendingCount = $allCount;
        }
    
        return view('admin.loans.loan', compact('loanApplications', 'allCount', 'pendingCount', 'approvedCount', 'rejectedCount'));
    }

    public function filterLoansByStatus(Request $request, $status)
    {
        $user = auth()->user();
        $query = LoanApplication::query();
        $searchQuery = $request->query('search', '');
        $sort = $request->query('sort', 'desc'); // Capture the sort option
        $countQuery = clone $query;

        // Apply initial permission and status filters
        if ($user->hasPermission(1)) {
            $query->whereHas('approvals', function ($query) use ($status) {
                $query->where('book_keeper', true);
            });
            $countQuery = clone $query; // Clone after applying filters for accurate counts

            if ($status !== 'all') {
                $query->where('application_status', $status);
                $countQuery->where('application_status', $status);
            } else {
                $query->where('application_status', '!=', 'reject');
                $countQuery->where('application_status', '!=', 'reject');
            }
        } elseif ($user->hasPermission(3)) {
            if ($status !== 'all' && $status !== 'pending') {
                $query->where('application_status', $status);
                $countQuery->where('application_status', $status);
            } else if ($status === 'all') {
                $query->where(function ($query) {
                    $query->whereHas('approvals', function ($subQuery) {
                        $subQuery->where('book_keeper', true)
                                 ->where('general_manager', true);
                    })->orWhereHas('approvals', function ($subQuery) {
                        $subQuery->where('book_keeper', true)
                                 ->where('general_manager', false);
                    });
                });
                $countQuery = clone $query; // Clone after applying filters for accurate counts
            } else if ($status === 'pending') {
                $query->whereHas('approvals', function ($query) {
                    $query->where('book_keeper', false);
                })->where('application_status', 'pending');
                $countQuery->whereHas('approvals', function ($query) {
                    $query->where('book_keeper', false);
                })->where('application_status', 'pending');
            } 
        } else {
            if ($status === 'pending' || $status === 'all') {
                $query->where('application_status', 'pending');
                $countQuery->where('application_status', 'pending');
            } else {
                $query->where('id', '=', 0);
                $countQuery->where('id', '=', 0);
            }
        }

        if ($user->hasPermission(1)) {
            // For users with permission level 1
            $loanApplications = LoanApplication::whereHas('approvals', function ($query) {
                $query->where('book_keeper', true);
            })->where('application_status', '!=', 'reject')->get();
    
            // Calculate counts based on the same conditions
            $allCount = $loanApplications->count();
            $pendingCount = $loanApplications->where('application_status', 'pending')->count();
            $approvedCount = $loanApplications->where('application_status', 'approved')->count();
            $rejectedCount = $loanApplications->where('application_status', 'rejected')->count();
        } elseif ($user->hasPermission(3)) {
            // For users with permission level 3
            $overAllloanApplications = LoanApplication::whereHas('approvals', function ($query) {
                $query->where('book_keeper', true)
                    ->where('general_manager', true);
            })->get();
            $overAllRejectedloanApplications = LoanApplication::whereHas('approvals', function ($query) {
                $query->where('book_keeper', true)
                    ->where('general_manager', '!=', true);
            })->get();
            
            $pendingApplicationsQuery = LoanApplication::whereHas('approvals', function ($query) {
                $query->where('book_keeper', false)->where('general_manager', false);
            })->where('application_status', 'pending');
            $loanApplications = LoanApplication::whereHas('approvals', function ($query) {
                $query->where('book_keeper', true);
            })->where('application_status', '!=', 'reject')->get();
            // Calculate counts
            $allCount = $loanApplications->count();
            $pendingCount = $pendingApplicationsQuery->count();
            $approvedCount = $loanApplications->where('application_status', 'approved')->count();
            $rejectedCount = $loanApplications->where('application_status', 'rejected')->count();
        } else {
            $loanApplications = LoanApplication::where('application_status', 'pending')->get();
    
            $allCount = $loanApplications->count();
            $pendingCount = $allCount;
        }

        
        if (!empty($searchQuery)) {
            $query->where(function($q) use ($searchQuery) {
                $q->whereHas('user', function ($subQuery) use ($searchQuery) {
                    $subQuery->where('account_number', 'like', "%{$searchQuery}%");
                })->orWhere('customer_name', 'like', "%{$searchQuery}%")
                  ->orWhere('loan_reference', 'like', "%{$searchQuery}%"); 
            });
            // Apply the same search conditions to $countQuery
            $countQuery->where(function($q) use ($searchQuery) {
                $q->whereHas('user', function ($subQuery) use ($searchQuery) {
                    $subQuery->where('account_number', 'like', "%{$searchQuery}%");
                })->orWhere('customer_name', 'like', "%{$searchQuery}%")
                  ->orWhere('loan_reference', 'like', "%{$searchQuery}%"); 
            });
        }
        
        $query->orderBy('created_at', $sort);
        
        // Pagination Setting
        $loanApplications = $query->paginate(20);

        $allCount = $loanApplications->count();
        $pendingCount = $pendingApplicationsQuery->count();
        $approvedCount = $loanApplications->where('application_status', 'approved')->count();
        $rejectedCount = $loanApplications->where('application_status', 'rejected')->count();
        // Now, calculate counts based on $countQuery with all conditions applied
        $counts = [
            'all' => $allCount,
            'pending' => $pendingCount,
            'approved' => $approvedCount,
            'rejected' => $rejectedCount,
        ];
        return response()->json([
            'html' => view('admin.loans.partials.loan_table', compact('loanApplications'))->render(),
            'pagination' => $loanApplications->appends([
                'sort' => $sort,
                'search' => $searchQuery,
                'status' => $status
            ])->links()->toHtml(),
            'counts' => $counts,
            'currentFilter' => $request->status,
        ]);
    }



    
    // -----------------------------------------------------------------------------------
    // Member's Porfolio
    public function application(Request $request, $loanReference)
    {
        $currentLoanApplication = LoanApplication::with('approvals')->where('loan_reference', $loanReference)->firstOrFail();

        $bookKeeperApproved = $currentLoanApplication->approvals->contains(function($approval) {
            return $approval->book_keeper == true;
        }) && $currentLoanApplication->application_status !== 'reject';

        $sortColumn = $request->query('sort', 'created_at'); 
        $sortDirection = $request->query('direction', 'desc'); 

        // Initialize the query
        $query = LoanApplication::where('account_number_id', $currentLoanApplication->account_number_id);

        if ($sortColumn == 'application_status') {
            switch ($sortDirection) {
                case 'pending':
                    $query->orderByRaw("FIELD(application_status, 'pending', 'approved', 'rejected')");
                    break;
                case 'approved':
                    $query->orderByRaw("FIELD(application_status, 'approved', 'rejected', 'pending')");
                    break;
                case 'rejected':
                    $query->orderByRaw("FIELD(application_status, 'rejected', 'pending', 'approved')");
                    break;
                default:
                    $query->orderBy('application_status', 'asc');
                    break;
            }
        } else {
            $direction = in_array(strtolower($sortDirection), ['asc', 'desc']) ? $sortDirection : 'desc'; 
            $query->orderBy($sortColumn, $direction);
        }

        $pastLoanApplications = $query->paginate(5);

        try {
            $mediaItems = $currentLoanApplication->mediaItems()->where('loan_id', $currentLoanApplication->id)->get();
        } catch (\Exception $e) {
            Log::error("Error fetching media items: " . $e->getMessage());
        }

        if ($request->ajax()) {
            $tbodyHtml = view('admin.loans.partials.loan_table_info', ['pastLoanApplications' => $pastLoanApplications])->render();
            return response()->json([
                'table' => $tbodyHtml, 
            ]);
        }

        return view('admin.loans.application', compact('currentLoanApplication', 'pastLoanApplications', 'mediaItems', 'bookKeeperApproved'));
    }


    public function approveByLevel3(Request $request, $loanReference)
    {
        $loanApplication = LoanApplication::where('loan_reference', $loanReference)->firstOrFail();
        $user = auth()->user();

        if ($user->hasPermission(3)) {
            $transaction = new TransactionHistory();
            $transaction->audit_description = 'Loan Application Response';
            $transaction->transaction_type = 'Loan Application';
            $transaction->transaction_status = 'Approved';
            $transaction->transaction_date = now()->setTimezone('Asia/Manila');
            $transaction->account_number_id = $loanApplication->account_number_id;
            $transaction->loan_application_id = $loanApplication->id;
            $transaction->currently_assigned_id = auth()->id();
            $transaction->save();
            LoanApplicationApprovals::where('loan_id', $loanApplication->id)->update(['book_keeper' => true]);

            Mail::to($loanApplication->user->email)->send(new LoanVerdict($loanApplication, 'approvedByLevel3'));
            return redirect()->back()->with('message', 'Application approved successfully.');
        } else {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
    }

    public function rejectByLevel3(Request $request, $loanReference)
    {
        $loanApplication = LoanApplication::where('loan_reference', $loanReference)->firstOrFail();
        $user = auth()->user();
        $note = $request->input('note');
        if ($user->hasPermission(3)) {
            $loanApplication->note = $note;
            $loanApplication->update(['application_status' => 'rejected']);
            $loanApplication->save();

            $transaction = new TransactionHistory();
            $transaction->audit_description = 'Loan Application Response';
            $transaction->transaction_type = 'Loan Application';
            $transaction->transaction_status = 'Rejected';
            $transaction->transaction_date = now()->setTimezone('Asia/Manila');
            $transaction->account_number_id = $loanApplication->account_number_id;
            $transaction->loan_application_id = $loanApplication->id;
            $transaction->currently_assigned_id = auth()->id();
            $transaction->save();
            LoanApplicationApprovals::where('loan_id', $loanApplication->id)->update(['book_keeper' => true]);
            Mail::to($loanApplication->user->email)->send(new LoanVerdict($loanApplication, 'rejectedByLevel3'));
            return redirect()->back()->with('message', 'Application rejected successfully.');
        } else {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
    }

    public function finalAcceptance(Request $request, $loanReference)
    {
        $loanApplication = LoanApplication::where('loan_reference', $loanReference)->firstOrFail();
        $client = Client::where('id', $loanApplication->client_id)->first();
        $note = $request->input('note');
        $due_date = $request->input('due_date');
        $user = auth()->user();

        if ($user->hasPermission(1)) {
            $loanApplication->update(['application_status' => 'approved']);
            $loanApplication->update(['remarks' => 'unpaid']);
            $loanApplication->due_date = $due_date;
            $loanApplication->note = $note;
            $loanApplication->update(['balance' => $loanApplication->finance_charge]);
            $loanApplication->save();


            $transaction = new TransactionHistory();
            $transaction->audit_description = 'Loan Application Response';
            $transaction->transaction_type = 'Loan Application';
            $transaction->transaction_status = 'Approved';
            $transaction->transaction_date = now()->setTimezone('Asia/Manila');
            $transaction->account_number_id = $loanApplication->account_number_id;
            $transaction->loan_application_id = $loanApplication->id;
            $transaction->currently_assigned_id = auth()->id();
            $transaction->save();
            if ($client) { 
                $client->balance = $client->balance + $loanApplication->finance_charge;
                $client->update(['remarks' => 'unpaid']);
                $client->save();
            }
            LoanApplicationApprovals::where('loan_id', $loanApplication->id)->update(['general_manager' => true]);

            Mail::to($loanApplication->user->email)->send(new LoanVerdict($loanApplication, 'approvedByLevel1'));
            return redirect()->back()->with('message', 'Final acceptance successful.');
        } else {
            return redirect()->back()->with('error', 'Unauthorized action or invalid application status.');
        }
    }

    public function rejectByLevel1(Request $request, $loanReference)
    {
        $action = new LoanApplicationApprovals;
        $loanApplication = LoanApplication::where('loan_reference', $loanReference)->firstOrFail();
        $user = auth()->user();

        $note = $request->input('note');

        if ($user->hasPermission(1)) {
            $loanApplication->note = $note;
            $loanApplication->update(['application_status' => 'rejected']);
            $loanApplication->save();

            $transaction = new TransactionHistory();
            $transaction->audit_description = 'Loan Application Response';
            $transaction->transaction_type = 'Loan Application';
            $transaction->transaction_status = 'Rejected';
            $transaction->transaction_date = now()->setTimezone('Asia/Manila');
            $transaction->account_number_id = $loanApplication->account_number_id;
            $transaction->loan_application_id = $loanApplication->id;
            $transaction->currently_assigned_id = auth()->id();
            $transaction->save();
            LoanApplicationApprovals::where('loan_id', $loanApplication->id)->update(['general_manager' => true]);

            Mail::to($loanApplication->user->email)->send(new LoanVerdict($loanApplication, 'rejectedByLevel1'));

            return redirect()->back()->with('message', 'Application rejected successfully.');
        } else {
            return redirect()->back()->with('error', 'Unauthorized action or invalid application status.');
        }
    }
}
