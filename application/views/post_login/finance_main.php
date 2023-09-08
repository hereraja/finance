<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo base_url("/benfed.png"); ?>">
    <title>Samabayika</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url("/assets/css/sb-admin.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("/assets/css/select2.css"); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url("/assets/js/validation.js") ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("/assets/js/select2.js") ?>"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url("/assets/css/bootstrap-toggle.css"); ?>" rel="stylesheet">
    <!--  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> -->
    <script type="text/javascript" src="<?php echo base_url("/assets/js/table2excel.js") ?>"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url("/assets/js/bootstrap-toggle.js") ?>"></script>

    <link href="<?php echo base_url("/assets/css/apps_newDashboard.css"); ?>" rel="stylesheet">

    <style>
        .hr {
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 1px;
        }

        .transparent_tag {

            background: transparent;
            border: none;

        }

        .no-border {
            border: 0;
            box-shadow: none;
            width: 75px;
        }


        .badge-notify {
            background: red;
            position: relative;
            top: -6px;
            left: -10px;
        }
        #listmotification li{
            width: 100%;
        }
        .dropbtnt{
            padding: 0px !important;
            margin-right: 1em;
        }
    </style>

    
<style>
    .dropdown-left-manual {
  right: 0;
  left: auto;
  padding-left: 1px;
  padding-right: 1px;
}
</style>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
    <link href="<?php echo base_url("/assets/css/apps.css"); ?>" rel="stylesheet">
</head>

