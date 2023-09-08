<div class="wraper">

    <div class="row">

        <div class="col-lg-9 col-sm-12">

            <h1><strong>Print Journal Vouchers</strong></h1>

        </div>

    </div>

    <div class="col-lg-12 container contant-wraper">
		<div class="col-sm-2">
        <!-- <h3>
            <a href="<?php echo site_url("jurnalVoucher/entry"); ?>" class="btn btn-primary" style="width: 100px;">Add</a>
            <span class="confirm-div" style="float:right; color:green;"></span>
        </h3> -->
		</div>
		    <div class="col-sm-8" style="margin-top:20px">
			<form method="POST" action="<?php echo site_url("transaction/approvedjournal") ?>" >
            <label for="voucher_dt" class="col-sm-2 col-form-label">From Date:</label>
            <div class="col-sm-3">
              <input type="date" name="fr_dt" class="form-control" value="" required />
            </div>
            <label for="voucher_mode" class="col-sm-2 col-form-label">To Date:</label>
            <div class="col-sm-3">
                    <input type="date" name="to_dt" class="form-control" value="" required />
            </div>
			<div class="col-sm-2"><input type="submit" value="Filter"></div>
			</form>
		</div>	

        <table class="table table-bordered table-hover">

            <thead>

                <tr>
                    <th>Date</th>
                    <th>Voucher No.</th>
                    <th>Type</th>
                    <th>Mode</th>
                    <th>Amount</th>
                    <th>Print</th>
                    <!-- <th>Edit</th>
                    <th>Delete</th> -->
                </tr>

            </thead>

            <tbody>

                <?php

                if ($row) {
                    foreach ($row as $value) {
                ?>

                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($value->voucher_date)); ?></td>
                            <td><?php echo $value->voucher_id; ?></td>
                            <td><?php $type = $value->voucher_type;
                                if ($type == "P") {
                                    $type = "Payment";
                                } else {
                                    $type = "Receipt";
                                }
                                echo $type;
                                ?></td>
                            <td><?php $mode = $value->voucher_mode;
                                if ($mode == "C") {
                                    $val = "Cash";
                                } elseif ($mode == "B") {
                                    $val = "Bank";
                                } else {
                                    $val = "Journal";
                                }
                                echo $val;
                                ?></td>
                            <td><?php echo $value->amount; ?></td>
                            <td>
                              <a href="<?php echo site_url('report/jrnlprn?voucher_id='.$value->voucher_id.''); ?>" title="Print">

                            
                              <i class="fa fa-print fa-2x" style="color:green;"></i>  
                              <!-- <span class="mdi mdi-printer"></span> -->
                              </a>
                            </td>
                            <!-- <td><a href="<?= site_url() ?>/transaction/jurnal_edit?id=<?php echo $value->voucher_id; ?>" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                    <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
                                </a>
                            </td> -->
                        <!--    <td><a href="<?= site_url() ?>/transaction/jurnal_approve?id=<?php //echo $value->voucher_id; ?>" data-toggle="tooltip" data-placement="bottom" title="Forward">
                                    <i class="fa fa-forward fa-2x" style="color: #007bff"></i>
                                </a>
                            </td>  -->
							<!-- <?php if($value->voucher_mode != 'A'){ ?>
                            <td>
                                <button type="button" class="delete" date="<?php echo $value->voucher_date; ?>" id="<?php echo $value->voucher_id; ?>" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                    <i class="fa fa-trash-o fa-2x" style="color: #bd2130"></i>
                                </button>
                            </td>
							 <?php }?> -->
                        </tr>

                <?php

                    }
                } else {

                    echo "<tr><td colspan='10' style='text-align: center;'>No data Found</td></tr>";
                }
                ?>

            </tbody>

            <tfoot>

                <tr>

                    <th>Date</th>
                    <th>Voucher No.</th>
                    <th>Type</th>
                    <th>Mode</th>
                    <th>Amount</th>
                    <th>Print</th>
                    <!-- <th>Edit</th>
                    <th>Delete</th> -->
                </tr>

            </tfoot>

        </table>

    </div>

</div>

<script>
    $(document).ready(function() {

        $('.delete').click(function() {

            var id = $(this).attr('id'),
                date = $(this).attr('date');

            var result = confirm("Do you really want to delete this record?");

            if (result) {

                window.location = "<?php echo site_url('transaction/jurnal_delete?id="+id+"'); ?>";

            }

        });

    });
</script>

<script>
    $(document).ready(function() {

        <?php if ($this->session->flashdata('msg')) { ?>
            window.alert("<?php echo $this->session->flashdata('msg'); ?>");
    });

    <?php } ?>
</script>