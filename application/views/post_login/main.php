<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo base_url("/benfed.png"); ?>">
    <title>BENFED</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url("/assets/css/sb-admin.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("/assets/css/select2.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("/assets/css/anexture.css"); ?>">


    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url("/assets/css/bootstrap-toggle.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("/assets/css/jquery.dataTables.css"); ?>" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> -->
    <script type="text/javascript" src="<?php echo base_url("/assets/js/jquery.dataTables.js") ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("/assets/js/validation.js") ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("/assets/js/select2.js") ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("/assets/js/table2excel.js") ?>"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url("/assets/js/bootstrap-toggle.js") ?>"></script>
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
    </style>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
    <link href="<?php echo base_url("/assets/css/apps.css"); ?>" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/css_table/apps.css"); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/css_table/apps_inner.css"); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/css_table/res.css"); ?>">

</head>

<body id="page-top" style="background-color: #eff3f6;">
    <header class="header_class">
        <ul class="header_top">
            <li><strong>Branch Name: </strong><?php if (isset($this->session->userdata['loggedin']['branch_name'])) {
                                                    echo $this->session->userdata['loggedin']['branch_name'];
                                                } ?></li>
            <li><strong>KMS Year: </strong><?php if (isset($this->session->userdata['loggedin']['fin_yr'])) {
                                                echo $this->session->userdata['loggedin']['fin_yr'];
                                            } ?></li>
            <li><strong>User: </strong><?php if (isset($this->session->userdata['loggedin']['user_name'])) {
                                            echo $this->session->userdata['loggedin']['user_name'];
                                        } ?></li>
            <li><strong>Module: </strong>Paddy Procurement</li>
            <li class="date"><strong>Date: </strong> <?php echo date("d-m-Y"); ?></li>
        </ul>
    </header>

    <nav class="navbar navbar-inverse bg-primary">

        <div class="col-sm-2 logo_sec_main">
            <div class="logo_sec">
                <img src="<?php echo base_url("assets/images/benfed.png"); ?>" />
            </div>
        </div>
        <div class="col-sm-10 navbarSectio">

            <div class="dropdown">
                <div class="dropbtn">
                    <a href="<?php echo site_url("dashboard"); ?>" style="color: white; text-decoration: none;"><i class="fa fa-home"></i> Home</a>
                </div>

            </div>
            <div class="dropdown">
                <div class="dropbtn">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    Master
                    <i class="fa fa-angle-down"></i>
                </div>
                <div class="dropdown-content">
                    <?php if ($this->session->userdata['loggedin']['user_type'] == "A" && $this->session->userdata['loggedin']['ho_flag'] == "Y") { ?>
                        <a href="<?php echo site_url('group'); ?>">Group</a>
                        <a href="<?php echo site_url('subgroup'); ?>">Sub Group</a>
                        <a href="<?php echo site_url('achead'); ?>">A/C Head</a>
                        <!-- <a href="<?php // echo site_url('paddys/add_new/f_district'); 
                                        ?>">District</a> -->
                    <?php } ?>
                </div>
            </div>

            <div class="dropdown">
                <div class="dropbtn">
                    <a href="<?php echo site_url("User_Login/logout") ?>" style="color: white; text-decoration: none;"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                </div>
            </div>
        </div>

    </nav>
    <section>