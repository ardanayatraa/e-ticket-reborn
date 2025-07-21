<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Anhskohbo\NoCaptcha\Facades\NoCaptcha;

class PelangganAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.pelanggan.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('pelanggan')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.pelanggan.register');
    }

    public function register(Request $request)
    {
        // Manual captcha verification first
        $captchaResponse = $request->input('g-recaptcha-response');
        
        if (empty($captchaResponse) || !NoCaptcha::verifyResponse($captchaResponse)) {
            return back()->withErrors([
                'captcha' => 'Please complete the captcha verification.'
            ])->withInput();
        }

        $validatedData = $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pelanggans',
            'password' => 'required|string|min:8|confirmed',
            'alamat' => 'required|string',
            'nomor_whatsapp' => 'required|string'
        ]);

        $pelanggan = Pelanggan::create([
            'nama_pemesan' => $validatedData['nama_pemesan'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'alamat' => $validatedData['alamat'],
            'nomor_whatsapp' => $validatedData['nomor_whatsapp'],
        ]);

        Auth::guard('pelanggan')->login($pelanggan);

        return redirect('/')->with('success', 'Registrasi berhasil!');
    }

    public function logout(Request $request)
    {
        Auth::guard('pelanggan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}