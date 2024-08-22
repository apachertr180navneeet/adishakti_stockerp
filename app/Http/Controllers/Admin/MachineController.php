<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    Color,
    Machine
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

class MachineController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user_data = auth()->user();

            $machine_list = Machine::get();

            return view('admin.machine.machine_list',compact('user_data','machine_list'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }




    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();

            return view('admin.machine.machine_add',compact('user_data'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }


    public function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $datauser = [
            'name' => $request->name,
            'code' => $request->code,
            'last_repair_date' => $request->last_repair_date,
            'description' => $request->description
        ];

        $id = Machine::insertGetId($datauser);


        return redirect()->route('admin.machine.list')->with('success','Machine created successfully.');

    }

    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $machine = Machine::where('id', $id)->first();


            return view('admin.machine.machine_edit',compact('user_data','machine'));
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
            'code' => $request->code,
            'last_repair_date' => $request->last_repair_date,
            'description' => $request->description
        ];

        Machine::where('id', $id)->update($datauser);



        return redirect()->route('admin.machine.list')->with('success','Machine Update successfully.');
    }

    public function delete($id)
    {
        $deleted = Machine::where('id', $id)->delete();
        return response()->json(['success'=>'item Deleted Successfully!']);
    }

    public function status(Request $request){

        $id = $request->id;
        $datauser = [
             'status' => $request->status,
        ];


        Machine::where('id', $id)->update($datauser);


        return response()->json(['success'=>'item Status Changes Successfully!']);
    }
}
