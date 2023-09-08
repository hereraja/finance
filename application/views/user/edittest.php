<div class="wraper">

    <form method="POST" id="form" action="<?php echo site_url("admins/user_edit"); ?>">

        <div class="col-md-6 container form-wraper" style="margin-left: 0px;">

            <div class="form-header">

                <h4>User Edit</h4>

            </div>

            <input type="hidden" name="user_id" value="<?php echo $user_dtls->user_id; ?>" />

            <div class="form-group row">

                <label for="name" class="col-sm-2 col-form-label">User Name:</label>

                <div class="col-sm-10">

                    <input type="text" class="form-control required" name="name" id="name" value="<?php echo $user_dtls->user_name; ?>" />

                </div>

            </div>
            <div class="form-group row">

                <label for="name" class="col-sm-2 col-form-label">Employee Code:</label>

                <div class="col-sm-10">

                    <input type="text" class="form-control required" name="emp_code" id="emp_code" value="<?php echo $user_dtls->emp_code; ?>" />

                </div>

            </div>
            <div class="form-group row">

                <label for="name" class="col-sm-2 col-form-label">Designation:</label>

                <div class="col-sm-10">

                    <input type="text" class="form-control required" name="designation" id="designation" value="<?php echo $user_dtls->designation; ?>" />

                </div>

            </div>

            <?php if ($this->session->userdata['loggedin']['ho_flag'] == "Y") {   ?>
                <div class="form-group row">

                    <label for="pass" class="col-sm-2 col-form-label">Permission:</label>

                    <div class="col-sm-3">
                        <select name="user_type" class="form-control">
                            <option value="">Select</option>
                            <option value="M" <?php if ($user_dtls->user_type == "M") {
                                                    echo "selected";
                                                } ?>>Manager</option>
                            <option value="D" <?php if ($user_dtls->user_type == "D") {
                                                    echo "selected";
                                                } ?>>Accountant</option>
                            <option value="U" <?php if ($user_dtls->user_type == "U") {
                                                    echo "selected";
                                                } ?>>User</option>
                        </select>

                    </div>

                    <label for="pass" class="col-sm-2 col-form-label">User status:</label>

                    <div class="col-sm-3">
                        <select name="user_status" class="form-control">
                            <option value="">Select</option>
                            <option value="A" <?php if ($user_dtls->user_status == "A") {
                                                    echo "selected";
                                                } ?>>Active</option>
                            <option value="I" <?php if ($user_dtls->user_status == "I") {
                                                    echo "selected";
                                                } ?>>Inactive</option>
                        </select>

                    </div>

                </div>

                <div class="form-group row">

                    <div class="col-sm-10">

                        <input type="submit" class="btn btn-info" value="Save" />

                    </div>

                </div>

            <?php } else { ?>
                <?php if ($user_dtls->user_status != "A") {   ?>

                    <div class="form-group row">

                        <div class="col-sm-10">

                            <input type="submit" class="btn btn-info" value="Save" />

                        </div>

                    </div>

            <?php  }
            }
            ?>
        </div>



    </form>

</div>

<script>
    $("#form").validate();
</script>