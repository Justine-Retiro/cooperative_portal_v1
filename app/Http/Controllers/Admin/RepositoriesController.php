<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AccountDetailsMail;
use App\Mail\ResetPasswordMailAdmin;
use App\Models\Client;
use App\Models\MemberApplication;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Validator;

class RepositoriesController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();
        $searchQuery = $request->query('search', '');
        $sort = $request->query('sort', 'id');
        $direction = $request->query('direction', 'asc');

        if (!empty($searchQuery)) {
            $query->where('first_name', 'like', "%{$searchQuery}%")
                ->orWhere('last_name', 'like', "%{$searchQuery}%")
                ->orWhere('account_number', 'like', "%{$searchQuery}%");
        }

        $query->orderBy($sort, $direction);

        $clients = $query->paginate(20); // Adjust the number per page as needed

        if ($request->ajax()) {
            $view = view('admin.partials.client_row', compact('clients'))->render();
            $pagination = '';
            // Check if the total number of clients is greater than the number per page
            if ($clients->total() > $clients->perPage()) {
                $pagination = $clients->links()->toHtml(); // Render pagination links
            }
            return response()->json(['html' => $view, 'pagination' => $pagination]);
        }

        $memberApplicationsCount = MemberApplication::where('status', 'pending')->count();
        return view('admin.repositories.repositories', compact('clients', 'memberApplicationsCount'));
    }
    public function filter(Request $request)
    {
        
        // $query = Client::whereHas('user');
        $searchQuery = $request->query('search', '');
        $query = Client::whereIn('id', function ($subQuery) {
            $subQuery->selectRaw('MIN(id)')
                ->from('clients')
                ->whereNull('deleted_at')
                ->groupBy('user_id');
        });
        $countQuery = clone $query;
        
        // Search functionality
        if (!empty($searchQuery)) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('first_name', 'LIKE', "%{$searchQuery}%")
                ->orWhere('middle_name', 'LIKE', "%{$searchQuery}%")
                ->orWhere('last_name', 'LIKE', "%{$searchQuery}%")
                
                ->orWhereHas('user', function($q) use ($searchQuery) {
                    $q->where('account_number', 'LIKE', "%{$searchQuery}%");
                    $q->orWhere('email', 'LIKE', "%{$searchQuery}%");
                });
            });
            $countQuery->where(function($q) use ($searchQuery) {
                $q->where('first_name', 'LIKE', "%{$searchQuery}%")
                ->orWhere('middle_name', 'LIKE', "%{$searchQuery}%")
                ->orWhere('last_name', 'LIKE', "%{$searchQuery}%")
                ->orWhereHas('user', function($q) use ($searchQuery) {
                    $q->where('account_number', 'LIKE', "%{$searchQuery}%");
                });
            });
        }

        $clients = $query->paginate(20);
        $totalRecords = $clients->total();
        $recordsPerPage = $clients->perPage();
        $currentPageCount = $clients->count();

        // Check if it's an AJAX request
        if ($request->ajax()) {
            // Determine which pagination view to use
            $paginationView = $totalRecords > $recordsPerPage ? 'pagination::bootstrap-5' : 'admin.repositories.partials.pagination';
        
            // Render the pagination links to HTML
            $paginationHtml = $totalRecords > $recordsPerPage ? 
                $clients->appends([
                    'search' => $searchQuery,
                ])->links($paginationView)->toHtml() : 
                view($paginationView, [
                    'count' => $currentPageCount,
                    'total' => $totalRecords,
                    'perPage' => $recordsPerPage,
                    'currentPage' => $clients->currentPage(),
                ])->render();
        
                return response()->json([
                    'html' => view('admin.repositories.partials.clients_table', compact('clients'))->with('clients', $clients)->render(),
                    'pagination' => $paginationHtml,
                ]);
        }
    }
    public function paginateClients(Request $request){
        if ($request->ajax()) {
            $clients = Client::paginate(10); // Adjust the number per page as needed
            $view = view('admin.partials.client_row', compact('clients'))->render();
            $pagination = $clients->links()->toHtml();
            return response()->json(['html' => $view, 'pagination' => $pagination]);
        } else {
            abort(404); // Or handle non-AJAX requests as needed
        }
    }

    public function add(){
        $account_number = "6" . mt_rand(100000000, 999999999);
        $password = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@'), 0, 9);
        return view('admin.repositories.addrepo', ['account_number' => $account_number, 'password' => $password]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_number' => 'required|unique:users,account_number',
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'phone_num' => 'unique:clients,phone_number|nullable|numeric|digits:11',
            'taxID_num' => 'unique:clients,tax_id_number|nullable|numeric|digits:12',
            'password' => 'required',
            'email' => 'nullable|email|unique:users,email',
            'confirm_email' => 'nullable|same:email',
        ]);
        try {
            DB::transaction(function () use ($validated, $request) {
                // Create user
                $user = new User([
                    'role_id' => 2,
                    'account_number' => $validated['account_number'],
                    'name' => $validated['first_name'] . (empty($validated['middle_name']) ? '' : ' ' . $validated['middle_name']) . ' ' . $validated['last_name'],
                    'password' => Hash::make($validated['password']),
                    'default_password' => true,
                    'email' => $validated['email'] ?? null,
                    'birth_date' => $request->input('birth_date'),
                    'default_profile' => true,
                    'email_verified' => false,
                    'is_from_signup' => false,
                    'is_share_paid' => false,
                ]);
                $user->save();

                // Check if user_id has been used, if so, create a new user record
                if (Client::where('user_id', $user->id)->exists()) {
                    $user = User::create([
                        'email' => $validated['email'],
                        'role_id' => 2,
                        'name' => $validated['first_name'] . (empty($validated['middle_name']) ? '' : ' ' . $validated['middle_name']) . ' ' . $validated['last_name'],
                        'birth_date' => $request->input('birth_date'),
                        'account_number' => $validated['account_number'],
                        'password' => Hash::make($validated['password']),
                        'default_profile' => true,
                        'email_verified' => false,
                        'default_password' => true,
                        'is_from_signup' => true,
                        'is_share_paid' => false,
                    ]);
                }

                // Create client
                $client = new Client([
                    'user_id' => $user->id,
                    'first_name' => $validated['first_name'],
                    'middle_name' => $validated['middle_name'] ?? null,
                    'last_name' => $validated['last_name'],
                    'citizenship' => $request->input('citizenship'),
                    'civil_status' => $request->input('civil_status'),
                    'spouse_name' => $request->input('spouse_name'),
                    'birth_date' => $request->input('birth_date'),
                    'birth_place' => $request->input('birth_place'),
                    'provincial_address' => $request->input('provincial_address'),
                    'city_address' => $request->input('city_address'),
                    'mailing_address' => $request->input('mailing_address'),
                    'phone_number' => $validated['phone_num'],
                    'tax_id_number' => $validated['taxID_num'],
                    'date_employed' => $request->input('date_employed'),
                    'position' => $request->input('position'),
                    'account_status' => $request->input('account_status'),
                    'nature_of_work' => $request->input('natureOf_work'),
                    'amount_of_share' => $request->input('amountOf_share'),
                ]);
                $client->save();

                // Send email if provided
                if (!empty($validated['email'])) {
                    Mail::to($validated['email'])->send(new AccountDetailsMail($user, $validated['password']));
                }
            });

            return redirect()->route('admin.repositories')->with('success', 'Member added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add member: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $user = Client::find($id);
        return view('admin.repositories.editrepo', compact('user'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:25',
                'middle_name' => 'nullable|string|max:25',
                'last_name' => 'required|string|max:25',
                'citizenship' => 'required|string|max:255',
                'civil_status' => 'required|string|max:255',
                'spouse_name' => 'required|string|max:255',
                'birth_date' => 'required|date',
                'birth_place' => 'required|string|max:45',
                'provincial_address' => 'required|string|max:25',
                'city_address' => 'required|string|max:45',
                'mailing_address' => 'required|string|max:255',
                'phone_number' => 'numeric',
                'tax_id_number' => 'numeric',
                'date_employed' => 'required|date',
                'position' => 'required|string|max:35',
                'account_status' => 'required|string|max:255',
                'natureOf_work' => 'required|string|max:255',
            ]);

            $client = Client::with('user')->find($id);
            if (!$client) {
                return back()->with('error', 'Client not found.');
            }

            $fullName = $validated['first_name'] . ' ' . ($validated['middle_name'] ? $validated['middle_name'] . ' ' : '') . $validated['last_name'];
            
            $client->update($validated);
            $client->save();

            $user = User::find($client->user_id);
            if (!$user) {
                return back()->with('error', 'User not found.');
            }

            $user->update([
                'name' => $fullName,
                'birth_date' => $validated['birth_date'],
            ]);
            $user->save();

            return back()->with('success', 'Member updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }
    public function view($id, $account_number){
        $client = Client::where('user_id', $id)
                        ->whereHas('user', function ($query) use ($account_number) {
                            $query->where('account_number', $account_number);
                        })->first();
    
        if (!$client) {
            return back()->with('error', 'Client not found.');
        }
        return view('admin.repositories.viewrepo', compact('client'));
    }
    public function searchRepo(Request $request)
    {
        $searchQuery = $request->input('search');

        $query = Client::query();

        if ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('first_name', 'like', '%' . $searchQuery . '%')
                ->orWhere('middle_name', 'like', '%' . $searchQuery . '%')
                ->orWhere('last_name', 'like', '%' . $searchQuery . '%')
                ->orWhere('account_number', 'like', '%' . $searchQuery . '%')
                ->orWhere('nature_of_work', 'like', '%' . $searchQuery . '%');
            });
        }
        $clients = $query->paginate(10);

        if ($request->ajax()) {
            $paginationView = $clients->hasPages() ? 'pagination::bootstrap-5' : 'admin.repositories.partials.pagination';

            $paginationHtml = $clients->hasPages()
                ? $clients->appends(['search' => $searchQuery])->links($paginationView)->toHtml()
                : view($paginationView, [
                    'count' => $clients->count(),
                    'total' => $clients->total(),
                    'perPage' => $clients->perPage(),
                    'currentPage' => $clients->currentPage(),
                ])->render();

            return response()->json([
                'html' => view('admin.repositories.partials.client_table', compact('clients'))->render(),
                'pagination' => $paginationHtml,
            ]);
        }

        return view('admin.repositories.repositories', compact('clients'));
    }
    public function search(Request $request)
    {
        $searchQuery = $request->input('search');
        $searchTerm = $request->input('search', '');
        $query = Client::query();

        if ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('first_name', 'like', '%' . $searchQuery . '%')
                ->orWhere('middle_name', 'like', '%' . $searchQuery . '%')
                ->orWhere('last_name', 'like', '%' . $searchQuery . '%')
                ->orWhere('account_number', 'like', '%' . $searchQuery . '%')
                ->orWhere('nature_of_work', 'like', '%' . $searchQuery . '%');
            });
        }
        $clients = $query->paginate(10);

        if ($request->ajax()) {
            $paginationView = $clients->hasPages() ? 'pagination::bootstrap-5' : 'admin.repositories.partials.pagination';
    
            $paginationHtml = $clients->hasPages()
                ? $clients->appends(['search' => $searchQuery])->links($paginationView)->toHtml()
                : view($paginationView, [
                    'count' => $clients->count(),
                    'total' => $clients->total(),
                    'perPage' => $clients->perPage(),
                    'currentPage' => $clients->currentPage(),
                ])->render();
    
            return response()->json([
                'html' => view('admin.repositories.partials.client_table', compact('clients'))->render(),
                'pagination' => $paginationHtml,
            ]);
        }

        return view('admin.partials.client_row', compact('clients'));
    }
    public function resetPassword(Request $request, $id){
        try {
            $validated = $request->validate([
                'account_number' => $id,
                'email' => 'nullable|email|unique:users,email',
                'confirm_email' => 'nullable|same:email',
            ]);

            $user = User::find($id);
            if (!$user) {
                throw new \Exception("User not found.");
            }
            $password = $user->birth_date; 
            $user->password = bcrypt($password);
            $user->email = $validated['email'] ?? $user->email;
            $user->default_password = true;
            $user->save();
            // Send email if provided
            if (!empty($validated['email'])) {
                Mail::to($validated['email'])->send(new ResetPasswordMailAdmin($user, $password));
            } else {
                Mail::to($user->email)->send(new ResetPasswordMailAdmin($user, $password));
            }
            return back()->with('success', 'Password reset successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
