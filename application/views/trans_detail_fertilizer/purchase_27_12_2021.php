<div class="wraper">      

    <div class="col-md-11 container form-wraper">


            <div class="form-header">
                
            	<h4>RO detail</h4>
                <span id="msg" style="color:#bd2130"></span>
            </div>
            <?php if($stock) {?>
            <div class="form-group row">

				<label for="comp_id" class="col-sm-1 col-form-label">Company:</label>

					<div class="col-sm-3">

						<input type="hidden" style="width:200px"  name="comp_id" class="form-control required"  
        					value = "<?php echo $stock->comp_id; ?>" readonly 
						/>

        				<input type="text" style="width:200px"  name="comp_desc" class="form-control required"  
        					value = "<?php echo $stock->COMP_NAME; ?>" readonly 
						/>

					</div>

				<label for="gst_no" class="col-sm-1 col-form-label">GSTIN:</label>

					<div class="col-sm-3">

                    	<input type="text" style="width:200px"  name="gst_no" class="form-control required"  
        					value = "<?php echo $stock->GST_NO; ?>" readonly 
						/>

					</div>

                <label for="cin" class="col-sm-1 col-form-label">CIN:</label>
					
					<div class="col-sm-3">

						<input type="text" style="width:150px" id=cin name="cin"class="form-control required"  
        					value = "<?php echo $stock->CIN; ?>" readonly 
						/>

					</div>
			</div>

			<div class="form-group row">

				<label for="comp_add" class="col-sm-1 col-form-label">Address:</label>
					
					<div class="col-sm-4">

						<textarea style="width:580px;height:70px"  id=comp_add name="comp_add" class="form-control required"readonly><?php echo $stock->COMP_ADD; ?>
						</textarea>

					</div>
				
            </div>

			<div class="form-header">
                
  				<h4>Product Details</h4>
            
			</div>

			<div class="form-group row">

				<label for="prod_id" class="col-sm-1 col-form-label">Product:</label>

					<div class="col-sm-3">

						 <input type="hidden" style="width:200px"  name="prod_id" class="form-control required"  
        					value = "<?php echo $stock->PROD_ID; ?>" readonly />

        				<input type="text" style="width:200px"  name="prod_desc" class="form-control required"  
        					value = "<?php echo $stock->PROD_DESC; ?>" readonly 
						/>


					</div>

				<label for="hsn_code" class="col-sm-1 col-form-label">HSN:</label>
					
					<div class="col-sm-3">

                    	<input type="text" style="width:200px"  name="hsn_code" class="form-control required"  
        					value = "<?php echo $stock->HSN_CODE; ?>" readonly 
						/>

					</div>
                    
				<label for="gst_rt" class="col-sm-1 col-form-label">GST RT:</label>
					
					<div class="col-sm-3">
	
						<input type="text" style="width:150px" id=gst_rt name="gst_rt" class="form-control" 
							value = "<?php echo $stock->GST_RT; ?>" readonly 
						/>
	
					</div>
			</div>

			<div class="form-group row">
				
				<label for="stkpnt_id" class="col-sm-1 col-form-label">Stock Point:</label>

					<div class="col-sm-3">
						
						<select name="stkpnt_id" style="width:200px" class="form-control sch_cd required" id="stkpnt_id" required>

							<option value="">Select</option>

								<?php

									foreach($stockpoint as $stkpnt){

								?>
									<option value="<?php echo $stkpnt->soc_id;?>"<?php if($stock->stock_point==$stkpnt->soc_id) {echo "selected"; }?>><?php echo $stkpnt->soc_name;?></option>
									
								<?php

									}

								?>     

						</select>

					</div>
					<?php

									foreach($sale as $sl){

								?>
					<input type="hidden" style="width:200px"  name="sale_cnt" id="sale_cnt" class="form-control required"  
							value = "<?php echo $sl->sale_cnt; ?>"  
						/>
						<?php

									}

								?>   
					
			</div>

            <div class="form-header">
                                
                <h4>Stock Details</h4>
                            
            </div>

            <div class="form-group row">

                <label for="ro_no" class="col-sm-1 col-form-label">RO/DO No::</label>

					<div class="col-sm-3">

						<input type="text" style="width:200px"  name="ro_no" class="form-control required"  
							value = "<?php echo $stock->ro_no; ?>"  readonly
						/>
							
						<input type="hidden" style="width:200px"  name="challan_flag" id="challan_flag" class="form-control required"  
							value = "<?php echo $stock->challan_flag; ?>"  
						/>
						
						
					</div>

                <label for="ro_dt" class="col-sm-1 col-form-label">Ro Date:</label>

                	<div class="col-sm-3">
                
						<input type="date" style="width:200px"  name="ro_dt" class="form-control required"  
                        	value = "<?php echo $stock->ro_dt; ?>"  
						/>

                	</div>
					<label for="no_of_days" class="col-sm-1 col-form-label">No Of Days:</label>
					<div class="col-sm-3">
					<input type="text" style="width:80px" id=no_of_days name="no_of_days" class="form-control" value="<?php echo $stock->no_of_days; ?>" required />
					</div>
				
                
			</div>

            <div class="form-group row">
			<label for="due_dt" class="col-sm-1 col-form-label">Due Date:</label>
                
				<div class="col-sm-3">
			
					<input type="date" style="width:150px"  name="due_dt" class="form-control required"  
						value = "<?php echo $stock->due_dt; ?>"  
					/>
				</div>
                <label for="delivery_mode" class="col-sm-1 col-form-label">Delivery Mode:</label>

					<div class="col-sm-3">
  
    					<select  class="form-control" style="width:200px;" name="delivery_mode" id="delivery_mode" >
                    
                    		<option value="">Select</option>

                    <option value="1" <?php echo ($stock->delivery_mode == 1)? 'selected' : '';?> >EX GODOWN</option>
						<option value="2" <?php echo ($stock->delivery_mode == 2)? 'selected' : '';?>>EX RAIL </option>
						<option value="3" <?php echo ($stock->delivery_mode == 3)? 'selected' : '';?> >BUFFER </option>
						<option value="4" <?php echo ($stock->delivery_mode == 4)? 'selected' : '';?> >NON BUFFER</option>
						<option value="5" <?php echo ($stock->delivery_mode == 5)? 'selected' : '';?>>FOR-FOL</option>
                		</select>  
					
					</div>

				<label for="invoice_no" class="col-sm-1 col-form-label">Invoice No:</label>

					<div class="col-sm-3">

 						<input type="text" style="width:200px"  name="invoice_no" class="form-control required"  
          					value = "<?php echo $stock->invoice_no; ?>"  
						/>
					</div>
                
			</div>

			<div class="form-group row">
			<label for="invoice_dt" class="col-sm-1 col-form-label">Invoice Date:</label>

					<div class="col-sm-3">

						<input type="date" style="width:150px"   name="invoice_dt" class="form-control required"  
							value = "<?php echo $stock->invoice_dt; ?>"   
						/>

					</div>

				<label for="qty" class="col-sm-1 col-form-label">Qty:</label>

					<div class="col-sm-3">

 						<input type="text" style="width:200px"  name="qty" id="qty" class="form-control required"  
          					value = "<?php echo $stock->qty; ?>"  
						/>

					</div>
					<label for="unit" class="col-sm-1 col-form-label">Unit:</label>

					<div class="col-sm-3">

							<input type="text" style="width:200px"  name="unit_name" class="form-control required" 
							value = "<?php echo $stock->unit_name; ?>"   
							readonly		
							/>
							<input type="hidden" style="width:200px"  name="unit_id" class="form-control required" 
							value = "<?php echo $stock->unit; ?>"   
							readonly		
							/>
					</div>
			</div>

			<div class="form-group row">

			

				<label for="no_of_bags" class="col-sm-1 col-form-label">No.of Storage Unit:</label>

  					<div class="col-sm-3">

						<input type="text" style="width:150px"   name="no_of_bags" class="form-control required"  
							value = "<?php echo $stock->no_of_bags; ?>"  readonly 
						/>

					</div>

					 <label for="trans_dt" class="col-sm-1 col-form-label">Purchase Date:</label>
					<div class="col-sm-3">

					<input type="date" style="width:150px" id="trans_dt" name="trans_dt" class="form-control" 
					value = "<?php echo $stock->trans_dt; ?>"  />
					</div> 
					 
			</div>


 
<div class="form-group row">
					<!-- <label for="reck_pt_rt" class="col-sm-1 col-form-label">Reck Pt Entry Rate:</label>
					<div class="col-sm-3">

						<input type="text" style="width:180px" id="reck_pt_rt" name="reck_pt_rt" class="form-control" 
						value = "<?php echo $stock->reck_pt_rt; ?>" />

					</div> -->
					<!-- <label for="reck_pt_n_rt" class="col-sm-1 col-form-label">Non Reck Pt Entry Rate:</label>
					<div class="col-sm-3">

					<input type="text" style="width:150px" id="reck_pt_n_rt" name="reck_pt_n_rt" class="form-control" 
					value = "<?php echo $stock->reck_pt_n_rt; ?>"  />
					</div>  -->

					<!-- <label for="trans_dt" class="col-sm-1 col-form-label">Purchase Date:</label>
					<div class="col-sm-3">

					<input type="date" style="width:150px" id="trans_dt" name="trans_dt" class="form-control" 
					value = "<?php echo $stock->trans_dt; ?>"  />
					</div>  -->
				</div>
<!-- 
				<div class="form-group row">
					<label for="iffco_buf_rt" class="col-sm-1 col-form-label">IFFCO Buffer Rate:</label>
					<div class="col-sm-3">

						<input type="text" style="width:180px" id="iffco_buf_rt" name="iffco_buf_rt" class="form-control"
						value = "<?php echo $stock->iffco_buf_rt; ?>"  />

					</div>
					<label for="iffco_n_buff_rt" class="col-sm-1 col-form-label">IFFCO Non Buffer Rate:</label>
					<div class="col-sm-3">

						<input type="text" style="width:150px" id="iffco_n_buff_rt" name="iffco_n_buff_rt" class="form-control"
						value = "<?php echo $stock->iffco_n_buff_rt; ?>" />

					</div>
				</div> -->
<div class="form-header">
                
                <h4>Price Details</h4>
            
            </div>	
           <div class="form-group row">
            
						<label for="rate" class="col-sm-1 col-form-label">Purchase Rate/Unit:</label>
						<div class="col-sm-3">
	
							<input type="text" style="width:150px" id="rate" name="rate" class="form-control required" 
                            value = "<?php echo $stock->rate; ?>"  readonly   />
			
						</div>
						
						<label for="base_price" class="col-sm-1 col-form-label">Base Price:</label>
						<div class="col-sm-3">
	
							<input type="text" style="width:150px" id="base_price" name="base_price" class="form-control" 
                            value = "<?php echo $stock->base_price; ?>"   readonly />
						   
						</div>
						<label for="net_amt" class="col-sm-1 col-form-label">Taxable Amt:</label>
						<div class="col-sm-3">
	
							<input type="text" style="width:150px" id="net_amt" name="net_amt" class="form-control" 
                            value = "<?php echo $stock->net_amt; ?>" readonly />
						   
						</div>
                        </div>
                        <div class="form-group row">
					<label for="retlr_margin" class="col-sm-1 col-form-label">Add Retailer margin:</label>
						<div class="col-sm-2">
	
						<input type="text" style="width:150px" id="retlr_margin" name="retlr_margin" class="form-control"  
                        value = "<?php echo $stock->retlr_margin; ?>" readonly />
						</div> 
						<div class="col-sm-1">
					<label for="add_ret_margin_flag" style="color:green;">GST</label>
					<input type="checkbox" id="add_ret_margin_flag" name="add_ret_margin_flag" value = "Y" class="checkbox_check"
					disabled
					
					<?php 
				   
					   if ($stock->add_ret_margin_flag=='Y'){
						   echo "checked";
						   }
					   
					   
					   ?>
					   >
				   
                    
					</div>
						<label for="spl_rebt" class="col-sm-1 col-form-label">Less Special Rebate:</label>
						<div class="col-sm-2">
	
							<input type="text" style="width:150px" id="spl_rebt" name="spl_rebt" class="form-control" 
                            value = "<?php echo $stock->spl_rebt; ?>" readonly  />
						   
						</div>
						<div class="col-sm-2">
					<label for="less_spl_rbt_flag" style="color:green;">GST</label>
					<input type="checkbox" id="less_spl_rbt_flag" name="less_spl_rbt_flag" value = "Y" class="checkbox_check"
					
					disabled
					<?php 
				   
					   if ($stock->less_spl_rbt_flag=='Y'){
						   echo "checked";
						   }
					   
					   
					   ?>>
					</div>
                     </div>

                        <div class="form-group row">
					<label for="adj_amt" class="col-sm-1 col-form-label">Add Adj Amt:</label>
						<div class="col-sm-2">
	
						<input type="text" style="width:150px" id="adj_amt" name="adj_amt" class="form-control"  
                        value = "<?php echo $stock->add_adj_amt; ?>" readonly  />
						</div> 

					<div class="col-sm-1">
					<label for="add_adj_amt_flag" style="color:green;">GST</label>
					<input type="checkbox" id="add_adj_amt_flag" name="add_adj_amt_flag" value="Y"
					disabled
					 <?php 
					
						if ($stock->add_adj_amt_flag=='Y'){
							echo "checked";
							}
						
						
						?>>
					
					</div>

						 <label for="less_adj_amt" class="col-sm-1 col-form-label">Less Adj Amt:</label>
						<div class="col-sm-2">
	
							<input type="text" style="width:150px" id="less_amt" name="less_adj_amt" class="form-control" 
                            value = "<?php echo $stock->less_adj_amt; ?>" readonly  />
						   
						</div> 
						<div class="col-sm-1">
					<label for="less_adj_amt_flag" style="color:green;">GST</label>
					<input type="checkbox" id="less_adj_amt_flag" name="less_adj_amt_flag"  value = "Y" class="checkbox_check"
					disabled
					
					<?php 
				   
					   if ($stock->less_adj_amt_flag=='Y'){
						   echo "checked";
						   }
					   
					   
					   ?>>
					</div>
					  </div>

					  <div class="form-group row">
					  <label for="trd_mgr" class="col-sm-1 col-form-label">Less Trade margin:</label>
						<div class="col-sm-2">
	
							<input type="text" style="width:150px" id=trd_mgr name="trd_mgr" class="form-control" value="<?php echo $stock->trad_margin; ?>" readonly  />
						   
						</div>
						<div class="col-sm-1">
						<label for="less_trad_margin_flag" style="color:green;">GST</label>
						<input type="checkbox" id="less_trad_margin_flag" name="less_trad_margin_flag" value = "Y" class="checkbox_check"
				          disabled
					
					<?php 
				   
					   if ($stock->less_trad_margin_flag=='Y'){
						   echo "checked";
						   }
					   
					   
					   ?>>
						</div>
					  <label for="les_oth_dis" class="col-sm-1 col-form-label">Less Oth discount:</label>
						<div class="col-sm-2">
	
							<input type="text" style="width:150px" id=les_oth_dis name="les_oth_dis" class="form-control" value="<?php echo $stock->oth_dis; ?>" readonly />
						   
						</div>
					<div class="col-sm-1">
					<label for="less_oth_dis_flag" style="color:green;">GST</label>
					<input type="checkbox" id="less_oth_dis_flag" name="less_oth_dis_flag" value = "Y" class="checkbox_check"
				disabled
					
					<?php 
				   
					   if ($stock->less_oth_dis_flag=='Y'){
						   echo "checked";
						   }
					   
					   
					   ?>>
					</div>
						<label for="frt_subsidy" class="col-sm-1 col-form-label">Less Freight Subsidy:</label>
						<div class="col-sm-2">
	
						<input type="frt_subsidy" style="width:120px" id=frt_subsidy name="frt_subsidy" class="form-control" value="<?php echo $stock->frt_subsidy; ?>" readonly />
						   
						</div>
						<div class="col-sm-1">
						<label for="less_frght_subsdy_flag" style="color:green;">GST</label>
						<input type="checkbox" id="less_frght_subsdy_flag" name="less_frght_subsdy_flag"value = "Y" class="checkbox_check"
					
					disabled
					<?php 
				   
					   if ($stock->less_frght_subsdy_flag=='Y'){
						   echo "checked";
						   }
					   
					   
					   ?>>
						</div>
						</div>
                      <div class="form-group row">
					<label for="cgst" class="col-sm-1 col-form-label">CGST:</label>
						<div class="col-sm-3">
	
						<input type="text" style="width:150px" id=cgst name="cgst" class="form-control" 
                        value = "<?php echo $stock->cgst; ?>" readonly  />
						</div> 
	
						<label for="sgst" class="col-sm-1 col-form-label">SGST:</label>
						<div class="col-sm-3">
	
							<input type="text" style="width:150px" id=sgst name="sgst" class="form-control" 
                            value = "<?php echo $stock->sgst; ?>"  readonly  />
						   
						</div>
						
					  </div>
                      <div class="form-group row">
					<label for="rbt_add" class="col-sm-1 col-form-label">Rebate Add:</label>
						<div class="col-sm-3">
	
						<input type="text" style="width:150px" id="rbt_add" name="rbt_add" class="form-control" 
                        value = "<?php echo $stock->rbt_add; ?>"    />
						</div> 
	
						<label for="rbt_less" class="col-sm-1 col-form-label">Rebate Less:</label>
						<div class="col-sm-3">
	
						<input type="text" style="width:150px" id="rbt_less" name="rbt_less" class="form-control" 
                        value = "<?php echo $stock->rbt_less; ?>"    />
						</div> 
						<label for="tot_pur_rt" class="col-sm-1 col-form-label" style="color:Blue;">Net Rate/Unit:</label>
						<div class="col-sm-3">
	
						<input type="text" style="width:150px" id=tot_pur_rt name="tot_pur_rt" class="form-control"
						 value= "<?php echo number_format($stock->tot_amt/$stock->qty,3); ?>" readonly  />
						</div> 
						</div>
                        <div class="form-group row">
					<label for="rnd_of_add" class="col-sm-1 col-form-label">Round Off Add:</label>
						<div class="col-sm-3">
	
						<input type="text" style="width:150px" id="rnd_of_add" name="rnd_of_add" class="form-control" 
                        value = "<?php echo $stock->rnd_of_add; ?>"    />
						</div> 
	
						<label for="rnd_of_less" class="col-sm-1 col-form-label">Round Off Less:</label>
						<div class="col-sm-3">
	
						<input type="text" style="width:150px" id="rnd_of_less" name="rnd_of_less" class="form-control"
                        value = "<?php echo $stock->rnd_of_less; ?>"     />
						</div> 
						<label for="tot_amt" class="col-sm-1 col-form-label">Total Amt:</label>
						<div class="col-sm-2">
	
							<input type="text" style="width:150px" id=tot_amt name="tot_amt" class="form-control" 
                            value = "<?php echo $stock->tot_amt; ?>"  readonly />
						   
						</div>
						</div>
			<?php } else {?>
					
				<div class="form-group row">

					<label for="comp_add" class="col-sm-1 col-form-label"></label>
						
						<div class="col-sm-4"> <h1>No Record Found</h1> </div>
					
				</div>
			
			<?php } ?>
				
 
           
        </div>

    </div>


    <script>

    	 $(".sch_cd").select2();   // Code For Select Write Option
	
	$(document).ready(function(){
	
		var i = 2;
		var tot_qty  =0.00;
		var base_price =0.00;
		var gst_rt =0.00;
		var gst=0.00;
		var tot_amt= 0.00;
		var rbt_add= 0.00;
		var rbt_less= 0.00;
		var rnd_of_add= 0.00;
		var rnd_of_less= 0.00;
		var add_adj_amt =0.00;
		var less_adj_amt=0.00;
		$('#rate').change(function(){
	
			$.get( 
	
				'<?php echo site_url("stock/f_get_ro");?>',
				{ 
	
					rate: $(this).val()
					
				}
	
			)
			.done(function(data){
	
				//console.log(data);
				var parseData = JSON.parse(data);
				tot_qty=$('#qty').val() 
				gst_rt =$('#gst_rt').val() 
				base_price =tot_qty * $('#rate').val() 
				taxable_amt =base_price
				gst=(taxable_amt * gst_rt/100)/2
				tot_amt=parseFloat(taxable_amt) + parseFloat(gst)*2
				//console.log(parseData);
				//  console.log(parseData[0].qty);
				// console.log(parseData[0].allot_qty_qnt);
				console.log(qty);
				$('#base_price').val(base_price);
				$('#net_amt').val(taxable_amt);
				$('#tot_amt').val(tot_amt);
				$('#retlr_margin').val(0);
				$('#spl_rebt').val(0);
				$('#cgst').val(gst);
				$('#sgst').val(gst);
				$('#rbt_add').val(0);
				$('#rbt_less').val(0);
				$('#rnd_of_add').val(0);
				$('#rnd_of_less').val(0);
				$('#adj_amt').val(0);
				$('#less_amt').val(0);
			});
	
		});
	
	});
	
	</script>
