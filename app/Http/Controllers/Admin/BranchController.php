<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    Branch
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

class BranchController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user_data = auth()->user();

            $branch_list = Branch::paginate(10);
            
            return view('admin.branch.branch_list',compact('user_data','branch_list'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }




    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();
            
            return view('admin.branch.branch_add',compact('user_data'));
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

        $id = Branch::insertGetId($datauser);


        return redirect()->route('admin.branch.list')->with('success','branch created successfully.');

    }
       
    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $user = Branch::where('id', $id)->first();

            
            return view('admin.branch.branch_edit',compact('user_data','user'));
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

        Branch::where('id', $id)->update($datauser);



        return redirect()->route('admin.branch.list')->with('success','branch Update successfully.');
    }

    public function delete($id)
    {
        $deleted = Branch::where('id', $id)->delete();
        return response()->json(['success'=>'branch Deleted Successfully!']);
    }
    
    public function status(Request $request){
        
        $id = $request->id;
        $datauser = [
             'status' => $request->status,
        ];

        
        Branch::where('id', $id)->update($datauser);


        return response()->json(['success'=>'branch Status Changes Successfully!']);
    }
}
