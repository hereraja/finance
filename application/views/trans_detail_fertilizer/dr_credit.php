<div class="wraper">      
            <div class="col-md-2 container"></div>
			<div class="col-md-8 container form-wraper">
	
					<div class="form-header">
					
						<h4>Credit Note</h4>
					
					</div>
					<?php if($dr_dtls){ ?>				
                    <div class="form-group row">

                      <label for="ro_no" class="col-sm-2 col-form-label">Society:</label>
						<div class="col-sm-4">

                           <select name="soc_id" id="soc_id" class="form-control  soc_id" required>
                                <option value="">Select Society</option>
                                <?php
                                //  echo $dr_dtls->soc_id;
                                //  die();
                                    foreach($socdtls as $key2)
                                    { 
                                //   echo  $key1->soc_id();
                                //   die();
                                ?>
                             
                                    <option value="<?php echo  $this->input->get('soc_id'); ?>"<?php echo( $this->input->get('soc_id')==$key2->soc_id)?'selected':'';?>><?php echo $key2->soc_name; ?></option>

                                <?php 
                                    } 
                                ?>
                            </select> 
	              
	                    </div>

                        <label for="ro_no" class="col-sm-2 col-form-label">Company:</label>

                       <div class="col-sm-4">
    
                            <select name="comp_id" id="comp_id" class="form-control comp_id" required>
                              <option value="">Select Company</option>
                            <?php
                                foreach($compdtls as $row)
                            { ?>
                            
                                <option value="<?php echo $row->comp_id; ?>"<?php echo($dr_dtls->comp_id==$row->comp_id)?'selected':'';?>><?php echo $row->comp_name; ?></option>
                            <?php
                            } ?>
                            </select> 
                       </div>


                    </div>

                    <div class="form-group row">

				<label for="inv_no" class="col-sm-2 col-form-label">Invoice No:</label>

				<div class="col-sm-4">
				<input type="text" id="inv_no" name="trans_dt" class="form-control" value="<?php echo $dr_dtls->invoice_no; ?>" readonly />
				</div>

				<label for="ro_no" class="col-sm-2 col-form-label">Ro_no:</label>

				<div class="col-sm-4">
				<input type="text" id="ro_no" name="ro_no" class="form-control" value="<?php echo $dr_dtls->ro; ?>" readonly />
				</div>


				</div>
				<div class="form-group row">
				<label for="cat_id" class="col-sm-2 col-form-label">Type:</label>

				<div class="col-sm-4">
				<input type="text" id="cat_id" name="cat_id" class="form-control" value="<?php echo $dr_dtls->cat_desc; ?>" readonly />
				</div>


</div>
<!-- </div> -->

                    <div class="form-group row">

                        <label for="trans_dt" class="col-sm-2 col-form-label">Credit Note Date:</label>

						<div class="col-sm-4">
						<input type="date" id="trans_dt" name="trans_dt" class="form-control" value="<?php echo $dr_dtls->trans_dt; ?>" readonly />
	                    </div>

                        <label for="dr_amt" class="col-sm-2 col-form-label">Amount:</label>

                        <div class="col-sm-4">
                        <input type="text" id="tot_amt" name="tot_amt" class="form-control" value="<?php echo $dr_dtls->tot_amt; ?>" required />
                        </div>


                    </div>


                       <div class="form-group row">

                        <label for="dr_amt" class="col-sm-2 col-form-label">Remarks:</label>

                        <div class="col-sm-10">
                          <textarea id="remarks" name="remarks" class="form-control" readonly><?php echo $dr_dtls->remarks; ?></textarea >
                       
                        </div>

                        <input type="hidden" id="trans_no" name="trans_no" class="form-control" value="<?php echo $dr_dtls->trans_no; ?>" />

                    </div>
						
            <?php }else {?>
              <h1> No data Found</h1>
			<?php } ?>

        </div>

    </div>

</div>