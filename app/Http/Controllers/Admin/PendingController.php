<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AccountDetailsMail;
use App\Mail\MembershipRejectionMail;
use App\Models\Client;
use App\Models\MemberApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class PendingController extends Controller
{
    public function index()
    {
        // $applyingMembers = MemberApplication::where('status', 'Pending');
        $allMember = MemberApplication::count();
        $approvedMember = MemberApplication::where('status', 'Approved')->count();
        $rejectedMember = MemberApplication::where('status', 'Rejected')->count();
        $pendingMember = MemberApplication::where('status', 'Pending')->count();
        
        return view('admin.repositories.pending.pending_dashboard', compact( 'approvedMember', 'rejectedMember', 'pendingMember', 'allMember'));
    }

    public function filter(Request $request, $status)
    {
        $query = MemberApplication::query();
        $searchQuery = $request->query('search', '');
        $sort = $request->query('sort', 'desc');
        $countQuery = clone $query;

        // Filter by status if not 'all'
        if ($status !== 'all') {
            $query->where('status', ucfirst($status));
            $countQuery->where('status', ucfirst($status));
        }

        // Search functionality
        if (!empty($searchQuery)) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('first_name', 'LIKE', "%{$searchQuery}%")
                ->orWhere('last_name', 'LIKE', "%{$searchQuery}%")
                ->orWhere('email', 'LIKE', "%{$searchQuery}%");
            });
            $countQuery->where(function($q) use ($searchQuery) {
                $q->where('first_name', 'LIKE', "%{$searchQuery}%")
                ->orWhere('last_name', 'LIKE', "%{$searchQuery}%")
                ->orWhere('email', 'LIKE', "%{$searchQuery}%");
            });
        }

        // Sorting
        $query->orderBy('created_at', $sort);

        $applyingMembers = $query->paginate(20);
        $totalRecords = $applyingMembers->total();
        $recordsPerPage = $applyingMembers->perPage();
        $currentPageCount = $applyingMembers->count();

        // Check if it's an AJAX request
        if ($request->ajax()) {
            // Determine which pagination view to use
            $paginationView = $totalRecords > $recordsPerPage ? 'pagination::bootstrap-5' : 'admin.repositories.pending.partials.pagination';
        
            // Render the pagination links to HTML
            $paginationHtml = $totalRecords > $recordsPerPage ? 
                $applyingMembers->appends([
                    'sort' => $sort,
                    'search' => $searchQuery,
                    'status' => $status
                ])->links($paginationView)->toHtml() : 
                view($paginationView, [
                    'count' => $currentPageCount,
                    'total' => $totalRecords,
                    'perPage' => $recordsPerPage,
                    'currentPage' => $applyingMembers->currentPage(),
                ])->render();
        
            return response()->json([
                'html' => view('admin.repositories.pending.partials.member_req_table', compact('applyingMembers'))->render(),
                'pagination' => $paginationHtml,
            ]);
        }
    }

    public function fetchRecords(Request $request)
    {
        $applyingMembers = MemberApplication::paginate(20);
        $totalRecords = $applyingMembers->total();

        // Check if total records are less than 20
        if ($request->ajax()) {
            $paginationView = $totalRecords < 20 ? 'admin.repositories.pending.partials.pagination' : 'pagination::bootstrap-4';
            $pagination = $applyingMembers->links()->toHtml();
    
            return response()->json([
                'html' => view('admin.repositories.pending.partials.member_req_table', compact('applyingMembers'))->render(),
                'pagination' => $pagination,
            ]);
        }

        // For non-AJAX request, return your normal view
        return view('admin.repositories.pending.pending_dashboard', compact('applyingMembers', 'pagination'));
    }
    public function getFilteredMembers(Request $request, $status)
    {
        // Filter the members based on the status
        $members = MemberApplication::where('status', $status)->get();
    
        // Calculate the counts for all statuses
        $counts = [
            'all' => MemberApplication::count(),
            'Pending' => MemberApplication::where('status', 'Pending')->count(),
            'Approved' => MemberApplication::where('status', 'Approved')->count(),
            'Rejected' => MemberApplication::where('status', 'Rejected')->count(),
        ];
    
        // Generate the HTML for the members
        $html = view('partials.members_table', compact('members'))->render();
    
        // Return the response
        return response()->json([
            'html' => $html,
            'counts' => $counts,
            'currentFilter' => $status,
        ]);
    }

    public function viewApplicant($id)
    {
        $applyingMember = MemberApplication::find($id);
        
        return view('admin.repositories.pending.view_applicant', compact('applyingMember'));
    }

    public function getDecryptedImageContent($path)
    {
        $targetPath = base_path('../public_html/' . $path);
        try {
            // if (!file_exists($targetPath)) {
            //     throw new \Exception('File does not exist.');
            // }

            $encryptedContent = file_get_contents($targetPath);
            $decryptedContent = Crypt::decryptString($encryptedContent);
        } catch (\Exception $e) {
            session()->flash('error',"File not found.");
            return;
        }

        return $decryptedContent;
    }

    // Decision Actions
    public function approve($id)
    {
        $application = MemberApplication::findOrFail($id);
        $existingApplication = MemberApplication::where(function($query) use ($application) {
            $query->where('last_name', $application->last_name)
                  ->where('middle_name', $application->middle_name)
                  ->where('first_name', $application->first_name)
                  ->where('tax_id_number', $application->tax_id_number)
                  ->where('status', 'Approved');
        })->orWhereExists(function ($query) use ($application) {
            $query->select(DB::raw(1))
                  ->from('clients')
                  ->whereRaw("clients.last_name = '{$application->last_name}'")
                  ->whereRaw("clients.middle_name = '{$application->middle_name}'")
                  ->whereRaw("clients.first_name = '{$application->first_name}'")
                  ->whereRaw("clients.tax_id_number = '{$application->tax_id_number}'");
        })->exists();
    
        if ($existingApplication) {
            return redirect()->back()->with('message', 'This user is already registered.');
        }
        try {
            DB::transaction(function () use ($id) {
                $application_member = MemberApplication::findOrFail($id);
                $application_member->status = 'Approved';
                $application_member->balance = $application_member->amount_of_share;
                $application_member->save();

                $account_number = "6" . mt_rand(100000000, 999999999);

                // Generate a random password
                $password = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@'), 0, 9);

                // Create or update User
                $user = User::updateOrCreate(
                    ['email' => $application_member->email], 
                    [
                        'role_id' => 2, // Assuming '2' is the correct role ID for approved members
                        'name' => $application_member->first_name . (empty($application_member->middle_name) ? '' : ' ' . $application_member->middle_name) . ' ' . $application_member->last_name,
                        'birth_date' => $application_member->birth_date,
                        'account_number' => $account_number,
                        'password' => Hash::make($password),
                        'default_profile' => true,
                        'email_verified' => false,
                        'default_password' => true,
                        'is_from_signup' => true,
                        'is_share_paid' => false,
                    ]
                );

                // Check if user_id has been used, if so, create a new user record
                if (Client::where('user_id', $user->id)->exists()) {
                    $user = User::create([
                        'email' => $application_member->email,
                        'role_id' => 2,
                        'name' => $application_member->first_name . (empty($application_member->middle_name) ? '' : ' ' . $application_member->middle_name) . ' ' . $application_member->last_name,
                        'birth_date' => $application_member->birth_date,
                        'account_number' => $account_number,
                        'password' => Hash::make($password),
                        'default_profile' => true,
                        'email_verified' => false,
                        'default_password' => true,
                        'is_from_signup' => true,
                        'is_share_paid' => false,
                    ]);
                }

                // Transfer details to Client table, excluding email
                $clientData = collect($application_member->getAttributes())->except(['email', 'id', 'created_at', 'updated_at', 'deleted_at', 'status'])->all();
                $client = new Client($clientData);
                $client->account_status = 'Active';
                $client->user_id = $user->id;
                $client->mailing_address = $application_member->mailing_address;
                $client->amount_of_share = $application_member->amount_of_share;
                $client->balance = $application_member->amount_of_share;
                $client->remarks = 'unpaid';
                $client->member_application_id = $application_member->id;
                $client->save();

                // Email the user with account details
                if (!empty($user->email)) {
                    Mail::to($user->email)->send(new AccountDetailsMail($user, $password));
                }
            });

            return redirect()->back()->with('success', 'Application approved and client details transferred.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error during approval: ' . $e->getMessage());
        }
    }
    public function reject($id)
    {
        $applyingMember = MemberApplication::find($id);
        $applyingMember->status = 'Rejected';
        Mail::to($applyingMember->email)->send(new MembershipRejectionMail($applyingMember->first_name, $applyingMember->email));
        $applyingMember->save();

        return redirect()->back()->with('success', 'Application rejected.');
    }
}
