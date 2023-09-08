<style>
#loader {
    position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 120px;
  height: 120px;
  margin: -76px 0 0 -76px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

/* #loader.loading { */
	/* background: <?= base_url() . 'assets/images/ajax-loader.gif' ?> no-repeat center center;
	width: 32px;
	margin: auto; */
    /* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
/* } */

</style>

    <!-- Loader -->
    <div id="loader" class="loading img-center" style="display: none;"></div>
<div class="wraper">

    <div class="row">

        <div class="col-lg-9 col-sm-12">

            <h1><strong>Service Invoice</strong></h1>

        </div>

    </div>
    <?php // print_r($this->session->userdata['loggedin']); ?>

    <div class="col-lg-12 container contant-wraper">

        <h3>
            <a href="<?php echo site_url("transaction/service_charge_invoice"); ?>" class="btn btn-primary"
                style="width: 100px;">Add</a>
            <span class="confirm-div" style="float:right; color:green;"></span>
        </h3>

        <table class="table table-bordered table-hover" id="example">

            <thead>
                <?php //print_r($this->session->userdata()) ?>

                <tr>
                    <th>Sl No.</th>
                    <th>Date</th>
                    <th>Invoice No</th>
                    <th>Customer</th>
                    <!-- <th>Godown</th> -->
                    <th>Amount</th>
                    <th>IRN</th>
                    <th>ACK No</th>
                    <th>ACT DT</th>
                    <th>DOWNLOAD</th>
                    <th>Delete</th>
                    <!-- <th>B2C Print</th> -->
                </tr>

            </thead>

            <tbody>

                <?php
   
                if ($listData) {
                    $i = 1;
                    foreach ($listData as $rent_list) {
						$disable_prnt=$rent_list->irn? 'hidden' : '';
                                $disable_btn = $rent_list->irn ? 'hidden' : '';
                                $enable_btn = $rent_list->irn ? '' : 'hidden';
                ?>

                <tr>
                    <td><?php echo $i; ?></td>
                    <td id="do_dt"><?php echo date("d/m/Y",strtotime($rent_list->trans_dt)); ?></td>
                    <td><?php echo $rent_list->invoice_no; ?></td>
                    <!-- <td><?php echo $rent_list->product_desc; ?></td> -->
                    <td><?php echo $rent_list->cust_name; ?></td>
                    <td><?php echo $rent_list->total_amt; ?></td>

					
					<td id="irn_clk_td_<?= $i ?>">
                                    <?php if($rent_list->irn ){echo ' <i class="fa fa-check fa-2x"  aria-hidden="true" style="color: green"></i>'; }
                                        else{ ?>
                                        <button type="button" data-toggle="tooltip" data-placement="bottom" title="irn" onclick="irn_clk(<?= $i ?>, '<?= $rent_list->invoice_no ?>')">
                                        <i class="fa fa-upload fa-2x"  aria-hidden="true" style="color: blue"></i>
                                        </button>
                                        <?php } ?> 
                    </td>

                    <!--  <td><?php echo $rent_list->irn; ?></td>  -->
                     <td><?php echo $rent_list->ack_no	; ?></td> 
                    <td><?php echo $rent_list->ack_dt	; ?></td> 
					 <td>
                        <button type="button" name="download_<?= $i ?>" class="download_" id="download"                  
                        data-toggle="tooltip" data-placement="bottom" title="download_" <?= $enable_btn; ?>>    
                         <a href="<?php echo site_url('api/print_irn?irn='.$rent_list->irn.''); ?>" id="down_clk_td_<?= $i ?>"		title="Download"><i class="fa fa-download fa-2x" style="color:green;"></i></a>
                     </td>

                    <td>
                        <!-- <a href="<?php //echo site_url() ?>/handling-trandport-charges/htc_collection_edit/<?php  //echo $rent_list->trans_no; ?>"
                            data-toggle="tooltip" data-placement="bottom" title="Edit">

                            <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
                        </a> -->
                        <?php if($rent_list->irn == ''){?>
                        <button type="button" class="delete" date="<?php //echo $value->voucher_date; ?>" id="<?php echo $rent_list->trans_no; ?>" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                    <i class="fa fa-trash-o fa-2x" style="color: #bd2130"></i>
                        </button>
                        <?php } ?>
                    </td>
                    
                </tr>

                <?php
                     $i++;  
                    }
                } else {

                    echo "<tr><td colspan='10' style='text-align: center;'>No data Found</td></tr>";
                }
                ?>

            </tbody>

            <tfoot>

                <tr>

                    <th>Sl No.</th>
                    <th>Date</th>
                    <th>Invoice No</th>
                   
                    <th>Customer</th>
                    <!-- <th>Godown</th> -->
                    
                    <th>Amount</th>
                    <th>IRN</th>
                    <th>ACK No</th>
                    <th>ACT DT</th>
                    <th>DOWNLOAD</th>
                    
                    <th>Delete</th>
                    
                </tr>

            </tfoot>

        </table>

    </div>

