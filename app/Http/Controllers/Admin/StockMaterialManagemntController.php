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
    Color,
    ConditionMaster,
    Machine,
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

            $stock_material_list = StockMaterialManagemnt::select('stock_material_managemnt.id','stock_material_managemnt.stock_material_managemnt_date','stock_material_managemnt.machine_name','stock_material_managemnt.source_location','stock_material_managemnt.destination_location','stock_material_managemnt.status','source_branch.name as sourcebranchname','destination_branch.name as destinbranchname')
            ->join('company as source_branch', 'stock_material_managemnt.source_location', '=', 'source_branch.id')
            ->join('company as destination_branch', 'stock_material_managemnt.destination_location', '=', 'destination_branch.id')
            ->orderByDesc('stock_material_managemnt_date')
            ->get();

            $startDate = "";
            $endDate = "";

            return view('admin.stock_material.stock_material_list',compact('user_data','stock_material_list','startDate','endDate'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();
            $item_list = Item::orderBy('item_name')->get();
            $overHeadList = Overhead::orderBy('name')->get();
            $branch_list = Company::orderBy('name')->get();
            $color_list = Color::where('is_group','1')->orderBy('color_name')->get();
            $chemical_list = ConditionMaster::orderBy("name")->get();
            $machine_list = Machine::orderBy('created_at', 'asc')
                       ->get();
            return view('admin.stock_material.stock_material_add',compact('user_data','item_list','overHeadList','branch_list','color_list','machine_list','chemical_list'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function store(Request $request) {
        // Extract data from the validated request
        $date = $request->input('stock_material_management_date');
        $machine_names = $request->input('machine_name', []);
        $markas = $request->input('marka', []);
        $productionTotalAmount = $request->input('production_totalamount', []);
        $consumptionTotalAmount = $request->input('consumption_totalamount', []);
        $sourceLocation = $request->input('source_location');
        $destinationLocation = $request->input('destination_location');
        $executeDate = $request->input('execute_date');

        $productionItemIds = $request->input('production_item_id', []);
        $productionItemQtys = $request->input('production_qty', []);
        $productionItemAmounts = $request->input('production_amount', []);

        $consumptionItemIds = $request->input('consumption_item_id', []);
        $consumptionItemQtys = $request->input('consumption_qty', []);
        $consumptionItemAmounts = $request->input('consumption_amount', []);

        $overheadItemIds = $request->input('overhead_item_id', []);
        $overheadAmounts = $request->input('overhead_amount', []);

        $colorItemIds = $request->input('color_item_id', []);
        $colorRates = $request->input('color_rate', []);
        $colorGrams = $request->input('color_gram', []);

        $chemicalItemIds = $request->input('chemical_item_id', []);
        $chemicalRates = $request->input('chemical_rate', []);
        $chemicalGrams = $request->input('chemical_gram', []);

        try {
            // Begin transaction
            DB::beginTransaction();

            foreach ($machine_names as $key => $machineName) {
                $marka = $markas[$key] ?? null;
                $productionTotal = $productionTotalAmount[$key] ?? 0;
                $consumptionTotal = $consumptionTotalAmount[$key] ?? 0;

                // Insert stock material
                $stockMaterialId = StockMaterialManagemnt::insertGetId([
                    'stock_material_managemnt_date' => $date,
                    'production_total' => $productionTotal,
                    'consumption_total' => $consumptionTotal,
                    'source_location' => $sourceLocation,
                    'destination_location' => $destinationLocation,
                    'excute_date' => $executeDate,
                    'machine_name' => $machineName,
                    'marka' => $marka,
                ]);

                // Insert related items for this machine
                $this->insertSingleConsumptionItem($stockMaterialId, $consumptionItemIds[$key], $consumptionItemQtys[$key], $consumptionItemAmounts[$key]);
                $this->insertSingleOverheadItem($stockMaterialId, $overheadItemIds[$key], $overheadAmounts[$key]);
                $this->insertSingleColorItem($stockMaterialId, $colorItemIds[$key], $colorRates[$key], $colorGrams[$key]);
                $this->insertSingleChemicalItem($stockMaterialId, $chemicalItemIds[$key], $chemicalRates[$key], $chemicalGrams[$key]);
                $this->insertSingleProductionItem($stockMaterialId, $productionItemIds[$key], $productionItemQtys[$key], $productionItemAmounts[$key]);
            }

            // Commit transaction
            DB::commit();

            return redirect()->route('admin.stock.material.list')->with('success', 'Stock material created successfully.');
        } catch (\Exception $e) {
            // Rollback transaction if an exception occurs
            DB::rollBack();

            // Log the error for debugging and return a user-friendly message
            dd($e->getMessage());

            return back()->with('error', 'Failed to create stock material. Please try again.');
        }
    }

    // Example methods for inserting single related items
    protected function insertSingleConsumptionItem($stockMaterialId, $itemId, $qty, $amount) {
        StockMaterialConsumoption::create([
            'stock_material_id' => $stockMaterialId,
            'counsumption_item_id' => $itemId,
            'qty' => $qty ?? 0,
            'rate' => $amount ?? 0,
            'total_amount' => $qty * $amount ?? 0,
        ]);

        $stockReport = StockReport::where('item_id', $itemId)->first();
        if ($stockReport) {
            $stockReport->quantity -= $qty;
            $stockReport->save();
        }
    }

    protected function insertSingleOverheadItem($stockMaterialId, $itemId, $amount) {
        StockMaterialOverhead::create([
            'stock_material_id' => $stockMaterialId,
            'overhead_item_id' => $itemId,
            'amount' => $amount ?? 0,
        ]);
    }

    protected function insertSingleColorItem($stockMaterialId, $itemId, $rate, $gram) {
        DB::table('stock_meterial_color')->insert([
            'stock_material_id' => $stockMaterialId,
            'color_item_id' => $itemId,
            'rate' => $rate ?? 0,
            'gram' => $gram ?? 0,
        ]);

        $color = DB::table('color')->where('id', $itemId)->first();
        if ($color) {
            $color->current_value -= $gram;
            DB::table('color')->where('id', $itemId)->update(['current_value' => $color->current_value]);
        }
    }

    protected function insertSingleChemicalItem($stockMaterialId, $itemId, $rate, $gram) {
        DB::table('stock_meterial_chemical')->insert([
            'stock_material_id' => $stockMaterialId,
            'chemical_item_id' => $itemId,
            'rate' => $rate ?? 0,
            'gram' => $gram ?? 0,
        ]);
    }

    protected function insertSingleProductionItem($stockMaterialId, $itemId, $qty, $amount) {
        StockMaterialProduction::create([
            'stock_material_id' => $stockMaterialId,
            'production_item_id' => $itemId,
            'qty' => $qty ?? 0,
            'rate' => $amount ?? 0,
            'total_amount' => $qty * $amount ?? 0,
        ]);

        $stockReport = StockReport::where('item_id', $itemId)->first();
        if ($stockReport) {
            $stockReport->quantity += $qty;
            $stockReport->save();
        }
    }

    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();

            $user = StockMaterialManagemnt::select('stock_material_managemnt.id','stock_material_managemnt.stock_material_managemnt_date','stock_material_managemnt.source_location','stock_material_managemnt.destination_location','stock_material_managemnt.machine_name','stock_material_managemnt.marka','stock_material_managemnt.status','source_branch.name as sourcebranchname','destination_branch.name as destinbranchname')
            ->where('stock_material_managemnt.id', $id)
            ->join('company as source_branch', 'stock_material_managemnt.source_location', '=', 'source_branch.id')
            ->join('company as destination_branch', 'stock_material_managemnt.destination_location', '=', 'destination_branch.id')
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

            $stockcolor = DB::table('stock_meterial_color')->select('stock_meterial_color.color_id','stock_meterial_color.stock_material_id','stock_meterial_color.color_item_id','stock_meterial_color.rate','stock_meterial_color.gram','color.color_name')
            ->where('stock_meterial_color.stock_material_id', $stockmaterialid)
            ->join('color', 'stock_meterial_color.color_item_id', '=', 'color.id')
            ->get();

            $stockchemical = DB::table('stock_meterial_chemical')->select('stock_meterial_chemical.chemical_id','stock_meterial_chemical.stock_material_id','stock_meterial_chemical.chemical_item_id','stock_meterial_chemical.rate','stock_meterial_chemical.gram','condition_master.name')
            ->where('stock_meterial_chemical.stock_material_id', $stockmaterialid)
            ->join('condition_master', 'stock_meterial_chemical.chemical_item_id', '=', 'condition_master.id')
            ->get();

            return view('admin.stock_material.stock_material_edit',compact('user_data','user','stockconsumptionitem','stockproductionitem','stockoverhead','stockcolor','stockchemical'));
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
