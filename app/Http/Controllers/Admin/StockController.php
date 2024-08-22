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

            $stock_list = Stock::select('stock.id','stock.stock_date','stock.total_amount','stock.gadhiL','stock.qty','stock.status','vendor.name AS vendor_name','company.name AS company_name')->join('users As vendor', 'stock.vendor_id', '=', 'vendor.id')->join('company', 'stock.company_id', '=', 'company.id')->paginate(10);
            $startDate = "";
            $endDate = "";

            return view('admin.stock.stock_list',compact('user_data','stock_list','startDate','endDate'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();
            $unit_list = Unit::orderBy('unit_name')->get();
            $branch_list = Company::orderBy('name')->get();
            $user_list = User::where('type', '1')->orderBy('name')->get();
            $item_list = Item::select('item.*','unit.unit_name','unit.unit_code')->join('unit', 'item.unit_id', '=', 'unit.id')->orderBy('item_name')->get();
            //dd($item_list);

            return view('admin.stock.stock_add',compact('user_data','unit_list','user_list','item_list','branch_list'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function store(Request $request){
        $validatedData = $request->validate([
            'stock_date' => 'required',
        ]);
        $itemid = $request->service_id;
        $branch_id = $request->branch_id;
        if(empty($itemid)){
            return redirect()->back()->with(['danger' => 'At least one item to select']);
        }
        $qty = $request->qty;
        $amount = $request->rate;
        $unit = $request->unit;
        $company_id = $request->branch_id;
        $totalamount = $request->totalamount;
        $date = $request->stock_date;
        $Lgadhi = $request->Lgadhi;
        $itemgadhidata = $request->itemgadhidata;
        $newDateFormat = date("m/d/Y", strtotime($date));
        $mainqty =  0;
        foreach ($qty as $qtymainkey => $qtymainvalue) {
            $mainqty += $qtymainvalue;
        }
        $datastock = [
            'stock_date' => $request->stock_date,
            'vendor_id' => $request->vendor_id,
            'company_id' => $request->branch_id,
            'total_amount' => $request->finaltotal_amount,
            'gadhiL' => $Lgadhi,
            'qty' => $mainqty
        ];
        $id = Stock::insertGetId($datastock);
        foreach ($itemid as $key => $itemidvalue) {
            $datastockitem[] = [
                'stock_id' => $id,
                'item_id' => $itemidvalue,
                'branch_id' => $request->branch_id,
                'stock_quantity' => $qty[$key],
                'stock_amount' => $amount[$key],
                'itemtotalamount' => $totalamount[$key],
                'unit' => $unit[$key],
                'gadhiL' => $itemgadhidata[$key]
            ];;
        }
        foreach ($datastockitem as $stockitemvalue) {
            StockItem::insertGetId($stockitemvalue);
        }
        return redirect()->route('admin.stock.in.list')->with('success','stock created successfully.');

    }
    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $stock = Stock::where('id', $id)->first();
            $stockItem = StockItem::where('stock_id', $id)->join('item', 'stock_item.item_id', '=', 'item.id')->get();
            $unit_list = Unit::orderBy('unit_name')->get();
            $item_list = Item::select('item.*','unit.unit_name','unit.unit_code')->join('unit', 'item.unit_id', '=', 'unit.id')->orderBy('item_name')->get();
            $user_list = User::where('type', '1')->orderBy('name')->get();
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
                'branch_id' => $request->branch_id,
                'item_id' => $itemidvalue,
                'stock_quantity' => $stock_quantity[$key],
                'stock_amount' => $stock_amount[$key],
                'itemtotalamount' => $itemtotalamount[$key],
                'unit' => $unit[$key],
                'gadhiL' => $itemgadhidata[$key]
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
