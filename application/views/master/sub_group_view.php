<div class="wraper">

    <div class="row">

        <div class="col-lg-9 col-sm-12">

            <h1><strong>Sub Group Master</strong></h1>

        </div>

    </div>

    <div class="col-lg-12 container contant-wraper">

        <h3>
            <a href="<?php echo site_url("subgroup/entry"); ?>?id=" class="btn btn-primary" style="width: 100px;">Add</a>
            <span class="confirm-div" style="float:right; color:green;"></span>
        </h3>

        <table class="table table-bordered table-hover">

            <thead>

                <tr>
                    <th>Sl No.</th>
                    <th>Group Name</th>
                    <th>Sub Group Name</th>
                    <th>Option</th>
                </tr>

            </thead>

            <tbody>

                <?php
                $sub_group_dtls = json_decode($sub_group_dtls);
                if ($sub_group_dtls) {
                    $i = 1;
                    foreach ($sub_group_dtls as $dt) {
                ?>

                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $dt->group_name; ?></td>
                            <td><?= $dt->name; ?></td>
                            <td><a href="<?= site_url() ?>/subgroup/entry?id=<?php echo $dt->sl_no; ?>" data-toggle="tooltip" data-placement="bottom" title="Edit">

                                    <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
                                </a>
                            </td>
                        </tr>

                <?php
                        $i++;
                    }
                } else {

                    echo "<tr><td colspan='4' style='text-align: center;'>No data Found</td></tr>";
                }
                ?>

            </tbody>

            <tfoot>

                <tr>
                    <th>Sl No.</th>
                    <th>Group Name</th>
                    <th>Sub Group Name</th>
                    <th>Option</th>
                </tr>

            </tfoot>

        </table>

    </div>

</div>

<script>
    $(document).ready(function() {

        <?php if ($this->session->flashdata('msg')) { ?>
            window.alert("<?php echo $this->session->flashdata('msg'); ?>");
    });

    <?php } ?>
</script>