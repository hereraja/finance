<div class="wraper">
    <div class="col-md-8 container form-wraper">
        <form method="POST" action="<?php echo site_url("handling-trandport-charges/customar_htc_entry");?> " onsubmit="return valid_data()">
            <div class="form-header">
                <h4>Handling & transport charges</h4>
            </div>
            <div class="form-group row">
                <label for="ac_type" class="col-sm-2 col-form-label">Effective Date:</label>
                <div class="col-sm-4">
                    <input type="date" value="<?php echo date('Y-m-d');?>" class="form-control" id="gr_name" name="effectiveDate" readonly required />
                </div>
            </div>
            <div class="form-group row">
                <!-- <label for="trans_dt" class="col-sm-2 col-form-label">Godown:</label> -->
                
                <label for="voucher_mode" class="col-sm-2 col-form-label">Customer:</label>
                <div class="col-sm-4">
                <select class="form-control" id="ac_type" name="customer" required>
                        <option value=''>Select</option>
                        <?php foreach ($customer as $cm) { ?>
                        <option value="<?php echo $cm->id; ?>"><?php echo $cm->cust_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="trans_dt" class="col-sm-2 col-form-label">From date:</label>
                <div class="col-sm-4">
                    <input type="date" name="startDate" id="startDate" class="form-control startDate" required>
                </div>
                <label for="voucher_mode" class="col-sm-2 col-form-label">To date:</label>
                <div class="col-sm-4">
                    <input type="date" name="endDate" id="endDate" class="form-control endDate" required>
                </div>
            </div>
            <!-- <div class="form-group row">
                <label for="trans_dt" class="col-sm-2 col-form-label">CGST</label>
                <div class="col-sm-4">
                    <input type="text" name="cgst" id="chst" class="form-control startDate">
                </div>
                <label for="voucher_mode" class="col-sm-2 col-form-label">SGST:</label>
                <div class="col-sm-4">
                    <input type="text" name="sgst" id="sgst" class="form-control endDate">
                </div>
            </div> -->
<!-- 
            <div class="form-group row">
                <label for="trans_dt" class="col-sm-2 col-form-label">CGST Rate:</label>
                <div class="col-sm-4">
                    <input type="text" name="cgst" class="form-control smallinput_text">
                </div>
                <label for="voucher_mode" class="col-sm-2 col-form-label">SGST Rate:</label>
                <div class="col-sm-4">
                    <input type="text" name="sgst" class="form-control smallinput_text">
                </div>
            </div> -->
            <div class="form-group row">
                <label for="trans_dt" class="col-sm-2 col-form-label">Amount:</label>
                <div class="col-sm-4">
                    <input type="text" name="amount" id="amount" class="form-control smallinput_text amount">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <input type="submit" id="submit" class="btn btn-info submit" value="Save" />
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $('form').on('#submit', function() {
        
        var amount=$('#amount').val();
     if(amount>0){
        return true;
     }else{
        return false;
     }
});



$('#submit').click(function() {
    var am = $('#amount').val();
        
          if(am > 0){ 
            return true;
          }else{
            alert('invalid amount'); 
            return false;
          } 
            
});

$('#submit').click(function() {
    var sd = $('#startDate').val();
    var ed = $('#endDate').val();
        
          if(sd < ed){
            return true;
          }else{
            alert('end date should be greater than start date'); 
            return false;
          } 
            
});
</script>