<script>
	
	$(document).ready(function(){
	
		var i           = 2;
		var tot_qty     = 0.00;
		var base_price  = 0.00;
		var gst_rt      = 0.00;
		var gst         = 0.00;
		var spl_rebt    = 0.00;
		var retlr_margin= 0.00;
		var tot_amt     = 0.00;
	
		var rbt_add     = 0.00;
		var rbt_less    = 0.00;
		var rnd_of_add  = 0.00;
		var rnd_of_less = 0.00;
		var add_adj_amt = 0.00;
		var less_adj_amt= 0.00;
        var net_rt      = 0.00;
		$('#retlr_margin').change(function(){
			let row = $(this).closest('tr');
			$.get( 
	
				'<?php echo site_url("stock/f_get_ro");?>',
				{ 
	
					rate: $(this).val()
					
				}
	
			)
			.done(function(data){
	
				//console.log(data);
				var parseData = JSON.parse(data);
				tot_qty=$('#qty').val() 
				gst_rt =$('#gst_rt').val() 
				base_price =tot_qty * $('#rate').val()
				base_price=parseFloat(base_price).toFixed(2)
				
				retlr_margin = $('#retlr_margin').val() 
				spl_rebt  = $('#spl_rebt').val() 
				var ckbox = $('#add_ret_margin_flag');

$('input').on('click',function () {
	if (ckbox.is(':checked')) {
		// alert('You have Checked it');
		taxable_amt= parseFloat(base_price) +  parseFloat(retlr_margin) -parseFloat(spl_rebt)
		taxable_amt =parseFloat(taxable_amt).toFixed(2)
		gst=(taxable_amt * gst_rt/100)/2
		gst=parseFloat(gst).toFixed(2)
		tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2
		tot_amt=Math.round(parseFloat(tot_amt))
		// alert(gst);
		$('#net_amt').val(taxable_amt);
		// $('#cgst').val(gst);
		$('#tot_amt').val(tot_amt);
				$('#retlr_margin').val(retlr_margin);
				$('#spl_rebt').val(spl_rebt);
				$('#cgst').val(gst);
				$('#sgst').val(gst);
				$('#rbt_add').val(0);
				$('#rbt_less').val(0);
				$('#rnd_of_add').val(0);
				$('#rnd_of_less').val(0);
				$('#adj_amt').val(0);
				$('#less_amt').val(0);
				net_rt =parseFloat(tot_amt/tot_qty).toFixed(3);
               $('#tot_pur_rt').val(net_rt);
	} else {
		// alert('You Un-Checked it');
		taxable_amt= parseFloat(base_price) + -parseFloat(spl_rebt)
		taxable_amt =parseFloat(taxable_amt).toFixed(2)
		gst=(taxable_amt * gst_rt/100)/2
		gst=parseFloat(gst).toFixed(2)
		tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2
		tot_amt=Math.round(parseFloat(tot_amt))
				$('#net_amt').val(taxable_amt);
				$('#tot_amt').val(tot_amt);
				$('#retlr_margin').val(retlr_margin);
				$('#spl_rebt').val(spl_rebt);
				$('#cgst').val(gst);
				$('#sgst').val(gst);
				$('#rbt_add').val(0);
				$('#rbt_less').val(0);
				$('#rnd_of_add').val(0);
				$('#rnd_of_less').val(0);
				$('#adj_amt').val(0);
				$('#less_amt').val(0);
				net_rt =parseFloat(tot_amt/tot_qty).toFixed(3);
                 $('#tot_pur_rt').val(net_rt);
	}
});
				
				
			});
	
		});
	
	});
