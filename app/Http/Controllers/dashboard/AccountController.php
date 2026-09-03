<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use App\Models\AgentAccount;
use App\Models\Agent;
use App\Models\CustomerAccount;
use App\Models\Admin;
use App\Models\AdminDetail;
use App\Models\Booking;
use App\Models\BookingService;
use App\Models\BookingPassenger;
use App\Models\BookingPayment;
use App\Models\BookingDocument;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AccountController extends Controller
{

    public function index()
    {
        // Determine the current user type and ID for data scoping
        $currentUserId = null;
        $userType = 'superadmin'; // default
        
        if (auth('admin')->check()) {
            $currentUserId = auth('admin')->user()->id;
            $userType = auth('admin')->user()->hasRole('SuperAdmin') ? 'superadmin' : 'customer';
        } elseif (auth()->check()) {
            $currentUserId = auth()->user()->id;
            $userType = 'staff';
        }
        
        // Calculate metrics (placeholder values - replace with actual calculations)
        $todaySales = 15240;
        $todayProfit = 4890;
        $outstanding = 47650;
        $cashInHand = 2350;
        $bankBalance = 28750;
        $upcomingTrips = 12;
        
        // Chart data (placeholder - replace with actual data from database)
        $salesLabels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
        $salesData = [8500, 12000, 9800, 15240];
        $profitLabels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
        $profitData = [2800, 4200, 3500, 4890];
        
        // Recent bookings (placeholder - replace with actual data)
        $recentBookings = collect([
            (object) ['booking_id' => 'BK000125', 'customer_name' => 'John Smith', 'amount' => 1250],
            (object) ['booking_id' => 'BK000124', 'customer_name' => 'ADC Travels', 'amount' => 2450],
            (object) ['booking_id' => 'BK000123', 'customer_name' => 'Maria Garcia', 'amount' => 780],
        ]);
        
        // Recent payments (placeholder - replace with actual data)
        $recentPayments = collect([
            (object) ['payment_id' => 'PA1000001', 'payer_name' => 'John Smith', 'amount' => 1200],
            (object) ['payment_id' => 'PAYCARTOO', 'payer_name' => 'ABC Travels', 'amount' => 2400],
            (object) ['payment_id' => 'FA1000019', 'payer_name' => 'Global Corp', 'amount' => 1000],
        ]);
        
        return view('admin.account-index', compact(
            'todaySales',
            'todayProfit',
            'outstanding',
            'cashInHand',
            'bankBalance',
            'upcomingTrips',
            'salesLabels',
            'salesData',
            'profitLabels',
            'profitData',
            'recentBookings',
            'recentPayments'
        ));
    }

    public function createBooking()
    {
        // Determine the current user type and ID for data scoping
        $currentUserId = null;
        $userType = 'superadmin'; // default
        
        if (auth('admin')->check()) {
            $currentUserId = auth('admin')->user()->id;
            $userType = auth('admin')->user()->hasRole('SuperAdmin') ? 'superadmin' : 'customer';
        } elseif (auth()->check()) {
            $currentUserId = auth()->user()->id;
            $userType = 'staff';
        }
        
        // Generate booking number
        $bookingNo = 'BK' . str_pad(time() % 1000000, 6, '0', STR_PAD_LEFT);
        
        return view('admin.booking-form', compact('bookingNo'));
    }

    public function bookingIndex()
    {
        // Determine the current user type and ID for data scoping
        $currentUserId = null;
        $userType = 'superadmin'; // default
        
        if (auth('admin')->check()) {
            $currentUserId = auth('admin')->user()->id;
            $userType = auth('admin')->user()->hasRole('SuperAdmin') ? 'superadmin' : 'customer';
        } elseif (auth()->check()) {
            $currentUserId = auth()->user()->id;
            $userType = 'staff';
        }
        
        // Get bookings based on user type
        $query = Booking::with(['services', 'passengers', 'payments']);
        
        if ($userType === 'superadmin') {
            // SuperAdmin can see all bookings
            $bookings = $query->orderBy('created_at', 'desc')->get();
            return view('admin.booking-index', compact('bookings', 'userType'));
        } elseif ($userType === 'customer') {
            // Customers can only see their own bookings
            $bookings = $query->where('customer_id', $currentUserId)->orderBy('created_at', 'desc')->get();
            return view('customer.booking-index', compact('bookings', 'userType'));
        } elseif ($userType === 'staff') {
            // Staff can see all bookings (or limit based on your requirements)
            $bookings = $query->orderBy('created_at', 'desc')->get();
            return view('staff.booking-index', compact('bookings', 'userType'));
        }
        
        
    }

    public function storeBooking(Request $request)
    {
        // Determine the current user type and ID for data scoping
        $currentUserId = null;
        $userType = 'superadmin'; // default
        
        if (auth('admin')->check()) {
            $currentUserId = auth('admin')->user()->id;
            $userType = auth('admin')->user()->hasRole('SuperAdmin') ? 'superadmin' : 'customer';
        } elseif (auth()->check()) {
            $currentUserId = auth()->user()->id;
            $userType = 'staff';
        }
        
        // Validate the request
        $validated = $request->validate([
            'booking_no' => 'required|string|unique:bookings,booking_no',
            'booking_date' => 'required|date',
            'customer_id' => 'nullable|exists:users,id',
            'customer_type' => 'required|string|in:individual,corporate,agent',
            'customer_name' => 'required|string',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string',
            'booking_notes' => 'nullable|string',
        ]);
        
        // Calculate totals
        $totalCost = 0;
        $totalSell = 0;
        
        if ($request->has('service_cost') && $request->has('service_sell')) {
            foreach ($request->service_cost as $cost) {
                $totalCost += floatval($cost);
            }
            foreach ($request->service_sell as $sell) {
                $totalSell += floatval($sell);
            }
        }
        
        $profit = $totalSell - $totalCost;
        
        // Create booking
        $booking = Booking::create([
            'booking_no' => $validated['booking_no'],
            'booking_date' => $validated['booking_date'],
            'customer_id' => $validated['customer_id'],
            'customer_type' => $validated['customer_type'],
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'booking_notes' => $validated['booking_notes'],
            'total_cost' => $totalCost,
            'total_sell' => $totalSell,
            'profit' => $profit,
            'status' => 'pending',
            'created_by' => $currentUserId,
        ]);
        
        // Save services
        if ($request->has('service_type')) {
            foreach ($request->service_type as $index => $type) {
                if (!empty($type)) {
                    BookingService::create([
                        'booking_id' => $booking->id,
                        'service_type' => $type,
                        'description' => $request->service_description[$index] ?? null,
                        'supplier' => $request->service_supplier[$index] ?? null,
                        'cost' => $request->service_cost[$index] ?? 0,
                        'sell' => $request->service_sell[$index] ?? 0,
                    ]);
                }
            }
        }
        
        // Save passengers
        if ($request->has('passenger_name')) {
            foreach ($request->passenger_name as $index => $name) {
                if (!empty($name)) {
                    BookingPassenger::create([
                        'booking_id' => $booking->id,
                        'name' => $name,
                        'passport_no' => $request->passport_no[$index] ?? null,
                        'nationality' => $request->nationality[$index] ?? null,
                        'dob' => $request->dob[$index] ?? null,
                    ]);
                }
            }
        }
        
        // Save payments
        if ($request->has('payment_amount')) {
            foreach ($request->payment_amount as $index => $amount) {
                if (!empty($amount)) {
                    BookingPayment::create([
                        'booking_id' => $booking->id,
                        'payment_date' => $request->payment_date[$index] ?? null,
                        'payment_method' => $request->payment_method[$index] ?? 'cash',
                        'amount' => $amount,
                        'status' => $request->payment_status[$index] ?? 'pending',
                    ]);
                }
            }
        }
        
        // Save documents
        if ($request->has('document_type')) {
            foreach ($request->document_type as $index => $type) {
                if (!empty($type)) {
                    $documentFile = null;
                    if ($request->hasFile('document_file.' . $index)) {
                        $file = $request->file('document_file.' . $index);
                        $fileName = time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('uploads/booking-documents'), $fileName);
                        $documentFile = 'uploads/booking-documents/' . $fileName;
                    }
                    
                    BookingDocument::create([
                        'booking_id' => $booking->id,
                        'document_type' => $type,
                        'document_name' => $request->document_name[$index] ?? null,
                        'document_file' => $documentFile,
                    ]);
                }
            }
        }
        
        // Determine appropriate redirect route based on user type
        $redirectRoute = 'admin.booking.index';
        if ($userType === 'customer') {
            $redirectRoute = 'customer.booking.index';
        } elseif ($userType === 'staff') {
            $redirectRoute = 'staff.booking.index';
        }
        
        // Check if generate invoice button was clicked
        if ($request->has('generate_invoice')) {
            $invoiceRoute = 'admin.booking.invoice';
            if ($userType === 'customer') {
                $invoiceRoute = 'customer.booking.invoice';
            } elseif ($userType === 'staff') {
                $invoiceRoute = 'staff.booking.invoice';
            }
            return redirect()->route($invoiceRoute, $booking->id);
        }
        
        return redirect()->route($redirectRoute)->with('success', 'Booking created successfully');
    }

    public function dropBookingTables()
    {
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('booking_services');
        Schema::dropIfExists('booking_passengers');
        Schema::dropIfExists('booking_payments');
        Schema::dropIfExists('booking_documents');
        
        return redirect()->back()->with('success', 'Booking tables dropped successfully');
    }

    public function generateInvoice($id)
    {
        $booking = Booking::with(['services', 'passengers', 'payments', 'documents', 'customer'])->findOrFail($id);
        
        // Generate invoice number
        $invoiceNo = 'INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
        
        // Calculate VAT (assuming 20% VAT rate)
        $vatRate = 20;
        $subtotal = $booking->total_sell;
        $vatAmount = ($subtotal * $vatRate) / 100;
        $total = $subtotal + $vatAmount;
        
        return view('admin.booking-invoice', compact(
            'booking',
            'invoiceNo',
            'vatRate',
            'subtotal',
            'vatAmount',
            'total'
        ));
    }

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

    public function generalLedger(Request $request)
    {
        $currentYear = date('Y');
        $currentMonth = date('m');

        // Get all customer account transactions
        $query = CustomerAccount::with('admin');

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
        if ($request->has('customer_id') && $request->customer_id) {
            $query->where('customer_id', $request->customer_id);
        }
        if ($request->has('year') && $request->year) {
            $query->whereYear('tr_date', $request->year);
        }
        if ($request->has('month') && $request->month) {
            $query->whereMonth('tr_date', $request->month);
        }

        $transactions = $query->orderBy('tr_date', 'asc')->get();

        // Calculate running balance for general ledger
        $runningBalance = 0;
        $ledgerEntries = [];
        
        foreach ($transactions as $transaction) {
            $runningBalance += $transaction->credit - $transaction->debit;
            
            $ledgerEntries[] = [
                'id' => $transaction->id,
                'date' => $transaction->tr_date,
                'account' => $transaction->admin ? $transaction->admin->name : 'N/A',
                'ref' => $transaction->tr_type ?? '-',
                'debit' => $transaction->debit,
                'credit' => $transaction->credit,
                'balance' => $runningBalance,
                'bank_name' => $transaction->bank_name ?? '-'
            ];
        }

        // Calculate totals
        $totalDebit = collect($ledgerEntries)->sum('debit');
        $totalCredit = collect($ledgerEntries)->sum('credit');

        $customers = Admin::with('adminDetail')->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superAdmin');
        })->latest()->get();

        return view('admin.general-ledger', compact('ledgerEntries', 'totalDebit', 'totalCredit', 'customers'));
    }

    public function supplierLedger(Request $request)
    {
        $currentYear = date('Y');
        $currentMonth = date('m');

        // Get transactions where allocated_to is 'supplier'
        $query = CustomerAccount::where('allocated_to', 'supplier');

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
        if ($request->has('supplier_name') && $request->supplier_name) {
            $query->where('supplier_name', 'like', '%' . $request->supplier_name . '%');
        }

        $transactions = $query->orderBy('tr_date', 'asc')->get();

        // Group by supplier and calculate totals
        $groupedLedger = [];
        foreach ($transactions as $transaction) {
            $supplierName = $transaction->supplier_name ?? 'Unknown Supplier';
            
            if (!isset($groupedLedger[$supplierName])) {
                $groupedLedger[$supplierName] = [
                    'total_bills' => 0,
                    'total_payments' => 0,
                    'balance_due' => 0,
                    'transactions' => []
                ];
            }
            
            // Add to appropriate total based on transaction type
            if ($transaction->debit > 0) {
                $groupedLedger[$supplierName]['total_bills'] += $transaction->debit;
            } else {
                $groupedLedger[$supplierName]['total_payments'] += $transaction->credit;
            }
            
            $groupedLedger[$supplierName]['balance_due'] = 
                $groupedLedger[$supplierName]['total_bills'] - $groupedLedger[$supplierName]['total_payments'];
            
            $groupedLedger[$supplierName]['transactions'][] = [
                'id' => $transaction->id,
                'date' => $transaction->tr_date,
                'type' => $transaction->debit > 0 ? 'Bill' : 'Payment',
                'reference' => $transaction->invoice_number ?? '-',
                'debit' => $transaction->debit,
                'credit' => $transaction->credit,
                'balance' => $groupedLedger[$supplierName]['balance_due']
            ];
        }

        return view('admin.supplier-ledger', compact('groupedLedger'));
    }

    public function expenseEntry(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'expense_date' => 'required|date',
                'category' => 'required|string',
                'paid_from' => 'required|string',
                'amount' => 'required|numeric|min:0',
                'vat_rate' => 'nullable|numeric|min:0|max:100',
                'vat_amount' => 'nullable|numeric|min:0',
                'description' => 'nullable|string',
                'receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
            ]);

            // Calculate VAT amount if not provided
            if (!isset($validated['vat_amount']) && isset($validated['vat_rate'])) {
                $validated['vat_amount'] = ($validated['amount'] * $validated['vat_rate']) / 100;
            }

            // Handle file upload
            $receiptPath = null;
            if ($request->hasFile('receipt')) {
                $receiptPath = $request->file('receipt')->store('expense_receipts', 'public');
            }

            // Create expense record
            CustomerAccount::create([
                'tr_date' => $validated['expense_date'],
                'bank_name' => $validated['paid_from'],
                'tr_type' => $validated['category'] . ' - ' . ($validated['description'] ?? ''),
                'debit' => $validated['amount'],
                'credit' => 0,
                'balance' => -$validated['amount'],
                'payment_pool' => 'unallocated',
                'allocated_to' => 'expense',
                'expense_category' => $validated['category'],
                'allocated_amount' => $validated['amount'],
                'remarks' => $validated['description'] ?? '',
                'status' => 1
            ]);

            return redirect()->route('admin.expense-entry')->with('success', 'Expense saved successfully.');
        }

        return view('admin.expense-entry');
    }

}
