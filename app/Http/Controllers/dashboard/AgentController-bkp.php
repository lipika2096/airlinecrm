<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use App\Models\Designation;
use App\Models\Group;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Airline;
use App\Models\Commission;
use App\Models\Wallet;
use App\Models\WalletRequest;
use App\Models\FareCondition;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Ticket;
use App\Models\AirTicket;
use App\Models\Agent;
use App\Models\AgentAccount;
use App\Models\AgentProvisionsPli;
use App\Models\AgentProductsType;
use App\Models\AgentConversation;
use App\Models\AgentAddress;
use App\Models\HeadOfficeContactDetail;
use App\Models\SpecialFare;
use App\Models\FareType;
use App\Models\CaseHistory;
use App\Models\CaseUpdate;
use Carbon\Carbon;


class AgentController extends Controller
{
    public function index()
    {
        $designation = Designation::latest()->get();
        $agents = Agent::get();
        return view('admin.agent', compact('agents', 'designation'));
    }

    public function update($id)
    {
        $designation = Designation::latest()->get();
        $agent = Agent::find($id);
        $agentAccounts = AgentAccount::where('agent_id', $id)->get();
        $agentPli = AgentProvisionsPli::latest()->whereNotNull('pli')->where('agent_id', $id)->get();
        $agentProv = AgentProvisionsPli::latest()->whereNotNull('prov')->where('agent_id', $id)->get();
        $agentTarget = AgentProvisionsPli::latest()->whereNotNull('target')->where('agent_id', $id)->get();
        $agentProduct = AgentProductsType::latest()->where('agent_id', $id)->get();
        $agentConversation = AgentConversation::latest()->get();
        return view('admin.edit-agent', compact('agent', 'designation', 'agentAccounts','agentPli','agentProv','agentTarget','agentProduct','agentConversation'));
    }

    public function store(Request $request)
{
    try {

        $agent = new Agent();
        $agent->company_name = $request->company_name;
        $agent->email = $request->email;
        $agent->agency_name = $request->agency_name;
        $agent->address = $request->address;
        $agent->city = $request->city;
        $agent->state = $request->state;
        $agent->country = $request->country;
        $agent->pincode = $request->pincode;
        $agent->owner_name = $request->owner_name;

        // Store focus destinations as a JSON-encoded string
        $agent->focus_destinations = json_encode($request->focus_destinations);
        $agent->parent_company = $request->parent_company;
        $agent->headquarters = $request->headquarters;
        $agent->key_people = $request->key_people;
        $agent->websites = $request->websites;
        $agent->no_of_employees = $request->no_of_employees;
        $agent->iata = $request->iata;
        $agent->gds_type = $request->gds_type;
        $agent->pcc_office_id = $request->pcc_office_id; // Assuming office phone is the same as the provided phone
        $agent->business_mode = $request->business_mode;
        $agent->discount = $request->discount;
        $agent->remarks = $request->remarks;
        $agent->account_code = $request->account_code;
// dd($agent);
        $agent->save();
        return redirect()->route('admin.agents')->with('success', 'Agent added successfully');
    } catch (\Exception $e) {
        // Log the error message
        Log::error('Error adding agent: ' . $e->getMessage());
        return redirect()->back()->with('error', 'There was an error adding the agent. Please try again.');
    }
}

public function caseStore(Request $request)
    {
        $validatedData = $request->validate([
            'case_opening_date' => 'required|date',
            'opened_by' => 'required|string|max:255',
            'pnr' => 'required|string|max:255',
            'case_status' => 'required|string|max:255',
            'case_closed_by' => 'nullable|string|max:255',
            'case_closing_date' => 'nullable|date',
            'agent_id' => 'required|integer',
        ]);

        $airline = CaseHistory::create($validatedData);

        return redirect()->back()->with('success', 'Special fares updated successfully.');
    }


    // Update the case based on the form submission
    public function caseUpdate(Request $request)
    {
        $case = CaseHistory::findOrFail($request->input('caseId'));

        $request->validate([
            'status' => 'required|string|in:Update,Close',
            'comments' => 'required|string|max:1000',
        ]);

        // Add the new update to the case_updates table
        CaseUpdate::create([
            'case_id' => $case->id,
            'update_date' => Carbon::now(),
            'updated_by' => auth('admin')->user()->name, // Assuming user is authenticated
            'comments' => $request->comments,
            'status' => $request->status,
        ]);

        // Update the case status and other relevant fields if closing the case
        if ($request->status === 'Close') {
            $case->update([
                'case_status' => 'Closed',
                'case_closed_by' => auth('admin')->user()->name,
                'case_closing_date' => Carbon::now(),
            ]);
        } else {
            $case->update(['case_status' => 'Updated']);
        }

        return redirect()->back()->with('success', 'Special fares updated successfully.');
    }

