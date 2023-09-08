<style>
	table {
		border-collapse: collapse;
	}

	table,
	td,
	th {
		border: 1px solid #dddddd;

		padding: 6px;

		font-size: 14px;
	}

	th {

		text-align: center;

	}

	tr:hover {
		background-color: #f5f5f5;
	}
</style>
<script>
	function printDiv() {

		var divToPrint = document.getElementById('divToPrint');

		var WindowObject = window.open('', 'Print-Window');
		WindowObject.document.open();
		WindowObject.document.writeln('<!DOCTYPE html>');
		WindowObject.document.writeln('<html><head><title>Test Print</title><style type="text/css">');

		//	  	WindowObject.document.writeln('');
		WindowObject.document.writeln('@media print { .center { text-align: center;}' +
			'body{padding: 0; margin:0;}' +
			'.billPrintWrapper{padding: 15px; color: #333;}' +
			'.billPrintWrapper .topSec{border-bottom: #ccc solid 1px; display: inline-block; width: 100%; margin: 0 0 4px 0; padding: 0 0 4px 0;}' +
			'.billPrintWrapper .logo_secCustom{margin: 0; padding: 0; width: 100%; text-align: center;}' +
			'.billPrintWrapper h2{font-size: 18px;color: #333;margin:0;padding: 0;text-align: center;font-weight: 700;line-height: 20px;}' +
			'.billPrintWrapper h2 span{font-size: 14px; font-weight: 400; display: block;}' +
			'.billPrintWrapper .topSec p{font-size: 14px;color: #333; margin: 0; padding: 0; text-align: center;}' +
			'.billPrintWrapper .printTop023 {margin-bottom: 10px; width: 100%; display: inline-block; color: #333; font-size: 16px;}' +
			'.billPrintWrapper .printTop023 .leftNo {float: left; padding: 0 15px; font-size: 15px;}' +
			'.billPrintWrapper .printTop023 .rightDate {float: right; padding: 0 15px; font-size: 15px;}' +
			'.billPrintWrapper .tableArea{width: 100%;}' +
			'.billPrintWrapper .tdFirst{width: 55%;}' +
			'.billPrintWrapper .tdSecound{width: 15%;}' +
			'.billPrintWrapper .tdTHird{width: 15%;}' +
			'.billPrintWrapper .tdFourth{width: 15%;}' +
			'table thead tr th{text-align: left; padding:8px 5px; font-size: 15px; background-color: #c4c4c4;}' +
			'table tr td{text-align: left; padding:5px; font-size: 15px;}' +
			'table tfoot tr th{text-align: left; padding:8px 5px; font-size: 15px; background-color: #c4c4c4;}' +

			//'.billPrintWrapper .debitLine{margin-bottom: 10px; padding: 0 15px; font-size: 16px;}' +
			//'.billPrintWrapper .debitLine p{margin: 0; padding: 0;}' +
			//'.billPrintWrapper .debitLine p span{border-bottom: #000 solid 2px; font-size: 22px; font-weight: 700;}' +
			//'.billPrintWrapper .billTxtArea{width: 100%; padding: 0 15px;}' +
			//'.billPrintWrapper .billTxtArea p{margin: 0; padding: 0; font-size: 15px; line-height: 20px;}' +
			//'.billPrintWrapper .billTxtArea p strong.italic{font-style: italic;}' +
			//'.billPrintWrapper .priceSec{max-width: 120px;border: #000 solid 1px;padding: 5px;color: #333;margin-top: 6px;font-weight: 700;}' +
			//
			//'.billPrintWrapper .printBottom{margin:80px 0 0 0; padding: 0 15px; width: 100%; display: inline-block;}' +
			//'.billPrintWrapper .printBottom .col-md-3{width: 100%; max-width: 25%; padding: 0 0; float: left; box-sizing: border-box;}' +								  
			'} </style>');
		WindowObject.document.writeln('</head><body onload="window.print()">');
		WindowObject.document.writeln(divToPrint.innerHTML);
		WindowObject.document.writeln('</body></html>');
		WindowObject.document.close();
		setTimeout(function() {
			WindowObject.close();
		}, 10);

	}
</script>


