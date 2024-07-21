<?php

namespace App\Http\Controllers;

use App\Models\Organizations;
use App\Models\User;
use App\Rules\TcNo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public $rules = [
        'company_name' => 'required|string|max:255',
        'tax_number' => ['required', 'numeric', 'unique:organizations,tax_number'],
        'tax_office' => 'required|string|max:255',
        'mersis_no' => ['required', 'numeric', 'unique:organizations,mersis_no'],
        'kep_address' => 'sometimes|nullable|email|max:255',
        'city' => 'required|string|max:255',
        'province' => 'required|string|max:255',
        'district' => 'required|string|max:255',
        'address' => 'required|string|max:500',
        'email' => 'required|email|max:255|unique:organizations,email',
        'phone' => ['required', 'numeric', 'digits_between:10,15'],

        'auth_name' => 'required|string|max:255',
        'auth_surname' => 'required|string|max:255',
        'tc_no' => ['required', TcNo::class, 'unique:organizations,tc_no'],
        'auth_email' => 'required|email|max:255|unique:users,email',
        'job_title' => 'required|string|max:255',
        'auth_phone' => ['required', 'numeric', 'digits_between:10,15'],
        'password' => 'required|string|min:8|confirmed',

        'signature_circus' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        'tax_certificate' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        'registration_certificate' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
    ];

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $organization = new Organizations();
        $organization->name = $validated['company_name'];
        $organization->tax_number = $validated['tax_number'];
        $organization->tax_office = $validated['tax_office'];
        $organization->mersis_no = $validated['mersis_no'];
        $organization->kep_address = $validated['kep_address'];
        $organization->city = $validated['city'];
        $organization->province = $validated['province'];
        $organization->district = $validated['district'];
        $organization->address = $validated['address'];
        $organization->email = $validated['email'];
        $organization->phone = $validated['phone'];

        $organization->signature_circus = $validated['signature_circus']->store('documents');
        $organization->tax_certificate = $validated['tax_certificate']->store('documents');
        $organization->registration_certificate = $validated['registration_certificate']->store('documents');

        $organization->save();

        $user = new User();
        $user->name = $validated['auth_name'];
        $user->surname = $validated['auth_surname'];
        $user->tc_no = $validated['tc_no'];
        $user->email = $validated['auth_email'];
        $user->job_title = $validated['job_title'];
        $user->phone = $validated['auth_phone'];
        $user->password = bcrypt($validated['password']);

        $user->save();

        return response()->json([
            'user' => $user,
            'organization' => $organization,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
//            'password' => ['required', Rules\Password::defaults()],
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->input('remember-me', false))) {
            return response()->json(\auth()->user(), 200);
        }else{
            return response()->json(['email' => 'Invalid credentials', 'password' => 'Invalid credentials']);
        }

    }

    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json(null, 204);
    }
}
