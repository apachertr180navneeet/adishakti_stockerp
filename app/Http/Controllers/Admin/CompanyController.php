<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
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

class CompanyController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user_data = auth()->user();

            $company_list = Company::get();

            return view('admin.company.company_list',compact('user_data','company_list'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }




    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();

            return view('admin.company.company_add',compact('user_data'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }


    public function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $datauser = [
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
        ];

        $id = Company::insertGetId($datauser);


        return redirect()->route('admin.company.list')->with('success','Company created successfully.');

    }

    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $user = Company::where('id', $id)->first();


            return view('admin.company.company_edit',compact('user_data','user'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $id = $request->id;
        $datauser = [
             'name' => $request->name,
             'address' => $request->address,
             'city' => $request->city,
             'state' => $request->state,
             'pincode' => $request->pincode,
        ];

        Company::where('id', $id)->update($datauser);



        return redirect()->route('admin.company.list')->with('success','Company Update successfully.');
    }

    public function delete($id)
    {
        $deleted = Company::where('id', $id)->delete();
        return response()->json(['success'=>'Company Deleted Successfully!']);
    }

    public function status(Request $request){

        $id = $request->id;
        $datauser = [
             'status' => $request->status,
        ];


        Company::where('id', $id)->update($datauser);


        return response()->json(['success'=>'Company Status Changes Successfully!']);
    }
}
