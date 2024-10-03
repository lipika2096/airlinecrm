<?php

namespace App\Http\Controllers;
use App\Models\WalletRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class BankController extends Controller
{
    public function index(){
        $userId = auth()->user()->id;
        $walletRequest = WalletRequest::where('user_id', $userId)->get();
        return view('wallet-request.index', compact('walletRequest'));
    }

    public function show($id){
        $walletDetail = WalletRequest::where('id', $id)->first();
        return view('wallet-request.view-wallet', compact('walletDetail'));
    }

    public function create(){
        return view('wallet-request.create');
    }

    public function store(Request $request){

        $userId = auth()->user()->id;
        WalletRequest::create([
            'payment_mode' => $request->input('payment_mode'),
            'amount' => $request->input('amount'),
            'bank_name' => $request->input('bank_name'),
            'bank_branch' => $request->input('bank_branch'),
            'user_id' => $userId,
            'bank_tran_id' => $request->input('bank_tran_id'),
            'status' => '2'
        ]);
        return redirect()->route('bank');
    }
}