<body id="page-top" style="background-color: #eff3f6;">
    <header class="header_class">
        <ul class="header_top">
            <li><strong>Branch Name: </strong><?php if (isset($this->session->userdata['loggedin']['branch_name'])) {
                                                    echo $this->session->userdata['loggedin']['branch_name'];
                                                } ?></li>
            <li><strong>Financial Year: </strong><?php if (isset($this->session->userdata['loggedin']['fin_yr'])) {
                                                        echo $this->session->userdata['loggedin']['fin_yr'];
                                                    } ?></li>
            <li><strong>User: </strong><?php if (isset($this->session->userdata['loggedin']['user_name'])) {
                                            echo $this->session->userdata['loggedin']['user_name'];
                                        } ?></li>
            <li><strong>Module: </strong>Accounts</li>



            <li class="date"><strong>Date: </strong> <?php echo date("d-m-Y"); ?></li>

            <!-- <li class="date">



                <?php if ($this->session->userdata['loggedin']['branch_id'] == "342") { ?>

                    <div class="dropdown">
                        <div class="dropbtn dropbtnt">
                            <a href="<?php echo site_url("notification"); ?>" style="color: white; text-decoration: none;"><i class="fa fa-bell" style="font-size: 0.73em;"></i> </a>
                        </div>

                    </div>
                <?php } else { ?>


                    <div class="dropdown">
                        <div class="dropbtn dropbtnt">
                            <a href="#" style="color: white; text-decoration: none;">
                                <i class="fa fa-bell fa-fw" aria-hidden="true" style="font-size: 0.73em;"></i>
                                <span class="badge progress-bar-danger badge-notify" id="notification"></span>
                            </a>
                        </div>
                        <div class="dropdown-content dropdown-left-manual">
                            <ul class="list-group" id="listmotification">

                            </ul>
                            <a href="<?= site_url('notification/my-notification');?>" style="text-align: center;">More Notification</a>
                        </div>
                    </div>

                <?php } ?>


            </li> -->
        </ul>
    </header>

    <nav class="navbar navbar-inverse bg-primary">

        <div class="col-sm-2 logo_sec_main">
            <div class="logo_sec">
                <img src="<?php echo base_url("assets/images/benfed.png"); ?>" />
            </div>
        </div>
        <div class="col-sm-9 navbarSectio">
            <?php if ($this->session->userdata['loggedin']['user_type'] != "O") { ?>
                <div class="dropdown">
                    <div class="dropbtn">
                        <a href="<?php echo site_url("dashboard"); ?>" style="color: white; text-decoration: none;"><i class="fa fa-home"></i> Home</a>
                    </div>

                </div>

                <?php if ($this->session->userdata['loggedin']['ho_flag'] == "Y" && $this->session->userdata['loggedin']['user_type'] = "A") { ?>
                    <div class="dropdown">
                        <div class="dropbtn">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                            Master
                            <i class="fa fa-angle-down"></i>
                        </div>
                        <div class="dropdown-content">
                            <a href="<?php echo site_url('group'); ?>">Group</a>
                            <a href="<?php echo site_url('subgroup'); ?>">Sub Group</a>
                            <a href="<?php echo site_url('achead'); ?>">A/C Head</a>

                            <!-- <a href="<?php // echo site_url('paddys/add_new/f_district'); 
                                            ?>">District</a> -->
                        </div>
                    </div>
                <?php } ?>
                <div class="dropdown">
                    <div class="dropbtn">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                        Transaction
                        <i class="fa fa-angle-down"></i>
                    </div>
                    <div class="dropdown-content">
                        <a href="<?php echo site_url('cashVoucher'); ?>">Cash Voucher</a>
                        <a href="<?php echo site_url('bankVoucher'); ?>">Bank Voucher</a>

                        <a href="<?php echo site_url('jurnalVoucher'); ?>">Journal Voucher</a>

                        <a href="<?php echo site_url('cheqdtl'); ?>">Cheque Entry</a>
                    

                        <?php if ($this->session->userdata['loggedin']['ho_flag'] == "Y" && $this->session->userdata['loggedin']['user_type'] == "A" ||  $this->session->userdata['loggedin']['user_type'] == 'M' || $this->session->userdata['loggedin']['user_type'] == 'S') { ?>
                          

                           
                            
                        <?php } ?>
                    </div>
                </div>
                <?php if ($this->session->userdata['loggedin']['ho_flag'] == "Y" || $this->session->userdata['loggedin']['user_type'] == 'M' || $this->session->userdata['loggedin']['user_type'] == 'C' || $this->session->userdata['loggedin']['user_type'] == 'A' || $this->session->userdata['loggedin']['user_type'] == 'S') { ?>
                    <div class="dropdown">
                        <div class="dropbtn">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                            Approve
                            <i class="fa fa-angle-down"></i>
                        </div>
                        <div class="dropdown-content">
                            <?php if ($this->session->userdata['loggedin']['ho_flag'] == "Y") { ?>
                                <a href="<?php echo site_url('mnthend'); ?>">Month End </a>
                            <?php } ?>
                            <a href="<?php echo site_url('purchasevu'); ?>">Vouchers</a>

                            <!--<a href="<?php echo site_url('crnvu'); ?>">Cr Note to society </a>
                        <a href="<?php echo site_url('advvu'); ?>">Advance from society </a>
                        <a href="<?php echo site_url('xyz'); ?>">Receive from society </a>
                         <a href="<?php echo site_url('jurnalVoucher'); ?>">Jurnal Voucher</a> -->
                            <!-- <a href="<?php // echo site_url('paddys/add_new/f_district'); 
                                            ?>">District</a> -->
                        </div>
                    </div>
                <?php } ?>
                <div class="dropdown">
                    <div class="dropbtn">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                        Report
                        <i class="fa fa-angle-down"></i>
                    </div>
                    <div class="dropdown-content">
                        <div class="sub-dropdown">
                            <a class="sub-dropbtn">Print Voucher<i class="fa fa-angle-right" style="float: right;"></i></a>
                            <div class="sub-dropdown-content">
                                <a href="<?php echo site_url("cashVoucherlst"); ?>">Cash Voucher</a>
                                <a href="<?php echo site_url("bankVoucherlst"); ?>">Bank Voucher</a>
                                <a href="<?php echo site_url("journallst"); ?>">Journal Voucher</a>

                                <a href="<?php echo site_url('advjrnlr'); ?>">All Voucher</a>
                            </div>
                        </div>
                        <a href="<?php echo site_url('ledgcodedtl'); ?>">Account Heads Details</a>

                        <!-- <a href="<?php echo site_url('daybook'); ?>">Daybook</a> -->
                        <a href="<?php echo site_url('cashbook'); ?>">Cashbook</a>
                        <a href="<?php echo site_url('bankbook'); ?>">Bankbook</a>
                        <a href="<?php echo site_url('report/scroll_book'); ?>">Scroll Book</a>


                        <a href="<?php echo site_url('trailbal'); ?>">Trial balance </a>
						<a href="<?php echo site_url('balsh'); ?>">Balance Sheet</a>
						<a href="<?php echo site_url('pl'); ?>">Profit & Loss(pl)</a>
                        <?php if ($this->session->userdata['loggedin']['branch_id'] == 342) { ?>
                            <a href="<?php echo site_url('consolidated-trailbal'); ?>">Consolidated Trial</a>
                            <a href="<?php echo site_url('consolidated-trailbal-group'); ?>">Group Wise Acc details</a>
                            <a href="<?php echo site_url('consolidated-trailbal-subgroup'); ?>">Sub Group Wise Acc details</a>
                        <?php } ?>
                        <!-- <div class="dropdown-content"> -->
                        <!-- <div class="sub-dropdown">
                            <a class="sub-dropbtn">Trial balance<i class="fa fa-angle-right" style="float: right;"></i></a>
                            <div class="sub-dropdown-content">
                                

                                <a href="<?php echo site_url('trailbal'); ?>">Branch Wise </a>


                                <?php if ($this->session->userdata['loggedin']['ho_flag'] == "Y" && $this->session->userdata['loggedin']['user_type'] == "A") { ?>

                                    <!-- <a href="<?php echo site_url('trailbalsubgroup'); ?>">Subgroup Wise</a> 
                                    <!--  <a href="<?php //echo site_url('trailbal_group'); 
                                                    ?>">Trial balance group</a> 
                                <?php } ?>

                            </div>
                        </div> -->
                        <!-- </div> -->




                        <!-- <a href="<?php //echo site_url('gl'); 
                                        ?>">GL</a> -->
                        <a href="<?php echo site_url('ac_detail'); ?>">Acount detail</a>
                        <?php if ($this->session->userdata['loggedin']['user_type'] == "A" && $this->session->userdata['loggedin']['ho_flag'] == "Y") { ?>
                            
                        <?php }
                        if ($this->session->userdata['loggedin']['user_type'] == "A" && $this->session->userdata['loggedin']['ho_flag'] == "Y") { ?>
                            <!--  <a href="<?php echo site_url('purjrnlr'); ?>">Purchase Journal</a>-->

                        <?php } ?>
                    </div>
                </div>


                <!-- ============================================= -->




                <!-- ================================================= -->



                <div class="dropdown">
                    <div class="dropbtn">

                        <i class="fa fa-cog fa-spin fa-fw" aria-hidden="true"></i>
                        Setting
                        <i class="fa fa-angle-down"></i>
                    </div>
                    <div class="dropdown-content">



                        <!-- ===================================================================================== -->


                        <a href="<?php echo site_url('/user_add'); ?>">Create User</a>
                        <?php
                        if ($this->session->userdata['loggedin']['user_type'] == "A") { ?>
                            <a href="<?php echo site_url('/userlist_admin'); ?>">User List </a>
                        <?php }
                        if ($this->session->userdata['loggedin']['user_type'] != "U" && $this->session->userdata['loggedin']['user_type'] != "A") { ?>
                            <!-- <a href="<?php echo site_url('/user'); ?>">User List</a> -->
                        <?php } ?>
                        <a href="<?php echo site_url("/admins/edite_userProfile"); ?>">Edit Profile</a>
                        <a href="<?php echo site_url("/admins/change_passwoerd"); ?>">Change Password</a>


                        <!-- ================================================================================================ -->




                        <!-- <a href="<?php echo site_url("profiles") ?>">Change Password</a> -->
                        <?php if ($this->session->userdata['loggedin']['user_type'] != "U") {
                        ?>
                            <!-- <a href="<?php echo site_url('user'); ?>">Create User</a> -->
                        <?php } ?>
                    </div>
                </div>
            <?php } else { ?>
                <div class="dropdown">
                    <div class="dropbtn">
                        <i class="fa fa-cog fa-spin fa-fw" aria-hidden="true"></i>
                        Setting
                        <i class="fa fa-angle-down"></i>
                    </div>
                    <div class="dropdown-content">
                        <!-- <a href="<?php echo site_url('user'); ?>">Create User</a> -->
                    </div>
                </div>
            <?php } ?>
            <div class="dropdown">
                <div class="dropbtn">
                    <a href="<?php echo site_url("login/logout") ?>" style="color: white; text-decoration: none;"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                </div>
            </div>
        </div>

    </nav>
    <section>