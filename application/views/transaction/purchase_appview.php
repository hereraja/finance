<div class="wraper">

    <div class="row">

        <div class="col-lg-9 col-sm-12">

            <h1><strong>Unapproved & Hold Vouchers</strong></h1>

        </div>

    </div>

    <div class="col-lg-12 container contant-wraper">
        <br>
        <!-- <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-2">

                <strong>Select Vouchers</strong>
               
            </div>
			<div class="col-lg-3">
              <select name="vtype" class="form-control" id="vtype">
			    <option value="">Select</option>
				<option value="P">Payment</option>
				<option value="R">Received</option>
				<option value="A">Advance</option>
				<option value="CRN">Credit Note</option>
				<option value="DRN">Debit Note</option>
				<option value="SL">Sale</option>
				<option value="PUR">Purchase</option>
				<option value="RECV">Receive From Society</option>
				</select>
            </div>

        </div> -->
        <div id="v_list">
            <br>
            <table class="table table-bordered table-hover" id="example">
                <thead>
                    <tr>
                        <th>Sl. No</th>
                        <th>Voucher No.</th>
                        <th>voucher Date</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Edit</th>
                        <!-- <th style="width: 6%;">Approve</th> -->
                        <!-- <th>Delete</th> -->
                    </tr>

                </thead>
                <tbody>

                    <?php
					
                    if ($row) {
						$i = 1;
                        foreach ($row as $value) {
                            // $drcr_flag = $value->voucher_type == 'R' ? 'Dr' : 'Cr';
                            //if (//$value->approval_status == 'U') {
                    ?>

                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $value->voucher_id; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($value->voucher_date)); ?></td>
                        <th>
                            <?php if($value->approval_status=='U'){
                                             echo'Unapproved';
                                         }else if($value->approval_status=='H'){
                                            echo'On Hold';
                                         }  ?>
                        </th>
                        <!-- <td><?php echo $value->trans_no; ?></td> -->
                        <td><?php echo $value->dr_amt; ?></td>
                        <td><a href="<?= site_url() ?>/Transaction/purchaseappv?id=<?php echo $value->voucher_id; ?>"
                                data-toggle="tooltip" data-placement="bottom" title="Edit">

                                <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
                            </a>
                        </td>
                        <!-- <td><a href="<?= site_url() ?>/transaction/bank_forward?id=<?php echo $value->voucher_id; ?>" data-toggle="tooltip" data-placement="bottom" title="Forward">
                                            <i class="fa fa-forward fa-2x" style="color: #007bff"></i>
                                        </a>
                                    </td> -->
                        <!-- <td>
                                        <button type="button" class="delete" date="<?php echo $value->voucher_date; ?>" id="<?php echo $value->voucher_id; ?>" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                            <i class="fa fa-trash-o fa-2x" style="color: #bd2130"></i>
                                        </button>
                                    </td> -->
                    </tr>

                    <?php
                            //}
                        }
                    } else {

                        echo "<tr><td colspan='10' style='text-align: center;'>No data Found</td></tr>";
                    }
                    ?>

                </tbody>

                <tfoot>

                    <tr>
                        <th>Sl. No</th>
                        <th>Voucher No.</th>
                        <th>voucher Date</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Edit</th>
                    </tr>

                </tfoot>

            </table>
        </div>
        <center><img src="<?=base_url()?>assets/images/loader.gif" height="120px" id="image"
                style="margin-top:20px;display:none"></img></center>
        <div id="v_lists">

        </div>
    </div>

</div>

<script>
    $(document).ready(function () {

        $('.delete').click(function () {

            var id = $(this).attr('id'),
                date = $(this).attr('date');
            var result = confirm("Do you really want to delete this record?");
            if (result) {
                window.location = "<?php echo site_url('transaction/bank_delete?id=" + id + "'); ?>";
            }

        });

    });
</script>

<script>
    $(document).ready(function () {

        <?php
        if ($this->session-> flashdata('msg')) {
            ?>
            window.alert("<?php echo $this->session->flashdata('msg'); ?>"); 
            <?php
        } ?>
    });
</script>


<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "pagingType": "full_numbers",
            // "scrollY": 250,
            // "scrollX": true
        });
    });

    $(document).ready(function () {


        // your code to get data

        // $('input[type=radio][name=vtype]').on('change', function() {
        // 		$('#vtype').on('change', function() {
        // 			$('#v_list').hide();
        // 			$('#v_lists').html('');
        // 			$('#image').show();
        // 			$.ajax({
        // 				type: "GET",
        // 				url: "<?php echo site_url('transaction/get_voucher'); ?>",
        // 				beforeSend: function(){
        //                 $('#image').show();
        // 				},
        // 				complete: function(){
        // 					$('#image').hide();
        // 				},
        // 				data: {
        // 					vtype: $(this).val()
        // 				},
        // 				success: function(result) {

        // 					  var string = '<br><table class="table table-bordered table-hover" id="example"><thead><tr><th>Voucher No.</th><th>Voucher No.</th><th>voucher Date</th><th>Transaction No</th><th>Amount</th><th>Edit</th></tr></thead><tbody>';
        // 					  var sl_no = 1;
        // 					  var  utype = '';
        // 					$.each(JSON.parse(result), function( index, value ) {

        // 						var dateAr = value.voucher_date.split('-');
        // var newDate = dateAr[1] + '/' + dateAr[2] + '/' + dateAr[0];

        // 						string += '<tr><td>' + sl_no++ + '</td><td>' + value.voucher_id + '</td><td>' + newDate + '</td><td>' + value.trans_no + '</td><td>' + value.amount + '</td><td><a href="Transaction/purchaseappv?id=' + value.voucher_id + '" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-edit fa-2x" style="color: #007bff"></i></a></td></tr>'

        // 					});
        // 				string +='</tbody></table>';

        // 					$('#v_list').hide();
        // 					$('#v_lists').html(string);

        // 				}
        //             });



        // 		});

    });
</script>