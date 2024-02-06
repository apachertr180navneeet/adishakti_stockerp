<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    Unit,
    ConditionMaster,
    ChemicalCombination
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

class ConditionMasterController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user_data = auth()->user();

            $condition_list = ConditionMaster::paginate(10);

            return view('admin.condition.condition_list',compact('user_data','condition_list'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }




    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();

            $unit_list = Unit::get();

            $condition_list = ConditionMaster::where('type', 'base_unit')->get();

            return view('admin.condition.condition_add',compact('user_data','unit_list','condition_list'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }


    public function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required',
            'value' => 'required',
            'unit_id' => 'required',
        ]);

        $datauser = [
             'name' => $request->name,
             'value' => $request->value,
             'unit' => $request->unit_id,
             'type' => $request->type,
             'meter_value' => $request->metervalue,
        ];

        $id = ConditionMaster::insertGetId($datauser);

        if($request->type == "sub_unit"){
            $chemical_id = $request->chemical_id;
            $chemical_qty = $request->chemical_qty;
            $chemical_calculation = $request->chemical_calculation;

            foreach ($chemical_id as $key => $itemidvalue) {
                $datastockitem[] = [
                    'chemical_id' => $id,
                    'chemical_item_id' => $itemidvalue,
                    'chemcical_qty' => $chemical_qty[$key],
                    'chemical_calculation' => $chemical_calculation[$key],
                ];;
            }
            foreach ($datastockitem as $stockitemvalue) {
                ChemicalCombination::insertGetId($stockitemvalue);
            }
        }


        return redirect()->route('admin.condition.list')->with('success','condition created successfully.');

    }

    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $user = ConditionMaster::where('id', $id)->first();


            return view('admin.condition.condition_edit',compact('user_data','user'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }

    public function update(Request $request){

        $validatedData = $request->validate([
            'name' => 'required',
            'value' => 'required',
        ]);
        $id = $request->id;
        $datauser = [
            'name' => $request->name,
            'value' => $request->value,
        ];

        ConditionMaster::where('id', $id)->update($datauser);



        return redirect()->route('admin.condition.list')->with('success','condition Update successfully.');
    }

    public function delete($id)
    {
        $deleted = ConditionMaster::where('id', $id)->delete();
        return response()->json(['success'=>'condition Deleted Successfully!']);
    }

    public function status(Request $request){

        $id = $request->id;
        $datauser = [
             'status' => $request->status,
        ];


        ConditionMaster::where('id', $id)->update($datauser);


        return response()->json(['success'=>'condition Status Changes Successfully!']);
    }
}