    // Close the case
    public function caseClose(Request $request)
    {
        $case = CaseHistory::findOrFail($request->input('caseId'));

        $request->validate([
            'comments' => 'required|string|max:1000',
        ]);

        // Update the case status to closed and record closing comments
        CaseUpdate::create([
            'case_id' => $case->id,
            'update_date' => Carbon::now(),
            'updated_by' => auth('admin')->user()->name,
            'comments' => $request->comments,
            'status' => 'Closed',
        ]);

        $case->update([
            'case_status' => 'Closed',
            'case_closed_by' => auth('admin')->user()->name,
            'case_closing_date' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Special fares updated successfully.');
    }
public function targetStore(Request $request)
{
    foreach ($request->input('airline') as $airlineId => $fareTypes) {
        foreach ($fareTypes as $fareType => $status) {

            SpecialFare::updateOrCreate(
                [
                    'agent_id' => $request->input('agent_id'),
                    'fare_type' => $fareType,
                    'airline_id' => $airlineId
                ],
                [
                    'status' => $status
                ]
            );
        }
    }

    return redirect()->back()->with('success', 'Special fares updated successfully.');
}

    public function pliStore(Request $request){
        AgentProvisionsPli::create([
            'agent_id' => $request->input('agent_id'),
            'pli' => $request->input('pli'),
            'business' => $request->input('business'),
            'pre_economy' => $request->input('pre_economy'),
            'economy' => $request->input('economy'),
            'valid_from_to' => $request->input('valid_from_to')
        ]);
        return redirect()->back();
    }

    public function provStore(Request $request){
        AgentProvisionsPli::create([
            'agent_id' => $request->input('agent_id'),
            'prov' => $request->input('prov'),
            'business' => $request->input('business'),
            'pre_economy' => $request->input('pre_economy'),
            'economy' => $request->input('economy'),
            'valid_from_to' => $request->input('valid_from_to')
        ]);
        return redirect()->back();

    }

    public function transactionStore(Request $request){
        AgentAccount::create([
            'agent_id' => $request->input('agent_id'),
            'debit' => $request->input('debit'),
            'credit' => $request->input('credit'),
            'tr_date' => $request->input('tr_date'),
            'tr_type' => $request->input('tr_type'),
        ]);
        return redirect()->back();

    }
    public function productStore(Request $request){
        AgentProductsType::create([
            'agent_id' => $request->input('agent_id'),
            'product_type' => $request->input('product_type')
        ]);
        return redirect()->back();

    }

    public function productUpdate(Request $request, $id){
        $prod = AgentProductsType::find($id);
        $prod->update([
            'agent_id' => $request->input('agent_id'),
            'product_type' => $request->input('product_type')
        ]);
        return redirect()->back();

    }
    public function contactUpdate(Request $request, $id){
        $prod = Agent::find($id);
        $prod->update([
            'phone' => $request->input('phone'),
            'emergency_phone' => $request->input('emergency_phone'),
            'office_phone' => $request->input('office_number'),
        ]);
        return redirect()->back();

    }
    public function ContactStore(Request $request){
        HeadOfficeContactDetail::create([
            'title' => $request->input('title'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email_address' => $request->input('email_address'),
            'phone_number' => $request->input('phone_number'),
            'position' => $request->input('position'),
            'agent_id' => $request->input('agent_id'),
        ]);
        return redirect()->back();

    }
    public function AddressStore(Request $request){
        AgentAddress::create([
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'street' => $request->input('street'),
            'country' => $request->input('country'),
            'pincode' => $request->input('pincode'),
            'agent_id' => $request->input('agent_id'),
        ]);
        return redirect()->back();

    }

    public function addressUpdate(Request $request, $id){
        $prod = Agent::find($id);
        $prod->update([
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'street' => $request->input('street'),
            'country' => $request->input('country'),
            'pincode' => $request->input('pincode'),
        ]);
        return redirect()->back();

    }
    public function generalUpdate(Request $request, $id){
        $prod = Agent::find($id);
        $prod->update([
            'city' => $request->input('city'),
            'agency_name' => $request->input('agency_name'),
            'address' => $request->input('address'),
            'country' => $request->input('country'),
            'pincode' => $request->input('pincode'),
            'iata' => $request->input('iata'),
            'gds_type' => $request->input('gds_type'),
            'pcc_office_id' => $request->input('pcc_office_id'),
            'business_mode' => $request->input('business_mode'),
            'focus_destinations' => $request->input('focus_destinations'),
            'key_people' => $request->input('key_people'),
            'parent_company' => $request->input('parent_company'),
            'headquarters' => $request->input('headquarters'),
            'website' => $request->input('website'),
            'no_of_employees' => $request->input('no_of_employees'),
        ]);
        return redirect()->back();

    }

    public function conversationStore(Request $request){
        AgentConversation::create([
            'from' => $request->input('from'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'c_date' => now()
        ]);
        return redirect()->back();

    }

    public function targetUpdate(Request $request, $id){
        $target = AgentProvisionsPli::find($id);
        $target->update([
            'agent_id' => $request->input('agent_id'),
            'target' => $request->input('target'),
            'business' => $request->input('business'),
            'pre_economy' => $request->input('pre_economy'),
            'economy' => $request->input('economy'),
        ]);
        return redirect()->back();
    }

    public function pliUpdate(Request $request, $id){
        $pli = AgentProvisionsPli::find($id);
        $pli->update([
            'agent_id' => $request->input('agent_id'),
            'pli' => $request->input('pli'),
            'business' => $request->input('business'),
            'pre_economy' => $request->input('pre_economy'),
            'economy' => $request->input('economy'),
            'valid_from_to' => $request->input('valid_from_to')
        ]);
        return redirect()->back();
    }

    public function provUpdate(Request $request, $id){
        $prov = AgentProvisionsPli::find($id);
        $prov->update([
            'agent_id' => $request->input('agent_id'),
            'prov' => $request->input('prov'),
            'business' => $request->input('business'),
            'pre_economy' => $request->input('pre_economy'),
            'economy' => $request->input('economy'),
            'valid_from_to' => $request->input('valid_from_to')
        ]);
        return redirect()->back();

    }

    public function transactionUpdate(Request $request, $id){
        $tr = AgentAccount::find($id);
        $tr->update([
            'agent_id' => $request->input('agent_id'),
            'debit' => $request->input('debit'),
            'credit' => $request->input('credit'),
            'tr_date' => $request->input('tr_date'),
            'tr_type' => $request->input('tr_type')
        ]);
        return redirect()->back();

    }

    public function edit(Request $request, $id)
    {
        try {
            // Find the client and user records to update
            $agent = Agent::find($id);

            $agent->first_name = $request->first_name;
            $agent->last_name = $request->last_name;
            $agent->email = $request->email;
            $agent->agency_name = $request->agency_name;
            $agent->phone = $request->phone;
            $agent->emergency_phone = $request->emergency_phone;
            $agent->address = $request->address;
            $agent->city = $request->city;
            $agent->state = $request->state;
            $agent->country = $request->country;
            $agent->pincode = $request->pincode;
            $agent->owner_name = $request->owner_name;
            $agent->gst = $request->gst;
            $agent->pancard = $request->pancard;
            $agent->save();

            return redirect()->route('admin.agents')->with('success', 'Agent updated successfully');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error updating agent: '. $e->getMessage());
            return redirect()->back()->with('error', 'There was an error updating the agent. Please try again.');
        }
    }

    public function view(Request $request, $id)
    {

        $agent = Agent::find($id);
        $agentAccounts = AgentAccount::where('agent_id', $id)->get();
        $agentPli = AgentProvisionsPli::latest()->whereNotNull('pli')->where('agent_id', $id)->get();
        $agentProv = AgentProvisionsPli::latest()->whereNotNull('prov')->where('agent_id', $id)->get();
        $agentTarget = AgentProvisionsPli::latest()->whereNotNull('target')->where('agent_id', $id)->get();
        $agentProduct = AgentProductsType::latest()->where('agent_id', $id)->get();
        $agentConversation = AgentConversation::latest()->get();
        $agentAddress = AgentAddress::where('agent_id', $id)->get();
        $agentContact = HeadOfficeContactDetail::where('agent_id', $id)->get();
        $specialFare = SpecialFare::where('agent_id', $id)->get();
        $caseData = CaseHistory::where('agent_id', $id)->get();

        $fareType = FareType::get();
        if (!$agent) {
            return redirect()->route('admin.agents')->with('error', 'Agent not found.');
        }

        $client = Agent::find($id);

        if (!$client) {
            return redirect()->route('admin.agents')->with('error', 'Client not found.');
        }


        $airline = Airline::all();
        $designation = Designation::all();
        $fareConditions = FareCondition::where('agent_id', $id)->get();
        $group = Group::where('agent_id', $id)->get();
        $commissions = Commission::all();
        $agents = Agent::where('deleted_at', 'null')->get();
        $airlines = Airline::all();


        $wallets = Wallet::where('agent_id', $id)->get();


        $walletRequests = WalletRequest::where('user_id', $id)->get();


        $tickets = Ticket::where('ticket_clientid', $id)->get();
        $airtickets = AirTicket::where('agent_id', $id)->get();

        return view('admin.view-agent', compact('agent', 'client', 'designation', 'group', 'airline', 'fareConditions', 'agents', 'airlines', 'commissions', 'wallets', 'walletRequests', 'tickets', 'airtickets','agentAccounts', 'agentProv', 'agentPli', 'agentTarget','agentConversation','agentProduct', 'agentAddress','agentContact','specialFare','fareType','caseData'));
    }

    public function storeWallet(Request $request)
    {
        try {
            $request->validate([
                'agent_id' => 'required',
                'payment' => 'required|numeric',
                'description' => 'required',
                'date' => 'required|date',
            ]);

            // Check if there's already a primary wallet entry for the agent
            $primaryWallet = Wallet::where('agent_id', $request->agent_id)->where('parent_id', '')->first();

            if ($primaryWallet) {
                // Update existing primary wallet
                $primaryWallet->wallet += (int)$request->payment;
                $primaryWallet->available_balance = $primaryWallet->wallet;
                $primaryWallet->description = $request->description;
                $primaryWallet->date = $request->date;
                $primaryWallet->status = 'credit';
                $primaryWallet->save();

                // Create a new secondary wallet entry
                $secondaryWallet = new Wallet();
                $secondaryWallet->agent_id = $request->agent_id;
                $secondaryWallet->wallet = $request->payment;
                $secondaryWallet->available_balance = $primaryWallet->available_balance;
                $secondaryWallet->description = $request->description;
                $secondaryWallet->date = $request->date;
                $secondaryWallet->status = 'credit';
                $secondaryWallet->parent_id = $primaryWallet->id;
                $secondaryWallet->save();
            } else {
                // Create a new primary wallet entry
                $primaryWallet = new Wallet();
                $primaryWallet->agent_id = $request->agent_id;
                $primaryWallet->wallet = $request->payment;
                $primaryWallet->available_balance = $request->payment;
                $primaryWallet->description = $request->description;
                $primaryWallet->date = $request->date;
                $primaryWallet->status = 'credit';
                $primaryWallet->save();

                // Create a new secondary wallet entry
                $secondaryWallet = new Wallet();
                $secondaryWallet->agent_id = $request->agent_id;
                $secondaryWallet->wallet = $request->payment;
                $secondaryWallet->available_balance = $request->payment;
                $secondaryWallet->description = $request->description;
                $secondaryWallet->date = $request->date;
                $secondaryWallet->status = 'credit';
                $secondaryWallet->parent_id = $primaryWallet->id;
                $secondaryWallet->save();
            }

            return redirect()->route('wallets')->with('success', 'Wallet added successfully');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error adding wallet: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add wallet. Please try again.');
        }
    }

    public function deleteWalletRequest($id)
    {
        // Find the wallet request by ID and delete it
        $walletRequest = WalletRequest::find($id);

        if ($walletRequest) {
            $walletRequest->delete();
            return redirect()->back()->with('success', 'Wallet request deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Wallet request not found.');
        }
    }

    public function deleteWallet(Request $request)
    {
        try {
            $wallet = Wallet::find($request->wallet_id);

            if (!$wallet) {
                return redirect()->back()->with('error', 'Wallet entry not found.');
            }

            $wallet->delete();

            return redirect()->back()->with('success', 'Wallet entry deleted successfully.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error deleting wallet entry: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete wallet entry. Please try again.');
        }
    }

    public function groupstore(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'airline_id' => 'required|integer', // Adjust validation as per your database schema
            'agent_id' => 'required|integer',   // Adjust validation as per your database schema
            // Add other fields as needed
        ]);

        // Create a new group record
        $group = Group::create($validatedData);

        return redirect()->back()->with('success', 'Group added successfully.');

    }

    public function groupupdate(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'airline_id' => 'sometimes|required|integer',
            'agent_id' => 'sometimes|required|integer',
            // Add other fields as needed
        ]);

        // Find the group record by ID
        $group = Group::findOrFail($id);

        // Update the group record with validated data
        $group->update($validatedData);

        // Return a response
        return redirect()->back()->with('success', 'Group updated successfully');
    }

}
