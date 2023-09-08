<div class="wraper">      
            
	<div class="col-md-6 container form-wraper">

			<div class="form-header">
			
				<h4>Edit Advance</h4>
			
			</div>

            <div class="form-group row">
                <label for="receipt_no" class="col-sm-2 col-form-label">Receipt No.:</label>

                <div class="col-sm-10">

                    <input type="text" id=receipt_no name="receipt_no" class="form-control"   
                        value="<?php echo $advDtls->receipt_no; ?>" readonly />

                </div>

            </div>

            <div class="form-group row">
				<label for="society" class="col-sm-2 col-form-label">Society:</label>
				<div class="col-sm-4">

					<select name="society" class="form-control sch_cd required" id="society" required>

						<option value="">Select Society</option>

                        <?php

                            foreach($societyDtls as $val){

                        ?>

                        <option value="<?php echo $val->soc_id;?>"<?php echo($advDtls->soc_id==$val->soc_id)?'selected':'';?>><?php echo $val->soc_name;?></option>

                        <?php

                            }

                        ?>     

                    </select>

                </div>

                <!-- <label for="trans_dt" class="col-sm-2 col-form-label">Date:</label>

				<div class="col-sm-4">

					<input type="date" id=trans_dt name="trans_dt" class="form-control" 
                           value="<?php echo $advDtls->trans_dt; ?>" required />

				</div> -->

            </div>

            <div class="form-group row">
            <div></div>
            </div>

			<div class="form-group row">
				<label for="trans_type" class="col-sm-2 col-form-label">Transaction Type:</label>
				<div class="col-sm-4">

                    <select name="trans_type" class="form-control required" id="trans_type">

                        <option value="I"<?php echo($advDtls->trans_type=='I')?'selected':'';?>>Deposit</option>

                        <option value="O"<?php echo($advDtls->trans_type=='O')? 'selected' : '';?>>Adjustment</option>

                    </select>

				</div>

				<label for="adv_amt" class="col-sm-2 col-form-label">Amount:</label>
				<div class="col-sm-4">

					<input type="text" id=adv_amt name="adv_amt" class="form-control required" 
                           value="<?php echo $advDtls->adv_amt; ?>" required/>

				</div>
			</div>
			<div class="form-group row">
			<label for="trans_dt" class="col-sm-2 col-form-label">Date:</label>

				<div class="col-sm-4">

					<input type="date" id=trans_dt name="trans_dt" class="form-control" 
                           value="<?php echo $advDtls->trans_dt; ?>" required />

				</div>
			<div class="col-sm-2">
				
			<input id="cshbank"  name="cshbank" type="radio" class="radio-label" <?php if($advDtls->cshbnk_flag=='0') echo "checked='checked'"; ?> value="0"  />
			
                <label for="cshbank" class="radio-label">Cash</label>
			</div>
				<div class="col-sm-2">
                <input id="cshbank" name="cshbank" type="radio" class="radio-label"  <?php if($advDtls->cshbnk_flag=='1') echo "checked='checked'"; ?>value="1"/>
				
                <label for="cshbank" class="radio-label">Bank</label>
				</div>
			</div>

            <div class="form-group row">
            <label for="bank"  class="col-sm-2 col-form-label">Bank:</label>

<div class="col-sm-4">

<select name="bank" class="form-control sch_cd required" id="bank" >

						<option value="">Select bank</option>

                        <?php

                            foreach($bnk_dtls as $val){

                        ?>

                        <option value="<?php echo $val->sl_no;?>"<?php echo($advDtls->bank==$val->sl_no)?'selected':'';?>><?php echo $val->bank_name;?></option>

                        <?php

                            }

                        ?>     

                    </select>
</div>
<div>
<div class="form-group row">
<label for="ac_no" class="col-sm-2 col-form-label">A/C No.:</label>
<div class="col-sm-4">

<input type="text" id=ac_no name="ac_no" class="form-control ac_no" 
value="<?php echo $advDtls->ac_no; ?>" readonly/>
						

                       

                      
</div>
</div>
            <div class="form-group row">
				<label for="remarks" class="col-sm-2 col-form-label">Remarks:</label>
				<div class="col-sm-10">

                    <textarea id=remarks name="remarks" class="form-control"><?php echo $advDtls->remarks; ?></textarea>
                </div>
            </div>

			</div>

	</div>	

</div>


<script>
    
     $(".sch_cd").select2();

</script>

<script>

$(document).ready(function(){

	var i = 2;

	$('#bank').change(function(){

		$.get( 

			'<?php echo site_url("adv/f_get_dist_bnk_dtls");?>',
			{ 

				bnk_id: $(this).val(),
				
				
			}

		)
		.done(function(data){

			//console.log(data);
			var parseData = JSON.parse(data);
			var ac_no = parseData[0].ac_no;
			var ifsc = parseData[0].ifsc;
            $('#ac_no').val(ac_no);
			// $('#ifsc').val(ifsc);
           
		});
        

	});

});
</script>
<script>
$('input:radio[name="cshbank"]').change(function() {
	console.log('hi');
    if ($(this).val()=='1') {
        $('#bank').attr('disabled', false);
		$('#bank').attr('required', 'required');
    } 
    else if ($(this).val()=='0') {
        $('#bank').attr('disabled', true);
	 $("#ac_no").val("");
	//  $("#bank").val('Select bank', 'Select bank'); 
	$("#bank")[0].selectedIndex = 0;
    $("#bank").trigger("change");
	$("#remarks").val("");
					 
    }
});
</script>