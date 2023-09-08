<div class="wraper">

    <div class="row">

        <div class="col-lg-9 col-sm-12">

            <h1><strong>Group Master</strong></h1>

        </div>

    </div>

    <div class="col-lg-12 container contant-wraper">

        <h3>
            <a href="<?php echo site_url("group/entry"); ?>" class="btn btn-primary" style="width: 100px;">Add</a>
            <span class="confirm-div" style="float:right; color:green;"></span>
        </h3>

        <table class="table table-bordered table-hover">

            <thead>

                <tr>
                    <th>Sl No.</th>
                    <th>Group Name</th>
                    <th>Group Type</th>
                    <th>Option</th>
                </tr>

            </thead>

            <tbody>

                <?php

                if ($group_dtls) {
                    $i = 1;
                    foreach ($group_dtls as $dt) {
                ?>

                        <tr>
                            <td><?= $i; ?></td>
                            <td><?php echo $dt->name; ?></td>
                            <td><?php echo $group_type[$dt->type]; ?></td>
                            <td><a href="<?= site_url() ?>/group/edit?id=<?php echo $dt->sl_no; ?>" data-toggle="tooltip" data-placement="bottom" title="Edit">

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
                    <th>Schedule Name</th>
                    <th>Option</th>
                </tr>

            </tfoot>

        </table>

    </div>

</div>

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