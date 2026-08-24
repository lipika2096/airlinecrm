<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use App\Models\AgentAccount;
use App\Models\Agent;
use App\Models\CustomerAccount;
use App\Models\Admin;
use App\Models\AdminDetail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    public function account()
    {
        $accounts = AgentAccount::where('acc_no' ,'!=', NULL)->with('agent')->get();
        $agents = Agent::where('deleted_at', 'null')->get();
        return view('admin.add-customer-account', compact('accounts','agents'));
    }

    public function viewAccount()
    {
        $accounts = AgentAccount::where('acc_no' ,'!=', NULL)->with('agent')->get();
        $agents = Agent::where('deleted_at', 'null')->get();
        return view('admin.view-customer-accounts', compact('accounts','agents'));
    }

    public function storeAccount(Request $request)
    {
        // Add your logic for duties store
        $validator = Validator::make($request->all(),[
            'agent_id' => 'required',
            'acc_no' => 'required|string|max:255',
            'ifsc_code' => 'required|string|max:255',
            'misc_code' => 'required|string|max:255',
            'booking_id' => 'required|integer',
            'pnr' => 'required|string|max:255',
            'ticket_no' => 'required|string|max:255',
        ]);

        $account = new AgentAccount();
        $account->agent_id = $request->agent_id;
        $account->acc_no = $request->acc_no;
        $account->ifsc_code = $request->ifsc_code;
        $account->misc_code = $request->misc_code;
        $account->booking_id = $request->booking_id;
        $account->pnr = $request->pnr;
        $account->ticket_no = $request->ticket_no;
        $account->balance = $request->balance;
        $account->save();

        return redirect()->route('admin.accounts.view')->with('success', 'Account created successfully.');
    }

    public function updateAccount(Request $request, $id)
    {
        $account = AgentAccount::findorFail($id);
        $account->payment_pool = $request->payment_pool;
        $account->save();

        return redirect()->route('admin.accounts.view')->with('success', 'Account updated successfully.');
    }

    public function updateStatus(Request $request)
    {
        $leave = AgentAccount::find($request->id);
        if ($leave) {
            $leave->status = $request->status;
            $leave->save();
            return response()->json(['success' => 'Status updated successfully.']);
        }
        return response()->json(['error' => 'Account not found.'], 404);
    }

    public function indexCustomerAccount()
    {
        $customers = Admin::with('adminDetail')->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superAdmin');})->latest()->get();
        return view('admin.add-customer-account', compact('customers'));
    }

    public function viewCustomerAccount()
    {
        $accounts = CustomerAccount::where('acc_no' ,'!=', NULL)->with('admin')->get();
        //dd($accounts);
        $customers = Admin::with('adminDetail')->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superAdmin');})->latest()->get();
        return view('admin.view-customer-accounts', compact('accounts','customers'));
    }

    public function storeCustomerAccount(Request $request)
    {
        // Add your logic for duties store
        $validator = Validator::make($request->all(),[
            'customer_id' => 'required',
            'acc_no' => 'required|string|max:255',
            'ifsc_code' => 'required|string|max:255',
            'misc_code' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
        ]);

        $account = new CustomerAccount();
        $account->customer_id = $request->customer_id;
        $account->acc_no = $request->acc_no;
        $account->ifsc_code = $request->ifsc_code;
        $account->misc_code = $request->misc_code;
        $account->booking_id = 0;
        $account->bank_name = $request->bank_name;
        $account->balance = $request->balance;
        $account->credit = 0;
        $account->debit = 0;
        $account->tr_date = now();
        $account->save();

        return redirect()->route('admin.customer.accounts.view')->with('success', 'Account created successfully.');
    }

    public function updateCustomerAccount(Request $request, $id)
    {
        $account = CustomerAccount::findorFail($id);
        $account->payment_pool = $request->payment_pool;
        $account->save();

        return redirect()->route('admin.accounts.view')->with('success', 'Account updated successfully.');
    }

    public function updateCustomerStatus(Request $request)
    {
        $leave = CustomerAccount::find($request->id);
        if ($leave) {
            $leave->status = $request->status;
            $leave->save();
            return response()->json(['success' => 'Status updated successfully.']);
        }
        return response()->json(['error' => 'Account not found.'], 404);
    }

    public function viewCustomerInvoice($id)
    {
        $account = CustomerAccount::findorFail($id);
        $creditamount = CustomerAccount::where('customer_id', $account->customer_id)->sum('credit');
        $debitamount = CustomerAccount::where('customer_id', $account->customer_id)->sum('debit');
        $newbalance = CustomerAccount::where('customer_id', $account->customer_id)->latest()->first();
        $transactions = CustomerAccount::where('customer_id', $account->customer_id)
            ->orderBy('created_at', 'asc')->where('acc_no', null)
            ->paginate(10);
        return view('admin.customer-account-invoice-view', compact('account', 'debitamount', 'creditamount', 'newbalance', 'transactions'));
    }

    public function viewInvoice($id)
    {
        $account = AgentAccount::findorFail($id);
        $creditamount = AgentAccount::where('agent_id', $account->agent_id)->sum('credit');
        $debitamount = AgentAccount::where('agent_id', $account->agent_id)->sum('debit');
        $newbalance = AgentAccount::where('agent_id', $account->agent_id)->latest()->first();
        return view('admin.account-invoice-view', compact('account', 'debitamount', 'creditamount', 'newbalance'));
    }

    public function customerLedger(Request $request)
    {
        $currentYear = date('Y');
        $currentMonth = date('m');
        
        $query = CustomerAccount::with('admin');
        
        // Default filter by current year and month
        $query->whereYear('tr_date', $currentYear)
              ->whereMonth('tr_date', $currentMonth);
        
        // Apply filters if provided (override defaults)
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('tr_date', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('tr_date', '<=', $request->to_date);
        }
        if ($request->has('customer_id') && $request->customer_id) {
            $query->where('customer_id', $request->customer_id);
        }
        if ($request->has('year') && $request->year) {
            $query->whereYear('tr_date', $request->year);
        }
        if ($request->has('month') && $request->month) {
            $query->whereMonth('tr_date', $request->month);
        }
        
        $ledgerEntries = $query->orderBy('tr_date', 'asc')->get();
        
        // Group by customer_id and calculate running balance
        $groupedLedger = [];
        foreach ($ledgerEntries as $entry) {
            $customerId = $entry->customer_id;
            
            if (!isset($groupedLedger[$customerId])) {
                // Get initial balance for this customer
                $initialBalance = CustomerAccount::where('customer_id', $customerId)
                    ->where('credit', 0)->where('debit', 0)
                    ->orderBy('created_at', 'asc')
                    ->first();
                
                $groupedLedger[$customerId] = [
                    'customer_name' => $entry->admin ? $entry->admin->name : 'N/A',
                    'initial_balance' => $initialBalance ? $initialBalance->balance : 0,
                    'running_balance' => $initialBalance ? $initialBalance->balance : 0,
                    'first_entry_date' => $initialBalance->tr_date,
                    'entries' => []
                ];
            }
            
            // Calculate running balance for this entry
            $groupedLedger[$customerId]['running_balance'] += $entry->credit - $entry->debit;
            
            $groupedLedger[$customerId]['entries'][] = [
                'id' => $entry->id,
                'date' => $entry->tr_date,
                'description' => $entry->tr_type ?? 'Transaction',
                'debit' => $entry->debit,
                'credit' => $entry->credit,
                'balance' => $groupedLedger[$customerId]['running_balance'],
                'booking_id' => $entry->booking_id
            ];
        }
        
        // Flatten the grouped ledger for display
        $flatLedger = [];
        $sno = 1;
        foreach ($groupedLedger as $customerId => $customerData) {
            // Add opening balance entry
            $flatLedger[] = [
                'sno' => $sno++,
                'date' => $customerData['first_entry_date'], // Opening balance has no specific date
                'customer_name' => $customerData['customer_name'],
                'description' => 'Opening Balance',
                'debit' => 0,
                'credit' => $customerData['initial_balance'],
                'balance' => $customerData['initial_balance'],
                'is_opening' => true
            ];
            
            // Add transaction entries
            foreach ($customerData['entries'] as $entry) {
                // Only add entries where either credit or debit is not 0
                if ($entry['credit'] != 0 || $entry['debit'] != 0) {
                    $flatLedger[] = [
                        'sno' => $sno++,
                        'date' => $entry['date'],
                        'customer_name' => $customerData['customer_name'],
                        'description' => $entry['description'],
                        'debit' => $entry['debit'],
                        'credit' => $entry['credit'],
                        'balance' => $entry['balance'],
                        'booking_id' => $entry['booking_id'],
                        'is_opening' => false
                    ];
                }
            }
        }
        
        $customers = Admin::with('adminDetail')->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superAdmin');
        })->latest()->get();
        
        return view('admin.customer-ledger', compact('flatLedger', 'customers'));
    }

}
