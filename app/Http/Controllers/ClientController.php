<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Dealer;
use App\Machine;
use Session;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    
    public function __construct()
    {
		date_default_timezone_set("Asia/Kolkata");
        $this->middleware('auth');
//       $this->middleware(function ($request, $next) {
//            $this->user= Auth::user();
//
//            return $next($request);
//        });
    }
    
     public function index()
    {
                    
        return view('home');
        //}
    }
    
    public function getClientData() {
        $client_data = DB::table('bil_Registration')->orderBy('rid', 'asc')->get();
        return view('master_data.client_data',['client_data' => $client_data]);
    }   
    
    public function getActivate($id,$val){
//        echo $val;
        $data = \App\Admin::findorfail($id);
//        echo "<pre>";print_r($data);exit;
        $requestdata['activate_flag'] = $val;
        $requestdata['activate_date'] = date("Y-m-d");
        $data->update($requestdata);
    }
}