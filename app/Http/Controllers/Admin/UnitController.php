<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    Unit
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

class UnitController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user_data = auth()->user();

            $unit_list = Unit::paginate(10);
            
            return view('admin.unit.unit_list',compact('user_data','unit_list'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }




    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();
            
            return view('admin.unit.unit_add',compact('user_data'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }


    public function store(Request $request){

        $validatedData = $request->validate([
            'unit_code' => 'required',
            'unit_name' => 'required',
        ]);

        $datauser = [
             'unit_code' => $request->unit_code,
             'unit_name' => $request->unit_name,
        ];

        $id = Unit::insertGetId($datauser);


        return redirect()->route('admin.unit.list')->with('success','unit created successfully.');

    }
       
    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $user = Unit::where('id', $id)->first();

            
            return view('admin.unit.unit_edit',compact('user_data','user'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
        
    public function update(Request $request){
        
        $validatedData = $request->validate([
            'unit_code' => 'required',
            'unit_name' => 'required',
        ]);
        $id = $request->id;
        
        $datauser = [
            'unit_code' => $request->unit_code,
            'unit_name' => $request->unit_name,
       ];

        Unit::where('id', $id)->update($datauser);



        return redirect()->route('admin.unit.list')->with('success','unit Update successfully.');
    }

    public function delete($id)
    {
        $deleted = Unit::where('id', $id)->delete();
        return response()->json(['success'=>'unit Deleted Successfully!']);
    }
    
    public function status(Request $request){
        
        $id = $request->id;
        $datauser = [
             'status' => $request->status,
        ];

        
        Unit::where('id', $id)->update($datauser);


        return response()->json(['success'=>'unit Status Changes Successfully!']);
    }
}
