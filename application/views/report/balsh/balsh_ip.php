    <div class="wraper">      

        <div class="col-md-6 container form-wraper">
    
            <form method="POST" id="form" action="<?php echo site_url("balsh");?>" >

                <div class="form-header">
                    <h4>Input Dates</h4>
                
                </div>

                <div class="form-group row">
                <?php $fyear=$this->session->userdata['loggedin']['fin_yr']; $year=explode('-',$fyear) ?>
                    <label for="from_dt" class="col-sm-2 col-form-label">From Date:</label>

                    <div class="col-sm-6">
                        <input type="date"
                               name="from_date"
                               class="form-control required" min='<?=$year[0]?>-04-01' max="<?= $year[0]+1?>-03-31"
                               value="<?=$year[0]?>-04-01"/>  
                    </div>
                </div>

                <div class="form-group row">
                    <label for="to_date" class="col-sm-2 col-form-label">To Date:</label>
                    <div class="col-sm-6">
                        <input type="date"
                               name="to_date"
                               class="form-control required"
                               value="<?=$year[0]+1?>-03-31" min='<?=$year[0]?>-04-01' max="<?= $year[0]+1?>-03-31"/>  
                    </div>
                </div>
               
                <div class="form-group row">
                    <div class="col-sm-10">
                        <input type="submit" class="btn btn-info" value="Submit" />
                    </div>
                </div>
            </form>    
        </div>
    </div>