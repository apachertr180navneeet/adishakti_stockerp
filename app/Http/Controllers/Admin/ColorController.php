<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    Color,
    ColorCombination,
    Company,
    Unit,
    Item,
    ColorStockIn,
    ColorItem,
    ColorReport
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

class ColorController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user_data = auth()->user();

            $color_list = Color::orderBy('color.color_name', 'ASC')->get();

            return view('admin.color.color_list',compact('user_data','color_list'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();
            $color_list = Color::orderBy('color_name')->get();

            return view('admin.color.color_add',compact('user_data','color_list'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function store(Request $request){
        
        $validatedData = $request->validate([
            'color_code' => 'required',
            'color_name' => 'required',
            'rate_per_gram' => 'required',
        ]);

        $name = $request->name;
        $gm = $request->gm;
        $datauser = [
             'color_code' => $request->color_code,
             'color_name' => $request->color_name,
             'rate_per_gram' => $request->rate_per_gram,
             'meter_value' => $request->metervalue,
             'qty_on_meter' => $request->qty_on_meter,
             'current_value' => $request->current_value,
             'usage_per_gram' => $request->usage_per_gram,
             'rate_per_kg' => $request->rate_per_kg,
             'is_group' => $request->is_group,
        ];

        $id = Color::insertGetId($datauser);
        
        

        if(!empty($name)){
            foreach ($name as $key => $itemidvalue) {
                $datastockitem[] = [
                    'color_id' => $id,
                    'gram' => $gm[$key],
                    'name' => $itemidvalue,
                ];;
            }
            foreach ($datastockitem as $stockitemvalue) {
                ColorCombination::insertGetId($stockitemvalue);
            }
        }
        return redirect()->route('admin.color.list')->with('success','color created successfully.');
    }

    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $user = Color::where('id', $id)->first();

            $color_combination = ColorCombination::where('color_id', $id)->join('color', 'color_combination.color_id', '=', 'color.id')->get();

            $color_list = Color::orderBy('color_name')->get();
            return view('admin.color.color_edit',compact('user_data','user','color_list','color_combination'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function update(Request $request){

        $validatedData = $request->validate([
            'color_code' => 'required',
            'color_name' => 'required',
        ]);
        $id = $request->id;
        $name = $request->name;
        $gm = $request->gm;
        
        $useagegm = 0;
        if(!empty($gm)){
            foreach ($gm as $gmkey => $gmvalue) {
                $gmvalue;
                $useageper = $gmvalue;
                $useagegm += $useageper; 
            }
        }
        $datauser = [
            'color_code' => $request->color_code,
            'color_name' => $request->color_name,
            'rate_per_gram' => $request->rate_per_gram,
            'meter_value' => $request->metervalue,
            'qty_on_meter' => $request->qty_on_meter,
            'current_value' => $request->current_value,
            'usage_per_gram' => $useagegm,
            'rate_per_kg' => $request->rate_per_kg,
            'is_group' => $request->is_group,
       ];
       
        Color::where('id', $id)->update($datauser);
        if(!empty($name)){
            $deleted = ColorCombination::where('color_id', $id)->delete();
            foreach ($name as $key => $itemidvalue) {
                $datastockitem[] = [
                    'color_id' => $id,
                    'gram' => $gm[$key],
                    'name' => $itemidvalue,
                ];;
            }
            foreach ($datastockitem as $stockitemvalue) {
                ColorCombination::insertGetId($stockitemvalue);
            }
        }


        return redirect()->route('admin.color.list')->with('success','color Update successfully.');
    }
    public function delete($id)
    {
        $deleted = Color::where('id', $id)->delete();
        return response()->json(['success'=>'color Deleted Successfully!']);
    }
    public function status(Request $request){

        $id = $request->id;
        $datauser = [
             'status' => $request->status,
        ];


        Color::where('id', $id)->update($datauser);


        return response()->json(['success'=>'Color Status Changes Successfully!']);
    }

    public function colorstockin(){
        if(Auth::check()){
            $user_data = auth()->user();

            $colorstock = DB::table('color_stock_in')->select('color_stock_in.*','users.name as vendor_name')->where('color_stock_in.type','0')->join('users', 'color_stock_in.vendor_id', '=', 'users.id')->get();
            
            return view('admin.color_stock.colorstockin_list',compact('user_data','colorstock'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    
    public function addcolorstock(){
        if(Auth::check()){
            $user_data = auth()->user();
            $unit_list = Unit::orderBy('unit_name')->get();
            $branch_list = Company::orderBy('name')->get();
            $user_list = User::where('type', '1')->orderBy('name')->get();
            $item_list = Color::orderBy('color_name')->get();
            return view('admin.color_stock.colorstockin_add',compact('user_data','unit_list','user_list','item_list','branch_list'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }

    public function color_stock_store(Request $request){
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
            'branch_id' => $company,
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
                'branch_id' => $company
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
                ];
                ColorReport::insertGetId($dataReport);
            }else{
                $oldqty = $stockreporthcheck->quantity;
                $testqty = $oldqty + $quantity;
                ColorReport::where('color_id', $itemid)->where('branch_id', $company)->update(['qty' => $testqty]);
            }
        }
        return redirect('admin/color_stock_in');
    }

    public function colorstockedit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $colorstockIN = ColorStockIn::where('id', $id)->first();
            $stockItem = ColorItem::where('color_stock_id', $id)->join('color', 'color_item.color_id', '=', 'color.id')->get();
            
            $finalamount = '0';
            foreach ($stockItem as $key => $value) {
                $finalamount += $value->total_amount;
            }
            $unit_list = Unit::orderBy('unit_name')->get();
            $branch_list = Company::orderBy('name')->get();
            $user_list = User::where('type', '1')->orderBy('name')->get();
            $item_list = Color::orderBy('color_name')->get();
            return view('admin.color_stock.colorstockin_edit',compact('user_data','colorstockIN','unit_list','user_list','item_list','stockItem','branch_list','finalamount'));
        }
        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
}