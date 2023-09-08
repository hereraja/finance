<div class="wraper">

    <div class="row">

        <div class="col-lg-9 col-sm-12">

            <h1><strong>Handling & transport charges Customer List</strong></h1>

        </div>

    </div>

    <div class="col-lg-12 container contant-wraper">

        <h3>
            <a href="<?php echo site_url("handling-trandport-charges/customar_entry"); ?>" class="btn btn-primary" style="width: 100px;">Add</a>
            <span class="confirm-div" style="float:right; color:green;"></span>
        </h3>

        <table class="table table-bordered table-hover" id="example">
            <thead>
                <tr>
                    <th>Sl No.</th>
                    <th>Customer Name</th>
                    <th>District</th>
                    <th>Contact No</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>

                <?php

                if ($customar_list) {
                    $i = 1;
                    foreach ($customar_list as $dt) {
                ?>

                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $dt->cust_name; ?></td>
                            <td><?php echo $dt->district_name; ?></td>
                            <td><?php echo $dt->cnct_no; ?></td>
                            <td><a href="<?php echo site_url() ?>/handling-trandport-charges/customar-edit/<?php  echo $dt->id; ?>" data-toggle="tooltip" data-placement="bottom" title="Edit">

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
                    <th>Customer Name</th>
                    <th>District</th>
                    <th>Contact No</th>
                    <th></th>
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
        $('#example').DataTable({
            "pagingType": "full_numbers",
            // "scrollY": 250,
            // "scrollX": true
        });
    });
</script>

<!--<script>

    $(document).ready( function (){

        $('.delete').click(function () {

            var id = $(this).attr('id'),
                date = $(this).attr('date');

            var result = confirm("Do you really want to delete this record?");

            if(result) {

                window.location = "<//?php echo site_url('payroll/deduction/delete?empcd="+id+"&saldate="+date+"');?>";

            }
            
        });

    });

</script>-->

<script>
    $(document).ready(function() {

        <?php if ($this->session->flashdata('msg')) { ?>
            window.alert("<?php echo $this->session->flashdata('msg'); ?>");
    });

    <?php } ?>
</script>