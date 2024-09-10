<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Airline;
use App\Models\Agent;
use App\Models\AgentAccount;
use App\Models\SpecialFare;
use Illuminate\Support\Facades\Auth;

class AgentReportController extends Controller
{
    public function airlineReport(Request $request)
    {
        $agents = Agent::all();
        $agent_id = $request->agent_id;
        $specialFares = SpecialFare::where('agent_id', $request->agent_id)
                        ->groupBy('airline_id')
                        ->get();
        $agent_account= AgentAccount::where('agent_id', $request->agent_id)->get();
        $agent_account_detail = AgentAccount::where('agent_id', $request->agent_id)->where('acc_no', '!=', "")->first();
                        
        return view('admin.agent-reports', compact('agents','agent_id','specialFares','agent_account','agent_account_detail'));
    }

}
