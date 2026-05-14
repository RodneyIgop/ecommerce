<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function handle(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'account_type' => ['required', 'in:personal,business'],
        ]);

        $role = $data['account_type'] === 'business' ? User::ROLE_BUSINESS : User::ROLE_BUYER;

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role,
            'status' => 'active',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->isBusiness()) {
            return redirect()->route('business.dashboard');
        }

        return redirect()->route('home');
    }
}
