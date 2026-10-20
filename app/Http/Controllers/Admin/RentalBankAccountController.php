<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RentalBankAccount;
use Illuminate\Http\Request;

class RentalBankAccountController extends Controller
{
    public function index()
    {
        $accounts = RentalBankAccount::orderBy('bank_name')->paginate(15);

        return view('content.admin.bank-accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('content.admin.bank-accounts.create', ['account' => new RentalBankAccount(['is_active' => true])]);
    }

    public function store(Request $request)
    {
        RentalBankAccount::create($this->validated($request));

        return redirect()->route('admin.bank-accounts.index')->with('success', 'Rekening bank berhasil ditambahkan.');
    }

    public function edit(RentalBankAccount $bank_account)
    {
        return view('content.admin.bank-accounts.edit', ['account' => $bank_account]);
    }

    public function update(Request $request, RentalBankAccount $bank_account)
    {
        $bank_account->update($this->validated($request));

        return redirect()->route('admin.bank-accounts.index')->with('success', 'Rekening bank berhasil diperbarui.');
    }

    public function destroy(RentalBankAccount $bank_account)
    {
        if ($bank_account->payments()->exists()) {
            return back()->with('error', 'Rekening tidak dapat dihapus karena sudah dipakai transaksi pembayaran. Nonaktifkan saja bila tidak digunakan.');
        }

        $bank_account->delete();

        return redirect()->route('admin.bank-accounts.index')->with('success', 'Rekening bank berhasil dihapus.');
    }

    /**
     * Toggle is_active agar rekening tampil/hilang di halaman pembayaran pelanggan.
     */
    public function toggleActive(RentalBankAccount $bank_account)
    {
        $bank_account->is_active = !$bank_account->is_active;
        $bank_account->save();

        return back()->with('success', 'Rekening ' . $bank_account->bank_name . ' kini ' . ($bank_account->is_active ? 'aktif' : 'nonaktif') . '.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'bank_name' => ['required', 'string', 'max:50'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_holder_name' => ['required', 'string', 'max:100'],
        ], [
            'bank_name.required' => 'Nama bank wajib diisi.',
            'account_number.required' => 'Nomor rekening wajib diisi.',
            'account_holder_name.required' => 'Atas nama wajib diisi.',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
