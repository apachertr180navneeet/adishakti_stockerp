<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    StockMaterialManagemnt,
    StockMaterialProduction,
    StockMaterialConsumoption,
    StockMaterialOverhead,
    Item,
    Overhead,
    Company,
    StockReport,
    Unit,
    Color
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

class StockMaterialManagemntController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user_data = auth()->user();

            $stock_material_list = StockMaterialManagemnt::select('stock_material_managemnt.id','stock_material_managemnt.stock_material_managemnt_date','stock_material_managemnt.source_location','stock_material_managemnt.destination_location','stock_material_managemnt.status','source_branch.name as sourcebranchname','destination_branch.name as destinbranchname')
            ->join('company as source_branch', 'stock_material_managemnt.source_location', '=', 'source_branch.id')
            ->join('company as destination_branch', 'stock_material_managemnt.destination_location', '=', 'destination_branch.id')
            ->paginate(10);

            $startDate = "";
            $endDate = "";

            return view('admin.stock_material.stock_material_list',compact('user_data','stock_material_list','startDate','endDate'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();
            $item_list = Item::get();
            $overHeadList = Overhead::get();
            $branch_list = Company::get();
            $color_list = Color::get();
            return view('admin.stock_material.stock_material_add',compact('user_data','item_list','overHeadList','branch_list','color_list'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function store(Request $request){

        $validatedData = $request->validate([
            'stock_material_managemnt_date' => 'required',
        ]);

        $date = $request->stock_material_managemnt_date;
        $productiontotalamount = $request->production_total_amount;
        $consumptiontotalamount = $request->consuption_total_amount;
        $productionitemid = $request->production_item_id;
        $productionitemrate = $request->production_rate;
        $productionitemqty = $request->production_qty;
        $productionitemtotalamount = $request->production_totalamount;
        $consumptionitemid = $request->consumption_item_id;
        $consumptionitemrate = $request->consumption_rate;
        $consumptionitemqty = $request->consumption_qty;
        $consumptionitemtotalamount = $request->consumption_totalamount;
        $overheaditemid = $request->overhead_item_id;
        $overheadrate = $request->overhead_rate;
        $sourcelocation = $request->source_location;
        $destinationlocation = $request->destination_location;

        $datauser = [
            'stock_material_managemnt_date' => $date,
            'production_total' => $productiontotalamount,
            // 'consumption_total' => $consumptiontotalamount,
            'consumption_total' => '0',
            'source_location' => $sourcelocation,
            'destination_location' => $destinationlocation,
        ];

        $id = StockMaterialManagemnt::insertGetId($datauser);

         // counsumptionItem
         foreach ($consumptionitemid as $key => $consumptionitemidvalue) {
            $dataconsumption[] = [
                    'stock_material_id' => $id,
                    'counsumption_item_id' => $consumptionitemidvalue,
                    'rate' => $consumptionitemrate[$key],
                    'qty' => $consumptionitemqty[$key],
                    'total_amount' => $consumptionitemtotalamount[$key],
                ];
            $consumptiondataStockReport[] = [
                'item_id' => $consumptionitemidvalue,
                'quantity' => $consumptionitemqty[$key],
            ];
        }
        foreach ($consumptiondataStockReport as $StockReportValue) {
            $itemid = $StockReportValue['item_id'];
            $quantity = $StockReportValue['quantity'];
            $stockreporthcheck = StockReport::where('item_id', '=', $itemid)->where('branch_id', '=', $destinationlocation)->first();
            if(!empty($stockreporthcheck)){
                $oldqty = $stockreporthcheck->quantity;
                $testqty = $oldqty - $quantity;
                StockReport::where('item_id', $itemid)->update(['quantity' => $testqty]);
            }
        }
        foreach ($dataconsumption as $dataconsumptionvalue) {
            StockMaterialConsumoption::insertGetId($dataconsumptionvalue);
        }


        // overhead
        foreach ($overheaditemid as $key => $overheaditemidvalue) {
            $dataoverhead[] = [
                    'stock_material_id' => $id,
                    'overhead_item_id' => $overheaditemidvalue,
                    'amount' => $overheadrate[$key]
                ];
        }

        foreach ($dataoverhead as $dataoverheadvalue) {
            StockMaterialOverhead::insertGetId($dataoverheadvalue);
        }


        // production
        foreach ($productionitemid as $key => $productionitemidvalue) {
            $dataproduction[] = [
                    'stock_material_id' => $id,
                    'production_item_id' => $productionitemidvalue,
                    'rate' => $productionitemrate[$key],
                    'qty' => $productionitemqty[$key],
                    'total_amount' => $productionitemtotalamount[$key],
                ];

                $productiondataStockReport[] = [
                    'item_id' => $productionitemidvalue,
                    'quantity' => $productionitemqty[$key],
                ];
        }

        foreach ($productiondataStockReport as $proStockReportValue) {
            $itemid = $proStockReportValue['item_id'];
            $quantity = $proStockReportValue['quantity'];
            $itemdetail = Item::where('id', '=', $itemid)->first();
            $unit = Unit::where('id', '=', $itemdetail->unit_id)->first();
            $stockreporthcheck = StockReport::where('item_id', '=', $itemid)->where('branch_id', '=', $destinationlocation)->first();
            if(empty($stockreporthcheck)){
                $dataReport = [
                    'item_id' => $itemid,
                    'branch_id' => $destinationlocation,
                    'quantity' => $quantity,
                    'unit' => $unit->unit_code
                ];
                StockReport::insertGetId($dataReport);
            }else{
                $oldqty = $stockreporthcheck->quantity;
                $testqty = $oldqty + $quantity;
                StockReport::where('item_id', $itemid)->where('branch_id', $destinationlocation)->update(['quantity' => $testqty]);
            }
        }

        foreach ($dataproduction as $dataproductionvalue) {
            StockMaterialProduction::insertGetId($dataproductionvalue);
        }


        return redirect()->route('admin.stock.material.list')->with('success','stock_material created successfully.');

    }
    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();

            $user = StockMaterialManagemnt::select('stock_material_managemnt.id','stock_material_managemnt.stock_material_managemnt_date','stock_material_managemnt.source_location','stock_material_managemnt.destination_location','stock_material_managemnt.status','source_branch.name as sourcebranchname','destination_branch.name as destinbranchname')
            ->where('stock_material_managemnt.id', $id)
            ->join('branch as source_branch', 'stock_material_managemnt.source_location', '=', 'source_branch.id')
            ->join('branch as destination_branch', 'stock_material_managemnt.destination_location', '=', 'destination_branch.id')
            ->first();

            $stockmaterialid = $user->id;

            $stockconsumptionitem = StockMaterialConsumoption::select('stock_meterial_consumption.consumtion_id','stock_meterial_consumption.stock_material_id','stock_meterial_consumption.counsumption_item_id','stock_meterial_consumption.rate','stock_meterial_consumption.qty','stock_meterial_consumption.total_amount','item.item_name')
            ->where('stock_meterial_consumption.stock_material_id', $stockmaterialid)
            ->join('item', 'stock_meterial_consumption.counsumption_item_id', '=', 'item.id')
            ->get();

            $stockproductionitem = StockMaterialProduction::select('stock_meterial_production.production_id','stock_meterial_production.stock_material_id','stock_meterial_production.production_item_id','stock_meterial_production.rate','stock_meterial_production.qty','stock_meterial_production.total_amount','item.item_name')
            ->where('stock_meterial_production.stock_material_id', $stockmaterialid)
            ->join('item', 'stock_meterial_production.production_item_id', '=', 'item.id')
            ->get();

            $stockoverhead = StockMaterialOverhead::select('stock_meterial_overhead.overhead_id','stock_meterial_overhead.stock_material_id','stock_meterial_overhead.overhead_item_id','stock_meterial_overhead.amount','overhead.name')
            ->where('stock_meterial_overhead.stock_material_id', $stockmaterialid)
            ->join('overhead', 'stock_meterial_overhead.overhead_item_id', '=', 'overhead.id')
            ->get();

            return view('admin.stock_material.stock_material_edit',compact('user_data','user','stockconsumptionitem','stockproductionitem','stockoverhead'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function update(Request $request){
        $validatedData = $request->validate([
            'stock_material_managemnt_date' => 'required',
        ]);

        $id = $request->id;
        $datauser = [
            'stock_material_managemnt_date' => $request->stock_material_managemnt_date,
            'item_id' => $request->item_id,
            'stock_material_managemnt_quantity' => $request->stock_material_managemnt_quantity,
            'source_location' => $request->source_location,
            'destination_location' => $request->destination_location,
        ];

        StockMaterialManagemnt::where('id', $id)->update($datauser);



        return redirect()->route('admin.stock.material.list')->with('success','stock_material Update successfully.');
    }
    public function delete($id)
    {
        $deleted = StockMaterialManagemnt::where('id', $id)->delete();

        return response()->json(['success'=>'stock_material Deleted Successfully!']);
    }
    public function status(Request $request){

        $id = $request->id;
        $datauser = [
             'status' => $request->status,
        ];


        StockMaterialManagemnt::where('id', $id)->update($datauser);


        return response()->json(['success'=>'stock_material Status Changes Successfully!']);
    }
    public function search(){
        if(Auth::check()){
            $user_data = auth()->user();
            if(!empty($_GET['startDate'])){
                $startDate = date($_GET['startDate']);
                $startDateFormat = date("Y-m-d", strtotime($startDate));
                $endDate = date($_GET['endDate']);
                $endDateFormat = date("Y-m-d", strtotime($endDate));
                $stock_material_list = StockMaterialManagemnt::select('stock_material_managemnt.id','stock_material_managemnt.stock_material_managemnt_date','stock_material_managemnt.item_id','stock_material_managemnt.stock_material_managemnt_quantity','stock_material_managemnt.source_location','stock_material_managemnt.destination_location','stock_material_managemnt.status','item.item_name')->where('stock_date', '>=', $startDateFormat)->where('stock_date', '<=', $endDateFormat)->join('item', 'stock_material_managemnt.item_id', '=', 'item.id')->paginate(10);
            }

            return view('admin.stock_material.stock_material_list',compact('user_data','stock_material_list','startDate','endDate'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
}
