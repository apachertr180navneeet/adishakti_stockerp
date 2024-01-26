<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    Company,
    Unit,
    Item,
    Stock,
    StockItem,
    StockReport,
    ItemStock
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

class StockController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user_data = auth()->user();

            $stock_list = Stock::select('stock.id','stock.stock_date','stock.total_amount','stock.qty','stock.status','users.name')->join('users', 'stock.vendor_id', '=', 'users.id')->paginate(10);
            $startDate = "";
            $endDate = "";

            return view('admin.stock.stock_list',compact('user_data','stock_list','startDate','endDate'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();
            $unit_list = Unit::get();
            $branch_list = Company::get();
            $user_list = User::where('type', '1')->get();
            $item_list = Item::select('item.*','unit.unit_name','unit.unit_code')->join('unit', 'item.unit_id', '=', 'unit.id')->get();
            //dd($item_list);

            return view('admin.stock.stock_add',compact('user_data','unit_list','user_list','item_list','branch_list'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function store(Request $request){
        // Validate input data
        $validatedData = $request->validate([
            'stock_date' => 'required',
        ]);

        $itemId = $request->service_id;
        $branchId = $request->branch_id;

        if (empty($itemId)) {
            return redirect()->back()->with(['danger' => 'At least one item to select']);
        }

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create a new stock
            $stock = Stock::create([
                'stock_date' => $request->stock_date,
                'vendor_id' => $request->vendor_id,
                'total_amount' => $request->finaltotal_amount,
                'qty' => array_sum($request->qty) // Calculate total quantity
            ]);

            $dataStockItems = [];
            $dataStockReport = [];

            // Prepare data for stock items and stock report
            foreach ($itemId as $key => $itemIdValue) {
                $dataStockItems[] = [
                    'stock_id' => $stock->id,
                    'item_id' => $itemIdValue,
                    'stock_quantity' => $request->qty[$key],
                    'stock_amount' => $request->rate[$key],
                    'item_total_amount' => $request->totalamount[$key],
                    'unit' => $request->unit[$key]
                ];

                $dataStockReport[] = [
                    'item_id' => $itemIdValue,
                    'quantity' => $request->qty[$key],
                    'unit' => $request->unit[$key]
                ];
            }

            // Bulk insert stock items
            StockItem::insert($dataStockItems);

            // // Update or insert stock report
            // foreach ($dataStockReport as $stockReportValue) {
            //     $itemId = $stockReportValue['item_id'];
            //     $quantity = $stockReportValue['quantity'];
            //     $unit = $stockReportValue['unit'];

            //     StockReport::updateOrCreate(
            //         ['item_id' => $itemId, 'branch_id' => $branchId],
            //         ['quantity' => DB::raw("quantity + $quantity"), 'unit' => $unit]
            //     );
            // }

            // Commit the transaction
            DB::commit();

            return redirect()->route('admin.stock.in.list')->with('success', 'Stock created successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to create stock. Please try again.');
        }
    }
    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $stock = Stock::where('id', $id)->first();
            $stockItem = StockItem::where('stock_id', $id)->join('item', 'stock_item.item_id', '=', 'item.id')->get();
            $unit_list = Unit::get();
            $item_list = Item::get();
            $user_list = User::where('type', '1')->get();
            return view('admin.stock.stock_edit',compact('user_data','stock','unit_list','user_list','item_list','stockItem'));
        }
        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function update(Request $request){
        $validatedData = $request->validate([
            'stock_date' => 'required',
        ]);
        $stockitemid = $request->stockitemid;
        $stock_quantity = $request->stock_quantity;
        $stock_amount = $request->stock_amount;
        $itemtotalamount = $request->itemtotalamount;
        $id = $request->id;
        $datastock = [
            'stock_date' => $request->stock_date,
            'vendor_id' => $request->vendor_id,
            'total_amount' => $request->finaltotal_amount
        ];
        Stock::where('id', $id)->update($datastock);
        $deleted = StockItem::where('stock_id', $id)->delete();
        foreach ($request->stockitemid as $key => $itemidvalue) {
            $datastockitem[] = [
                'stock_id' => $id,
                'item_id' => $itemidvalue,
                'stock_quantity' => $stock_quantity[$key],
                'stock_amount' => $stock_amount[$key],
                'itemtotalamount' => $itemtotalamount[$key],
            ];

        }

        foreach ($datastockitem as $stockitemvalue) {
            StockItem::insertGetId($stockitemvalue);
        }
        return redirect()->route('admin.stock.in.list')->with('success','stock Update successfully.');
    }
    public function delete($id)
    {
        $deleted = StockItem::where('stock_id', $id)->delete();
        $deleted = Stock::where('id', $id)->delete();
        return response()->json(['success'=>'stock Deleted Successfully!']);
    }
    public function status(Request $request){
        $id = $request->id;
        $datauser = [
             'status' => $request->status,
        ];
        Stock::where('id', $id)->update($datauser);
        return response()->json(['success'=>'stock Status Changes Successfully!']);
    }
    public function serach(){
        if(Auth::check()){

            $user_data = auth()->user();
            if(!empty($_GET['startDate'])){
                $startDate = date($_GET['startDate']);
                $startDateFormat = date("Y-m-d", strtotime($startDate));
                $endDate = date($_GET['endDate']);
                $endDateFormat = date("Y-m-d", strtotime($endDate));
                $stock_list = Stock::select('stock.id','stock.stock_date','stock.status','users.name')->where('stock_date', '>=', $startDateFormat)->where('stock_date', '<=', $endDateFormat)->join('users', 'stock.vendor_id', '=', 'users.id')->paginate(10);
            }

            return view('admin.stock.stock_list',compact('user_data','stock_list','startDate','endDate'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
}