</script>

<script>
	
	$(document).ready(function(){
	
		var i            = 2;
		var tot_qty      = 0.00;
		var base_price   = 0.00;
		var gst_rt       = 0.00;
		var gst          = 0.00;
		var spl_rebt     = 0.00;
		var retlr_margin = 0.00;
		var tot_amt      = 0.00;
		var rbt_add      = 0.00;
		var rbt_less     = 0.00;
		var rnd_of_add   = 0.00;
		var rnd_of_less  = 0.00;
		var add_adj_amt  = 0.00;
		var less_adj_amt = 0.00;
        var net_rt       = 0.00;
		$('#spl_rebt').change(function(){
	
			$.get( 
	
				'<?php echo site_url("stock/f_get_ro");?>',
				{ 
	
					rate: $(this).val()
					
				}
	
			)
			.done(function(data){
	
				     //console.log(data);
				var parseData = JSON.parse(data);
				tot_qty=$('#qty').val() 
				gst_rt =$('#gst_rt').val() 
				base_price =tot_qty * $('#rate').val() 
				base_price=parseFloat(base_price).toFixed(2)
				retlr_margin = $('#retlr_margin').val() 
				spl_rebt  = $('#spl_rebt').val() 

				var ckbox2 = $('#less_spl_rbt_flag');

$('input').on('click',function () {

	if (ckbox2.is(':checked')) {
		taxable_amt= parseFloat(base_price) +  parseFloat(retlr_margin) -parseFloat(spl_rebt)
				taxable_amt =parseFloat(taxable_amt).toFixed(2)
				gst=(taxable_amt * gst_rt/100)/2
				gst=parseFloat(gst).toFixed(2)
				tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2
				tot_amt=Math.round(parseFloat(tot_amt))
				
				$('#base_price').val(base_price);
				$('#net_amt').val(taxable_amt);
				$('#tot_amt').val(tot_amt);
				$('#retlr_margin').val(retlr_margin);
				$('#spl_rebt').val(spl_rebt);
				$('#cgst').val(gst);
				$('#sgst').val(gst);
				$('#rbt_add').val(0);
				$('#rbt_less').val(0);
				$('#rnd_of_add').val(0);
				$('#rnd_of_less').val(0);
				net_rt =parseFloat(tot_amt/tot_qty).toFixed(3);
                $('#tot_pur_rt').val(net_rt);
	} else {
		        taxable_amt= parseFloat(base_price) +  parseFloat(retlr_margin)
				taxable_amt =parseFloat(taxable_amt).toFixed(2)
				gst=(taxable_amt * gst_rt/100)/2
				gst=parseFloat(gst).toFixed(2)
				tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2
				tot_amt=Math.round(parseFloat(tot_amt))
				 
				$('#base_price').val(base_price);
				$('#net_amt').val(taxable_amt);
				$('#tot_amt').val(tot_amt);
				$('#retlr_margin').val(retlr_margin);
				$('#spl_rebt').val(spl_rebt);
				$('#cgst').val(gst);
				$('#sgst').val(gst);
				$('#rbt_add').val(0);
				$('#rbt_less').val(0);
				$('#rnd_of_add').val(0);
				$('#rnd_of_less').val(0);
				net_rt =parseFloat(tot_amt/tot_qty).toFixed(3);
                $('#tot_pur_rt').val(net_rt);

	}
});
				
			});
	
		});
	
	});
