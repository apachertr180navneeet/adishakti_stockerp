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

use Barryvdh\DomPDF\Facade\Pdf;


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


    public function color_report(Request $request){
        if(Auth::check()){
            $user_data = auth()->user();
            $currentDate = Carbon::now();
            $formattedDate = $currentDate->format('Y-m-d');

            $startDate = $formattedDate;
            $endDate = $formattedDate;
            $branch = "";

            $branch_list = Company::where('status', '1')->get();

            $stock_report = DB::table('color_report')->where('color_report.type','0')->select('color_report.color_id','color_report.branch_id','color_report.qty','color.color_name','company.name')
            ->join('color', 'color_report.color_id', '=', 'color.id')
            ->join('company', 'color_report.branch_id', '=', 'company.id')
            ->get();

            return view('admin.stockreport.color_report',compact('user_data','stock_report','startDate','endDate','branch_list','branch'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }


    public function color_report_filter(Request $request){
        if(Auth::check()){
            $branch = $request->branch;
            $user_data = auth()->user();
            $branch_list = Company::where('status', '1')->get();
            $startDate = $request->from;
            $endDate = $request->to;


            $stock_report = DB::table('color_report')->where('color_report.type','0')->select('color_report.color_id','color_report.branch_id','color_report.qty','color.color_name','company.name')
            ->where('color_report.branch_id', $branch)
            ->whereBetween(DB::raw('DATE(color_report.created_at)'), [$startDate, $endDate])
            ->join('color', 'color_report.color_id', '=', 'color.id')
            ->join('company', 'color_report.branch_id', '=', 'company.id')
            ->get();

            return view('admin.stockreport.color_report',compact('user_data','stock_report','startDate','endDate','branch_list','branch'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }


    public function chemical_report(Request $request){
        if(Auth::check()){
            $branch ="";
            $user_data = auth()->user();
            $branch_list = Company::where('status', '1')->get();
            $startDate = $request->from;
            $endDate = $request->to;


            $stock_report = DB::table('color_report')->where('color_report.type','1')->select('color_report.color_id','color_report.qty','condition_master.name','company.name as company_name')
            ->join('condition_master', 'color_report.color_id', '=', 'condition_master.id')
            ->join('company', 'color_report.branch_id', '=', 'company.id')
            ->get();

            return view('admin.stockreport.chemical_report',compact('user_data','stock_report','startDate','endDate','branch_list','branch'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }


    public function chemical_report_filter(Request $request){
        if(Auth::check()){
            $branch = $request->branch;
            $user_data = auth()->user();
            $branch_list = Company::where('status', '1')->get();
            $startDate = $request->from;
            $endDate = $request->to;

            $stock_report = DB::table('color_report')->where('color_report.type','1')->select('color_report.color_id','color_report.qty','condition_master.name','company.name as company_name')
            ->where('color_report.branch_id', $branch)
            ->whereBetween(DB::raw('DATE(color_report.created_at)'), [$startDate, $endDate])
            ->join('condition_master', 'color_report.color_id', '=', 'condition_master.id')
            ->join('company', 'color_report.branch_id', '=', 'company.id')
            ->get();

            return view('admin.stockreport.chemical_report',compact('user_data','stock_report','startDate','endDate','branch_list','branch'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }


    public function machine_report(Request $request){
        if(Auth::check()){
            $user_data = auth()->user();

            $currentDate = Carbon::now();
            $formattedDate = $currentDate->format('Y-m-d');
            $startDate = $formattedDate;
            $endDate = $formattedDate;
            $branch_list = Company::where('status', '1')->get();
            $branch = "";

            $stock_report = DB::table('stock_material_managemnt')->select('stock_material_managemnt.id','stock_material_managemnt.excute_date','stock_material_managemnt.marka','stock_material_managemnt.stock_material_managemnt_date','stock_material_managemnt.excute_date','stock_material_managemnt.machine_name')->where('stock_material_managemnt.excute_date',$formattedDate)->where('stock_material_managemnt.source_location',$branch)
            ->get();

            return view('admin.stockreport.machine_report',compact('user_data','stock_report','startDate','branch_list','branch'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }


    public function machine_report_filter(Request $request){
        if(Auth::check()){
            $user_data = auth()->user();
            $startDate = $request->from;
            //$startDate = $currentDate->format('Y-m-d');
            $branch_list = Company::where('status', '1')->get();
            $branch = $request->branch;


            $stock_report = DB::table('stock_material_managemnt')->select('stock_material_managemnt.id','stock_material_managemnt.excute_date','stock_material_managemnt.marka','stock_material_managemnt.stock_material_managemnt_date','stock_material_managemnt.excute_date','stock_material_managemnt.machine_name')->where('stock_material_managemnt.excute_date',$startDate)->where('stock_material_managemnt.source_location',$branch)
            ->get();

            return view('admin.stockreport.machine_report',compact('user_data','stock_report','startDate','branch_list','branch'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
}
