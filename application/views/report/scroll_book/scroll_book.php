<style>
table {
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid #dddddd;
    padding: 6px;
    font-size: 14px;
}

th {
    text-align: center;
}

tr:hover {background-color: #f5f5f5;}

</style>
<script>
  function printDiv() {

        var divToPrint = document.getElementById('divToPrint');
        var WindowObject = window.open('', 'Print-Window');
        WindowObject.document.open();
        WindowObject.document.writeln('<!DOCTYPE html>');
        WindowObject.document.writeln('<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title></title><style type="text/css">');
        WindowObject.document.writeln('@media print { .center { text-align: center;}' +
            '                                         .inline { display: inline; }' +
            '                                         .underline { text-decoration: underline; }' +
            '                                         .left { margin-left: 315px;} ' +
            '                                         .right { margin-right: 375px; display: inline; }' +
            '                                          table { border-collapse: collapse; font-size: 12px;}' +
            '                                          th, td { border: 1px solid black; border-collapse: collapse; padding: 6px;}' +
            '                                           th, td { }' +
            '                                         .border { border: 1px solid black; } ' +
            '                                         .bottom { bottom: 5px; width: 100%; position: fixed ' +
            '                                       ' +
            '                                   } } </style>');
        WindowObject.document.writeln('</head><body onload="window.print()">');
        WindowObject.document.writeln(divToPrint.innerHTML);
        WindowObject.document.writeln('</body></html>');
        WindowObject.document.close();
        setTimeout(function () {
            WindowObject.close();
        }, 10);

  }
</script>

        <div class="wraper"> 
            <div class="col-lg-12 container contant-wraper">
                <div id="divToPrint">
                    <div style="text-align:center;">

                         <div>BARRACKPORE CENTRAL ZONE WHOLESALE CONSUMERS' COOPERATIVE SOCIETY LIMITED.</div>
						 <div>87, MADHUPANDIT  ROAD, P.O-TALPUKUR, 24 PARGANAS (NORTH) ,700123</div>
                     
                        <div>Scroll Book Between: <?php echo $_SESSION['date']; ?></div>
                        <div style="text-align:left"><label>District: </label> <?php echo $this->session->userdata['loggedin']['branch_name']; ?></div> 

                    </div>
                    <br>  

                    <table style="width: 100%;" id="example">
                        <thead>
                            <tr>
								<th>SL No</th>
                                <th>Date</th>
                                <th>Particulars</th>
                                <!-- <th>Vch Type</th> -->
                                <th>Voucher no</th>
								<th>Receive(DR)</th>
								<th>Payment(CR)</th>
                            </tr>
                        </thead>

                        <tbody>
                                <tr class="rep">
                                     <td><?php //echo substr($_SESSION['date'],0,10); ?></td>
                                     <td></td>
									 <td><b>Opening Balance</b></td>
                                      <td></td>
									<!-- <td></td> -->
                                     
                                     <td><b>
                                    <?php 
									  $temp_op_bal = 0;
										 $temp_op_bal =$op_bal->amount;
                                  if($temp_op_bal >0){echo abs($temp_op_bal); 
                                   $op_bal =$temp_op_bal; 
										 }
										 ?>
                                   </b></td>
                                     <td><b>
                                    <?php 
									 
                                if($temp_op_bal<0){ echo abs($temp_op_bal); 
													
										 $op_bal =$temp_op_bal;			
								 } 
                                  
										 ?>
                                   </b></td>       
                                </tr>
                                <?php

                                if($scroll_book){
			
                                    $i = 1;
                                    $total = 0.00;
                                    $val =0;
									$dr_amt = 0.00;
									$cr_amt = 0.00;
									$cls_bal = 0.00;

                                    foreach($scroll_book as $tb){
                            ?>
                                <tr class="rep">
									  <td><?php echo $i++; ?></td>
                                     <td><?php echo date('d-m-Y',strtotime($tb->voucher_date)); ?></td>
                                  
                                     <td><?php echo $tb->remarks; ?></td>
                                    
									 <td><?php echo $tb->voucher_id; ?></td>
                                     <td><?php echo $tb->dr_amt; $dr_amt += $tb->dr_amt; ?></td>
                                     <td><?php echo $tb->cr_amt; $cr_amt += $tb->cr_amt; ?></td>
                                </tr>
 
                                <?php  
                                                        
                                      }  ?>
									  <tr><td colspan="4"></td><td><b><?=$dr_amt?></b></td><td><b><?=$cr_amt?></b></td>
							</tr>
							  <tr><td colspan="3"></td><td><b>
								Closing Balance
								</b></td>
                            
                            <td><b> 
								<?php  
                          if( ($op_bal+$dr_amt)-$cr_amt>0)
 
                          { echo $cls_bal = $dr_amt-$cr_amt+$op_bal; }
   
                            ?>
							</b></td>
                            
                           <td><b>
								<?php  
                          if(  ($op_bal+$dr_amt)-$cr_amt<0)

                           { echo abs($cls_bal =  abs($dr_amt-$cr_amt+$op_bal)); }
   
                            ?>
								</b></td>
							</tr>  
						<tr><td colspan="4"></td><td><b><?//php echo abs($dr_amt); ?></b></td>
                            <td><b><?php //abs($cr_amt+$cls_bal); ?></b></td>
							</tr>  
									  
                             <?php    }else{

                                    echo "<tr><td colspan='6' style='text-align:center;'>No Data Found</td></tr>";
                                 }   

                            ?>
							
                        </tbody>
                    </table>
                </div>   
                
                <div style="text-align: center;">
                    <button class="btn btn-primary" type="button" onclick="printDiv();">Print</button>
                   <!-- <button class="btn btn-primary" type="button" id="btnExport" >Excel</button>-->
                </div>
            </div>
        </div>