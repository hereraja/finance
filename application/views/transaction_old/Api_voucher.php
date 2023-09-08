<?php
	class Api_voucher extends CI_Controller{
		protected $sysdate;
		protected $kms_year;
		public function __construct(){
		parent::__construct();	
        $this->load->model('Transaction_model');
        $this->load->model('Api_model');
        }

	
        public function f_acc_code(){
		 
            $select	=	array("a.*");
            $data    = $this->Api_model->f_select("md_achead a",$select,NULL,0);
            // $curl = curl_init();
            echo json_encode($data);
        }
        public function company_payAdd(){
            $acc = $this->Transaction_model->f_select('md_achead ',Null,NULL,0); 

            $curl = curl_init();
		
			curl_setopt_array($curl, array(
		
			CURLOPT_URL => 'http://localhost/benfed/benfed_fertilizer/index.php/compay/comp_acc',
             //CURLOPT_URL => 'http://benfed.in/benfed_fertilizer/index.php/compay/comp_acc',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
				"data": '.json_encode($acc).'
			}',
			
			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Cookie: ci_session=eieqmu6gupm05pkg5o78jqbq97jqb22g'
			  ),
			));
			
			$response = curl_exec($curl);
			
			curl_close($curl);
			echo $response;
			
	
        }


        public function sale_voucher(){
             
        $input = file_get_contents("php://input");
       
        $dt = json_decode($input, true);
        $fin_yr['fin_yr']= $dt['data']['fin_yr'];

        
        $select    = array("max(sl_no)+1 as sl" );
        $where     =$fin_yr;
           // print_r( $where);
        $v_id = $this->Transaction_model->f_select('td_vouchers ',$select,$where,1);
          // echo $this->db->last_query();
         //  print_r( $v_id);
        // var_dump($v_id);
       // exit;
  
         $input_data = array(
        'voucher_date'   => $dt['data']['do_dt'],
        // 'sl_no'          => $v_id->sl,
        'voucher_id'     => 'SALE'.$dt['data']['trans_do'],
        'branch_id'      => $dt['data']['br_cd'],
        'trans_no'       => $dt['data']['trans_do'],
        'trans_dt'       => $dt['data']['do_dt'],  
        'voucher_type'   => 'SL',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => $dt['data']['soc_id'],
        'dr_cr_flag'     => 'DR',
        'amount'         => $dt['data']['tot_amt'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'A',
        'user_flag'      =>'',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => '',
        'approved_dt'    => '',
        'fin_yr'         => $dt['data']['fin_yr']    
    );
    $input_cgst = array(
        'voucher_date'   => $dt['data']['do_dt'],
        // 'sl_no'          => $v_id->sl,
        'voucher_id'     => 'SALE'.$dt['data']['trans_do'],
        'branch_id'      => $dt['data']['br_cd'],
        'trans_no'       => $dt['data']['trans_do'],
        'trans_dt'       => $dt['data']['do_dt'],  
        'voucher_type'   => 'SL',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => 2205,
        'dr_cr_flag'     => 'CR',
        'amount'         => $dt['data']['cgst'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'A',
        'user_flag'      => '',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => '',
        'approved_dt'    => '',
        'fin_yr'         => $dt['data']['fin_yr']    
    );
    
    $input_sgst = array(
        'voucher_date'   => $dt['data']['do_dt'],
        // 'sl_no'          => $v_id->sl,
        'voucher_id'     => 'SALE'.$dt['data']['trans_do'],
        'branch_id'      => $dt['data']['br_cd'],
        'trans_no'       => $dt['data']['trans_do'],
        'trans_dt'       => $dt['data']['do_dt'],  
        'voucher_type'   => 'SL',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => 2206,
        'dr_cr_flag'     => 'CR',
        'amount'         => $dt['data']['sgst'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'A',
        'user_flag'      => '',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => '',
        'approved_dt'    => '',
        'fin_yr'         => $dt['data']['fin_yr']    
    );
     
        $input_sale = array(
            'voucher_date'   => $dt['data']['do_dt'],
            // 'sl_no'          => $v_id->sl,
            'voucher_id'     => 'SALE'.$dt['data']['trans_do'],
            'branch_id'      => $dt['data']['br_cd'],
            'trans_no'       => $dt['data']['trans_do'],
            'trans_dt'       => $dt['data']['do_dt'],  
            'voucher_type'   => 'SL',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => 2207,
            'dr_cr_flag'     => 'CR',
            'amount'         => $dt['data']['taxable_amt'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'A',
            'user_flag'      => '',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => '',
            'approved_dt'    => '',
            'fin_yr'         => $dt['data']['fin_yr']    
        );

        // echo '<pre>';
        // echo 'input_data<br>'; var_dump($input_data);
        // echo 'input_cgst<br>'; var_dump($input_cgst);
        // echo 'input_sgst<br>'; var_dump($input_sgst);
        // echo 'input_sale<br>'; var_dump($input_sale);
        // exit;

        if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_cgst) && $this->db->insert('td_vouchers', $input_sgst) && $this->db->insert('td_vouchers', $input_sale) ){
        return 1;
    }else{
        return 0;
    }  
                     
        }


          public function salecrn_voucher(){
             
        $input = file_get_contents("php://input");
       
        $dt = json_decode($input, true);
        $fin_yr['fin_yr']= $dt['data']['fin_yr'];

        
        $select    = array("max(sl_no)+1 as sl" );
        $where     =$fin_yr;
           // print_r( $where);
        $v_id = $this->Transaction_model->f_select('td_vouchers ',$select,$where,1);
          // echo $this->db->last_query();
         //  print_r( $v_id);
        // var_dump($v_id);
       // exit;
  
         $input_data = array(
        'voucher_date'   => $dt['data']['do_dt'],
        // 'sl_no'          => $v_id->sl,
        'voucher_id'     => 'SALE'.$dt['data']['trans_do'],
        'branch_id'      => $dt['data']['br_cd'],
        'trans_no'       => $dt['data']['trans_do'],
        'trans_dt'       => $dt['data']['do_dt'],  
        'voucher_type'   => 'SL',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => $dt['data']['soc_id'],
        'dr_cr_flag'     => 'CR',
        'amount'         => $dt['data']['tot_amt'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'A',
        'user_flag'      =>'',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => '',
        'approved_dt'    => '',
        'fin_yr'         => $dt['data']['fin_yr']    
    );
    $input_cgst = array(
        'voucher_date'   => $dt['data']['do_dt'],
        // 'sl_no'          => $v_id->sl,
        'voucher_id'     => 'SALE'.$dt['data']['trans_do'],
        'branch_id'      => $dt['data']['br_cd'],
        'trans_no'       => $dt['data']['trans_do'],
        'trans_dt'       => $dt['data']['do_dt'],  
        'voucher_type'   => 'SL',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => 2205,
        'dr_cr_flag'     => 'DR',
        'amount'         => $dt['data']['cgst'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'A',
        'user_flag'      => '',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => '',
        'approved_dt'    => '',
        'fin_yr'         => $dt['data']['fin_yr']    
    );
    
    $input_sgst = array(
        'voucher_date'   => $dt['data']['do_dt'],
        // 'sl_no'          => $v_id->sl,
        'voucher_id'     => 'SALE'.$dt['data']['trans_do'],
        'branch_id'      => $dt['data']['br_cd'],
        'trans_no'       => $dt['data']['trans_do'],
        'trans_dt'       => $dt['data']['do_dt'],  
        'voucher_type'   => 'SL',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => 2206,
        'dr_cr_flag'     => 'DR',
        'amount'         => $dt['data']['sgst'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'A',
        'user_flag'      => '',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => '',
        'approved_dt'    => '',
        'fin_yr'         => $dt['data']['fin_yr']    
    );
     
        $input_sale = array(
            'voucher_date'   => $dt['data']['do_dt'],
            // 'sl_no'          => $v_id->sl,
            'voucher_id'     => 'SALE'.$dt['data']['trans_do'],
            'branch_id'      => $dt['data']['br_cd'],
            'trans_no'       => $dt['data']['trans_do'],
            'trans_dt'       => $dt['data']['do_dt'],  
            'voucher_type'   => 'SL',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => 2207,
            'dr_cr_flag'     => 'DR',
            'amount'         => $dt['data']['taxable_amt'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'A',
            'user_flag'      => '',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => '',
            'approved_dt'    => '',
            'fin_yr'         => $dt['data']['fin_yr']    
        );

        // echo '<pre>';
        // echo 'input_data<br>'; var_dump($input_data);
        // echo 'input_cgst<br>'; var_dump($input_cgst);
        // echo 'input_sgst<br>'; var_dump($input_sgst);
        // echo 'input_sale<br>'; var_dump($input_sale);
        // exit;

        if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_cgst) && $this->db->insert('td_vouchers', $input_sgst) && $this->db->insert('td_vouchers', $input_sale) ){
        return 1;
    }else{
        return 0;
    }  
                     
        }
        //salecrn_voucher

/***************************************** */

// public function salecr_voucher(){
             
//     $input = file_get_contents("php://input");
   
//     $dt = json_decode($input, true);
//     $fin_yr['fin_yr']= $dt['data']['fin_yr'];
    
//     $select    = array("max(sl_no)+1 as sl" );
//     $where     =$fin_yr;
//     // print_r( $where);
//     $v_id = $this->Transaction_model->f_select('td_vouchers ',$select,$where,1);
//     echo $this->db->last_query();
    
//      print_r( $v_id);
//     // var_dump($v_id);
//    // exit;

//      $input_data = array(
//     'voucher_date'   => $dt['data']['do_dt'],
//     'sl_no'          => $v_id->sl,
//     'voucher_id'     => 'SALE'.$dt['data']['trans_do'],
//     'branch_id'      => $dt['data']['br_cd'],
//     'trans_no'       => $dt['data']['trans_do'],
//     'trans_dt'       => $dt['data']['do_dt'],  
//     'voucher_type'   => 'CRN',
//     'transfer_type'  => 'T',
//     'voucher_mode'   => 'J',
//     'voucher_through'=> 'A',
//     'acc_code'       => $dt['data']['soc_id'],
//     'dr_cr_flag'     => 'CR',
//     'amount'         => $dt['data']['tot_amt'],
//     'ins_no'         => '',
//     'ins_dt'         => '',
//     'bank_name'      => '',
//     'remarks'        => 'CRN',
//     'approval_status'=> 'U',
//     'user_flag'      =>'',
//     'created_dt'     => $dt['data']['created_dt'],
//     'created_by'     => $dt['data']['created_by'],
//     'modified_by'    => '',
//     'modified_dt'    => '',
//     'approved_by'    => '',
//     'approved_dt'    => '',
//     'fin_yr'         => $dt['data']['fin_yr']    
// );
// $input_cgst = array(
//     'voucher_date'   => $dt['data']['do_dt'],
//     'sl_no'          => $v_id->sl,
//     'voucher_id'     => 'CRN'.$dt['data']['trans_do'],
//     'branch_id'      => $dt['data']['br_cd'],
//     'trans_no'       => $dt['data']['trans_do'],
//     'trans_dt'       => $dt['data']['do_dt'],  
//     'voucher_type'   => 'CRN',
//     'transfer_type'  => 'T',
//     'voucher_mode'   => 'J',
//     'voucher_through'=> 'A',
//     'acc_code'       => 2205,
//     'dr_cr_flag'     => 'CR',
//     'amount'         => $dt['data']['cgst'],
//     'ins_no'         => '',
//     'ins_dt'         => '',
//     'bank_name'      => '',
//     'remarks'        => 'CRN',
//     'approval_status'=> 'U',
//     'user_flag'      => '',
//     'created_dt'     => $dt['data']['created_dt'],
//     'created_by'     => $dt['data']['created_by'],
//     'modified_by'    => '',
//     'modified_dt'    => '',
//     'approved_by'    => '',
//     'approved_dt'    => '',
//     'fin_yr'         => $dt['data']['fin_yr']    
// );

// $input_sgst = array(
//     'voucher_date'   => $dt['data']['do_dt'],
//     'sl_no'          => $v_id->sl,
//     'voucher_id'     => 'CRN'.$dt['data']['trans_do'],
//     'branch_id'      => $dt['data']['br_cd'],
//     'trans_no'       => $dt['data']['trans_do'],
//     'trans_dt'       => $dt['data']['do_dt'],  
//     'voucher_type'   => 'CRN',
//     'transfer_type'  => 'T',
//     'voucher_mode'   => 'J',
//     'voucher_through'=> 'A',
//     'acc_code'       => 2206,
//     'dr_cr_flag'     => 'DR',
//     'amount'         => $dt['data']['sgst'],
//     'ins_no'         => '',
//     'ins_dt'         => '',
//     'bank_name'      => '',
//     'remarks'        => 'CRN',
//     'approval_status'=> 'U',
//     'user_flag'      => '',
//     'created_dt'     => $dt['data']['created_dt'],
//     'created_by'     => $dt['data']['created_by'],
//     'modified_by'    => '',
//     'modified_dt'    => '',
//     'approved_by'    => '',
//     'approved_dt'    => '',
//     'fin_yr'         => $dt['data']['fin_yr']    
// );
 
//     $input_sale = array(
//         'voucher_date'   => $dt['data']['do_dt'],
//         'sl_no'          => $v_id->sl,
//         'voucher_id'     => 'CRN'.$dt['data']['trans_do'],
//         'branch_id'      => $dt['data']['br_cd'],
//         'trans_no'       => $dt['data']['trans_do'],
//         'trans_dt'       => $dt['data']['do_dt'],  
//         'voucher_type'   => 'CRN',
//         'transfer_type'  => 'T',
//         'voucher_mode'   => 'J',
//         'voucher_through'=> 'A',
//         'acc_code'       => 2207,
//         'dr_cr_flag'     => 'DR',
//         'amount'         => $dt['data']['taxable_amt'],
//         'ins_no'         => '',
//         'ins_dt'         => '',
//         'bank_name'      => '',
//         'remarks'        => 'CRN',
//         'approval_status'=> 'U',
//         'user_flag'      => '',
//         'created_dt'     => $dt['data']['created_dt'],
//         'created_by'     => $dt['data']['created_by'],
//         'modified_by'    => '',
//         'modified_dt'    => '',
//         'approved_by'    => '',
//         'approved_dt'    => '',
//         'fin_yr'         => $dt['data']['fin_yr']    
//     );

//     if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_cgst) && $this->db->insert('td_vouchers', $input_sgst) && $this->db->insert('td_vouchers', $input_sale) ){
//     return 1;
// }else{
//     return 0;
// }  
                 
//     }

/****************************************************** */
public function recv_voucher_cr(){
             
    $input = file_get_contents("php://input");
   
    $dt = json_decode($input, true);
    // var_dump($dt);exit;
    $fin_yr['fin_yr']= $dt['data']['fin_yr'];
    $paid_id=$dt['data']['paid_id'];
    $select    = array("ISNULL(max(sl_no))+1 as sl" );
    $where     =$fin_yr;
    // print_r( $where);
    $v_id = $this->Transaction_model->f_select('td_vouchers ',$select,NULL,1); 
    // echo $this->db->last_query();
    
     $input_bank     = array(
    'voucher_date'   => $dt['data']['paid_dt'],
    'voucher_id'     => 'RECV'.$dt['data']['paid_id'],
    'branch_id'      => $dt['data']['branch_id'],
    'trans_no'       =>'RECV'.$dt['data']['paid_id'],
    'trans_dt'       => $dt['data']['paid_dt'],  
    'voucher_type'   => 'RECV',
    'transfer_type'  => 'T',
    'voucher_mode'   => 'J',
    'voucher_through'=> 'A',
    'acc_code'       => $dt['data']['adv_acc'],
    'dr_cr_flag'     => 'DR',
    'amount'         => $dt['data']['paid_amt'],
    'ins_no'         => '',
    'ins_dt'         => '',
    'bank_name'      => '',
    'remarks'        => $dt['data']['rem'],
    'approval_status'=> 'U',
    'user_flag'      =>'',
    'created_dt'     => $dt['data']['created_dt'],
    'created_by'     => $dt['data']['created_by'],
    'modified_by'    => '',
    'modified_dt'    => '',
    'approved_by'    => '',
    'approved_dt'    => '',
    'fin_yr'         => $dt['data']['fin_yr']    
);
if($this->db->insert('td_vouchers', $input_bank) ){
    return 1;
}else{
    return 0;
}  
 }

 public function  recv_voucher_soc(){
             
    $input = file_get_contents("php://input");
    $dt = json_decode($input, true);
    // var_dump($dt);exit;
    $fin_yr['fin_yr']= $dt['data']['fin_yr'];
    $paid_id=$dt['data']['paid_id'];
    $select    = array("ISNULL(max(sl_no))+1 as sl" );
    $where     =$fin_yr;
    // print_r( $where);
    $v_id = $this->Transaction_model->f_select('td_vouchers ',$select,NULL,1);
    
    // echo $this->db->last_query();
    
     $input_bank     = array(
    'voucher_date'   => $dt['data']['paid_dt'],
    'voucher_id'     =>  'RECV'.$dt['data']['paid_id'],
    'branch_id'      => $dt['data']['branch_id'],
    'trans_no'       =>'RECV'.$dt['data']['paid_id'],
    'trans_dt'       => $dt['data']['paid_dt'],  
    'voucher_type'   => 'RECV',
    'transfer_type'  => 'T',
    'voucher_mode'   => 'J',
    'voucher_through'=> 'A',
    // 'acc_code'       => $dt['data']['soc_id'],
    'acc_code'       => $dt['data']['acc_cd'],
    'dr_cr_flag'     => 'CR',
    'amount'         => $dt['data']['paid_amt'],
    'ins_no'         => '',
    'ins_dt'         => '',
    'bank_name'      => '',
    'remarks'        => $dt['data']['rem'],
    'approval_status'=> 'U',
    'user_flag'      =>'',
    'created_dt'     => $dt['data']['created_dt'],
    'created_by'     => $dt['data']['created_by'],
    'modified_by'    => '',
    'modified_dt'    => '',
    'approved_by'    => '',
    'approved_dt'    => '',
    'fin_yr'         => $dt['data']['fin_yr']    
);
if($this->db->insert('td_vouchers', $input_bank) ){
    return 1;
}else{
    return 0;
}  
 }


public function recv_voucher(){
             
    $input = file_get_contents("php://input");
    
    $dt = json_decode($input, true);
    // var_dump($dt);exit;
    $fin_yr['fin_yr']= $dt['data']['fin_yr'];
    $paid_id=$dt['data']['paid_id'];
    $cshbank_flag['cshbank'] = $dt['data']['cshbank'];
    $br_id['branch_id'] = $dt['data']['branch_id'];
    $select    = array("ISNULL(max(sl_no))+1 as sl" );
    // $where     =$fin_yr;
    // print_r( $where);
    $v_id = $this->Transaction_model->f_select('td_vouchers ',$select,NULL,1);
    
    if ( $cshbank_flag['cshbank']==0){
        $select_cash    = array("sl_no" );
        $where_cash  = array(
            "mngr_id"   => 6 ,
            "subgr_id"  => 56,
            "br_id"     => $br_id['branch_id']);
        $cshbank_code = $this->Transaction_model->f_select('md_achead ',$select_cash ,$where_cash,1);
        
        $input_data = array(
            'voucher_date'   => $dt['data']['paid_dt'],
            //'sl_no'          => $v_id->sl,
            'voucher_id'     => 'RECV'.$dt['data']['paid_id'],
            'branch_id'      => $dt['data']['branch_id'],
            'trans_no'       => $dt['data']['paid_id'],
            'trans_dt'       => $dt['data']['paid_dt'],  
            'voucher_type'   => 'A',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            // 'acc_code'       => $dt['data']['soc_id'],
            'acc_code'       => $cshbank_code->sl_no ,
            'dr_cr_flag'     => 'DR',
            'amount'         => $dt['data']['paid_amt'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'U',
            'user_flag'      =>'',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => '',
            'approved_dt'    => '',
            'fin_yr'         => $dt['data']['fin_yr']    
        );
         // if($this->db->insert('td_vouchers', $input_bank) && $this->db->insert('td_vouchers', $input_soc) ){
            if( $this->db->insert('td_vouchers', $input_data)){
                // echo 'true';
        echo '1';
    }else{
        // echo 'False';
        echo '0';
    }  
    }else{

    

$input_soc = array(
    'voucher_date'   => $dt['data']['paid_dt'],
    'voucher_id'     =>  'RECV'.$dt['data']['paid_id'],
    'branch_id'      => $dt['data']['branch_id'],
    'trans_no'       => 'RECV'.$dt['data']['paid_id'],
    'trans_dt'       => $dt['data']['paid_dt'],  
    'voucher_type'   => 'RECV',
    'transfer_type'  => 'T',
    'voucher_mode'   => 'J',
    'voucher_through'=> 'A',
    // 'acc_code'       => $dt['data']['bnk_id'],
    'acc_code'       => $dt['data']['acc_code'],
    'dr_cr_flag'     => 'DR',
    'amount'         => $dt['data']['paid_amt'],
    'ins_no'         => '',
    'ins_dt'         => '',
    'bank_name'      => '',
    'remarks'        => $dt['data']['rem'],
    'approval_status'=> 'U',
    'user_flag'      => '',
    'created_dt'     => $dt['data']['created_dt'],
    'created_by'     => $dt['data']['created_by'],
    'modified_by'    => '',
    'modified_dt'    => '',
    'approved_by'    => '',
    'approved_dt'    => '',
    'fin_yr'         => $dt['data']['fin_yr']    
);
 // if($this->db->insert('td_vouchers', $input_bank) && $this->db->insert('td_vouchers', $input_soc) ){
    if( $this->db->insert('td_vouchers', $input_soc) ){
        // echo 'true';
echo '1';
}else{
// echo 'False';
echo '0';
}  
}
   
                 
    }


   public function compay_voucher(){

        $input = file_get_contents("php://input");
       
        $dt = json_decode($input, true);
         $fin_yr['fin_yr']= $dt['data']['fin_yr'];
        
        $select    = array("max(sl_no)+1 as sl" );
        $where     = $fin_yr;
        
        $v_id = $this->Transaction_model->f_select('td_vouchers ',$select,$where,1);
        $input_bank     = array(
            'voucher_date'   => $dt['data']['pay_dt'],
            'voucher_id'     =>  'PMT'.$dt['data']['pay_no'],
            'branch_id'      => 332,
            'trans_no'       =>'PMT'.$dt['data']['pay_no'],
            'trans_dt'       => $dt['data']['pay_dt'],  
            'voucher_type'   => 'PMT',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => $dt['data']['bnk_ac_cd'],
            'dr_cr_flag'     => 'DR',
            'amount'         => $dt['data']['paid_amt'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'U',
            'user_flag'      =>'',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => '',
            'approved_dt'    => '',
            'fin_yr'         => $dt['data']['fin_yr']    
        );

        $input_acc    = array(
            'voucher_date'   => $dt['data']['pay_dt'],
            'voucher_id'     =>  'PMT'.$dt['data']['pay_no'],
            'branch_id'      => 332,
            'trans_no'       =>'PMT'.$dt['data']['pay_no'],
            'trans_dt'       => $dt['data']['pay_dt'],  
            'voucher_type'   => 'PMT',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => $dt['data']['acc_code'],
            'dr_cr_flag'     => 'CR',
            'amount'         => $dt['data']['paid_amt'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'U',
            'user_flag'      =>'',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => '',
            'approved_dt'    => '',
            'fin_yr'         => $dt['data']['fin_yr']    
        );

        if($this->db->insert('td_vouchers', $input_bank) &&  $this->db->insert('td_vouchers',$input_acc)  ){

            return 1;
        }
        else{
            return 0;
        }  

    }

      /********************************************** */   
      public function purchase_voucher(){
             
        $input = file_get_contents("php://input");
        // $dt = $input ? $input[0] : $input;
        $dt = json_decode($input, true);
        $fin_yr['fin_yr']= $dt['data']['fin_yr'];
        
        // $select    = array("max(sl_no)+1 as sl" );
        // $where     =$fin_yr;
        //  print_r( $where);
        $sl_no    = $this->Transaction_model->f_get_voucher_id($fin_yr['fin_yr']);
        $v_srl=$sl_no->sl_no;

        $v_id= $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;
        
        // print_r($sl_no);
        // exit;
         $input_data = array(
        'voucher_date'   => $dt['data']['trans_dt'],
        'sl_no'          => $v_srl,
        // 'voucher_id'     => 'Purchase'.$dt['data']['ro_no'],
        'voucher_id'     => $v_id,
        'branch_id'      => $dt['data']['br'],
        'trans_no'       => $dt['data']['ro_no'],
        'trans_dt'       => $dt['data']['trans_dt'],  
        'voucher_type'   => 'PUR',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => 2209,
        'dr_cr_flag'     => 'CR',
        'amount'         => $dt['data']['tot_amt'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'A',
        'user_flag'      =>'',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => '',
        'approved_dt'    => '',
        'fin_yr'         => $dt['data']['fin_yr']    
    );

     if ($dt['data']['rnd_of_add']>0){

    
    $input_rndcr = array(
        'voucher_date'   => $dt['data']['trans_dt'],
        'sl_no'          => $v_srl,
        // 'voucher_id'     => 'Purchase'.$dt['data']['ro_no'],
        'voucher_id'     => $v_id,
        'branch_id'      => $dt['data']['br'],
        'trans_no'       => $dt['data']['ro_no'],
        'trans_dt'       => $dt['data']['trans_dt'],  
        'voucher_type'   => 'PUR',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => 2211,
        'dr_cr_flag'     => 'DR',
        'amount'         => $dt['data']['rnd_of_add'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'A',
        'user_flag'      =>'',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => '',
        'approved_dt'    => '',
        'fin_yr'         => $dt['data']['fin_yr']    
    );
    $this->db->insert('td_vouchers', $input_rndcr) ;
}

    $input_cgst = array(
        'voucher_date'   => $dt['data']['trans_dt'],
        'sl_no'          => $v_srl,
        // 'voucher_id'     => 'Purchase'.$dt['data']['ro_no'],
        'voucher_id'     => $v_id,
        'branch_id'      => $dt['data']['br'],
        'trans_no'       => $dt['data']['ro_no'],
        'trans_dt'       => $dt['data']['trans_dt'],  
        'voucher_type'   => 'PUR',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => 2205,
        'dr_cr_flag'     => 'DR',
        'amount'         => $dt['data']['cgst'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'A',
        'user_flag'      => '',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => '',
        'approved_dt'    => '',
        'fin_yr'         => $dt['data']['fin_yr']    
    );
    
    $input_sgst = array(
        'voucher_date'   => $dt['data']['trans_dt'],
        'sl_no'          => $v_srl,
        // 'voucher_id'     => 'Purchase'.$dt['data']['ro_no'],
        'voucher_id'     => $v_id,
        'branch_id'      => $dt['data']['br'],
        'trans_no'       => $dt['data']['ro_no'],
        'trans_dt'       => $dt['data']['trans_dt'],  
        'voucher_type'   => 'PUR',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => 2206,
        'dr_cr_flag'     => 'DR',
        'amount'         => $dt['data']['sgst'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'A',
        'user_flag'      => '',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => '',
        'approved_dt'    => '',
        'fin_yr'         => $dt['data']['fin_yr']    
    );
    
              
        $input_pur= array(
            'voucher_date'   => $dt['data']['trans_dt'],
            'sl_no'          => $v_srl,
        // 'voucher_id'     => 'Purchase'.$dt['data']['ro_no'],
        'voucher_id'     => $v_id,
            'branch_id'      => $dt['data']['br'],
            'trans_no'       => $dt['data']['ro_no'],
            'trans_dt'       => $dt['data']['trans_dt'],  
            'voucher_type'   => 'PUR',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => 2208,
            'dr_cr_flag'     => 'DR',
            'amount'         => $dt['data']['net_amt'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'A',
            'user_flag'      => '',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => '',
            'approved_dt'    => '',
            'fin_yr'         => $dt['data']['fin_yr']    
        );

if ($dt['data']['rnd_of_less']>0){

    
    $input_rndcr = array(
        'voucher_date'   => $dt['data']['trans_dt'],
        'sl_no'          => $v_srl,
        // 'voucher_id'     => 'Purchase'.$dt['data']['ro_no'],
        'voucher_id'     => $v_id,
        'branch_id'      => $dt['data']['br'],
        'trans_no'       => $dt['data']['ro_no'],
        'trans_dt'       => $dt['data']['trans_dt'],  
        'voucher_type'   => 'PUR',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => 2211,
        'dr_cr_flag'     => 'CR',
        'amount'         => $dt['data']['rnd_of_less'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'U',
        'user_flag'      =>'',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => '',
        'approved_dt'    => '',
        'fin_yr'         => $dt['data']['fin_yr']    
    );
    $this->db->insert('td_vouchers', $input_rndcr) ;
}

if ($dt['data']['rbt_add']>0){

    
    $input_rbt = array(
        'voucher_date'   => $dt['data']['trans_dt'],
        'sl_no'          => $v_srl,
        // 'voucher_id'     => 'Purchase'.$dt['data']['ro_no'],
        'voucher_id'     => $v_id,
        'branch_id'      => $dt['data']['br'],
        'trans_no'       => $dt['data']['ro_no'],
        'trans_dt'       => $dt['data']['trans_dt'],  
        'voucher_type'   => 'PUR',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => 2210,
        'dr_cr_flag'     => 'DR',
        'amount'         => $dt['data']['rbt_add'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'A',
        'user_flag'      =>'',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => '',
        'approved_dt'    => '',
        'fin_yr'         => $dt['data']['fin_yr']    
    );
    $this->db->insert('td_vouchers', $input_rbt);
}


if ($dt['data']['rbt_less']>0){

    
    $input_rbt = array(
        'voucher_date'   => $dt['data']['trans_dt'],
        'sl_no'          => $v_srl,
        // 'voucher_id'     => 'Purchase'.$dt['data']['ro_no'],
        'voucher_id'     => $v_id,
        'branch_id'      => $dt['data']['br'],
        'trans_no'       => $dt['data']['ro_no'],
        'trans_dt'       => $dt['data']['trans_dt'],  
        'voucher_type'   => 'PUR',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => 2210,
        'dr_cr_flag'     => 'CR',
        'amount'         => $dt['data']['rbt_less'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'U',
        'user_flag'      =>'',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => '',
        'approved_dt'    => '',
        'fin_yr'         => $dt['data']['fin_yr']    
    );
    $this->db->insert('td_vouchers', $input_rbt);
}

        if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_cgst) && $this->db->insert('td_vouchers', $input_sgst) && $this->db->insert('td_vouchers', $input_pur) ){
        return 1;
    }
    else{
        return 0;
    }  
      
    
        }
      /******************************************* */

      public function adv_voucher(){
             
        $input = file_get_contents("php://input");
        // $dt = $input ? $input[0] : $input;
        $dt = json_decode($input, true);
        // print_r($br_id['branch_id']); 
        // exit;
        // print_r($dt);
        // exit;
        
        $fin_yr['fin_yr']= $dt['data']['fin_yr'];
        $cshbank_flag['cshbnk_flag'] = $dt['data']['cshbnk_flag'];
        $br_id['branch_id'] = $dt['data']['branch_id'];

        $sl_no    = $this->Transaction_model->f_get_voucher_id($fin_yr['fin_yr']);
        $v_srl=$sl_no->sl_no;

        $v_id= $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;
        // print_r($br_id['branch_id']); 
        // exit;

        // $select    = array("max(sl_no)+1 as sl" );
        // $where     =$fin_yr;
        //  print_r( $where);
        // $v_id = $this->Transaction_model->f_select('td_vouchers ',$select,NULL,1);
        // echo $this->db->last_query();
        //  print_r( $v_id); 
 
        if ( $cshbank_flag['cshbnk_flag']==0){
            $select_cash    = array("sl_no" );
            $where_cash  = array(
                "mngr_id"   => 6 ,
                "subgr_id"  => 56,
                "br_id"     => $br_id['branch_id']);
            $cshbank_code = $this->Transaction_model->f_select('md_achead ',$select_cash ,$where_cash,1);
            
            $input_data = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
               // 'voucher_id'     => 'ADV'.$dt['data']['sl_no'],
               'voucher_id'     =>$v_id,
                'branch_id'      => $dt['data']['branch_id'],
                'trans_no'       => $dt['data']['receipt_no'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'A',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                // 'acc_code'       => $dt['data']['soc_id'],
                'acc_code'       => $cshbank_code->sl_no ,
                'dr_cr_flag'     => 'DR',
                'amount'         => $dt['data']['adv_amt'],
                'ins_no'         => '',
                'ins_dt'         => '',
                'bank_name'      => '',
                'remarks'        => $dt['data']['rem'],
                'approval_status'=> 'U',
                'user_flag'      =>'',
                'created_dt'     => $dt['data']['created_dt'],
                'created_by'     => $dt['data']['created_by'],
                'modified_by'    => '',
                'modified_dt'    => '',
                'approved_by'    => '',
                'approved_dt'    => '',
                'fin_yr'         => $dt['data']['fin_yr']    
            );
        }else{
            $input_data = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
               // 'voucher_id'     => 'ADV'.$dt['data']['sl_no'],
               'voucher_id'     =>$v_id,
                'branch_id'      => $dt['data']['branch_id'],
                'trans_no'       => $dt['data']['receipt_no'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'A',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                // 'acc_code'       => $dt['data']['soc_id'],
                'acc_code'       =>  $dt['data']['acc_code'],
                'dr_cr_flag'     => 'DR',
                'amount'         => $dt['data']['adv_amt'],
                'ins_no'         => '',
                'ins_dt'         => '',
                'bank_name'      => '',
                'remarks'        => $dt['data']['rem'],
                'approval_status'=> 'U',
                'user_flag'      =>'',
                'created_dt'     => $dt['data']['created_dt'],
                'created_by'     => $dt['data']['created_by'],
                'modified_by'    => '',
                'modified_dt'    => '',
                'approved_by'    => '',
                'approved_dt'    => '',
                'fin_yr'         => $dt['data']['fin_yr']    
            );    
        }

       
              
        $input_cr= array(
            'voucher_date'   => $dt['data']['trans_dt'],
            'sl_no'          => $v_srl,
            // 'voucher_id'     => 'ADV'.$dt['data']['sl_no'],
            'voucher_id'     =>$v_id,
            'branch_id'      => $dt['data']['branch_id'],
            'trans_no'       => $dt['data']['receipt_no'],
            'trans_dt'       => $dt['data']['trans_dt'],  
            'voucher_type'   => 'A',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => $dt['data']['adv_acc'],
            'dr_cr_flag'     => 'CR',
            'amount'         => $dt['data']['adv_amt'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'U',
            'user_flag'      => '',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => '',
            'approved_dt'    => '',
            'fin_yr'         => $dt['data']['fin_yr']    
        );


        if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_cr) ){
        return 1;
    }
    else{
        return 0;
    }  
      
    
        }


      /*********************************************** */

      public function crn_voucher(){
             
        $input = file_get_contents("php://input");
        // $dt = $input ? $input[0] : $input;
        $dt = json_decode($input, true);
        $fin_yr['fin_yr']= $dt['data']['fin_yr'];
        $sl_no    = $this->Transaction_model->f_get_voucher_id($fin_yr['fin_yr']);
        $v_srl=$sl_no->sl_no;

        $v_id= $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;
       // $select    = array("max(sl_no)+1 as sl" );
        // $where     =$fin_yr;
        //  print_r( $where);
        //$v_id = $this->Transaction_model->f_select('td_vouchers ',$select,NULL,1);
        // echo $this->db->last_query();
        //  print_r( $v_id); 
 
         $input_data = array(
        'voucher_date'   => $dt['data']['trans_dt'],
        'sl_no'          =>  $v_srl,
        //'voucher_id'     => 'CRN'.$dt['data']['ro'],
        'voucher_id'     =>$v_id,
        'branch_id'      => $dt['data']['branch_id'],
        'trans_no'       => $dt['data']['recpt_no'],
        'trans_dt'       => $dt['data']['trans_dt'],  
        'voucher_type'   => 'CRN',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => $dt['data']['soc_id'],
        'dr_cr_flag'     => 'CR',
        'amount'         => $dt['data']['tot_amt'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'U',
        'user_flag'      =>'',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => '',
        'approved_dt'    => '',
        'fin_yr'         => $dt['data']['fin_yr']    
    );
              
        $input_cr= array(
            'voucher_date'   => $dt['data']['trans_dt'],
            'sl_no'          =>  $v_srl,
            //'voucher_id'     => 'CRN'.$dt['data']['ro'],
            'voucher_id'     =>$v_id,
            'branch_id'      => $dt['data']['branch_id'],
            'trans_no'       => $dt['data']['recpt_no'],
            'trans_dt'       => $dt['data']['trans_dt'],  
            'voucher_type'   => 'CRN',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => $dt['data']['acc_cd'],
            'dr_cr_flag'     => 'DR',
            'amount'         => $dt['data']['tot_amt'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'U',
            'user_flag'      => '',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => '',
            'approved_dt'    => '',
            'fin_yr'         => $dt['data']['fin_yr']    
        );


        if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_cr) ){
        return 1;
    }
    else{
        return 0;
    }  
      
    
        }

      /******************************************** */
                
    }
?>
