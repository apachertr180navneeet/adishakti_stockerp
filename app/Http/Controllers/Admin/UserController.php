<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    User_detail,
    Company
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

class UserController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user_data = auth()->user();

            $user_list = User::where('type', '2')->select('users.id','users.status','users.name','users.email','users.phone_number','company.name As branchname')->join('user_detail', 'users.id', '=', 'user_detail.user_id')->join('company', 'users.branch_id', '=', 'company.id')->get();

            return view('admin.user.user_list',compact('user_data','user_list'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }




    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();

            $branch_list = Company::orderBy('name')->get();

            return view('admin.user.user_add',compact('user_data','branch_list'));
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
             'branch_id' => $request->branch_id,
             'password' => Hash::make($request->password),
             'type'=> '2',
        ];

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

        return redirect()->route('admin.user.list')->with('success','user created successfully.');

    }


    public function view($id){
        if(Auth::check()){
            $user_data = auth()->user();

            $user_detail = User::where('id', $id)->join('user_detail', 'users.id', '=', 'user_detail.user_id')->first();

            return view('admin.user.user_detail',compact('user_data','user_detail'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }

    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $branch_list = Company::orderBy('name')->get();
            $user = User::where('id', $id)->join('user_detail', 'users.id', '=', 'user_detail.user_id')->first();


            return view('admin.user.user_edit',compact('user_data','user','branch_list'));
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
             'password' => $request->password,
             'branch_id' => $request->branch_id,
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



        return redirect()->route('admin.user.list')->with('success','user Update successfully.');
    }

    public function delete($id)
    {
        $deleteduserdetail = User_detail::where('user_id', $id)->delete();

        $deleted = User::where('id', $id)->delete();
        return response()->json(['success'=>'user Deleted Successfully!']);
    }

    public function status(Request $request){

        $id = $request->id;
        $datauser = [
             'status' => $request->status,
        ];


        User::where('id', $id)->update($datauser);


        return response()->json(['success'=>'user Status Changes Successfully!']);
    }
}
