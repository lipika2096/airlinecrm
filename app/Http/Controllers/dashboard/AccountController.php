<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use App\Models\AgentAccount;
use App\Models\Agent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    public function account()
    {
        $accounts = AgentAccount::where('acc_no' ,'!=', NULL)->with('agent')->get();
        $agents = Agent::where('deleted_at', 'null')->get();
        return view('admin.add-account', compact('accounts','agents'));
    }

    public function viewAccount()
    {
        $accounts = AgentAccount::where('acc_no' ,'!=', NULL)->with('agent')->get();
        $agents = Agent::where('deleted_at', 'null')->get();
        return view('admin.view-accounts', compact('accounts','agents'));
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

    public function viewInvoice($id)
    {
        $account = AgentAccount::findorFail($id);
        $creditamount = AgentAccount::where('agent_id', $account->agent_id)->sum('credit');
        $debitamount = AgentAccount::where('agent_id', $account->agent_id)->sum('debit');
        $newbalance = AgentAccount::where('agent_id', $account->agent_id)->latest()->first();
        return view('admin.account-invoice-view', compact('account', 'debitamount', 'creditamount', 'newbalance'));
    }


}
