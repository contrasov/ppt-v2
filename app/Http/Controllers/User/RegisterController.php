<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        return Inertia::render('auth/Register');
    }

    public function store(Request $request)
    {
        $validedData = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'username' => $validedData['username'],
            'email' => $validedData['email'],
            'password' => Hash::make($validedData['password']),
        ]);

        Auth::login($user);

        return redirect(route('home'));
    }
}
