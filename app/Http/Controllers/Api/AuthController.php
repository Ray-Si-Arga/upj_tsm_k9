<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User; // Digunakan untuk Type Hinting
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException; // <<< KOREKSI: Impor ValidationException

class AuthController extends Controller
{
    /**
     * Proses login dan generate token untuk aplikasi Flutter.
     */
    public function login(Request $request)
    {
        try {
            // 1. Validasi
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
        } catch (ValidationException $e) { // Peringatan Undefined Type sudah hilang di sini
            return response()->json(['message' => 'Invalid credentials.', 'errors' => $e->errors()], 401);
        }

        if (Auth::attempt($credentials)) {
            /** @var User $user */ // Type Hinting untuk fix createToken
            $user = Auth::user();

            // 2. Tentukan kemampuan (abilities) berdasarkan role
            $abilities = [];
            if ($user->role === 'admin') {
                $abilities = ['admin-access', 'customer-access'];
            } else {
                $abilities = ['customer-access'];
            }

            // 3. Generate token
            $token = $user->createToken('authToken', $abilities)->plainTextToken;

            return response()->json([
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
                'role' => $user->role,
            ]);
        }

        return response()->json(['message' => 'Invalid email or password.'], 401);
    }

    /**
     * Proses registrasi dan generate token untuk pengguna baru (customer).
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer', // Default role untuk registrasi API
        ]);

        // Generate token untuk user baru dengan kemampuan customer
        $token = $user->createToken('authToken', ['customer-access'])->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'role' => $user->role,
        ], 201);
    }

    /**
     * Mengambil profil pengguna yang terautentikasi (digunakan untuk validasi token).
     */
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Logout pengguna (mencabut token yang sedang digunakan).
     */
    public function logout(Request $request)
    {
        // Mencabut token Sanctum saat ini
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
