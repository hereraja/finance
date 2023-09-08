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

            <h1><strong>Collect Rent</strong></h1>

        </div>

    </div>
    <?php // print_r($this->session->userdata['loggedin']); ?>

    <div class="col-lg-12 container contant-wraper">

        <!-- <h3>
            <a href="<?php //echo site_url("rent_collection/entry"); ?>" class="btn btn-primary"
                style="width: 100px;">Add</a>
            <span class="confirm-div" style="float:right; color:green;"></span>
        </h3> -->

        <table class="table table-bordered table-hover">

            <thead>
                <?php //print_r($this->session->userdata()) ?>

                <tr>
                    <th>Sl No.</th>
                    <th>Date</th>
                    <th>Invoice No</th>
                   
                    <th>Customer</th>
                    <!-- <th>Godown</th> -->
                    
                    <th>Amount</th>
                    <th>ACK No</th>
                    <th>ACT DT</th>
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
                    <td id="do_dt"><?php echo date("d/m/Y",strtotime($rent_list->trans_dt)); ?></td>
                    <td><?php echo $rent_list->invoice_no; ?></td>
                    <!-- <td><?php echo $rent_list->product_desc; ?></td> -->
                    <td><?php echo $rent_list->cust_name; ?></td>
                    <!-- <td><?php echo $rent_list->gdn_name; ?></td> -->
                    <!-- <td><?php echo $rent_list->taxable_amt	; ?></td> -->
                    <!-- <td><?php echo $rent_list->cgst_amt	; ?></td> -->
                    <!-- <td><?php echo $rent_list->sgst_amt	; ?></td> -->
                    <td><?php echo $rent_list->total_amt; ?></td>
                   
                    <td><?php echo $rent_list->ack_no; ?></td>
                    <td><?php echo $rent_list->ack_dt; ?></td>

                    <td><a href="<?php echo site_url() ?>/collectRent/edit/<?php  echo $rent_list->trans_no; ?>"
                            data-toggle="tooltip" data-placement="bottom" title="Edit">

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
                    <th>Date</th>
                    <th>Invoice No</th>
                   
                    <th>Customer</th>
                    <!-- <th>Godown</th> -->
                    
                    <th>Amount</th>
                    <th>ACK No</th>
                    <th>ACT DT</th>
                    <th></th>
                </tr>

            </tfoot>

        </table>

    </div>

</div>
