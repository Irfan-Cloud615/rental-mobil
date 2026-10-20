<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login', ['pageConfigs' => $pageConfigs]);
  }

  /**
   * Proses login, lalu arahkan sesuai role:
   * - admin -> halaman admin (admin.home)
   * - user  -> halaman user (home)
   */
  public function store(Request $request)
  {
    $credentials = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required', 'string'],
    ]);

    if (!Auth::attempt($credentials, $request->boolean('remember'))) {
      return back()
        ->withInput($request->only('email', 'remember'))
        ->withErrors(['email' => 'Email atau kata sandi tidak sesuai.']);
    }

    $request->session()->regenerate();

    return auth()->user()->role === 'admin'
      ? redirect()->intended(route('admin.home'))
      : redirect()->intended(route('home'));
  }

  /**
   * Logout.
   */
  public function destroy(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('landing.index');
  }
}
