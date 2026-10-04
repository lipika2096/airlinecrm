<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\SupplierContact;
use App\Models\SupplierAccount;
use App\Models\SupplierLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $currentUserId = null;
        $userType = 'superadmin';

        if (auth('admin')->check()) {
            $currentUserId = auth('admin')->user()->id;
            $userType = auth('admin')->user()->hasRole('SuperAdmin') ? 'superadmin' : 'customer';
        } elseif (auth()->check()) {
            $currentUserId = auth()->user()->id;
            $userType = 'staff';
        }

        $suppliersQuery = Supplier::query();

        if ($userType !== 'superadmin') {
            $suppliersQuery->where('created_by', $currentUserId);
        }

        // Handle search and filters
        $query = $request->input('q');
        $category = $request->input('category');
        $status = $request->input('status');

        if ($query) {
            $suppliersQuery->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('supplier_code', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%");
            });
        }

        if ($category && $category !== 'all') {
            $suppliersQuery->where('category', $category);
        }

        if ($status && $status !== 'all') {
            $suppliersQuery->where('status', $status);
        }

        $suppliers = $suppliersQuery->whereNull('deleted_at')->paginate(10);

        return view('admin.suppliers', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.supplier-create');
    }

    public function store(Request $request)
    {
        $currentUserId = null;

        if (auth('admin')->check()) {
            $currentUserId = auth('admin')->user()->id;
        } elseif (auth()->check()) {
            $currentUserId = auth()->user()->id;
        }

        $validatedData = $request->validate([
            'supplier_code' => 'required|string|unique:suppliers,supplier_code',
            'name' => 'required|string',
            'category' => 'required|string',
            'contact_person' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'status' => 'required|string|in:active,inactive',
            'website' => 'nullable|string',
            'description' => 'nullable|string',
            'payment_terms' => 'nullable|string',
            'currency' => 'nullable|string',
            'tax_id' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $validatedData['created_by'] = $currentUserId;

        Supplier::create($validatedData);

        return redirect()->route('admin.suppliers')->with('success', 'Supplier added successfully');
    }

    public function update(Request $request, $id)
    {
        $currentUserId = null;

        if (auth('admin')->check()) {
            $currentUserId = auth('admin')->user()->id;
        } elseif (auth()->check()) {
            $currentUserId = auth()->user()->id;
        }

        $validatedData = $request->validate([
            'supplier_code' => 'required|string|unique:suppliers,supplier_code,' . $id,
            'name' => 'required|string',
            'category' => 'required|string',
            'contact_person' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'status' => 'required|string|in:active,inactive',
            'website' => 'nullable|string',
            'description' => 'nullable|string',
            'payment_terms' => 'nullable|string',
            'currency' => 'nullable|string',
            'tax_id' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $validatedData['updated_by'] = $currentUserId;

        $supplier = Supplier::findOrFail($id);
        $supplier->update($validatedData);

        return redirect()->route('admin.suppliers')->with('success', 'Supplier updated successfully');
    }

    public function show($id)
    {
        $supplier = Supplier::with(['contacts', 'accounts', 'ledger'])->findOrFail($id);
        return view('admin.supplier-view', compact('supplier'));
    }

    public function edit($id)
    {
        $supplier = Supplier::with(['contacts', 'accounts', 'ledger'])->findOrFail($id);
        return view('admin.supplier-edit', compact('supplier'));
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update([
            'deleted_at' => now()
        ]);

        return redirect()->route('admin.suppliers')->with('success', 'Supplier deleted successfully');
    }

    // Contact Management Methods
    public function storeContact(Request $request, $supplierId)
    {
        $currentUserId = null;

        if (auth('admin')->check()) {
            $currentUserId = auth('admin')->user()->id;
        } elseif (auth()->check()) {
            $currentUserId = auth()->user()->id;
        }

        $validatedData = $request->validate([
            'title' => 'nullable|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'position' => 'nullable|string',
            'department' => 'nullable|string',
        ]);

        $validatedData['supplier_id'] = $supplierId;
        $validatedData['is_primary'] = $request->has('is_primary') ? 1 : 0;
        $validatedData['created_by'] = $currentUserId;

        // If this is set as primary, unmark other contacts
        if ($validatedData['is_primary']) {
            SupplierContact::where('supplier_id', $supplierId)->update(['is_primary' => false]);
        }

        SupplierContact::create($validatedData);

        return redirect()->back()->with('success', 'Contact added successfully');
    }

    public function updateContact(Request $request, $supplierId, $contactId)
    {
        $currentUserId = null;

        if (auth('admin')->check()) {
            $currentUserId = auth('admin')->user()->id;
        } elseif (auth()->check()) {
            $currentUserId = auth()->user()->id;
        }

        $validatedData = $request->validate([
            'title' => 'nullable|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'position' => 'nullable|string',
            'department' => 'nullable|string',
        ]);

        $validatedData['is_primary'] = $request->has('is_primary') ? 1 : 0;
        $validatedData['updated_by'] = $currentUserId;

        // If this is set as primary, unmark other contacts
        if ($validatedData['is_primary']) {
            SupplierContact::where('supplier_id', $supplierId)->where('id', '!=', $contactId)->update(['is_primary' => false]);
        }

        $contact = SupplierContact::findOrFail($contactId);
        $contact->update($validatedData);

        return redirect()->back()->with('success', 'Contact updated successfully');
    }

    public function destroyContact($supplierId, $contactId)
    {
        $contact = SupplierContact::findOrFail($contactId);
        $contact->delete();

        return redirect()->back()->with('success', 'Contact deleted successfully');
    }

    // Account Management Methods
    public function storeAccount(Request $request, $supplierId)
    {
        $currentUserId = null;

        if (auth('admin')->check()) {
            $currentUserId = auth('admin')->user()->id;
        } elseif (auth()->check()) {
            $currentUserId = auth()->user()->id;
        }

        $validatedData = $request->validate([
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'account_name' => 'required|string',
            'account_type' => 'required|string|in:checking,savings',
            'currency' => 'required|string',
            'swift_code' => 'nullable|string',
            'iban' => 'nullable|string',
            'routing_number' => 'nullable|string',
            'bank_address' => 'nullable|string',
        ]);

        $validatedData['supplier_id'] = $supplierId;
        $validatedData['is_primary'] = $request->has('is_primary') ? 1 : 0;
        $validatedData['created_by'] = $currentUserId;

        // If this is set as primary, unmark other accounts
        if ($validatedData['is_primary']) {
            SupplierAccount::where('supplier_id', $supplierId)->update(['is_primary' => false]);
        }

        SupplierAccount::create($validatedData);

        return redirect()->back()->with('success', 'Account added successfully');
    }

    public function updateAccount(Request $request, $supplierId, $accountId)
    {
        $currentUserId = null;

        if (auth('admin')->check()) {
            $currentUserId = auth('admin')->user()->id;
        } elseif (auth()->check()) {
            $currentUserId = auth()->user()->id;
        }

        $validatedData = $request->validate([
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'account_name' => 'required|string',
            'account_type' => 'required|string|in:checking,savings',
            'currency' => 'required|string',
            'swift_code' => 'nullable|string',
            'iban' => 'nullable|string',
            'routing_number' => 'nullable|string',
            'bank_address' => 'nullable|string',
        ]);

        $validatedData['is_primary'] = $request->has('is_primary') ? 1 : 0;
        $validatedData['updated_by'] = $currentUserId;

        // If this is set as primary, unmark other accounts
        if ($validatedData['is_primary']) {
            SupplierAccount::where('supplier_id', $supplierId)->where('id', '!=', $accountId)->update(['is_primary' => false]);
        }

        $account = SupplierAccount::findOrFail($accountId);
        $account->update($validatedData);

        return redirect()->back()->with('success', 'Account updated successfully');
    }

    public function destroyAccount($supplierId, $accountId)
    {
        $account = SupplierAccount::findOrFail($accountId);
        $account->delete();

        return redirect()->back()->with('success', 'Account deleted successfully');
    }

    // Ledger Management Methods
    public function getLedgerData($supplierId, Request $request)
    {
        $supplier = Supplier::findOrFail($supplierId);
        $query = SupplierLedger::where('supplier_id', $supplierId)->where('status', '!=', 'cancelled');

        // Apply filters
        if ($request->has('from_date') && $request->from_date) {
            $query->where('transaction_date', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date) {
            $query->where('transaction_date', '<=', $request->to_date);
        }
        if ($request->has('transaction_type') && $request->transaction_type !== 'all') {
            $query->where('transaction_type', $request->transaction_type);
        }
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('reference_no', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->orderBy('id', 'desc')->paginate(10);

        // Calculate totals (excluding cancelled)
        $totalDebit = SupplierLedger::where('supplier_id', $supplierId)->where('status', '!=', 'cancelled')
            ->when($request->has('from_date') && $request->from_date, function ($q) use ($request) {
                $q->where('transaction_date', '>=', $request->from_date);
            })
            ->when($request->has('to_date') && $request->to_date, function ($q) use ($request) {
                $q->where('transaction_date', '<=', $request->to_date);
            })
            ->when($request->has('transaction_type') && $request->transaction_type !== 'all', function ($q) use ($request) {
                $q->where('transaction_type', $request->transaction_type);
            })
            ->sum('debit');

        $totalCredit = SupplierLedger::where('supplier_id', $supplierId)->where('status', '!=', 'cancelled')
            ->when($request->has('from_date') && $request->from_date, function ($q) use ($request) {
                $q->where('transaction_date', '>=', $request->from_date);
            })
            ->when($request->has('to_date') && $request->to_date, function ($q) use ($request) {
                $q->where('transaction_date', '<=', $request->to_date);
            })
            ->when($request->has('transaction_type') && $request->transaction_type !== 'all', function ($q) use ($request) {
                $q->where('transaction_type', $request->transaction_type);
            })
            ->sum('credit');

        $closingBalance = $totalDebit - $totalCredit;

        // Get opening balance (before filtered date range)
        $openingBalance = 0;
        if ($request->has('from_date') && $request->from_date) {
            $openingBalance = SupplierLedger::where('supplier_id', $supplierId)->where('status', '!=', 'cancelled')
                ->where('transaction_date', '<', $request->from_date)
                ->sum('debit') - SupplierLedger::where('supplier_id', $supplierId)->where('status', '!=', 'cancelled')
                ->where('transaction_date', '<', $request->from_date)
                ->sum('credit');
        } else {
            $openingBalance = SupplierLedger::where('supplier_id', $supplierId)->where('status', '!=', 'cancelled')
                ->sum('debit') - SupplierLedger::where('supplier_id', $supplierId)->where('status', '!=', 'cancelled')
                ->sum('credit') - ($totalDebit - $totalCredit);
        }

        return response()->json([
            'transactions' => $transactions,
            'total_debit' => $totalDebit,
            'total_credit' => $totalCredit,
            'closing_balance' => $closingBalance,
            'opening_balance' => $openingBalance,
        ]);
    }

    public function storeLedgerTransaction(Request $request, $supplierId)
    {
        $currentUserId = null;

        if (auth('admin')->check()) {
            $currentUserId = auth('admin')->user()->id;
        } elseif (auth()->check()) {
            $currentUserId = auth()->user()->id;
        }

        $validatedData = $request->validate([
            'transaction_date' => 'required|date',
            'reference_no' => 'required|string|unique:supplier_ledger,reference_no',
            'transaction_type' => 'required|string|in:Invoice,Payment,Credit Note,Adjustment',
            'description' => 'nullable|string',
            'debit' => 'required|numeric|min:0',
            'credit' => 'required|numeric|min:0',
            'status' => 'required|string|in:posted,pending,cancelled',
        ]);

        // Calculate running balance
        $lastBalance = SupplierLedger::where('supplier_id', $supplierId)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        $previousBalance = $lastBalance ? $lastBalance->running_balance : 0;
        $runningBalance = $previousBalance + $validatedData['debit'] - $validatedData['credit'];

        $validatedData['supplier_id'] = $supplierId;
        $validatedData['running_balance'] = $runningBalance;
        $validatedData['created_by'] = $currentUserId;

        SupplierLedger::create($validatedData);

        return redirect()->back()->with('success', 'Transaction added successfully');
    }

    public function updateLedgerTransaction(Request $request, $supplierId, $transactionId)
    {
        $currentUserId = null;

        if (auth('admin')->check()) {
            $currentUserId = auth('admin')->user()->id;
        } elseif (auth()->check()) {
            $currentUserId = auth()->user()->id;
        }

        $validatedData = $request->validate([
            'transaction_date' => 'required|date',
            'reference_no' => 'required|string|unique:supplier_ledger,reference_no,' . $transactionId,
            'transaction_type' => 'required|string|in:Invoice,Payment,Credit Note,Adjustment',
            'description' => 'nullable|string',
            'debit' => 'required|numeric|min:0',
            'credit' => 'required|numeric|min:0',
            'status' => 'required|string|in:posted,pending,cancelled',
        ]);

        $validatedData['updated_by'] = $currentUserId;

        $transaction = SupplierLedger::findOrFail($transactionId);
        $transaction->update($validatedData);

        // Recalculate running balances for all subsequent transactions
        $this->recalculateRunningBalances($supplierId);

        return redirect()->back()->with('success', 'Transaction updated successfully');
    }

    public function destroyLedgerTransaction($supplierId, $transactionId)
    {
        $transaction = SupplierLedger::findOrFail($transactionId);
        $transaction->delete();

        // Recalculate running balances for all subsequent transactions
        $this->recalculateRunningBalances($supplierId);

        return redirect()->back()->with('success', 'Transaction deleted successfully');
    }

    private function recalculateRunningBalances($supplierId)
    {
        $transactions = SupplierLedger::where('supplier_id', $supplierId)
            ->where('status', '!=', 'cancelled')
            ->orderBy('transaction_date', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $runningBalance = 0;
        foreach ($transactions as $transaction) {
            $runningBalance += $transaction->debit - $transaction->credit;
            $transaction->update(['running_balance' => $runningBalance]);
        }
    }
}
