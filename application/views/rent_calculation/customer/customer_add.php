<div class="wraper">

    <div class="col-md-8 container form-wraper">


        <form method="POST" action="<?php echo site_url("customer/entry");?> " onsubmit="return valid_data()">
            
            <div class="form-header">

                <h4>Add Rent Customer</h4>

            </div>



            <div class="form-group row">

                <label for="ac_type" class="col-sm-2 col-form-label">Customer Name:</label>

                <div class="col-sm-10">

                    <input type="text" class="form-control" id="gr_name" name="customerName" required />

                </div>

            </div>

            <div class="form-group row">

                <label for="remarks" class="col-sm-2 col-form-label">Customer Address:</label>

                <div class="col-sm-10">

                    <textarea class="form-control" name="customerAddress" required></textarea>

                </div>
            </div>
            <div class="form-group row">
                <label for="trans_dt" class="col-sm-2 col-form-label">PIN Code:</label>
                <div class="col-sm-4">
                    <input type="text" name="pincode" class="form-control pincode" required>
                </div>
                <!-- <label for="voucher_mode" class="col-sm-2 col-form-label">Acc Head</label>
                <div class="col-sm-4">
                    <select class="form-control select2" id="acchead" name="acchead">
                        <option value=''>Select</option>
                        <?php // foreach ($bank as $bnk) { ?>
                        <option value='<?php // echo $bnk->sl_no; ?>'><?php //echo $bnk->ac_name; ?></option>
                        <?php //} ?>
                    </select>
                </div> -->
            </div>



            <div class="form-group row">

                <label for="trans_dt" class="col-sm-2 col-form-label">Email:</label>

                <div class="col-sm-4">

                    <input type="email" name="email" class="form-control smallinput_text">

                </div>

                <label for="voucher_mode" class="col-sm-2 col-form-label">Gst Number:</label>

                <div class="col-sm-4">

                    <input type="text" name="gstNumber" class="form-control smallinput_text" required>

                </div>

            </div>


            <div class="form-group row">

                <label for="trans_dt" class="col-sm-2 col-form-label">FMS ID:</label>

                <div class="col-sm-4">

                    <input type="text" name="fmsid" class="form-control smallinput_text">

                </div>

                <label for="voucher_mode" class="col-sm-2 col-form-label">PAN Number:</label>

                <div class="col-sm-4">

                    <input type="text" name="panNo" class="form-control smallinput_text">

                </div>

            </div>

            <div class="form-group row">

                <label for="trans_dt" class="col-sm-2 col-form-label">District:</label>

                <div class="col-sm-4">

                    <select class="form-control" id="ac_type" name="district" required>
                        <option value=''>Select</option>
                        <?php foreach ($district as $dist) { ?>
                        <option value="<?php echo $dist->district_code; ?>"><?php echo $dist->district_name; ?></option>
                        <?php } ?>





                    </select>

                </div>
                <label for="gst_rt" class="col-sm-2 col-form-label">Gst Rate:</label>
                <div class="col-sm-4">

                <input type="text" name="gst_rt" class="form-control smallinput_text">

                </div>

            </div>
            <div class="form-group row">

                <label for="trans_dt" class="col-sm-2 col-form-label">Contact Person:</label>

                <div class="col-sm-4">

                    <input type="text" name="contactPerson" class="form-control smallinput_text">

                </div>

                <label for="voucher_mode" class="col-sm-2 col-form-label">Contact Number:</label>

                <div class="col-sm-4">

                    <input type="text" name="contactNumber" class="form-control smallinput_text">

                </div>

            </div>

            <div class="form-group row" id="bank_section">
                <label for="voucher_mode" class="col-sm-2 col-form-label">Debit A/c Head:</label>
                <div class="col-sm-10">
                    <select class="form-control select2" id="drBank" name="acchead">
                        <option value=''>Select bank</option>
                        <?php foreach ($bank as $bnk) { ?>
                        <option value='<?php echo $bnk->sl_no; ?>'><?php echo $bnk->ac_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>


            <div class="form-group row">

                <div class="col-sm-10">

                    <input type="submit" class="btn btn-info" value="Save" />

                </div>

            </div>

        </form>

    </div>

</div>

<script>
    $(".select_2").select2();
    // $("#sch_cd").select2();
</script>