<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password; // [PERBAIKAN #5] Import Password rules
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Halaman login
     */
    public function login()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('pelanggan.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses login (Web)
     * [PERBAIKAN #3] Rate limiting sudah diterapkan di routes/web.php (throttle:5,1)
     */
    public function loginPost(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required',
        ]);

        $login    = $request->login;
        $password = $request->password;
        $remember = $request->has('remember');

        $fieldtype = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if (Auth::attempt([$fieldtype => $login, 'password' => $password], $remember)) {
            $request->session()->regenerate();

            return Auth::user()->role === 'admin'
                ? redirect()->route('admin.dashboard')->with('success', 'Selamat Datang Admin ' . Auth::user()->name)
                : redirect()->route('pelanggan.dashboard')->with('success', 'Selamat Datang ' . Auth::user()->name);
        }

        // Pesan error yang generik (tidak membedakan "email salah" vs "password salah")
        throw ValidationException::withMessages([
            'login' => ['Kredensial yang Anda masukkan tidak valid.'],
        ]);
    }

    /**
     * Halaman registrasi PUBLIK
     */
    public function publicRegister()
    {
        return view('auth.public_register');
    }

    /**
     * Proses registrasi PUBLIK
     * [PERBAIKAN #5] Password minimum 8 karakter, harus ada huruf dan angka
     * [PERBAIKAN #3] Rate limiting sudah diterapkan di routes/web.php (throttle:3,1)
     */
    public function publicRegisterPost(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255', 'unique:users,name'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'phone'    => ['required', 'string', 'max:20'],
            // [PERBAIKAN #5] Naik dari min:6 → min:8 + wajib ada huruf + angka
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'phone.required'     => 'Nomor telepon wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.letters'   => 'Password harus mengandung huruf.',
            'password.numbers'   => 'Password harus mengandung angka.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'customer',
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Silakan login.');
    }

    /**
     * Halaman & form registrasi oleh Admin
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi oleh Admin
     * [PERBAIKAN #5] Password minimum 8 karakter
     */
    public function registerPost(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'unique:users,name', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'role'     => ['required', 'in:admin,customer'],
            'phone'    => ['required_if:role,customer', 'nullable', 'string', 'max:20'],
            // [PERBAIKAN #5] Password lebih kuat
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'phone'    => $request->phone,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Registrasi berhasil!');
    }

    /**
     * Hapus pengguna
     * [PERBAIKAN #1] Sekarang hanya bisa diakses admin (middleware 'admin' di routes)
     * [PERBAIKAN #1] Method sekarang DELETE (bukan GET) agar tidak bisa dipanggil via URL langsung
     * [PERBAIKAN #4] Admin tidak bisa menghapus akun dirinya sendiri
     */
    public function hapus($id)
    {
        $user = User::findOrFail($id);

        // [PERBAIKAN #4] Cegah admin menghapus akunnya sendiri
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Hapus semua data relasi
        foreach ($user->bookings as $booking) {
            $booking->serviceAdvisors()->delete();
            $booking->delete();
        }

        $user->delete();

        return redirect()->back()->with('success', 'Pengguna dan semua data relasi berhasil dihapus.');
    }

    /**
     * Halaman profil pengguna
     */
    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    /**
     * Update profil pengguna
     * [PERBAIKAN #5] Password minimum 8 karakter saat update
     */
    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email,' . Auth::id()],
            // [PERBAIKAN #5] Password nullable tapi kalau diisi harus kuat
            'password' => ['nullable', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        $updateData = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $request->user()->update($updateData);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Logout pengguna
     * [PERBAIKAN #2] Sekarang via POST (bukan GET) — sudah diatur di routes/web.php
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda berhasil logout.');
    }
}