<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    // public function index(Request $request)
    // {
    //     $query = User::where('role', 'customer')->withCount('bookings')->with('bookings');

    //     if ($request->has('search') && $request->search != '') {
    //         $search = $request->search;
    //         $query->where(function ($q) use ($search) {
    //             $q->where('name', 'like', "%{$search}%")
    //                 ->orWhere('email', 'like', "%{$search}%")
    //                 ->orWhereHas('bookings', function ($q) use ($search) {
    //                     $q->where('customer_whatsapp', 'like', "%{$search}%");
    //                 });
    //         });
    //     }

    //     $customers = $query->orderBy('created_at', 'desc')->paginate(10);

    //     return view('customers.index', compact('customers'));
    // }

    /**
     * Halaman login
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Proses login (Web)
     */
    public function loginPost(Request $request)
    {
        // 1. Validasi format input
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required',
        ]);

        $login = $request->login;
        $password = $request->password;

        $fieldtype = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? 'email' : 'name';

        if (Auth::attempt([$fieldtype => $login, 'password' => $password])) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat Datang Admin');
            }

            return redirect()->route('pelanggan/dashboard')->with('success', 'Selamat Datang');
        }

        throw ValidationException::withMessages([
            'login' => ['Nama / Email Salah'],
        ]);
    }

    /**
     * Halaman registrasi
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi (Web)
     */
    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:users,name' ,'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => in_array($request->role, ['admin', 'customer']) ? $request->role : 'customer',
        ]);

        // Auth::login($user); // Login otomatis setelah registrasi

        return redirect()->route('admin.dashboard')->with('success', 'Registrasi berhasil!');
    }

    /**
     * Menampilkan halaman profil pengguna
     */
    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    /**
     * Memperbarui profil pengguna
     */
    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Validasi unik email, kecuali untuk email pengguna saat ini
            'email' => ['required', 'email', 'unique:users,email,' . Auth::user()->id],
            'password' => ['nullable', 'min:6', 'confirmed'],
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $request->user()->update($updateData);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Hapus pengguna beserta semua data relasi
     */
    public function hapus($id)
    {
        $user = User::findOrFail($id);

        // Hapus semua booking yang terkait dengan user
        foreach ($user->bookings as $booking) {
            // Hapus service advisor yang terkait dengan booking
            $booking->serviceAdvisors()->delete();
            // Hapus booking
            $booking->delete();
        }

        // Hapus user
        $user->delete();

        return redirect()->back()->with('success', 'Pengguna dan semua data relasi berhasil dihapus.');
    }

    /**
     * Logout pengguna (Web)
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda berhasil logout.');
    }
}