</script>


<script>
	
	$(document).ready(function(){
	
		var i = 2;
		var tot_qty     = 0.00;
		var base_price  = 0.00;
		var gst_rt      = 0.00;
		var gst         = 0.00;
		var spl_rebt    = 0.00;
		var retlr_margin= 0.00;
		var tot_amt     = 0.00;
		var rbt_add     = 0.00;
		var rbt_less    = 0.00;
		var rnd_of_add  = 0.00;
		var rnd_of_less = 0.00;
		var add_adj_amt = 0.00;
		var less_adj_amt= 0.00;
		var net_rt      = 0.00;
		$('#adj_amt').change(function(){
	
			$.get( 
	
				'<?php echo site_url("stock/f_get_ro");?>',
				{ 
	
					rate: $(this).val()
					
				}
	
			)
			.done(function(data){
	
				     //console.log(data);
				var parseData = JSON.parse(data);
				tot_qty=$('#qty').val() 
				gst_rt =$('#gst_rt').val() 
				base_price =tot_qty * $('#rate').val() 
				base_price=parseFloat(base_price).toFixed(2)
				retlr_margin = $('#retlr_margin').val() 
				spl_rebt  = $('#spl_rebt').val() 
				add_adj_amt=$('#adj_amt').val() 
				less_adj_amt =$('#less_amt').val() 

				var ckbox3 = $('#add_adj_amt_flag');

$('input').on('click',function () {

	if (ckbox3.is(':checked')) {
		taxable_amt= parseFloat(base_price) +  parseFloat(retlr_margin) -parseFloat(spl_rebt)+parseFloat(add_adj_amt)-parseFloat(less_adj_amt)
				taxable_amt =parseFloat(taxable_amt).toFixed(2)
				gst=(taxable_amt * gst_rt/100)/2
				gst=parseFloat(gst).toFixed(2)
				tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2
				tot_amt=Math.round(parseFloat(tot_amt))
				
				$('#base_price').val(base_price);
				$('#net_amt').val(taxable_amt);
				$('#tot_amt').val(tot_amt);
				$('#retlr_margin').val(retlr_margin);
				$('#spl_rebt').val(spl_rebt);
				$('#cgst').val(gst);
				$('#sgst').val(gst);
				$('#rbt_add').val(0);
				$('#rbt_less').val(0);
				$('#rnd_of_add').val(0);
				$('#rnd_of_less').val(0);
				$('#adj_amt').val(add_adj_amt);
				net_rt =parseFloat(tot_amt/tot_qty);
                $('#tot_pur_rt').val(net_rt);
	} else {
		       taxable_amt= parseFloat(base_price) +  parseFloat(retlr_margin) -parseFloat(spl_rebt)-parseFloat(less_adj_amt)
				taxable_amt =parseFloat(taxable_amt).toFixed(2)
				gst=(taxable_amt * gst_rt/100)/2
				gst=parseFloat(gst).toFixed(2)
				tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2
				tot_amt=Math.round(parseFloat(tot_amt))
				
				$('#base_price').val(base_price);
				$('#net_amt').val(taxable_amt);
				$('#tot_amt').val(tot_amt);
				$('#retlr_margin').val(retlr_margin);
				$('#spl_rebt').val(spl_rebt);
				$('#cgst').val(gst);
				$('#sgst').val(gst);
				$('#rbt_add').val(0);
				$('#rbt_less').val(0);
				$('#rnd_of_add').val(0);
				$('#rnd_of_less').val(0);
				$('#adj_amt').val(add_adj_amt);
				net_rt =parseFloat(tot_amt/tot_qty).toFixed(3);
                $('#tot_pur_rt').val(net_rt);

	}
});
				
			});
	
		});
	
	});
	
</script>

