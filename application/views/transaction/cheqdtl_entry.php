<div class="wraper">

    <div class="col-md-9 container form-wraper">

        <form method="POST" action="<?php echo site_url("transaction/cheqdtlsave") ?>" onsubmit="return valid_data()">

            <div class="form-header">
                <h4>Cheque Detail Add</h4>
            </div>

            <div class="form-group row">
                <label for="voucher_mode" class="col-sm-2 col-form-label">Society:</label>
                <div class="col-sm-4">
                    <select name="soc_id" class="form-control select2" required>
                        <option value="">Select</option>
                        <?php
                        foreach ($row as $value) {
                            echo "<option value='" . $value->soc_id . "'>" . $value->soc_name . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="cheq_no" class="col-sm-2 col-form-label">Cheque No:</label>
                <div class="col-sm-4">
                    <input type="text" name="cheq_no" class="form-control smallinput_text" value=""  required />
                </div>

                <label for="cheq_dt" class="col-sm-2 col-form-label">Cheque Date:</label>
                <div class="col-sm-4">
                    <input type="date" name="cheq_dt" value="<?= date('Y-m-d') ?>" class="form-control"  required/>
                </div>

            </div>

            <div class="form-group row">
                <label for="amt" class="col-sm-2 col-form-label">Amount:</label>
                <div class="col-sm-4">
                    <input type="text" name="amt" class="form-control" value=""  required />
                </div>
                <label for="bank_name" class="col-sm-2 col-form-label">Bank:</label>
                <div class="col-sm-4">
                    <input type="text" name="bank_name" class="form-control" value=""  required />
                </div>
            </div>

            <div class="form-group row">

                <label for="remarks" class="col-sm-2 col-form-label">Remarks:</label>

                <div class="col-sm-10">

                    <textarea class="form-control" name="remarks" required></textarea>

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