<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    Branch,
    Unit,
    Item,
    DebitNote,
    DebitNoteItem
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

class DebitNoteController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user_data = auth()->user();
            $DebitNoteList = DebitNote::select('debit_note.id','debit_note.debit_note','debit_note.debit_date','debit_note.type','debit_note.user_id','debit_note.branch_id','debit_note.grand_total','debit_note.add_amount','debit_note.final_amunt','debit_note.status')->paginate(10);

            $startDate = "";
            $endDate = "";
            
            return view('admin.debitnote.debitnote_list',compact('user_data','DebitNoteList','startDate','endDate'))->with('i', (request()->input('page', 1) - 1) * 1);
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
            $debitnotenumber = strtotime(Carbon::now());
            
            return view('admin.debitnote.debitnote_add',compact('user_data','unit_list','user_list','item_list','branch_list','debitnotenumber'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
    public function store(Request $request){


        $validatedData = $request->validate([
            'debit_date' => 'required',
        ]);
        $debit_item_id = $request->debit_item_id;
        $qty = $request->qty;
        $amount = $request->rate;
        $totalamount = $request->totalamount;

        $datastock = [
            'debit_note' => $request->debit_note_id,
            'debit_date' => $request->debit_date,
            'type' => $request->type,
            'user_id' => isset($request->user_id) ?$request->user_id:'0',
            'branch_id' => isset($request->branch_id) ?$request->branch_id:'0',
            'grand_total' => $request->grand_total,
            'add_amount' => $request->add_amount,
            'final_amunt' => $request->final_amunt
        ];

        $id = DebitNote::insertGetId($datastock);
        foreach ($debit_item_id as $key => $itemidvalue) {
            $datastockitem[] = [
                    'debit_note_id' => $id,
                    'item_id' => $itemidvalue,
                    'debit_quantity' => $qty[$key],
                    'debit_amount' => $amount[$key],
                    'debit_total_amount' => $totalamount[$key],
                ];
        }

        foreach ($datastockitem as $stockitemvalue) {
            DebitNoteItem::insertGetId($stockitemvalue);
        }


        return redirect()->route('admin.debit.note.list')->with('success','Debit Note created successfully.');

    }
       
    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $debitnote = DebitNote::where('id', $id)->first();
            $debitnoteItem = DebitNoteItem::where('debit_note_id', $id)->join('item', 'debit_note_item.item_id', '=', 'item.id')->get();
            $unit_list = Unit::get();
            $item_list = Item::get();
            $user_list = User::where('type', '2')->get();
            $branch_list = Branch::get();            
            return view('admin.debitnote.debitnote_edit',compact('user_data','unit_list','user_list','item_list','branch_list','debitnote','debitnoteItem'));
        }
        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
        
    public function update(Request $request){
        $validatedData = $request->validate([
            'debit_date' => 'required',
        ]);
        $stockitemid = $request->stockitemid;
        if(empty($stockitemid)){
            return redirect()->back()->with(['danger' => 'At least one item to select']);
        }
        $stock_quantity = $request->stock_quantity;
        $stock_amount = $request->stock_amount;
        $itemtotalamount = $request->itemtotalamount;
        $id = $request->id;
        $datastock = [
            'debit_note' => $request->debit_note_id,
            'debit_date' => $request->debit_date,
            'type' => $request->type,
            'user_id' => isset($request->user_id) ?$request->user_id:'0',
            'branch_id' => isset($request->branch_id) ?$request->branch_id:'0',
            'grand_total' => $request->grand_total,
            'add_amount' => $request->add_amount,
            'final_amunt' => $request->final_amunt
        ];
        DebitNote::where('id', $id)->update($datastock);
        $deleted = DebitNoteItem::where('debit_note_id', $id)->delete();
        foreach ($request->stockitemid as $key => $itemidvalue) {
            $datastockitem[] = [
                'debit_note_id' => $id,
                'item_id' => $itemidvalue,
                'debit_quantity' => $stock_quantity[$key],
                'debit_amount' => $stock_amount[$key],
                'debit_total_amount' => $itemtotalamount[$key],
            ];
        }

        foreach ($datastockitem as $stockitemvalue) {
            DebitNoteItem::insertGetId($stockitemvalue);
        }
        return redirect()->route('admin.debit.note.list')->with('success','Debit Note Update successfully.');
    }

    public function delete($id)
    {
        $deleted = DebitNoteItem::where('debit_note_id', $id)->delete();
        $deleted = DebitNote::where('id', $id)->delete();
        return response()->json(['success'=>'Debit Deleted Successfully!']);
    }
    
    public function status(Request $request){
        $id = $request->id;
        $datauser = [
             'status' => $request->status,
        ];
        DebitNote::where('id', $id)->update($datauser);
        return response()->json(['success'=>'Debit Changes Successfully!']);
    }

    public function search(){
        if(Auth::check()){
            $user_data = auth()->user();
            if(!empty($_GET['startDate'])){
                $startDate = date($_GET['startDate']);
                $startDateFormat = date("Y-m-d", strtotime($startDate));
                $endDate = date($_GET['endDate']);
                $endDateFormat = date("Y-m-d", strtotime($endDate));
                $DebitNoteList = DebitNote::select('debit_note.id','debit_note.debit_note','debit_note.debit_date','debit_note.type','debit_note.user_id','debit_note.branch_id','debit_note.grand_total','debit_note.add_amount','debit_note.final_amunt','debit_note.status')->where('stock_date', '>=', $startDateFormat)->where('stock_date', '<=', $endDateFormat)->paginate(10);
            }
            return view('admin.creditnote.creditnote_list',compact('user_data','CreditNoteList','startDate','endDate'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
}
