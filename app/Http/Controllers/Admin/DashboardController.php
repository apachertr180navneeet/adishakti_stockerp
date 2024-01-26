<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    User,
    Setting
};


use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\{
    Auth,
    Hash,
    Session
};




class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function dashboard()
    {
        if(Auth::check()){
            $user_data = auth()->user();

            $userCount = User::where('type', '1')->count();
            $userCountActive = User::where('type', '1')->where('status', '1')->count();
            $userCountInActive = User::where('type', '1')->where('status', '0')->count();
            
            return view('admin.dashboard.dashboard',compact('user_data','userCount','userCountActive','userCountInActive'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }

    public function setting(){
        if(Auth::check()){
            $user_data = auth()->user();

            $settingdata = Setting::where('id', '1')->first();
            
            return view('admin.setiing.setting_edit',compact('user_data','settingdata'));
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }


    public function edit(Request $request){
       

        $id = $request->id;

        $baseUrl = url('/');



        if(!empty($request->file('vedio')) && empty($request->file('app_logo'))){
            $vedio = $request->file('vedio');
            $vedioname = time().'.'.$vedio->getClientOriginalExtension();
            
            
            
            // File upload location
            $location = 'uploads';
            
            $vedioupload = $baseUrl.'/'.$location.'/'.$filename;
            
            // Upload file
            $vedio->move($location,$vedioname);

            $datauser = [
                'title' => $request->title,
                'app_link' => $request->app_link,
                'vedio' => $vedioupload
           ];
        }elseif(!empty($request->file('app_logo')) && empty($request->file('vedio'))){

            $app_logo = $request->file('app_logo');
            $app_logoname = time().'.'.$app_logo->getClientOriginalExtension();
            
            
            
            // File upload location
            $location = 'uploads';
            
            $app_logonameupload = $baseUrl.'/'.$location.'/'.$app_logoname;
            
            // Upload file
            $app_logo->move($location,$app_logoname);
            $datauser = [
                'title' => $request->title,
                'app_link' => $request->app_link,
                'app_logo' => $app_logonameupload
           ];
        }elseif(!empty($request->file('app_logo')) && !empty($request->file('vedio'))){

            $vedio = $request->file('vedio');
            $vedioname = time().'.'.$vedio->getClientOriginalExtension();
            
            
            
            // File upload location
            $location = 'uploads';
            
            $vedioupload = $baseUrl.'/'.$location.'/'.$filename;
            
            // Upload file
            $vedio->move($location,$vedioname);

            $app_logo = $request->file('app_logo');
            $app_logoname = time().'.'.$app_logo->getClientOriginalExtension();
            
            
            
            // File upload location
            $location = 'uploads';
            
            $app_logonameupload = $baseUrl.'/'.$location.'/'.$app_logoname;
            
            // Upload file
            $app_logo->move($location,$app_logoname);

            $datauser = [
                'title' => $request->title,
                'app_link' => $request->app_link,
                'vedio' => $vedioupload,
                'app_logo' => $app_logonameupload
           ];

        }else{
            $datauser = [
                'title' => $request->title,
                'app_link' => $request->app_link,
           ];
   
        }
        Setting::where('id', $request->id)->update($datauser);


        return redirect()->route('admin.setting')->with('success','Setting created successfully.');
    }

    public function logout() {
        Session::flush();
        Auth::logout();

        return Redirect('admin/login');
    }
}
