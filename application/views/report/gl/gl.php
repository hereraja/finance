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

                        <h4>BARRACKPORE CENTRAL ZONE WHOLESALE CONSUMERS' COOPERATIVE SOCIETY LIMITED.</h4>
						 <h5>87, MADHUPANDIT  ROAD, P.O-TALPUKUR, 24 PARGANAS (NORTH) ,700123</h5>
                        <h4>General Ledger: <?php echo $_SESSION['date']; ?></h4>
                        <h5 style="text-align:left"><label>District: </label> <?php echo $this->session->userdata['loggedin']['branch_name']; ?></h5> 

                    </div>
                    <br>  

                    <table style="width: 100%;" id="example">

                        <thead>
                            <tr>
								<th rowspan='2'>Date</th>
                                <th rowspan='2'>Particulars</th>
                                <th colspan='2'>Trancation</th>
                                
							<tr>
                                <th>Debit</th>
                                <th>Credit</th>
                            </tr>

                        </thead>

                        <tbody>
						

                            <?php
                                  
                                if($trail_balnce){
									
						
                                    $i = 1;
                                    $total = 0.00;$ope_bal = 0.00;$cls_bal = 0.00;$opdr=0.00;$opcr=0.00;
									$tot_debit = 0.00;$tot_cre =0.00;
                                    $val =0;
									$type =0;
									
								    if($opebalcal){
										$opdr =$opebalcal->dr_amt;
										$opcr =$opebalcal->cr_amt;
										if($opebalcal->type == 1 || $opebalcal->type == 3){
										$ope_bal = $ope_bal+$opcr-$opdr;
										}else if($opebalcal->type == 2 || $opebalcal->type == 4){
										$ope_bal = $ope_bal+$opdr-$opcr;										
										}
									}
									
									?>
								<tr class="rep">
									 <td></td>
									 <td>Opening Balance</td>
                                     <td><?=$ope_bal?></td>
                                     <td></td>
                                    
                                </tr>
                               <?php   foreach($trail_balnce as $tb){
                                           $type = $tb->type;
								   ?>
                                <tr class="rep">
                                     <!-- <td class="report"><?php //echo $i++; ?></td> -->
									 <td><?php echo date('d-m-Y',strtotime($tb->voucher_date)); ?></td>
									 <td><?php echo $tb->ac_name; ?></td>
                                     <td><?php echo $tb->dr_amt; $tot_debit +=$tb->dr_amt; ?></td>
                                     <td><?php echo $tb->cr_amt; $tot_cre +=$tb->cr_amt;?></td>
                                     
                                </tr>
 
                                <?php  
                                                        
                                    }
                                ?>
								<tr class="rep">
									 <td></td>
									 <td>Total</td>
                                     <td><?=$tot_debit?></td>
                                     <td><?=$tot_cre?></td>
                                </tr>
								<tr class="rep">
									 <td></td>
									 <td>Closing Balance</td>
                                     <td><?php if($type == 2 || $type == 4){ ?>
										  <?=$ope_bal+$tot_debit-$tot_cre?>
										 <?php } ?></td>
                                     <td><?php if($type == 1 || $type == 3){ ?>
									       <?=$ope_bal+$tot_cre-$tot_debit?>
								         <?php }  ?>
									 </td>
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


        <!-- <script>
            $(document).ready(function() {

$('.total').each(function() {
  var prevClass = $(this).prev().attr('class');
  var sum = 0;
  $('.' + prevClass).each(function() {
    sum += Number($(this).text());
  })

  $(this).text('Total :'+sum);
})

});
        </script> -->