<div class="wraper">

	<div class="col-lg-12 container contant-wraper">

		<div id="divToPrint">
			<div class="billPrintWrapper">
				<div style="text-align:center;">

					 <h4>BARRACKPORE CENTRAL ZONE WHOLESALE CONSUMERS' COOPERATIVE SOCIETY LIMITED.</h4>
						 <h5>87, MADHUPANDIT  ROAD, P.O-TALPUKUR, 24 PARGANAS (NORTH) ,700123</h5>
				
					<!-- <h4><?= $voucher_type ?> vouchers Between: <?php echo $_SESSION['date']; ?></h4> -->
					<!-- <h5 style="text-align:left"><label>District: </label> <?php echo $branch->branch_name; ?></h5> -->

				</div>
				<br>









				<?php foreach ($voucher as $vou); {     ?>
					<div class="printTop023">
						<div class="leftNo"><b>Voucher ID: </b> <?= $vou->voucher_id ?></div>
						<div class="rightDate"><b>Dated:</b> <?php echo date("d/m/Y", strtotime($vou->voucher_date)); ?></div><br>




						<!-- </div>

					<div class="printTop023"> -->
						<!-- <div class="leftNo">Transaction No:<?= $vou->trans_no ?></a></div><br> -->
						<!-- <div class="leftNo">Transaction No: <a href="<?= base_url() ?>index.php/report/trans_detail?trans_no=<?php echo base64_encode($vou->trans_no); ?>&type=<?= base64_encode($type) ?>&trans_dt=<?= $vou->trans_dt ?>" target="_blank"><?= $vou->trans_no ?></a></div><br> -->
						<!-- <div class="leftNo">Voucher type: <?php if ($vou->transfer_type == 'C') {
																	echo 'Cheque';
																} elseif ($vou->transfer_type == 'N') {
																	echo 'NEFT';
																} elseif ($vou->transfer_type == 'R') {
																	echo 'RTGS';
																} elseif ($vou->transfer_type == 'T') {
																	echo 'Transfer';
																}
																?></div> -->





						<?php if ($vou->transfer_type != 'T') { ?>

							<div class="leftNo"><b>Branch: </b><?= $vou->branch_name ?></div>
							<!-- <div class="leftNo">Ref No: <?= $vou->ins_no ?></div> -->
							<!-- <div class="rightDate">Ref date: <?php echo date("d/m/Y", strtotime($vou->ins_dt)); ?></div> -->

							<!-- <div class="printTop023">
		<div class="leftNo">Bank: <?= $vou->bank_name ?></div>
		</div> -->
						<?php } ?>

						<div class="rightDate"><b>Status:</b> <?php if ($vou->approval_status == 'A') {
															echo 'Approved';
														} elseif ($vou->approval_status == 'U') {
															echo 'Unpproved';
														} ?></div>


					</div>
					<div class="tableArea">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" id="example">
							<thead>
								<tr>
									<th class="tdFirst">A/C Head</th>
									<th class="tdSecound">A/C Code</th>
									<th class="tdSecound">Trans Type</th>
									<th class="tdTHird">Dr Amount</th>
									<th class="tdFourth">Cr Amount</th>
								</tr>
							</thead>
							<tbody>
								<?php $dr_tot  = 0.00;
								$cr_tot  = 0.00;
								$remarks = '';
								if ($voucher) {
									foreach ($voucher as $adv) {
										if ($adv->voucher_id == $vou->voucher_id) {
											$remarks = $adv->remarks;
								?>
											<tr>
												<td><?php echo $adv->ac_name; ?></td>
												<td><?php echo $adv->benfed_ac_code; ?></td>
												<td><?php echo $adv->dr_cr_flag; ?></td>
												<td><?php
													if ($adv->dr_cr_flag == 'Dr') {
														echo $adv->amount;
														$dr_tot += $adv->amount;
													} else {
														echo '0.00';
													} ?></td>
												<td><?php
													if ($adv->dr_cr_flag == 'Cr') {
														echo $adv->amount;
														$cr_tot += $adv->amount;
													} else {
														echo '0.00';
													}

													?></td>
											</tr>
									<?php    }
									}    				  ?>
							</tbody>
							<?php
									$dr_tot = number_format((float)$dr_tot, 2, '.', '');
									$cr_tot = number_format((float)$cr_tot, 2, '.', '');
									$style_c = '';
									if ($dr_tot != $cr_tot) {
										$style_c = '#FF0000';
									} ?>
							<tfoot>
								<tr>
									<th class="tdFirst" style="background-color:<?= $style_c ?>">Total:</th>
									<th class="tdSecound" style="background-color:<?= $style_c ?>"></th>
									<th class="tdSecound" style="background-color:<?= $style_c ?>"></th>
									<th class="tdTHird" style="background-color:<?= $style_c ?>"><?= $dr_tot ?></th>
									<th class="tdFourth" style="background-color:<?= $style_c ?>"><?= $cr_tot ?></th>
								</tr>
							</tfoot>
						</table>
					</div>
					</br>
					<p>
						<?php
									$number = $cr_tot;
									$no = floor($number);
									$point = round($number - $no, 2) * 100;
									$hundred = null;
									$digits_1 = strlen($no);
									$i = 0;
									$str = array();
									$words = array(
										'0' => 'zero', '1' => 'one', '2' => 'two',
										'3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
										'7' => 'seven', '8' => 'eight', '9' => 'nine',
										'10' => 'ten', '11' => 'eleven', '12' => 'twelve',
										'13' => 'thirteen', '14' => 'fourteen',
										'15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
										'18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
										'30' => 'thirty', '40' => 'forty', '50' => 'fifty',
										'60' => 'sixty', '70' => 'seventy',
										'80' => 'eighty', '90' => 'ninety'
									);
									$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
									while ($i < $digits_1) {
										$divider = ($i == 2) ? 10 : 100;
										$number = floor($no % $divider);
										$no = floor($no / $divider);
										$i += ($divider == 10) ? 1 : 2;
										if ($number) {
											$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
											$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
											$str[] = ($number < 21) ? $words[$number] .
												" " . $digits[$counter] . $plural . " " . $hundred
												:
												$words[floor($number / 10) * 10]
												. " " . $words[$number % 10] . " "
												. $digits[$counter] . $plural . " " . $hundred;
										} else $str[] = null;
									}
									$str = array_reverse($str);
									$result = implode('', $str);
									$points = ($point) ?
										"." . $words[$point / 10] . " " .
										$words[$point = $point % 10] : '';
									if (!empty($points)) {
										echo humanize($result . "Rupees  " . $points . " Paise");
									} else {
										echo humanize($result . "Rupees  ");
									}

						?>
					</p>

					<div class="remarks"><b>Remarks: </b> <?= $remarks ?></div>
					</br>


					<div class="printTop023">

						<div class="leftNo"><b>Created By</b>: <?php echo $vou->created_by; ?></div>
						<div class="rightDate"><b>Approved By</b>: <?php echo $vou->approved_by; ?></div> <br>

						<div class="leftNo"><b>Created Date</b>: <?php echo  date("d/m/Y H:i:s", strtotime($vou->created_dt)); ?></div>
						<div class="rightDate"><b>Approved Date</b>: <?php 
						if(empty($vou->approved_dt) || $vou->approved_dt=='0000-00-00 00:00:00'||$vou->approved_dt==""){ 
							
						}else{
							echo  date("d/m/Y H:i:s", strtotime($vou->approved_dt)); 
						}?></div>


					</div>
					<!-- line 173 -->

					<div class="tableArea">

						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 100px;" id="example">
							<tbody>
								<tr>

									<td>Prepared By</td>

									<?php if ($this->session->userdata('loggedin')['branch_id'] == 342) { ?>
										<td>Asst Manager/Dy. Manager</td>
										<td>Departmental Manager(S)</td>
										<td>CA&AO</td>
										<td>General Manager</td>
									<?php } else { ?>
										<td>Assistant/ Sr. Assistant</td>
										<td>Branch Accountant</td>
										<td>District Manager</td>
									<?php } ?>
								</tr>
							</tbody>
						</table>
					</div>



					<hr style="border-top: 4px dashed #bbb">
			<?php
									$dr_tot = 0.00;
									$cr_tot = 0.00;
								}
							}		?>
			</div>
		</div>

		<div style="text-align: center;">

			<button class="btn btn-primary" type="button" onclick="printDiv();">Print</button>
			<!-- <button class="btn btn-primary" type="button" id="btnExport" >Excel</button>-->

		</div>

	</div>

</div>


<!-- <script>
            $(document).ready(function() {

$('.total').each(function() {
  var prevClass = $(this).prev().attr('class');
  var sum = 0;
  $('.' + prevClass).each(function() {
    sum += Number($(this).text());
  })

  $(this).text('Total :'+sum);
})

});
        </script> -->