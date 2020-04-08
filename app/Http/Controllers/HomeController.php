<?php

namespace App\Http\Controllers;

use App\Item;
use App\BillDetail;
use App\BillMaster;
use App\EnquiryLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
        $this->middleware('auth.basic');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->admin = Auth::guard('admin')->user();
            $this->employee = Auth::guard('employee')->user();
            $this->dealer = Auth::guard('dealer')->user();
            return $next($request);
        });
    }
    public function indexAdmin()
    {
        $final_pie = array();
        $date = date('Y-m-d');
        $from_date = date($date . ' 00:00:00', time());
        $to_date   = date($date . ' 23:59:59', time());
        if (Auth::guard('admin')->check()) {
            $id = $this->admin->rid;
            $location = $this->admin->location;
            //            echo $location;
            //            exit;
            if ($location == "multiple") {
                $active_items = Item::where(['cid' => $id, 'is_active' => 0])->count();
                $inactive_items = Item::where(['cid' => $id, 'is_active' => 1])->count();
                $total_sales = BillDetail::where(['cid' => $id])->count();
                $total_sales_amount = BillDetail::where(['cid' => $id])->sum('item_totalrate');
                $total_loc = EnquiryLocation::where(['cid' => $id, 'is_active' => 1])->count();
                // $total_loc = EnquiryLocation::where(['cid' => $id, 'is_active' => 0])->toSql();
                // dd($total_loc);
                $top_loc = "";
                $top_items = "";
                $top_items = DB::table('bil_AddBillDetail')
                    ->select('item_name')
                    ->where('cid', '=', $id)
                    ->selectRaw('sum(item_qty) as item_qty')
                    ->groupby('item_name')
                    ->orderby('item_qty', 'desc')
                    ->limit(4)
                    ->get();
                $top_loc = DB::table('bil_AddBillDetail')
                    ->leftjoin('bil_location', 'bil_location.loc_id', '=', 'bil_AddBillDetail.lid')
                    ->select('bil_location.loc_name')
                    ->where('bil_AddBillDetail.cid', '=', $id)
                    ->selectRaw('count(DISTINCT(bil_AddBillDetail.bill_no)) as orders')
                    ->selectRaw('SUM(bil_AddBillDetail.item_totalrate) as total')
                    ->groupby('bil_location.loc_name')
                    ->orderby('orders', 'desc')
                    ->get();
                $pie_loc = DB::table('bil_AddBillDetail')
                    ->leftjoin('bil_location', 'bil_location.loc_id', '=', 'bil_AddBillDetail.lid')
                    ->select('bil_location.loc_name')
                    ->where('bil_AddBillDetail.cid', '=', $id)
                    ->selectRaw('sum(bil_AddBillDetail.item_totalrate) as amount')
                    ->selectRaw('sum(bil_AddBillDetail.item_qty) as qty')
                    ->selectRaw('count(DISTINCT(bil_AddBillDetail.bill_no)) as orders')
                    ->groupby('bil_location.loc_name')
                    ->orderby('orders', 'desc')
                    // ->limit(10)
                    ->get();
                $data = array();
                foreach ($pie_loc as $loc) {
                    $data['name'] = $loc->loc_name;
                    $data['y'] = $loc->orders;
                    $data['custom'] = $loc->qty;
                    $data['custom1'] = $loc->amount;
                    $final_pie[] = $data;
                }
                $items = DB::table('bil_AddItems')
                    ->leftjoin('bil_location', 'bil_location.loc_id', '=', 'bil_AddItems.lid')
                    ->select('bil_location.loc_name', 'bil_AddItems.item_name')
                    ->where('bil_AddItems.cid', '=', $id)
                    ->orderby('bil_AddItems.item_name', 'desc')
                    ->get();
                //                echo "<pre>";
                //                print_r($items);
                //                exit;
                //today
                $today_active_items = Item::where(['item_date' => $date, 'cid' => $id, 'is_active' => 0])->count();
                $today_inactive_items = Item::where(['item_date' => $date, 'cid' => $id, 'is_active' => 1])->count();
                $today_total_sales = \App\BillMaster::where(['cid' => $id, 'isactive' => 0])->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                    //     ->toSql();
                    // var_dump($today_total_sales);
                    // exit;

                    ->count();
                $today_total_sales_amount = BillDetail::where('cid', '=', $id)->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])->sum('item_totalrate');
                return view('admin.home', [
                    'active_items' => $active_items, 'inactive_items' => $inactive_items, 'total_sales' => $total_sales, 'top_items' => $top_items, 'total_loc' => $total_loc, 'top_loc' => $top_loc, 'final_pie' => $final_pie, 'items' => $items, 'total_sales_amount' => $total_sales_amount, 'today_active_items' => $today_active_items, 'today_inactive_items' => $today_inactive_items, 'today_total_sales' => $today_total_sales, 'today_total_sales_amount' => $today_total_sales_amount
                ]);
                //                echo "<pre>";
                //                print_r($final_pie);
                //                exit;
                //return view('admin.home',['total_items'=>$total_items,'total_sales'=>$total_sales,'top_items'=>$top_items,'total_loc'=>$total_loc,'top_loc'=>$top_loc,'final_pie'=>$final_pie]);
            }
            if ($location == "single") {
                $active_items = Item::where(['cid' => $id, 'is_active' => 0])->count();
                $inactive_items = Item::where(['cid' => $id, 'is_active' => 1])->count();
                $total_sales = BillMaster::select('bill_no')->where('cid', '=', $id)->where('isactive', '=', 0)
                    // ->groupBy('bill_no')
                    ->count();
                //		echo "<pre>";print_r($total_sales);exit;
                $total_sales_amount = BillDetail::where('cid', '=', $id)->where('isactive', '=', 0)->sum('item_totalrate');
                // ->sum('item_totalrate');
                $pie_loc = DB::table('bil_AddBillDetail')
                    ->leftjoin('bil_location', 'bil_location.loc_id', '=', 'bil_AddBillDetail.lid')
                    ->select('bil_location.loc_name')
                    ->where('bil_AddBillDetail.cid', '=', $id)
                    ->selectRaw('sum(bil_AddBillDetail.item_totalrate) as amount')
                    ->selectRaw('sum(bil_AddBillDetail.item_qty) as qty')
                    ->selectRaw('count(DISTINCT(bil_AddBillDetail.bill_no)) as orders')
                    ->groupby('bil_location.loc_name')
                    ->orderby('orders', 'desc')
                    ->limit(10)
                    ->get();
                $data = array();
                foreach ($pie_loc as $loc) {
                    $data['name'] = $loc->loc_name;
                    $data['y'] = $loc->orders;
                    $data['custom'] = $loc->qty;
                    $data['custom1'] = $loc->amount;
                    $final_pie[] = $data;
                }
                $total_loc = EnquiryLocation::where(['cid' => $id, 'is_active' => 1])->count();
                $top_loc = "";
                $top_items = "";
                $top_items = DB::table('bil_AddBillDetail')
                    ->select('item_name')
                    ->where('cid', '=', $id)
                    ->where('isactive', '=', 0)
                    ->selectRaw('sum(item_qty) as item_qty')
                    ->groupby('item_name')
                    ->orderby('item_qty', 'desc')
                    ->limit(4)
                    ->get();
                $top_loc = DB::table('bil_AddBillDetail')
                    ->leftjoin('bil_location', 'bil_location.loc_id', '=', 'bil_AddBillDetail.lid')
                    ->select('bil_location.loc_name')
                    ->where('bil_AddBillDetail.cid', '=', $id)
                    ->selectRaw('count(DISTINCT(bil_AddBillDetail.bill_no)) as orders')
                    ->groupby('bil_location.loc_name')
                    ->orderby('orders', 'desc')
                    ->limit(4)
                    ->get();
                $process_defect1 = array();
                $sales_item_data = DB::table('bil_AddBillDetail')
                    ->select('bil_AddBillDetail.item_name')
                    ->where('bil_AddBillDetail.cid', '=', $id)
                    ->selectRaw('sum(bil_AddBillDetail.item_qty) as qty')
                    ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                    ->groupby('bil_AddBillDetail.item_name')
                    //->orderByRaw('sum(bil_AddBillDetail.item_qty)','desc')
                   // ->limit(5)
                    ->get();
                   
                foreach ($sales_item_data as $data) {
                    $item_data = \App\Item::select('*')->where(['item_name' => $data->item_name, 'cid' => $id, 'is_active' => 0])->first();
                    $process_defect1['name'][] = $data->item_name;
                    $process_defect1['data'][] = $data->qty;
                    if (!empty($item_data))
                        $process_defect1['data1'][] = $item_data->item_stock;
                    else
                        $process_defect1['data1'][] = 0;
                }
                arsort($process_defect1['data']);
                 $three = array_slice($process_defect1['data'], 0, 10, true);
                 foreach ($three as $key => $value) {
                    $process_defect['name'][] = $process_defect1['name'][$key];
                    $process_defect['data1'][] = $process_defect1['data1'][$key];
                    $process_defect['data'][] = $value;
                }
            //echo "<pre/>";print_r($process_defect);exit;

                //today 
                $today_active_items = Item::where(['item_date' => $date, 'cid' => $id, 'is_active' => 0])->count();
                $today_inactive_items = Item::where(['item_date' => $date, 'cid' => $id, 'is_active' => 1])->count();
                $today_total_sales = \App\BillMaster::where('cid', '=', $id)->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])->where(['isactive' => 0])
                    // ->toSql();
                    // var_dump($today_total_sales);
                    // exit;
                    ->count();
                $today_total_sales_amount = BillDetail::where('cid', '=', $id)->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])->where(['isactive' => 0])->sum('item_totalrate');

                return view('admin.home-single', [
                    'active_items' => $active_items, 'inactive_items' => $inactive_items, 'total_sales' => $total_sales, 'top_items' => $top_items, 'total_loc' => $total_loc, 'total_sales_amount' => $total_sales_amount, 'today_active_items' => $today_active_items, 'today_inactive_items' => $today_inactive_items, 'today_total_sales' => $today_total_sales, 'today_total_sales_amount' => $today_total_sales_amount, 'process_defect1' => $process_defect
                ]);                //                return view('admin.home-single');
            }
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function empIndex()
    {
        $date = date('Y-m-d');
        $from_date = date($date . ' 00:00:00', time());
        $to_date   = date($date . ' 23:59:00', time());
        if (Auth::guard('employee')->check()) {
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
        }
        $active_items = Item::where(['cid' => $cid, 'lid' => $lid, 'is_active' => 0])->count();
        $inactive_items = Item::where(['cid' => $cid, 'lid' => $lid, 'is_active' => 1])->count();
        $total_sales = BillDetail::select('bill_no')->where(['cid' => $cid, 'lid' => $lid])->where(['isactive' => 0])->groupBy('bill_no')->get();
        $total_sales_amount = BillDetail::where(['cid' => $cid, 'lid' => $lid])->sum('item_totalrate');
        $total_loc = EnquiryLocation::where(['cid' => $cid, 'is_active' => 1])->count();
        $top_loc = "";
        $top_items = "";
        $top_items = DB::table('bil_AddBillDetail')
            ->select('item_name')
            ->where(['cid' => $cid, 'lid' => $lid])
            ->selectRaw('sum(item_qty) as item_qty')
            ->groupby('item_name')
            ->orderby('item_qty', 'desc')
            ->limit(4)
            ->get();
        $top_loc = DB::table('bil_AddBillDetail')
            ->leftjoin('bil_location', 'bil_location.loc_id', '=', 'bil_AddBillDetail.lid')
            ->select('bil_location.loc_name')
            ->where(['bil_AddBillDetail.cid' => $cid, 'bil_AddBillDetail.lid' => $lid])
            ->selectRaw('count(DISTINCT(bil_AddBillDetail.bill_no)) as orders')
            ->groupby('bil_location.loc_name')
            ->orderby('orders', 'desc')
            ->limit(4)
            ->get();

        //today 
        $today_active_items = Item::where(['item_date' => $date, 'cid' => $cid, 'lid' => $lid, 'is_active' => 0])->count();
        $today_inactive_items = Item::where(['item_date' => $date, 'cid' => $cid, 'lid' => $lid, 'is_active' => 1])->count();
        $today_total_sales = \App\BillMaster::where(['cid' => $cid, 'lid' => $lid])->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])->count();
        // echo "<pre/>";                print_r($today_total_sales);exit;
        $today_total_sales_amount = BillDetail::where(['cid' => $cid, 'lid' => $lid])->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])->sum('item_totalrate');
        if ($role == 1) {
            return view('employee.home-single', [
                'active_items' => $active_items, 'inactive_items' => $inactive_items, 'total_sales' => $total_sales, 'top_items' => $top_items, 'total_loc' => $total_loc, 'total_sales_amount' => $total_sales_amount, 'today_active_items' => $today_active_items, 'today_inactive_items' => $today_inactive_items, 'today_total_sales' => $today_total_sales, 'today_total_sales_amount' => $today_total_sales_amount
            ]);
        } else {
            return view('employee.home');
        }
    }
    public function dealerIndex()
    {
        $date = date('Y-m-d');
        if (Auth::guard('admin')->check()) {
            $id = $this->admin->rid;
            $today_en = DB::table('tbl_enquiry')
                ->select('enquiry_no', 'customer_name', 'mobile_no', 'enquiry_id')
                ->where('followup_date', '=', $date)
                ->where(['cid' => $id])
                ->get();
            $status = \App\EnquiryStatus::where(['is_active' => 0, 'cid' => $id])->get();
        } else if (Auth::guard('dealer')->check()) {
            $today_en = DB::table('tbl_enquiry')
                ->select('enquiry_no', 'customer_name', 'mobile_no', 'enquiry_id')
                ->where('followup_date', '=', $date)
                ->get();
            $status = \App\EnquiryStatus::where(['is_active' => 0])->get();
        } else if (Auth::guard('web')->check()) {
            $today_en = DB::table('tbl_enquiry')
                ->select('enquiry_no', 'customer_name', 'mobile_no', 'enquiry_id')
                ->where('followup_date', '=', $date)
                ->get();
            $status = \App\EnquiryStatus::where(['is_active' => 0])->get();
        } else if (Auth::guard('employee')->check()) {
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            if ($role == 1) {
                $today_en = DB::table('tbl_enquiry')
                    ->select('enquiry_no', 'customer_name', 'mobile_no', 'enquiry_id')
                    ->where('followup_date', '=', $date)
                    ->where(['cid' => $cid, 'lid' => $lid, 'emp_id' => $emp_id])
                    ->get();
                $status = \App\EnquiryStatus::where(['is_active' => 0, 'cid' => $cid, 'emp_id' => $emp_id])->get();
            } else {
                $today_en = DB::table('tbl_enquiry')
                    ->select('enquiry_no', 'customer_name', 'mobile_no', 'enquiry_id')
                    ->where('followup_date', '=', $date)
                    ->where(['cid' => $cid, 'lid' => $lid, 'emp_id' => $emp_id])
                    ->get();
                $status = \App\EnquiryStatus::where(['is_active' => 0, 'cid' => $cid, 'emp_id' => $emp_id])->get();
            }
        }
        return view('dealer.home');
    }
    public function showClients()
    {
        if (Auth::guard('dealer')->check()) {
            $dealer_id = Auth::guard('dealer')->user()->dealer_id;
            $dealer_code = Auth::guard('dealer')->user()->dealer_code;
            $client_data = DB::table('tbl_Registration')
                ->where('reg_dealercode', '=', $dealer_code)
                ->get();
            return view('dealer.dealer_clients', ['client_data' => $client_data]);
        }
    }
    public function send()
    {
        $msg = $_GET['data'];
        //echo $msg;exit;
        $conn = mysqli_connect("localhost", "root", "", "new-dump");
        if (Auth::guard('admin')->check()) {
            $id = $this->admin->rid;
            $location = $this->admin->location;
        }
        $sql = " select token,id from bil_employees where cid='$id'";
        $result = mysqli_query($conn, $sql);
        $date = date('Y-m-d');
        $tokens = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                //$tokens = array($row["token"]);
                $tokens = array($row["token"]);
                $message = array("message" => "Please Sync Data For " . $msg);
                //echo $message;exit;
                $this->send_notification($tokens, $message);
            }
        }
        mysqli_close($conn);
    }
    public function send_notification($tokens, $message)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $arr = array(1, 2, 3, 4, 5, 6, 7);
        //         print_r($arr);
        //         exit;


        $fields = array(
            'registration_ids' => $tokens,
            'data' => $message,
            'arr' => $arr
        );

        //print_r($fields);

        $headers = array(
            'Authorization:key=AIzaSyAu4VNOaIPP7m_7L4ZKeIer3uk4jY08Seg',
            'Content-Type:application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        //echo $result;exit;         
        if ($result === FALSE) {
            echo "Failed";
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        print_r($result);
        //       exit;
        return $result;
    }
    public function check_expiry()
    {
        if (Auth::guard('admin')->check()) {
            $id = $this->admin->rid;

            $activate_data = \App\Admin::select('*')->where(['is_active' => 0, 'activate_flag' => 1, 'rid' => $id])->get();
            foreach ($activate_data as $d) {
                $active_date = $d->activate_date;
                $date = date("Y-m-d");
                if ($active_date != NULL) {

                    $start_date = $active_date;
                    $end_date = $date;
                    //$diff=date_diff($end_date,$start_date);

                    $datetime1 = new DateTime($start_date);
                    $datetime2 = new DateTime($end_date);
                    $interval = $datetime1->diff($datetime2);
                    $diff = $interval->format('%d');
                    if ($diff >= 365) {
                        $user_data = \App\Admin::where(['rid' => $d->rid])->update(['activate_flag' => '0']);
                        $employee_data = \App\Employee::where(['cid' => $d->rid])->update(['is_active' => '1']);
                        echo json_encode("updated");
                    } else {
                        echo json_encode("not");
                    }
                }
            }
        }
    }
}

