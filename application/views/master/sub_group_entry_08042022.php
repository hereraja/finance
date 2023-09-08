 <div class="wraper">      

	<div class="col-md-6 container form-wraper">

		
		<form method="POST" action="<?php echo site_url('master/sub_group_save');?>" >

			<div class="form-header">
                
				<h4>Add Group</h4>
			
			</div>

			<div class="form-group row">

				<label for="gr_name" class="col-sm-2 col-form-label">A/c Head Name</label>

				<div class="col-sm-10">

					<select class="form-control" id="gr_name" name="gr_name">
						<option value="">Select</option>
						<?php
							$gr_dtls = json_decode($gr_dtls);
							foreach($gr_dtls as $dt){
							$select = '';
							if($dt->sl_no == $selected['gr_id']){
								$select = 'selected';
							}
						?>
						<option value='<?= $dt->sl_no ?>' <?= $select ?>><?= strtoupper($dt->name) ?></option>
					<?php } ?>
					</select>
				</div>

			</div>

			<div class="form-group row">

				<label for="ac_flg" class="col-sm-2 col-form-label">Sub Group</label>

				<div class="col-sm-10">
					
					<input type="text" class="form-control" id="sub_gr" name="sub_gr" required="required" value="<?= $selected['sub_gr'] ?>" />

				</div>

			</div>

			<input type="hidden" name="id" value="<?= $selected['id'] ?>">

			<div class="form-group row">

				<div class="col-sm-10">

				<input type="submit" class="btn btn-info" value="Save" />

				</div>

			</div>

		</form>

  	</div>

    </div>

	<script>

		$( "#gr_name" ).select2();

	</script>