<script>
	
	$(document).ready(function(){
	
		var i           = 2;
		var tot_qty     = 0.00;
		var base_price  = 0.00;
		var gst_rt      = 0.00;
		var gst         = 0.00;
		var spl_rebt    = 0.00;
		var retlr_margin= 0.00;
		var tot_amt     = 0.00;
		var rbt_add     = 0.00;
		var rbt_less    = 0.00;
		var rnd_of_add  = 0.00;
		var rnd_of_less = 0.00;
		var add_adj_amt = 0.00;
		var less_adj_amt= 0.00;
        var net_rt      = 0.00;
		$('#less_amt').change(function(){
	
			$.get( 
	
				'<?php echo site_url("stock/f_get_ro");?>',
				{ 
	
					rate: $(this).val()
					
				}
	
			)
			.done(function(data){
	
				     //console.log(data);
				var parseData = JSON.parse(data);
				tot_qty=$('#qty').val() 
				gst_rt =$('#gst_rt').val() 
				base_price =tot_qty * $('#rate').val() 
				base_price=parseFloat(base_price).toFixed(2)
				retlr_margin = $('#retlr_margin').val() 
				spl_rebt  = $('#spl_rebt').val() 
				add_adj_amt=$('#adj_amt').val() 
				less_adj_amt =$('#less_amt').val() 
				var ckbox4 = $('#less_adj_amt_flag');

$('input').on('click',function () {

	if (ckbox4.is(':checked')) {
		taxable_amt= parseFloat(base_price) +  parseFloat(retlr_margin) -parseFloat(spl_rebt)+parseFloat(add_adj_amt)-parseFloat(less_adj_amt)
				taxable_amt =parseFloat(taxable_amt).toFixed(2)
				gst=(taxable_amt * gst_rt/100)/2
				gst=parseFloat(gst).toFixed(2)
				tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2
				tot_amt=Math.round(parseFloat(tot_amt))
				
				$('#base_price').val(base_price);
				$('#net_amt').val(taxable_amt);
				$('#tot_amt').val(tot_amt);
				$('#retlr_margin').val(retlr_margin);
				$('#spl_rebt').val(spl_rebt);
				$('#cgst').val(gst);
				$('#sgst').val(gst);
				$('#add_adj_amt').val(add_adj_amt);
				$('#rbt_add').val(0);
				$('#rbt_less').val(0);
				$('#rnd_of_add').val(0);
				$('#rnd_of_less').val(0);
				$('#less_amt').val(less_adj_amt);
				net_rt =parseFloat(tot_amt/tot_qty);
                $('#tot_pur_rt').val(net_rt);
				
	} else {
		taxable_amt= parseFloat(base_price) +  parseFloat(retlr_margin) -parseFloat(spl_rebt)+parseFloat(add_adj_amt)
				taxable_amt =parseFloat(taxable_amt).toFixed(2)
				gst=(taxable_amt * gst_rt/100)/2
				gst=parseFloat(gst).toFixed(2)
				tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2
				tot_amt=Math.round(parseFloat(tot_amt))
				
				$('#base_price').val(base_price);
				$('#net_amt').val(taxable_amt);
				$('#tot_amt').val(tot_amt);
				$('#retlr_margin').val(retlr_margin);
				$('#spl_rebt').val(spl_rebt);
				$('#cgst').val(gst);
				$('#sgst').val(gst);
				$('#rbt_add').val(0);
				$('#rbt_less').val(0);
				$('#rnd_of_add').val(0);
				$('#rnd_of_less').val(0);
				$('#add_adj_amt').val(add_adj_amt);
				$('#less_amt').val(less_adj_amt);
				net_rt =parseFloat(tot_amt/tot_qty).toFixed(3);
                $('#tot_pur_rt').val(net_rt);
	}
});
				
			});
	
		});
	
	});
	
</script>

	 <script>
	
	$(document).ready(function(){
	
		var tot_qty     =0.00;
		var base_price  =0.00;
		var gst_rt      =0.00;
		var gst         =0.00;
		var spl_rebt    =0.00;
		var retlr_margin=0.00;
		var tot_amt     = 0.00;
		var rbt_add     = 0.00;
		var rbt_less    = 0.00;
		var rnd_of_add  = 0.00;
		var rnd_of_less = 0.00;
		var add_adj_amt =0.00;
		var less_adj_amt=0.00;
		var tot_amt     = 0.00;
		var net_rt      = 0.00;
		$('#rbt_add').change(function(){
	
			$.get( 
	
				'<?php echo site_url("stock/f_get_ro");?>',
				{ 
	
					rate: $(this).val()
					
				}
	
			)
			.done(function(data){
	         //console.log(data);
				var parseData = JSON.parse(data);
				tot_qty=$('#qty').val() 
				console.log('qty');
				console.log(tot_qty);
				gst_rt =$('#gst_rt').val() 
				console.log('gst_rt');
				console.log(gst_rt);
				base_price =tot_qty * $('#rate').val() 
				base_price=parseFloat(base_price).toFixed(2)
				console.log('base_price');
				console.log(base_price);
				retlr_margin = $('#retlr_margin').val() 
				console.log('retlr_margin');
				console.log(retlr_margin);
				spl_rebt  = $('#spl_rebt').val() 
				console.log('spl_rebt');
				console.log(spl_rebt);
				add_adj_amt=$('#adj_amt').val() 
				console.log('add_adj_amt');
				console.log(add_adj_amt);
				less_adj_amt =$('#less_amt').val() 
				console.log('less_adj_amt');
				console.log(less_adj_amt);
                // $('#rbt_less').val(0);
				$('#rnd_of_add').val(0);
				$('#rnd_of_less').val(0);
				taxable_amt= parseFloat(base_price) +  parseFloat(retlr_margin) - parseFloat(spl_rebt) + parseFloat(add_adj_amt)- parseFloat(less_adj_amt)
				console.log('taxable_amt');
				console.log(taxable_amt);
				taxable_amt =parseFloat(taxable_amt).toFixed(2)
				
				gst=(taxable_amt * gst_rt/100)/2
				gst=parseFloat(gst).toFixed(2)
				// tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2
			    rbt_add =$('#rbt_add').val() 
				console.log(rbt_add);
				
				tot_amt = taxable_amt + parseFloat(gst) *2
				// console.log(tot_amt);
				tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2 + parseFloat(rbt_add) - parseFloat(rbt_less)
				tot_amt=Math.round(parseFloat(tot_amt))
			
				$('#tot_amt').val(tot_amt);
				net_rt =parseFloat(tot_amt/tot_qty).toFixed(3);
                $('#tot_pur_rt').val(net_rt);
				
			});
	
		});
	
	});
</script>

<script>
	
	$(document).ready(function(){
	
		var tot_qty     = 0.00;
		var base_price  = 0.00;
		var gst_rt      = 0.00;
		var gst         = 0.00;
		var spl_rebt    = 0.00;
		var retlr_margin= 0.00;
		var tot_amt     = 0.00;
		var rbt_add     = 0.00;
		var rbt_less    = 0.00;
		var rnd_of_add  = 0.00;
		var rnd_of_less = 0.00;
		var add_adj_amt = 0.00;
		var less_adj_amt= 0.00;
		var tot_amt     = 0.00;
		var net_rt      = 0.00;
		$('#rbt_less').change(function(){
	
			$.get( 
	
				'<?php echo site_url("stock/f_get_ro");?>',
				{ 
	
					rate: $(this).val()
					
				}
	
			)
			.done(function(data){
	
				     //console.log(data);
				var parseData = JSON.parse(data);
				tot_qty=$('#qty').val() 
				gst_rt =$('#gst_rt').val() 
				base_price =tot_qty * $('#rate').val() 
				base_price=parseFloat(base_price).toFixed(2)
				retlr_margin = $('#retlr_margin').val() 
				spl_rebt  = $('#spl_rebt').val() 
				add_adj_amt=$('#adj_amt').val() 
				less_adj_amt =$('#less_amt').val() 
				rbt_add  = $('#less_amt').val() 
				// $('#rbt_add').val(0);
			
				taxable_amt= parseFloat(base_price) +  parseFloat(retlr_margin) -parseFloat(spl_rebt)+parseFloat(add_adj_amt)-parseFloat(less_adj_amt)
				taxable_amt =parseFloat(taxable_amt).toFixed(2)
				gst=(taxable_amt * gst_rt/100)/2
				gst=parseFloat(gst).toFixed(2)
				// tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2
			    rbt_add =$('#rbt_add').val() 
				console.log(rbt_add);
				rbt_less =$('#rbt_less').val() 
				$('#rnd_of_add').val(0);
				$('#rnd_of_less').val(0);
				tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2 + parseFloat(rbt_add) - parseFloat(rbt_less)
				tot_amt=Math.round(parseFloat(tot_amt))
			
				$('#tot_amt').val(tot_amt);
				net_rt =parseFloat(tot_amt/tot_qty).toFixed(3);
                $('#tot_pur_rt').val(net_rt);
				
			});
	
		});
	
	});
	
