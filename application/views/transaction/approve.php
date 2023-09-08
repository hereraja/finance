<style>
    td,
    th {
        padding: 5px;
    }
</style>
<div class="wraper">

    <div class="col-md-9 container form-wraper">

        <form method="POST" action="<?php echo site_url("transaction/forward") ?>" onsubmit="return valid_data()">
            <div class="form-header">
                <h4>Cash Voucher</h4>
            </div>
            <div class="form-group row">
                <label for="voucher_dt" class="col-sm-2 col-form-label">Date:</label>
                <div class="col-sm-7">
                    <input type=date name="voucher_dt" class="transparent_tag" value="<?= $head_tag['voucher_date'] ?>" readonly />
                </div>
                <label for="voucher_mode" class="col-sm-1 col-form-label">Mode:</label>
                <div class="col-sm-1">
                    <input type="text" name="voucher_mode" value="CASH" class="transparent_tag" style="width:50px;" readonly />
                </div>
            </div>
            <div class="form-group row">
                <label for="voucher_type" class="col-sm-2 col-form-label">Voucher Type:</label>
                <div class="col-sm-8">
                    <select id="v_type" style="width: 100%;" onchange="set_dr_cr()" class="form-control" disabled>

                        <option value="">Select</option>
                        <option value="R" <?= $head_tag['voucher_type'] == 'R' ? 'selected' : '' ?>>Cash Received</option>
                        <option value="P" <?= $head_tag['voucher_type'] == 'P' ? 'selected' : '' ?>>Cash Payment</option>

                    </select>
                    <input type="hidden" name="voucher_type" value="<?= $head_tag['voucher_type'] ?>">
                </div>

            </div>

            <div class="form-group row">

                <label for="acc_hd" class="col-sm-2 col-form-label">A/C Head:</label>

                <div class="col-sm-8">

                    <input type="text" name="acc_hd" class="transparent_tag" value="<?= $cash_head ?>" style="width: 200px; display:inline;" readonly />

                    <input type="text" id="dc" class="transparent_tag" name="dr_cr_flag" value="<?= $head_tag['dr_cr_flag'] == 'Dr' ? 'Debit' : 'Credit' ?>" style="display:inline;" readonly />

                </div>

            </div>

            <input type="hidden" name="acc_cd" value="<?= $cash_code ?>" />

            <div class="form-group row">

                <label for="trans_dt" class="col-sm-2 col-form-label">Remarks:</label>

                <div class="col-sm-8">

                    <textarea class="form-control" name="remarks" readonly><?= $head_tag['remarks'] ?></textarea>

                </div>

            </div>

            <hr class="hr">

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