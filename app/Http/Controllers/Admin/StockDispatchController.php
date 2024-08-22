<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    Company,
    Unit,
    Item,
    StockDispatch,
    StockDispatchItem,
    StockReport
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

class StockDispatchController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user_data = auth()->user();
            $stockDispatchList = StockDispatch::select('stock_dispatch.id','stock_dispatch.stock_date','stock_dispatch.status','stock_dispatch.total_amount','stock_dispatch.type','stock_dispatch.from_id','stock_dispatch.vendor_to_id','stock_dispatch.branch_to_id')->paginate(10);

            $startDate = "";
            $endDate = "";

            return view('admin.stock_dispatch.stock_list',compact('user_data','stockDispatchList','startDate','endDate'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }

    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();
            $unit_list = Unit::orderBy('unit_name')->get();
            $branch_list = Company::orderBy('name')->get();
            $user_list = User::where('type', '1')->orderBy('name')->get();
            $item_list = Item::orderBy('item_name')->get();

            return view('admin.stock_dispatch.stock_add',compact('user_data','unit_list','user_list','item_list','branch_list'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }


    public function store(Request $request){


        $validatedData = $request->validate([
            'stock_date' => 'required',
        ]);
        $itemid = $request->service_id;
        if(empty($itemid)){
            return redirect()->back()->with(['danger' => 'At least one item to select']);
        }
        $qty = $request->qty;
        $amount = $request->rate;
        $totalamount = $request->totalamount;

        $datastock = [
            'stock_date' => $request->stock_date,
            'from_id' => $request->from_id,
            'type' => '0',
            'vendor_to_id' => isset($request->vendor_to_id) ?$request->vendor_to_id:'0',
            'branch_to_id' => isset($request->branch_to_id) ?$request->branch_to_id:'0',
            'total_amount' => $request->finaltotal_amount
        ];

        $id = StockDispatch::insertGetId($datastock);
        foreach ($itemid as $key => $itemidvalue) {
            $datastockitem[] = [
                    'stock_id' => $id,
                    'item_id' => $itemidvalue,
                    'stock_quantity' => $qty[$key],
                    'stock_amount' => $amount[$key],
                    'itemtotalamount' => $totalamount[$key],
                ];

                $dataStockReport[] = [
                    'item_id' => $itemidvalue,
                    'quantity' => $qty[$key],
                ];
        }

        foreach ($datastockitem as $stockitemvalue) {
            StockDispatchItem::insertGetId($stockitemvalue);
        }

        foreach ($dataStockReport as $StockReportValue) {
            $itemid = $StockReportValue['item_id'];
            $quantity = $StockReportValue['quantity'];
            $stockreporthcheck = StockReport::where('item_id', '=', $itemid)->where('branch_id', '=', $request->branch_to_id)->first();
            if(empty($stockreporthcheck)){
                $dataReport = [
                    'item_id' => $itemid,
                    'branch_id' => $request->branch_to_id,
                    'quantity' => $quantity,
                ];
                StockReport::insertGetId($dataReport);
            }else{
                $oldqty = $stockreporthcheck->quantity;
                $testqty = $oldqty + $quantity;
                StockReport::where('item_id', $itemid)->where('branch_id', $request->branch_to_id)->update(['quantity' => $testqty]);
            }
        }
        return redirect()->route('admin.stock.dispatch.list')->with('success','stock created successfully.');

    }

    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $stock = StockDispatch::where('id', $id)->first();
            $stockItem = StockDispatchItem::where('stock_id', $id)->join('item', 'stock_dispatch_item.item_id', '=', 'item.id')->get();
            $unit_list = Unit::orderBy('unit_name')->get();
            $item_list = Item::orderBy('item_name')->get();
            $user_list = User::where('type', '1')->orderBy('name')->get();
            $branch_list = Company::orderBy('name')->get();
            return view('admin.stock_dispatch.stock_edit',compact('user_data','stock','unit_list','user_list','item_list','stockItem','branch_list'));
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
            'from_id' => $request->from_id,
            'type' => '0',
            'vendor_to_id' => isset($request->vendor_to_id) ?$request->vendor_to_id:'0',
            'branch_to_id' => isset($request->branch_to_id) ?$request->branch_to_id:'0',
            'total_amount' => $request->finaltotal_amount
        ];
        StockDispatch::where('id', $id)->update($datastock);
        $deleted = StockDispatchItem::where('stock_id', $id)->delete();
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
            StockDispatchItem::insertGetId($stockitemvalue);
        }
        return redirect()->route('admin.stock.dispatch.list')->with('success','stock Update successfully.');
    }

    public function delete($id)
    {
        $deleted = StockDispatchItem::where('stock_id', $id)->delete();
        $deleted = StockDispatch::where('id', $id)->delete();
        return response()->json(['success'=>'stock Deleted Successfully!']);
    }

    public function status(Request $request){
        $id = $request->id;
        $datauser = [
             'status' => $request->status,
        ];
        StockDispatch::where('id', $id)->update($datauser);
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
                $stockDispatchList = StockDispatch::select('stock_dispatch.id','stock_dispatch.stock_date','stock_dispatch.status','stock_dispatch.total_amount','stock_dispatch.type','stock_dispatch.from_id','stock_dispatch.vendor_to_id','stock_dispatch.branch_to_id')->where('stock_date', '>=', $startDateFormat)->where('stock_date', '<=', $endDateFormat)->paginate(10);
            }
            return view('admin.stock_dispatch.stock_list',compact('user_data','stockDispatchList','startDate','endDate'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
}
