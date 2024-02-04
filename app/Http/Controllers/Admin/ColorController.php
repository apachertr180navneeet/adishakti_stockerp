<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    Color,
    ColorCombination
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

class ColorController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user_data = auth()->user();

            $color_list = Color::paginate(10);

            return view('admin.color.color_list',compact('user_data','color_list'))->with('i', (request()->input('page', 1) - 1) * 1);
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }




    public function create(){
        if(Auth::check()){
            $user_data = auth()->user();
            $color_list = Color::paginate(10);

            return view('admin.color.color_add',compact('user_data','color_list'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }


    public function store(Request $request){

        $validatedData = $request->validate([
            'color_code' => 'required',
            'color_name' => 'required',
            'rate_per_gram' => 'required',
        ]);

        $name = $request->name;
        $gm = $request->gm;

        $datauser = [
             'color_code' => $request->color_code,
             'color_name' => $request->color_name,
             'rate_per_gram' => $request->rate_per_gram,
        ];

        $id = Color::insertGetId($datauser);

        foreach ($name as $key => $itemidvalue) {
            $datastockitem[] = [
                'color_id' => $id,
                'gram' => $gm[$key],
                'name' => $itemidvalue,
            ];;
        }
        foreach ($datastockitem as $stockitemvalue) {
            ColorCombination::insertGetId($stockitemvalue);
        }


        return redirect()->route('admin.color.list')->with('success','color created successfully.');

    }

    public function edit($id){
        if(Auth::check()){
            $user_data = auth()->user();
            $user = Color::where('id', $id)->first();

            $color_list = Color::paginate(10);
            return view('admin.color.color_edit',compact('user_data','user','color_list'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }

    public function update(Request $request){

        $validatedData = $request->validate([
            'color_code' => 'required',
            'color_name' => 'required',
        ]);
        $id = $request->id;

        $datauser = [
            'color_code' => $request->color_code,
            'color_name' => $request->color_name,
       ];

        Color::where('id', $id)->update($datauser);



        return redirect()->route('admin.color.list')->with('success','color Update successfully.');
    }

    public function delete($id)
    {
        $deleted = Color::where('id', $id)->delete();
        return response()->json(['success'=>'color Deleted Successfully!']);
    }

    public function status(Request $request){

        $id = $request->id;
        $datauser = [
             'status' => $request->status,
        ];


        Color::where('id', $id)->update($datauser);


        return response()->json(['success'=>'Color Status Changes Successfully!']);
    }
}
