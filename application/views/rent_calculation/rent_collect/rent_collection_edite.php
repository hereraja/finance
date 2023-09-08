<div class="wraper">
    <div class="col-md-10 container form-wraper">
    <?php foreach ($listData as $rntcledite) { ?>
        <form method="POST" action="<?php echo site_url("collectRent/edit/".$rntcledite->trans_no);?> " onsubmit="return valid_data()">
        <input type="hidden" name="accherd" value="<?php echo $rntcledite->acchead; ?>">
        <input type="hidden" name="invoice_no" value="<?php echo $rntcledite->invoice_no; ?>">
            <div class="form-header">
                <h4>Collect Rent</h4>
            </div>
            <div class="form-group row">
                <label for="ac_type" class="col-sm-2 col-form-label">Invoice Date:</label>
                <div class="col-sm-4">
                    <input type="date" value="<?php echo $rntcledite->trans_dt;  ?>" class="form-control" id="gr_name"
                        name="effectiveDate" readonly required />
                </div>

                <label for="trans_dt" class="col-sm-2 col-form-label">Transaction Date:</label>
                <div class="col-sm-4">

                <input type="date" value="<?php echo date("Y-m-d");  ?>" class="form-control"  readonly required />
                </div>
            </div>
            <div class="form-group row">
                <label for="ac_type" class="col-sm-2 col-form-label">Product:</label>
                <div class="col-sm-4">
                <?php //print_r($rent_product); ?>
                        <select class="form-control" id="product" name="product" required disabled>
                        <option value=''>Select</option>
                        <?php foreach ($rent_product as $rp) { ?>
                            <option value="<?php echo $rp->sl_no; ?>" <?php if($rntcledite->prod_id==$rp->sl_no){echo 'selected'; } ?>><?php echo $rp->product_desc; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="voucher_mode" class="col-sm-2 col-form-label">Customer:</label>

                <div class="col-sm-4">
                    <select class="form-control" id="ac_type" name="customer" required disabled>
                        <option value=''>Select</option>
                        <?php foreach ($customer as $cm) { ?>
                            <option value="<?php echo $cm->id; ?>" <?php if($rntcledite->cust_id==$cm->id){echo 'selected'; } ?>><?php echo $cm->cust_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <label for="trans_dt" class="col-sm-2 col-form-label">Godown:</label>
                <div class="col-sm-4">

                    <select class="form-control" id="godown" name="godown" required disabled>
                        <option value=''>Select</option>
                        <?php foreach ($godown as $gd) { ?>
                            <option value="<?php echo $gd->id; ?>" <?php if($rntcledite->godown_id==$gd->id){echo 'selected'; } ?>><?php echo $gd->gdn_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>


            <div class="form-group row">
                <label for="trans_dt" class="col-sm-2 col-form-label">Amount:</label>
                <div class="col-sm-4">
                    <input type="text" name="amount" id="amount" value="<?php echo $rntcledite->taxable_amt;  ?>" class="form-control" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label for="trans_dt" class="col-sm-2 col-form-label" >CGST : <span id="cgstp"><?php echo $rntcledite->cgst_rt;  ?></span> % </label>
                <div class="col-sm-4">
                    <input type="text" name="cgst" id="cgst" class="form-control cgst" value="<?php echo $rntcledite->cgst_amt;  ?>" readonly>
                    <input type="hidden" name="cgst_rt" id="cgst_rt" class="form-control cgst_rt" value="<?php echo $rntcledite->cgst_rt;  ?>">
                </div>
                <label for="voucher_mode" class="col-sm-2 col-form-label">SGST:  <span id="sgstp"><?php echo $rntcledite->sgst_rt;  ?></span> %</label>
                <div class="col-sm-4">
                    <input type="text" name="sgst" id="sgst" class="form-control sgst" readonly value="<?php echo $rntcledite->sgst_amt;  ?>">
                    <input type="hidden" name="sgst_rt" id="sgst_rt" class="form-control sgst_rt" value="<?php echo $rntcledite->sgst_rt;  ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="trans_dt" class="col-sm-2 col-form-label">Total Amount:</label>
                <div class="col-sm-4">
                    <input type="text" name="totalAmount" id="totalAmount" class="form-control totalAmount" readonly value="<?php echo $rntcledite->total_amt;  ?>">
                </div>
            </div>

            <div class="form-group row">

                <label for="remarks" class="col-sm-2 col-form-label">Remarks:</label>

                <div class="col-sm-10"><grammarly-extension data-grammarly-shadow-root="true" style="position: absolute; top: 0px; left: 0px; pointer-events: none;" class="cGcvT"></grammarly-extension><grammarly-extension data-grammarly-shadow-root="true" style="mix-blend-mode: darken; position: absolute; top: 0px; left: 0px; pointer-events: none;" class="cGcvT"></grammarly-extension>

                    <textarea class="form-control" name="remarks" required spellcheck="false"></textarea>

                </div>

            </div>


            <div class="form-group row">
                <label for="voucher_mode" class="col-sm-2 col-form-label">Mode:</label>

                <div class="col-sm-4">
                    <select class="form-control" id="mode" name="mode" required>
                    <option value=''>Select</option>
                        <option value='B'>BANK</option>
                        <option value='C' >Cash</option>
                    </select>
                </div>
                <label for="voucher_mode" class="col-sm-2 col-form-label transaction_type">Transaction Type:</label>

                <div class="col-sm-4 transaction_type" id="transaction_type">
                    <select class="form-control" id="transactionType" name="transactionType" >
                    <option value=''>Transaction type</option>
                        <option value='NEFT'>NEFT</option>
                        <option value='RTGS'>RTGS</option>
                        <option value='IMPS'>IMPS</option>
                        <option value='CHEQUE' >CHEQUE</option>
                    </select>
                </div>
            </div>
            <?php //if($rntcledite->trans_type=='B'){ ?>
            <div class="form-group row" id="bank_section">
                <label for="voucher_mode" class="col-sm-2 col-form-label">Credit Bank:</label>
                <div class="col-sm-10">
                    <select class="form-control select2" id="crBank" name="crBank" >
                        <option value=''>Select bank &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</option>
                        <?php foreach ($bank as $bnk) { ?>
                            <option value='<?php echo $bnk->sl_no; ?>' <?php if($rntcledite->cr_bnk==$bnk->sl_no){echo 'selected'; }?>><?php echo $bnk->ac_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group row transaction_type" id="1rf">
                <label for="trans_dt" class="col-sm-2 col-form-label">Reference Date:</label>
                <div class="col-sm-4">
                    <input type="date" name="rfDate" id="rfDate" class="form-control rfDate" value="<?php echo $rntcledite->rf_date; ?>" >
                </div>
                <label for="voucher_mode" class="col-sm-2 col-form-label">Reference No:</label>
                <div class="col-sm-4">
                    <input type="text" name="rfNo" id="rfNo" class="form-control rfNo"  value="<?php echo $rntcledite->rf_no; ?>">
                </div>
            </div>
<?php //} ?>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input type="submit" id="submit" class="btn btn-info submit" value="Save" />
                </div>
            </div>
        </form>
        <?php } ?>
    </div>
</div>
<?php  //print_r($this->session->userdata); ?>
<script>
    // $(".select_2").select2();
    $("#crBank").select2();
</script>
<script>
    $(document).ready(function() {
        $(".select_2").select2();
    $('#bank_section').hide();
    $('#rf').hide();
    $('.transaction_type').hide();
    $('#mode').change(function(){
        let mode=$(this).val();
        if(mode=='B'){
            $("#rfNo").attr("required", true);
            $("#rfDate").attr("required", true);
            $("#crBank").attr("required", true);
            $("#transactionType").attr("required", true);
        $('#bank_section').show();
        $('#rf').show();
        $('.transaction_type').show();
        }else{
            $("#rfNo").attr("required", false);
            $("#rfDate").attr("required", false);
            $("#crBank").attr("required", false);
            $("#transactionType").attr("required", false);

            $('#bank_section').hide(); 
            $('#rf').hide();
    $('.transaction_type').hide();
        }
    });


    $('#amount').keyup(function(){
        var amount=$(this).val();
        var cgst=((amount/100)*9);
        var sgst=((amount/100)*9);
        var totalamt=(cgst + sgst + parseFloat(amount));
        $('#cgst').val(parseFloat(cgst).toFixed('2'));
        $('#sgst').val(parseFloat(sgst).toFixed('2'));
        $('#totalAmount').val(parseFloat(totalamt).toFixed('2'));
    });

    function totalvalue(data){
        var cgst_rt=$('#cgst_rt').val();
        var sgst_rt =$('#sgst_rt').val();
        var amount=data;
        var cgst=((amount/100)*cgst_rt);
        var sgst=((amount/100)*sgst_rt);
        var totalamt=(cgst + sgst + parseFloat(amount));
        $('#cgst').val(parseFloat(cgst).toFixed('2'));
        $('#sgst').val(parseFloat(sgst).toFixed('2'));
        $('#totalAmount').val(parseFloat(totalamt).toFixed('2'));
    }

    $('#product').change(function(){

        var product_id=$(this).val();
        $.ajax({
            url: "<?php echo site_url().'/rent_collection/fetch_product'; ?>",
            type: 'POST',
            data: {product_id:product_id},
            dataType: "json",
            success: function(data) {
                $('#cgstp').html(data.cgst_rt);
                $('#sgstp').html(data.sgst_rt);
                $('#cgst_rt').val(data.htm_cgst_rt);
                $('#sgst_rt').val(data.htm_sgst_rt);
            }
        });

    });
    $('#product').change(function(){

        var product_id=$(this).val();
        $.ajax({
            url: "<?php echo site_url().'/rent_collection/fetch_product'; ?>",
            type: 'POST',
            data: {product_id:product_id},
            dataType: "json",
            success: function(data) {
                $('#cgstp').html(data.cgst_rt);
                $('#sgstp').html(data.sgst_rt);
                $('#cgst_rt').val(data.htm_cgst_rt);
                $('#sgst_rt').val(data.htm_sgst_rt);
            }
        });

    });

    

    $('#godown').change(function(){
        var godown_id=$(this).val();
        var cust_id=$('#ac_type').val();
        $.ajax({
            url: "<?php echo site_url().'/rent_collection/fetch_amount'; ?>",
            type: 'POST',
            data: {godown_id:godown_id,cust_id:cust_id},
            dataType: "json",
            success: function(data) {
               $('#amount').val(data);
               totalvalue(data);
            }
        });

        $('#ac_type').change(function(){
        var customer=$(this).val();
        $.ajax({
            url: "<?php echo site_url().'/rent_collection/fetch_godown'; ?>",
            type: 'POST',
            data: {customer:customer},
            dataType: "json",
            success: function(data) {
                $('#godown').html(data);
            }
        });
    });

    });
});
</script>