</script>

<script>
	
	$(document).ready(function(){
	
		var tot_qty     = 0.00;
		var base_price  = 0.00;
		var gst_rt      = 0.00;
		var gst         = 0.00;
		var spl_rebt    = 0.00;
		var retlr_margin= 0.00;
		var tot_amt     = 0.00;
		var rbt_add     = 0.00;
		var rbt_less    = 0.00;
		var rnd_of_add  = 0.00;
		var rnd_of_less = 0.00;
		var add_adj_amt = 0.00;
		var less_adj_amt= 0.00;
		var tot_amt     = 0.00;
		var net_rt      = 0.00;
		$('#rnd_of_add').change(function(){
	
			$.get( 
	
				'<?php echo site_url("stock/f_get_ro");?>',
				{ 
	
					rate: $(this).val()
					
				}
	
			)
			.done(function(data){
	
				     //console.log(data);
				var parseData = JSON.parse(data);
				tot_qty=$('#qty').val() 
				gst_rt =$('#gst_rt').val() 
				base_price =tot_qty * $('#rate').val() 
				base_price=parseFloat(base_price).toFixed(2)
				retlr_margin = $('#retlr_margin').val() 
				spl_rebt  = $('#spl_rebt').val() 
				add_adj_amt=$('#adj_amt').val() 
				less_adj_amt =$('#less_amt').val() 
				rbt_add  = $('#less_amt').val() 
				rnd_of_add = $('#rnd_of_add').val() 
				rnd_of_less =$('#rnd_of_less').val() 
				// $('#rbt_add').val(0);
			
				taxable_amt= parseFloat(base_price) +  parseFloat(retlr_margin) -parseFloat(spl_rebt)+parseFloat(add_adj_amt)-parseFloat(less_adj_amt)
				taxable_amt =parseFloat(taxable_amt).toFixed(2)
				gst=(taxable_amt * gst_rt/100)/2
				gst=parseFloat(gst).toFixed(2)
				// tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2
			    rbt_add =$('#rbt_add').val() 
				console.log(rbt_add);
				rbt_less =$('#rbt_less').val() 
				// $('#rnd_of_add').val(0);
				tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2 + parseFloat(rbt_add) - parseFloat(rbt_less) + parseFloat(rnd_of_add) - parseFloat(rnd_of_less)
				tot_amt=Math.round(parseFloat(tot_amt))
			
				$('#tot_amt').val(tot_amt);
			    net_rt =parseFloat(tot_amt/tot_qty).toFixed(3);
                $('#tot_pur_rt').val(net_rt);
				
			});
	
		});
	
	});
	
</script> 

<script>
	
	$(document).ready(function(){
	
		var tot_qty     = 0.00;
		var base_price  = 0.00;
		var gst_rt      = 0.00;
		var gst         = 0.00;
		var spl_rebt    = 0.00;
		var retlr_margin= 0.00;
		var tot_amt     = 0.00;
		var rbt_add     = 0.00;
		var rbt_less    = 0.00;
		var rnd_of_add  = 0.00;
		var rnd_of_less = 0.00;
		var add_adj_amt = 0.00;
		var less_adj_amt= 0.00;
		var tot_amt     = 0.00;
		var net_rt      = 0.00;
		$('#rnd_of_less').change(function(){
	
			$.get( 
	
				'<?php echo site_url("stock/f_get_ro");?>',
				{ 
	
					rate: $(this).val()
					
				}
	
			)
			.done(function(data){
	
				     //console.log(data);
				var parseData = JSON.parse(data);
				tot_qty=$('#qty').val() 
				gst_rt =$('#gst_rt').val() 
				base_price =tot_qty * $('#rate').val() 
				base_price=parseFloat(base_price).toFixed(2)
				retlr_margin = $('#retlr_margin').val() 
				spl_rebt  = $('#spl_rebt').val() 
				add_adj_amt=$('#adj_amt').val() 
				less_adj_amt =$('#less_amt').val() 
				rbt_add  = $('#less_amt').val() 
				rnd_of_add = $('#rnd_of_add').val() 
				rnd_of_less =$('#rnd_of_less').val() 
			
			
				taxable_amt= parseFloat(base_price) +  parseFloat(retlr_margin) -parseFloat(spl_rebt)+parseFloat(add_adj_amt)-parseFloat(less_adj_amt)
				taxable_amt =parseFloat(taxable_amt).toFixed(2)
				gst=(taxable_amt * gst_rt/100)/2
				gst=parseFloat(gst).toFixed(2)
				
			    rbt_add =$('#rbt_add').val() 
				console.log(rbt_add);
				rbt_less =$('#rbt_less').val() 
				
				tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2 + parseFloat(rbt_add) - parseFloat(rbt_less) + parseFloat(rnd_of_add) - parseFloat(rnd_of_less)
				tot_amt=Math.round(parseFloat(tot_amt))
			
				$('#tot_amt').val(tot_amt);
			    net_rt =parseFloat(tot_amt/tot_qty).toFixed(3);
                 $('#tot_pur_rt').val(net_rt);
				
			});
	
		});
	
	});
	
</script> 

<script>
$(document).ready(function(){
$("#ro_dt").change(function(){

var ro_dt = $('#ro_dt').val();

var sale_rate=$('#govt_sale_rt').val();

var d = new Date();

var month = d.getMonth()+1;
var day = d.getDate();

var output = d.getFullYear() + '-' +
(month<10 ? '0' : '') + month + '-' +
(day<10 ? '0' : '') + day;

// console.log(trans_dt,output);

if(new Date(output) < new Date(ro_dt))
{
alert("Ro Date Can Not Be Greater Than Current Date");
//  alert(sale_rate);
$('#submit').attr('type', 'buttom');
return false;

}else{
   $('#submit').attr('type', 'submit');

}

})


});
</script>

<script>
$(document).ready(function(){
$("#invoice_dt").change(function(){

var ro_dt = $('#invoice_dt').val();



var d = new Date();

var month = d.getMonth()+1;
var day = d.getDate();

var output = d.getFullYear() + '-' +
(month<10 ? '0' : '') + month + '-' +
(day<10 ? '0' : '') + day;

// console.log(trans_dt,output);

if(new Date(output) < new Date(ro_dt))
{
alert("invoice Date Can Not Be Greater Than Current Date");
$('#submit').attr('type', 'buttom');
return false;
}else{
   $('#submit').attr('type', 'submit');
}
})
});
</script>

<script>
$(document).ready(function(){
$("#due_dt").change(function(){

var ro_dt = $('#due_dt').val();



var d = new Date();

var month = d.getMonth()+1;
var day = d.getDate();

var output = d.getFullYear() + '-' +
(month<10 ? '0' : '') + month + '-' +
(day<10 ? '0' : '') + day;

// console.log(trans_dt,output);

if(new Date(output) > new Date(ro_dt))
{
alert("Due Date Can Not Be Less Than Current Date");
$('#submit').attr('type', 'buttom');
return false;
}else{
   $('#submit').attr('type', 'submit');
}
})
});
</script>

<script>

