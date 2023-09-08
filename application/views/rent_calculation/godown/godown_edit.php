
<div class="wraper">      

<div class="col-md-8 container form-wraper">

    
    <form method="POST" action="<?php echo site_url("godown/edit/".$editData[0]['id']);?> "onsubmit="return valid_data()" >

        <div class="form-header">
            
            <h4>Edit Godown</h4>
        
        </div>

     

        <div class="form-group row">

            <label for="ac_type" class="col-sm-2 col-form-label">Godown Name:</label>

            <div class="col-sm-10">

                <input type="text" class="form-control" id="gr_name" name="godown_Name" value="<?php if(!empty($editData[0]['gdn_name'])){echo $editData[0]['gdn_name'];} ?>" required/>

            </div>

        </div>

        <div class="form-group row">

                <label for="remarks" class="col-sm-2 col-form-label">Godown Address:</label>

                <div class="col-sm-10">

                    <textarea class="form-control" name="godown_Address"required><?php if(!empty($editData[0]['gdn_addr'])){echo $editData[0]['gdn_addr'];} ?></textarea>

                </div>

            </div>

        <div class="form-group row">

                <label for="trans_dt" class="col-sm-2 col-form-label">District:</label>

                <div class="col-sm-4">

                <select class="form-control" id="ac_type" name="district" required>
                <option value=''>Select</option>
                    <?php foreach ($district as $dist) { ?>
						<option value="<?php echo $dist->district_code; ?>" <?php if(!empty($editData[0]['gdn_dist'])){ if($editData[0]['gdn_dist']==$dist->district_code){echo "selected";}} ?>><?php echo $dist->district_name; ?></option>
                       <?php } ?>
						



                        
					</select>

                </div>

                <label for="voucher_mode" class="col-sm-2 col-form-label" >SAC Code:</label>

                <div class="col-sm-4">

                    <input type="text" name="sac_Code" class="form-control smallinput_text" value="<?php if(!empty($editData[0]['sac_code'])){echo $editData[0]['sac_code'];} ?>" required>

                </div>

            </div>
            <div class="form-group row">

<label for="trans_dt" class="col-sm-2 col-form-label">Contact Person:</label>

<div class="col-sm-4">

                    <input type="text" name="contactPerson" class="form-control smallinput_text" value="<?php if(!empty($editData[0]['cnct_person'])){echo $editData[0]['cnct_person'];} ?>">

</div>

<label for="voucher_mode" class="col-sm-2 col-form-label">Contact Number:</label>

<div class="col-sm-4">

    <input type="text" name="contactNumber" class="form-control smallinput_text" value="<?php if(!empty($editData[0]['cnct_no'])){echo $editData[0]['cnct_no'];} ?>">

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

    $( "#sch_cd" ).select2();

</script>
