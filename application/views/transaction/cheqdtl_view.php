<div class="wraper">

    <div class="row">

        <div class="col-lg-9 col-sm-12">

            <h1><strong>Cheque detail list</strong></h1>

        </div>

    </div>

    <div class="col-lg-12 container contant-wraper">
		<div class="col-sm-2">
        <h3>
            <a href="<?php echo site_url("cheqdtladd"); ?>" class="btn btn-primary" style="width: 100px;">Add</a>
            <span class="confirm-div" style="float:right; color:green;"></span>
        </h3>
		</div>
		    <div class="col-sm-8" style="margin-top:20px">
			<form method="POST" action="<?php echo site_url("cheqdtl") ?>" >
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
                    <th>Society </th>
                    <th>Cheque No.</th>
                    <th>Cheque Dt</th>
                    <th>Amount</th>
                    <th>Bank Name</th>
                    <th>Option</th>
                </tr>

            </thead>

            <tbody>

                <?php

                if ($row) {
                    foreach ($row as $value) {
                ?>

                        <tr>
                            <td><?php foreach($society as $v){
                                if($v->soc_id == $value->soc_id) { echo $v->soc_name; }
                            } ?></td>
                            <td><?php echo $value->cheq_no; ?></td>
                            <td><?php echo $value->cheq_dt; ?></td>
                            <td><?php echo $value->amt; ?></td>
                            <td><?php echo $value->bank_name; ?></td>
                            <td><a href="<?= site_url() ?>/transaction/cheqdtledit?id=<?php echo $value->id; ?>" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                    <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
                                </a>
                                <button type="button" class="delete" date="" id="<?php echo $value->id; ?>" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                    <i class="fa fa-trash-o fa-2x" style="color: #bd2130"></i>
                                </button>
                               
                            </td>
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
                    <th>Society </th>
                    <th>Cheque No.</th>
                    <th>Cheque Dt</th>
                    <th>Amount</th>
                    <th>Bank Name</th>
                    <th>Option</th>
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

                window.location = "<?php echo site_url('transaction/cheqdtldelete?id="+id+"'); ?>";

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