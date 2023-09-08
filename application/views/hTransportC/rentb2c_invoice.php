<?php 
$qr = 'https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl='."Invoice".':'.$data->trans_do. ','."GSTIN".':'.$data->gstin. ','."Society".':' .$data->soc_name.','."Total:".$sum_data->tot_amt_rnd;
?>
<style>
table {
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid #dddddd;

    padding: 6px;

    font-size: 12px;
}

th {


}

tr:hover {background-color: #f5f5f5;}

</style>
<!-- <style type="text/css">
@media print {
    #printbtn {
        display :  none;
    }
} -->
</style>
<script>
  function printDiv() {

        var divToPrint = document.getElementById('divToPrint');

        var WindowObject = window.open('', 'Print-Window');
        WindowObject.document.open();
        var printButton = document.getElementById("printbtn");
        //Set the print button visibility to 'hidden' 
        printButton.style.visibility = 'hidden';
        WindowObject.document.writeln('<!DOCTYPE html>');
        WindowObject.document.writeln('<html><head><title></title><style type="text/css">');


        WindowObject.document.writeln('@media print { .center { text-align: center;}' +
			'body{margin:0;padding:0;}'+
			'.pageTitle h3{font-size: 20px;}'+
			'.logoSec img{max-width: 78px; width: 100%; padding: 0;}'+
			'.barcodePage img{max-width: 95px; width: 100%; padding: 0;}'+
            '.inline { display: inline; }' +
            '.underline { text-decoration: underline; }' +
            '.left { margin-left: 315px;} ' +
            '.right { margin-right: 375px; display: inline; }' +
            'table { border-collapse: collapse; font-size: 12px;}' +
            /*'th, td { border: 1px solid red; border-collapse: collapse; padding: 6px;}' +*/
			'th, td { border:none; padding: 0;}' +
			'.logoSec, .pageTitle, .barcodePage{max-width:33.3%; width:100%; padding-left:15px; padding-right:15px; float:left;	box-sizing:border-box;}'+
			'.barcodePage img{max-width: 95px; width: 100%; padding: 0;}'+
			'.barcodePage {text-align: right;}'+
			'.logoSec{padding-top: 7px; padding-bottom: 7px;}'+
			'.logoSec img{max-width: 78px; width: 100%; padding: 0;}'+
			'.tableBottomBorder{border-top: 1px solid #dddddd; padding-top: 0px; margin-top: 5px;}'+
			'.tableBottomBorder table.table3 tbody tr td.adres_topLeft p {margin:0; padding:0;}'+
			'.tableBottomBorder table.table3 tbody tr td.adres_topLeft{padding:3px;}'+
			'.tableBottomBorder table.table2 tbody tr td.adres_topLeft{padding:3px;}'+
			'.tableBottomBorder .table > thead > tr > td{padding:3px; font-size: 11px;}'+
			'.tableBottomBorder .table > tbody > tr > td{padding:3px; font-size: 11px;}'+
			'.tableBottomBorder .table td{font-size: 11px;}'+	  
			'.noborder{border:none !important;}'+
			'.border_left{border-left:1px solid #dddddd !important;}'+
			'.border_right{border-right:1px solid #dddddd !important;}'+
			'.border_top{border-top:1px solid #dddddd !important;}'+
			'.border_bottom{border-bottom:1px solid #dddddd !important;}'+
			'.titleTd {background: #d9d9d9; color: #000;}'+
			'.formDurkBack {padding: 5px !important; background: #626262 !important; background-color: rgba(247, 202, 24, 0.3) !important; color: #000;}'+
			'.padding_botNew{padding-bottom: 25px !important;}'+
			'.padding_topNew{padding-top: 25px !important;}'+
			'.padding_5{padding: 5px !important;}'+
            'th, td {background-color:#999;}' +
            '.border { border: 1px solid black; } ' +
            '.bottom { bottom: 5px; width: 100%; position: fixed ' +
            '' +
            '} } </style>');
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
<div class="wrapper_fixed">

<!-- <div class="col-sm-2 logo_sec_main">
                    <div class="logo_sec">
                    <img src="<?php //echo base_url("/benfed.png");?>" />
                    </div>
                </div> -->
  <!-- <h5> <img src="<?php //echo base_url("/benfed.png");?>" />
  </h5> -->
  <!-- <head>
  <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&display=swap" rel="stylesheet">
  </head> -->

  <div class="row">
    <div class="logoSec"><img src="<?php echo base_url("/benfed.png");?>" class="pull-left" /></div>
    <div class="pageTitle"><h3><center>Tax Invoice</center></h3></div>
    <div class="barcodePage"><img src="<?= $qr; ?>" class="pull-right" alt=""></div>
  </div>
  <!-- <h3><img src="<?php //echo base_url("/benfed.png");?>" />Tax Invoice </h3> -->
  <div class="tableBottomBorder">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1" id="example">
  <tbody>
  <!-- <tr><td id="qr_gen"><img src="<?php //$qr; ?>" class="pull-right" alt=""></td></tr>
								<?php //echo '<br><hr><h2>'.$this->postCURL('https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl= rvbn', 'raja').'</h2><br><hr><br>';?>
							
    <tr> -->
        <td align="left" valign="top" class="border_bottom border_top"><table width="100%" cellpadding="0" cellspacing="0" class="table tableCus table2" id="example">
    <tr>
<td scope="col" class="tax_1 padding_botNew"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="table3" id="example">
        <tbody>
          <tr>
            <td class="tax_border_bot adres_topLeft">
            <p>The West Bengal State Co-operative Marketing Federation Ltd.<br>
            Southend Conclave, 3rd Floor,1582 Rajdanga Main Road,Kolkata - 700 107.</p>
<!-- <h2 style="text-align:center">The West Bengal State Co-operative Marketing Federation Ltd.</h2>
  <h4 style="text-align:center">Southend Conclave, 3rd Floor,1582 Rajdanga Main Road,Kolkata - 700 107.</h4> -->
            </td>
            </tr>
            <tr>
            <td class="tax_border_bot adres_topLeft noborder_bottom"><p>Consignee</p>
              <p><strong><?php echo  $data->soc_name;?></strong><br>
               Address :<?php echo  $data->soc_add;?><br>
              GSTIN: <?php echo  $data->gstin;?><br>
              mfms: <?php echo  $data->mfms;?> </p>            </td>
          </tr>
          <tr>
            <td class="tax_border_bot adres_topLeft noborder_bottom"><p>Buyer (if other then consignee)</p>
              <p><strong><?php echo  $data->soc_name;?></strong><br>
               Address :<?php echo  $data->soc_add;?><br>
              GSTIN: <?php echo  $data->gstin;?><br>
              mfms: <?php echo  $data->mfms;?> </p>            </td>
          </tr>
        </tbody>
      </table></td>
      <td scope="col" class="tax_2 adres_topLeft padding_botNew">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table4" id="example">
        <tbody>
          <tr>
            <td class="tax_border_bot_left">Invoice No.<br>
              <strong><?php echo  $data->trans_do;?></strong></td>
            <td class="tax_border_bot_left">Date<br>
              <strong><?php echo date("d-m-Y", strtotime( $data->do_dt));?></strong></td>
          </tr>
          <tr>
            <td class="tax_border_bot_left">Delivery Note</td>
            <td class="tax_border_bot_left">Mode/terms of payment
            </td>
          </tr>
          <tr>
            <td class="tax_border_bot_left">Supplier's Ref.<br>
              <strong><?php echo  $data->suppliers_ref;?></strong>
            </td>
            <td class="tax_border_bot_left">Others Reference(s)
            </td>
          </tr>
          <tr>
            <td class="tax_border_bot_left">Buyer's Order No.</td>
            <td class="tax_border_bot_left">
            <strong><?php echo 'Dated';?></strong></td>
          </tr>
          <tr>
            <td class="tax_border_bot_left">Despatch Document No</td>
            <td class="tax_border_bot_left"><?php echo 'Delivery Note Date';?></td>
          </tr>
          <tr>
            <td class="tax_border_bot_left">Despatch Through</td>
            <td class="tax_border_bot_left">Destination</td>
          </tr>
          <!-- <tr>
            <td class="tax_border_bot_left" style="border-top: none; border-left: none !important;">Lorem Ipsum is simply</td>
            <td class="tax_border_bot_left" style="border-top: none;">Lorem Ipsum is simply dummy tex</td>
          </tr> -->
          <!-- <tr>
            <td class="tax_border_bot_left" style="border-top: none; border-left: none !important;">Lorem Ipsum is simply</td>
            <td class="tax_border_bot_left" style="border-top: none;">Lorem Ipsum is simply dummy tex</td>
          </tr> -->
        </tbody>
      </table>
		<p>Terms Of Delivery</p>
		</td>
      </tr>
</table></td>
    </tr>
    <tr>
      <td align="left" valign="top"><table width="100%" cellpadding="0" cellspacing="0" class="table tableCus table5" id="example">
        <thead>
          <tr>
            <td scope="col" class="col_13_1 titleTd border_bottom">Sl No</td>
            <td scope="col" class="col_13_2 titleTd border_bottom">Description Of Goods</td>
            <td scope="col" class="col_13_3 titleTd border_bottom">HSN/SAC</td>
            <td scope="col" class="col_13_4 titleTd border_bottom">Quantity</td>
            <td scope="col" class="col_13_5 titleTd border_bottom">Rate</td>
			  
			 <!-- <td scope="col" class="col_13_6 titleTd border_bottom">Per</td> -->
			  <td scope="col" class="col_13_7 titleTd border_bottom">Amount</td>
			  <td scope="col" class="col_13_8 titleTd border_bottom">Taxable Value</td>
			  <td scope="col" class="col_13_9 titleTd border_bottom">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table6" id="example">
			    <tbody>
			      <tr>
			        <td style=" border: none !important;"><strong>CGST</strong></td>
			        </tr>
			      <tr>
			        <td style="padding: 0; margin: 0;  border-right: none !important;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table7" id="example">
			          <tbody>
			            <tr>
			              <td width="50%" class="col_50Per">Rate</td>
			              <td class="col_50Per">Amount</td>
			              </tr>
			            </tbody>
			          </table></td>
			        </tr>
			      </tbody>
			    </table></td>
			  <td scope="col" class="col_13_10 titleTd border_bottom">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table8" id="example">
			    <tbody>
			      <tr>
			        <td style=" border: none !important;"><strong>SGST</strong></td>
			        </tr>
			      <tr>
			        <td style="margin: 0;  border-right: none !important;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table9" id="example">
			          <tbody>
			            <tr>
			              <td width="50%" class="col_50Per">Rate</td>
			              <td class="col_50Per">Amount</td>
			              </tr>
			            </tbody>
			          </table></td>
			        </tr>
			      </tbody>
			    </table></td>  
			  <td scope="col" class="col_13_11 titleTd border_bottom"><strong>Total Amount</strong></td>
			  </tr>
        </thead>
        <tbody>
          <tr>
            <td scope="row" class="border_right">1</td>
            <td align="left" valign="top" class="border_right"><strong><?php echo  $data->prod_desc;?><br>
              <!-- Godown: 316545455 -->
              </strong>
              <!-- <p><strong>Batch: EFFFFFLOKO</strong></p> -->
              </td>
            <td align="left" valign="top" class="border_right"><?php echo  $data->hsn_code;?></td>
            <td align="left" valign="top" class="border_right"><strong><?php echo  $data->qty;?>
              </strong>
              <!-- 0.254 Mt. -->
              
              <!-- <p><strong>0.254 Mt.</strong> <strong><br> -->
              </td>
            <td align="left" valign="top" class="border_right"><?php echo  $data->sale_rt;?></td>
			       <!-- <td align="left" valign="top" class="border_right">Mt.</td> -->
            <td align="left" valign="top" class="border_right"><?php echo  $data->taxable_amt;?></td>
            <td align="left" valign="top" class="border_right"><?php echo  $data->taxable_amt;?></td>
		<td align="left" valign="top" class="border_right">&nbsp;</td>
            <td align="left" valign="top" style="padding: 0;" class="border_right">&nbsp;</td>

			  <td align="left" valign="top"><?php echo  $data->tot_amt;?></td>
			  </tr>
          <tr>
            <td scope="row" class="border_right">&nbsp;</td>
            <td align="left" valign="top" class="border_right"><strong><em>CGST (GST) (Output)<br>
              SGST (GST) (Output)<br>
              <!-- Round Of -->
              </em>
              </strong></td>
            <td align="left" valign="top" class="border_right">&nbsp;</td>
            <td align="left" valign="top" class="border_right">&nbsp;</td>
            <td align="left" valign="top" class="border_right">&nbsp;</td>
            <td align="left" valign="top" class="border_right">
              <!-- 452.25 -->
              </td>
            <td align="left" valign="top" class="border_right"><?php echo  $data->cgst;?><br>
            <?php echo  $data->sgst;?></td>
            <td align="left" valign="top" class="border_right">&nbsp;</td>
			  <td align="left" valign="top" class="border_right"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="table10" id="example">
			    <tbody>
			      <tr>
			        <td width="50%" class="col_50Per"><?php echo  $data->gst_rt/2;?>%</td>
			        <td class="col_50Per"><?php echo  $data->cgst;?></td>
			        </tr>
			      </tbody>
			    </table></td>
                <td align="left" valign="top" class="border_right"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="table11" id="example">
                  <tbody>
                    <tr>
                      <td width="50%" class="col_50Per"><?php echo  $data->gst_rt/2;?>%</td>
                      <td class="col_50Per"><?php echo  $data->cgst;?></td>
                    </tr>
                  </tbody>
                </table></td>
			  <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td scope="row" class="border_right">&nbsp;</td>
            <td align="left" valign="top" class="border_right"><strong><u>Bill Details</u></strong> <?php echo  $sum_data->tot_amt_rnd;?> Dr</td>
            <td align="left" valign="top" class="border_right">&nbsp;</td>
            <td align="left" valign="top" class="border_right">&nbsp;</td>
            <td align="left" valign="top" class="border_right">&nbsp;</td>
            <td align="left" valign="top" class="border_right">&nbsp;</td>
            <td align="left" valign="top" class="border_right">&nbsp;</td>
            <td align="left" valign="top" class="border_right">&nbsp;</td>
            <td align="left" valign="top" class="border_right">&nbsp;</td>
			  <td align="left" valign="top" class="border_right">&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td scope="row" class="border_right border_bottom">&nbsp;</td>
            <td align="left" valign="top" style="text-align: right;" class="border_right border_bottom"><strong style="text-align: right;">Total</strong></td>
            <td align="left" valign="top" class="border_right border_bottom">&nbsp;</td>
            <td align="left" ></td>
            <!-- <td align="left" valign="top" class="border_right border_bottom"><?php //echo  $sum_data->qty;?>Mt.</td> -->
            <td align="left" valign="top" class="border_right border_bottom">&nbsp;</td>
            <td align="left" valign="top" class="border_right border_bottom">&nbsp;</td>
            <td align="left" valign="top" class="border_right border_bottom"><strong><?php echo  $sum_data->tot_amt_rnd;?></strong></td>
            <td align="left" valign="top" class="border_right border_bottom"><?php echo  $sum_data->taxable_amt;?></td>
            <td align="left" valign="top" class="border_right border_bottom">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table12" id="example">
              <tbody>
                <tr>
                  <td width="50%" class="col_50Per">&nbsp;</td>
                  <td width="50%" class="col_50Per"><?php echo  $sum_data->cgst;?></td>
                </tr>
              </tbody>
            </table>
				
				</td>
            <td align="left" valign="top" class="border_right border_bottom">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table13" id="example">
              <tbody>
                <tr>
                  <td width="50%" class="col_50Per">&nbsp;</td>
                  <td class="col_50Per"><?php echo  $sum_data->sgst;?></td>
                </tr>
              </tbody>
            </table></td>
            <td align="left" valign="top" class="border_bottom">&nbsp;</td>
          </tr>
          
          
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td align="left" valign="top" class="formDurkBack border_bottom"><div style="padding: 0; margin: 0; float: left">Amount Chargable(in words)INR <?php echo getIndianCurrency($sum_data->tot_amt_rnd);?></div>
		<div style="padding: 0; margin: 0; float: right; text-align: right">E.&amp; O.	E</div>
		</td>
    </tr>
  </tbody>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table14" id="example">
  <tbody>
    <tr>
<td class="tax_1"><table width="100%" cellpadding="0" cellspacing="0" class="table tableCus table15" id="example">
        <thead>
          <tr>
          <td scope="col" class="col_12_1 titleTd border_bottom"></td>
            <td scope="col" class="col_12_2 titleTd border_bottom">Taxable Value</td>
            <td scope="col" class="col_12_3 titleTd border_bottom">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table15" id="example">
              <tbody>
                <tr>
                  <td style=" border: none !important;"><strong>CGST</strong></td>
                </tr>
                <tr>
                  <td style="margin: 0;  border-right: none !important;">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table16" id="example">
                    <tbody>
                      <tr>
                        <td width="50%" class="col_50Per">Rate</td>
                        <td class="col_50Per">Amount</td>
                      </tr>
                    </tbody>
                  </table></td>
                </tr>
              </tbody>
            </table></td>
            <td scope="col" class="col_12_4 titleTd border_bottom">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table17" id="example">
              <tbody>
                <tr>
                  <td style=" border: none !important;"><strong>SGST</strong></td>
                </tr>
                <tr>
                  <td style="margin: 0;  border-right: none !important;">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table18" id="example">
                    <tbody>
                      <tr>
                        <td width="50%" class="col_50Per">Rate</td>
                        <td class="col_50Per">Amount</td>
                      </tr>
                    </tbody>
                  </table></td>
                </tr>
              </tbody>
            </table></td>
            <td scope="col" class="col_12_5 titleTd border_bottom"><strong>Total Amount(Round)</strong></td>
          </tr>
        </thead>
        <tbody>
          <tr>
          <td align="left" valign="top"></td>
            <td align="left" valign="top"><?php echo  $sum_data->taxable_amt;?></td>
            <td align="left" valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table19" id="example">
              <tbody>
                <tr>
                  <td width="50%" class="col_50Per"><?php echo  $data->gst_rt/2;?></td>
                  <td class="col_50Per"><?php echo  $sum_data->cgst;?></td>
                </tr>
              </tbody>
            </table></td>
			  
            <td align="left" valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table20" id="example">
              <tbody>
                <tr>
                  <td width="50%" class="col_50Per"><?php echo  $data->gst_rt/2;?></td>
                  <td class="col_50Per"><?php echo  $sum_data->sgst;?></td>
                </tr>
              </tbody>
            </table></td>
            <td align="left" valign="top"><?php echo  $sum_data->tot_amt_rnd;?></td>
          </tr>
          
          <tr>
          <td align="right" valign="top"><strong>Total:</strong></td>
            <td align="left" valign="top"><?php echo  $sum_data->taxable_amt;?></td>
            <td align="left" valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table21" id="example">
              <tbody>
                <tr>
                  <td width="50%" class="col_50Per">&nbsp;</td>
                  <td class="col_50Per"><?php echo  $sum_data->cgst;?></td>
                  </tr>
                </tbody>
              </table></td>
            <td align="left" valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table22" id="example">
              <tbody>
                <tr>
                  <td width="50%" class="col_50Per">&nbsp;</td>
                  <td class="col_50Per"><?php echo  $sum_data->sgst;?></td>
                  </tr>
                </tbody>
              </table></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
      </tr>
      </tbody>
      </table>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table14" id="example">
  <tbody>
   
    <tr>
      <td class="formDurkBack border_bottom border_top"><p style="padding: 0; margin: 0; float: left">Tax Amount(in words)INR <?php echo getIndianCurrency($sum_data->tot_amt_rnd);?></p></td>
      <td class="formDurkBack border_bottom border_top" align="right">Total: <strong><?php echo  $sum_data->tot_amt_rnd;?></strong></td>
    </tr>
    <tr>
      <td align="left" valign="top" class="padding_topNew padding_botNew" style="padding-left: 5px; padding-right: 5px;">Company's GSTIN/UIN: <strong>19AABAT0010H2ZY</strong><br>
        Company's Pan:<strong> AABAT0010H</strong><br>
        Remarks: <strong><?php echo  $sum_data->remarks;?></strong>
      </td>
      <td align="left" valign="top" class="padding_topNew padding_botNew" style="padding-left: 5px; padding-right: 5px;">Company's Bank Details:<br>
        Bank Name:<br>
        A/C Number: <br>
        Branch &amp; IFS Code: </td>
    </tr>
    <tr>
      <td align="left" valign="top" class="formDurkBack border_bottom border_top"><strong>Declaration:</strong><br>
We declare that this invoice shows the actual price of goods described and particulars are true and correct,</td>
      <td align="left" valign="top" class="formDurkBack border_bottom border_top"><p style="padding: 0; margin: 0;"><strong>For The West Bengal State Co-operative Marketing Federation Ltd</strong></p></td>
    </tr>
    
  </tbody>
</table>
<div class="table23Main">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table23" id="example">
  <tbody>
   
    <tr>
      <td class="padding_topNew padding_botNew">Prepared By</td>
      <td class="padding_topNew padding_botNew">Verified By</td>
      <td class="padding_topNew padding_botNew">Authorised Signature</td></tr>
      </tbody>
      </table>
</div>

  </div>

<div class="billDateGroop">
  <!-- <div class="crmBill"><strong><?php echo "**"."&#2352;".$data->adv_amt."/-";?></strong></div>	 -->
<!-- <div class="dateTop">Date: <strong><?php echo  date("d-m-Y", strtotime($data->trans_dt));?></strong></div></div> -->
<br clear="all">
  <p style="padding:0; margin:0; float:left; font-size:12px;">**Subjet to Realisation</p>  <p style="padding:0; margin:0; font-size:12px; float:right;">Authorised Signatory</p>
<br>

</div>


    
  </div>

            
                    <div style="text-align: center;">
    
                        <button class="btn btn-primary" id=printbtn type="button" onclick="printDiv();">Print</button>
    
                    </div>
   </div>
</div>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.colVis.min.js"></script>
<script>
   $('#example').dataTable({
    destroy: true,
   searching: false,ordering: false,paging: false

// dom: 'Bfrtip',
// buttons: [
//    {
// extend: 'excelHtml5',
// title: 'ICMARD INSURANCE REPORT',
// text: 'Export to excel'
// //Columns to export
// // exportOptions: {
// //    columns: [0, 1, 2, 3]
// // }
//    }
// ]
   });
</script>
<!-- <script type="text/javascript">
        function print_page() {
            var ButtonControl = document.getElementById("printbtn");
            ButtonControl.style.visibility = "hidden";
            window.print();
        }
    </script> -->