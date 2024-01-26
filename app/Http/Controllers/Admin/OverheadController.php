<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    Overhead
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

class OverheadController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user_data = auth()->user();

            $overhead_list = Overhead::paginate(10);
            
            return view('admin.overhead.overhead_list',compact('user_data','overhead_list'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }




    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();
            
            return view('admin.overhead.overhead_add',compact('user_data'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }


    public function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $datauser = [
             'name' => $request->name,
        ];

        $id = Overhead::insertGetId($datauser);


        return redirect()->route('admin.overhead.list')->with('success','Overhead created successfully.');

    }
       
    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $user = Overhead::where('id', $id)->first();

            
            return view('admin.overhead.overhead_edit',compact('user_data','user'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }
        
    public function update(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $id = $request->id;
        $datauser = [
             'name' => $request->name,
        ];

        Overhead::where('id', $id)->update($datauser);



        return redirect()->route('admin.overhead.list')->with('success','Overhead Update successfully.');
    }

    public function delete($id)
    {
        $deleted = Overhead::where('id', $id)->delete();
        return response()->json(['success'=>'Overhead Deleted Successfully!']);
    }
    
    public function status(Request $request){
        
        $id = $request->id;
        $datauser = [
             'status' => $request->status,
        ];

        
        Overhead::where('id', $id)->update($datauser);


        return response()->json(['success'=>'Overhead Status Changes Successfully!']);
    }
}
