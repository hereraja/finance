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
                        <h4>Credit Note Journal Between: <?php echo $_SESSION['date']; ?></h4>
                        <!-- <h5 style="text-align:left"><label>District: </label> <?php echo $branch->district_name; ?></h5> -->

                    </div>
                    <br>  

                    <table style="width: 100%;" id="example">

                        <thead>
                        <!-- <th>Journal Id</th> -->
                            <tr>
                            
                                <!-- <th>Sl No.</th> -->
                                <th>Journal Id</th>
                                <th>Journal Date</th>
                                <th>Acc Name</th>
                                <th>Trans Type</th>
                                <th>Dr Amount</th>
                                <th>Cr Amount</th>
                                <!-- <th>Amount</th> -->

                            </tr>

                        </thead>

                        <tbody>

                            <?php

//  print_r($opening);
//  exit;
                                if($advance){ 

                                    $i = 1;
                                    $total = 0.00;
                                    $val =0;

                                        foreach($advance as $prodtls){
                            ?>
                              
                                <tr class="rep">
                                     <!-- <td class="report"><?php echo $i++; ?></td> -->
                                     <!-- <tr v-for="(cover,index) in  packetDocument" i=index> -->
                                     <td class=<?php echo $prodtls->sl_no; ?>><?php echo $prodtls->voucher_id; ?></td>
                                     <td class=<?php echo $prodtls->sl_no; ?>><?php echo date("d/m/Y",strtotime($prodtls->voucher_date)); ?></td>
                                     <td class=<?php echo $prodtls->sl_no; ?>><?php echo $prodtls->ac_name; ?></td>
                                     <td class=<?php echo $prodtls->sl_no; ?>><?php echo $prodtls->dr_cr_flag; ?></td>
                                     
                                     <td class=<?php echo $prodtls->sl_no; ?>><?php 
                                       if($prodtls->dr_cr_flag=='Dr'){
                                        echo $prodtls->amount;
                                    }
                                    
                                     ?></td>

                                     <td class=<?php echo $prodtls->sl_no; ?>><?php 
                                       if($prodtls->dr_cr_flag=='Cr'){
                                        echo $prodtls->amount;}
                                       
                                   ?></td>
                                    
                                     <!-- <td class="report"><?php echo $prodtls->amount; ?> -->
                                     <!-- <td class="report opening" id="opening">
                                        <?php 
                                            foreach($opening as $opndtls){
                                                if($prodtls->prod_id==$opndtls->prod_id){
                                                    echo $opndtls->opn_qty;
                                                }
                                            }
                                        ?>
                                     </td> -->
                                     <!-- <td class="report purchase" id="purchase">
                                        <?php 
                                            foreach($purchase as $purdtls){
                                                if($prodtls->prod_id==$purdtls->prod_id){
                                                    echo $purdtls->tot_pur;
                                                }
                                            }
                                        ?>
                                     </td> -->
                                     <!-- <td class="report sale" id="sale">
                                        <?php 
                                            foreach($sale as $saledtls){
                                                if($prodtls->prod_id==$saledtls->prod_id){
                                                    echo $saledtls->tot_sale;
                                                }
                                            }
                                        ?>
                                     </td> -->

                                     <!-- <td class="report closing" id="closing">
                                        <?php 
                                        foreach($opening as $opndtls){
                                            if($prodtls->prod_id==$opndtls->prod_id){
                                                echo $opndtls->cls_qty;
                                            }
                                        }
                                        
                                            
                                        ?>
                                     </td> -->
                                   
                                </tr>
 
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