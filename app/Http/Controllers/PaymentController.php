<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Type;
use App\Category;
use App\Subscription;
use Session;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
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
    
    public function getPointOfContact()
    {
        $location_data=$employee_data='';
        if(Auth::guard('admin')->check()){
          $cid = $this->admin->rid;   
          if($this->admin->location=="multiple")
          {
               $location_data= \App\EnquiryLocation::select('*')->where(['cid'=>$cid])->get();
          }
         
          $employee_data= \App\PointOfContact::select('*')->where(['cid'=>$cid,'is_active'=>0])->get();
//          echo "<pre/>";print_r();exit;
        }
        return view('reports.payment.poc_report',['location_data'=>$location_data,'employee_data'=>$employee_data]);
    }
    public function fetchPointOfContact(Request $request)
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
                                     ->where(['cid'=>$cid,'point_of_contact'=>$requestData['employee'],'isactive'=>0])
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
                                     ->where(['cid'=>$cid,'lid'=>$lid,'point_of_contact'=>$requestData['employee'],'isactive'=>0])
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
                                     ->where(['cid'=>$cid,'point_of_contact'=>$requestData['employee'],'isactive'=>0])
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
              $result_data['cust_name']=$customer_data->cust_name;
             else
               $result_data['cust_name']='';
            
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
             $user_data= \App\Employee::select('*')->where(['cid'=>$data->cid,'lid'=>$data->lid,'id'=>$data->emp_id])->first();
             if(empty($user_data))
             {
                $user_data= \App\Admin::select('*')->where(['rid'=>$data->cid])->first();
              $result_data['user']=$user_data->reg_personname;  
             }
            else
            $result_data['user']=$user_data->name;  
			 $result_data['date']=$data->bill_date;  
             array_push($result_final, $result_data);
         }
         $result['amount']=round($total_amount,2);
         $result['other_data']=$result_final;
         echo json_encode($result);
         
    }
    public function getEmployee()
    {
        $lid=$_GET['location'];
        $sdata='';
        if(Auth::guard('admin')->check()){
              $cid = $this->admin->rid;
        }
        if($lid=="all")
        $result_data =\App\Employee::select('*')->where(['cid'=>$cid,'is_active'=>'0'])->get();
        else
        $result_data =\App\Employee::select('*')->where(['lid'=>$lid,'is_active'=>'0'])->get();
        $sdata.='<option value="">---Select Employee---</option>';
        foreach($result_data as $data)
        {
            $sdata.='<option value="'.$data->id.'">'.$data->name.'</option>';
        }
        echo $sdata;
    }

    public function downloadPointOfContact(Request $request)
    {
        $requestData = $request->all();
        $from_date = $requestData["from_date"];
       
        if(!empty($requestData["to_date"]))
         $to_date = $requestData["to_date"];
        else
          $to_date = $from_date;
        
          $from_date = date($from_date . ' 00:00:00', time());
         $to_date   = date($to_date . ' 22:00:40', time());
           
         if(Auth::guard('admin')->check()){
               $cid = $this->admin->rid;
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
                                     ->where(['cid'=>$cid,'point_of_contact'=>$requestData['employee'],'isactive'=>0])
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
                       $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                  }
              }
            else {
                    if(isset($requestData['employee']))
                   {
                          $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'point_of_contact'=>$requestData['employee'],'isactive'=>0])
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
         return view('reports.payment.download_poc_report',['bill_data'=>$bill_data]);
    }
  public function getPayment()
    {
        $location_data=$employee_data='';
        if(Auth::guard('admin')->check()){
          $cid = $this->admin->rid;   
          if($this->admin->location=="multiple")
          {
               $location_data= \App\EnquiryLocation::select('*')->where(['cid'=>$cid])->get();
          }
         
          $employee_data= \App\PaymentType::select('payment_type')->where(['cid'=>$cid,'is_active'=>0])->distinct()->get();
//          echo "<pre/>";print_r($employee_data);exit;
        }
        return view('reports.payment.payment_report',['location_data'=>$location_data,'employee_data'=>$employee_data]);
    }
    public function fetchPayment(Request $request)
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
                                     ->where(['cid'=>$cid,'cash_or_credit'=>$requestData['employee'],'isactive'=>0])
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
                                     ->where(['cid'=>$cid,'lid'=>$lid,'cash_or_credit'=>$requestData['employee'],'isactive'=>0])
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
                                     ->where(['cid'=>$cid,'cash_or_credit'=>$requestData['employee'],'isactive'=>0])
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
              $result_data['cust_name']=$customer_data->cust_name;
             else
               $result_data['cust_name']='';
            
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
             $user_data= \App\Employee::select('*')->where(['cid'=>$data->cid,'lid'=>$data->lid,'id'=>$data->emp_id])->first();
             if(empty($user_data))
             {
                $user_data= \App\Admin::select('*')->where(['rid'=>$data->cid])->first();
              $result_data['user']=$user_data->reg_personname;  
             }
            else
            $result_data['user']=$user_data->name;  
			$result_data['date']=$data->bill_date;  
             array_push($result_final, $result_data);
         }
         $result['amount']=round($total_amount,2);
         $result['other_data']=$result_final;
         echo json_encode($result);
         
    }
     public function downloadPayment(Request $request)
    {
        $requestData = $request->all();
        $from_date = $requestData["from_date"];
       
        if(!empty($requestData["to_date"]))
         $to_date = $requestData["to_date"];
        else
          $to_date = $from_date;
        
          $from_date = date($from_date . ' 00:00:00', time());
         $to_date   = date($to_date . ' 22:00:40', time());
           
         if(Auth::guard('admin')->check()){
               $cid = $this->admin->rid;
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
                                     ->where(['cid'=>$cid,'cash_or_credit'=>$requestData['employee'],'isactive'=>0])
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
                       $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                  }
              }
            else {
                    if(isset($requestData['employee']))
                   {
                          $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'cash_or_credit'=>$requestData['employee'],'isactive'=>0])
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
         return view('reports.payment.download_poc_report',['bill_data'=>$bill_data]);
    }
    
}