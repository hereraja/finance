<div class="wraper">

    <div class="col-md-8 container form-wraper">


        <form method="POST" action="<?php echo site_url("customer/edit/".$editData[0]['id']);?> "
            onsubmit="return valid_data()">

            <div class="form-header">

                <h4>Edite Rent Customer</h4>

            </div>



            <div class="form-group row">

                <label for="ac_type" class="col-sm-2 col-form-label">Customer Name:</label>

                <div class="col-sm-10">

                    <input type="text" class="form-control" id="gr_name" name="customerName"
                        value="<?php if(!empty($editData[0]['cust_name'])){ echo $editData[0]['cust_name'];} ?>"
                        required />

                </div>

            </div>

            <div class="form-group row">

                <label for="remarks" class="col-sm-2 col-form-label">Customer Address:</label>

                <div class="col-sm-10">

                    <textarea class="form-control" name="customerAddress"
                        required><?php if(!empty($editData[0]['cust_addr'])){ echo $editData[0]['cust_addr'];} ?></textarea>

                </div>

            </div>

            <div class="form-group row">
                <label for="trans_dt" class="col-sm-2 col-form-label">PIN Code:</label>
                <div class="col-sm-4">
                    <input type="text" name="pincode" class="form-control pincode" value="<?php if(!empty($editData[0]['pin_code'])){ echo $editData[0]['pin_code'];} ?>" required>
                </div>

            </div>



            <div class="form-group row">

                <label for="trans_dt" class="col-sm-2 col-form-label">Email:</label>

                <div class="col-sm-4">

                    <input type="email" name="email" class="form-control smallinput_text"
                        value="<?php if(!empty($editData[0]['email_id'])){ echo $editData[0]['email_id'];} ?>">

                </div>

                <label for="voucher_mode" class="col-sm-2 col-form-label">Gst Number:</label>

                <div class="col-sm-4">

                    <input type="text" name="gstNumber" class="form-control smallinput_text"
                        value="<?php if(!empty($editData[0]['gst_no'])){ echo $editData[0]['gst_no'];} ?>" required>

                </div>

            </div>


            <div class="form-group row">

                <label for="trans_dt" class="col-sm-2 col-form-label">FMS ID:</label>

                <div class="col-sm-4">

                    <input type="text" name="fmsid" class="form-control smallinput_text"
                        value="<?php if(!empty($editData[0]['fms_id'])){ echo $editData[0]['fms_id'];} ?>">

                </div>

                <label for="voucher_mode" class="col-sm-2 col-form-label">PAN Number:</label>

                <div class="col-sm-4">

                    <input type="text" name="panNo" class="form-control smallinput_text"
                        value="<?php if(!empty($editData[0]['pan_no'])){ echo $editData[0]['pan_no'];} ?>">

                </div>

            </div>

            <div class="form-group row">

                <label for="trans_dt" class="col-sm-2 col-form-label">District:</label>

                <div class="col-sm-4">

                    <select class="form-control" id="ac_type" name="district" required>
                        <option value=''>Select</option>
                        <?php foreach ($district as $dist) { ?>
                        <option value="<?php echo $dist->district_code; ?>"
                            <?php if(!empty($editData[0]['cust_dist'])){ if($editData[0]['cust_dist']==$dist->district_code){ echo "selected";}} ?>>
                            <?php echo $dist->district_name; ?></option>
                        <?php } ?>





                    </select>

                </div>

                <label for="gst_rt" class="col-sm-2 col-form-label">Gst Rate:</label>
                <div class="col-sm-4">

                <input type="text" name="gst_rt" class="form-control smallinput_text"
                value="<?php if(!empty($editData[0]['gst_rt'])){ echo $editData[0]['gst_rt'];} ?>">

                </div>

            </div>
            <div class="form-group row">

                <label for="trans_dt" class="col-sm-2 col-form-label">Contact Person:</label>

                <div class="col-sm-4">

                    <input type="text" name="contactPerson"
                        value="<?php if(!empty($editData[0]['cnct_person'])){ echo $editData[0]['cnct_person'];} ?>"
                        class="form-control smallinput_text">

                </div>

                <label for="voucher_mode" class="col-sm-2 col-form-label">Contact Number:</label>

                <div class="col-sm-4">

                    <input type="text" name="contactNumber"
                        value="<?php if(!empty($editData[0]['cnct_no'])){ echo $editData[0]['cnct_no'];} ?>"
                        class="form-control smallinput_text">

                </div>

            </div>

            <div class="form-group row" id="bank_section">
                <label for="voucher_mode" class="col-sm-2 col-form-label">Debit A/c Head:</label>
                <div class="col-sm-10">
                    <select class="form-control select2" id="drBank" name="acchead">
                        <option value=''>Select bank</option>
                        <?php foreach ($bank as $bnk) { ?>
                        <option value='<?php echo $bnk->sl_no; ?>'<?php if($bnk->sl_no==$editData[0]['acchead']){echo "selected";} ?>><?php echo $bnk->ac_name; ?></option>
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
    $(".select2").select2();
</script>