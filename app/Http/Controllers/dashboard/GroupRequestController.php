<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\GroupRequest;

class GroupRequestController extends Controller
{
    //
    public function index(){
        $groupRequest = GroupRequest::where('request_status',1)->get();
        return view('admin.open-request', compact('groupRequest'));
    }

    public function confirm(){
        $confirmRequest = GroupRequest::where('request_status',2)->get();
        return view('admin.confirm-request', compact('confirmRequest'));
    }

    public function search(Request $request){
        // dd($request);
        $groupRequest = GroupRequest::where('request_id',$request->input('query'))->get();
        // dd($groupRequest);
        return view('admin.open-request', compact('groupRequest'));
    }

    public function confirmsearch(){
        $confirmRequest = GroupRequest::where('request_id',$request->input('query'))->get();
        return view('admin.confirm-request', compact('confirmRequest'));
    }
}
