<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Table;
use App\Category;
use App\Subscription;
use Session;
use Illuminate\Support\Facades\Auth;

class TableReportController extends Controller
{
    public function __construct()
    {
		date_default_timezone_set("Asia/Kolkata");
       $this->middleware('auth.basic');
       $this->middleware(function ($request, $next) {
            $this->user= Auth::user();
            $this->admin = Auth::guard('admin')->user();
            $this->employee = Auth::guard('employee')->user();
            return $next($request);
        });
    }
    
    //Type 
    public function view_report() {
        $location_data=$employee_data='';
        if(Auth::guard('admin')->check())
            {
            $id = $this->admin->rid;
            $table_data = DB::table('bil_add_table')->where(['cid'=>$id])->get();
            $waiter_data = DB::table('bil_add_waiter')->where(['cid'=>$id])->get();
             if($this->admin->location=="multiple")
          {
               $location_data= \App\EnquiryLocation::select('*')->where(['cid'=>$id])->get();
          }
         
          $employee_data= \App\Employee::select('*')->where(['cid'=>$id])->get();
        }
        else if(Auth::guard('web')->check()){
            $table_data = DB::table('bil_add_table')->get();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
            
            
            if($client_data->location == "single" && $role == 2)
            {
                $table_data = DB::table('bil_add_table')->where(['cid'=>$cid])->get();
                $waiter_data = DB::table('bil_add_waiter')->where(['cid'=>$cid])->get();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
               
                if($sub_emp_id != "")
                {
                    $table_data = DB::table('bil_add_table')
                            ->where(['cid'=>$cid,'lid'=>$lid])
                            ->orWhere(['emp_id'=>$sub_emp_id])
                            ->orWhere(['emp_id'=>$emp_id])
                            ->get();
                    $waiter_data = DB::table('bil_add_waiter')
                            ->where(['cid'=>$cid,'lid'=>$lid])
                            ->orWhere(['emp_id'=>$sub_emp_id])
                            ->orWhere(['emp_id'=>$emp_id])
                            ->get();
                }
                else
                {
                    $table_data = DB::table('bil_add_table')->where(['cid'=>$cid,'lid'=>$lid])->get();
                    $waiter_data = DB::table('bil_add_waiter')->where(['cid'=>$cid,'lid'=>$lid])->get();
                }
                
            }
            else if($client_data->location == "multiple" && $role == 1)
            {
                $table_data = DB::table('bil_add_table')->where(['cid'=>$cid,'lid'=>$lid])->get();
                $waiter_data = DB::table('bil_add_waiter')->where(['cid'=>$cid,'lid'=>$lid])->get();
            }
        }
        return view('reports.table.table_report',['table_data' => $table_data,'location_data'=>$location_data,'employee_data'=>$employee_data]);
    }
    
    public function fetchSale(Request $request)
    {
         $requestData = $request->all();
         $total_amount=0;
         $result=array();
        $from_date = $requestData["from_date"];
        if(!empty($requestData["to_date"]))
         $to_date = $requestData["to_date"];
        else
          $to_date = $from_date;
        
         $from_date = date($from_date . ' 00:00:00', time());
         $to_date   = date($to_date . ' 22:00:40', time());
           
         if(Auth::guard('admin')->check()){
              $cid = $this->admin->rid;
              if(isset($requestData['location']))
              {
                 
                  $lid=$requestData['location'];
                 //  echo $lid;exit;
                  if($lid=="all")
                  {
                        if(isset($requestData['employee']))
                        {
                             $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'emp_id'=>$requestData['employee'],'isactive'=>0])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                        }
                        else
                        {
                             $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'isactive'=>0])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                        }
                     
                  }
                  else
                  {
                      if(isset($requestData['employee']))
                      {
                           $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'emp_id'=>$requestData['employee'],'isactive'=>0])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                      }
                      else
                      {
                           $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                      }
                      
                  }
              }
            else {
                   if(isset($requestData['employee']))
                   {
                          $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'emp_id'=>$requestData['employee'],'isactive'=>0])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                   }
                   else
                   {
                    //   echo "in else".$from_date."&".$to_date;
                       $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'isactive'=>0])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                   }
              
            }
 
           
         
         }
         else if(Auth::guard('web')->check()){
             $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                      ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
         }
          else if(Auth::guard('employee')->check()){
             $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
            
            // echo $client_data->location."".$role;exit;
            if($client_data->location == "single" && $role == 2)
            {
                 $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                    ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'isactive'=>0])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
