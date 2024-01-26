<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    Branch,
    Unit,
    Item
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

class ItemController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user_data = auth()->user();

            $item_list = Item::select('item.id','item.item_name','item.item_description','unit.unit_code','item.status')->join('unit', 'item.unit_id', '=', 'unit.id')->paginate(10);
            
           
            return view('admin.item.item_list',compact('user_data','item_list'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }




    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();
            $unit_list = Unit::get();
            $user_list = User::where('type', '1')->get();
            
            
            return view('admin.item.item_add',compact('user_data','unit_list','user_list'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }


    public function store(Request $request){

        $validatedData = $request->validate([
            'item' => 'required',
        ]);

        $datauser = [
            'item_name' => $request->item,
            'item_description' => $request->description,
            'unit_id' => $request->unit_id
        ];

        $id = Item::insertGetId($datauser);


        return redirect()->route('admin.item.list')->with('success','item created successfully.');

    }
       
    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $user = Item::where('id', $id)->first();
            

            $unit_list = Unit::get();
            $user_list = User::where('type', '1')->get();

            
            return view('admin.item.item_edit',compact('user_data','user','unit_list','user_list'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
        
    public function update(Request $request){
        $validatedData = $request->validate([
            'item' => 'required',
        ]);

        $id = $request->id;
        $datauser = [
            'item_name' => $request->item,
            'item_description' => $request->description,
            'unit_id' => $request->unit_id
        ];

        Item::where('id', $id)->update($datauser);



        return redirect()->route('admin.item.list')->with('success','item Update successfully.');
    }

    public function delete($id)
    {
        $deleted = Item::where('id', $id)->delete();
        return response()->json(['success'=>'item Deleted Successfully!']);
    }
    
    public function status(Request $request){
        
        $id = $request->id;
        $datauser = [
             'status' => $request->status,
        ];

        
        Item::where('id', $id)->update($datauser);


        return response()->json(['success'=>'item Status Changes Successfully!']);
    }
}