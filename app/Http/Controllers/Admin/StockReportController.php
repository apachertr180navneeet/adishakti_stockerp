<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    StockReport,
    StockChallan,
    StockMaterialManagemnt,
    StockMaterialProduction,
    StockMaterialConsumoption,
    StockMaterialOverhead,
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


use Carbon\Carbon;

class StockReportController extends Controller
{
    public function total_stock_report(){
        if(Auth::check()){
            $user_data = auth()->user();
            $branch_list = Company::where('status', '1')->get();
            $currentDate = Carbon::now();
            $formattedDate = $currentDate->format('Y-m-d');
            $branch = "";

            $stock_report = StockReport::select('stock_report.id','stock_report.item_id','stock_report.branch_id','stock_report.quantity','item.item_name','item.unit_id','company.name as branch_name','unit.unit_code as unit_name')
            ->join('item', 'stock_report.item_id', '=', 'item.id')
            ->join('unit', 'item.unit_id', '=', 'unit.id')
            ->join('company', 'stock_report.branch_id', '=', 'company.id')
            ->get();
            $startDate = $formattedDate;
            $endDate = $formattedDate;


            return view('admin.stockreport.stock_report',compact('user_data','stock_report','startDate','endDate','branch_list','branch'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }

    public function total_stock_report_filter(Request $request){
        if(Auth::check()){
            $branch = $request->branch;
            $user_data = auth()->user();
            $branch_list = Company::where('status', '1')->get();
            $startDate = $request->from;
            $endDate = $request->to;

            $stock_report = StockReport::select('stock_report.id','stock_report.item_id','stock_report.branch_id','stock_report.quantity','item.item_name','item.unit_id','company.name as branch_name','unit.unit_code as unit_name')
            ->where('branch_id', $branch)
            ->whereBetween(DB::raw('DATE(stock_report.created_at)'), [$startDate, $endDate])
            ->join('item', 'stock_report.item_id', '=', 'item.id')
            ->join('unit', 'item.unit_id', '=', 'unit.id')
            ->join('company', 'stock_report.branch_id', '=', 'company.id')
            ->get();

            return view('admin.stockreport.stock_report',compact('user_data','stock_report','startDate','endDate','branch_list','branch'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }

    public function pending_order_report(){
        if(Auth::check()){
            $user_data = auth()->user();
            $branch_list = Company::where('status', '1')->get();
            $currentDate = Carbon::now();
            $formattedDate = $currentDate->format('Y-m-d');
            $branch = "";
            $startDate = $formattedDate;
            $endDate = $formattedDate;

            $order_pending_report = StockChallan::select('stock_challan.id','stock_challan.challan_number','stock_challan.order_date','stock_challan.customer_id','stock_challan.branch_id','stock_challan.item_id','stock_challan.quantity','company.name as branch_name','users.name as users_name','item.item_name as item_name')
            ->join('item', 'stock_challan.item_id', '=', 'item.id')
            ->join('company', 'stock_challan.branch_id', '=', 'company.id')
            ->join('users', 'stock_challan.customer_id', '=', 'users.id')
            ->get();

            return view('admin.stockreport.pendin_order_report',compact('user_data','order_pending_report','startDate','endDate','branch_list','branch'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }

    public function pending_order_report_filter(Request $request){
        if(Auth::check()){
            $user_data = auth()->user();
            $branch_list = Company::where('status', '1')->get();
            $branch = $request->branch;
            $startDate = $request->from;
            $endDate = $request->to;

            $order_pending_report = StockChallan::select('stock_challan.id','stock_challan.challan_number','stock_challan.order_date','stock_challan.customer_id','stock_challan.branch_id','stock_challan.item_id','stock_challan.quantity','stock_challan.created_at as stock_challan_created_at','stock_challan.quantity as stock_challan_qty','company.name as branch_name','users.name as users_name','item.item_name as item_name')
            ->where('stock_challan.branch_id', $branch)
            ->whereBetween(DB::raw('DATE(stock_challan.created_at)'), [$startDate, $endDate])
            ->join('item', 'stock_challan.item_id', '=', 'item.id')
            ->join('company', 'stock_challan.branch_id', '=', 'company.id')
            ->join('users', 'stock_challan.customer_id', '=', 'users.id')
            ->get();

            return view('admin.stockreport.pendin_order_report',compact('user_data','order_pending_report','startDate','endDate','branch_list','branch'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }

    public function consumption_order_report(){
        if(Auth::check()){
            $user_data = auth()->user();
            $branch_list = Company::where('status', '1')->get();
            $currentDate = Carbon::now();
            $formattedDate = $currentDate->format('Y-m-d');
            $branch = "";
            $startDate = $formattedDate;
            $endDate = $formattedDate;

            $consumption_order_report = StockMaterialManagemnt::select('stock_material_managemnt.id','stock_material_managemnt.source_location','stock_material_managemnt.destination_location','stock_meterial_consumption.counsumption_item_id','stock_meterial_consumption.created_at as consumption_created_at','stock_meterial_consumption.qty as consumption_qty','item.item_name','company.name as branch_name')
            ->join('stock_meterial_consumption', 'stock_material_managemnt.id', '=', 'stock_meterial_consumption.stock_material_id')
            ->join('item', 'stock_meterial_consumption.counsumption_item_id', '=', 'item.id')
            ->join('company', 'stock_material_managemnt.source_location', '=', 'company.id')
            ->get();

            return view('admin.stockreport.consumption_item_report',compact('user_data','consumption_order_report','startDate','endDate','branch_list','branch'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }

    public function consumption_order_report_filter(Request $request){
        if(Auth::check()){
            $user_data = auth()->user();
            $branch_list = Company::where('status', '1')->get();
            $branch = $request->branch;
            $startDate = $request->from;
            $endDate = $request->to;

            $consumption_order_report = StockMaterialManagemnt::select('stock_material_managemnt.id','stock_material_managemnt.source_location','stock_material_managemnt.destination_location','stock_meterial_consumption.counsumption_item_id','stock_meterial_consumption.created_at as consumption_created_at','stock_meterial_consumption.qty as consumption_qty','item.item_name','company.name as branch_name')
            ->join('stock_meterial_consumption', 'stock_material_managemnt.id', '=', 'stock_meterial_consumption.stock_material_id')
            ->join('item', 'stock_meterial_consumption.counsumption_item_id', '=', 'item.id')
            ->join('company', 'stock_material_managemnt.source_location', '=', 'company.id')
            ->where('stock_material_managemnt.destination_location', $branch)
            ->whereBetween(DB::raw('DATE(stock_meterial_consumption.created_at)'), [$startDate, $endDate])
            ->get();

            return view('admin.stockreport.consumption_item_report',compact('user_data','consumption_order_report','startDate','endDate','branch_list','branch'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }

    public function pending_report(){
        if(Auth::check()){
            $user_data = auth()->user();
            $branch_list = Company::where('status', '1')->get();
            $currentDate = Carbon::now();
            $formattedDate = $currentDate->format('Y-m-d');
            $branch = "";
            $startDate = $formattedDate;
            $endDate = $formattedDate;

            $order_pending_report = StockChallan::select('stock_challan.id','stock_challan.challan_number','stock_challan.conditionmaster','stock_challan.actualconditionmaster','stock_challan.order_date','stock_challan.customer_id','stock_challan.branch_id','stock_challan.item_id','stock_challan.quantity','company.name as branch_name','users.name as users_name','item.item_name as item_name')
            ->join('item', 'stock_challan.item_id', '=', 'item.id')
            ->join('company', 'stock_challan.branch_id', '=', 'company.id')
            ->join('users', 'stock_challan.customer_id', '=', 'users.id')
            ->get();

            return view('admin.stockreport.pending_report',compact('user_data','order_pending_report','startDate','endDate','branch_list','branch'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }


    public function pending_report_filter(Request $request){
        if(Auth::check()){
            $user_data = auth()->user();
            $branch_list = Company::where('status', '1')->get();
            $branch = $request->branch;
            $startDate = $request->from;
            $endDate = $request->to;

            $order_pending_report = StockChallan::select('stock_challan.id','stock_challan.challan_number','stock_challan.conditionmaster','stock_challan.actualconditionmaster','stock_challan.order_date','stock_challan.customer_id','stock_challan.branch_id','stock_challan.item_id','stock_challan.quantity','company.name as branch_name','users.name as users_name','item.item_name as item_name')
            ->where('stock_challan.branch_id', $branch)
            ->whereBetween(DB::raw('DATE(stock_challan.order_date)'), [$startDate, $endDate])
            ->join('item', 'stock_challan.item_id', '=', 'item.id')
            ->join('company', 'stock_challan.branch_id', '=', 'company.id')
            ->join('users', 'stock_challan.customer_id', '=', 'users.id')
            ->get();

            return view('admin.stockreport.pending_report',compact('user_data','order_pending_report','startDate','endDate','branch_list','branch'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
}