</div>

<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable( {
        "pagingType": "full_numbers",
        // "scrollY": 250,
        // "scrollX": true
    } );

    $('.delete').click(function() {
    var id = $(this).attr('id'),
        date = $(this).attr('date');

    var result = confirm("Do you really want to delete this record?");

    if (result) {

        window.location = "<?php echo site_url('transaction/service_delete?id="+id+"'); ?>";

    }

    });
} );
</script>

<script>
        function irn_clk(i, trans_do){
        // alert(i);
        var do_dt=$('#do_dt').text();
            
        var curr_dt=new Date();
        var curr = (((curr_dt.getDate())) > 9 ? ((curr_dt.getDate())) : '0'+((curr_dt.getDate()))) + '/' + (((curr_dt.getMonth())+1) > 9 ? ((curr_dt.getMonth())+1) : '0'+((curr_dt.getMonth())+1)) + '/' + curr_dt.getFullYear();
        console.log({'do_dt': do_dt, 'curr_dt': curr});
        if(do_dt != curr){
                    alert('IRN Genaration Not Possible');
                    $('[name="irn_clk_td_'+i+'"]').attr('disabled','disabled');
        }else{
            $.ajax({
            type: "GET",
            url: "<?php echo site_url('/api/get_api_service'); ?>",
            data: {trans_do: trans_do},
            dataType: 'html',
            beforeSend: function () {
                // Show image container
                $("#loader").show();
                $('.wraper').hide();
            },
            success: function (result) {
                // console.log(result);
                var res = JSON.parse(result);
                var trn_type='';
                console.log(res['Success']);
                if(res['Success'] == 'Y'){
                        save_data(trans_do, res['Irn'],res['AckNo'],res['AckDt'],trn_type='Y');
                    // if(save_data(trans_do, res['Irn']) > 0){
                        $('#ack_dt_td_' + i).empty();
                        $('#ack_clk_td_' + i).empty();
                        $('#irn_clk_td_' + i).empty();
                        $('#trn_type_td_' + i).empty();
                        // $('#irn_clk_td_' + i).text(res['Irn']);
                        $('#irn_clk_td_' + i).html('<i class="fa fa-check fa-2x"  aria-hidden="true" style="color: blue"></i>');
                        $('#ack_clk_td_' + i).text(res['AckNo']);
                        $('#ack_dt_td_' + i).text(res['AckDt']);
                        $('#down_clk_td_' + i).attr('href', '<?= site_url() ?>api/print_irn?irn='+res['Irn']);
                        $('#ack_dt_td_' + i).text('Cash/B2B');
                        // AckNo
                        //AckDt
                        $('[name="delete_'+i+'"]').attr('disabled', 'disabled');
                    // }else{
                    //     alert('Data Not Inserted');
                    //     $('[name="delete_'+i+'"]').removeAttr('disabled');
                    // }

                }else{
                    // alert('Something Went Wrong');
                    alert('IRN not generated! Something Went Wrong/This will may be a B2c invoice');
                    $('[name="delete_'+i+'"]').removeAttr('disabled');
                }
            },
            complete: function (data) {
                // Hide image container
                $("#loader").hide();
                $('.wraper').show();
            }
	    });

        }
        
    }

    function save_data(trans_do, irn,ack,ack_dt,trn_type){
        $.ajax({
            type: "GET",
            url: "<?php echo site_url('api/save_service_irn'); ?>",
            data: {trans_do: trans_do, irn: irn,ack:ack,ack_dt:ack_dt,trn_type:trn_type},
            dataType: 'html',
            success: function (result) {
                // console.log(result);
                if(result == 1){
                    return 1;
                    // alert('IRN GENERATED SUCCESSFULLY');
                }else{
                    return 0;
                }
               
            }
	    });
    }

</script>