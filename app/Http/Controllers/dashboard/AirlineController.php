<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Airline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\AirlineDetail;
use App\Models\Aircraft;
use App\Models\ApprovedStaff;
use App\Models\User;
use App\Models\AirlineLibrary;
use App\Models\Fleet;
use App\Models\SLA;
use App\Models\Rule;
use App\Models\Agent;
use App\Models\SpecialFare;
use App\Models\Agreement;
use App\Models\FareType;
use App\Models\Duty;

use App\Models\HeadOfficeContactDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class AirlineController extends Controller
{
    public function index()
    {

        $airlineDetails = AirlineDetail::where('deleted_at', NULL)->with('airline')->get();
        $airlines = Airline::all();

        return view('admin.airlines', compact('airlines', 'airlineDetails'));
    }

    public function report(Request $request)
    {
        $airlines = Airline::all();
        $airline_id = $request->airline_id;
        // dd($airline_id);
        $specialFares = SpecialFare::where('airline_id', $request->airline_id)
            ->groupBy('agent_id')
            ->get();
        // dd($specialFares);

        return view('admin.airline-reports', compact('airlines', 'specialFares'));
    }

    public function view($id)
    {
        $rules = Rule::where('airline_id', $id)->get();
        $agents = Agent::where('deleted_at', null)->orWhere('deleted_at', 'null')->with('specialFare')->get();
        $airlineDetails = AirlineDetail::where('airline_id', $id)->where('deleted_at', null)->orWhere('deleted_at', 'null')->first();
        $airlines = Airline::all();
        $aircrafts = Aircraft::where('deleted_at', null)->orWhere('deleted_at', 'null')->where('airline_id', $id)->get();
        $fleets = Fleet::where('deleted_at', null)->orWhere('deleted_at', 'null')->where('airline_id', $id)->get();
        $staff = User::where('role_id', 2)->get();
        $library = AirlineLibrary::where('deleted_at', null)->orWhere('deleted_at', 'null')->where('airline_id', $id)->get();
        $approvedStaffs = ApprovedStaff::where('status', 1)->where('airline_id', $id)->get();
        $slas = SLA::where('deleted_at', null)->orWhere('deleted_at', 'null')->where('airline_id', $id)->get();
        $headOffices = HeadOfficeContactDetail::where('airline_id', $id)->where('deleted_at', NULL)->get();
        $headOfficesDeleted = HeadOfficeContactDetail::where('airline_id', $id)->where('deleted_at', '!=', NULL)->get();
        $Staffs = User::where('status', 'active')->get();
        $agreements = Agreement::where('deleted_at', null)->orWhere('deleted_at', 'null')->with(['agent', 'airline'])->get();
        $fareType = FareType::get();
        $duty = Duty::where('status', 1)->get();
        $specialFare = SpecialFare::where('airline_id', $id)->where('status', 1)->with('fareDiscount')->get();

        return view('admin.view-airline', compact('airlines', 'airlineDetails', 'aircrafts', 'fleets', 'staff', 'approvedStaffs', 'library', 'slas', 'headOffices', 'Staffs', 'agents', 'rules', 'headOfficesDeleted', 'agreements', 'fareType', 'specialFare', 'duty'));
    }

    public function searchSpecialFare(Request $request, $id)
    {
        $specialFares = SpecialFare::with(['airline', 'agent.head_office'])->where('airline_id', $id)
            ->where('status', 1);

        if ($request->has('search') && !empty($request->input('search'))) {
            $searchValue = $request->input('search');
            $searchTypes = $request->input('search_type', []);

            $searchParts = array_map('trim', explode(',', $searchValue));

            $specialFares->where(function ($q) use ($searchParts, $searchTypes) {
                foreach ($searchTypes as $index => $type) {
                    if (isset($searchParts[$index])) {
                        $searchTerm = '%' . $searchParts[$index] . '%';

                        if (in_array($type, ['company_name', 'pincode', 'city', 'state', 'country', 'account_code', 'iata', 'agency_name'])) {
                            $q->whereHas('agent', function ($subQuery) use ($type, $searchTerm) {
                                $subQuery->where($type, 'like', $searchTerm);
                            });
                        }

                        if (in_array($type, ['phone_number', 'email_address', 'first_name'])) {
                            $q->whereHas('agent.head_office', function ($subQuery) use ($type, $searchTerm) {
                                $subQuery->where($type, 'like', $searchTerm);
                            });
                        }

                        if ($type === 'fare_type') {
                            $q->where('fare_type', 'like', $searchTerm);
                        }

                        // Check for product_type in agent_product_types
                        if ($type === 'product_type') {
                            $q->whereHas('agent.agentProductTypes', function ($subQuery) use ($searchTerm) {
                                $subQuery->where('product_type', 'like', $searchTerm);
                            });
                        }
                    }
                }
            });
        }

        $specialFares = $specialFares->get();

        if ($request->ajax()) {
            $data = $specialFares->map(function ($fare) {
                return [
                    'company_name' => $fare->agent->company_name ?? 'N/A',
                    'fare_type' => $fare->fare_type ?? 'N/A',
                    'status' => $fare->status == 1 ? 'Active' : 'Inactive',
                    'iata' => $fare->agent->iata ?? 'N/A',
                    'pcc_office_id' => $fare->agent->pcc_office_id ?? 'N/A',
                    'account_code' => $fare->agent->account_code ?? 'N/A',
                    'discount' => $fare->agent->discount ?? 'N/A',
                    'remarks' => $fare->agent->remarks ?? 'N/A',
                    'created_at' => $fare->created_at ? Carbon::parse($fare->created_at)->format('d-m-Y H:i:s') : null,
                    'created_by' => $fare->created_by,
                    'updated_at' => $fare->updated_at ? Carbon::parse($fare->updated_at)->format('d-m-Y H:i:s') : null,
                    'updated_by' => $fare->updated_by,
                ];
            });

            return response()->json(['specialFares' => $data]);
        }
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->all();

        // Handle file upload
        if ($request->hasFile('logo')) {
            // Get the file
            $file = $request->file('logo');

            // Generate a unique file name with extension
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Define the storage path
            $storagePath = public_path('assets/img/airlines');

            // Check if the directory exists, if not create it
            if (!File::exists($storagePath)) {
                File::makeDirectory($storagePath, 0755, true, true);
            }

            // Move the file to the defined path
            $file->move($storagePath, $fileName);

            // Add file path to validated data
            $validatedData['logo_name'] = $file->getClientOriginalName(); // This is the original name
            $validatedData['logo_path'] = 'public/assets/img/airlines/' . $fileName; // This is the unique path
        }

        // Create a new airline record
        $airline = Airline::create($validatedData);

        // Prepare data for airlineDetails
        $airlineDetailsData = [
            'airline_id' => $airline->id,
            'country' => $validatedData['country'],
            'founded_on' => $validatedData['founded_on'],
            'commenced_on' => $validatedData['commenced_on'],
            'hubs' => $validatedData['hubs'],
            'secondary_hubs' => $validatedData['secondary_hub'],
            'focus_cities' => json_encode($validatedData['focus_cities']),
            'frequent_flyer_program' => $validatedData['frequent_flyer_program'],
            'alliance' => $validatedData['alliance'],
            'subsidiaries' => $validatedData['subsidiaries'],
            'fleet_size' => $validatedData['fleet_size'],
            'destinations' => $validatedData['destinations'],
            'slogan' => $validatedData['slogan'],
            'key_people' => $request->input('key_people'),
            'parent_company' => $request->input('parent_company'),
            'head_quarters' => $request->input('head_quarters'),
            'website' => $request->input('website'),
            'IATA' => $request->input('IATA'),
            'ICAO' => $request->input('ICAO'),
            'callsign' => $request->input('callsign'),
            'numeric_code' => $request->input('numeric_code')
        ];

        // Create a new airlineDetails record
        AirlineDetail::create($airlineDetailsData);

        // Return a response
        return redirect()->route('admin.airlines-details')->with('success', 'Airline added successfully');
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->all();

        // Find the existing airline record
        $airline = Airline::findOrFail($id);

        // Handle file upload
        if ($request->hasFile('logo')) {
            // Get the file
            $file = $request->file('logo');

            // Generate a unique file name with extension
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Define the storage path
            $storagePath = public_path('assets/img/airlines');

            // Check if the directory exists, if not create it
            if (!File::exists($storagePath)) {
                File::makeDirectory($storagePath, 0755, true, true);
            }

            // Move the file to the defined path
            $file->move($storagePath, $fileName);

            // Delete the old logo if it exists
            if ($airline->logo_path && File::exists(public_path($airline->logo_path))) {
                File::delete(public_path($airline->logo_path));
            }

            // Add file path to validated data
            $validatedData['logo_name'] = $file->getClientOriginalName(); // This is the original name
            $validatedData['logo_path'] = 'public/assets/img/airlines/' . $fileName; // This is the unique path
        }

        // Update the airline record
        $airline->update($validatedData);

        // Prepare data for airlineDetails
        $airlineDetailsData = [
            'airline_id' => $airline->id,

            'country' => $validatedData['country'],
            'founded_on' => $validatedData['founded_on'],
            'commenced_on' => $validatedData['commenced_on'],
            'hubs' => $validatedData['hubs'],
            'secondary_hubs' => $validatedData['secondary_hub'],
            'focus_cities' => json_encode($validatedData['focus_cities']), // Assuming focus_cities is an array
            'frequent_flyer_program' => $validatedData['frequent_flyer_program'],
            'alliance' => $validatedData['alliance'],
            'subsidiaries' => $validatedData['subsidiaries'],
            'fleet_size' => $validatedData['fleet_size'],
            'destinations' => $validatedData['destinations'],
            'slogan' => $validatedData['slogan'],
            'key_people' => $request->input('key_people'),
            'parent_company' => $request->input('parent_company'),
            'head_quarters' => $request->input('head_quarters'),
            'website' => $request->input('website'),
            'IATA' => $request->input('IATA'),
            'ICAO' => $request->input('ICAO'),
            'callsign' => $request->input('callsign'),
            'numeric_code' => $request->input('numeric_code')
        ];

        // Update the airlineDetails record
        $airlineDetail = AirlineDetail::where('airline_id', $id)->first();

        $airlineDetail->update($airlineDetailsData);

        // Return a response
        return redirect()->route('admin.airlines-details')->with('success', 'Airline updated successfully');
    }

    public function delete($id)
    {
        $airlines = AirlineDetail::find($id);
        $airlines->update([
            'deleted_at' => now()
        ]);

        return redirect()->back();
    }


    public function deletedAirline()
    {
        $airlineDetails = AirlineDetail::where('deleted_at', NULL)->with('airline')->get();
        $airlines = Airline::all();
        return view('admin.airline-details', compact('airlines', 'airlineDetails'));
    }



    public function aircraftStore(Request $request)
    {
        $request->validate([
            'flight_no' => 'required|string|unique:flights',
            'origin_station' => 'required|string',
            'arrival_station' => 'required|string',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
            'aircraft_type' => 'required|string',
            'valid_till' => 'required|date',
            'frequency' => 'required|string',
            'airline_id' => 'required'
        ]);

        $flight = Aircraft::create($request->all());

        return redirect()->back();
    }

    // Update existing flight
    public function aircraftUpdate(Request $request, $id)
    {
        $flight = Aircraft::findOrFail($id);

        $request->validate([
            'flight_no' => 'required|string|unique:flights,flight_no,' . $flight->id,
            'origin_station' => 'required|string',
            'arrival_station' => 'required|string',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
            'aircraft_type' => 'required|string',
            'valid_till' => 'required|date',
            'frequency' => 'required|string',
        ]);

        $flight->update($request->all());

        return redirect()->back();
    }

    public function aircraftDelete($id, Request $request)
    {
        $flight = Aircraft::findOrFail($id);
        $flight->update([
            'deleted_at' => now(),
            'remarks' => $request->input('remarks')
        ]);
        return redirect()->back()->with('success', 'Schedule deleted successfully');
    }

    public function fleetStore(Request $request)
    {
        $validated = $request->all();

        Fleet::create($validated);

        return redirect()->back()->with('success', 'Fleet Created Sucessfully');
    }

    // Update function
    public function fleetUpdate(Request $request, $id)
    {
        $validated = $request->all();

        $fleet = Fleet::findOrFail($id);
        $fleet->update($validated);

        return redirect()->back()->with('success', 'Fleet Updated Sucessfully');
    }

    public function fleetDelete($id, Request $request)
    {
        $fleets = Fleet::findorFail($id);
        $fleets->update([
            'deleted_at' => now(),
            'remarks' => $request->input('remarks')
        ]);
        return redirect()->back()->with('success', 'Fleet Deleted Sucessfully');
    }

    public function approvedStaffStore(Request $request)
    {
        $validatedData = $request->validate([
            'airline_id' => 'required|integer',
            'staff_id' => 'required|integer',
            'ticketing' => 'required|integer',
            'marketing' => 'required|integer',
            'sales' => 'required|integer',
            'airport_operations' => 'required|integer',
            'created_by' => 'nullable'
        ]);
        $approvedStaff = ApprovedStaff::create($validatedData);
        return redirect()->back();
    }

    public function approvedStaffUpdate(Request $request, $id)
    {
        $approvedStaff = ApprovedStaff::find($id);
        $approvedStaff->update([
            'staff_id' => $request->input('staff_id'),
            'ticketing' => $request->input('ticketing'),
            'marketing' => $request->input('marketing'),
            'sales' => $request->input('sales'),
            'airport_operations' => $request->input('airport_operations'),
            'updated_at' => now(),
            'updated_by' => auth()->user()->name
        ]);
        return redirect()->back();
    }



    public function slaStore(Request $request)
    {
        try {

            $fileName = null;

            if ($request->hasFile('document')) {

                $docName = $request->file('document');

                $fileName = uniqid() . '.' . $docName->getClientOriginalExtension();

                $mediaPath = $docName->move('public/assets/docs/', $fileName);
                if (!$mediaPath) {
                    return back()->with('error', 'Failed to upload sla documnt');
                }
            }


            // Create a new SLA record with validated data
            SLA::create([
                'airline_id' => $request->input('airline_id'),
                'title' => $request->input('title'),
                'category' => $request->input('category'),
                'content' => $request->input('content'),
                'document' => $fileName,
                'updated_at' =>  $request->input('updated_at'),
                'created_by' => Auth()->user()->name
            ]);

            return redirect()->back()->with('success', 'SLA added successfully.');
        } catch (Exception $e) {
            dd($e);
        }
    }




    public function slaUpdate(Request $request, $id)
    {

        $sla = SLA::findOrFail($id);

        $fileName = $sla->document;


        if ($request->hasFile('document')) {

            $docName = $request->file('document');

            $fileName = uniqid() . '.' . $docName->getClientOriginalExtension();

            $mediaPath = $docName->move('public/assets/docs/', $fileName);
            if (!$mediaPath) {
                return back()->with(['error' => 'Failed to upload document']);
            }
        }


        $sla->update([
            'airline_id' => $request->input('airline_id'),
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'content' => $request->input('content'),
            'document' => $fileName,
            'updated_by' => Auth()->user()->name
        ]);

        return redirect()->back()->with('success', 'SLA updated successfully.');
    }




    public function slaDestroy($id, Request $request)
    {
        $sla = SLA::findOrFail($id);
        $sla->update([
            'deleted_at' => now(),
            'remarks' => $request->input('remarks')
        ]);

        return redirect()->back();
    }


    public function slaUpdateStatus($id, Request $request)
    {
        try {
            // Find the SLA record by ID
            $sla = SLA::findOrFail($id);

            // Toggle the status
            $sla->status = ($sla->status == 1) ? 2 : 1;
            $sla->save();

            // Return a JSON response for AJAX requests
            if ($request->ajax()) {
                return response()->json(['success' => true, 'status' => $sla->status]);
            }

            // Fallback for non-AJAX requests
            return redirect()->back()->with('success', 'SLA status updated successfully.');
        } catch (\Exception $e) {
            // Log the error message
            \Log::error('Error updating SLA status: ' . $e->getMessage());

            // Return a JSON error response
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Error updating status'], 500);
            }

            return redirect()->back()->with('error', 'Error updating status.');
        }
    }


    public function headOfficeStore(Request $request)
    {

        $validated = $request->all();

        HeadOfficeContactDetail::create($validated);
        //dd($validated);
        return redirect()->back()->with('success', 'head office Contact Details added successfully.');
    }

    public function headOfficeUpdate(Request $request, $id)
    {
        $headOffice = HeadOfficeContactDetail::findOrFail($id);

        $validated = $request->validate([
            'airline_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'email_address' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',

        ]);


        $validated['last_updated_by'] = auth()->user()->name;
        $validated['last_updated_on'] = now();
        $validated['add_to_mail_list'] = $request->input('add_to_mail_list') == '1' ? 1 : 0;
        $headOffice->update($validated);

        return redirect()->back()->with('success', 'Head Office Contact Details updated successfully.');
    }


    public function headOfficeUpdateStatus($id, Request $request)
    {


        $headOffice = HeadOfficeContactDetail::findOrFail($id);


        $headOffice->status = ($headOffice->status == 1) ? 2 : 1;
        $headOffice->save();

        // Return a JSON response for AJAX requests
        if ($request->ajax()) {
            return response()->json(['success' => true, 'status' => $headOffice->status]);
        }

        // Fallback for non-AJAX requests
        return redirect()->back()->with('success', 'SLA status updated successfully.');
    }


    public function headOfficeDestroy($id, Request $request)
    {
        $headOffice = HeadOfficeContactDetail::findOrFail($id);
        $headOffice->update([
            'deleted_at' => now(),
            'remarks' => $request->input('remarks')
        ]);

        return redirect()->back();
    }




    public function approvedStaffUpdateStatus(Request $request)
    {

        $request->validate([
            'staff_id' => 'required|integer',
            'field' => 'required|string',
            'status' => 'required|integer|in:1,2',
        ]);

        $staff = ApprovedStaff::where('staff_id', $request->staff_id)->first();

        if (!$staff) {
            return response()->json(['success' => false, 'message' => 'Staff not found']);
        }

        $staff->{$request->field} = $request->status;
        $staff->save();

        return response()->json(['success' => true]);
    }

    public function libraryupdate(Request $request, $id)
    {
        // Find the document by its ID
        $document = AirlineLibrary::findOrFail($id);

        // Handle the attachment file upload
        // if ($request->hasFile('attachment')) {
        //     $docName = $request->file('attachment');
        //     $fileName = uniqid() . '.' . $docName->getClientOriginalExtension();
        //     $mediaPath = $docName->move(public_path('public/assets/docs/'), $fileName);

        //     if (!$mediaPath) {
        //         return back()->withErrors(['media' => 'Failed to upload document']);
        //     }

        //     // Update the attachment field
        //     $document->attachment = $fileName;
        // }

        $fileNames = []; // Array to hold the filenames

        if ($request->hasFile('attachment')) {
            $docFile = $request->file('attachment');

            // foreach ($docFiles as $docFile) {
            // Generate a unique file name with extension
            $fileName = Str::uuid() . '.' . $docFile->getClientOriginalExtension();

            // Define the storage path
            $storagePath = ('public/assets/docs/');

            // Check if the directory exists, if not create it
            if (!File::exists($storagePath)) {
                File::makeDirectory($storagePath, 0755, true, true);
            }

            // Move the file to the defined path
            $docFile->move($storagePath, $fileName);

            // Add the filename to the array
            $fileNames[] = asset('public/assets/docs/') . "/" . $fileName;
            // }
        }
        // Convert array to a JSON string or comma-separated string
        $fileNamesString = json_encode($fileNames); // Use this if you prefer JSON format


        // Update other fields
        $document->airline_id = $request->input('airline_id');
        $document->doc_name = $request->input('doc_name');
        $document->issue_date = $request->input('issue_date');
        $document->effective_date = now();
        $document->attachment = $fileNamesString;
        $document->edition_no = $request->input('edition_no');


        $document->updated_by = auth()->user()->id; // Assuming you want to store the user ID
        $document->updated_at = now();


        $document->read_sign = 1;


        $document->save();


        return redirect()->back()->with('success', 'Document updated successfully!');
    }

    public function libraryDelete($id, Request $request)
    {
        $library = AirlineLibrary::findOrFail($id);
        $library->update([
            'deleted_at' => now(),
            'remarks' => $request->input('remarks')
        ]);
        return redirect()->back()->with('success', 'Library deleted successfully');
    }

    public function targetStore(Request $request)
    {
        foreach ($request->input('agent') as $agentId => $fareTypes) {
            foreach ($fareTypes as $fareType => $status) {

                // Check if a record exists for the given airline, fare type, and agent
                $specialFare = SpecialFare::where('agent_id', $agentId)
                    ->where('airline_id', $request->input('airline_id'))
                    ->where('fare_type', $fareType)
                    ->first();
                // If no record exists, create a new one
                if (!$specialFare) {
                    $specialFare = new SpecialFare();
                    $specialFare->airline_id = $request->input('airline_id');
                    $specialFare->agent_id = $agentId;
                    $specialFare->fare_type = $fareType;
                    $specialFare->status = $status;
                    $specialFare->created_by = Auth()->user()->name;
                    $specialFare->updated_at = $request->input('updated_at');
                    $specialFare->save();
                } else {
                    // If the status has changed, update the necessary fields
                    if ($specialFare->status != $status) {
                        $specialFare->status = $status;
                        $specialFare->updated_by = Auth()->user()->name;
                        $specialFare->updated_at = now();
                        $specialFare->save();
                    }
                }
            }
        }
        return redirect()->back()->with('success', 'Special fares updated successfully.');
    }


    public function approvedStaffRightsStore(Request $request)
    {
        foreach ($request->input('staff') as $satffId => $duties) {
            foreach ($duties as $duty => $status) {

                // Check if a record exists for the given airline, fare type, and agent
                $specialFare = ApprovedStaff::where('staff_id', $satffId)
                    ->where('airline_id', $request->input('airline_id'))
                    ->where('duties', $duty)
                    ->first();
                // If no record exists, create a new one
                if (!$specialFare) {
                    $specialFare = new ApprovedStaff();
                    $specialFare->airline_id = $request->input('airline_id');
                    $specialFare->staff_id = $satffId;
                    $specialFare->duties = $duty;
                    $specialFare->status = $status;
                    $specialFare->created_by = Auth()->user()->name;
                    $specialFare->updated_at = $request->input('updated_at');
                    $specialFare->save();
                } else {
                    // If the status has changed, update the necessary fields
                    if ($specialFare->status != $status) {
                        $specialFare->status = $status;
                        $specialFare->updated_by = Auth()->user()->name;
                        $specialFare->updated_at = now();
                        $specialFare->save();
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Special fares updated successfully.');
    }
    public function specialfaresUpdate(Request $request, $id)
    {
        $request->validate([
            'ticket_authorization' => 'nullable|boolean',
            'vfr_fares' => 'nullable|boolean',
            'to_fares' => 'nullable|boolean',
            'sme_fares' => 'nullable|boolean',
            'status' => 'required|boolean',
        ]);

        $specialFare = SpecialFare::findOrFail($id);
        $specialFare->update([
            'ticket_authorization' => $request->has('ticket_authorization') ? 1 : 0,
            'vfr_fares' => $request->has('vfr_fares') ? 1 : 0,
            'to_fares' => $request->has('to_fares') ? 1 : 0,
            'sme_fares' => $request->has('sme_fares') ? 1 : 0,
            'status' => $request->input('status'),
        ]);

        return redirect()->back()->with('success', 'Special fares updated successfully.');
    }

    public function rulesStore(Request $request)
    {
        $request->validate([
            'airline_id' => 'required|exists:airlines,id',
            'dos' => 'required|string',
            'donts' => 'required|string',
            'cancellation_policy' => 'required|string',
            'date_change_policy' => 'required|string',
        ]);

        Rule::create([
            'airline_id' => $request->input('airline_id'),
            'dos' => $request->input('dos'),
            'donts' => $request->input('donts'),
            'cancellation_policy' => $request->input('cancellation_policy'),
            'date_change_policy' => $request->input('date_change_policy'),
        ]);

        return redirect()->back()->with('success', 'Rules updated successfully.');
    }

    public function rulesUpdate(Request $request, $id)
    {
        $request->validate([
            'dos' => 'required|string',
            'donts' => 'required|string',
            'cancellation_policy' => 'required|string',
            'date_change_policy' => 'required|string',
        ]);

        $rule = Rule::findOrFail($id);
        $rule->update([
            'dos' => $request->input('dos'),
            'donts' => $request->input('donts'),
            'cancellation_policy' => $request->input('cancellation_policy'),
            'date_change_policy' => $request->input('date_change_policy'),
        ]);

        return redirect()->back()->with('success', 'Rules updated successfully.');
    }
    public function fleetUpdateStatus($id, Request $request)
    {
        // Find the Fleet record by ID
        $fleet = Fleet::findOrFail($id);

        // Toggle the status
        $fleet->status = ($fleet->status == 1) ? 2 : 1;
        $fleet->save();

        // Return a JSON response for AJAX requests
        if ($request->ajax()) {
            return response()->json(['success' => true, 'status' => $fleet->status]);
        }

        // Fallback for non-AJAX requests
        return redirect()->back()->with('success', 'Fleet status updated successfully.');
    }


    public function scheduleUpdateStatus($id, Request $request)
    {
        $data = Aircraft::findOrFail($id);


        $data->status = $data->status == 1 ? 2 : 1;
        $data->save();


        if ($request->ajax()) {
            return response()->json(['success' => true, 'status' => $data->status]);
        }


        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function librarystatusUpdate($id, Request $request)
    {
        // Find the record by ID
        $data = AirlineLibrary::findOrFail($id);

        // Toggle the status
        $data->status = ($data->status == 1) ? 2 : 1;
        $data->save();

        // Return a JSON response for AJAX requests
        if ($request->ajax()) {
            return response()->json(['success' => true, 'status' => $data->status]);
        }

        // Fallback for non-AJAX requests
        return redirect()->back()->with('success', 'Status updated successfully.');
    }


    public function rulesupdateStatus($id, Request $request)
    {
        // Find the rule by ID
        $rule = Rule::findOrFail($id);

        // Toggle the status
        $rule->status = ($rule->status == 1) ? 2 : 1;
        $rule->save();

        // Return a JSON response for AJAX requests
        if ($request->ajax()) {
            return response()->json(['success' => true, 'status' => $rule->status]);
        }

        // Fallback for non-AJAX requests
        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function specialfaresupdateStatus($id, Request $request)
    {


        // Find the record by ID
        $specialFare = SpecialFare::findOrFail($id);

        // Toggle the status
        $specialFare->status = ($specialFare->status == 1) ? 2 : 1;
        $specialFare->save();

        // Return a JSON response for AJAX requests
        if ($request->ajax()) {
            return response()->json(['success' => true, 'status' => $specialFare->status]);
        }

        // Fallback for non-AJAX requests
        return redirect()->back()->with('success', 'Status updated successfully.');
    }


    public function agreemenstStatusUpdate($id)
    {
        $agreement = Agreement::findOrFail($id);
        $agreement->status = $agreement->status == 1 ? 2 : 1;
        $agreement->save();
        // Return a JSON response for AJAX requests
        if ($request->ajax()) {
            return response()->json(['success' => true, 'status' => $specialFare->status]);
        }

        // Fallback for non-AJAX requests
        return redirect()->back()->with('success', 'Status updated successfully.');
    }


    public function agreementsStore(Request $request)
    {
        $request->validate([
            'airline_id' => 'required|integer',
            'agent_id' => 'required|integer',
            'incentive_description' => 'required|string|max:255',
            'term' => 'required|string|max:255',
            'agreement_status' => 'required|string|max:255',
        ]);

        Agreement::create([
            'airline_id' => $request->input('airline_id'),
            'agent_id' => $request->input('agent_id'),
            'incentive_description' => $request->input('incentive_description'),
            'term' => $request->input('term'),
            'agreement_status' => $request->input('agreement_status'),
            'type' => 'Agreement',
            'updated_at' => $request->input('updated_at'),
            'created_by' => Auth()->user()->name
        ]);

        return redirect()->back()->with('success', 'Rules updated successfully.');
    }



    public function agreementsUpdate(Request $request, $id)
    {
        $request->validate([
            'incentive_description' => 'required|string|max:255',
            'term' => 'required|string|max:255',
            'agreement_status' => 'required|string|max:255',
        ]);

        $agreement = Agreement::findOrFail($id);
        $agreement->update([
            'incentive_description' => $request->input('incentive_description'),
            'term' => $request->input('term'),
            'agreement_status' => $request->input('agreement_status'),
            'updated_by' => Auth()->user()->name

        ]);

        return redirect()->back()->with('success', 'Rules updated successfully.');
    }

    public function agreementsDestroy()
    {

        $agreement = Agreement::findOrFail($id);
        $agreement->update([
            'deleted_at' => now(),
            'remarks' => $request->input('remarks')
        ]);

        return redirect()->back();
    }

    public function pliStore(Request $request)
    {
        $request->validate([
            'airline_id' => 'required|integer',
            'agent_id' => 'required|integer',
            'incentive_description' => 'required|string|max:255',
            'term' => 'required|string|max:255',
            'target' => 'required|string|max:255',
            'businessclass_intl' => 'required|string|max:255',
            'businessclass_dom' => 'required|string|max:255',
            'premiumclass_intl' => 'required|string|max:255',
            'premiumclass_dom' => 'required|string|max:255',
            'economyclass_intl' => 'required|string|max:255',
            'economyclass_dom' => 'required|string|max:255',
            'valid_from' => 'required|string|max:255',
            'valid_till' => 'required|string|max:255',
        ]);

        Agreement::create([
            'airline_id' => $request->input('airline_id'),
            'agent_id' => $request->input('agent_id'),
            'incentive_description' => $request->input('incentive_description'),
            'term' => $request->input('term'),
            'target' => $request->input('target'),
            'businessclass_intl' => $request->input('businessclass_intl'),
            'businessclass_dom' => $request->input('businessclass_dom'),
            'premiumclass_intl' => $request->input('premiumclass_intl'),
            'premiumclass_dom' => $request->input('premiumclass_dom'),
            'economyclass_intl' => $request->input('economyclass_intl'),
            'economyclass_dom' => $request->input('economyclass_dom'),
            'valid_from' => $request->input('valid_from'),
            'valid_till' => $request->input('valid_till'),
            'type' => 'PLI',
            'updated_at' => $request->input('updated_at'),
            'created_by' => Auth()->user()->name

        ]);

        return redirect()->back()->with('success', 'Rules updated successfully.');
    }
}