$(document).ready(function(){

	var i = 2;

	$('#qty').change(function(){

		$.get( 

			'<?php echo site_url("stock/f_get_qty_per_bag");?>',
			{ 

				prod_id : $('#prod_id').val()
				//dist_cd: $(this).val(),
				// dist_cd : $('#dist_cd').val()
				
			}

		)
		.done(function(data){

			// console.log(data);
			var parseData = JSON.parse(data);
			var qty = $('#qty').val();
			var unit = $('#unit').val();
			// console.log(unit);
			var unitqty =0.00;
			var qty_per_bag = parseData[0].qty_per_bag;
			console.log(qty_per_bag);
			if (qty_per_bag==45){
				 if(unit==1){
				 	unitqty=parseFloat(1000/qty_per_bag).toFixed(2);
					 console.log(unitqty);
				 }
					if(unit==2){
						unitqty=parseFloat(100/qty_per_bag).toFixed(2);
				 }
						if(unit==3){
						unitqty=parseFloat(10/qty).toFixed(2);
					}
				
				var qty_per_bag  =unitqty *qty;
			// var qty_per_bag=parseFloat(qty_per_bag).toFixed(2)
			var qty_per_bag=Math.ceil(qty_per_bag)
			}
			if (qty_per_bag==50){
				if(unit==1){
				 	unitqty=parseFloat(1000/qty_per_bag).toFixed(2);
					 console.log(unitqty);
				 }
					if(unit==2){
						unitqty=parseFloat(100/qty_per_bag).toFixed(2);
				 }
						if(unit==3){
						unitqty=parseFloat(10/qty).toFixed(2);
					}
				
				var qty_per_bag  =unitqty *qty;
			// var qty_per_bag=parseFloat(qty_per_bag).toFixed(2)
			var qty_per_bag=Math.ceil(qty_per_bag)
			}

			// var gst_rt = parseData[0].gst_rt;
			$('#no_of_bags').val(qty_per_bag);
			// $('#gst_rt').val(gst_rt);
		});

	});

});
</script>
<script>
$(document).ready(function(){
	var sale_cnt = $('#sale_cnt').val();
	if (sale_cnt>0){
	//  alert(chal_flag);
	// $('#submit').hide();
		
	$('#msg').html("This RO cannot be edited.Since some items have been sold.").css("font-size","20px","color","#0d7d8ef5");
	$('#submit').attr('type', 'buttom');
return false;

	}else{
		//$('#msg').hide();	
		$('#submit').show();
	}


});
</script>

<script>
$(document).ready(function(){
	var chal_flag = $('#challan_flag').val();
	if (chal_flag=='Y'){
	//  alert(chal_flag);
	$('#submit').hide();	
	$('#msg').html("This RO cannot be edited.Since some items have been sold.").css("font-size","20px","color","#0d7d8ef5");

	}else{
		//$('#msg').hide();	
		$('#submit').show();
	}


});
</script>

<script>
		function endDt(){
			var frmDt = document.getElementById("ro_dt").value;
			var days  = document.getElementById("no_of_days").value;
			var day;

			var year;

			days = (days - 1);
			
			toDt   = new Date(frmDt);

			toDt.setDate(toDt.getDate() + days);

			var dd = toDt.getDate();
    		var mm = toDt.getMonth() + 1;
    		var y  = toDt.getFullYear();

    		if(dd <= 9){
    			dd = '0' + dd;
    		}else{
    			dd = dd;
    		}

    		if(mm <= 9){
    			mm = '0' + mm;
    		}else{
    			mm = mm;
    		}

			var format = y + '-' + mm + '-' + dd;

			document.getElementById("due_dt").value = format;
			
		}

		
</script>
<script>
	
	$(document).ready(function(){
	
		var i               = 2;
		var tot_qty         = 0.00;
		var base_price      = 0.00;
		var gst_rt          = 0.00;
		var gst             = 0.00;
		var spl_rebt        = 0.00;
		var retlr_margin    = 0.00;
		var tot_amt         = 0.00;
		var rbt_add         = 0.00;
		var rbt_less        = 0.00;
		var rnd_of_add      = 0.00;
		var rnd_of_less     = 0.00;
		var add_adj_amt     = 0.00;
		var less_adj_amt    = 0.00;
		var less_trad_margin= 0.00;
		var net_rt          = 0.00;
		$('#trd_mgr').change(function(){
	
			$.get( 
	
				'<?php echo site_url("stock/f_get_ro");?>',
				{ 
	
					rate: $(this).val()
					
				}
	
			)
			.done(function(data){
	
				     //console.log(data);
				var parseData = JSON.parse(data);
				tot_qty=$('#qty').val() 
				gst_rt =$('#gst_rt').val() 
				base_price =tot_qty * $('#rate').val() 
				base_price=parseFloat(base_price).toFixed(2)
				retlr_margin = $('#retlr_margin').val() 
				spl_rebt  = $('#spl_rebt').val() 
				add_adj_amt=$('#adj_amt').val() 
				less_adj_amt =$('#less_amt').val() 
                less_trad_margin=$('#trd_mgr').val() 
				var ckbox5 = $('#less_trad_margin_flag');

$('input').on('click',function () {

	if (ckbox5.is(':checked')) {
		taxable_amt= parseFloat(base_price) +  parseFloat(retlr_margin) -parseFloat(spl_rebt)+parseFloat(add_adj_amt)-parseFloat(less_adj_amt)-parseFloat(less_trad_margin)
				taxable_amt =parseFloat(taxable_amt).toFixed(2)
				gst=(taxable_amt * gst_rt/100)/2
				gst=parseFloat(gst).toFixed(2)
				tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2
				tot_amt=Math.round(parseFloat(tot_amt))
				 
				$('#base_price').val(base_price);
				$('#net_amt').val(taxable_amt);
				$('#tot_amt').val(tot_amt);
				$('#retlr_margin').val(retlr_margin);
				$('#spl_rebt').val(spl_rebt);
				$('#cgst').val(gst);
				$('#sgst').val(gst);
				$('#rbt_add').val(0);
				$('#rbt_less').val(0);
				$('#rnd_of_add').val(0);
				$('#rnd_of_less').val(0);
				net_rt =parseFloat(tot_amt/tot_qty);
                $('#tot_pur_rt').val(net_rt);
	} else {

		taxable_amt= parseFloat(base_price) +  parseFloat(retlr_margin) -parseFloat(spl_rebt)+parseFloat(add_adj_amt)-parseFloat(less_adj_amt)
				taxable_amt =parseFloat(taxable_amt).toFixed(2)
				gst=(taxable_amt * gst_rt/100)/2
				gst=parseFloat(gst).toFixed(2)
				tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2
				tot_amt=Math.round(parseFloat(tot_amt))
				
				$('#base_price').val(base_price);
				$('#net_amt').val(taxable_amt);
				$('#tot_amt').val(tot_amt);
				$('#retlr_margin').val(retlr_margin);
				$('#spl_rebt').val(spl_rebt);
				$('#cgst').val(gst);
				$('#sgst').val(gst);
				$('#rbt_add').val(0);
				$('#rbt_less').val(0);
				$('#rnd_of_add').val(0);
				$('#rnd_of_less').val(0);
				net_rt =parseFloat(tot_amt/tot_qty);
                $('#tot_pur_rt').val(net_rt);
	}
});
			
				
			});
	
		});
	
	});
	
</script>

