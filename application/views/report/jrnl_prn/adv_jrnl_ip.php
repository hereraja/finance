<style>
table {
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid #dddddd;

    padding: 6px;

    font-size: 14px;
}

th {

    text-align: center;

}

tr:hover {background-color: #f5f5f5;}

</style>


    
    <div class="wraper">      

        <div class="col-md-6 container form-wraper">
    
            <form method="POST" id="form" action="<?php echo site_url("advjrnlr");?>" >
			<!--	 <form method="POST" id="form" action="<?php //echo site_url("report/advjrnlv");?>" >  -->

                <div class="form-header">
                
                    <h4>Input Dates</h4>
                
                </div>

                <div class="form-group row">

                    <label for="from_dt" class="col-sm-2 col-form-label">From Date:</label>

                    <div class="col-sm-6">

                        <input type="date"
                               name="from_date"
                               class="form-control required"
                               value="<?php echo date('Y-m-d');?>"
                        />  

                    </div>


                </div>

                <div class="form-group row">

                    <label for="to_date" class="col-sm-2 col-form-label">To Date:</label>

                    <div class="col-sm-6">

                        <input type="date"
                               name="to_date"
                               class="form-control required"
                               value="<?php echo date('Y-m-d');?>"
                        />  

                    </div>

                </div>

                <div class="form-group row">

                    <label for="to_date" class="col-sm-2 col-form-label">Type:</label>

                    <div class="col-sm-6">
						<select class="form-control"  name="voucher_type" required>
						   <option value="">Select</option>
						   <option value="PUR">Purchase</option>
						   <option value="A">Advance</option>
						   <option value="CRN">Credit note</option>
						   <option value="SL">Sale</option>
						   <option value="P">Payment</option>
						   <option value="R">Receive</option>
						   <option value="OTH">Other</option>
						   
						</select>

                    </div>

                </div> 

                <div class="form-group row">

                    <label for="to_date" class="col-sm-2 col-form-label">District:</label>

                    <div class="col-sm-6">
						<select class="form-control"  name="branch_id" required>
						   <option value="">Select</option>
						   <?php foreach($branch as $br){?>
						   <option value="<?=$br->id?>"><?=$br->branch_name?></option>
						   <?php } ?>

						   
						</select>

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