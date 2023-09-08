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
        WindowObject.document.writeln('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title></title><style type="text/css">');


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

                        <h2>THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.</h2>
                        <h4>HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR, 1582 RAJDANGA MAIN ROAD, KOLKATA-700107.</h4>
                        <h4>Trial Balance Between: <?php echo $_SESSION['date']; ?></h4>
                        <!-- <h5 style="text-align:left"><label>District: </label> <?php echo $branch->district_name; ?></h5> -->

                    </div>
                    <br>  

                    <table style="width: 100%;" id="example">

                        <thead>
                            <tr>
                                <th rowspan='2'>Particulars</th>
                                <th rowspan='2'>Opening Balance</th>
                                <th colspan='2'>Tranction</th>
                                <th rowspan='2'>Closing Balance</th>
                            </tr>
							<tr>
                               
                                <th>Debit</th>
                                <th>Credit</th>
								
                            </tr>

                        </thead>

                        <tbody>

                            <?php

                                if($trail_balnceg){

                                    $i = 1;
                                    $total = 0.00;
                                    $val =0;

                                        foreach($trail_balnceg as $tbg){
                            ?>
                              
                                <tr class="rep">
                                     <!-- <td class="report"><?php echo $i++; ?></td> -->
                                     <!-- <tr v-for="(cover,index) in  packetDocument" i=index> -->
									 <td ><b><?php echo $tbg->name; ?></b></td>
                                     <td ><?php //echo $tb->voucher_id; ?></td>
                                     <td ><?php echo $tbg->dr_amt; ?></td>
                                     <td ><?php echo $tbg->cr_amt; ?></td>
                                     <td ><?php //echo $tb->dr_cr_flag; ?></td>
                                     
                                </tr>
									<?php   if($trail_balnce){
											    foreach($trail_balnce as $tb){
												   if($tbg->mngr_id == $tb->mngr_id){
									?>
												
									<tr class="rep">
										 <!-- <td class="report"><?php echo $i++; ?></td> -->
										 <!-- <tr v-for="(cover,index) in  packetDocument" i=index> -->
										 <td style="padding-left: 30px;"> <?php echo $tb->ac_name; ?></td>
										 <td ><?php //echo $tb->voucher_id; ?></td>
										 <td ><?php echo $tb->dr_amt; ?></td>
										 <td ><?php echo $tb->cr_amt; ?></td>
										 <td ><?php //echo $tb->dr_cr_flag; ?></td>
									</tr>
								    <?php          }   
									           }   
									       }      ?>
 
                                <?php  
                                                        
                                    }
                                ?>

 
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