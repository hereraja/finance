<div class="daseboard_home">
    <div class="col-sm-3 float-left">
    <div class="left_bar">
    <h2>MIS  <i class="fa fa-link" aria-hidden="true"></i></h2>
<?php if( $this->session->userdata['loggedin']['ho_flag'] == "N" ) { ?>
    <ul>
  <!--   <li><a href="<?php echo site_url('paddys/transactions/f_workorder'); ?>">Work Order</a></li>
    <li><a href="<?php echo site_url('paddys/transactions/f_paddycollection'); ?>">Paddy Procurement</a></li>
    <li><a href="<?php echo site_url('paddys/transactions/f_received'); ?>">Paddy Received </a></li>
    <li> <a href="<?php echo site_url('paddys/transactions/f_doisseued');?>">DO Issue</a></li>
    <li><a href="<?php echo site_url('paddys/transactions/f_offered');?>">CMR offered</a></li>
    <li><a href="<?php echo site_url('paddys/transactions/f_delivery');?>">CMR Delivery</a></li>
    <li> <a href="<?php echo site_url('paddys/transactions/f_wqsc');?>">WQSC</a></li> -->
    </ul>
   <?php }else{ ?>
     
    <ul>
    <!-- <li><a href="<?php echo site_url('paddys/add_new/f_society'); ?>">Society</a></li>
    <li><a href="<?php echo site_url('paddys/add_new/f_mill'); ?>">Mill</a></li>
    <li><a href="<?php echo site_url('paddys/add_new/f_farmer'); ?>">Farmer</a></li>
    <li><a href="<?php echo site_url('report/socProcho'); ?>">Societywise Procurement</a></li>
    <li><a href="<?php echo site_url('report/millProcho'); ?>">Millwise Procurement</a></li>
    <li><a href="<?php echo site_url('report/chequestatus'); ?>">Cheque Status</a></li>
    <li><a href="<?php echo site_url('report/returncheque'); ?>">Return Cheque</a></li> -->
    </ul>

   <?php } ?>
    </div>
    </div>

    <div class="col-sm-9 float-left" style="z-index:-1;">
    <div class="daseboardNav"><a href="#">Dashboard</a>  /  Overview </div>

 <!--    <div class="row daseSmBoxMain">
		
    <div class="col-sm-4">
        <div class="daseSmBox">
            <div class="subBox">
                <div class="icon"><img src="<?php echo base_url('assets/images/box_a.png'); ?>"></div>
                <div class="value"><?php
                 // if($this->session->userdata['loggedin']['ho_flag']=="Y")
                 //                          {
                 //                     echo $tot_paddy_procurement_ho->tot_quantity; 
                 //                          }else{
                 //                         echo $tot_paddy_procurement->tot_quantity; 
                 //                       }
                ?> <strong>Qnt</strong></div>
            </div>
        <h3>Total Paddy Procurement</h3>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="daseSmBox">
            <div class="subBox">
                <div class="icon2"><img src="<?php echo base_url('assets/images/box_b.png'); ?>"></div>
                <div class="value"><strong>Qnt</strong></div>
            </div>
        <h3>Total No. of Cheques Issued</h3>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="daseSmBox">
            <div class="subBox">
                <div class="icon3"><img src="<?php echo base_url('assets/images/box_c.png'); ?>"></div>
               <div class="value"><strong>Qnt</strong></div>
            </div>
        <h3>Total Cheque Amount Rs.</h3>
        </div>
    </div>
			

    <div class="col-sm-4">
        <div class="daseSmBox">
            <div class="subBox">
                <div class="icon4"><img src="<?php echo base_url('assets/images/box_d.png'); ?>"></div>
               <div class="value"><strong>Qnt</strong></div>
            </div>
        <h3>Total Amount of cheque cleared</h3>
        </div>
    </div>
			
    <div class="col-sm-4">
        <div class="daseSmBox">
            <div class="subBox">
                <div class="icon5"><img src="<?php echo base_url('assets/images/box_e.png'); ?>"></div>
                <div class="value"> <strong>Qnt</strong></div>
            </div>
        <h3>Total CMR offered</h3>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="daseSmBox">
            <div class="subBox">
                <div class="icon6"><img src="<?php echo base_url('assets/images/box_f.png'); ?>"></div>
                <div class="value"> <strong>Qnt</strong></div>
            </div>
        <h3>Total CMR Delivered</h3>
        </div>
    </div>


    </div> -->

    </div>

</div>

<script>
    var myIndex = 0;
    carousel();

    function carousel() {
        var i;
        var x = document.getElementsByClassName("mySlides");
        for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";  
        }
        myIndex++;
        if (myIndex > x.length) {myIndex = 1}    
        x[myIndex-1].style.display = "block";  
        setTimeout(carousel, 3000); // Change image every 2 seconds
    }
</script>