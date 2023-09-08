<F12>
    <div class="wraper">

        <div class="row">

            <div class="col-lg-9 col-sm-12">

                <h1><strong>Unapproved CR Note Vouchers</strong></h1>

            </div>

        </div>

        <div class="col-lg-12 container contant-wraper">

            <!-- <h3>
                <a href="<?php echo site_url("bankVoucher/entry"); ?>" class="btn btn-primary" style="width: 100px;">Add</a>
                <span class="confirm-div" style="float:right; color:green;"></span>
            </h3> -->

            <table class="table table-bordered table-hover" id="example">

                <thead>

                    <tr>
                        <!-- <th>Date</th> -->
                        <th>Voucher No.</th>
                        <th>voucher Date</th>
                        <th>Transaction No</th>
                        <th>Amount</th>
                        <th>Edit</th>
                        <!-- <th style="width: 6%;">Approve</th> -->
                        <!-- <th>Delete</th> -->
                    </tr>

                </thead>

                <tbody>

                    <?php

                    if ($row) {
                        foreach ($row as $value) {
                            // $drcr_flag = $value->voucher_type == 'R' ? 'Dr' : 'Cr';
                            if ($value->approval_status == 'U') {
                    ?>

                                <tr>
                                    
                                    <td><?php echo $value->voucher_id; ?></td>
                                     <td><?php echo date('d/m/Y', strtotime($value->voucher_date)); ?></td>
                                     <td><?php echo $value->trans_no; ?></td>
                                    <td><?php echo $value->amount; ?></td>
                                    <td><a href="<?= site_url() ?>/Transaction/purchaseappv?id=<?php echo $value->voucher_id; ?>" data-toggle="tooltip" data-placement="bottom" title="Edit">

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
                            }
                        }
                    } else {

                        echo "<tr><td colspan='10' style='text-align: center;'>No data Found</td></tr>";
                    }
                    ?>

                </tbody>

                <tfoot>

                    <tr>

                    <th>Voucher No.</th>
                        <th>voucher Date</th>
                        <th>Transaction No</th>
                        <th>Amount</th>
                        <th>Edit</th>
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

                    window.location = "<?php echo site_url('transaction/bank_delete?id="+id+"'); ?>";

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

</script>

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
} );
</script>