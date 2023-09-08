<style>
    td,th {
        padding: 5px;
    }
</style>
<script>
    function set_gr(id) {
        var pre_val = '';
        var pre_id = id - 1;
        if (id > 1) {
            pre_val = $('#acc_code_' + pre_id).val();
            if (pre_val == $('#acc_code_' + id).val()) {
                alert('A/C Head Can Not Be Same');
                $('#acc_code_' + id).val('');
                $('#gr_id_' + id).val('');
                $('#subgr_id_' + id).val('');
            } else {
                $.ajax({
                    type: "GET",
                    url: "<?php echo site_url('transaction/get_gr_dtls'); ?>",
                    data: {
                        ac_id: $('#acc_code_' + id).val()
                    },
                    dataType: 'html',
                    success: function(result) {
                        var result = $.parseJSON(result);
                        $('#benfedcode_' + id).val(result.benfed_ac_code);
                        $('#gr_id_' + id).val(result.gr_name);
                        $('#subgr_id_' + id).val(result.subgr_name);
                    }
                });
            }
        } else {
            $.ajax({
                type: "GET",
                url: "<?php echo site_url('transaction/get_gr_dtls'); ?>",
                data: {
                    ac_id: $('#acc_code_' + id).val()
                },
                dataType: 'html',
                success: function(result) {
                    var result = $.parseJSON(result);
                    $('#benfedcode_' + id).val(result.benfed_ac_code);
                    $('#gr_id_' + id).val(result.gr_name);
                    $('#subgr_id_' + id).val(result.subgr_name);
                    // console.log(result.gr_name);

                }
            });
        }
    }
    // var x = 1;
    $(document).ready(function() {
        var tot_amt = 0;
        $("#newrow").click(function() {
            if ($('#v_type').val() != '') {
                var tr_len = $('#vau_tab #add>tr').length;
                var x = tr_len + 1;
                $("#add").append('<tr class="mb-2"><td><select id="acc_code_' + x + '" name="acc_code[]" class="form-control acc_code select2" style="width: 80%;" onchange="set_gr(' + x + ')" required><option value="">Select</option>'
                +'<?php
                        foreach ($row as $value) {
                            echo "<option value='" . $value->sl_no . "'>" . $value->ac_name . "-". $value->benfed_ac_code ."</option>";
                        } ?>'+'</select></td>'+
                    '<td><input type="text" class="transparent_tag" id="benfedcode_'+ x +'" name="benfedcode_id[]" style="width: 100%;" readonly></td>'+
                    '<td><input type="text" class="transparent_tag" id="gr_id_' + x + '" name="gr_id[]" style="width: 100%;" readonly></td>' +
                    '<td><input type="text" class="transparent_tag" id="subgr_id_' + x + '" name="subgr_id[]" style="width: 100%;" readonly></td>' +
                    '<td><input type="text" class="form-control amount_cls" style="width: 100%; text-align: right;" id="amt" name="amount[]" oninput="validate(this)" required ></td>' +
                    '<td><input type = "text" id = "dc_flg" name = "dc_flg[]" class = "transparent_tag" style = "width: 100%; text-align: center;" value = "' + g_flg + '" readonly required ></td>' +
                    '<td><button type = "button" class = "btn btn-danger" id = "removeRow"> <i class = "fa fa-undo" aria-hidden = "true" > </i></button> </td></tr> ');
			  $( ".select2" ).select2();
            		 
            } else {
                alert('Please Select Voucher Type First');
                return false;
            }
        });

        $("#add").on('click', '#removeRow', function() {

            $(this).parent().parent().remove();

            $('.amount_cls').change();
        });

        $('#add').on("change", ".amount_cls", function() {

            $("#tot_amt").val('');
            var tot_amt = 0;
            $('.amount_cls').each(function() {
                tot_amt += +$(this).val();
            });
            $("#tot_amt").val(tot_amt.toFixed(2));

        });
    });
</script>

