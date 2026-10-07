<?php

namespace App\Http\Controllers;

use App\Models\B2CCustomer;
use App\Models\B2CPassenger;
use App\Models\B2CCustomerNote;
use App\Models\B2CCustomerDocument;
use App\Models\Booking;
use App\Models\Admin;
use App\Helpers\RouteHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class B2CCustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = B2CCustomer::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by customer type
        if ($request->filled('customer_type')) {
            $query->where('customer_type', $request->customer_type);
        }

        $customers = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.b2c-customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.b2c-customers.create');
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'customer_type' => 'required|in:individual,corporate',
            'salutation' => 'nullable|string|max:10',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:b2c_customers,email',
            'phone' => 'required|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'address' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,blocked',
            // Travel preferences
            'preferred_airline' => 'nullable|string|max:100',
            'preferred_class' => 'nullable|string|max:50',
            'meal_preference' => 'nullable|string|max:50',
            'seat_preference' => 'nullable|string|max:50',
            'special_requests' => 'nullable|string',
        ], [
            'phone.regex' => 'The phone number must contain only digits, spaces, and valid phone characters (+, -, (, )).',
        ]);

        if ($validator->fails()) {
            $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
            return redirect()->route($routePrefix . 'b2c-customers.create')
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

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

        $validated['created_by'] = $currentUserId;
        $validated['created_by_type'] = $userType;
        $validated['updated_by'] = $currentUserId;
        $validated['updated_by_type'] = $userType;

        $customer = B2CCustomer::create($validated);

        $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
        return redirect()->route($routePrefix . 'b2c-customers.index')
            ->with('success', 'B2C customer created successfully.');
    }

    public function show($id)
    {
        $customer = B2CCustomer::with(['passengers', 'notes.createdBy', 'documents', 'bookings'])->findOrFail($id);
        
        return view('admin.b2c-customers.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = B2CCustomer::findOrFail($id);
        return view('admin.b2c-customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = B2CCustomer::findOrFail($id);

        $validator = validator($request->all(), [
            'customer_type' => 'required|in:individual,corporate',
            'salutation' => 'nullable|string|max:10',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:b2c_customers,email,' . $id,
            'phone' => 'required|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'address' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,blocked',
            // Travel preferences
            'preferred_airline' => 'nullable|string|max:100',
            'preferred_class' => 'nullable|string|max:50',
            'meal_preference' => 'nullable|string|max:50',
            'seat_preference' => 'nullable|string|max:50',
            'special_requests' => 'nullable|string',
        ], [
            'phone.regex' => 'The phone number must contain only digits, spaces, and valid phone characters (+, -, (, )).',
        ]);

        if ($validator->fails()) {
            $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
            return redirect()->route($routePrefix . 'b2c-customers.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

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

        $validated['updated_by'] = $currentUserId;
        $validated['updated_by_type'] = $userType;

        $customer->update($validated);

        $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
        return redirect()->route($routePrefix . 'b2c-customers.show', $id)
            ->with('success', 'B2C customer updated successfully.');
    }

    public function destroy($id)
    {
        $customer = B2CCustomer::findOrFail($id);
        $customer->delete();

        $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
        return redirect()->route($routePrefix . 'b2c-customers.index')
            ->with('success', 'B2C customer deleted successfully.');
    }

    // Passenger Management
    public function addPassenger($customerId)
    {
        $customer = B2CCustomer::findOrFail($customerId);
        return view('admin.b2c-customers.passengers.create', compact('customer'));
    }

    public function storePassenger(Request $request, $customerId)
    {
        $customer = B2CCustomer::findOrFail($customerId);

        $validator = validator($request->all(), [
            'passenger_type' => 'required|in:adult,child,infant',
            'title' => 'nullable|string|max:10',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before_or_equal:today',
            'passport_number' => 'nullable|string|max:50|regex:/^[A-Za-z0-9]+$/',
            'nationality' => 'nullable|string|max:100|regex:/^[A-Za-z\s\-]+$/',
            'frequent_flyer_number' => 'nullable|string|max:50',
        ], [
            'date_of_birth.before_or_equal' => 'The date of birth cannot be in the future.',
            'passport_number.regex' => 'The passport number must contain only letters and numbers.',
            'nationality.regex' => 'The nationality must contain only letters, spaces, and hyphens.',
        ]);

        if ($validator->fails()) {
            $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
            return redirect()->route($routePrefix . 'b2c-customers.passengers.create', $customerId)
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

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

        $validated['b2c_customer_id'] = $customerId;
        $validated['created_by'] = $currentUserId;
        $validated['created_by_type'] = $userType;
        $validated['updated_by'] = $currentUserId;
        $validated['updated_by_type'] = $userType;

        B2CPassenger::create($validated);

        $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
        return redirect()->route($routePrefix . 'b2c-customers.show', $customerId)
            ->with('success', 'Passenger added successfully.');
    }

    public function editPassenger($customerId, $passengerId)
    {
        $customer = B2CCustomer::findOrFail($customerId);
        $passenger = B2CPassenger::findOrFail($passengerId);
        return view('admin.b2c-customers.passengers.edit', compact('customer', 'passenger'));
    }

    public function updatePassenger(Request $request, $customerId, $passengerId)
    {
        $passenger = B2CPassenger::findOrFail($passengerId);

        $validator = validator($request->all(), [
            'passenger_type' => 'required|in:adult,child,infant',
            'title' => 'nullable|string|max:10',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before_or_equal:today',
            'passport_number' => 'nullable|string|max:50|regex:/^[A-Za-z0-9]+$/',
            'nationality' => 'nullable|string|max:100|regex:/^[A-Za-z\s\-]+$/',
            'frequent_flyer_number' => 'nullable|string|max:50',
        ], [
            'date_of_birth.before_or_equal' => 'The date of birth cannot be in the future.',
            'passport_number.regex' => 'The passport number must contain only letters and numbers.',
            'nationality.regex' => 'The nationality must contain only letters, spaces, and hyphens.',
        ]);

        if ($validator->fails()) {
            $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
            return redirect()->route($routePrefix . 'b2c-customers.passengers.edit', [$customerId, $passengerId])
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

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

        $validated['updated_by'] = $currentUserId;
        $validated['updated_by_type'] = $userType;

        $passenger->update($validated);

        $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
        return redirect()->route($routePrefix . 'b2c-customers.show', $customerId)
            ->with('success', 'Passenger updated successfully.');
    }

    public function deletePassenger($customerId, $passengerId)
    {
        $passenger = B2CPassenger::findOrFail($passengerId);
        $passenger->delete();

        $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
        return redirect()->route($routePrefix . 'b2c-customers.show', $customerId)
            ->with('success', 'Passenger deleted successfully.');
    }

    // Notes Management
    public function storeNote(Request $request, $customerId)
    {
        $validated = $request->validate([
            'note' => 'required|string',
        ]);

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

        $validated['b2c_customer_id'] = $customerId;
        $validated['created_by'] = $currentUserId;
        $validated['created_by_type'] = $userType;

        B2CCustomerNote::create($validated);

        $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
        return redirect()->route($routePrefix . 'b2c-customers.show', $customerId)
            ->with('success', 'Note added successfully.');
    }

    public function deleteNote($customerId, $noteId)
    {
        $note = B2CCustomerNote::findOrFail($noteId);
        $note->delete();

        $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
        return redirect()->route($routePrefix . 'b2c-customers.show', $customerId)
            ->with('success', 'Note deleted successfully.');
    }

    // Documents Management
    public function storeDocument(Request $request, $customerId)
    {
        $validated = $request->validate([
            'document_type' => 'required|string|max:100',
            'file' => 'required|file|max:10240', // Max 10MB
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('b2c-customer-documents', $fileName, 'public');

            $validated['file_path'] = $filePath;
            $validated['file_name'] = $fileName;
        }

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

        $validated['b2c_customer_id'] = $customerId;
        $validated['created_by'] = $currentUserId;
        $validated['created_by_type'] = $userType;

        B2CCustomerDocument::create($validated);

        $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
        return redirect()->route($routePrefix . 'b2c-customers.show', $customerId)
            ->with('success', 'Document uploaded successfully.');
    }

    public function deleteDocument($customerId, $documentId)
    {
        $document = B2CCustomerDocument::findOrFail($documentId);
        
        // Delete file from storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        $document->delete();

        $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
        return redirect()->route($routePrefix . 'b2c-customers.show', $customerId)
            ->with('success', 'Document deleted successfully.');
    }

    // Status toggle
    public function toggleStatus($id)
    {
        $customer = B2CCustomer::findOrFail($id);
        $newStatus = $customer->status === 'active' ? 'inactive' : 'active';
        $customer->update(['status' => $newStatus]);

        return redirect()->back()
            ->with('success', "Customer status changed to {$newStatus}.");
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            return response()->json([]);
        }

        $customers = B2CCustomer::where(function ($q) use ($query) {
            $q->where('first_name', 'like', "%{$query}%")
              ->orWhere('last_name', 'like', "%{$query}%")
              ->orWhere('email', 'like', "%{$query}%")
              ->orWhere('phone', 'like', "%{$query}%");
        })
        ->get()
        ->map(function ($customer) {
            return [
                'id' => $customer->id,
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'address' => $customer->address,
                'country' => $customer->country,
                'special_requests' => $customer->special_requests,
            ];
        });

        return response()->json($customers);
    }
}
