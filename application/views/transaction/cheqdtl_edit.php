<div class="wraper">

    <div class="col-md-9 container form-wraper">

        <form method="POST" action="<?php echo site_url("transaction/cheqdtledit") ?>" onsubmit="return valid_data()">

            <div class="form-header">
                <h4>Cheque Detail Edit</h4>
            </div>
            <input type="hidden" name="id" class="form-control" value="<?php if(isset($cheqdtl->id)) echo $cheqdtl->id;  ?>"/>
            <div class="form-group row">
                <label for="voucher_mode" class="col-sm-2 col-form-label">Society:</label>
                <div class="col-sm-4">
                    <select name="soc_id" class="form-control select2" disabled>
                        <option value="">Select</option>
                        <?php
                        $selected = '';
                        foreach ($row as $value) {
                            if($value->soc_id == $cheqdtl->soc_id) { $selected = 'selected' ;}
                            echo "<option value='" . $value->soc_id . "' $selected   >" . $value->soc_name . "</option>";
                            $selected = '';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="cheq_no" class="col-sm-2 col-form-label">Cheque No:</label>
                <div class="col-sm-4">
                    <input type="text" name="cheq_no" class="form-control smallinput_text" 
                    value="<?php if(isset($cheqdtl->cheq_no)) echo $cheqdtl->cheq_no;  ?>"  readonly />
                </div>

                <label for="cheq_dt" class="col-sm-2 col-form-label">Cheque Date:</label>
                <div class="col-sm-4">
                    <input type="date" name="cheq_dt" value="<?php if(isset($cheqdtl->cheq_dt)) echo $cheqdtl->cheq_dt;  ?>" class="form-control"  readonly/>
                </div>

            </div>

            <div class="form-group row">
                <label for="amt" class="col-sm-2 col-form-label">Amount:</label>
                <div class="col-sm-4">
                    <input type="text" name="amt" class="form-control" value="<?php if(isset($cheqdtl->amt)) echo $cheqdtl->amt;  ?>"  readonly />
                </div>
                <label for="bank_name" class="col-sm-2 col-form-label">Bank:</label>
                <div class="col-sm-4">
                    <input type="text" name="bank_name" class="form-control" value="<?php if(isset($cheqdtl->bank_name)) echo $cheqdtl->bank_name;  ?>"  readonly />
                </div>
            </div>
            <div class="form-group row">
                <label for="clear_dt" class="col-sm-2 col-form-label">Clearing Date:</label>
                <div class="col-sm-4">
                    <input type="date" name="clear_dt" class="form-control" value="<?php if(isset($cheqdtl->clear_dt)) echo $cheqdtl->clear_dt;  ?>"  required />
                </div>
            </div>

            <div class="form-group row">

                <label for="remarks" class="col-sm-2 col-form-label">Remarks:</label>

                <div class="col-sm-10">

                    <textarea class="form-control" name="remarks" required><?php if(isset($cheqdtl->remarks)) echo $cheqdtl->remarks;  ?></textarea>

                </div>

            </div>
            
            <div class="form-group row">

                <div class="col-sm-10">

                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-info" />

                </div>

            </div>

        </form>

    </div>

</div>

<script>
    $(".select_2").select2();
</script>
<script>
    $('#submit').on('click', function(e) {
        $('input[name^=amount]').map(function(idx, elem) {
            if ($(elem).val() > 0) {} else {
                e.preventDefault();
                alert('Amount Can Not Be 0');
                return false;
            }
            // console.log();
        })
    });
</script>
<script>
    var g_flg;

    function set_dr_cr() {
        var flag;

        if (document.getElementById('v_type').value == 'R') {
            flag = 'Debit';
            g_flg = 'Credit';
        } else if (document.getElementById('v_type').value == 'P') {
            flag = 'Credit';
            g_flg = 'Debit';
        } else {
            flag = '';
            g_flg = '';
        }

        document.getElementById('dc').value = flag;
        document.getElementById('dc_flg').value = g_flg;
    }


    function valid_data() {
        var voucher_type = document.getElementById('v_type').value;
        if (voucher_type == '0') {
            alert("Please Supply Voucher Type");
            return false;
        }

        var dc_flag = document.getElementById('dc').value;
        if (dc_flag.trim() == '') {
            alert("Invalid Input");
            return false;
        }

        var dr_cr = document.getelementById('dc_flg').value;
        if (dr_cr.trim() == '') {
            alert("Invalid Input");
            return false;
        }

    }
</script>