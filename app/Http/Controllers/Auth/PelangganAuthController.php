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
        try {
            $captchaResponse = $request->input('g-recaptcha-response');
            if (empty($captchaResponse)) {
                return back()->withErrors(['g-recaptcha-response' => 'Silakan lengkapi CAPTCHA terlebih dahulu.'])->withInput();
            }
            if (!NoCaptcha::verifyResponse($captchaResponse)) {
                return back()->withErrors(['g-recaptcha-response' => 'Verifikasi CAPTCHA gagal. Silakan coba lagi.'])->withInput();
            }
            $validatedData = $request->validate([
                'nama_pemesan' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:pelanggans',
                'password' => 'required|string|min:8|confirmed',
                'alamat' => 'required|string',
                'nomor_whatsapp' => 'required|string'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data yang dimasukkan tidak valid.',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Registration error: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.'
                ], 500);
            }
            return back()->withErrors([
                'general' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.'
            ])->withInput();
        }
        $pelanggan = Pelanggan::create([
            'nama_pemesan' => $validatedData['nama_pemesan'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'alamat' => $validatedData['alamat'],
            'nomor_whatsapp' => $validatedData['nomor_whatsapp'],
        ]);
        Auth::guard('pelanggan')->login($pelanggan);
        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil!'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('pelanggan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}