//                echo "Lid".$lid."<br/>CID: ".$cid."<br/>Emp ID: ".$emp_id."<br/>Sub Emp ID: ".$sub_emp_id."<br>";
//                    echo "in if";echo $emp_id;
                if($sub_emp_id != "")
                {
                 //   echo "in sub if";
                    
                    $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0])
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
        
                }
                else
                {
                      $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                      ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                }
            }
             else if($client_data->location == "multiple" && $role == 1)
            {
                $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                      ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
             }
          }
            $i=1;
            $result_final=array();
          // echo "<pre/>";print_r($bill_data);exit;
         foreach($bill_data as $data)
         {
             $total_amount = $total_amount + $data->bill_totalamt;
             $result_data['bill_no']=$data->bill_no;
             $customer_data= \App\Customer::select('*')->where(['cust_id'=>$data->cust_id])->first();
             if(!empty($customer_data))
			 {
              $result_data['cust_name']=$customer_data->cust_name;
			 }
             else
			 {
				if($data->cust_name==NULL)
				$data->cust_name="";
               $result_data['cust_name']=$data->cust_name;
			 }
            
             $result_data['bill_totalamt']=$data->bill_totalamt;
             $result_data['cash_or_credit']=$data->cash_or_credit;
             //echo $data->point_of_contact;
             $point_of_data= \App\PointOfContact::select('*')->where(['id'=>$data->point_of_contact])->first();
           
             if(!empty($point_of_data))
              $result_data['point_of_contact']=$point_of_data->point_of_contact;
             else
               $result_data['point_of_contact']='';
             // echo "<pre/>";            print_r($result_data);
             if(isset($requestData['location']))
             {
             $location_data= \App\EnquiryLocation::select('*')->where(['loc_id'=>$data->lid])->first();
            $result_data['loc_name']=$location_data->loc_name;
             }
             else
             {
                  $result_data['loc_name']='Own';
             }
		//	 echo "CID=".$data->cid;
		//	 echo "LID=".$data->lid;
			// echo $data->emp_id;
             $user_data= \App\Employee::select('*')->where(['cid'=>$data->cid,'lid'=>$data->lid,'id'=>$data->emp_id])->first();
			//echo "<pre/>";print_r($user_data);exit;
             if(!empty($user_data))
             {
               
              $result_data['user']=$user_data->name;  
             }
            else
			{
				 $admin_data= \App\Admin::select('*')->where(['rid'=>$data->cid])->first();
            $result_data['user']=$admin_data->reg_personname;  
			}
			 $result_data['date']=$data->bill_date;  	
             array_push($result_final, $result_data);
         }
		// exit;
         $result['amount']=round($total_amount,2);
         $result['other_data']=$result_final;
         echo json_encode($result);
         
    }

    
    public function editTable()
    {
        $table_id=$_GET['table_id'];
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $query = Table::where('table_id', $table_id)->where(['is_active' => '0','cid'=>$id])->first();
        }else if(Auth::guard('web')->check()){
            $query = Table::where('table_id', $table_id)->where(['is_active' => '0'])->first();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
            if($client_data->location == "single" && $role == 2){
                $query = Table::where('table_id', $table_id)->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])->first();
            }
            else
            {
                $query = Type::where('table_id', $table_id)->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])
                        ->first();
            }
        }
        return view('master_data.table.edit_table',['table_data' => $query]);
    }
    
    public function addTable(Request $request) {
        $requestData = $request->all();
        if(Auth::guard('admin')->check()){
            $requestData['cid'] = $this->admin->rid;
        }
        else if(Auth::guard('employee')->check()){
            $requestData['cid'] = $this->employee->cid;
            $requestData['lid'] = $this->employee->lid;
            $requestData['emp_id'] = $this->employee->id;
        }
        Table::create($requestData);
        Session::flash('alert-success','Added Successfully.');
        return redirect('table_data');
    }
    
    public function updateTable(Request $request)
    {
        $requestData = $request->all();
        $type_id=$requestData['table_id'];
		$requestData['sync_flag']=0;
        $query =Table::findorfail($type_id);
        $query->update($requestData);
        Session::flash('alert-success','Updated Successfully.');
        return redirect('table_data');
    }
    
    public function deleteTable($table_id)
    {
        $status = 1;
        $query = Table::select('*')->where('table_id', $table_id)->first();
        if($query->is_active==0)
        $query->update(['is_active' => 1]);
        else
        $query->update(['is_active' => 0]);    
        return redirect('table_data');
    }
    
    //Waiter
     public function getWaiter() {
        return view('master_data.table.add_waiter');
    }
   
    public function addWaiter(Request $request) {
        $requestData = $request->all();
        if(Auth::guard('admin')->check()){
            $requestData['cid'] = $this->admin->rid;
        }
        else if(Auth::guard('employee')->check()){
            $requestData['cid'] = $this->employee->cid;
            $requestData['lid'] = $this->employee->lid;
            $requestData['emp_id'] = $this->employee->id;
        }
        \App\Waiter::create($requestData);
        Session::flash('alert-success','Added Successfully.');
        return redirect('table_data');
    }
    
    public function editWaiter()
    {
        $table_id=$_GET['waiter_id'];
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $query = \App\Waiter::where('id', $table_id)->where(['is_active' => '0','cid'=>$id])->first();
        }else if(Auth::guard('web')->check()){
            $query = \App\Waiter::where('id', $table_id)->where(['is_active' => '0'])->first();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
            if($client_data->location == "single" && $role == 2){
                $query = \App\Waiter::where('id', $table_id)->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])->first();
            }
            else
            {
                $query = \App\Waiter::where('id', $table_id)->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])
                        ->first();
            }
        }
        return view('master_data.table.edit_waiter',['waiter_data' => $query]);
    }
     public function updateWaiter(Request $request)
    {
        $requestData = $request->all();
        $type_id=$requestData['waiter_id'];
		$requestData['sync_flag']=0;
        $query = \App\Waiter::findorfail($type_id);
        $query->update($requestData);
        Session::flash('alert-success','Updated Successfully.');
        return redirect('table_data');
    }
    
    public function deleteWaiter($table_id)
    {
        $status = 1;
        $query = \App\Waiter::select('*')->where('id', $table_id)->first();
        if($query->is_active==0)
        $query->update(['is_active' => 1]);
        else
        $query->update(['is_active' => 0]);    
        return redirect('table_data');
    }
    public function view_order_table()
    {
        if(Auth::guard('admin')->check())
            {
            $id = $this->admin->rid;
            $table_data = DB::table('bil_add_table')->where(['is_active'=>0,'cid'=>$id])->get();
        }
        else if(Auth::guard('web')->check()){
            $table_data = DB::table('bil_add_table')->get();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
            
            
            if($client_data->location == "single" && $role == 2)
            {
                $table_data = DB::table('bil_add_table')->where(['is_active'=>0,'cid'=>$cid])->get();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
               
                if($sub_emp_id != "")
                {
                    $table_data = DB::table('bil_add_table')
                            ->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid])
                            ->orWhere(['emp_id'=>$sub_emp_id])
                            ->orWhere(['emp_id'=>$emp_id])
                            ->get();
                }
                else
                {
                    $table_data = DB::table('bil_add_table')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid])->get();
                }
                
            }
            else if($client_data->location == "multiple" && $role == 1)
            {
                $table_data = DB::table('bil_add_table')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid])->get();
            }
        }
        return view('table_order.table_order_data',['table_data' => $table_data]);
    }
    public function check_order_table()
    {
        $table_no=$_GET["tbl_id"];
         if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
         $category = DB::table('bil_category')
                ->select('bil_category.*','bil_type.type_name')
                ->leftjoin('bil_type','bil_type.type_id','=','bil_category.type_id')
                ->where(['bil_category.is_active' => '0','bil_category.cid'=>$id])
               // ->orderBy('bil_category.cat_name', 'asc')
                ->get();
          $hf_setting= \App\HeaderFooter::where(['cid'=>$id])->first();
          $bill_data = \App\TempMaster::select('tbl_bill_no')->where(['cid'=>$id])->orderBy('tbl_bill_no','desc')->first();
          $payment_type = \App\PaymentType::select('*')->where(['cid'=>$id,'is_active'=>0])->get();
          $point_of_data = \App\PointOfContact::select('*')->where(['cid'=>$id,'is_active'=>0])->get();
          $customer_data = \App\Customer::select('*')->where(['cid'=>$id,'is_active'=>0])->get();
          $waiter_data = \App\Waiter::select('*')->where(['cid'=>$id,'is_active'=>0])->get();
          $table_bill_data = \App\TempMaster::select('*')->where(['cid'=>$id,'table_no'=>$table_no])->orderBy('tbl_bill_no', 'desc')->first();
          
         }else if(Auth::guard('web')->check()){
             $category = DB::table('bil_category')
                ->select('bil_category.*','bil_type.type_name')
                ->leftjoin('bil_type','bil_type.type_id','=','bil_category.type_id')
                ->where(['bil_category.is_active' => '0'])
                //->orderBy('bil_category.cat_name', 'asc')
                ->get();
          $hf_setting= \App\HeaderFooter::first();
          $bill_data = \App\TempMaster::select('tbl_bill_no')->orderBy('tbl_bill_no','desc')->first();
          
         }else if(Auth::guard('employee')->check()){
             $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
            if($client_data->location == "single" && $role == 2)
            {
                 //echo "in else";exit;
                $category = DB::table('bil_category')
                ->select('bil_category.*','bil_type.type_name')
                ->leftjoin('bil_type','bil_type.type_id','=','bil_category.type_id')
                ->where(['bil_category.is_active' => '0','bil_category.cid'=>$cid])
                //->orderBy('bil_category.cat_name', 'asc')
                ->get();
          $hf_setting= \App\HeaderFooter::where(['cid'=>$cid])->first();
          $bill_data = \App\TempMaster::select('tbl_bill_no')->where(['cid'=>$cid])->orderBy('tbl_bill_no','desc')->first();
           $payment_type = \App\PaymentType::select('*')->where(['cid'=>$cid])->get();
          $point_of_data = \App\PointOfContact::select('*')->where(['cid'=>$cid])->get();
            $customer_data = \App\Customer::select('*')->where(['cid'=>$cid,'is_active'=>0])->get();
            $waiter_data = \App\Waiter::select('*')->where(['cid'=>$cid,'is_active'=>0])->get();
             $table_bill_data = \App\TempMaster::select('*')->where(['cid'=>$cid,'table_no'=>$table_no])->orderBy('tbl_bill_no', 'desc')->first();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
                //echo "in else";exit;
                if($sub_emp_id != "")
                {
                    
                    $category = DB::table('bil_category')
                            ->select('bil_category.*', 'bil_type.type_name')
                            ->leftjoin('bil_type', 'bil_type.type_id', '=', 'bil_category.type_id')
                            ->where(['bil_category.is_active' => '0', 'bil_category.cid' => $cid, 'bil_category.lid' => $lid])
                            ->orWhere(['emp_id' => $sub_emp_id])
                            ->orWhere(['emp_id' => $emp_id])
                           // ->orderBy('bil_category.cat_name', 'asc')
                            ->get();
                    $hf_setting = \App\HeaderFooter::where(['cid' => $cid, 'lid' => $lid])
                            ->orWhere(['emp_id' => $sub_emp_id])
                            ->orWhere(['emp_id' => $emp_id])
                            ->first();
                    $bill_data = \App\TempMaster::select('tbl_bill_no')->where(['cid' => $cid, 'lid' => $lid])
                            ->orWhere(['emp_id' => $sub_emp_id])
                            ->orWhere(['emp_id' => $emp_id])
                            ->orderBy('tbl_bill_no', 'desc')
                            ->first();
                     $payment_type = \App\PaymentType::select('*')->where(['cid' => $cid, 'lid' => $lid])
                            ->orWhere(['emp_id' => $sub_emp_id])
                            ->orWhere(['emp_id' => $emp_id])
                             ->get();
                    $point_of_data = \App\PointOfContact::select('*')
                            ->where(['cid' => $cid, 'lid' => $lid])
                            ->orWhere(['emp_id' => $sub_emp_id])
                            ->orWhere(['emp_id' => $emp_id])
                            ->get();
                    $customer_data = \App\Customer::select('*')->where(['cid'=>$cid,'is_active'=>0, 'lid' => $lid]) ->orWhere(['emp_id' => $sub_emp_id])
                            ->orWhere(['emp_id' => $emp_id])
			    ->get();
                    $waiter_data = \App\Waiter::select('*')->where(['cid'=>$cid,'is_active'=>0, 'lid' => $lid]) ->orWhere(['emp_id' => $sub_emp_id])
                            ->orWhere(['emp_id' => $emp_id])
			    ->get();
                    $table_bill_data = \App\TempMaster::select('*')
                            ->where(['cid'=>$cid, 'lid' => $lid,'table_no'=>$table_no]) 
                            ->orWhere(['emp_id' => $sub_emp_id])
                            ->orWhere(['emp_id' => $emp_id])
                            ->orderBy('tbl_bill_no', 'desc')
                            ->first();
                }
                else
                {
                    $category = DB::table('bil_category')
                            ->select('bil_category.*', 'bil_type.type_name')
                            ->leftjoin('bil_type', 'bil_type.type_id', '=', 'bil_category.type_id')
                            ->where(['bil_category.is_active' => '0', 'bil_category.cid' => $cid, 'bil_category.lid' => $lid])
                           // ->orderBy('bil_category.cat_name', 'asc')
                            ->get();
                    $hf_setting = \App\HeaderFooter::where(['cid' => $cid, 'lid' => $lid])
                            ->first();
                    $bill_data = \App\TempMaster::select('tbl_bill_no')->where(['cid' => $cid, 'lid' => $lid])
                            ->orderBy('tbl_bill_no', 'desc')
                            ->first();
                    $waiter_data = \App\Waiter::select('*')->where(['cid'=>$cid,'is_active'=>0, 'lid' => $lid]) 
			    ->get();
                     $payment_type = \App\PaymentType::select('*')->where(['cid' => $cid, 'lid' => $lid,'is_active'=>0])->get();
                     $point_of_data = \App\PointOfContact::select('*')->where(['cid' => $cid, 'lid' => $lid,'is_active'=>0])->get();
                     $table_bill_data = \App\TempMaster::select('*')
                            ->where(['cid' => $cid, 'lid' => $lid,'table_no'=>$table_no])
                            ->orderBy('tbl_bill_no', 'desc')
                            ->first();
                     
                }
            }
             else if($client_data->location == "multiple" && $role == 1)
            {
                  $category = DB::table('bil_category')
                            ->select('bil_category.*', 'bil_type.type_name')
                            ->leftjoin('bil_type', 'bil_type.type_id', '=', 'bil_category.type_id')
                            ->where(['bil_category.is_active' => '0', 'bil_category.cid' => $cid, 'bil_category.lid' => $lid])
                            //->orderBy('bil_category.cat_name', 'asc')
                            ->get();
                    $hf_setting = \App\HeaderFooter::where(['cid' => $cid, 'lid' => $lid])
                            ->first();
                    $bill_data = \App\TempMaster::select('tbl_bill_no')->where(['cid' => $cid, 'lid' => $lid])
                            ->orderBy('tbl_bill_no', 'desc')
                            ->first();
                      $payment_type = \App\PaymentType::select('*')->where(['cid' => $cid, 'lid' => $lid,'is_active'=>0])->get();
                      $customer_data = \App\Customer::select('*')->where(['cid'=>$cid,'is_active'=>0, 'lid' => $lid]) ->get();
                      $waiter_data = \App\Waiter::select('*')->where(['cid'=>$cid,'is_active'=>0, 'lid' => $lid]) ->get();
                     $point_of_data = \App\PointOfContact::select('*')->where(['cid' => $cid, 'lid' => $lid,'is_active'=>0])->get();
                      $table_bill_data = \App\TempMaster::select('*')
                            ->where(['cid' => $cid, 'lid' => $lid,'table_no'=>$table_no])
                            ->orderBy('tbl_bill_no', 'desc')
                            ->first();
                     
            }
             
         }
		     $bill_data = \App\TempMaster::select('tbl_bill_no')
                            ->orderBy('tbl_bill_no', 'desc')
                            ->first();
                     
                    
                    // echo "<pre/>";print_r($bill_data);exit;
        return view('table_order.table_sale',['category_data'=>$category,'bill_data'=>$bill_data,'hf_setting'=>$hf_setting,'payment_type'=>$payment_type,'point_of_contact'=>$point_of_data,'customer_data'=>$customer_data,'table_no'=>$table_no,'waiter_data'=>$waiter_data,'table_bill_data'=>$table_bill_data]);
    }
    public function add_tbl_bill(Request $request)
    {
        $requestData = $request->all();
         if(Auth::guard('admin')->check()){
            $requestData['cid'] = $this->admin->rid;
             $requestData['lid'] = NULL;
           }
           else if(Auth::guard('employee')->check()){
            $requestData['cid'] = $this->employee->cid;
             $requestData['lid'] = $this->employee->lid;
             $requestData['emp_id']= $this->employee->id;
           }
         $customer_data = \App\Customer::select('cust_id')->where('cust_name','=',$requestData['cust_name'])->first();
         if(!empty($customer_data))
         {
         $requestData['cust_id']=$customer_data->cust_id;
         }
         else if($requestData['cust_name']!="")
         {
             $cust_data=\App\Customer::create($requestData);
             $requestData['cust_id']=$cust_data->cust_id;
         }
         if(isset($requestData['payment_type']))
         {
             $payemnt_type_data= \App\PaymentType::select('payment_type')->where(['payment_type'=>$requestData['payment_type'],'lid'=>$requestData['lid'],'cid'=>$requestData['cid']])->first();
             if(empty($payemnt_type_data))
             $new_payemnt= \App\PaymentType::create($requestData);
             $requestData['cash_or_credit']=$requestData['payment_type'];
         }
         if(isset($requestData['point_of_contact']))
         {
             $point_of_contact= \App\PointOfContact::select('*')->where(['point_of_contact'=>$requestData['point_of_contact'],'lid'=>$requestData['lid'],'cid'=>$requestData['cid']])->first();
             if(empty($point_of_contact))
             {
                 $new_point_of_contact=  \App\PointOfContact::create($requestData);
                 $requestData['point_of_contact'] = $new_point_of_contact->id;        
             }
 else {
     $requestData['point_of_contact'] = $point_of_contact->id;        
 }
             
             
         }
         if(isset($requestData['payment_details']))
         {
			$requestData['payment_details1'] =array(array(
												"t_id"=>$requestData['payment_details'][0],
												"t_status" => $requestData['payment_details'][1],
												"t_details" => $requestData['payment_details'][2]
												));
			 $requestData['payment_details']=json_encode($requestData['payment_details1']);
         }
         if(isset($requestData['order_details']))
		 {
			 $requestData['order_details1'] =array(array(
												"o_details" => $requestData['order_details'][0]
													));
         $requestData['order_details']=json_encode($requestData['order_details1']);
		 }
       //
       //  echo "<pre/>";print_r($requestData); exit;
         $requestData['bill_date']=date('Y-m-d h:i:s');
        // echo "<pre/>";print_r($requestData);exit;
         if(empty($requestData["table_master_id"]))
         {
         $bill_master=\App\TempMaster::create($requestData);
         }
         else
         {
             $bill_master = \App\TempMaster::select('*')->where(['tbl_bill_no'=>$requestData["table_master_id"]])->first();
             $bill_master->update($requestData);
         }
         
//           echo "<pre/>";print_r($bill_master);exit;
         foreach($requestData["stoppage"] as $data)
         {
             
             $requestData["bill_no"]=$bill_master->tbl_bill_no;
             $requestData["item_name"]=$data[1];
             $requestData["item_qty"]=$data[2];
            //echo "<pre/>";print_r($item_data);
             $requestData["item_rate"]=$data[3];
             $requestData["discount"]=$data[4];
             $requestData["bill_tax"]=$data[5];
             $requestData["item_totalrate"]=$data[6];
             if(isset($data[7]))
             $requestData["kot_print"]=$data[7];
             else
             $requestData["kot_print"]=0;
             if(isset($data[8]))
             {
                $prev_data = \App\TempDetail::select('*')->where(['id'=>$data[8]])->first();
                $prev_data->update($requestData);
             }
            else {
                $bill_detail= \App\TempDetail::create($requestData);
            }
             
         }
		// echo "<pre/>";print_r($bill_detail);exit;
         echo json_encode($bill_master);
         
    }
    public function move_tbl_bill(Request $request)
    {
        $requestData = $request->all();
       //   echo "<pre/>";print_r($requestData); exit;
           if(Auth::guard('admin')->check()){
            $requestData['cid'] = $this->admin->rid;
             $requestData['lid'] = NULL;
           }
           else if(Auth::guard('employee')->check()){
            $requestData['cid'] = $this->employee->cid;
             $requestData['lid'] = $this->employee->lid;
             $requestData['emp_id']= $this->employee->id;
           }
         $customer_data = \App\Customer::select('cust_id')->where('cust_name','=',$requestData['cust_name'])->first();
         if(!empty($customer_data))
         {
         $requestData['cust_id']=$customer_data->cust_id;
         }
         else if($requestData['cust_name']!="")
         {
             $cust_data=\App\Customer::create($requestData);
             $requestData['cust_id']=$cust_data->cust_id;
         }
         if(isset($requestData['payment_type']))
         {
             $payemnt_type_data= \App\PaymentType::select('payment_type')->where(['payment_type'=>$requestData['payment_type'],'lid'=>$requestData['lid'],'cid'=>$requestData['cid']])->first();
             if(empty($payemnt_type_data))
             $new_payemnt= \App\PaymentType::create($requestData);
             $requestData['cash_or_credit']=$requestData['payment_type'];
         }
         if(isset($requestData['point_of_contact']))
         {
             $point_of_contact= \App\PointOfContact::select('*')->where(['point_of_contact'=>$requestData['point_of_contact'],'lid'=>$requestData['lid'],'cid'=>$requestData['cid']])->first();
             if(empty($point_of_contact))
             {
                 $new_point_of_contact=  \App\PointOfContact::create($requestData);
                 $requestData['point_of_contact'] = $new_point_of_contact->id;        
             }
 else {
     $requestData['point_of_contact'] = $point_of_contact->id;        
 }
             
             
         }
         if(isset($requestData['payment_details']))
         {
            // $requestData['payment_details']=json_encode($requestData['payment_details']);
			$requestData['payment_details1'] =array(array(
												"t_id"=>$requestData['payment_details'][0],
												"t_status" => $requestData['payment_details'][1],
												"t_details" => $requestData['payment_details'][2]
												));
			 $requestData['payment_details']=json_encode($requestData['payment_details1']);
		   // echo "<pre/>";print_r($requestData['payment_details1']);exit;
         }
         if(isset($requestData['order_details']))
		 {
			 $requestData['order_details1'] =array(array(
												"o_details" => $requestData['order_details'][0]
													));
         $requestData['order_details']=json_encode($requestData['order_details1']);
		 }
                 if(isset($requestData["table_master_id"])){
                 $requestData["order_type"]="Table";
             $id=$requestData["table_no"];
             $res= \App\TempMaster::where('tbl_bill_no',$id)->delete();
             $res= \App\TempDetail::where('bill_no',$id)->delete();
            

         }
       //
        // echo "<pre/>";print_r($requestData); exit;
         $requestData['bill_date']=date('Y-m-d h:i:s');
//         echo "<pre/>";print_r($requestData);exit;
         $bill_master=\App\BillMaster::create($requestData);
//           echo "<pre/>";print_r($bill_master);exit;
         foreach($requestData["stoppage"] as $data)
         {
             $requestData["bill_no"]=$bill_master->bill_no;
             $requestData["item_name"]=$data[1];
             $requestData["item_qty"]=$data[2];
             $item_data = \App\Item::select('*')->where(['is_active'=>0,'lid'=>$requestData['lid'],'cid'=>$requestData['cid']])->where('item_name', '=',$requestData["item_name"])->first();
             $updated_qty=$item_data->item_stock-$requestData["item_qty"];
             $item_data->update(['item_stock'=>$updated_qty]);
             //echo "<pre/>";print_r($item_data);
             $requestData["item_rate"]=$data[3];
             $requestData["discount"]=$data[4];
             $requestData["bill_tax"]=$data[5];
             $requestData["item_totalrate"]=$data[6];
             $bill_detail=\App\BillDetail::create($requestData);
         }
         
		// echo "<pre/>";print_r($bill_detail);exit;
         echo json_encode($bill_master);
    }
    public function delete_temp_item()
    {
        $item_id=$_GET["item_id"];
        $res= \App\TempDetail::where('id',$item_id)->delete(); 
        echo json_encode($res);
    }
    
}