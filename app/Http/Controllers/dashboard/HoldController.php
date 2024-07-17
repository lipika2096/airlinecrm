<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;

use App\Models\Wallet;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookMail;
use App\Mail\ConfirmHold;
use \PDF;
use Carbon\Carbon;

class HoldController extends Controller
{


    public function index(Request $request)
    {


        return view('admin.agent-hold');
    }

    public function confirmIndex(Request $request)
    {


        return view('admin.confirm-agent');
    }


    public function view(Request $request, $id)
    {
        $result = [];
        $result = Book::where('parent_id', $id)->orderby('id', 'desc')->paginate(10);

        $flight = Book::where('id', $id)->first();

        return view('admin.hold.view')->with(compact('result', 'flight'));
    }

    public function confirmView(Request $request)
    {

        return view('admin.confirm.view');
    }


    public function edit(Request $request, $id)
    {
        $result = [];
        $data = Book::where('id', $id)->first();
        return view('admin.hold.edit')->with(compact('data'));
    }

    public function confirmEdit(Request $request, $id)
    {
        $result = [];
        $data = Book::where('id', $id)->first();
        return view('admin.confirm.edit')->with(compact('data'));
    }



    public function update(Request $request, $id)
    {
        $result = [];
        $hold = Book::where('id', $id)->first();
        if(!$hold){
            return redirect()->back()->with('error', 'Hold Details Not Found');
        }

        $hold->fname = $request->fname ?? $hold->fname;
        $hold->lname = $request->lname ?? $hold->lname;
        $hold->title = $request->title ?? $hold->title;
        $hold->dob = $request->dob ?? $hold->dob;
        $hold->save();

        if($hold->status == 'active'){
            $parent = Book::where('id', $hold->parent_id)->first();
            $bookID = $parent->book_id;
            $passanger = Book::where('parent_id', $hold->parent_id)->get();
            $infant = Inventory::with('origin', 'destination')->where('id', $hold->invent_id)->first();

            $bookID = 'HOLD'.$parent->id;

            $mailData =[
                'infant' => $infant,
                'passanger' => $passanger,
                'bookID' => $bookID
            ];

            $name = basename($parent->file);

            if(File::exists(public_path('/user/pdf/').$name)){
                File::delete(public_path('/user/pdf/').$name);
            }

            $pdf = PDF::loadView('pdf.book', $mailData)->setPaper('a4', 'portrait');
            $path = $bookID.'-flight.pdf';
            $pdf->save(public_path('/user/pdf/'.$path));
            $parent->file = $path;
            $parent->save();
        }

        return redirect()->back()->with('success', 'Hold Details Update Successfully');
    }



    public function confirmUpdate(Request $request, $id)
    {
        $result = [];
        $hold = Book::where('id', $id)->first();
        if(!$hold){
            return redirect()->back()->with('error', 'Hold Details Not Found');
        }

        $hold->fname = $request->fname ?? $hold->fname;
        $hold->lname = $request->lname ?? $hold->lname;
        $hold->title = $request->title ?? $hold->title;
        $hold->dob = $request->dob ?? $hold->dob;
        $hold->save();

        if($hold->status == 'active'){
            $parent = Book::where('id', $hold->parent_id)->first();
            $bookID = $parent->book_id;
            $passanger = Book::where('parent_id', $hold->parent_id)->get();
            $infant = Inventory::with('origin', 'destination')->where('id', $hold->invent_id)->first();

            $bookID = 'HOLD'.$parent->id;

            $mailData =[
                'infant' => $infant,
                'passanger' => $passanger,
                'bookID' => $bookID
            ];

            $name = basename($parent->file);

            if(File::exists(public_path('/user/pdf/').$name)){
                File::delete(public_path('/user/pdf/').$name);
            }

            $pdf = PDF::loadView('pdf.book', $mailData)->setPaper('a4', 'portrait');
            $path = $bookID.'-flight.pdf';
            $pdf->save(public_path('/user/pdf/'.$path));
            $parent->file = $path;
            $parent->save();
        }

        return redirect()->back()->with('success', 'Hold Details Update Successfully');
    }

    public function confirmHold(Request $request){



        return view('admin.confirm-agent');
    }

