<div class="wraper">

    <div class="row">

        <div class="col-lg-9 col-sm-12">

            <h1><strong>Godown Rent</strong></h1>

        </div>

    </div>

    <div class="col-lg-12 container contant-wraper">

        <h3>
            <a href="<?php echo site_url("godownrent/entry"); ?>" class="btn btn-primary" style="width: 100px;">Add</a>
            <span class="confirm-div" style="float:right; color:green;"></span>
        </h3>

        <table class="table table-bordered table-hover">

            <thead>

                <tr>
                    <th>Sl No.</th>
                    <th>Effective Date</th>
                    <th>Godown</th>
                    <th>Customer</th>
                    <th>Start Date</th>
                    <th>End Date</th>
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
                    <td><?php echo $rent_list->gdn_name; ?></td>
                    <td><?php echo $rent_list->cust_name; ?></td>
                    <td><?php echo $rent_list->rent_start_date	; ?></td>
                    <td><?php echo $rent_list->rent_end_date	; ?></td>
                    <td><?php echo $rent_list->rent_amt	; ?></td>
                    <td><a href="<?php echo site_url() ?>/godownrent/edit/<?php echo $rent_list->sl_no ; ?>" data-toggle="tooltip"
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

                <tr>

                    <th>Sl No.</th>
                    <th>Effective Date</th>
                    <th>Godown</th>
                    <th>Customer</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Amount</th>
                    <th></th>
                </tr>

            </tfoot>

        </table>

    </div>

</div>
