<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Paddy Procurement Login</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="shortcut icon" href="<?php echo base_url("/assets/login_page/images/favicon.png");?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login_page/css/bootstrap.css"); ?>">
 <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo base_url("/assets/css/bootstrap-toggle.css");?>" rel="stylesheet">
      <link href="<?php echo base_url("/assets/css/jquery.dataTables.css");?>" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   
  
 <script type="text/javascript" src="<?php echo base_url("/assets/js/jquery.dataTables.js")?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login_page/css/font-awesome.css"); ?>">

<!--<link rel="stylesheet" type="text/css" href="<?php //echo base_url("/assets/login/css/apps_login.css")?>">-->

    <link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login/css/apps_login.css")?>">
	
<!--Exist File Start Use this file for display Login Popup-->
	<!--<link rel="stylesheet" type="text/css" href="assets/login/css/apps_login.css">-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login/css/apps_login.css")?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login/css/main.css")?>">
<!--Exist File End Use this file for display Login Popup-->
	
<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login_page/css/apps.css"); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login_page/css/apps_inner.css"); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login_page/css/res.css"); ?>">

<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<!--    font-family: 'Roboto', sans-serif;-->

<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<!--font-family: 'Oswald', sans-serif;-->
	
</head>

<body>
<header class="headerTop_DashLogin">
	<div class="wrapper_Dash">
	<div class="col-sm-3 float-left logo_Dash"><img src="<?php echo base_url("/assets/front_page/images/logo.png"); ?>" alt=""/></div>
	<div class="col-sm-9 float-left rightTxt_Dash">
	<h2>The W.B.S Co-Operative Marketing Federation Ltd (Benfed)<br>
	<span>Welcome To Benfed ePortal</span></h2>	
	</div>
	</div>	
</header>
<div class="navigationSecLogin">
	<div class="wrapper_Dash">
		<div class="col-sm-12">
		<ul>
		<li><a href="<?php echo base_url(); ?>">Home</a></li>
		<li><a href="#">Old KMS</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/User_Login/notice">Notice</a></li>
		<li><a href="#">Contacts</a></li>
		</ul>
		</div>
	</div>
</div>
	
<div class="daseboardContentArea_DashLogin daseboardPading_DashLogin">
	<div class="wrapper_Dash">
		
		<!--Take this area from developed code Div Classs Name "wrap-login100" (Start Point)-->
	
		
		<table class="table table-bordered table-hover" id="myTable">

                <thead>

                    <tr>
                    
                        <th>Sl. No.</th>
                        <th>Number</th>
                        <th>Date</th>
                        <th>PDF</th>
                        

                    </tr>

                </thead>

                <tbody> 

                    <?php 
                    
                    if($notice) {
                        $i = 1;
                        foreach($notice as $n) {

                    ?>

                            <tr>

                                <td><?php echo $i++; ?></td>
                                <td><?php if(isset($n->number)){ echo $n->number; }  ?></td>
                                <td><?php echo date('d/m/Y',strtotime($n->notice_date)); ?></td>
					
                                <td><a href="<?=base_url()?>uploads/notice/<?php if(isset($n->file)){ echo $n->file; }  ?>" download>Download</a></td>
                              

                            </tr>     
                    <?php
                    
                        }

                    }

                    else {

                        echo "<tr><td colspan='10' style='text-align: center;'>No data Found</td></tr>";

                    }

                    ?>
                
                </tbody>

                <tfoot>

                    <tr>
                    
                        <th>Sl. No.</th>
                        <th>Number</th>
                        <th>Date</th>
                        <th>PDF</th>

                    </tr>
                
                </tfoot>

            </table>

			
		<!--Take this area from developed code Div Classs Name "wrap-login100" (End Point)-->
	</div>
</div>
	
<footer class="footerSec_Dash">
	<div class="wrapper_Dash">
	<div class="col-sm-6 float-left mapSec"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3685.7375062895694!2d88.39095591548983!3d22.5140296852129!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a02714d6e5d2557%3A0x384d7dbe8ab31a73!2s3rd%20Floor%2C%201582%2C%20Rajdanga%20Main%20Rd%2C%20Kasba%20New%20Market%2C%20Rajdanga%2C%20Kasba%2C%20Kolkata%2C%20West%20Bengal%20700107!5e0!3m2!1sen!2sin!4v1614851691132!5m2!1sen!2sin" width="100%" height="175" style="border:0;" allowfullscreen="" loading="lazy"></iframe></div>
	<div class="col-sm-6 float-left addressSec">
		<h2>Location</h2>
		<p>Southend Conclave, 3rd Floor, 1582 Rajdanga Main Road, <br>
			Kolkata - 700 107</p>
		<ul>
		<li><i class="fa fa-phone" aria-hidden="true"></i> 91 33 2441 4366/67</li>
		<li><i class="fa fa-fax" aria-hidden="true"></i> +91 33 2441-4372</li>
		<li><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:info@benfed.org">info@benfed.org</a></li>
		</ul>
		
	</div>
	</div>
</footer>

<!--===============================================================================================-->
	<script src="<?php echo base_url("/assets/login/js/main.js")?>"></script>

	<script>
	   $(document).ready(function() {
    $('#myTable').DataTable();
} );

  </script>

	

</body>
</html>