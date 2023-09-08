<style>
    table {
        border-collapse: collapse;
    }

    table,
    td,
    th {
        border: 1px solid #dddddd;
        padding: 6px;
        font-size: 14px;
    }

    th {
        text-align: center;
    }

    tr:hover {
        background-color: #f5f5f5;
    }
</style>

<script>
    function printDiv() {

        var divToPrint = document.getElementById('divToPrint');

        var WindowObject = window.open('', 'Print-Window');
        WindowObject.document.open();
        WindowObject.document.writeln('<!DOCTYPE html>');
        WindowObject.document.writeln(
            '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title></title><style type="text/css">'
            );


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
                <h4>Rent Collection Between: <?php echo date('d-m-Y',strtotime($from_date)); ?> To <?php echo date('d-m-Y',strtotime($todate)); ?></h4>
                <!-- <h5 style="text-align:left"><label>District: </label> <?php //echo $branch->district_name; ?></h5> -->

            </div>
            <br>
            <?php //print_r($this->session->userdata('loggedin')) ?>
            <table style="width: 100%;" id="example">

                <thead>
                    <th>Sl No.</th>
                    <th>Date</th>
                    <th>Invoice No</th>
                    <th>Customer</th>
                    <th>Godown</th>
                    <th>IRN ACK No</th>
                    <!-- <th>collection date</th> -->
                    <!--<th>Bank</th>-->
                    <th>Gross Amount</th>
                    <th>CGST</th>
                    <th>SGST</th>
                    <th>NET Amount</th>
                </thead>

                <tbody>

                    <?php
    // print_r($listData);
    $grossAmount=0;
    $CGST=0;
    $SGST=0;
    $netAmount=0;
                if ($listData) {
                    $i = 1;
                    foreach ($listData as $rent_list) {
                        
                ?>

                    <tr>
                        <td><?php echo $i; ?></td>
                        <td id="do_dt"><?php echo date("d/m/Y",strtotime($rent_list->trans_dt)); ?></td>
                        <td><?php echo $rent_list->invoice_no; ?></td>
                        <!-- <td><?php echo $rent_list->product_desc; ?></td> -->
                        <td><?php echo $rent_list->cust_name; ?></td>
                        <td><?php echo $rent_list->gdn_name; ?></td>
                        <td><?php echo $rent_list->ack_no; ?></td>
                        <!-- <td><?php echo date("d/m/Y",strtotime($rent_list->payment_date)); ?></td> -->
                        <!-- <td>//<?php echo $rent_list->ac_name; ?></td>-->
                        <td><?php  $grossAmount= $grossAmount+$rent_list->taxable_amt; echo $rent_list->taxable_amt	; ?></td>
                        <td><?php $CGST=$CGST+$rent_list->cgst_amt; echo $rent_list->cgst_amt	; ?></td>
                        <td><?php $SGST=$SGST+$rent_list->sgst_amt; echo $rent_list->sgst_amt	; ?></td>
                        <td><?php $netAmount=$netAmount+$rent_list->total_amt; echo $rent_list->total_amt; ?></td>
                        
                    </tr>

                    <?php
                     $i++;  
                    }
                }         
                ?>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right"><b>Total</b></td>
                    <td><b><?php echo  $grossAmount; ?></b></td>
                    <td><b><?php echo $CGST; ?></b></td>
                    <td><b><?php echo $SGST ?></b></td>
                    <td><b><?php echo $netAmount ?></b></td>
                    <!-- <td  colspan="4"></td> -->
                   
                </tbody>

            </table>

        </div>

        <div style="text-align: center;">

            <button class="btn btn-primary" type="button" onclick="printDiv();">Print</button>
            <!-- <button class="btn btn-primary" type="button" id="btnExport" >Excel</button>-->

        </div>

    </div>

</div>




<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" rel="stylesheet" />

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>


<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>

<script>
   $('#example').dataTable({
    destroy: true,
   searching: false,ordering: false,paging: false,

dom: 'Bfrtip',
buttons: [
   {
extend: 'excelHtml5',
title: 'Rent Collection',
text: 'Export to excel'

   }
]
   });
</script>
