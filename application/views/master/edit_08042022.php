    <div class="wraper">      
         <!-- <div class="col-md-3 container"></div> -->
        <div class="col-md-6 container form-wraper">

            <form method="POST" id="form" action="<?php echo site_url("master/group_edit");?>" >
                     <input type="hidden" name="sl_no" class="form-control"  
                            value = "<?php echo $schdtls->sl_no; ?>" 
                        />
                <div class="form-header">
                
                    <h4>Edit Group</h4>
                
                </div>

                <div class="form-group row">
                  <label for="ac_type" id="ac_type" class="col-sm-3 col-form-label">Type:</label>

                    <div class="col-sm-9">

                        <select class="form-control required" id="ac_type" name="ac_type" required>

                            <option value="1" <?php echo ($schdtls->type == '1')? 'selected' : '';?>>Liabilities</option>

                            <option value="2" <?php echo ($schdtls->type == '2')? 'selected' : '';?>>Asset</option>

                            <option value="3" <?php echo ($schdtls->type == '3')? 'selected' : '';?>>Revenue</option>
                            <option value="4" <?php echo ($schdtls->type == '4')? 'selected' : '';?>>Expense</option>
                            
                        </select>

                    </div>
                
            </div>

              
            

                <div class="form-group row">

                    <label for="name" class="col-sm-3 col-form-label">Name:</label>

                    <div class="col-sm-9">
                        <!-- <textarea name="cate_desc" class="form-control" required=""><?php echo $schdtls->cate_desc; ?></textarea> -->
                        <input type="text" name="gr_name" class="form-control required"  
                            value = "<?php echo $schdtls->name; ?>" 
                        />
		            </div>

		        </div>


                <div class="form-group row">

                    <div class="col-sm-10">

                        <input type="submit" class="btn btn-info" value="Save" />

                    </div>

                </div>
 
            </form>

        </div>

    <!-- </div> -->