<style>
    td,
    th {
        padding: 5px;
    }
</style>
<script>
    function set_gr(id) {
        var pre_val = '';
        var pre_id = id - 1;
        $.ajax({
            type: "GET",
            url: "<?php echo site_url('transaction/get_gr_dtls'); ?>",
            data: {
                ac_id: $('#acc_code_' + id).val()
            },
            dataType: 'html',
            success: function(result) {
                var result = $.parseJSON(result);
                if (id > 1) {
                    pre_val = $('#acc_code_' + pre_id).val();
                    if (pre_val == $('#acc_code_' + id).val()) {
                        alert('A/C Head Can Not Be Same');
                        $('#acc_code_' + id).val('');
                        $('#gr_id_' + id).val('');
                        $('#subgr_id_' + id).val('');

                        $('#gr_id_' + id).attr("title",'');
                        $('#subgr_id_' + id).attr("title",'');
                    } else {
                        $('#benfedcode_' + id).val(result.benfed_ac_code);
                        $('#gr_id_' + id).val(result.gr_name);
                        $('#subgr_id_' + id).val(result.subgr_name);

                        $('#benfedcode_' + id).attr("title",result.benfed_ac_code);
                        $('#gr_id_' + id).attr("title",result.gr_name);
                        $('#subgr_id_' + id).attr("title",result.subgr_name);
                        // console.log(result.gr_name);
                    }
                } else {
                    $('#benfedcode_' + id).val(result.benfed_ac_code);
                    $('#gr_id_' + id).val(result.gr_name);
                    $('#subgr_id_' + id).val(result.subgr_name);

                    $('#benfedcode_' + id).attr("title",result.benfed_ac_code);
                    $('#gr_id_' + id).attr("title",result.gr_name);
                    $('#subgr_id_' + id).attr("title",result.subgr_name);
                }
            }
        });
    }


    function set_grDebit(id) {
        var pre_val = '';
        var pre_id = id - 1;
        $.ajax({
            type: "GET",
            url: "<?php echo site_url('transaction/get_gr_dtls'); ?>",
            data: {
                ac_id: $('#acc_code_Debit_' + id).val()
            },
            dataType: 'html',
            success: function(result) {
                var result = $.parseJSON(result);
                if (id > 1) {
                    pre_val = $('#acc_code_Debit_' + pre_id).val();
                    if (pre_val == $('#acc_code_Debit_' + id).val()) {
                        alert('A/C Head Can Not Be Same');
                        $('#acc_code_Debit_' + id).val('');
                        $('#gr_id_Debit_' + id).val('');
                        $('#subgr_id_Debit_' + id).val('');

                        $('#gr_id_Debit_' + id).attr("title",'');
                        $('#subgr_id_Debit_' + id).attr("title",'');
                    } else {
                        $('#benfedcode_Debit_' + id).val(result.benfed_ac_code);
                        $('#benfedcode_Debit_' + id).attr("title",result.benfed_ac_code);
                        $('#gr_id_Debit_' + id).val(result.gr_name);
                        $('#subgr_id_Debit_' + id).val(result.subgr_name);
                        $('#gr_id_Debit_' + id).attr("title",result.gr_name);
                        $('#subgr_id_Debit_' + id).attr("title",result.subgr_name);
                        // console.log(result.gr_name);
                    }
                } else {
                    $('#benfedcode_Debit_' + id).val(result.benfed_ac_code);
                    $('#benfedcode_Debit_' + id).attr("title",result.benfed_ac_code);
                    $('#gr_id_Debit_' + id).val(result.gr_name);
                    $('#subgr_id_Debit_' + id).val(result.subgr_name);
                    $('#gr_id_Debit_' + id).attr("title",result.gr_name);
                    $('#subgr_id_Debit_' + id).attr("title",result.subgr_name);
                }
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        var tot_amt = 0;
        $("#newrow").click(function() {
            if ($('#v_type').val() != '') {
                var tr_len = $('#vau_tab #add>tr').length;
                var x = tr_len + 1;

                $("#add").append('<tr class="mb-2"><td><select id="acc_code_' + x + '" name="acc_code[]" class="form-control acc_code select2 creditAcoCode" style="width: 80%;" onchange="set_gr(' + x + ')" required><option value="">Select</option>' +
                    "<?php
                        foreach ($row as $value) {
							   
                            echo "<option value='" . $value->sl_no . "'>" . $value->ac_name . "-". $value->benfed_ac_code ."</option>";
							 
                        }
                        ?>" + '</select></td>' + '<td><input type="text" class="transparent_tag" id="benfedcode_'+ x +'" name="benfedcode_id[]" style="width: 100%;" readonly></td>'+ '<td><input type="text" class="transparent_tag" id="gr_id_' + x + '" name="gr_id[]" style="width: 100%;" readonly></td>' + '<td><input type="text" class="transparent_tag" id="subgr_id_' + x + '" name="subgr_id[]" style="width: 100%;" readonly></td>' + '<td><input type="text" class="form-control amount_cls" style="width: 100%; text-align: right;" id="amt" name="amount[]" oninput="validate(this)" required ></td>' + '<td><h5>Credit</h5><input type = "hidden" id = "dc_flg" name = "dc_flg[]" class = "transparent_tag" style = "width: 100%; text-align: center;" value = "Credit" readonly required ></td>' + '<td><button type = "button" class = "btn btn-danger" id = "removeRow"> <i class = "fa fa-undo" aria-hidden = "true" > </i></button> </td></tr> ');
			  $( ".select2" ).select2();

            } else {
                alert('Please Select Voucher Type First');
                return false;
            }
        });
        // $("#newrow").click(function() {
        //     if ($('#v_type').val() != '') {
        //         var tr_len = $('#vau_tab #add>tr').length;
        //         var x = tr_len + 1;
        //         $("#add").append('<tr><td>' +
        //             '<select id= "acc_code_' + x + '" class="form-control select_2" name="acc_code[]" class="input_text" style="width: 80%;" onchange="set_gr(' + x + ')" required>' +
        //             '<option value="">Select</option>' +
        //              "<?php
        //                 foreach ($row as $value) {
        //                     echo "<option value='" . $value->sl_no . "'>'" . $value->ac_name . "'</option>";
        //                 }
        //                 ?>" +
        //             '</select></td>' +'<td><input type="text" class="transparent_tag" id="gr_id_' + x + '" name="gr_id[]" style="width: 100%;" readonly></td>' +
        //             '<td><input type="text" class="transparent_tag" id="subgr_id_' + x + '" name="subgr_id[]" style="width: 100%;" readonly></td>' +
        //             '<td><input type="text" class="form-control amount_cls" style="width: 100%; text-align: right;" id="amt" name="amount[]" oninput="validate(this)" required></td>' +
        //             '<td><input type="text" id="dc_flg" name="dc_flg[]" class="transparent_tag" style="width: 100%; text-align: center;" value="' + g_flg + '" readonly></td>' +
        //             '<td><button type="button" class="btn btn-danger" id="removeRow"><i class="fa fa-undo" aria-hidden="true"></i></button></td></tr>');
        //         $(".select_2").select2();
        //         //$('.preferenceSelect').change();
        //     } else {
        //         alert('Please Select Voucher Type First');
        //         return false;
        //     }
        // });

        $("#add").on('click', '#removeRow', function() {
            $(this).parent().parent().remove();
            //$('.preferenceSelect').change();
            $('.amount_cls').change();
        });

        $("#debitadd").on('click', '#removeRow_Debit', function() {
            $(this).parent().parent().remove();
            //$('.preferenceSelect').change();
            $('.amount_cls_Debit').change();
        });

        $('#add').on("change", ".amount_cls", function() {
            $("#tot_amt").val('');
            var tot_amt = 0;
            $('.amount_cls').each(function() {
                tot_amt += +$(this).val();
            });
            $("#tot_amt").val(parseFloat(tot_amt).toFixed(2));
        });

        $('#debitadd').on("change", ".amount_cls_Debit", function() {
            $("#tot_amt_Debit").val('');
            var tot_amt = 0;
            $('.amount_cls_Debit').each(function() {
                tot_amt += +$(this).val();
            });
            $("#tot_amt_Debit").val(parseFloat(tot_amt).toFixed(2));
        });

        $('#submit').click(function() {
            var date = $('#date').val(),
                sys_date = $('#sys_date').val();
                tot_amt_Debit=$('#tot_amt_Debit').val();
                tot_amt=$('#tot_amt').val();

            if(tot_amt_Debit===tot_amt){
                if (new Date(date) > new Date(sys_date)) {
                    alert("Invalid Date");
                    return false;
                } else {
                    $('#submit').prop('type', 'submit');
                    return true;
                }
            }else{
                alert("Total Debit & Credit Amount mismatch");
                    return false;
            }
//             $(".select2-hidden-accessible").each(function(){
//     alert($(this).value());
//   });
        });

        
    });
</script>


<script>
    $(document).ready(function() {
        var tot_amt = 0;
        $("#debitnewrow").click(function() {
            if ($('#v_type').val() != '') {
                var tr_len = $('#debit_vau_tab #debitadd>tr').length;
                var x = tr_len + 1;
                

                $("#debitadd").append('<tr class="mb-2"><td><select id="acc_code_Debit_' + x + '" name="acc_code_Debit[]" class="form-control acc_code select2" style="width: 80%;" onchange="set_grDebit(' + x + ')" required><option value="">Select</option>' +
                    "<?php
                        foreach ($row as $value) {
							   
                            echo "<option value='" . $value->sl_no . "'>" . $value->ac_name . "-". $value->benfed_ac_code ."</option>";
							 
                        }
                        ?>" + '</select></td>' + '<td><input type="text" class="transparent_tag" id="benfedcode_Debit_'+ x +'" name="benfedcode_id_Debit[]" style="width: 100%;" readonly></td>'+ '<td><input type="text" class="transparent_tag" id="gr_id_Debit_' + x + '" name="gr_id_Debit[]" style="width: 100%;" readonly></td>' + '<td><input type="text" class="transparent_tag" id="subgr_id_Debit_' + x + '" name="subgr_id_Debit[]" style="width: 100%;" readonly></td>' + '<td><input type="text" class="form-control amount_cls_Debit" style="width: 100%; text-align: right;" id="amt" name="amount_Debit[]" oninput="validate(this)" required ></td>' + '<td><h5>Debit</h5><input type = "hidden" id = "dc_flg" name = "dc_flg_Debit[]" class = "transparent_tag" style = "width: 100%; text-align: center;" value = "Debit" readonly required ></td>' + '<td><button type = "button" class = "btn btn-danger" id = "removeRow_Debit"> <i class = "fa fa-undo" aria-hidden = "true" > </i></button> </td></tr> ');
			  $( ".select2" ).select2();

            } else {
                alert('Please Select Voucher Type First');
                return false;
            }
        });
    });
</script>

<div class="wraper">

    <div class="col-md-10 container form-wraper">

        <form method="POST" action="<?php echo site_url("transaction/jurnal_save") ?>" onsubmit="return valid_data()">

            <div class="form-header">

                <h4>Journal Voucher</h4>

            </div>

            <input type="hidden" id="sys_date" value="<?= date('Y-m-d') ?>">

            <div class="form-group row">

                <label for="trans_dt" class="col-sm-2 col-form-label">Date:</label>

                <div class="col-sm-4">

                    <input type="date" min="" name="voucher_dt" class="form-control mindate smallinput_text" value="<?php echo date('Y-m-d') ?>" id="date" required />

                </div>

                <label for="voucher_mode" class="col-sm-2 col-form-label">Mode:</label>

                <div class="col-sm-1">

                    <input type="text" name="voucher_mode" value="Journal" class="transparent_tag" style="width:50px;" readonly />

                </div>

            </div>
            <div class="form-group row">

<label for="remarks" class="col-sm-2 col-form-label">Remarks:</label>

<div class="col-sm-8">

    <textarea class="form-control" name="remarks" required></textarea>

</div>

</div>

<hr class="hr_divide">

            <table id="debit_vau_tab">
                <thead>
                    <tr>
                    <th style="width: 40%;">A/C Head</th>
                        <th style="width: 12%;">A/C Code</th>
                        <th width="12%">Group</th>
                        <th width="12%">Subgroup</th>
                        <th>Amount</th>
                        <th></th>
                        <th><button class="btn btn-success" type="button" id="debitnewrow"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></button></th>
                    
                    </tr>
                </thead>
                <tbody id="debitadd">
                    <tr>
                        <td><select class="form-control select2" id="acc_code_Debit_1" name="acc_code_Debit[]" class="input_text" style="width: 80%;" onchange="set_grDebit(1)" required>
                                <option value="">Select</option>
                                <?php
                                foreach ($row as $value) {
                                    echo "<option value=" . $value->sl_no . ">" . $value->ac_name . "-" . $value->benfed_ac_code . "</option>";
                                }
                                ?>
                            </select></td>
                        <td>
                            <input type="text" class="transparent_tag" id="benfedcode_Debit_1" name="benfedcode_id_Debit[]" title="" style="width: 100%;" readonly></td>  
                        <td>
                            <input type="text" title="" class="transparent_tag" id="gr_id_Debit_1" name="gr_id_Debit[]" style="width: 100%;" readonly></td>
                        <td>
                            <input type="text" title="" class="transparent_tag" id="subgr_id_Debit_1" name="subgr_id_Debit[]" style="width: 100%;" readonly></td>
                        <td>
                            <input type="text" class="form-control amount_cls_Debit" id="amt" name="amount_Debit[]" style="width: 100%; text-align: right;"  oninput="validate(this)"  required></td>
                        <!-- <td></td> -->
                        <td><h5>Debit</h5><input type="hidden" class="transparent_tag" id="" name="dc_flg_Debit[]" value="Debit" style="width: 100%; text-align: center;" readonly></td>
                    </tr>
                </tbody>
                <tr>
                    <td colspan="3" style="text-align:right;"><strong>Total:</strong> <input name="tot_amt_Debit" type="text" class="transparent_tag" id="tot_amt_Debit" style="text-align:left; color:#c1264d; font-size: 25px; width:35%;" readonly>
                    </td>
                    <td><h4>Debit</h4></td>
                </tr>
                

            </table>

            <!-- <div class="form-group row">
                <label for="voucher_type" class="col-sm-2 col-form-label">Voucher Type:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="voucher_type" id="v_type" onchange="set_dr_cr()" class="input_text" required>
                        <option value="">Select</option>
                        <option value="R">Received</option>
                        <option value="P">Payment</option>
                    </select>
                </div>
            </div> -->

            <!-- <div class="form-group row">

                <label for="acc_cd" class="col-sm-2 col-form-label">A/C Head:</label>

                <div class="col-sm-4">

                    <select name="acc_cd" class="form-control select2" required>
                        <option value="0">Select</option>
                        <?php
                        //foreach ($row as $value) {
                           // echo "<option value='" . $value->sl_no . "'>" . $value->ac_name . "</option>";
                       // }
                        ?>
                    </select>

                    

                </div>
				<div class="col-sm-1">
				    <span style="display: inline;">
                        <input type="text" id="dc" class="transparent_tag" name="dr_cr_flag" value="" readonly>
                    </span>
				</div>

            </div> -->

            <hr class="hr_divide">

            

            <table id="vau_tab">
                <thead>
                    <tr>
                        <th style="width: 40%;">A/C Head</th>
                        <th style="width: 12%;">A/C Code</th>
                        <th width="12%">Group</th>
                        <th width="12%">Subgroup</th>
                        <th>Amount</th>
                        <th></th>
                        <th><button class="btn btn-success" type="button" id="newrow"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></button></th>
                    </tr>
                </thead>
                <tbody id="add">
                    <tr>
                        <?php //print_r($row); ?>
                        <td><select class="form-control select2 creditAcoCode" id="acc_code_1" name="acc_code[]" class="input_text" style="width: 80%;" onchange="set_gr(1)" required>
                                <option value="">Select</option>
                                <?php
                                foreach ($row as $value) {
                                    echo "<option value=" . $value->sl_no . ">" . $value->ac_name . "-" . $value->benfed_ac_code . "</option>";
                                }
                                ?>
                            </select></td>
                        <td>
                            <input type="text" title="" class="transparent_tag" id="benfedcode_1" name="benfedcode_id[]" style="width: 100%;" readonly></td>  
                        <td>
                            <input type="text" title="" class="transparent_tag" id="gr_id_1" name="gr_id[]" style="width: 100%;" readonly></td>
                        <td>
                            <input type="text" class="transparent_tag" id="subgr_id_1" name="subgr_id[]" title="" style="width: 100%;" readonly></td>
                        <td><input type="text" class="form-control amount_cls" id="amt" name="amount[]" style="width: 100%; text-align: right;"  oninput="validate(this)"  required></td>
                        <!-- <td></td> -->
                        <td><h5>Credit</h5><input type="hidden" class="transparent_tag" id="dc_flg" name="dc_flg[]" value="Credit" style="width: 100%; text-align: center;" readonly></td>
                    </tr>
                </tbody>
                <tr>
                    <td colspan="3" style="text-align:right;"><strong>Total:</strong> <input name="tot_amt" type="text" class="transparent_tag" id="tot_amt" style="text-align:left; color:#c1264d; font-size: 25px; width:35%;" readonly>
                    </td>
                    <td><h4>Credit</h4></td>
                </tr>

            </table>
            <div class="form-group row">

                <div class="col-sm-10">

                    <input type="button" name="submit" id="submit" value="Save" class="btn btn-info" />

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

    // $('#submit').on('click', function(e) {
    //     $('select[name^=acc_code_Debit]').map(function(idx, elem) {
    //         var debitAcoCode = $(elem).val();
    //         alert(debitAcoCode);
            
            
    //         $('select[name^=acc_code]').map(function(idx, elemm) {
    //             $('#vau_tab').select
                
    //             var creditAcoCode=$('.select2-hidden-accessible').val();
    //             console.log(creditAcoCode);
    //             if(creditAcoCode!=0){
    //             if(debitAcoCode==creditAcoCode){
    //                 alert('Debit & Credit A/C Head are same');
    //                 return false;
    //             }else{
                   
    //             }
    //         }

            
    //     })
           
    //     })
       
    // });
    
    $("#submit").on('click', function() {
        $mss=0;
        $('.creditAcoCode').map(function(idx, elemm) {
            var creditAcoCode=$(elemm).val();
            //console.log(creditAcoCode+"cs");

            $('select[name^=acc_code_Debit]').map(function(idx, elem) {
             var debitAcoCode = $(elem).val();

            if(creditAcoCode==debitAcoCode){
                $mss=1;
                return false;
            }
        //console.log(debitAcoCode);
           
         });
    });

    if($mss==1){
alert('A/C Head Can Not Be Same');
}

    
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
        var start_session_year ='<?php  echo financialyear($this->session->userdata['loggedin']['fin_yr'],0); ?>';
        var end_session_year ='<?php  echo financialyear($this->session->userdata['loggedin']['fin_yr'],1); ?>';
        var voucher_dt   = $('#date').val();
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

<script>
    $('.mindate').attr('min',
    		'<?=$date->end_yr ?>-<?php $month=$date->end_mnth+1; if($month==13){echo sprintf("%02d",1);}else{echo sprintf("%02d",$month);}?>-01'
    		);
</script>