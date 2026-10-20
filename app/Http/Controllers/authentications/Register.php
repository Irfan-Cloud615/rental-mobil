<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Register extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-register', ['pageConfigs' => $pageConfigs]);
  }

  /**
   * Proses registrasi akun baru:
   * - buat data di tabel users (role otomatis "user")
   * - buat data identitas di tabel customer_identities
   * - langsung login dan arahkan ke halaman user (home)
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
      'phone' => ['nullable', 'string', 'max:20'],
      'address' => ['nullable', 'string', 'max:65535'],
    ], [
      'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
      'password.confirmed' => 'Konfirmasi password tidak sama dengan password.',
    ]);

    $user = User::create([
      'name' => $validated['name'],
      'email' => $validated['email'],
      'password' => Hash::make($validated['password']),
      'role' => 'user',
    ]);

    $user->identity()->create([
      'phone' => $validated['phone'] ?? null,
      'address' => $validated['address'] ?? null,
    ]);

    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->route('home');
  }
}
