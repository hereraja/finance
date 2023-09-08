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
		setTimeout(function () {
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
						 <h5>MADHUPANDIT  ROAD, P.O-TALPUKUR, 24 PARGANAS (NORTH) ,700123</h5>
			
					<h4><?=$unit?> vouchers Between: <?php echo $_SESSION['date']; ?></h4>
					<h5 style="text-align:left"><label>District: </label> <?php echo $branch->branch_name; ?></h5>

				</div>
				<br>

				<?php foreach($voucher as $vou){     ?>
				<div class="printTop023">
					<div class="leftNo"><b>Voucher ID: </b><?=$vou->voucher_id?></div><br>
					<div class="rightDate"><b>Dated: </b> <?php echo date("d/m/Y",strtotime($vou->voucher_date)); ?></div>

					<div class="leftNo"><b>Status: </b> <?php  if($vou->approval_status=='A'){echo 'Paid';} 
														elseif($vou->approval_status=='U'){echo 'Unpproved';}
												elseif($vou->approval_status=='H'){echo 'Void';}
						                                ?></div><br>
					
					
					
					<?php if(!empty($vou->transfer_type)){ ?>
					<div class="rightDate"><b>Transfer type: </b><?php if($vou->transfer_type == 'C'){echo 'Checque'; } 
												 elseif($vou->transfer_type == 'N'){ echo 'NEFT'; }
												 elseif($vou->transfer_type == 'R'){ echo 'RTGS'; }
												 elseif($vou->transfer_type == 'T'){ echo 'Transfer'; }
												 elseif($vou->transfer_type == 'H'){ echo 'Cash'; }
												 ?></div>
					<?php } ?>
				<!-- </div>
				<div class="printTop023"> -->
					<?php if(!empty($vou->trans_no)){ ?>
					<div class="leftNo"><b>Transaction No: </b><?=$vou->trans_no?>
					</div>
					<?php } ?>
					
					
				</div>
				<!-- <?php if($vou->transfer_type != 'T' ) {?>
				<div class="printTop023">
				 <?php if(!empty($vou->ins_no)){ ?>
					<div class="leftNo">Ref No: <?=$vou->ins_no?></div>
					<?php } ?>
					<?php if(!empty($vou->ins_dt)){ ?>
					<div class="rightDate">Ref date: <?php echo date("d/m/Y",strtotime($vou->ins_dt)); ?></div>
					<?php } ?>
				</div> 
				<div class="printTop023">
				<?php if(!empty($vou->bank_name)){ ?>
					<div class="leftNo">Bank: <?=$vou->bank_name?></div>
					<?php } ?>
				</div> 
				<?php } ?> -->
				<div class="tableArea">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" id="example">
						<thead>
							<tr>
								<th class="tdFirst">A/C Head</th>
								<th class="tdSecound">Trans Type</th>
								<th class="tdTHird">Dr Amount</th>
								<th class="tdFourth">Cr Amount</th>
							</tr>
						</thead>
						<tbody>
							<?php  $dr_tot  = 0.00;
				         $cr_tot  = 0.00;
						 $remarks = '';
						 if($advance){
				        foreach($advance as $adv){
				          if($adv->voucher_id == $vou->voucher_id ){
							  $remarks = $adv->remarks;
					  ?>
							<tr>
								<td><?php echo $adv->ac_name; ?></td>
								<td><?php echo $adv->dr_cr_flag; ?></td>
								<td><?php 
                                       if($adv->dr_cr_flag=='Dr'){
                                        echo $adv->amount;
										$dr_tot += $adv->amount;
										} else { echo '0.00';}?></td>
								<td><?php 
                                       if($adv->dr_cr_flag=='Cr'){
                                        echo $adv->amount;
										$cr_tot += $adv->amount;
										}else{ echo '0.00';}
                                       
                                   ?></td>
							</tr>
							<?php    } 
                        }    				  ?>
						</tbody>


						<?php 
				      $dr_tot = number_format((float)$dr_tot, 2, '.', '');
					  $cr_tot = number_format((float)$cr_tot, 2, '.', '');
				$style_c='';if($dr_tot != $cr_tot ) { $style_c='#FF0000'; } ?>
						<tfoot>
							<tr>
								<th class="tdFirst" style="background-color:<?=$style_c?>">Total:</th>
								<th class="tdSecound" style="background-color:<?=$style_c?>"></th>
								<th class="tdTHird" style="background-color:<?=$style_c?>"><?=$dr_tot?></th>
								<th class="tdFourth" style="background-color:<?=$style_c?>"><?=$cr_tot?></th>
							</tr>
						</tfoot>
					</table>
					
				</div>
				<?php if(!empty($remarks)){ ?>
				<div class="remarks"><b>Remarks: </b><?=$remarks?></div>
				<?php } ?>


				<div class="printTop023">


					
					<div class="leftNo"><b> Created By: </b><?php echo $vou->created_by; ?></div>
					<div class="rightDate"><b>Approved By: </b><?php echo  $vou->approved_by; ?></div><br>

					<div class="leftNo"><b> Created Date: </b><?php echo date("d/m/Y H:i:s",strtotime($vou->created_dt)); ?></div>
					<div class="rightDate"><b>Approved Date: </b><?php
					
					if(empty($vou->approved_dt) || $vou->approved_dt=='0000-00-00 00:00:00'|| $vou->approved_dt==""){ 
							
					}else{
						echo  date("d/m/Y H:i:s", strtotime($vou->approved_dt)); 
					}?></div>
					
				</div>
				</br>
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