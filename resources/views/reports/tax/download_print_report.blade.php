<?php if (count($bill_data) > 0) {
    $client_data=\App\Admin::select('reg_personname')->where(['rid'=>$cid])->first();
    ?>
<table border="1">
    <tr><td colspan="6"><h3>Bill Report</h3></td><td style="text-align:center;"></td></tr>
    <tr>
        <th>Client<br/>Name:</th>
        <td colspan="6">{{$client_data->reg_personname}}</td>
    </tr>
    <tr>
        <th>Date:</th>
        <td colspan="6">{{$from_date}} To {{$to_date}}</td>
        <!--<th colspan="5" style="text-align:right;">To Date:{{$to_date}}</th>-->
    </tr>
       
              <?php
              $j=1; $i=1;
              $total_sales=0;
                  foreach($bill_data as $data)
                  {
					   if($data->cust_id>0)
					 {
                      $customer_data= \App\Customer::select('*')->where(['cust_id'=>$data->cust_id])->first();
					  $customer_name=$customer_data->cust_name;
					 }
					 else
					 {
						 $customer_name=$data->cust_name;
						 
					 }
                      $j=1;
                      $total_amt=$total_disc_amt=$total_tax_amt=$total_dis_rate=0;
           $total_amt=$total_amt+$data->bill_totalamt;
		if($data->app_bill_id=="")
                     $dros_out = App\BillDetail::where(['bill_no' => $data->bill_no])->get();
		else
			$dros_out = App\BillDetail::where(['bill_no' => $data->app_bill_id,'emp_id'=>$data->emp_id])->get();
		
           
                       $count = count($dros_out);
                      
                      //$total_cash=$total_cash+$data->cash_or_credit;
                      ?>
        <tr>
            <td><b>Bill No:</b></td>
            <td colspan="6" style="text-align:center;">{{$data->bill_no}}</td>
        </tr>
        <tr>
            <td><b>Date:</b></td>
            <td colspan="6" style="text-align:center;">{{$data->bill_date}}</td>
        </tr>
         <tr> 
            <th  style="text-align:center;">Sr.No.</th>
            <th style="text-align:center;">Item</th>
            <th style="text-align:center;">Qty</th>
            <th style="text-align:center;">Rate</th>
            <th style="text-align:center;">Disc</th>
            <th style="text-align:center;">Tax</th>
            <th style="text-align:center;">Amt</th>
           
        </tr>
        <tr>
            <?php 
            $sub_total=$net_total=0;
             foreach ($dros_out as $dross)
             {
                
 
                 $item_data = App\Item::select('*')->where('item_name','LIKE',$dross->item_name)->first();
                  $total_dis_rate=$total_dis_rate+$item_data->item_disrate;
                    $total_tax_amt=$total_tax_amt+$item_data->item_taxvalue;
                   $amt=$dross->item_qty*$dross->item_rate;
                   $sub_total=$sub_total+$dross->item_rate;
                   $net_total=$net_total+$amt;
                 if ($j == 1) {
            ?>
            <td style="text-align:center;">{{$j}}</td>
            <td style="text-align:center;">{{$dross->item_name}}</td>
            <td style="text-align:center;">{{$dross->item_qty}}</td>
             <td style="text-align:center;">{{$dross->item_rate}}</td>
            <td style="text-align:center;">{{$dross->discount}}</td>
            <!--<td style="text-align:center;">{{$item_data->item_disrate}}</td>-->
            <td style="text-align:center;">{{$dross->bill_tax}}</td>
            <td style="text-align:center;">{{$amt}}</td>
            <!--<td style="text-align:center;">{{$item_data->item_taxvalue}}</td>-->
            <!--<td style="text-align:center;">{{$data->bill_totalamt}}</td>-->
        </tr>
                  <?php }
 else {
   ?>
        <tr>
             <td style="text-align:center;">{{$j}}</td>
            <td style="text-align:center;">{{$dross->item_name}}</td>
            <td style="text-align:center;">{{$dross->item_qty}}</td>
            <td style="text-align:center;">{{$dross->item_rate}}</td>
            <td style="text-align:center;">{{$dross->discount}}</td>
            <!--<td style="text-align:center;">{{$item_data->item_disrate}}</td>-->
            <td style="text-align:center;">{{$dross->bill_tax}}</td>
            <td style="text-align:center;">{{$amt}}</td>
            <!--<td style="text-align:center;">{{$item_data->item_taxvalue}}</td>-->
            <!--<td style="text-align:center;">{{$data->bill_totalamt}}</td>-->    
        </tr>
    <?php
 }$j++;
             } //exit;
            ?>
                      <tr>
                           <td></td>
            <td colspan="2" style="text-align:center;"><b>Sub Total(Rs)</b></td>
            <td colspan="2" style="text-align:center;">{{$sub_total}}</td>
            <td></td> <td></td>
        </tr>
          <tr>
                           <td></td>
            <td colspan="2" style="text-align:center;"><b>Net Total(Rs)</b></td>
            <td colspan="2" style="text-align:center;">{{$net_total}}</td>
            <td></td> <td></td>
        </tr>
        <tr></tr>
                    <?php
                     $total_sales=$total_sales+$data->bill_totalamt;
                  $i++;}
                  ?>
     
       
        
</table>
<?php 
//exit;
  $the_data = 'this is test text for downloading the contents.';
    $report_name = "Bill Print Report";
    header("Content-Type: application/xls");
    header("Content-type: image/Upload");
    header("Content-Type: text/csv; charset=utf-8");
    header("Content-Disposition: attachment; filename=$report_name.xls");
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Transfer-Encoding: binary');
}
else {
    $flg = 1;
    echo '<a href="javascript:void(0)" onclick="goToURL(); return false;"></a>';
//}
    ?>
    <link href="css/sweetalert.css" rel="stylesheet" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script>
    //    alert();
    $(document).ready(function () {
        swal({title: "Error", text: "No Report Available For This Date", type: "error", confirmButtonText: "Back"},
                function () {
                    location.href = 'bill_print_report';
                }
        );
    //    swal({ type: "success", title: "Good Job!", confirmButtonColor: "#292929", text: "Form Sumbmitted Successfully for line A", confirmButtonText: "Ok" });

    });
    </script>
<?php
}
?>


