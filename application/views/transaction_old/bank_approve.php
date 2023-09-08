<style>
    td,
    th {
        padding: 5px;
    }
</style>

<div class="wraper">
    <div class="col-md-9 container form-wraper">
        <form method="POST" action="<?php echo site_url("transaction/bank_forward") ?>" onsubmit="return valid_data()">
            <div class="form-header">
                <h4>Bank Voucher</h4>
            </div>
            <input type="hidden" id="sys_date" value="<?= date('Y-m-d') ?>">
            <div class="form-group row">
                <label for="trans_dt" class="col-sm-2 col-form-label">Date:</label>
                <div class="col-sm-7">
                    <input type=date name="voucher_dt" class="form-control smallinput_text" value="<?= $head_tag['voucher_date'] ?>" id="date" style="width: 150px;" readonly />
                </div>
                <label for="voucher_mode" class="col-sm-1 col-form-label">Mode:</label>
                <div class="col-sm-1">
                    <input type="text" name="voucher_mode" value="BANK" class="transparent_tag" style="width:50px;" readonly />
                </div>
            </div>
            <div class="form-group row">
                <label for="voucher_type" class="col-sm-2 col-form-label">Voucher Type:</label>
                <div class="col-sm-4">
                    <select class="form-control select_2" id="v_type" onchange="set_dr_cr()" class="input_text" disabled>
                        <option value="">Select</option>
                        <option value="R" <?= $head_tag['voucher_type'] == 'R' ? 'selected' : '' ?>>Bank Received</option>
                        <option value="P" <?= $head_tag['voucher_type'] == 'P' ? 'selected' : '' ?>>Bank Payment</option>
                    </select>
                    <input type="hidden" name="voucher_type" value="<?= $head_tag['voucher_type'] ?>">
                </div>

                <label for="transfer_type" class="col-sm-2 col-form-label">Transfer Type:</label>
                <div class="col-sm-3">
                    <select class="form-control select_2" id="t_type" onchange="set_dr_cr()" class="input_text" disabled>
                        <option value="">Select</option>
                        <option value="C" <?= $head_tag['transfer_type'] == 'C' ? 'selected' : '' ?>>Checque</option>
                        <option value="N" <?= $head_tag['transfer_type'] == 'N' ? 'selected' : '' ?>>NEFT</option>
                        <option value="R" <?= $head_tag['transfer_type'] == 'R' ? 'selected' : '' ?>>RTGS</option>
                    </select>
                    <input type="hidden" name="transfer_type" value="<?= $head_tag['transfer_type'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="acc_cd" class="col-sm-2 col-form-label">Bank A/C:</label>
                <div class="col-sm-9">
                    <select class="form-control select_2" style="width:282px;display: inline;" disabled>
                        <option value="0">Select</option>
                        <?php
                        foreach ($bank as $value) {
                            $selected = '';
                            if ($value->sl_no == $head_tag['acc_code']) {
                                $selected = 'selected';
                            }
                            echo "<option value='" . $value->sl_no . "' " . $selected . ">" . $value->ac_name . "</option>";
                        }
                        ?>
                    </select>
                    <input type="hidden" name="acc_cd" value="<?= $head_tag['acc_code'] ?>">
                    <span style="float: right; display: inline;">
                        <input type="text" id="dc" class="transparent_tag" name="dr_cr_flag" value="" readonly>
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label for="trans_dt" id="t_label_no" class="col-sm-2 col-form-label">Cheque No.:</label>
                <div class="col-sm-4">
                    <input type="text" name="inst_num" class="form-control smallinput_text" value="<?= $head_tag['trans_no'] ?>" readonly>
                </div>
                <label for="trans_dt" id="t_label_dt" class="col-sm-2 col-form-label">Cheque Date:</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control smallinput_text" name="inst_dt" value="<?= $head_tag['trans_dt'] ?>" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label for="remarks" class="col-sm-2 col-form-label">Remarks:</label>
                <div class="col-sm-9">
                    <textarea class="form-control" name="remarks" readonly><?= $head_tag['remarks'] ?></textarea>
                </div>
            </div>
            <hr class="hr_divide">
            <table id="vau_tab">
                <thead>
                    <tr>
                        <th width="25%">A/C Head</th>
                        <th width="18%">Group</th>
                        <th width="18%">Subgroup</th>
                        <th>Amount</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="add">
                    <?php $i = 1;
                    foreach ($ac_dtls as $dt) { ?>
                        <tr class="mb-2">
                            <td>
                                <select id="acc_code_<?= $i ?>" class="form-control acc_code" style="width: 80%;" onchange="set_gr(<?= $i ?>)" disabled>
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($row as $value) {
                                        $selected = '';
                                        if ($value->sl_no == $dt['acc_code']) {
                                            $selected = 'selected';
                                        }
                                        echo "<option value=" . $value->sl_no . " " . $selected . ">" . $value->ac_name . "</option>";
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="acc_code[]" value="<?= $dt['acc_code'] ?>">
                            </td>
                            <td><input type="text" class="transparent_tag" id="gr_id_<?= $i ?>" name="gr_id[]" value="<?= $dt['gr_name'] ?>" style="width: 100%;" readonly></td>
                            <td><input type="text" class="transparent_tag" id="subgr_id_<?= $i ?>" name="subgr_id[]" value="<?= $dt['subgr_name'] ?>" style="width: 100%;" readonly></td>

                            <td><input type="text" class="form-control amount_cls" id="amt" name="amount[]" value="<?= $dt['amount'] ?>" style="width: 100%; text-align: right;" readonly></td>
                            <td><input type="text" class="transparent_tag" id="dc_flg" name="dc_flg[]" value="<?= $dt['dr_cr_flag'] == 'Dr' ? 'Debit' : 'Credit' ?>" style="width: 100%; text-align: center;" readonly required></td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
                <tr>
                    <td colspan="3" style="text-align:right;">
                        <strong>Total:</strong>
                        <input name="tot_amt" type="text" class="transparent_tag" id="tot_amt" value="<?= $head_tag['tot_amt'] ?>" style="text-align:left; color:#c1264d; font-size: 25px; width:16%;" readonly>
                    </td>
                </tr>

            </table>
            <input type="hidden" name="voucher_id" value="<?= $head_tag['voucher_id'] ?>">
            <input type="hidden" name="sl_no" value="<?= $head_tag['sl_no'] ?>">
            <div class="form-group row">
                <div class="col-sm-10">
                    <input type="submit" name="submit" id="submit" value="Approve" class="btn btn-info" />
                </div>

            </div>

        </form>

    </div>

</div>