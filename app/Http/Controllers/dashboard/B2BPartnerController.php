<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\B2BPartner;
use App\Models\B2BPartnerContact;
use App\Models\B2BPartnerAirline;
use App\Models\B2BPartnerProduct;
use App\Models\B2BPartnerDocument;
use App\Models\B2BPartnerNote;
use App\Models\B2BPartnerActivity;
use App\Models\Airline;
use App\Models\Admin;
use App\Models\Booking;
use App\Models\Product;
use App\Helpers\RouteHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class B2BPartnerController extends Controller
{
    public function index(Request $request)
    {
        $currentUserId = auth('admin')->check() ? auth('admin')->user()->id : (auth()->check() ? auth()->user()->id : null);
        $userType = RouteHelper::isSuperAdmin() ? 'superadmin' : (RouteHelper::isCustomer() ? 'customer' : 'staff');

        $query = B2BPartner::with('contacts', 'airlines', 'products')->whereNull('deleted_at');

        if ($userType !== 'superadmin') {
            $query->where('created_by', $currentUserId);
        }

        if ($request->has('search') && !empty($request->input('search'))) {
            $searchValue = $request->input('search');
            $query->where(function ($q) use ($searchValue) {
                $q->where('partner_name', 'like', '%' . $searchValue . '%')
                  ->orWhere('partner_code', 'like', '%' . $searchValue . '%')
                  ->orWhere('iata_tids_no', 'like', '%' . $searchValue . '%')
                  ->orWhere('email', 'like', '%' . $searchValue . '%')
                  ->orWhere('country', 'like', '%' . $searchValue . '%');
            });
        }

        if ($request->has('partner_type') && !empty($request->input('partner_type'))) {
            $query->where('partner_type', $request->input('partner_type'));
        }

        if ($request->has('status') && !empty($request->input('status'))) {
            $query->where('status', $request->input('status'));
        }

        $partners = $query->latest()->paginate(10);

        return view('admin.b2b-partners.index', compact('partners'));
    }

    public function create()
    {
        $airlines = Airline::all();
        $products = Product::where('status', 'Active')->get();
        return view('admin.b2b-partners.create', compact('airlines', 'products'));
    }

    public function store(Request $request)
    {
        \DB::beginTransaction();
        try {
            $currentUserId = auth('admin')->check() ? auth('admin')->user()->id : (auth()->check() ? auth()->user()->id : null);
            $userType = RouteHelper::isSuperAdmin() ? 'superadmin' : (RouteHelper::isCustomer() ? 'customer' : 'staff');

            $validated = $request->validate([
                'partner_name' => 'required|string|max:255',
                'partner_type' => 'required|in:Travel Agent,Tour Operator,Corporate,TMC',
                'iata_tids_no' => 'nullable|string|max:255',
                'country' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:255',
                'website' => 'nullable|url|max:255',
                'remarks' => 'nullable|string',
                'status' => 'required|in:Active,Pending,Inactive',
                'responsible_person' => 'nullable|string|max:255',
                'region' => 'nullable|string|max:255',
                'airline_responsibility' => 'nullable|string|max:255',
                'product_responsibility' => 'nullable|string|max:255',
                'tsa_status' => 'nullable|in:Activated,Deactivated',
                'custom_product' => 'nullable|string|max:255|required_if:products,other',
                'contacts' => 'nullable|array',
                'contacts.*.name' => 'nullable|string|max:255',
                'contacts.*.designation' => 'required_with:contacts.*.name|string|max:255',
                'contacts.*.phone' => 'required_with:contacts.*.name|string|max:255',
                'contacts.*.email' => 'required_with:contacts.*.name|email|max:255',
                'contacts.*.role' => 'required_with:contacts.*.name|in:Primary,Secondary',
            ]);

            // Get the max partner code and increment
            $lastPartner = B2BPartner::withTrashed()->orderBy('id', 'desc')->first();
            $nextId = $lastPartner ? $lastPartner->id + 1 : 1;
            $partnerCode = 'B' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

            $partner = B2BPartner::create([
                'partner_code' => $partnerCode,
                'partner_name' => $validated['partner_name'],
                'partner_type' => $validated['partner_type'],
                'iata_tids_no' => $validated['iata_tids_no'] ?? null,
                'country' => $validated['country'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'website' => $validated['website'] ?? null,
                'remarks' => $validated['remarks'] ?? null,
                'status' => $validated['status'],
                'responsible_person' => $validated['responsible_person'] ?? null,
                'region' => $validated['region'] ?? null,
                'airline_responsibility' => $validated['airline_responsibility'] ?? null,
                'product_responsibility' => $validated['product_responsibility'] ?? null,
                'tsa_status' => $validated['tsa_status'] ?? null,
                'created_by' => $currentUserId,
                'created_by_type' => $userType,
                'updated_by' => $currentUserId,
            ]);

            // Log activity (try-catch to prevent blocking main operation)
            try {
                B2BPartnerActivity::create([
                    'b2b_partner_id' => $partner->id,
                    'activity_type' => 'created',
                    'description' => 'B2B Partner ' . $partner->partner_name . ' was created',
                    'new_values' => $partner->toArray(),
                    'performed_by' => $currentUserId,
                    'performed_by_type' => $userType,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            } catch (\Exception $e) {
                Log::error('Error logging B2B partner activity: ' . $e->getMessage());
            }

            if ($request->has('contacts') && is_array($request->contacts)) {
                foreach ($request->contacts as $contact) {
                    if (!empty($contact['name'])) {
                        try {
                            B2BPartnerContact::create([
                                'b2b_partner_id' => $partner->id,
                                'name' => $contact['name'],
                                'designation' => $contact['designation'] ?? null,
                                'phone' => $contact['phone'] ?? null,
                                'email' => $contact['email'] ?? null,
                                'role' => $contact['role'] ?? 'Secondary',
                                'created_by' => $currentUserId,
                                'created_by_type' => $userType,
                            ]);
                        } catch (\Exception $e) {
                            Log::error('Error creating contact: ' . $e->getMessage());
                            throw $e; // Re-throw to trigger transaction rollback
                        }
                    }
                }
            }

            if ($request->has('airlines') && is_array($request->airlines)) {
                foreach ($request->airlines as $airlineId) {
                    B2BPartnerAirline::create([
                        'b2b_partner_id' => $partner->id,
                        'airline_id' => $airlineId,
                        'created_by' => $currentUserId,
                    ]);
                }
            }

            if ($request->has('products') && is_array($request->products)) {
                foreach ($request->products as $productId) {
                    if ($productId === 'other') {
                        // Handle custom product
                        if (!empty($validated['custom_product'])) {
                            // Check if product already exists
                            $existingProduct = Product::where('product_name', $validated['custom_product'])->first();
                            if (!$existingProduct) {
                                // Create new product
                                $newProduct = Product::create([
                                    'product_name' => $validated['custom_product'],
                                    'description' => 'Custom product created from B2B partner',
                                    'status' => 'Active',
                                    'created_by' => $currentUserId,
                                    'updated_by' => $currentUserId,
                                ]);
                                $productId = $newProduct->id;
                                $productName = $newProduct->product_name;
                            } else {
                                $productId = $existingProduct->id;
                                $productName = $existingProduct->product_name;
                            }

                            B2BPartnerProduct::create([
                                'b2b_partner_id' => $partner->id,
                                'product_id' => $productId,
                                'product_name' => $productName,
                                'created_by' => $currentUserId,
                            ]);
                        }
                    } else {
                        $product = Product::find($productId);
                        if ($product) {
                            B2BPartnerProduct::create([
                                'b2b_partner_id' => $partner->id,
                                'product_id' => $productId,
                                'product_name' => $product->product_name,
                                'created_by' => $currentUserId,
                            ]);
                        }
                    }
                }
            }

            \DB::commit();
            toastr()->success('B2B Partner added successfully');
            $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
            return redirect()->route($routePrefix . 'b2b-partners');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \DB::rollBack();
            Log::error('Validation error adding B2B partner: ' . $e->getMessage());
            toastr()->error('Please fix the validation errors and try again.');
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \DB::rollBack();
            Log::error('Error adding B2B partner: ' . $e->getMessage());
            toastr()->error('There was an error adding the B2B partner: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show($id)
    {
        $currentUserId = auth('admin')->check() ? auth('admin')->user()->id : (auth()->check() ? auth()->user()->id : null);
        $userType = RouteHelper::isSuperAdmin() ? 'superadmin' : (RouteHelper::isCustomer() ? 'customer' : 'staff');

        $partner = B2BPartner::with('contacts', 'airlines.airline', 'products', 'documents')->find($id);

        // Load notes with their creator relationships
        $partner->load('notes.createdByAdmin', 'notes.createdByUser');
        
        if (!$partner) {
            $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
            return redirect()->route($routePrefix . 'b2b-partners')->with('error', 'Partner not found.');
        }

        if ($userType !== 'superadmin' && $partner->created_by != $currentUserId) {
            return redirect()->back()->with('error', 'You do not have permission to view this partner');
        }

        $bookings = Booking::where('b2b_partner_id', $id)
            ->latest()
            ->paginate(10);

        $activities = B2BPartnerActivity::where('b2b_partner_id', $id)
            ->with('performedByAdmin', 'performedByUser')
            ->latest()
            ->get();

        $airlines = Airline::all();

        return view('admin.b2b-partners.show', compact('partner', 'airlines', 'bookings', 'activities'));
    }

    public function edit($id)
    {
        $currentUserId = auth('admin')->check() ? auth('admin')->user()->id : (auth()->check() ? auth()->user()->id : null);
        $userType = RouteHelper::isSuperAdmin() ? 'superadmin' : (RouteHelper::isCustomer() ? 'customer' : 'staff');

        $partner = B2BPartner::with('contacts', 'airlines', 'products')->find($id);

        if (!$partner) {
            $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
            return redirect()->route($routePrefix . 'b2b-partners')->with('error', 'Partner not found.');
        }

        if ($userType !== 'superadmin' && $partner->created_by != $currentUserId) {
            return redirect()->back()->with('error', 'You do not have permission to edit this partner');
        }

        $airlines = Airline::all();
        $products = Product::where('status', 'Active')->get();

        return view('admin.b2b-partners.edit', compact('partner', 'airlines', 'products'));
    }

    public function update(Request $request, $id)
    {
        try {
            $currentUserId = auth('admin')->check() ? auth('admin')->user()->id : (auth()->check() ? auth()->user()->id : null);
            $userType = RouteHelper::isSuperAdmin() ? 'superadmin' : (RouteHelper::isCustomer() ? 'customer' : 'staff');

            $partner = B2BPartner::find($id);

            if (!$partner) {
                $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
                return redirect()->route($routePrefix . 'b2b-partners')->with('error', 'Partner not found.');
            }

            if ($userType !== 'superadmin' && $partner->created_by != $currentUserId) {
                return redirect()->back()->with('error', 'You do not have permission to edit this partner');
            }

            $validated = $request->validate([
                'partner_name' => 'required|string|max:255',
                'partner_type' => 'required|in:Travel Agent,Tour Operator,Corporate,TMC',
                'iata_tids_no' => 'nullable|string|max:255',
                'country' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:255',
                'website' => 'nullable|url|max:255',
                'remarks' => 'nullable|string',
                'status' => 'required|in:Active,Pending,Inactive',
                'responsible_person' => 'nullable|string|max:255',
                'region' => 'nullable|string|max:255',
                'airline_responsibility' => 'nullable|string|max:255',
                'product_responsibility' => 'nullable|string|max:255',
                'tsa_status' => 'nullable|in:Activated,Deactivated',
                'custom_product' => 'nullable|string|max:255|required_if:products,other',
            ]);

            $oldValues = $partner->toArray();
            
            $partner->update([
                'partner_name' => $validated['partner_name'],
                'partner_type' => $validated['partner_type'],
                'iata_tids_no' => $validated['iata_tids_no'] ?? null,
                'country' => $validated['country'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'website' => $validated['website'] ?? null,
                'remarks' => $validated['remarks'] ?? null,
                'status' => $validated['status'],
                'responsible_person' => $validated['responsible_person'] ?? null,
                'region' => $validated['region'] ?? null,
                'airline_responsibility' => $validated['airline_responsibility'] ?? null,
                'product_responsibility' => $validated['product_responsibility'] ?? null,
                'tsa_status' => $validated['tsa_status'] ?? null,
                'updated_by' => $currentUserId,
            ]);

            // Log activity (try-catch to prevent blocking main operation)
            try {
                B2BPartnerActivity::create([
                    'b2b_partner_id' => $partner->id,
                    'activity_type' => 'updated',
                    'description' => 'B2B Partner ' . $partner->partner_name . ' was updated',
                    'old_values' => $oldValues,
                    'new_values' => $partner->toArray(),
                    'performed_by' => $currentUserId,
                    'performed_by_type' => $userType,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            } catch (\Exception $e) {
                Log::error('Error logging B2B partner activity: ' . $e->getMessage());
            }

            if ($request->has('contacts') && is_array($request->contacts)) {
                B2BPartnerContact::where('b2b_partner_id', $partner->id)->delete();
                foreach ($request->contacts as $contact) {
                    if (!empty($contact['name'])) {
                        B2BPartnerContact::create([
                            'b2b_partner_id' => $partner->id,
                            'name' => $contact['name'],
                            'designation' => $contact['designation'] ?? null,
                            'phone' => $contact['phone'] ?? null,
                            'email' => $contact['email'] ?? null,
                            'role' => $contact['role'] ?? 'Secondary',
                            'created_by' => $currentUserId,
                            'created_by_type' => $userType,
                        ]);
                    }
                }
            }

            if ($request->has('airlines') && is_array($request->airlines)) {
                B2BPartnerAirline::where('b2b_partner_id', $partner->id)->delete();
                foreach ($request->airlines as $airlineId) {
                    B2BPartnerAirline::create([
                        'b2b_partner_id' => $partner->id,
                        'airline_id' => $airlineId,
                        'created_by' => $currentUserId,
                    ]);
                }
            }

            if ($request->has('products') && is_array($request->products)) {
                B2BPartnerProduct::where('b2b_partner_id', $partner->id)->delete();
                foreach ($request->products as $productId) {
                    if ($productId === 'other') {
                        // Handle custom product
                        if (!empty($validated['custom_product'])) {
                            // Check if product already exists
                            $existingProduct = Product::where('product_name', $validated['custom_product'])->first();
                            if (!$existingProduct) {
                                // Create new product
                                $newProduct = Product::create([
                                    'product_name' => $validated['custom_product'],
                                    'description' => 'Custom product created from B2B partner',
                                    'status' => 'Active',
                                    'created_by' => $currentUserId,
                                    'updated_by' => $currentUserId,
                                ]);
                                $productId = $newProduct->id;
                                $productName = $newProduct->product_name;
                            } else {
                                $productId = $existingProduct->id;
                                $productName = $existingProduct->product_name;
                            }

                            B2BPartnerProduct::create([
                                'b2b_partner_id' => $partner->id,
                                'product_id' => $productId,
                                'product_name' => $productName,
                                'created_by' => $currentUserId,
                            ]);
                        }
                    } else {
                        $product = Product::find($productId);
                        if ($product) {
                            B2BPartnerProduct::create([
                                'b2b_partner_id' => $partner->id,
                                'product_id' => $productId,
                                'product_name' => $product->product_name,
                                'created_by' => $currentUserId,
                            ]);
                        }
                    }
                }
            }

            toastr()->success('B2B Partner updated successfully');
            $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
            return redirect()->route($routePrefix . 'b2b-partners.show', $partner->id);
        } catch (\Exception $e) {
            Log::error('Error updating B2B partner: ' . $e->getMessage());
            toastr()->error('There was an error updating the B2B partner. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        $currentUserId = auth('admin')->check() ? auth('admin')->user()->id : (auth()->check() ? auth()->user()->id : null);
        $userType = RouteHelper::isSuperAdmin() ? 'superadmin' : (RouteHelper::isCustomer() ? 'customer' : 'staff');

        $partner = B2BPartner::find($id);

        if (!$partner) {
            $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
            return redirect()->route($routePrefix . 'b2b-partners')->with('error', 'Partner not found.');
        }

        if ($userType !== 'superadmin' && $partner->created_by != $currentUserId) {
            return redirect()->back()->with('error', 'You do not have permission to delete this partner');
        }

        $partner->delete();

        toastr()->success('B2B Partner deleted successfully');
        $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
        return redirect()->route($routePrefix . 'b2b-partners');
    }

    public function storeContact(Request $request, $partnerId)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'designation' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'role' => 'required|in:Primary,Secondary',
            ]);

            $currentUserId = auth('admin')->check() ? auth('admin')->user()->id : (auth()->check() ? auth()->user()->id : null);
            $userType = auth('admin')->check() ? (auth('admin')->user()->hasRole('SuperAdmin') ? 'superadmin' : 'customer') : 'staff';

            B2BPartnerContact::create([
                'b2b_partner_id' => $partnerId,
                'name' => $validated['name'],
                'designation' => $validated['designation'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'role' => $validated['role'],
                'created_by' => $currentUserId,
                'created_by_type' => $userType,
            ]);

            return redirect()->back()->with('success', 'Contact added successfully');
        } catch (\Exception $e) {
            Log::error('Error adding contact: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error adding the contact. Please try again.');
        }
    }

    public function updateContact(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'designation' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'role' => 'required|in:Primary,Secondary',
            ]);

            $currentUserId = auth('admin')->check() ? auth('admin')->user()->id : (auth()->check() ? auth()->user()->id : null);
            $userType = RouteHelper::isSuperAdmin() ? 'superadmin' : (RouteHelper::isCustomer() ? 'customer' : 'staff');

            $contact = B2BPartnerContact::find($id);
            $contact->update([
                'name' => $validated['name'],
                'designation' => $validated['designation'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'role' => $validated['role'],
                'updated_by' => $currentUserId,
                'updated_by_type' => $userType,
            ]);

            return redirect()->back()->with('success', 'Contact updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating contact: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error updating the contact. Please try again.');
        }
    }

    public function deleteContact($id)
    {
        try {
            $contact = B2BPartnerContact::find($id);
            if ($contact) {
                $contact->delete();
                return redirect()->back()->with('success', 'Contact deleted successfully');
            }
            return redirect()->back()->with('error', 'Contact not found');
        } catch (\Exception $e) {
            Log::error('Error deleting contact: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error deleting the contact. Please try again.');
        }
    }

    public function storeDocument(Request $request, $partnerId)
    {
        try {
            $validated = $request->validate([
                'file' => 'required|file|max:10240',
                'document_type' => 'required|in:Agreement,TSA,Contract,License,Other',
            ]);

            $currentUserId = auth('admin')->check() ? auth('admin')->user()->id : (auth()->check() ? auth()->user()->id : null);
            $userType = auth('admin')->check() ? (auth('admin')->user()->hasRole('SuperAdmin') ? 'superadmin' : 'customer') : 'staff';

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('b2b-documents', $fileName, 'public');
                $fileExtension = $file->getClientOriginalExtension();

                B2BPartnerDocument::create([
                    'b2b_partner_id' => $partnerId,
                    'file_name' => $fileName,
                    'file_type' => $fileExtension,
                    'document_type' => $validated['document_type'],
                    'file_path' => $filePath,
                    'created_by' => $currentUserId,
                    'created_by_type' => $userType,
                ]);
            }

            return redirect()->back()->with('success', 'Document uploaded successfully');
        } catch (\Exception $e) {
            Log::error('Error uploading document: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error uploading the document. Please try again.');
        }
    }

    public function deleteDocument($id)
    {
        try {
            $document = B2BPartnerDocument::find($id);

            if ($document) {
                Storage::disk('public')->delete($document->file_path);
                $document->delete();
                return redirect()->back()->with('success', 'Document deleted successfully');
            }
            return redirect()->back()->with('error', 'Document not found');
        } catch (\Exception $e) {
            Log::error('Error deleting document: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error deleting the document. Please try again.');
        }
    }

    public function storeNote(Request $request, $partnerId)
    {
        try {
            $validated = $request->validate([
                'note' => 'required|string',
            ]);

            $currentUserId = auth('admin')->check() ? auth('admin')->user()->id : (auth()->check() ? auth()->user()->id : null);
            $userType = RouteHelper::isSuperAdmin() ? 'superadmin' : (RouteHelper::isCustomer() ? 'customer' : 'staff');

            B2BPartnerNote::create([
                'b2b_partner_id' => $partnerId,
                'note' => $validated['note'],
                'created_by' => $currentUserId,
                'created_by_type' => $userType,
            ]);

            return redirect()->back()->with('success', 'Note added successfully');
        } catch (\Exception $e) {
            Log::error('Error adding note: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error adding the note. Please try again.');
        }
    }

    public function deleteNote($id)
    {
        try {
            $note = B2BPartnerNote::find($id);
            if ($note) {
                $note->delete();
                return redirect()->back()->with('success', 'Note deleted successfully');
            }
            return redirect()->back()->with('error', 'Note not found');
        } catch (\Exception $e) {
            Log::error('Error deleting note: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error deleting the note. Please try again.');
        }
    }

    public function deleteAirline($id)
    {
        try {
            $airline = B2BPartnerAirline::find($id);
            if ($airline) {
                $airline->delete();
                return redirect()->back()->with('success', 'Airline removed successfully');
            }
            return redirect()->back()->with('error', 'Airline not found');
        } catch (\Exception $e) {
            Log::error('Error deleting airline: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error removing the airline. Please try again.');
        }
    }

    public function deleteProduct($id)
    {
        try {
            $product = B2BPartnerProduct::find($id);
            if ($product) {
                $product->delete();
                return redirect()->back()->with('success', 'Product removed successfully');
            }
            return redirect()->back()->with('error', 'Product not found');
        } catch (\Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error removing the product. Please try again.');
        }
    }

    public function reports(Request $request)
    {
        $currentUserId = auth('admin')->check() ? auth('admin')->user()->id : (auth()->check() ? auth()->user()->id : null);
        $userType = RouteHelper::isSuperAdmin() ? 'superadmin' : (RouteHelper::isCustomer() ? 'customer' : 'staff');

        $query = B2BPartner::with('bookings')->whereNull('deleted_at');

        if ($userType !== 'superadmin') {
            $query->where('created_by', $currentUserId);
        }

        // Apply date range filter
        if ($request->has('date_range') && !empty($request->input('date_range'))) {
            $dateRange = $request->input('date_range');
            $startDate = null;
            $endDate = now();

            switch ($dateRange) {
                case 'last_month':
                    $startDate = now()->subMonth();
                    break;
                case 'last_3_months':
                    $startDate = now()->subMonths(3);
                    break;
                case 'last_6_months':
                    $startDate = now()->subMonths(6);
                    break;
                case 'last_year':
                    $startDate = now()->subYear();
                    break;
                case 'custom':
                    if ($request->has('start_date') && !empty($request->input('start_date'))) {
                        $startDate = \Carbon\Carbon::parse($request->input('start_date'));
                    }
                    if ($request->has('end_date') && !empty($request->input('end_date'))) {
                        $endDate = \Carbon\Carbon::parse($request->input('end_date'));
                    }
                    break;
            }

            if ($startDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        // Apply partner type filter
        if ($request->has('partner_type') && !empty($request->input('partner_type'))) {
            $query->where('partner_type', $request->input('partner_type'));
        }

        $partners = $query->latest()->get();

        // Calculate report data
        $reportData = [
            'total_partners' => $partners->count(),
            'active_partners' => $partners->where('status', 'Active')->count(),
            'total_bookings' => $partners->sum('total_bookings'),
            'total_revenue' => $partners->sum('revenue'),
            'total_passengers' => $partners->sum('total_passengers'),
            'partners_by_type' => $partners->groupBy('partner_type')->map->count(),
            'top_partners' => $partners->sortByDesc('revenue')->take(10),
        ];

        return view('admin.b2b-partners.reports', compact('partners', 'reportData'));
    }

    public function generateReport(Request $request)
    {
        $reportType = $request->input('report_type');
        $dateRange = $request->input('date_range');
        $partnerType = $request->input('partner_type');

        $query = B2BPartner::with('bookings')->whereNull('deleted_at');

        // Apply filters
        if ($partnerType && $partnerType !== 'all') {
            $query->where('partner_type', $partnerType);
        }

        if ($dateRange && $dateRange !== 'all') {
            $startDate = null;
            $endDate = now();

            switch ($dateRange) {
                case 'last_month':
                    $startDate = now()->subMonth();
                    break;
                case 'last_3_months':
                    $startDate = now()->subMonths(3);
                    break;
                case 'last_6_months':
                    $startDate = now()->subMonths(6);
                    break;
                case 'last_year':
                    $startDate = now()->subYear();
                    break;
            }

            if ($startDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        $partners = $query->latest()->get();

        // Generate report based on type
        switch ($reportType) {
            case 'booking':
                return $this->generateBookingReport($partners);
            case 'revenue':
                return $this->generateRevenueReport($partners);
            case 'performance':
                return $this->generatePerformanceReport($partners);
            case 'tsa':
                return $this->generateTSAReport($partners);
            default:
                return redirect()->back()->with('error', 'Invalid report type');
        }
    }

    private function generateBookingReport($partners)
    {
        $data = [];
        foreach ($partners as $partner) {
            $data[] = [
                'Partner Name' => $partner->partner_name,
                'Partner Code' => $partner->partner_code,
                'Type' => $partner->partner_type,
                'Total Bookings' => $partner->total_bookings,
                'Total Passengers' => $partner->total_passengers,
                'Status' => $partner->status,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $data,
            'report_type' => 'Booking Report'
        ]);
    }

    private function generateRevenueReport($partners)
    {
        $data = [];
        foreach ($partners as $partner) {
            $data[] = [
                'Partner Name' => $partner->partner_name,
                'Partner Code' => $partner->partner_code,
                'Type' => $partner->partner_type,
                'Revenue (INR)' => $partner->revenue,
                'Average Booking Value' => $partner->total_bookings > 0 ? $partner->revenue / $partner->total_bookings : 0,
                'Status' => $partner->status,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $data,
            'report_type' => 'Revenue Report'
        ]);
    }

    private function generatePerformanceReport($partners)
    {
        $data = [];
        foreach ($partners as $partner) {
            $data[] = [
                'Partner Name' => $partner->partner_name,
                'Partner Code' => $partner->partner_code,
                'Type' => $partner->partner_type,
                'Total Bookings' => $partner->total_bookings,
                'Revenue (INR)' => $partner->revenue,
                'Passenger Count' => $partner->total_passengers,
                'Performance Score' => $partner->total_bookings > 0 ? round(($partner->revenue / $partner->total_bookings) * 0.1, 2) : 0,
                'Status' => $partner->status,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $data,
            'report_type' => 'Partner Performance Report'
        ]);
    }

    private function generateTSAReport($partners)
    {
        $data = [];
        foreach ($partners as $partner) {
            $data[] = [
                'Partner Name' => $partner->partner_name,
                'Partner Code' => $partner->partner_code,
                'Type' => $partner->partner_type,
                'TSA Status' => $partner->tsa_status ?? 'Not Set',
                'Airline Responsibility' => $partner->airline_responsibility ?? 'Not Set',
                'Product Responsibility' => $partner->product_responsibility ?? 'Not Set',
                'Status' => $partner->status,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $data,
            'report_type' => 'TSA Status Report'
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            return response()->json([]);
        }

        $partners = B2BPartner::where(function ($q) use ($query) {
            $q->where('partner_name', 'like', "%{$query}%")
              ->orWhere('email', 'like', "%{$query}%")
              ->orWhere('phone', 'like', "%{$query}%")
              ->orWhere('partner_code', 'like', "%{$query}%");
        })
        ->get()
        ->map(function ($partner) {
            return [
                'id' => $partner->id,
                'partner_name' => $partner->partner_name,
                'partner_type' => $partner->partner_type,
                'email' => $partner->email,
                'phone' => $partner->phone,
                'country' => $partner->country,
                'remarks' => $partner->remarks,
                'responsible_person' => $partner->responsible_person,
            ];
        });

        return response()->json($partners);
    }
}
