<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\PaymentPoolTransaction;
use App\Models\CustomerAccount;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentPoolController extends Controller
{
    public function index(Request $request)
    {
        $currentYear = date('Y');
        $currentMonth = date('m');
        
        // Use customer_accounts as the source for payment pool
        $query = CustomerAccount::with('admin', 'allocatedToCustomerAccount.admin');
        
        // Only fetch records where credit or debit is not 0
        $query->where(function($q) {
            $q->where('credit', '!=', 0)
              ->orWhere('debit', '!=', 0);
        });
        
        // Default filter by current year and month
        $query->whereYear('tr_date', $currentYear)
              ->whereMonth('tr_date', $currentMonth);
        
        // Apply filters if provided
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('tr_date', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('tr_date', '<=', $request->to_date);
        }
        if ($request->has('status') && $request->status) {
            if ($request->status === 'unallocated') {
                $query->unallocated();
            } elseif ($request->status === 'allocated') {
                $query->allocated();
            }
        }
        if ($request->has('year') && $request->year) {
            $query->whereYear('tr_date', $request->year);
        }
        if ($request->has('month') && $request->month) {
            $query->whereMonth('tr_date', $request->month);
        }
        
        $transactions = $query->orderBy('tr_date', 'asc')->get();
        
        // Group by customer_id and calculate running balance (like customer ledger)
        $groupedTransactions = [];
        foreach ($transactions as $transaction) {
            $customerId = $transaction->customer_id;
            
            if (!isset($groupedTransactions[$customerId])) {
                // Get initial balance for this customer
                $initialBalance = CustomerAccount::where('customer_id', $customerId)
                    ->where('credit', 0)->where('debit', 0)
                    ->orderBy('created_at', 'asc')
                    ->first();
                
                $groupedTransactions[$customerId] = [
                    'customer_name' => $transaction->admin ? $transaction->admin->name : 'N/A',
                    'initial_balance' => $initialBalance ? $initialBalance->balance : 0,
                    'running_balance' => $initialBalance ? $initialBalance->balance : 0,
                    'first_entry_date' => $initialBalance ? $initialBalance->tr_date : null,
                    'transactions' => []
                ];
            }
            
            // Calculate running balance for this transaction
            $groupedTransactions[$customerId]['running_balance'] += $transaction->credit - $transaction->debit;
            $transaction->running_balance = $groupedTransactions[$customerId]['running_balance'];
            
            $groupedTransactions[$customerId]['transactions'][] = $transaction;
        }
        
        // Flatten the grouped transactions for display
        $flatTransactions = [];
        foreach ($groupedTransactions as $customerId => $customerData) {
            // Add opening balance entry if exists
            if ($customerData['first_entry_date']) {
                $openingBalance = new \stdClass();
                $openingBalance->id = null;
                $openingBalance->tr_date = $customerData['first_entry_date'];
                $openingBalance->admin = (object)['name' => $customerData['customer_name']];
                $openingBalance->bank_name = 'Opening Balance';
                $openingBalance->tr_type = '-';
                $openingBalance->debit = 0;
                $openingBalance->credit = $customerData['initial_balance'];
                $openingBalance->balance = $customerData['initial_balance'];
                $openingBalance->running_balance = $customerData['initial_balance'];
                $openingBalance->payment_pool = null;
                $openingBalance->is_opening = true;
                $flatTransactions[] = $openingBalance;
            }
            
            // Add transaction entries
            foreach ($customerData['transactions'] as $transaction) {
                $transaction->is_opening = false;
                $flatTransactions[] = $transaction;
            }
        }
        
        // Reverse for display (newest first)
        $transactions = collect($flatTransactions)->reverse();
        
        // Calculate totals
        $allFunds = CustomerAccount::sum('credit') - CustomerAccount::sum('debit');
        $unallocatedFunds = CustomerAccount::unallocated()->sum('credit') - CustomerAccount::unallocated()->sum('debit');
        $allocatedFunds = CustomerAccount::allocated()->sum('credit') - CustomerAccount::allocated()->sum('debit');
        
        // Get customer accounts for allocation dropdown (accounts with acc_no)
        $customerAccounts = CustomerAccount::with('admin')->whereNotNull('acc_no')->get();
        
        return view('admin.payment-pool', compact(
            'transactions',
            'allFunds',
            'unallocatedFunds',
            'allocatedFunds',
            'customerAccounts'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tr_date' => 'required|date',
            'bank_name' => 'nullable|string|max:255',
            'tr_type' => 'nullable|string|max:255',
            'debit' => 'required|numeric|min:0',
            'credit' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $transaction = new CustomerAccount();
        $transaction->tr_date = $request->tr_date;
        $transaction->bank_name = $request->bank_name;
        $transaction->tr_type = $request->tr_type;
        $transaction->debit = $request->debit;
        $transaction->credit = $request->credit;
        $transaction->balance = $request->credit - $request->debit;
        $transaction->payment_pool = 'unallocated';
        $transaction->status = 1;
        $transaction->save();

        return response()->json(['success' => 'Transaction added successfully.']);
    }

    public function allocate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'customer_account_id' => 'required|exists:customer_accounts,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $transaction = CustomerAccount::findOrFail($id);
        $transaction->payment_pool = 'allocated';
        $transaction->allocated_to_customer_account_id = $request->customer_account_id;
        $transaction->allocated_at = now();
        $transaction->save();

        // Add the amount to the target customer account
        $targetAccount = CustomerAccount::findOrFail($request->customer_account_id);
        $targetAccount->credit += $transaction->credit;
        $targetAccount->debit += $transaction->debit;
        $targetAccount->balance += $transaction->balance;
        $targetAccount->tr_date = now();
        $targetAccount->save();

        return response()->json(['success' => 'Transaction allocated successfully.']);
    }

    public function deallocate($id)
    {
        $transaction = CustomerAccount::findOrFail($id);
        
        if ($transaction->payment_pool === 'allocated' && $transaction->allocated_to_customer_account_id) {
            // Remove the amount from the target customer account
            $targetAccount = CustomerAccount::findOrFail($transaction->allocated_to_customer_account_id);
            $targetAccount->credit -= $transaction->credit;
            $targetAccount->debit -= $transaction->debit;
            $targetAccount->balance -= $transaction->balance;
            $targetAccount->tr_date = now();
            $targetAccount->save();
        }

        $transaction->payment_pool = 'unallocated';
        $transaction->allocated_to_customer_account_id = null;
        $transaction->allocated_at = null;
        $transaction->save();

        return response()->json(['success' => 'Transaction deallocated successfully.']);
    }

    public function destroy($id)
    {
        $transaction = CustomerAccount::findOrFail($id);
        
        // If allocated, first deallocate
        if ($transaction->payment_pool === 'allocated' && $transaction->allocated_to_customer_account_id) {
            $targetAccount = CustomerAccount::findOrFail($transaction->allocated_to_customer_account_id);
            $targetAccount->credit -= $transaction->credit;
            $targetAccount->debit -= $transaction->debit;
            $targetAccount->balance -= $transaction->balance;
            $targetAccount->tr_date = now();
            $targetAccount->save();
        }

        $transaction->delete();

        return response()->json(['success' => 'Transaction deleted successfully.']);
    }
}
