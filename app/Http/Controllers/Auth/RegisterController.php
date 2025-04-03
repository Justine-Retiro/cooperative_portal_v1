<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ApplicationSubmittedMail;
use App\Models\MemberApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'last_name' => 'required|string|max:40',
            'middle_name' => 'nullable|string|max:40',
            'first_name' => 'required|string|max:40',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:40',
            'phone_number' => 'unique:clients|unique:member_application|required|numeric|digits:11',
            'civil_status' => 'required|string|max:40',
            'spouse_name' => 'required_if:civil_status,Married,Divorced,Widowed',
            'citizenship' => 'required|string|max:40',
            'provincial_address' => 'required|string|max:25',
            'city_address' => 'required|string|max:25',
            'mailing_address' => 'required|string|max:40',
            'email' => 'unique:member_application|unique:users|required|email',
            'tax_id_number' => 'required|numeric|digits:12',
            'position' => 'required|string|max:40',
            'date_employed' => 'required|date',
            'nature_of_work' => 'required|string|max:40',
            'amount_of_share' => 'required|numeric|min:2000|max:20000',
            'valid_id_type' => 'required|string|max:40',
        ]);
        $memberApplication = new MemberApplication();
        $existingApplication = MemberApplication::from('member_application as ma')
            ->leftJoin('clients as c', function($join) {
                $join->on('ma.last_name', '=', 'c.last_name')
                    ->on('ma.middle_name', '=', 'c.middle_name')
                    ->on('ma.first_name', '=', 'c.first_name')
                    ->on('ma.tax_id_number', '=', 'c.tax_id_number');
            })
            ->leftJoin('users as u', function($join) {
                $join->on('ma.email', '=', 'u.email');
            })
            ->where(function($query) use ($validatedData) {
                $query->where(function($q) use ($validatedData) {
                    $q->where('ma.last_name', $validatedData['last_name'])
                    ->orWhere('ma.middle_name', $validatedData['middle_name'])
                    ->orWhere('ma.first_name', $validatedData['first_name'])
                    ->orWhere('ma.tax_id_number', $validatedData['tax_id_number']);
                })
                ->whereIn('ma.status', ['Approved', 'Pending']);
            })
            ->orWhere(function($query) use ($validatedData) {
                $query->where('c.last_name', $validatedData['last_name'])
                    ->orWhere('c.middle_name', $validatedData['middle_name'])
                    ->orWhere('c.first_name', $validatedData['first_name'])
                    ->orWhere('c.tax_id_number', $validatedData['tax_id_number']);
            })
            ->orWhere(function($query) use ($validatedData) {
                $query->where('u.email', $validatedData['email']);
            })
            ->first();

        if ($existingApplication) {
            return redirect()->back()->with('message', 'This user is already registered.');
        }

        try {
            $memberApplication->fill($validatedData);
            $memberApplication->status = 'Pending';

            if ($request->hasFile('school_id_photo')) {
                $file = $request->file('school_id_photo');
                if (in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg']) && $file->getSize() <= 8388608) {
                    $path = $this->encryptAndStoreFile($file, 'school_id_photos');
                    $memberApplication->school_id_photo = $path;
                } else {
                    throw new \Exception('Invalid file type or size for school ID photo. Only JPEG, PNG, JPG up to 8MB are allowed.');
                }
            }

            if ($request->hasFile('valid_id_photo')) {
                $file = $request->file('valid_id_photo');
                if (in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg']) && $file->getSize() <= 8388608) {
                    $path = $this->encryptAndStoreFile($file, 'valid_id_photos');
                    $memberApplication->valid_id_photo = $path;
                } else {
                    throw new \Exception('Invalid file type or size for valid ID photo. Only JPEG, PNG, JPG up to 8MB are allowed.');
                }
            }

            $memberApplication->save();
            $name = $memberApplication->first_name . ' ' . $memberApplication->last_name;

            Mail::to($validatedData['email'])->send(new ApplicationSubmittedMail($memberApplication, $name));

            return redirect()->back()->with('success', 'Membership application submitted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    protected function encryptAndStoreFile($file, $directory)
    {
        $fileContent = file_get_contents($file);
        $encryptedContent = Crypt::encryptString($fileContent);
    
        $fileName = time() . '_' . uniqid() . '.dat';
        $targetPath = base_path('../public_html/' . $directory . '/' . $fileName);
    
        if (!file_exists(dirname($targetPath))) {
            mkdir(dirname($targetPath), 0777, true);
        }
    
        file_put_contents($targetPath, $encryptedContent);
    
        return $directory . '/' . $fileName;
    }
}
