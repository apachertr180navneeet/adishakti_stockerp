<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    Color,
    Batch,
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

class BatchController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user_data = auth()->user();

            $batch_list = Batch::select('batch.*','machine.name as machine_name','machine.code as machine_code')->join('machine', 'batch.machine_number', '=', 'machine.id')->get();

            return view('admin.batch.batch_list',compact('user_data','batch_list'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }




    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();
            $machine_list = Machine::orderBy('name')->get();

            return view('admin.batch.batch_add',compact('user_data','machine_list'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }


    public function store(Request $request){

        $validatedData = $request->validate([
            'batch_name' => 'required',
        ]);

        $datauser = [
            'machine_number' => $request->machine_number,
            'batch_name' => $request->batch_name,
            'batch_code' => $request->batch_code,
            'date_of_mgf' => $request->date_of_mgf
        ];

        $id = Batch::insertGetId($datauser);


        return redirect()->route('admin.batch.list')->with('success','batch created successfully.');

    }

    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $batch = Batch::where('id', $id)->first();
            $machine_list = Machine::orderBy('name')->get();


            return view('admin.batch.batch_edit',compact('user_data','batch','machine_list'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'batch_name' => 'required',
        ]);

        $id = $request->id;
        $datauser = [
            'machine_number' => $request->machine_number,
            'batch_name' => $request->batch_name,
            'batch_code' => $request->batch_code,
            'date_of_mgf' => $request->date_of_mgf
        ];

        Batch::where('id', $id)->update($datauser);



        return redirect()->route('admin.batch.list')->with('success','batch Update successfully.');
    }

    public function delete($id)
    {
        $deleted = Batch::where('id', $id)->delete();
        return response()->json(['success'=>'item Deleted Successfully!']);
    }

    public function status(Request $request){

        $id = $request->id;
        $datauser = [
             'status' => $request->status,
        ];


        Batch::where('id', $id)->update($datauser);


        return response()->json(['success'=>'item Status Changes Successfully!']);
    }
}
