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
                                                     '.btn-primary { display:none; }' +
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

                        <h2>THE WEST BENGAL SAMABAYIKA LTD.</h2>
                  
                        
                      <?php if($this->uri->segment(1)=="trailbal"){ ?>
                        <h4>Trial Balance Between: <?php echo $_SESSION['date']; ?></h4>
                        <h5 style="text-align:left"><label>District: <?php  echo $this->session->userdata['loggedin']['branch_name']; ?></label> </h5>

   
                        <?php }else{ ?>
                            <h5>Consolidated Group Details Between: <?php echo $_SESSION['date']; ?></h5>
                       <?php } ?>
                       <h5> Group : <?=$sbgrop?></h5>
                    </div>
                    <div class="printTop023">
						<div class="leftNo"><b>Type: </b> <?php foreach($type as $key => $value){ if($value==1){
                            echo"Liabilites, ";
                        }
                        if($value==2){
                            echo"Asset, ";
                        }
                        if($value==3){
                            echo"Expense, ";
                        }
                        if($value==4){
                            echo"Revenue";
                        }
                        }; ?></div>
						


					</div>
                    <br>  
                    <button id="btnExport" class="btn btn-primary" onclick="exportReportToExcel(this)">EXPORT EXCEL</button><br><br>
                    <table style="width: 100%;" id="example">

                        <thead>
                            <tr>
                                <th rowspan='2'>Sl</th>
                                <th rowspan='2'>Benfed Ac Code</th>
                                <th rowspan='2' style="width:40%">Subgroup name</th>
								<th colspan='2'>Opening</th>
                                <th colspan='2'>Transaction</th>
								<th colspan='2'>Closing</th>
                            </tr>
							<tr>
                                <th>Dr.</th>
                                <th>Cr.</th>
                                <th>Dr.</th>
								<th>Cr.</th>
                                <th>Dr.</th>
								<th>Cr.</th>
                                
                            </tr>
                        </thead>

                        <tbody>
                                
                            <?php
                              
                                if($trail_balnce){

                                    $i = 1;$otot_dr =0.00;$otot_cr =0.00;
                                    $total = 0.00;$tot_dr =0.00; $tot_cr =0.00;
                                    $val =0; $ope_bal = 0.00;$cls_bal = 0.00;$type='';
									$ctot_dr =0.00;$ctot_cr =0.00;
                                ?>
                                <?php   foreach($trail_balnce as $tb){ $type = $tb->type; 
                                    if($tb->op_dr+$tb->op_cr+$tb->dr_amt+$tb->cr_amt!=0) {?>
                                     
                                <tr class="rep">
                                     <td class="report"><?php echo $i++; ?></td>
                                     <td ><?php //echo $tb->benfed_ac_code; ?></td>
									 <td ><?php echo $tb->name; ?></td>


                                     <?php $dmo = date('m-d', strtotime($fd_date));
                                        if($dmo=='04-01'){ ?>

 <td style="text-align: right;">
 <?php  echo number_format(abs($tb->op_dr),2); $otot_dr +=$tb->op_dr; ?>
 </td>
 <td style="text-align: right;">
 <?php echo number_format(abs($tb->op_cr),2); $otot_cr +=$tb->op_cr; ?>
 </td>

<?php  }else{ ?>


									
                                     <td style="text-align: right;">
                                     
                                     <?php if($tb->op_dr > 0 && $tb->dr_cr_flag=='DR' ){
                                                echo number_format(abs($tb->op_dr),2); $otot_dr +=$tb->op_dr;
                                        }else if($tb->op_cr < 0 && $tb->dr_cr_flag=='DR'){
                                            echo number_format(abs($tb->op_cr),2); $otot_dr +=$tb->op_cr;
                                        } ?>
										 
									 </td>
                                     
                                     <td style="text-align: right;">
                                        <?php if($tb->op_cr > 0 && $tb->dr_cr_flag=='CR'){
                                                echo number_format(abs($tb->op_cr),2); $otot_cr +=abs($tb->op_cr);
                                        }else if($tb->op_dr < 0 && $tb->dr_cr_flag=='CR'){
                                            echo number_format(abs($tb->op_dr),2); $otot_cr +=abs($tb->op_dr);
                                        } ?>
									       
								        
									 </td>
<?php } ?>
                                     <td  style="text-align: right;"><?php echo number_format($tb->dr_amt,2); $tot_dr +=$tb->dr_amt; ?></td>
                                     <td  style="text-align: right;"><?php echo number_format($tb->cr_amt,2); $tot_cr +=$tb->cr_amt; ?></td>
                                     <td style="text-align: right;"><?php if($tb->op_dr+$tb->dr_amt>$tb->op_cr+$tb->cr_amt){ ?>
									       <?php echo  number_format(abs($tb->op_dr+$tb->dr_amt-($tb->op_cr)-($tb->cr_amt)),2);
													$ctot_dr += abs($tb->op_dr+$tb->dr_amt-($tb->op_cr)-($tb->cr_amt));
										   ?>
								         <?php }  ?>
									 </td>
									 <td style="text-align: right;"><?php if($tb->op_cr+$tb->cr_amt>$tb->op_dr+$tb->dr_amt){ ?>
										  <?php echo number_format(abs($tb->op_cr+$tb->cr_amt-($tb->op_dr)-($tb->dr_amt)),2);
													$ctot_cr +=abs($tb->op_cr+$tb->cr_amt-($tb->op_dr)-($tb->dr_amt));?>
										 <?php } ?>
									 </td>
                                     
									
                                </tr>
 
                                <?php  
                                    }                    
                                    }
                                ?>
                                <tr style="font-weight: bold;">
								    <td colspan='3'>Total</td>
									<td style="font-size: 12px !important; text-align: right;"><?=number_format(abs($otot_dr),2)?></td>
									<td style="font-size: 12px !important; text-align: right;"><?=number_format(abs($otot_cr),2)?></td>
									<td style="font-size: 12px !important; text-align: right;"><?=number_format(abs($tot_dr),2)?></td>
									<td style="font-size: 12px !important; text-align: right;"><?=number_format(abs($tot_cr),2)?></td>
									<td style="font-size: 12px !important; text-align: right;"><?=number_format(abs($ctot_dr),2)?></td>
									<td style="font-size: 12px !important; text-align: right;"><?=number_format(abs($ctot_cr),2)?></td>
								</tr>
                                <?php 
                                       }
                                else{

                                    echo "<tr><td colspan='14' style='text-align:center;'>No Data Found</td></tr>";

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
        

        <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>


        <script>
            function exportReportToExcel() {
  let table = document.getElementsByTagName("table"); // you can use document.getElementById('tableId') as well by providing id to the table tag
  TableToExcel.convert(table[0], { // html code may contain multiple tables so here we are refering to 1st table tag
    name: `TrialBalance.xlsx`, // fileName you could use any name
    sheet: {
      name: 'Trial Balance' // sheetName
    }
  });
}
        </script>
