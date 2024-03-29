<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    User_detail
};


use Exception;
use DB;
use Illuminate\Http\Request;





use Illuminate\Support\Facades\{
    Auth,
    Hash,
    Session,
    Storage
};

class VendorController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user_data = auth()->user();

            $vendor_list = User::where('type', '1')->select('users.id','users.status','users.name','users.email','users.phone_number')->join('user_detail', 'users.id', '=', 'user_detail.user_id')->paginate(10);

            return view('admin.vendor.vendor_list',compact('user_data','vendor_list'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }




    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();

            return view('admin.vendor.vendor_add',compact('user_data'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }


    public function store(Request $request){

        // $validatedData = $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users',
        //     'phone_number' => 'required|numeric',
        //     'address' => 'required',
        //     'city' => 'required',
        //     'state' => 'required',
        //     'password' => 'required'
        // ]);

        $datauser = [
             'name' => $request->name,
             'email' => $request->email,
             'phone_number' => $request->phone_number,
             'password' => Hash::make('12345678'),
             'type'=> '1',
        ];
        // dd($datauser);

        $id = User::insertGetId($datauser);

        $datauserdetail = [
            'user_id' => $id    ,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'gender' => $request->gender,
        ];

        User_detail::create($datauserdetail);

        return redirect()->route('admin.vendor.list')->with('success','Vendor created successfully.');

    }


    public function view($id){
        if(Auth::check()){
            $user_data = auth()->user();

            $user_detail = User::where('id', $id)->join('user_detail', 'users.id', '=', 'user_detail.user_id')->first();

            return view('admin.vendor.vendor_detail',compact('user_data','user_detail'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }

    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $user = User::where('id', $id)->join('user_detail', 'users.id', '=', 'user_detail.user_id')->first();


            return view('admin.vendor.vendor_edit',compact('user_data','user'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required|numeric',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required'
        ]);

        $id = $request->id;
        $datauser = [
             'name' => $request->name,
             'email' => $request->email,
             'phone_number' => $request->phone_number,
        ];

        User::where('id', $id)->update($datauser);

        $datauserdetail = [
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'gender' => $request->gender,
        ];

        User_detail::where('user_id', $id)->update($datauserdetail);



        return redirect()->route('admin.vendor.list')->with('success','Vendor Update successfully.');
    }

    public function delete($id)
    {
        $deleteduserdetail = User_detail::where('user_id', $id)->delete();

        $deleted = User::where('id', $id)->delete();
        return response()->json(['success'=>'Vendor Deleted Successfully!']);
    }

    public function status(Request $request){

        $id = $request->id;
        $datauser = [
             'status' => $request->status,
        ];


        User::where('id', $id)->update($datauser);


        return response()->json(['success'=>'Vendor Status Changes Successfully!']);
    }
}

