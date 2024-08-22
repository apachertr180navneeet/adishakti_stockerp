<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    Branch,
    Unit,
    Item,
    CreditNote,
    CreditNoteItem
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

class CreditNoteController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user_data = auth()->user();
            $CreditNoteList = CreditNote::select('credit_note.id','credit_note.credit_note','credit_note.credit_date','credit_note.type','credit_note.user_id','credit_note.branch_id','credit_note.grand_total','credit_note.add_amount','credit_note.final_amunt','credit_note.status')->paginate(10);
            
            $startDate = "";
            $endDate = "";

            return view('admin.creditnote.creditnote_list',compact('user_data','CreditNoteList','startDate','endDate'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();
            $unit_list = Unit::get();
            $branch_list = Branch::get();
            $user_list = User::where('type', '2')->get();
            $item_list = Item::get();
            $creditnotenumber = strtotime(Carbon::now());
            
            return view('admin.creditnote.creditnote_add',compact('user_data','unit_list','user_list','item_list','branch_list','creditnotenumber'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function store(Request $request){


        $validatedData = $request->validate([
            'credit_date' => 'required',
        ]);
        $credit_item_id = $request->credit_item_id;
        if(empty($credit_item_id)){
            return redirect()->back()->with(['danger' => 'At least one item to select']);
        }
        $qty = $request->qty;
        $amount = $request->rate;
        $totalamount = $request->totalamount;

        $datastock = [
            'credit_note' => $request->credit_note_id,
            'credit_date' => $request->credit_date,
            'type' => $request->type,
            'user_id' => isset($request->user_id) ?$request->user_id:'0',
            'branch_id' => isset($request->branch_id) ?$request->branch_id:'0',
            'grand_total' => $request->grand_total,
            'add_amount' => $request->add_amount,
            'final_amunt' => $request->final_amunt
        ];

        $id = CreditNote::insertGetId($datastock);
        foreach ($credit_item_id as $key => $itemidvalue) {
            $datastockitem[] = [
                    'credit_note_id' => $id,
                    'item_id' => $itemidvalue,
                    'credit_quantity' => $qty[$key],
                    'credit_amount' => $amount[$key],
                    'crdite_total_amount' => $totalamount[$key],
                ];
        }

        foreach ($datastockitem as $stockitemvalue) {
            CreditNoteItem::insertGetId($stockitemvalue);
        }


        return redirect()->route('admin.credit.note.list')->with('success','Credit Note created successfully.');

    }
       
    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $creditnote = CreditNote::where('id', $id)->first();
            $creditnoteItem = CreditNoteItem::where('credit_note_id', $id)->join('item', 'credit_note_item.item_id', '=', 'item.id')->get();
            $unit_list = Unit::get();
            $item_list = Item::get();
            $user_list = User::where('type', '2')->get();
            $branch_list = Branch::get();            
            return view('admin.creditnote.creditnote_edit',compact('user_data','unit_list','user_list','item_list','branch_list','creditnote','creditnoteItem'));
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
            'credit_note' => $request->credit_note_id,
            'credit_date' => $request->credit_date,
            'type' => $request->type,
            'user_id' => isset($request->user_id) ?$request->user_id:'0',
            'branch_id' => isset($request->branch_id) ?$request->branch_id:'0',
            'grand_total' => $request->grand_total,
            'add_amount' => $request->add_amount,
            'final_amunt' => $request->final_amunt
        ];
        CreditNote::where('id', $id)->update($datastock);
        $deleted = CreditNoteItem::where('credit_note_id', $id)->delete();
        foreach ($request->stockitemid as $key => $itemidvalue) {
            $datastockitem[] = [
                'credit_note_id' => $id,
                'item_id' => $itemidvalue,
                'credit_quantity' => $qty[$key],
                'credit_amount' => $amount[$key],
                'crdite_total_amount' => $totalamount[$key],
            ];
        }

        foreach ($datastockitem as $stockitemvalue) {
            CreditNoteItem::insertGetId($stockitemvalue);
        }
        return redirect()->route('admin.credit.note.list')->with('success','Credit Note Update successfully.');
    }

    public function delete($id)
    {
        $deleted = CreditNoteItem::where('credit_note_id', $id)->delete();
        $deleted = CreditNote::where('id', $id)->delete();
        return response()->json(['success'=>'stock Deleted Successfully!']);
    }
    
    public function status(Request $request){
        $id = $request->id;
        $datauser = [
             'status' => $request->status,
        ];
        CreditNote::where('id', $id)->update($datauser);
        return response()->json(['success'=>'stock Status Changes Successfully!']);
    }

    public function search(){
        if(Auth::check()){
            $user_data = auth()->user();
            if(!empty($_GET['startDate'])){
                $startDate = date($_GET['startDate']);
                $startDateFormat = date("Y-m-d", strtotime($startDate));
                $endDate = date($_GET['endDate']);
                $endDateFormat = date("Y-m-d", strtotime($endDate));
                $CreditNoteList = CreditNote::select('credit_note.id','credit_note.credit_note','credit_note.credit_date','credit_note.type','credit_note.user_id','credit_note.branch_id','credit_note.grand_total','credit_note.add_amount','credit_note.final_amunt','credit_note.status')->where('stock_date', '>=', $startDateFormat)->where('stock_date', '<=', $endDateFormat)->paginate(10);
            }
            return view('admin.creditnote.creditnote_list',compact('user_data','CreditNoteList','startDate','endDate'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
}
