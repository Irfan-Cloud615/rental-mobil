<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Daftar pelanggan: akun users (role 'user') digabung rincian customer_identities.
     */
    public function index(Request $request)
    {
        $customers = User::with('identity')
            ->withCount('bookings')
            ->where('role', 'user')
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%' . $request->input('q') . '%';
                $q->where(function ($qq) use ($term) {
                    $qq->where('name', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhereHas('identity', fn($i) => $i->where('phone', 'like', $term));
                });
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('content.admin.customers.index', compact('customers'));
    }

    /**
     * Detail pelanggan beserta identitas dan riwayat pemesanannya.
     */
    public function show(User $user)
    {
        abort_unless($user->role === 'user', 404);

        $user->load('identity');
        $bookings = $user->bookings()->with('car')->latest('created_at')->take(20)->get();

        return view('content.admin.customers.show', compact('user', 'bookings'));
    }
}
