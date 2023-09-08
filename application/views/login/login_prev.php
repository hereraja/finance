<!DOCTYPE html>
<html lang="en">
<head>
	<title>Paddy Procurement Login</title>
	<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<!--<link rel="shortcut icon" href="<?php echo base_url("/assets/front_page/images/favicon.png");?>" type="image/x-icon">-->
	<link rel="icon" href="<?php echo base_url("/benfed.png"); ?>">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login/vendor/bootstrap/css/bootstrap.min.css")?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css")?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css")?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login/vendor/animate/animate.css")?>">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login/vendor/css-hamburgers/hamburgers.min.css")?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login/vendor/animsition/css/animsition.min.css")?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login/vendor/select2/select2.min.css")?>">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login/vendor/daterangepicker/daterangepicker.css")?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login/css/util.css")?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login/css/main.css")?>">
<!--===============================================================================================-->



<style>
	img {
	float: left;
	}
	p.title 
	{
		font: 15px arial, sans-serif;
	}
</style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login/css/apps_login.css")?>">

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form flex-sb flex-w" id="login" method="POST" action="<?php echo site_url("User_Login/index") ?>">
					<div class="login100_logo">
					<h2><img src="<?php echo base_url('benfed.png'); ?>" alt="logo"></h2>
					<h3>The West Bengal  State Co-Operative Marketing Federation Ltd (Benfed)</h3>	
					</div>
					 <span class="login100-form-title p-b-10" style="color:red">
					 <?php echo $this->session->flashdata('login_error');?>
					</span> 
					
					<span class="txt1 p-b-11">
						Username
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Please supply a valid User Id">
						<input class="input100" type="text" name="user_id" id="user_id"/>
						<span class="focus-input100"></span>
					</div>
					<span class="txt1 p-b-11">
						Password
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Please supply password">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100" type="password" name="user_pwd" />
						<span class="focus-input100"></span>
					</div>
					<div class="select_main">
					<div class="select_1">

							<select class="form-control" name="kms_yr" id="kms_yr">

								<option value ="">Please Select KMS Year</option>

								<?php

									foreach($kms_yr as $row){ ?>

										<option value="<?php echo $row->sl_no ?>"><?php echo $row->kms_yr; ?></option>
									<?php
										}
									?>

							</select>

					</div>
					

					<div class="select_2" > 

						<select class="form-control" name="branch_id" id="test" style="display:none" >
							<option value="" >Please Select Branch Name</option>
							<?php foreach($branch_data as $branch){ ?>
								<option value="<?php echo $branch->id; ?>" ><?php echo $branch->branch_name; ?></option>
							<?php } ?>
						</select>

					</div>
					</div>
					

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
					
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="<?php echo base_url("/assets/login/vendor/jquery/jquery-3.2.1.min.js")?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url("/assets/login/vendor/animsition/js/animsition.min.js")?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url("/assets/login/vendor/bootstrap/js/popper.js")?>"></script>
	<script src="<?php echo base_url("/assets/login/vendor/bootstrap/js/bootstrap.min.js")?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url("/assets/login/vendor/select2/select2.min.js")?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url("/assets/login/")?>vendor/daterangepicker/moment.min.js"></script>
	<script src="<?php echo base_url("/assets/login/vendor/daterangepicker/daterangepicker.js")?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url("/assets/login/vendor/countdowntime/countdowntime.js")?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url("/assets/login/js/main.js")?>"></script>

	<script>
	$('#user_id').keyup(function(e) { // <--- THIS IS THE CHANGE
 
     var user_id = $('#user_id').val();
	 
      $.ajax({
	  type: "POST",
	  url: "<?php echo site_url("User_Login/check_user") ?>",
	  data: {user_id:user_id}, 
	  dataType: "html",
	  success: function(data){
		if(data=="A"){
		$('#test').show(data);
		$('#test').prop('required',true);
		}else{
			$('#test').hide(data);	
		}
	  },
	 // error: function() { alert("Error posting feed."); }
    });

    });
  </script>

	<script>
		$(document).ready(function(){
			$("#login").on('submit',function(){

				var kmyr = $("#kms_yr").val();

				if(kmyr == ""){
					alert("Please select KMS year");
					return false;
				}
			});
		});

	</script>
</body>
</html>