<script>
	
	$(document).ready(function(){
	
		var i               = 2;
		var tot_qty         = 0.00;
		var base_price      = 0.00;
		var gst_rt          = 0.00;
		var gst             = 0.00;
		var spl_rebt        = 0.00;
		var retlr_margin    = 0.00;
		var tot_amt         = 0.00;
		var rbt_add         = 0.00;
		var rbt_less        = 0.00;
		var rnd_of_add      = 0.00;
		var rnd_of_less     = 0.00;
		var add_adj_amt     = 0.00;
		var less_adj_amt    = 0.00;
        var less_trad_margin= 0.00;
        var less_oth_dis    = 0.00;
		var net_rt          = 0.00;

		$('#les_oth_dis').change(function(){
	
			$.get( 
	
				'<?php echo site_url("stock/f_get_ro");?>',
				{ 
	
					rate: $(this).val()
					
				}
	
			)
			.done(function(data){
				var parseData = JSON.parse(data);
				tot_qty=$('#qty').val() 
				gst_rt =$('#gst_rt').val() 
				base_price =tot_qty * $('#rate').val() 
				base_price=parseFloat(base_price).toFixed(2)
				retlr_margin = $('#retlr_margin').val() 
				spl_rebt  = $('#spl_rebt').val() 
				add_adj_amt=$('#adj_amt').val() 
				less_adj_amt =$('#less_amt').val() 
                                less_trad_margin=$('#trd_mgr').val() 
                                less_oth_dis    =$('#les_oth_dis').val()
								var ckbox6 = $('#less_oth_dis_flag');

$('input').on('click',function () {

	if (ckbox6.is(':checked')) {
		
		taxable_amt= parseFloat(base_price) +  parseFloat(retlr_margin) -parseFloat(spl_rebt)+parseFloat(add_adj_amt)-parseFloat(less_adj_amt)-parseFloat(less_trad_margin)-parseFloat(less_oth_dis)
				taxable_amt =parseFloat(taxable_amt).toFixed(2)
				gst=(taxable_amt * gst_rt/100)/2
				gst=parseFloat(gst).toFixed(2)
				tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2
				tot_amt=Math.round(parseFloat(tot_amt))
				$('#base_price').val(base_price);
				$('#net_amt').val(taxable_amt);
				$('#tot_amt').val(tot_amt);
				$('#retlr_margin').val(retlr_margin);
				$('#spl_rebt').val(spl_rebt);
				$('#cgst').val(gst);
				$('#sgst').val(gst);
				$('#rbt_add').val(0);
				$('#rbt_less').val(0);
				$('#rnd_of_add').val(0);
				$('#rnd_of_less').val(0);
				net_rt =parseFloat(tot_amt/tot_qty);
                $('#tot_pur_rt').val(net_rt);

	} else {

		taxable_amt= parseFloat(base_price) +  parseFloat(retlr_margin) -parseFloat(spl_rebt)+parseFloat(add_adj_amt)-parseFloat(less_adj_amt)-parseFloat(less_trad_margin)
				taxable_amt =parseFloat(taxable_amt).toFixed(2)
				gst=(taxable_amt * gst_rt/100)/2
				gst=parseFloat(gst).toFixed(2)
				tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2
				tot_amt=Math.round(parseFloat(tot_amt))
				$('#base_price').val(base_price);
				$('#net_amt').val(taxable_amt);
				$('#tot_amt').val(tot_amt);
				$('#retlr_margin').val(retlr_margin);
				$('#spl_rebt').val(spl_rebt);
				$('#cgst').val(gst);
				$('#sgst').val(gst);
				$('#rbt_add').val(0);
				$('#rbt_less').val(0);
				$('#rnd_of_add').val(0);
				$('#rnd_of_less').val(0);
				net_rt =parseFloat(tot_amt/tot_qty);
                $('#tot_pur_rt').val(net_rt);

	}
});		
				
			});
	
		});
	
	});
	
</script>
<script>
	
	$(document).ready(function(){
	
		var i               = 2;
		var tot_qty         = 0.00;
		var base_price      = 0.00;
		var gst_rt          = 0.00;
		var gst             = 0.00;
		var spl_rebt        = 0.00;
		var retlr_margin    = 0.00;
		var tot_amt         = 0.00;
		var rbt_add         = 0.00;
		var rbt_less        = 0.00;
		var rnd_of_add      = 0.00;
		var rnd_of_less     = 0.00;
		var add_adj_amt     = 0.00;
		var less_adj_amt    = 0.00;
        var less_trad_margin= 0.00;
        var less_oth_dis    = 0.00;
        var less_frt_subsidy= 0.00;
		var net_rt          = 0.00;
		$('#frt_subsidy').change(function(){
	
			$.get( 
	
				'<?php echo site_url("stock/f_get_ro");?>',
				{ 
	
					rate: $(this).val()
					
				}
	
			)
			.done(function(data){
	
				//console.log(data);
				var parseData = JSON.parse(data);
				tot_qty=$('#qty').val() 
				gst_rt =$('#gst_rt').val() 
				base_price =tot_qty * $('#rate').val() 
				base_price=parseFloat(base_price).toFixed(2)
				retlr_margin = $('#retlr_margin').val() 
				spl_rebt  = $('#spl_rebt').val() 
				add_adj_amt=$('#adj_amt').val() 
				less_adj_amt =$('#less_amt').val() 
                less_trad_margin=$('#trd_mgr').val() 
                less_oth_dis    =$('#les_oth_dis').val()
				less_frt_subsidy =$('#frt_subsidy').val()
				var ckbox7 = $('#less_frght_subsdy_flag');

$('input').on('click',function () {

	if (ckbox7.is(':checked')) {
		taxable_amt= parseFloat(base_price) +  parseFloat(retlr_margin) -parseFloat(spl_rebt)+parseFloat(add_adj_amt)-parseFloat(less_adj_amt)-parseFloat(less_trad_margin)-parseFloat(less_oth_dis)-parseFloat(less_frt_subsidy)
				taxable_amt =parseFloat(taxable_amt).toFixed(2)
				gst=(taxable_amt * gst_rt/100)/2
				gst=parseFloat(gst).toFixed(2)
				tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2
				tot_amt=Math.round(parseFloat(tot_amt))
				$('#base_price').val(base_price);
				$('#net_amt').val(taxable_amt);
				$('#tot_amt').val(tot_amt);
				$('#retlr_margin').val(retlr_margin);
				$('#spl_rebt').val(spl_rebt);
				$('#cgst').val(gst);
				$('#sgst').val(gst);
				$('#rbt_add').val(0);
				$('#rbt_less').val(0);
				$('#rnd_of_add').val(0);
				$('#rnd_of_less').val(0);
				net_rt =parseFloat(tot_amt/tot_qty);
                $('#tot_pur_rt').val(net_rt);
		
	} else {
		        taxable_amt= parseFloat(base_price) +  parseFloat(retlr_margin) -parseFloat(spl_rebt)+parseFloat(add_adj_amt)-parseFloat(less_adj_amt)-parseFloat(less_trad_margin)-parseFloat(less_oth_dis)
				taxable_amt =parseFloat(taxable_amt).toFixed(2)
				gst=(taxable_amt * gst_rt/100)/2
				gst=parseFloat(gst).toFixed(2)
				tot_amt=parseFloat(taxable_amt) + parseFloat(gst) *2
				tot_amt=Math.round(parseFloat(tot_amt))
				$('#base_price').val(base_price);
				$('#net_amt').val(taxable_amt);
				$('#tot_amt').val(tot_amt);
				$('#retlr_margin').val(retlr_margin);
				$('#spl_rebt').val(spl_rebt);
				$('#cgst').val(gst);
				$('#sgst').val(gst);
				$('#rbt_add').val(0);
				$('#rbt_less').val(0);
				$('#rnd_of_add').val(0);
				$('#rnd_of_less').val(0);
				net_rt =parseFloat(tot_amt/tot_qty);
                $('#tot_pur_rt').val(net_rt);
		
	}
});
				
			});
	
		});
	
	});
	
</script>

<!-- <script>
	
	$(".sch_cd").select2();   // Code For Select Write Option



$(document).ready(function(){

   var i = 0;

   $('#comp_id').change(function(){

	   $.get( 

		   '<?php echo site_url("stock/f_get_product");?>',

		   { 

			   comp_id: $(this).val()

		   }

	   ).done(function(data){

		   var string = '<option value="">Select</option>';

		   $.each(JSON.parse(data), function( index, value ) {

			   string += '<option value="' + value.prod_id + '">' + value.prod_desc + '</option>'

		   });

		   $('#prod_id').html(string);


		 });


   });

});
</script> -->
