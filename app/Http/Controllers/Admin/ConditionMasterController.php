<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    Unit,
    ConditionMaster,
    ChemicalCombination,
    ColorStockIn,
    ColorItem,
    ColorReport,
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

class ConditionMasterController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user_data = auth()->user();

            $condition_list = ConditionMaster::get();

            return view('admin.condition.condition_list',compact('user_data','condition_list'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }




    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();

            $unit_list = Unit::get();

            $condition_list = ConditionMaster::where('type', 'base_unit')->orderBy('name')->get();

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
            $unit_list = Unit::get();
            $condition_list = ConditionMaster::where('type', 'base_unit')->orderBy('name')->get();

            $userGet = ChemicalCombination::where('chemical_id', $id)->get();


            return view('admin.condition.condition_edit',compact('user_data','user','unit_list','condition_list','userGet'));
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
            'unit' => $request->unit_id,
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


    public function chemicalstockin(){
        if(Auth::check()){
            $user_data = auth()->user();

            $colorstock = DB::table('color_stock_in')->select('color_stock_in.*','users.name as vendor_name')->where('color_stock_in.type','1')->join('users', 'color_stock_in.vendor_id', '=', 'users.id')->get();
            
            return view('admin.chemicalstock.chemicalstockin_list',compact('user_data','colorstock'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    
    public function addchemicalstock(){
        if(Auth::check()){
            $user_data = auth()->user();
            $unit_list = Unit::orderBy('unit_name')->get();
            $branch_list = Company::orderBy('name')->get();
            $user_list = User::where('type', '1')->orderBy('name')->get();
            $item_list = ConditionMaster::where('type', 'base_unit')->orderBy('name')->get();
            return view('admin.chemicalstock.chemicalstockin_add',compact('user_data','unit_list','user_list','item_list','branch_list'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }

    public function chemical_stock_store(Request $request){
        $stock_date = $request->stock_date;
        $invoice = $request->invoice;
        $company = $request->branch_id;
        $vendor = $request->vendor_id;
        $colorId = $request->service_id;
        $rate = $request->rate;
        $qty = $request->qty;
        $unit = $request->unit;
        $totalamount = $request->totalamount;
        $finaltotal_amount = $request->final_total_amount;

        $datacolorin = 
        [
            'date' => $stock_date,
            'invoice_number' => $invoice,
            'vendor_id' => $vendor,
            'type' => '1',
            'branch_id' => $company
        ];
        $colorinid = ColorStockIn::insertGetId($datacolorin);
        foreach ($colorId as $key => $itemidvalue) {
            $datastockitem[] = [
                'color_stock_id' => $colorinid,
                'color_id' => $itemidvalue,
                'qty' => $qty[$key],
                'rate' => $rate[$key],
                'total_amount' => $totalamount[$key],
            ];

            $dataStockReport[] = [
                'color_id' => $itemidvalue,
                'qty' => $qty[$key],
                'branch_id' => $company,
                
            ];
        }
        foreach ($datastockitem as $stockitemvalue) {
            ColorItem::insertGetId($stockitemvalue);
        }

        foreach ($dataStockReport as $StockReportValue) {
            $itemid = $StockReportValue['color_id'];
            $quantity = $StockReportValue['qty'];
            $stockreporthcheck = ColorReport::where('color_id', '=', $itemid)->where('branch_id', '=', $company)->first();
            if(empty($stockreporthcheck)){
                $dataReport = [
                    'color_id' => $itemid,
                    'branch_id' => $company,
                    'qty' => $quantity,
                    'type' => '1'
                ];
                ColorReport::insertGetId($dataReport);
            }else{
                $oldqty = $stockreporthcheck->quantity;
                $testqty = $oldqty + $quantity;
                ColorReport::where('color_id', $itemid)->where('branch_id', $company)->update(['qty' => $testqty]);
            }
        }
        return redirect('admin/chemical_stock_in');
    }

    public function chemicalstockedit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $colorstockIN = ColorStockIn::where('id', $id)->first();
            $stockItem = ColorItem::where('color_stock_id', $id)->join('condition_master', 'color_item.color_id', '=', 'condition_master.id')->get();
            
            $finalamount = '0';
            foreach ($stockItem as $key => $value) {
                $finalamount += $value->total_amount;
            }
            $unit_list = Unit::orderBy('unit_name')->get();
            $item_list = ConditionMaster::where('type', 'base_unit')->orderBy('name')->get();
            $user_list = User::where('type', '1')->orderBy('name')->get();
            $branch_list = Company::orderBy('name')->get();
            return view('admin.chemicalstock.chemicalstockin_edit',compact('user_data','colorstockIN','unit_list','user_list','item_list','stockItem','branch_list','finalamount'));
        }
        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
}