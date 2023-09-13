<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signin() {
        return view('auth.signin');
    }

    public function signinPost(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $store = Store::where('user_id', Auth::user()->id)->first();

            $request->session()->regenerate();
            $request->session()->put('lfps_store', $store->store_slug);

            return response()->json(['status' => 200, 'message' => 'Sign in OK']);
        }

        return response()->json(['status' => 400, 'message' => 'Email atau password salah!'], 400);
    }
}
