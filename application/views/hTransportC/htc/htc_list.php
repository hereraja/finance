<div class="wraper">

    <div class="row">

        <div class="col-lg-9 col-sm-12">

            <h1><strong>Handling & transport charges</strong></h1>

        </div>

    </div>

    <div class="col-lg-12 container contant-wraper">

        <h3>
            <a href="<?php echo site_url("handling-trandport-charges/customar_htc_entry"); ?>" class="btn btn-primary" style="width: 100px;">Add</a>
            <span class="confirm-div" style="float:right; color:green;"></span>
        </h3>

        <table class="table table-bordered table-hover" id="example">

            <thead>

                <tr>
                    <th>Sl No.</th>
                    <th>Effective Date</th>
                    <!-- <th>Godown</th> -->
                    <th>Customer</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Amount</th>
                    <th></th>
                </tr>

            </thead>

            <tbody>

                <?php
    // print_r($listData);
                if ($listData) {
                    $i = 1;
                    foreach ($listData as $rent_list) {
                        
                ?>

                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $rent_list->effective_date; ?></td>
                    <!-- <td><?php //echo $rent_list->gdn_name; ?></td> -->
                    <td><?php echo $rent_list->cust_name; ?></td>
                    <td><?php echo $rent_list->htc_start_date	; ?></td>
                    <td><?php echo $rent_list->htc_end_date	; ?></td>
                    <td><?php echo $rent_list->htc_amt	; ?></td>
                    <td><a href="<?php echo site_url() ?>/handling-trandport-charges/htc_edit/<?php echo $rent_list->sl_no ; ?>" data-toggle="tooltip"
                            data-placement="bottom" title="Edit">

                            <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
                        </a>
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

            <th>Sl No.</th>
                    <th>Effective Date</th>
                    <!-- <th>Godown</th> -->
                    <th>Customer</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Amount</th>
                    <th></th>

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
        $('#example').DataTable({
            "pagingType": "full_numbers",
            // "scrollY": 250,
            // "scrollX": true
        });
    });
</script>