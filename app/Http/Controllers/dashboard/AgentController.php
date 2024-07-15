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

class AgentController extends Controller
{
    public function index()
    {
        $designation = Designation::latest()->get();
        $agents = Client::join('users', 'users.clientid', '=', 'clients.client_id')
                        ->get(['clients.*', 'users.*']);
        return view('admin.agent', compact('agents', 'designation'));
    }

    public function store(Request $request)
    {
        try {
            // Create a new client record
            $client = new Client();
            $client->client_creatorid = 0;
            $client->client_categoryid = 2;
            $client->client_created_from_leadid = 0;
            $client->client_company_name = "CRM";
            $client->client_billing_street = $request->client_billing_street;
            $client->client_phone = $request->client_phone;
            $client->client_billing_city = $request->client_billing_city;
            $client->client_billing_state = $request->client_billing_state;
            $client->client_billing_country = $request->client_billing_country;
            $client->client_billing_zip = $request->client_billing_zip;
            $client->client_custom_field_4 = $request->client_custom_field_4;
            $client->client_custom_field_2 = $request->client_custom_field_2;
            $client->client_custom_field_3 = $request->client_custom_field_3;
            $client->client_custom_field_1 = $request->client_custom_field_1;
            $client->save();

            // Create a new user record
            $user = new User();
            $user->clientid = $client->client_id;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->unique_id = $request->employee_id;
            $user->phone = $request->phone;
            $user->joining_date = $request->joining_date;
            $user->position = $request->designation;
            $user->account_owner = 'yes';
            $user->primary_admin = 'no';
            $user->type = 'client';

            // Handle image upload
            if ($request->hasFile('avatar_filename')) {
                $image = $request->file('avatar_filename');
                $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('public/agent_images', $imageName);
                $user->avatar_filename = $imageName;
            }

            $user->save();

            return redirect()->route('admin.agents')->with('success', 'Agent added successfully');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error adding agent: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error adding the agent. Please try again.');
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            // Find the user record
            $user = User::findOrFail($id);

            // Handle image upload
            if ($request->hasFile('avatar_filename')) {
                // Delete old image if exists
                if ($user->avatar_filename) {
                    Storage::delete('public/agent_images/' . $user->avatar_filename);
                }

                // Upload new image
                $image = $request->file('avatar_filename');
                $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('public/agent_images', $imageName);

                // Save image path to database
                $user->avatar_filename = $imageName;
            }

            // Update other fields
            $user->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'unique_id' => $request->input('employee_id'),
                'phone' => $request->input('phone'),
                'position' => $request->input('designation'),
            ]);

            return redirect()->route('admin.agents')->with('success', 'Agent updated successfully');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error updating agent: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error updating the agent. Please try again.');
        }
    }


    public function view($id)
    {

        $agent = User::find($id);

        if (!$agent) {
            return redirect()->route('admin.agents')->with('error', 'Agent not found.');
        }


        $client = Client::find($agent->clientid);

        if (!$client) {
            return redirect()->route('admin.agents')->with('error', 'Client not found.');
        }


        $airline = Airline::all();
        $designation = Designation::all();
        $fareConditions = FareCondition::where('agent_id', $id)->get();
        $group = Group::where('agent_id', $id)->get();
        $commissions = Commission::all();
        $agents = User::all();
        $airlines = Airline::all();


        $wallets = Wallet::where('agent_id', $id)->get();


        $walletRequests = WalletRequest::where('user_id', $id)->get();


        $tickets = Ticket::where('ticket_clientid', $id)->get();
        $airtickets = AirTicket::where('agent_id', $id)->get();

        return view('admin.view-agent', compact('agent', 'client', 'designation', 'group', 'airline', 'fareConditions', 'agents', 'airlines', 'commissions', 'wallets', 'walletRequests', 'tickets', 'airtickets'));
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



