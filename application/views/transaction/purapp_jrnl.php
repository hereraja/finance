<style>
.centered {
  position: fixed;
  top: 40%;
  left: 50%;
  transform: translate(-50%, -50%);
  -webkit-transform: translate(-50%, -50%);
  -moz-transform: translate(-50%, -50%);
  -o-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  
  font-size: 20px;
  background-color: gray;
  border: black 5px ;
  padding: 2px;
  z-index: 100;
}

.cente {
  font-size: 20px;
  background-color: gray;
  border: black 5px ;
  padding: 2px;
}

table {
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid #dddddd;

    padding: 6px;

    font-size: 14px;
}

th {

    text-align: center;

}

tr:hover {background-color: #f5f5f5;}

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
'.billPrintWrapper .topSec{border-bottom: #ccc solid 1px; display: inline-block; width: 100%; margin: 0 0 4px 0; padding: 0 0 4px 0;}'+
'.billPrintWrapper .logo_secCustom{margin: 0; padding: 0; width: 100%; text-align: center;}'+
'.billPrintWrapper h2{font-size: 18px;color: #333;margin:0;padding: 0;text-align: center;font-weight: 700;line-height: 20px;}' +
'.billPrintWrapper h2 span{font-size: 14px; font-weight: 400; display: block;}' +
'.billPrintWrapper .topSec p{font-size: 14px;color: #333; margin: 0; padding: 0; text-align: center;}'+
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
			<form method="POST" id="form" action="<?php echo site_url("transaction/f_upd_app");?>" >
                <div id="divToPrint">
						<div class="billPrintWrapper">
                    <div style="text-align:center;">
					
                        <h2>THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.</h2>
                        <h4>HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR, 1582 RAJDANGA MAIN ROAD, KOLKATA-700107.</h4>
                        <!-- <?php 
						// foreach($voucher as $vou);{     ?>
						// 	 <h4><?php
						// 	 if($vou->voucher_type == 'PUR'){echo 'Purchase Voucher'; } 
						// 	 elseif($vou->voucher_type == 'SL'){ echo 'Sale  Voucher'; }
						// 	 elseif($vou->voucher_type == 'A'){ echo 'Advance  Voucher'; }
						// 	 elseif($vou->voucher_type == 'P'){ echo 'Paywent  Voucher'; }
						// 	 elseif($vou->voucher_type == 'R'){ echo 'Receive  Voucher'; }
						// 	 elseif($vou->voucher_type == 'CRN'){ echo 'Credit Note  Voucher'; }
								
						// 		?> </h4>
							 <?php
							//}
							?> -->
                        <!-- <h5 style="text-align:left"><label>District: </label> <?php echo $branch->branch_name; ?></h5> -->

                    </div>
                    <br>  

        <?php foreach($voucher as $vou);     ?>
		<div class="printTop023">
		<div class="leftNo">Voucher ID: <?=$vou->voucher_id?></div><br>
		<div class="leftNo">Dated: <?php echo date("d/m/Y",strtotime($vou->voucher_date)); ?></div>
		<center >
		<span class="cente">Approval Status: 	
        <select class="" id="appstatus" name="appstatus"  >
	
		<option value="">Select Product Type</option>

		<option value="U" <?php echo ($vou->approval_status == 'U')? 'selected' : '';?>>Unapproved</option>
		
		<option value="A" <?php echo ($vou->approval_status == 'A')? 'selected' : '';?>>Approved</option>

		<option value="H" <?php echo ($vou->approval_status == 'H')? 'selected' : '';?>>On Hold</option>

        </select>
		</span>
        </center>
		<div class="rightDate" style="margin-top: -49px;">Created By: <?=$vou->created_by?></div>
		<div class="rightDate" style="margin-top: -27px;">Created Date: <?php echo date("d/m/Y H:i:s",strtotime($vou->created_dt));?></div>
		</div>
		<div class="printTop023">
		<div class="leftNo">Transaction No: <?=$vou->trans_no?>
		<!-- <div class="leftNo">Transaction No: <a href="<?=base_url()?>index.php/report/trans_detail?trans_no=<?php echo base64_encode($vou->trans_no);?>&type=<?=base64_encode($type)?>&trans_dt=<?=$vou->trans_dt?>" target="_blank"><?=$vou->trans_no?></a></div><br> -->
		<input type="hidden" name="trans_no" class="form-control" value = "<?php echo $vou->trans_no; ?>" />
		<input type="hidden" name="voucher_date" class="form-control" value = "<?php echo $vou->voucher_date; ?>" />
		<input type="hidden" name="voucher_id" class="form-control" value = "<?php echo $vou->voucher_id; ?>" />
	   </div>

		<!-- <div class="leftNo">Approval Status: <?=$vou->approval_status?></div> -->
        <br>
		<?php if(!empty($vou->transfer_type)){ ?>
		<div class="rightDate">Voucher type: <?php if($vou->transfer_type == 'C'){echo 'Bank'; } 
												 elseif($vou->transfer_type == 'N'){ echo 'Bank'; }
												 elseif($vou->transfer_type == 'R'){ echo 'Bank'; }
												 elseif($vou->transfer_type == 'T'){ echo 'Journal'; }
												 elseif($vou->transfer_type == 'CH'){ echo 'CASH'; }
												 ?></div>
												 <?php } ?>
		</div>
		<?php if($vou->transfer_type != 'T' ) { if($vou->transfer_type != 'CH'){ ?>
		<div class="printTop023">
			<?php if(!empty($vou->ins_no)){ ?>
		<div class="leftNo">Ref No: <?=$vou->ins_no?></div>
		<?php } ?>
		<?php if(!empty(($vou->ins_dt))){  ?>
		<div class="rightDate">Ref date: <?php echo date("d/m/Y",strtotime($vou->ins_dt));?></div>
		<?php } ?>
		</div>
		<div class="printTop023">
			<?php if(!empty($vou->bank_name)){ ?>
		<div class="leftNo">Bank: <?=$vou->bank_name?></div>
		<?php } ?>
		</div>
		<?php }} ?>
		<div class="tableArea">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
							if($adv->amount > 0){	
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
						}	
                       }    				  ?>
				</tbody>
				<?php 
				      $dr_tot = number_format((float)$dr_tot, 2, '.', '');
					  $cr_tot = number_format((float)$cr_tot, 2, '.', '');
				$style_c='';if($dr_tot != $cr_tot ) { $style_c='#FF0000'; } ?>	
				<tfoot >
					<tr >
					  <th class="tdFirst" style="background-color:<?=$style_c?>">Total:</th>
					  <th class="tdSecound" style="background-color:<?=$style_c?>"></th>
					  <th class="tdTHird" style="background-color:<?=$style_c?>"><?=$dr_tot?></th>
					  <th class="tdFourth" style="background-color:<?=$style_c?>"><?=$cr_tot?></th>
					</tr>
				</tfoot>
		    </table>
		</div>
		
		<div class="remarks"><b>Remarks: <?=$remarks?></b></div>
		</br>
		<hr style="border-top: 4px dashed #bbb">
        <?php 
		$dr_tot = 0.00;
		$cr_tot = 0.00;
		
		    }
		 //}	
		?>
	
					</div>
                </div>   
                
                <div style="text-align: center;">

                    <!-- <button class="btn btn-primary" type="button" onclick="printDiv();">Print</button> -->
					
                   <!-- <button class="btn btn-primary" type="submit" id="submit" onclick='approve("<?php echo  $vou->voucher_id ?>");'>Update</button> -->
				   <button class="btn btn-primary" type="submit" id="submit" >Save</button>
                </div>
				</form>
            </div>
            
        </div>

<!-- <script>
	function approve($vou_id){
	
alert($vou_id);

	}
</script> -->
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