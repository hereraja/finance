<div class="">
<!-- <div class="daseboard_home"> -->

<div class="daseboard_home_newAdmin">

      <div class="fullWidthBotomPading">

    <div class="col-sm-3 float-left">
        <div class="left_bar">
            <h2>Quick Links <i class="fa fa-link" aria-hidden="true"></i></h2>

           
               <ul>

               <?php  //if($this->session->userdata['loggedin']['user_type']=="A"){ ?>
                    <li><a href="<?php echo site_url('cashVoucher'); ?>">Cash Voucher</a></li>
                    <li><a href="<?php echo site_url('bankVoucher'); ?>">Bank Voucher</a></li>
                    <li><a href="<?php echo site_url('jurnalVoucher'); ?>">Journal Voucher </a></li>
                    <li> <a href="<?php echo site_url('cheqdtl'); ?>">Cheque Entry</a></li>
                    <li> <a href="<?php echo site_url('advjrnlr'); ?>">Print Voucher</a></li>

                    <?php //}
                    if($this->session->userdata['loggedin']['user_type']=="A"||$this->session->userdata['loggedin']['user_type']=="M"||$this->session->userdata['loggedin']['user_type']=="D"||$this->session->userdata['loggedin']['user_type']=="S"||$this->session->userdata['loggedin']['user_type']=="C" ){ ?>
                        <li><a href="<?php echo site_url('mnthend'); ?>">Month End</a></li>
                        <li><a href="<?php echo site_url('purchasevu'); ?>">Unapproved Voucher</a></li>
                    <?php } ?>

                    <li><a href="<?php echo site_url('cashbook'); ?>">Cash Book</a></li>
                    <li><a href="<?php echo site_url('bankbook'); ?>">Bank Book</a></li>
                    <!-- <li> <a href="<?php echo site_url('bankbook'); ?>">Cheque Entry</a></li> -->
                    <li><a href="<?php echo site_url('ac_detail'); ?>">Account Detail</a></li>
                    
                </ul>
            <?php // } else { ?>

               

            <?php // } ?>
        </div>
    </div>




    <div class="col-sm-9 float-left rightSideSec">
          <div class="row">
            <div class="threeBoxNewmain">
              <div class="col-sm-4 float-left">
                <div class="threeBoxNewSmall">
                  <!-- <div class="value"><strong>&#2352;</strong>
              </div> -->
                  <div class="threeBoxImg darkBlue"><img src="http://localhost/benfed/benfed_fertilizer/assets/images/boxIcon_a.png" alt=""></div>
                  <div class="threeBoxTxt">
                    <h2>Approved voucher of the day</h2>
                    <p class="price"><span class="mt">
                        0                        <strong>MT</strong></span>

                      <span class="lit">
                        0                        <strong>L</strong>
                      </span>
                    </p>
                  </div>
                </div>
              </div>



              <div class="col-sm-4 float-left">
                <div class="threeBoxNewSmall">
                  <div class="threeBoxImg yellowCol"><img src="http://localhost/benfed/benfed_fertilizer/assets/images/boxIcon_b.png" alt=""></div>
                  <div class="threeBoxTxt">
                    <h2>Unapproved voucher of the day</h2>
                    <p class="price"><span class="mt">0<strong>MT</strong></span>
                      <span class="lit"> <strong>L</strong></span>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 float-left">
                <div class="threeBoxNewSmall">
                  <div class="threeBoxImg yellowCol"><img src="http://localhost/benfed/benfed_fertilizer/assets/images/boxIcon_collec.png" alt="">
                  </div>
                  <div class="threeBoxTxt">
                    <h2>Voucher on hold for the Day</h2>
                    <p class="price">
                      <span class="lit"><strong><i class="fa fa-inr" aria-hidden="true"></i> </strong>0.00</span>
                    </p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>




    

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
        if (myIndex > x.length) {
            myIndex = 1
        }
        x[myIndex - 1].style.display = "block";
        setTimeout(carousel, 3000); // Change image every 2 seconds
    }
</script>