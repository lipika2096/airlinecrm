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
use App\Models\B2BPartner;
use App\Models\B2CCustomer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AccountController extends Controller
{

    public function index()
    {
        try{
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
        } catch (\Exception $e) {
            // Log error but don't prevent user creation
            \Log::error('Failed to process: ' . $e->getMessage());
            if (auth('admin')->check() && !auth('admin')->user()->hasRole('SuperAdmin')) {
                // Determine appropriate redirect route based on user type
                return redirect()->route('admin.accounts.index')->with('error', 'Failed to create account: ' . $e->getMessage());
            }
            elseif (auth('admin')->check() && !auth('admin')->user()->hasRole('SuperAdmin')) {
                return redirect()->route('customer.accounts.index')->with('error', 'Failed to create account: ' . $e->getMessage());

            } elseif (auth()->check()) {
                return redirect()->route('staff.accounts.index')->with('error', 'Failed to create account: ' . $e->getMessage());

            } 
        }
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

        // Generate sequential booking number
        try {
            $bookingNo = Booking::generateNextBookingNumber();
        } catch (\Exception $e) {
            // Fallback to timestamp-based if generation fails
            $bookingNo = 'BK' . str_pad(time() % 1000000, 6, '0', STR_PAD_LEFT);
        }

        return view('admin.booking-form', compact('bookingNo'));
    }

    public function editBooking($id)
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

        // Get the booking with related data
        $booking = Booking::with(['services', 'passengers', 'payments', 'documents'])->findOrFail($id);

        // Check if user has permission to edit this booking
        if ($userType !== 'superadmin') {
            $hasPermission = false;

            // Check if user created this booking
            if ($booking->created_by == $currentUserId && $booking->created_by_type == $userType) {
                $hasPermission = true;
            }

            // For staff, also check if booking was created by the superadmin who created them
            if ($userType === 'staff' && !$hasPermission) {
                $staffUser = \App\Models\User::find($currentUserId);
                $superadminCreatorId = $staffUser ? $staffUser->created_by : null;

                if ($superadminCreatorId && $booking->created_by == $superadminCreatorId && $booking->created_by_type == 'superadmin') {
                    $hasPermission = true;
                }
            }

            if (!$hasPermission) {
                return redirect()->back()->with('error', 'You do not have permission to edit this booking.');
            }
        }

        $bookingNo = $booking->booking_no;

        return view('admin.booking-form', compact('bookingNo', 'booking'));
    }

    public function updateBooking(Request $request, $id)
    {
        try {
            // Determine the current user type and ID for data scoping
            $currentUserId = null;
            $userType = 'superadmin'; // default

            if (auth('admin')->check()) {
                $currentUserId = auth('admin')->user()->id;
                $user = auth('admin')->user();

                $userType = auth('admin')->user()->hasRole('SuperAdmin') ? 'superadmin' : 'customer';
            } elseif (auth()->check()) {
                $currentUserId = auth()->user()->id;
                $user = auth()->user();
                $userType = 'staff';
            }

            // Get the booking
            $booking = Booking::findOrFail($id);

            // Check if user has permission to edit this booking
            if ($userType !== 'superadmin') {
                $hasPermission = false;

                // Check if user created this booking
                if ($booking->created_by == $currentUserId && $booking->created_by_type == $userType) {
                    $hasPermission = true;
                }

                // For staff, also check if booking was created by the superadmin who created them
                if ($userType === 'staff' && !$hasPermission) {
                    $staffUser = \App\Models\User::find($currentUserId);
                    $superadminCreatorId = $staffUser ? $staffUser->created_by : null;

                    if ($superadminCreatorId && $booking->created_by == $superadminCreatorId && $booking->created_by_type == 'superadmin') {
                        $hasPermission = true;
                    }
                }

                if (!$hasPermission) {
                    return redirect()->back()->with('error', 'You do not have permission to edit this booking.');
                }
            }

            // Validate the request (booking_no should not be changed during update)
            $validated = $request->validate([
                'booking_date' => 'required|date',
                'customer_id' => 'nullable|integer',
                'customer_type' => 'required|string|in:b2b,b2c',
                'customer_name' => 'nullable|string',
                'customer_email' => 'nullable|email',
                'customer_phone' => 'nullable|string',
                'booking_notes' => 'nullable|string',
                'selected_customer_id' => 'nullable|integer',
                'selected_customer_type' => 'nullable|string|in:b2b,b2c',
                // Invoice fields
                'invoice_number' => 'nullable|string',
                'invoice_date' => 'nullable|date',
                'invoice_due_date' => 'nullable|date',
                'invoice_tax_rate' => 'nullable|numeric',
                'invoice_notes' => 'nullable|string',
                'billing_address' => 'nullable|string',
                'shipping_address' => 'nullable|string',
                // B2C Customer Details
                'b2c_first_name' => 'nullable|string',
                'b2c_last_name' => 'nullable|string',
                'b2c_email' => 'nullable|email',
                'b2c_phone' => 'nullable|string',
                'b2c_street' => 'nullable|string',
                'b2c_house_no' => 'nullable|string',
                'b2c_city' => 'nullable|string',
                'b2c_pincode' => 'nullable|string',
                'b2c_state' => 'nullable|string',
                'b2c_country' => 'nullable|string',
                'b2c_language' => 'nullable|string',
                'b2c_responsible' => 'nullable|string',
                'b2c_remarks' => 'nullable|string',
                // B2B Customer Details
                'b2b_group' => 'nullable|string',
                'b2b_company_name' => 'nullable|string',
                'b2b_email' => 'nullable|email',
                'b2b_phone' => 'nullable|string',
                'b2b_street' => 'nullable|string',
                'b2b_house_no' => 'nullable|string',
                'b2b_city' => 'nullable|string',
                'b2b_pincode' => 'nullable|string',
                'b2b_state' => 'nullable|string',
                'b2b_country' => 'nullable|string',
                'b2b_language' => 'nullable|string',
                'b2b_responsible' => 'nullable|string',
                'b2b_remarks' => 'nullable|string',
            ]);

            // Use database transaction to ensure atomic booking update
            \DB::beginTransaction();
            try {
                // Populate required customer fields from B2B/B2C data if not provided
                $customerName = $validated['customer_name'] ?? null;
                $customerEmail = $validated['customer_email'] ?? null;
                $customerPhone = $validated['customer_phone'] ?? null;

                if ($validated['customer_type'] === 'b2b' && empty($customerName)) {
                    $customerName = $validated['b2b_company_name'] ?? null;
                    $customerEmail = $validated['b2b_email'] ?? null;
                    $customerPhone = $validated['b2b_phone'] ?? null;
                } elseif ($validated['customer_type'] === 'b2c' && empty($customerName)) {
                    $customerName = ($validated['b2c_first_name'] ?? '') . ' ' . ($validated['b2c_last_name'] ?? '');
                    $customerEmail = $validated['b2c_email'] ?? null;
                    $customerPhone = $validated['b2c_phone'] ?? null;
                }

                // Calculate totals from services
                $totalCost = 0;
                $totalSell = 0;

                if ($request->has('service_cost')) {
                    foreach ($request->service_cost as $cost) {
                        $totalCost += (float)($cost ?? 0);
                    }
                }

                if ($request->has('service_sell')) {
                    foreach ($request->service_sell as $sell) {
                        $totalSell += (float)($sell ?? 0);
                    }
                }

                $profit = $totalSell - $totalCost;

                // Update booking (booking_no cannot be changed)
                $booking->update([
                    'booking_date' => $validated['booking_date'],
                    'customer_id' => $validated['customer_id'] ?? null,
                    'customer_type' => $validated['customer_type'],
                    'customer_name' => $customerName ?: 'Unknown Customer',
                    'customer_email' => $customerEmail,
                    'customer_phone' => $customerPhone,
                    'booking_notes' => $validated['booking_notes'] ?? null,
                    'total_cost' => $totalCost,
                    'total_sell' => $totalSell,
                    'profit' => $profit,
                    // Invoice fields
                    'invoice_number' => $validated['invoice_number'] ?? null,
                    'invoice_date' => $validated['invoice_date'] ?? null,
                    'invoice_due_date' => $validated['invoice_due_date'] ?? null,
                    'invoice_tax_rate' => $validated['invoice_tax_rate'] ?? null,
                    'invoice_notes' => $validated['invoice_notes'] ?? null,
                    'billing_address' => $validated['billing_address'] ?? null,
                    'shipping_address' => $validated['shipping_address'] ?? null,
                    // B2C Customer Details
                    'b2c_first_name' => $validated['b2c_first_name'] ?? null,
                    'b2c_last_name' => $validated['b2c_last_name'] ?? null,
                    'b2c_email' => $validated['b2c_email'] ?? null,
                    'b2c_phone' => $validated['b2c_phone'] ?? null,
                    'b2c_street' => $validated['b2c_street'] ?? null,
                    'b2c_house_no' => $validated['b2c_house_no'] ?? null,
                    'b2c_city' => $validated['b2c_city'] ?? null,
                    'b2c_pincode' => $validated['b2c_pincode'] ?? null,
                    'b2c_state' => $validated['b2c_state'] ?? null,
                    'b2c_country' => $validated['b2c_country'] ?? null,
                    'b2c_language' => $validated['b2c_language'] ?? null,
                    'b2c_responsible' => $validated['b2c_responsible'] ?? null,
                    'b2c_remarks' => $validated['b2c_remarks'] ?? null,
                    // B2B Customer Details
                    'b2b_group' => $validated['b2b_group'] ?? null,
                    'b2b_company_name' => $validated['b2b_company_name'] ?? null,
                    'b2b_email' => $validated['b2b_email'] ?? null,
                    'b2b_phone' => $validated['b2b_phone'] ?? null,
                    'b2b_street' => $validated['b2b_street'] ?? null,
                    'b2b_house_no' => $validated['b2b_house_no'] ?? null,
                    'b2b_city' => $validated['b2b_city'] ?? null,
                    'b2b_pincode' => $validated['b2b_pincode'] ?? null,
                    'b2b_state' => $validated['b2b_state'] ?? null,
                    'b2b_country' => $validated['b2b_country'] ?? null,
                    'b2b_language' => $validated['b2b_language'] ?? null,
                    'b2b_responsible' => $validated['b2b_responsible'] ?? null,
                    'b2b_remarks' => $validated['b2b_remarks'] ?? null,
                    'updated_by' => $currentUserId,
                    'updated_by_type' => $userType,
                ]);

                // Delete existing related data
                $booking->services()->delete();
                $booking->passengers()->delete();
                $booking->payments()->delete();
                $booking->documents()->delete();

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
                if ($request->has('passenger_first_name')) {
                    foreach ($request->passenger_first_name as $index => $firstName) {
                        if (!empty($firstName)) {
                            BookingPassenger::create([
                                'booking_id' => $booking->id,
                                'title' => $request->passenger_title[$index] ?? null,
                                'gender' => $request->passenger_gender[$index] ?? null,
                                'first_name' => $firstName,
                                'last_name' => $request->passenger_last_name[$index] ?? null,
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
                                'remarks' => $request->payment_remarks[$index] ?? null,
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

                            // Only create document if we have a name or file
                            $documentName = $request->document_name[$index] ?? null;
                            if (!empty($documentName) || !empty($documentFile)) {
                                BookingDocument::create([
                                    'booking_id' => $booking->id,
                                    'document_type' => $type,
                                    'document_name' => $documentName ?? ($type . ' document'),
                                    'document_file' => $documentFile,
                                ]);
                            }
                        }
                    }
                }

                // Commit the transaction
                \DB::commit();

                // Determine appropriate redirect route based on user type
                if ($userType === 'superadmin') {
                    return redirect()->route('admin.booking.index')->with('success', 'Booking updated successfully');
                } elseif ($userType === 'customer') {
                    return redirect()->route('customer.booking.index')->with('success', 'Booking updated successfully');
                } elseif ($userType === 'staff') {
                    return redirect()->route('staff.booking.index')->with('success', 'Booking updated successfully');
                }

            } catch (\Exception $e) {
                // Rollback the transaction in case of error
                \DB::rollBack();

                // Log error with more context
                \Log::error('Failed to update booking: ' . $e->getMessage());
                \Log::error('Exception details: ' . $e->getTraceAsString());

                if (auth('admin')->check() && auth('admin')->user()->hasRole('SuperAdmin')) {
                    return redirect()->route('admin.booking.index')->with('error', 'Failed to update booking: ' . $e->getMessage());
                } elseif (auth('admin')->check() && !auth('admin')->user()->hasRole('SuperAdmin')) {
                    return redirect()->route('customer.booking.index')->with('error', 'Failed to update booking: ' . $e->getMessage());
                } elseif (auth()->check()) {
                    return redirect()->route('staff.booking.index')->with('error', 'Failed to update booking: ' . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update booking: ' . $e->getMessage());
        }
    }

    public function bookingIndex()
    {
        try{
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
                return view('admin.booking-index', compact('bookings', 'userType'));
            } elseif ($userType === 'staff') {
                // Staff can see:
                // 1. Bookings they created themselves
                // 2. Bookings created by the superadmin who created them
                $staffUser = \App\Models\User::find($currentUserId);
                $superadminCreatorId = $staffUser ? $staffUser->created_by : null;

                $bookings = $query->where(function($q) use ($currentUserId, $superadminCreatorId) {
                    // Bookings created by this staff member
                    $q->where(function($subQuery) use ($currentUserId) {
                        $subQuery->where('created_by', $currentUserId)
                                  ->where('created_by_type', 'staff');
                    });
                    // OR bookings created by the superadmin who created this staff member
                    if ($superadminCreatorId) {
                        $q->orWhere(function($subQuery) use ($superadminCreatorId) {
                            $subQuery->where('created_by', $superadminCreatorId)
                                      ->where('created_by_type', 'superadmin');
                        });
                    }
                })->orderBy('created_at', 'desc')->get();

                return view('admin.booking-index', compact('bookings', 'userType'));
            }
        } catch (\Exception $e) {
            // Log error but don't prevent user creation
            \Log::error('Failed to process: ' . $e->getMessage());
            if (auth('admin')->check() && !auth('admin')->user()->hasRole('SuperAdmin')) {
                // Determine appropriate redirect route based on user type
                return redirect()->route('admin.booking.index')->with('error', 'Failed to create account: ' . $e->getMessage());
            }
            elseif (auth('admin')->check() && !auth('admin')->user()->hasRole('SuperAdmin')) {
                return redirect()->route('customer.booking.index')->with('error', 'Failed to create account: ' . $e->getMessage());

            } elseif (auth()->check()) {
                return redirect()->route('staff.booking.index')->with('error', 'Failed to create account: ' . $e->getMessage());

            }
        }

    }

    public function storeBooking(Request $request)
    {
        try{
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
            $bookingId = $request->id ?? null;

            // Generate sequential booking number for new bookings
            if (is_null($bookingId)) {
                $bookingNo = Booking::generateNextBookingNumber();
            } else {
                // For existing bookings, validate the booking_no from request
                $validated = $request->validate([
                    'booking_no' => 'required|string|unique:bookings,booking_no,' . $bookingId . ',id',
                ]);
                $bookingNo = $validated['booking_no'];
            }

            $validated = $request->validate([
                'booking_date' => 'required|date',
                'customer_id' => 'nullable|integer',
                'customer_type' => 'required|string|in:b2b,b2c',
                'customer_name' => 'nullable|string',
                'customer_email' => 'nullable|email',
                'customer_phone' => 'nullable|string',
                'booking_notes' => 'nullable|string',
                'selected_customer_id' => 'nullable|integer',
                'selected_customer_type' => 'nullable|string|in:b2b,b2c',
                // Invoice fields
                'invoice_number' => 'nullable|string',
                'invoice_date' => 'nullable|date',
                'invoice_due_date' => 'nullable|date',
                'invoice_tax_rate' => 'nullable|numeric',
                'invoice_notes' => 'nullable|string',
                'billing_address' => 'nullable|string',
                'shipping_address' => 'nullable|string',
                // B2C Customer Details
                'b2c_first_name' => 'nullable|string',
                'b2c_last_name' => 'nullable|string',
                'b2c_email' => 'nullable|email',
                'b2c_phone' => 'nullable|string',
                'b2c_street' => 'nullable|string',
                'b2c_house_no' => 'nullable|string',
                'b2c_city' => 'nullable|string',
                'b2c_pincode' => 'nullable|string',
                'b2c_state' => 'nullable|string',
                'b2c_country' => 'nullable|string',
                'b2c_language' => 'nullable|string',
                'b2c_responsible' => 'nullable|string',
                'b2c_remarks' => 'nullable|string',
                // B2B Customer Details
                'b2b_group' => 'nullable|string',
                'b2b_company_name' => 'nullable|string',
                'b2b_email' => 'nullable|email',
                'b2b_phone' => 'nullable|string',
                'b2b_street' => 'nullable|string',
                'b2b_house_no' => 'nullable|string',
                'b2b_city' => 'nullable|string',
                'b2b_pincode' => 'nullable|string',
                'b2b_state' => 'nullable|string',
                'b2b_country' => 'nullable|string',
                'b2b_language' => 'nullable|string',
                'b2b_responsible' => 'nullable|string',
                'b2b_remarks' => 'nullable|string',
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
            
            // Handle B2B partner creation if customer type is B2B and data doesn't exist
            $b2bPartnerId = null;
            
            // Check if customer was selected from search
            if (!empty($validated['selected_customer_id']) && $validated['selected_customer_type'] === 'b2b') {
                $b2bPartnerId = $validated['selected_customer_id'];
            } elseif ($validated['customer_type'] === 'b2b' && !empty($validated['b2b_company_name'])) {
                // Check if B2B partner already exists by email or company name
                $existingPartner = B2BPartner::where('email', $validated['b2b_email'])
                    ->orWhere('partner_name', $validated['b2b_company_name'])
                    ->first();
                
                if (!$existingPartner) {
                    // Generate partner code
                    $partnerCode = 'B' . str_pad(B2BPartner::count() + 1, 3, '0', STR_PAD_LEFT);
                    
                    // Create new B2B partner
                    $b2bPartner = B2BPartner::create([
                        'partner_code' => $partnerCode,
                        'partner_name' => $validated['b2b_company_name'],
                        'partner_type' => $validated['b2b_group'] ?? 'Corporate',
                        'email' => $validated['b2b_email'],
                        'phone' => $validated['b2b_phone'],
                        'country' => $validated['b2b_country'],
                        'remarks' => $validated['b2b_remarks'],
                        'responsible_person' => $validated['b2b_responsible'],
                        'status' => 'Active',
                        'created_by' => $currentUserId,
                        'created_by_type' => $userType,
                    ]);
                    
                    $b2bPartnerId = $b2bPartner->id;
                } else {
                    $b2bPartnerId = $existingPartner->id;
                }
            }
            
            // Handle B2C customer creation if customer type is B2C and data doesn't exist
            $b2cCustomerId = null;
            
            // Check if customer was selected from search
            if (!empty($validated['selected_customer_id']) && $validated['selected_customer_type'] === 'b2c') {
                $b2cCustomerId = $validated['selected_customer_id'];
            } elseif ($validated['customer_type'] === 'b2c' && !empty($validated['b2c_first_name']) && !empty($validated['b2c_last_name'])) {
                // Check if B2C customer already exists by email
                $existingCustomer = B2CCustomer::where('email', $validated['b2c_email'])
                    ->where('first_name', $validated['b2c_first_name'])
                    ->where('last_name', $validated['b2c_last_name'])
                    ->first();
                
                if (!$existingCustomer) {
                    // Create new B2C customer
                    $b2cCustomer = B2CCustomer::create([
                        'customer_type' => 'individual',
                        'first_name' => $validated['b2c_first_name'],
                        'last_name' => $validated['b2c_last_name'],
                        'email' => $validated['b2c_email'],
                        'phone' => $validated['b2c_phone'],
                        'address' => $validated['b2c_street'] . ', ' . $validated['b2c_house_no'] . ', ' . $validated['b2c_city'] . ', ' . $validated['b2c_state'] . ', ' . $validated['b2c_pincode'],
                        'country' => $validated['b2c_country'],
                        'special_requests' => $validated['b2c_remarks'],
                        'status' => 'active',
                        'created_by' => $currentUserId,
                        'created_by_type' => $userType,
                    ]);
                    
                    $b2cCustomerId = $b2cCustomer->id;
                } else {
                    $b2cCustomerId = $existingCustomer->id;
                }
            }
            
            // Populate required customer fields from B2B/B2C data if not provided
            $customerName = $validated['customer_name'] ?? null;
            $customerEmail = $validated['customer_email'] ?? null;
            $customerPhone = $validated['customer_phone'] ?? null;

            if ($validated['customer_type'] === 'b2b' && empty($customerName)) {
                $customerName = $validated['b2b_company_name'] ?? null;
                $customerEmail = $validated['b2b_email'] ?? null;
                $customerPhone = $validated['b2b_phone'] ?? null;
            } elseif ($validated['customer_type'] === 'b2c' && empty($customerName)) {
                $customerName = ($validated['b2c_first_name'] ?? '') . ' ' . ($validated['b2c_last_name'] ?? '');
                $customerEmail = $validated['b2c_email'] ?? null;
                $customerPhone = $validated['b2c_phone'] ?? null;
            }

            // Use database transaction to ensure atomic booking creation
            \DB::beginTransaction();
                // Create booking
                $booking = Booking::create([
                'booking_no' => $bookingNo,
                'booking_date' => $validated['booking_date'],
                'customer_id' => $validated['customer_id'] ?? null,
                'customer_type' => $validated['customer_type'],
                'customer_name' => $customerName ?: 'Unknown Customer',
                'customer_email' => $customerEmail,
                'customer_phone' => $customerPhone,
                'booking_notes' => $validated['booking_notes'] ?? null,
                'total_cost' => $totalCost,
                'total_sell' => $totalSell,
                'profit' => $profit,
                'status' => 'pending',
                'created_by' => $currentUserId,
                'created_by_type' => $userType,
                'b2b_partner_id' => $b2bPartnerId,
                'b2c_customer_id' => $b2cCustomerId,
                // Invoice fields
                'invoice_number' => $validated['invoice_number'] ?? null,
                'invoice_date' => $validated['invoice_date'] ?? null,
                'invoice_due_date' => $validated['invoice_due_date'] ?? null,
                'invoice_tax_rate' => $validated['invoice_tax_rate'] ?? null,
                'invoice_notes' => $validated['invoice_notes'] ?? null,
                'billing_address' => $validated['billing_address'] ?? null,
                'shipping_address' => $validated['shipping_address'] ?? null,
                // B2C Customer Details
                'b2c_first_name' => $validated['b2c_first_name'] ?? null,
                'b2c_last_name' => $validated['b2c_last_name'] ?? null,
                'b2c_email' => $validated['b2c_email'] ?? null,
                'b2c_phone' => $validated['b2c_phone'] ?? null,
                'b2c_street' => $validated['b2c_street'] ?? null,
                'b2c_house_no' => $validated['b2c_house_no'] ?? null,
                'b2c_city' => $validated['b2c_city'] ?? null,
                'b2c_pincode' => $validated['b2c_pincode'] ?? null,
                'b2c_state' => $validated['b2c_state'] ?? null,
                'b2c_country' => $validated['b2c_country'] ?? null,
                'b2c_language' => $validated['b2c_language'] ?? null,
                'b2c_responsible' => $validated['b2c_responsible'] ?? null,
                'b2c_remarks' => $validated['b2c_remarks'] ?? null,
                // B2B Customer Details
                'b2b_group' => $validated['b2b_group'] ?? null,
                'b2b_company_name' => $validated['b2b_company_name'] ?? null,
                'b2b_email' => $validated['b2b_email'] ?? null,
                'b2b_phone' => $validated['b2b_phone'] ?? null,
                'b2b_street' => $validated['b2b_street'] ?? null,
                'b2b_house_no' => $validated['b2b_house_no'] ?? null,
                'b2b_city' => $validated['b2b_city'] ?? null,
                'b2b_pincode' => $validated['b2b_pincode'] ?? null,
                'b2b_state' => $validated['b2b_state'] ?? null,
                'b2b_country' => $validated['b2b_country'] ?? null,
                'b2b_language' => $validated['b2b_language'] ?? null,
                'b2b_responsible' => $validated['b2b_responsible'] ?? null,
                'b2b_remarks' => $validated['b2b_remarks'] ?? null,
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
            if ($request->has('passenger_first_name')) {
                foreach ($request->passenger_first_name as $index => $firstName) {
                    if (!empty($firstName)) {
                        BookingPassenger::create([
                            'booking_id' => $booking->id,
                            'title' => $request->passenger_title[$index] ?? null,
                            'gender' => $request->passenger_gender[$index] ?? null,
                            'first_name' => $firstName,
                            'last_name' => $request->passenger_last_name[$index] ?? null,
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
                            'remarks' => $request->payment_remarks[$index] ?? null,
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

                        // Only create document if we have a name or file
                        $documentName = $request->document_name[$index] ?? null;
                        if (!empty($documentName) || !empty($documentFile)) {
                            BookingDocument::create([
                                'booking_id' => $booking->id,
                                'document_type' => $type,
                                'document_name' => $documentName ?? ($type . ' document'),
                                'document_file' => $documentFile,
                            ]);
                        }
                    }
                }
            }

            // Commit the transaction
            \DB::commit();

            // Determine appropriate redirect route based on user type
            if ($userType === 'superadmin') {
                $redirectRoute = 'admin.booking.index';
                return redirect()->route('admin.booking.index')->with('success', 'Booking created successfully');
            } elseif ($userType === 'customer') {
                $redirectRoute = 'customer.booking.index';
                return redirect()->route('customer.booking.index')->with('success', 'Booking created successfully');
            } elseif ($userType === 'staff') {
                $redirectRoute = 'staff.booking.index';
                return redirect()->route('staff.booking.index')->with('success', 'Booking created successfully');
            }

            // Check if generate invoice button was clicked
            if ($request->has('generate_invoice')) {
                if ($userType === 'superadmin') {
                    $invoiceRoute = 'admin.booking.invoice';
                    return redirect()->route('admin.booking.invoice', $booking->id);
                } elseif ($userType === 'customer') {
                    $invoiceRoute = 'customer.booking.invoice';
                    return redirect()->route('customer.booking.invoice', $booking->id);
                } elseif ($userType === 'staff') {
                    $invoiceRoute = 'staff.booking.invoice';
                    return redirect()->route('staff.booking.invoice', $booking->id);
                }
            }
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            \DB::rollBack();

            // Log error with more context
            \Log::error('Failed to create booking: ' . $e->getMessage());
            \Log::error('Exception details: ' . $e->getTraceAsString());

            if (auth('admin')->check() && auth('admin')->user()->hasRole('SuperAdmin')) {
                return redirect()->route('admin.booking.index')->with('error', 'Failed to create booking: ' . $e->getMessage());
            } elseif (auth('admin')->check() && !auth('admin')->user()->hasRole('SuperAdmin')) {
                return redirect()->route('customer.booking.index')->with('error', 'Failed to create booking: ' . $e->getMessage());
            } elseif (auth()->check()) {
                return redirect()->route('staff.booking.index')->with('error', 'Failed to create booking: ' . $e->getMessage());
            }
        }
        }
        
    public function saveCustomer(Request $request)
    {
        try {
            // Determine the current user type and ID
            $currentUserId = null;
            $userType = 'superadmin';

            if (auth('admin')->check()) {
                $currentUserId = auth('admin')->user()->id;
                $userType = auth('admin')->user()->hasRole('SuperAdmin') ? 'superadmin' : 'customer';
            } elseif (auth()->check()) {
                $currentUserId = auth()->user()->id;
                $userType = 'staff';
            }

            $validated = $request->validate([
                'customer_type' => 'required|string|in:b2b,b2c',
                'booking_no' => 'required|string',
                'booking_date' => 'required|date',
                // B2C Customer Details
                'b2c_first_name' => 'nullable|string',
                'b2c_last_name' => 'nullable|string',
                'b2c_email' => 'nullable|email',
                'b2c_phone' => 'nullable|string',
                'b2c_street' => 'nullable|string',
                'b2c_house_no' => 'nullable|string',
                'b2c_city' => 'nullable|string',
                'b2c_pincode' => 'nullable|string',
                'b2c_state' => 'nullable|string',
                'b2c_country' => 'nullable|string',
                'b2c_language' => 'nullable|string',
                'b2c_responsible' => 'nullable|string',
                'b2c_remarks' => 'nullable|string',
                // B2B Customer Details
                'b2b_group' => 'nullable|string',
                'b2b_company_name' => 'nullable|string',
                'b2b_email' => 'nullable|email',
                'b2b_phone' => 'nullable|string',
                'b2b_street' => 'nullable|string',
                'b2b_house_no' => 'nullable|string',
                'b2b_city' => 'nullable|string',
                'b2b_pincode' => 'nullable|string',
                'b2b_state' => 'nullable|string',
                'b2b_country' => 'nullable|string',
                'b2b_language' => 'nullable|string',
                'b2b_responsible' => 'nullable|string',
                'b2b_remarks' => 'nullable|string',
            ]);

            \DB::beginTransaction();

            $customerId = null;
            $customerType = $validated['customer_type'];

            // Handle B2B partner creation/update
            if ($customerType === 'b2b' && !empty($validated['b2b_company_name'])) {
                // Check if B2B partner already exists by email or company name
                $existingPartner = B2BPartner::where('email', $validated['b2b_email'])
                    ->orWhere('partner_name', $validated['b2b_company_name'])
                    ->first();

                if (!$existingPartner) {
                    // Generate partner code
                    $partnerCode = 'B' . str_pad(B2BPartner::count() + 1, 3, '0', STR_PAD_LEFT);

                    // Create new B2B partner
                    $b2bPartner = B2BPartner::create([
                        'partner_code' => $partnerCode,
                        'partner_name' => $validated['b2b_company_name'],
                        'partner_type' => $validated['b2b_group'] ?? 'Corporate',
                        'email' => $validated['b2b_email'],
                        'phone' => $validated['b2b_phone'],
                        'country' => $validated['b2b_country'],
                        'remarks' => $validated['b2b_remarks'],
                        'responsible_person' => $validated['b2b_responsible'],
                        'status' => 'active',
                        'created_by' => $currentUserId,
                        'created_by_type' => $userType,
                    ]);

                    $customerId = $b2bPartner->id;
                } else {
                    $customerId = $existingPartner->id;
                }
            }
            // Handle B2C customer creation/update
            elseif ($customerType === 'b2c' && !empty($validated['b2c_first_name']) && !empty($validated['b2c_last_name'])) {
                // Check if B2C customer already exists by email
                $existingCustomer = B2CCustomer::where('email', $validated['b2c_email'])
                    ->where('first_name', $validated['b2c_first_name'])
                    ->where('last_name', $validated['b2c_last_name'])
                    ->first();

                if (!$existingCustomer) {
                    // Create new B2C customer
                    $b2cCustomer = B2CCustomer::create([
                        'customer_type' => 'individual',
                        'first_name' => $validated['b2c_first_name'],
                        'last_name' => $validated['b2c_last_name'],
                        'email' => $validated['b2c_email'],
                        'phone' => $validated['b2c_phone'],
                        'address' => $validated['b2c_street'] . ', ' . $validated['b2c_house_no'] . ', ' . $validated['b2c_city'] . ', ' . $validated['b2c_state'] . ', ' . $validated['b2c_pincode'],
                        'country' => $validated['b2c_country'],
                        'special_requests' => $validated['b2c_remarks'],
                        'status' => 'active',
                        'created_by' => $currentUserId,
                        'created_by_type' => $userType,
                    ]);

                    $customerId = $b2cCustomer->id;
                } else {
                    $customerId = $existingCustomer->id;
                }
            }

            // Check if booking already exists with this booking_no
            $existingBooking = Booking::where('booking_no', $validated['booking_no'])->first();

            if ($existingBooking) {
                // Update existing booking
                $customerName = $customerType === 'b2b' 
                    ? $validated['b2b_company_name'] 
                    : ($validated['b2c_first_name'] . ' ' . $validated['b2c_last_name']);
                $customerEmail = $customerType === 'b2b' ? $validated['b2b_email'] : $validated['b2c_email'];
                $customerPhone = $customerType === 'b2b' ? $validated['b2b_phone'] : $validated['b2c_phone'];

                $existingBooking->update([
                    'customer_type' => $customerType,
                    'customer_name' => $customerName,
                    'customer_email' => $customerEmail,
                    'customer_phone' => $customerPhone,
                    'b2b_partner_id' => $customerType === 'b2b' ? $customerId : null,
                    'b2c_customer_id' => $customerType === 'b2c' ? $customerId : null,
                    // B2C Customer Details
                    'b2c_first_name' => $validated['b2c_first_name'] ?? null,
                    'b2c_last_name' => $validated['b2c_last_name'] ?? null,
                    'b2c_email' => $validated['b2c_email'] ?? null,
                    'b2c_phone' => $validated['b2c_phone'] ?? null,
                    'b2c_street' => $validated['b2c_street'] ?? null,
                    'b2c_house_no' => $validated['b2c_house_no'] ?? null,
                    'b2c_city' => $validated['b2c_city'] ?? null,
                    'b2c_pincode' => $validated['b2c_pincode'] ?? null,
                    'b2c_state' => $validated['b2c_state'] ?? null,
                    'b2c_country' => $validated['b2c_country'] ?? null,
                    'b2c_language' => $validated['b2c_language'] ?? null,
                    'b2c_responsible' => $validated['b2c_responsible'] ?? null,
                    'b2c_remarks' => $validated['b2c_remarks'] ?? null,
                    // B2B Customer Details
                    'b2b_group' => $validated['b2b_group'] ?? null,
                    'b2b_company_name' => $validated['b2b_company_name'] ?? null,
                    'b2b_email' => $validated['b2b_email'] ?? null,
                    'b2b_phone' => $validated['b2b_phone'] ?? null,
                    'b2b_street' => $validated['b2b_street'] ?? null,
                    'b2b_house_no' => $validated['b2b_house_no'] ?? null,
                    'b2b_city' => $validated['b2b_city'] ?? null,
                    'b2b_pincode' => $validated['b2b_pincode'] ?? null,
                    'b2b_state' => $validated['b2b_state'] ?? null,
                    'b2b_country' => $validated['b2b_country'] ?? null,
                    'b2b_language' => $validated['b2b_language'] ?? null,
                    'b2b_responsible' => $validated['b2b_responsible'] ?? null,
                    'b2b_remarks' => $validated['b2b_remarks'] ?? null,
                    'updated_by' => $currentUserId,
                    'updated_by_type' => $userType,
                ]);

                \DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Customer details saved successfully',
                    'customer_id' => $customerId,
                    'booking_id' => $existingBooking->id
                ]);
            } else {
                // Create new booking
                $customerName = $customerType === 'b2b' 
                    ? $validated['b2b_company_name'] 
                    : ($validated['b2c_first_name'] . ' ' . $validated['b2c_last_name']);
                $customerEmail = $customerType === 'b2b' ? $validated['b2b_email'] : $validated['b2c_email'];
                $customerPhone = $customerType === 'b2b' ? $validated['b2b_phone'] : $validated['b2c_phone'];

                $booking = Booking::create([
                    'booking_no' => $validated['booking_no'],
                    'booking_date' => $validated['booking_date'],
                    'customer_type' => $customerType,
                    'customer_name' => $customerName ?: 'Unknown Customer',
                    'customer_email' => $customerEmail,
                    'customer_phone' => $customerPhone,
                    'total_cost' => 0,
                    'total_sell' => 0,
                    'profit' => 0,
                    'status' => 'pending',
                    'created_by' => $currentUserId,
                    'created_by_type' => $userType,
                    'b2b_partner_id' => $customerType === 'b2b' ? $customerId : null,
                    'b2c_customer_id' => $customerType === 'b2c' ? $customerId : null,
                    // B2C Customer Details
                    'b2c_first_name' => $validated['b2c_first_name'] ?? null,
                    'b2c_last_name' => $validated['b2c_last_name'] ?? null,
                    'b2c_email' => $validated['b2c_email'] ?? null,
                    'b2c_phone' => $validated['b2c_phone'] ?? null,
                    'b2c_street' => $validated['b2c_street'] ?? null,
                    'b2c_house_no' => $validated['b2c_house_no'] ?? null,
                    'b2c_city' => $validated['b2c_city'] ?? null,
                    'b2c_pincode' => $validated['b2c_pincode'] ?? null,
                    'b2c_state' => $validated['b2c_state'] ?? null,
                    'b2c_country' => $validated['b2c_country'] ?? null,
                    'b2c_language' => $validated['b2c_language'] ?? null,
                    'b2c_responsible' => $validated['b2c_responsible'] ?? null,
                    'b2c_remarks' => $validated['b2c_remarks'] ?? null,
                    // B2B Customer Details
                    'b2b_group' => $validated['b2b_group'] ?? null,
                    'b2b_company_name' => $validated['b2b_company_name'] ?? null,
                    'b2b_email' => $validated['b2b_email'] ?? null,
                    'b2b_phone' => $validated['b2b_phone'] ?? null,
                    'b2b_street' => $validated['b2b_street'] ?? null,
                    'b2b_house_no' => $validated['b2b_house_no'] ?? null,
                    'b2b_city' => $validated['b2b_city'] ?? null,
                    'b2b_pincode' => $validated['b2b_pincode'] ?? null,
                    'b2b_state' => $validated['b2b_state'] ?? null,
                    'b2b_country' => $validated['b2b_country'] ?? null,
                    'b2b_language' => $validated['b2b_language'] ?? null,
                    'b2b_responsible' => $validated['b2b_responsible'] ?? null,
                    'b2b_remarks' => $validated['b2b_remarks'] ?? null,
                ]);

                \DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Customer details and booking saved successfully',
                    'customer_id' => $customerId,
                    'booking_id' => $booking->id
                ]);
            }
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Failed to save customer: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save customer: ' . $e->getMessage()
            ], 500);
        }
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
        try{
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
        catch(\Exception $e){
            return redirect()->back()->with('error', 'Failed to generate invoice: ' . $e->getMessage());
        }
    }

    public function account()
    {
        try{
        $accounts = AgentAccount::where('acc_no' ,'!=', NULL)->with('agent')->get();
        $agents = Agent::where('deleted_at', 'null')->get();
        return view('admin.add-customer-account', compact('accounts','agents'));
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', 'Failed to load accounts: ' . $e->getMessage());
        }
    }

    public function viewAccount()
    {
        try{
        $accounts = AgentAccount::where('acc_no' ,'!=', NULL)->with('agent')->get();
        $agents = Agent::where('deleted_at', 'null')->get();
        return view('admin.view-customer-accounts', compact('accounts','agents'));
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', 'Failed to load accounts: ' . $e->getMessage());
        }
    }

    public function storeAccount(Request $request)
    {
        try{
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
        catch(\Exception $e){
            return redirect()->back()->with('error', 'Failed to create account: ' . $e->getMessage());
        }
    }

    public function updateAccount(Request $request, $id)
    {
        try{
        $account = AgentAccount::findorFail($id);
        $account->payment_pool = $request->payment_pool;
        $account->save();

        return redirect()->route('admin.accounts.view')->with('success', 'Account updated successfully.');
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', 'Failed to update account: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request)
    {
        try{
        $leave = AgentAccount::find($request->id);
        if ($leave) {
            $leave->status = $request->status;
            $leave->save();
            return response()->json(['success' => 'Status updated successfully.']);
        }
        return response()->json(['error' => 'Account not found.'], 404);
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Failed to update status: ' . $e->getMessage()], 500);
        }
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
        try{
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
        catch(\Exception $e){
            return redirect()->back()->with('error', 'Failed to create account: ' . $e->getMessage());
        }
    }

    public function updateCustomerAccount(Request $request, $id)
    {
        try{
        $account = CustomerAccount::findorFail($id);
        $account->payment_pool = $request->payment_pool;
        $account->save();

        return redirect()->route('admin.accounts.view')->with('success', 'Account updated successfully.');
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', 'Failed to update account: ' . $e->getMessage());
        }
    }

    public function updateCustomerStatus(Request $request)
    {
        try{
        $leave = CustomerAccount::find($request->id);
        if ($leave) {
            $leave->status = $request->status;
            $leave->save();
            return response()->json(['success' => 'Status updated successfully.']);
        }
        return response()->json(['error' => 'Account not found.'], 404);
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Failed to update status: ' . $e->getMessage()], 500);
        }
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
        try{
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
        catch(\Exception $e){
            return redirect()->back()->with('error', 'Failed to save expense: ' . $e->getMessage());
        }
    }

}
