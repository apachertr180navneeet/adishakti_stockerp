<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    StockChallan,
    Item,
    Branch,
    ConditionMaster,
    OrderDispatch,
    StockReport
};


use Exception;
use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\{
    Auth,
    Hash,
    Session,
    Storage
};

class StockChallanController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user_data = auth()->user();

            $stock_challan_list = StockChallan::select('stock_challan.id','stock_challan.challan_number','stock_challan.order_date','stock_challan.quantity','stock_challan.rate','stock_challan.customer_id','stock_challan.branch_id','stock_challan.item_id','stock_challan.quantity','stock_challan.status','stock_challan.orderstatus','item.item_name','users.name AS user_name','branch.name AS branch_name')
            ->join('item', 'stock_challan.item_id', '=', 'item.id')
            ->join('users', 'stock_challan.customer_id', '=', 'users.id')
            ->join('branch', 'stock_challan.branch_id', '=', 'branch.id')
            ->orderBy('stock_challan.id', 'desc')
            ->paginate(10);
            $startDate = "";
            $endDate = "";
            return view('admin.stock_challan.stock_challan_list',compact('user_data','stock_challan_list','startDate','endDate'))->with('i', (request()->input('page', 1) - 1) * 1);
        }
        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();
            $item_list = Item::get();
            $user_list = User::where('type', '3')->get();
            $branch_list = Branch::get();
            $condition_list = ConditionMaster::get();
            $challannumber = 'ORD'.'-'.strtotime(Carbon::now());

            return view('admin.stock_challan.stock_challan_add',compact('user_data','item_list','challannumber','user_list','branch_list','condition_list'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function store(Request $request){

        $validatedData = $request->validate([
            'stock_dispatch_date' => 'required',
        ]);
        $conditionmaster = $request->conditionmaster;
        $condition = json_encode($conditionmaster);
        $datauser = [
            'challan_number' => $request->challan_number,
            'order_date' => $request->stock_dispatch_date,
            'customer_id' => $request->customer_id,
            'item_id' => $request->item_id,
            'branch_id' => $request->branch_id,
            'quantity' => $request->quantity,
            'rate' => $request->rate,
            'actualconditionmaster' => $condition,
        ];
        $id = StockChallan::insertGetId($datauser);

        $itemid = $request->item_id;
        $quantity = $request->quantity;
        $stockreporthcheck = StockReport::where('item_id', '=', $itemid)->first();
        if(empty($stockreporthcheck)){
            $dataReport = [
                'item_id' => $itemid,
                'quantity' => $quantity,
            ];
            StockReport::insertGetId($dataReport);
        }else{
            $oldqty = $stockreporthcheck->quantity;
            $testqty = $oldqty + $quantity;
            StockReport::where('item_id', $itemid)->update(['quantity' => $testqty]);
        }


        return redirect()->route('admin.stock.challan.list')->with('success','Order created successfully.');

    }
    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $user = StockChallan::where('id', $id)->first();
            $item_list = Item::get();
            $user_list = User::where('type', '3')->get();
            $branch_list = Branch::get();
            $condition_list = ConditionMaster::get();
            $actualdata = json_decode($user->actualconditionmaster, true);



            return view('admin.stock_challan.stock_challan_edit',compact('user_data','user','item_list','user_list','branch_list','condition_list','actualdata'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function update(Request $request){
        $validatedData = $request->validate([
            'stock_dispatch_date' => 'required',
        ]);

        $id = $request->id;

        $conditionmaster = $request->conditionmaster;
        $condition = json_encode($conditionmaster);
        $datauser = [
            'challan_number' => $request->challan_number,
            'order_date' => $request->stock_dispatch_date,
            'customer_id' => $request->customer_id,
            'item_id' => $request->item_id,
            'branch_id' => $request->branch_id,
            'quantity' => $request->quantity,
            'rate' => $request->rate,
            'actualconditionmaster' => $condition,
        ];

        StockChallan::where('id', $id)->update($datauser);



        return redirect()->route('admin.stock.challan.list')->with('success','Order Update successfully.');
    }
    public function delete($id)
    {
        $deleted = StockChallan::where('id', $id)->delete();

        return response()->json(['success'=>'stock_challan Deleted Successfully!']);
    }
    public function status(Request $request){

        $id = $request->id;
        $datauser = [
             'status' => $request->status,
        ];


        StockChallan::where('id', $id)->update($datauser);


        return response()->json(['success'=>'stock_challan Status Changes Successfully!']);
    }
    public function serach(){
        if(Auth::check()){
            $user_data = auth()->user();
            if(!empty($_GET['startDate'])){
                $startDate = date($_GET['startDate']);
                $startDateFormat = date("Y-m-d", strtotime($startDate));
                $endDate = date($_GET['endDate']);
                $endDateFormat = date("Y-m-d", strtotime($endDate));
                $stock_challan_list = StockChallan::select('stock_challan.id','stock_challan.challan_number','stock_challan.stock_dispatch_date','stock_challan.customer_id','stock_challan.address','stock_challan.item_id','stock_challan.quantity','stock_challan.status','item.item_name','users.name AS user_name')->join('item', 'stock_challan.item_id', '=', 'item.id')->where('stock_date', '>=', $startDateFormat)->where('stock_date', '<=', $endDateFormat)->join('users', 'stock_challan.customer_id', '=', 'users.id')->paginate(10);
            }
            return view('admin.stock_challan.stock_challan_list',compact('user_data','stock_challan_list','startDate','endDate'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function order_dispatch($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $orderlist = StockChallan::where('stock_challan.id', $id)
            ->select('stock_challan.id','stock_challan.challan_number','stock_challan.order_date','stock_challan.customer_id','stock_challan.branch_id','stock_challan.actualconditionmaster','stock_challan.item_id','stock_challan.quantity','stock_challan.rate','stock_challan.status','item.item_name','users.name AS user_name','branch.name AS branch_name')
            ->join('item', 'stock_challan.item_id', '=', 'item.id')
            ->join('users', 'stock_challan.customer_id', '=', 'users.id')
            ->join('branch', 'stock_challan.branch_id', '=', 'branch.id')->first();
            $conditiondata = json_decode($orderlist->actualconditionmaster, true);
            $challannumber = 'ORDDP'.'-'.strtotime(Carbon::now());
            $now = Carbon::now();
            $CurrentformattedDate = $now->format('Y-m-d');
            $condition_list = ConditionMaster::get();
            return view('admin.stock_challan.order_dispatch',compact('user_data','orderlist','challannumber','CurrentformattedDate','condition_list','conditiondata'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function order_dispatch_update(Request $request){

        $orderid = $request->id;
        $conditionmaster = $request->conditionmaster;
        $condition = json_encode($conditionmaster);
        $orderlist = StockChallan::where('id', $orderid)->first();

        $newqty = $orderlist->quantity - $request->qty;
        $number = floatval($newqty);
        if ($number < 0) {
            return redirect()->back()->with('error','Quantity is not valid.');
        }

        $datauser = [
            'order_dispatch_date' => $request->orderdispatchdate,
            'order_dispatch_number' => $request->orderdispatchnumber,
            'qty' => $request->qty,
            'rate' => $request->rate,
            'order_id' => $request->id,
            'amount' => $request->total_amount,
            'conditionmaster' => $condition,
        ];

        $id = OrderDispatch::insertGetId($datauser);

        $dataqty = [
            'quantity' => $newqty,
        ];


        StockChallan::where('id', $orderid)->update($dataqty);
        if($number == '0'){
            $datauser = [
                'orderstatus' => '1',
            ];

            StockChallan::where('id', $orderid)->update($datauser);
        }

        if(!empty($request->complete)){
            $datauser = [
                'orderstatus' => $request->complete,
            ];

            StockChallan::where('id', $orderid)->update($datauser);
        }


        return redirect()->route('admin.order.dispatch.list')->with('success','Order Created created successfully.');
    }
    public function order_dispatch_list(){
        if(Auth::check()){
            $user_data = auth()->user();
            $stock_challan_list = OrderDispatch::select('order_dispatch.id','order_dispatch.order_dispatch_date','order_dispatch.order_dispatch_number','order_dispatch.qty','order_dispatch.rate','order_dispatch.order_id','order_dispatch.amount','stock_challan.branch_id','stock_challan.challan_number','stock_challan.item_id','stock_challan.quantity','stock_challan.status','item.item_name','users.name AS user_name','branch.name AS branch_name')
            ->join('stock_challan', 'order_dispatch.order_id', '=', 'stock_challan.id')
            ->join('item', 'stock_challan.item_id', '=', 'item.id')
            ->join('users', 'stock_challan.customer_id', '=', 'users.id')
            ->join('branch', 'stock_challan.branch_id', '=', 'branch.id')
            ->paginate(10);
            $startDate = "";
            $endDate = "";
            return view('admin.stock_challan.order_dispatch_list',compact('user_data','stock_challan_list','startDate','endDate'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function order_dispatch_view($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $orderlist = OrderDispatch::select('order_dispatch.id','order_dispatch.order_dispatch_date','order_dispatch.order_dispatch_number','order_dispatch.conditionmaster','order_dispatch.qty','order_dispatch.rate','order_dispatch.order_id','order_dispatch.amount','stock_challan.branch_id','stock_challan.challan_number','stock_challan.item_id','stock_challan.quantity','stock_challan.status','item.item_name','users.name AS user_name','branch.name AS branch_name')
            ->where('order_dispatch.id',$id)
            ->join('stock_challan', 'order_dispatch.order_id', '=', 'stock_challan.id')
            ->join('item', 'stock_challan.item_id', '=', 'item.id')
            ->join('users', 'stock_challan.customer_id', '=', 'users.id')
            ->join('branch', 'stock_challan.branch_id', '=', 'branch.id')
            ->first();

            $conditiondata = json_decode($orderlist->conditionmaster, true);

            return view('admin.stock_challan.order_dispatch_view',compact('user_data','orderlist','conditiondata'));
        }
        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
}
