<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WalletRequest;




class WalletRequestController extends Controller
{
    public function index()
    {
        $walletRequests = WalletRequest::latest()->get();
        return view('admin.wallet-requests', compact('walletRequests'));
    }

}
