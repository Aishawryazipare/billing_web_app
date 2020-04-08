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
        // $this->middleware(function ($request, $next) {
        //     $this->user = Auth::user();

        //     return $next($request);
        // });
    }

    public function index()
    {

        return view('home');
    }

    public function getClientData()
    {
        $client_data = DB::table('bil_Registration')->where('is_active', '0')->orderBy('rid', 'asc')->get();
        return view('master_data.client_data', ['client_data' => $client_data]);
    }

    public function getActivate($id, $val)
    {
        //        echo $val;
        $data = \App\Admin::findorfail($id);
        //        echo "<pre>";print_r($data);exit;
        $requestdata['activate_flag'] = $val;
        $requestdata['activate_date'] = date("Y-m-d");
        $data->update($requestdata);
    }
    public function editClient()
    {
        $id = $_GET['id'];
        // $userData = \App\Employee::findorfail($id);
        $client_data = DB::table('bil_Registration')->where('rid', $id)->first();
        // $client_data = DB::table('bil_Registration')->findOrFail($id);

        return view('master_data.edit_client_data', ['client_data' => $client_data]);
    }

    public function updateClient($id, Request $request)
    {
        $requestdata = $request->all();
        // dd($requestdata);
        if ($requestdata['reg_userpassword'])
            $requestdata['reg_userpassword'] = bcrypt($requestdata['reg_userpassword']);

        if (isset($request->upload_logo)) {
            $design = $request->upload_logo;
            $filename = rand(0, 999) . $design->getClientOriginalName();
            $destination = "logo/";
            $design->move($destination, $filename);
            $requestdata['upload_logo'] = $filename;
        }
        $users = \App\Admin::findorfail($id);
        $users->update($requestdata);
        Session::flash('alert-success', 'Client Data updated Successfully.');
        return redirect('client_data');
    }

    public function deleteClient($id)
    {
        $query = \App\Admin::where('rid', $id)->update(['is_active' => 1]);
        // dd($query);
        // Session::flash('alert-success', 'Deleted Successfully.');
        // return redirect('client_list');
        echo json_encode("deleted");
    }
}