    public function cancelHold(Request $request, $id){

        $hold = Book::where('id',$id)->first();


        $childCount = Book::where('parent_id',$id)->count();
        $infant = Inventory::where('id', $hold->invent_id)->first();
        $totleAvailabilty = $infant->availabilty + $childCount;
        $infant->availabilty = $totleAvailabilty;
        $infant->save();
        $hold->delete();
        $child = Book::where('parent_id',$id)->delete();

        return redirect()->back()->with('success', 'Hold Cancel Successfully');
    }

    public function releaseIndex(Request $request){

        $result = [];
        $data = [];

        $query = Inventory::query();

        if ($request->has('invent_id') && !empty($request->get('invent_id'))) {
            $sector = $query->where('id', $request->invent_id)->first();
            if($sector){
                $query->where('origin_id', $sector->origin_id)->where('destination_id', $sector->destination_id)->paginate();
            }
        }

        if ($request->has('availabilty') && !empty($request->get('availabilty'))) {
            if($request->availabilty == 1 ){
                $data['page_title'] = 'All Sold Inventory';
                $query->where('availabilty', '=', 0);
            }else{
               $query->where('availabilty', '!=', 0);
            }
        }

        $result = $query->with('infant', 'airline', 'destination', 'origin')->orderby('id', 'desc')->paginate(10);
        $sector = Inventory::get();
        $sectors = $sector->unique('origin_id');
        return view('admin.release.index')->with(compact('result', 'sectors', 'data'));

    }

    public function viewRelease(Request $request, $id){


        $result = Inventory::with('origin', 'destination', 'airline')->where('id', $id)->first();

        return view('admin.release.add')->with(compact( 'result'));
    }


    public function storeRelease(Request $request){
        $requestData = $request->all();
        $array = [];
        $query = Inventory::query();
        $holdDateCheck = $query->where('id', $requestData['invent_id'])
                ->whereDate('departure_date_from', Carbon::tomorrow())
                ->whereTime('departure_time','<',date('H:i'))
                ->first();

        if($holdDateCheck){
            return redirect()->back()->with('error', 'This Inventory Not Available To Hold Only Booking Available');
        }

        for($x = 1; $x <= (int)$request->person; $x++){
            array_push($array, $x);
        }

        $lastProject =  Book::orderBy('id', 'desc')->first();

        if (isset($lastProject)) {
            $holdID = 'H0000'.($lastProject->id + 1);
            } else {
            $holdID = 'H00001';
        }

        $infant = Inventory::with('origin','destination')->where('id', $requestData['invent_id'])->first();
        $adult = $requestData['person'] ?? 0;
        $availabilty = (int)$adult ;

        if($requestData['availabilty'] < $availabilty){
            return redirect()->back()->with('error', 'Availabilty Not Available.');
        }

        $hold = new Book();
        $hold->user_id = Auth::id();
        $hold->invent_id = $requestData['invent_id'];
        $hold->book_id = $holdID;
        $hold->remark = $requestData['message'];
        $hold->adult = $requestData['person'] ?? 0;
        $hold->child =  0;
        $hold->infant = 0;
        $hold->email = $requestData['email'];
        $hold->status = 'pending';
        $hold->save();
        $parentId = $hold->id;

        foreach($array as $arr) {

            $hold = new Book();
            $hold->user_id = Auth::id();
            $hold->invent_id = $requestData['invent_id'];
            $hold->book_id = $holdID;
            $hold->remark = $requestData['message'];
            $hold->parent_id = $parentId;
            $hold->title = 'Mr';
            $hold->fname = 'ADMIN';
            $hold->lname = 'ADMIN';
            $hold->email = $requestData['email'];
            $hold->dob =  date('Y-m-d');
            $hold->adult = $requestData['person'];
            $hold->status = 'pending';
            $hold->save();
        }

        $infant = Inventory::where('id', $requestData['invent_id'])->first();
        $adult = $requestData['person'] ?? 0;
        $availabilty = (int)$adult ;
        $totleAvailabilty = $infant->availabilty - $availabilty;
        $infant->availabilty = $totleAvailabilty;
        $infant->save();

        $totelFair = (int)$infant->sale_rate * $availabilty;
        $holdUpdateFair = Book::where('id', $parentId)->first();
        $holdUpdateFair->fair = $totelFair;
        $holdUpdateFair->save();

        return redirect()->back()->with('success', 'Inventory Hold Successfully');
    }

}
