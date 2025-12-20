<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\BoardingHouse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Show role selection page
     */
    public function showRoleSelection()
    {
        return view('auth.role-selection');
    }

    /**
     * Show login page
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Show owner registration form
     */
    public function showRegisterOwner()
    {
        return view('auth.register-owner');
    }

    /**
     * Show renter registration form
     */
    public function showRegisterRenter()
    {
        return view('auth.register-renter');
    }

    /**
     * Handle owner registration
     */
    public function registerOwner(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8'],
            'terms' => ['required', 'accepted'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'password' => Hash::make($validated['password']),
            'role' => 'owner',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan masuk dengan akun Anda.');
    }

    /**
     * Handle renter registration
     */
    public function registerRenter(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:17', 'max:100'],
            'gender' => ['required', 'in:Male,Female'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8'],
            'terms' => ['required', 'accepted'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'age.required' => 'Usia wajib diisi.',
            'age.integer' => 'Usia harus berupa angka.',
            'age.min' => 'Usia minimal 17 tahun.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'password' => Hash::make($validated['password']),
            'role' => 'renter',
            'age' => $validated['age'],
            'gender' => $validated['gender'],
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan masuk dengan akun Anda.');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Check if user is blocked
            if ($user->is_blocked) {
                Auth::logout();
                $request->session()->invalidate();
                return back()->withErrors([
                    'email' => 'Akun Anda telah diblokir. Silakan hubungi administrator.',
                ])->onlyInput('email');
            }

            // Log login activity
            LogActivity::login();

            // Redirect based on role
            if ($user->role === 'owner') {
                // Check if owner has any boarding house
                $hasKos = BoardingHouse::where('user_id', $user->id)->exists();
                if (!$hasKos) {
                    return redirect()->route('owner.kost.create')
                        ->with('info', 'Selamat datang! Silakan tambahkan kos pertama Anda untuk memulai.');
                }
                return redirect()->route('owner.dashboard');
            }

            return match($user->role) {
                'superadmin' => redirect()->route('superadmin.dashboard'),
                'renter' => redirect()->route('renter.dashboard'),
                default => redirect()->route('home'),
            };
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        // Log logout activity before logging out
        LogActivity::logout();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah keluar.');
    }
}
