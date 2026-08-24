<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller
{
    public function index()
    {
        $bankAccounts = BankAccount::where('created_by', auth('admin')->user()->id)->get();
        return view('admin.bank-accounts.index', compact('bankAccounts'));
    }

    public function create()
    {
        return view('admin.bank-accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50|unique:bank_accounts,account_number',
            'ifsc_code' => 'nullable|string|max:20',
            'branch_name' => 'nullable|string|max:255',
            'account_type' => 'required|in:savings,current',
            'opening_balance' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        BankAccount::create([
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'ifsc_code' => $request->ifsc_code,
            'branch_name' => $request->branch_name,
            'account_type' => $request->account_type,
            'opening_balance' => $request->opening_balance,
            'current_balance' => $request->opening_balance,
            'notes' => $request->notes,
            'is_active' => true,
            'created_by' => auth('admin')->user()->id,
        ]);

        return redirect()->route('admin.bank-accounts.index')->with('success', 'Bank account created successfully.');
    }

    public function edit($id)
    {
        $bankAccount = BankAccount::find($id);
        return view('admin.bank-accounts.edit', compact('bankAccount'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50|unique:bank_accounts,account_number,' . $id,
            'ifsc_code' => 'nullable|string|max:20',
            'branch_name' => 'nullable|string|max:255',
            'account_type' => 'required|in:savings,current',
            'notes' => 'nullable|string',
        ]);

        $bankAccount = BankAccount::find($id);
        $bankAccount->update([
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'ifsc_code' => $request->ifsc_code,
            'branch_name' => $request->branch_name,
            'account_type' => $request->account_type,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.bank-accounts.index')->with('success', 'Bank account updated successfully.');
    }

    public function destroy($id)
    {
        $bankAccount = BankAccount::find($id);
        $bankAccount->delete();
        return redirect()->route('admin.bank-accounts.index')->with('success', 'Bank account deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $bankAccount = BankAccount::find($id);
        if ($bankAccount) {
            $bankAccount->is_active = !$bankAccount->is_active;
            $bankAccount->save();
            return redirect()->back()->with('success', 'Bank account status updated successfully.');
        }
        return redirect()->back()->with('error', 'Bank account not found.');
    }
}