<div class="wraper">
    <div class="col-md-10 container form-wraper">

        <form method="POST" action="<?php echo site_url("transaction/save") ?>" onsubmit="return valid_data()">

            <div class="form-header">

                <h4>Cash Voucher</h4>

            </div>

            <div class="form-group row">

                <label for="voucher_dt" class="col-sm-2 col-form-label">Date:</label>

                <div class="col-sm-4">

                    <input type="date" name="voucher_dt" class="form-control smallinput_text transparent_tag" value="<?= date('Y-m-d') ?>" id="voucher_dt" />

                </div>

                <label for="voucher_mode" class="col-sm-1 col-form-label">Mode:</label>
                <div class="col-sm-1">
                    <input type="text" name="voucher_mode" value="CASH" class="transparent_tag" style="width:50px;" readonly />
                </div>

            </div>

            <div class="form-group row">

                <label for="voucher_type" class="col-sm-2 col-form-label">Voucher Type:</label>

                <div class="col-sm-4">

                    <select name="voucher_type" id="v_type" style="width: 100%;" onchange="set_dr_cr()" class="form-control" required>

                        <option value="">Select</option>
                        <option value="R">Cash Received</option>
                        <option value="P">Cash Payment</option>

                    </select>

                </div>

            </div>

            <div class="form-group row">

                <label for="acc_hd" class="col-sm-2 col-form-label">A/C Head:</label>

                <div class="col-sm-8">

                    <input type="text" name="acc_hd" class="transparent_tag" value="<?= $cash_head ?>" style="width: 200px; display:inline;" readonly />

                    <input type="text" id="dc" class="transparent_tag" name="dr_cr_flag" value="" style="display:inline;" readonly />

                </div>

            </div>

            <input type="hidden" name="topacc_cd" value="<?= $cash_code ?>" />

            <div class="form-group row">

                <label for="trans_dt" class="col-sm-2 col-form-label">Remarks:</label>

                <div class="col-sm-8">

                    <textarea class="form-control" name="remarks" required></textarea>

                </div>

            </div>
            <hr class="hr">
            <table id="vau_tab">
                <thead>
                    <tr>
                        <th style="width: 38%;">A/C Head</th>
                        <th style="width: 12%;">A/C Code</th>
                        <th width="12%">Group</th>
                        <th width="12%">Subgroup</th>
                        <th>Amount</th>
                        <th></th>
                        <th><button class="btn btn-success" type="button" id="newrow">
                                <i class="fa fa-arrow-circle-down" aria-hidden="true"></i></button>
                        </th>
                    </tr>
                </thead>
                <tbody id="add">
                    <tr class="mb-2">
                        <td>
                            <select id="acc_code_1" name="acc_code[]" class="form-control acc_code select2" style="width: 80%;" onchange="set_gr(1)" required>
                                <option value="">Select</option>
                                <?php
                                foreach ($row as $value) {
									
                                    echo "<option value=" . $value->sl_no . ">" . $value->ac_name . "-" . $value->benfed_ac_code . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td><input type="text" class="transparent_tag" id="benfedcode_1" name="benfedcode_id[]" style="width: 100%;" readonly></td>
                        <td><input type="text" class="transparent_tag" id="gr_id_1" name="gr_id[]" style="width: 100%;" readonly></td>
                        <td><input type="text" class="transparent_tag" id="subgr_id_1" name="subgr_id[]" style="width: 100%;" readonly></td>
                        <td><input type="text" class="form-control amount_cls" id="amt" name="amount[]" style="width: 100%; text-align: right;" oninput="validate(this)" required></td>
                        <td><input type="text" class="transparent_tag" id="dc_flg" name="dc_flg[]" style="width: 100%; text-align: center;" readonly required></td>
                    </tr>
                </tbody>
                <tr>
                    <td colspan="3" style="text-align:right;">
                        <strong>Total:</strong>
                        <input name="tot_amt" type="text" class="transparent_tag" id="tot_amt" style="text-align:left; color:#c1264d; font-size: 25px; width:35%;" readonly>
                    </td>
                </tr>

            </table>

            <div class="form-group row">

                <div class="col-sm-10">

                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-info" />

                </div>

            </div>

        </form>

    </div>

</div>

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
    })
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
        var start_session_year ='<?php echo START_SESSION_YEAR; ?>';
        var end_session_year ='<?php echo END_SESSION_YEAR; ?>';
		 $('#submit')
		var tot_amt = parseFloat($('#tot_amt').val());
        var voucher_type = document.getElementById('v_type').value;
        var voucher_dt   = $('#voucher_dt').val();
        
        if(new Date(voucher_dt) < new Date(start_session_year))
        {
            alert("Voucher date cannot be before Financial year");
            return false;  
        }
        if(new Date(voucher_dt) > new Date(end_session_year))
        {
            alert("Voucher date cannot be After Financial year");
            return false;  
        }
        if(voucher_type == 'R' ){
			
			if(tot_amt > parseFloat(199000)){
			alert("Amount can not be Greater than 199000");
            return false;
			}
		}
        if (voucher_type == '') {
            alert("Please Supply Voucher Type");
            return false;
        }
		if(voucher_type == 'R' ){
			
			if(tot_amt > parseFloat(199000)){
			alert("Amount can not be Greater than 199000");
            return false;
			}
		}
		if(voucher_type == 'P' ){
			
			if(tot_amt > parseFloat(10000)){
			alert("Amount can not be Greater than 10000");
            return false;
			}
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