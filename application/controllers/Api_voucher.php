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

/************************************************* *  Samabyaka Sale  */

        public function sale_voucher(){
             
        $input = file_get_contents("php://input");
        $dt = json_decode($input, true);
        $tot_roundoff = 0;
		$drsum        = 0;
        $fyrdtls= $this->Api_model->f_fin_yr_dtls_by_date($dt['data']['tr_dt']);
		$dt['data']['fin_fulyr'] = $fyrdtls->fin_yr;	
		$dt['data']['fin_yr'] = $fyrdtls->sl_no;
		$sl_no    = $this->Transaction_model->f_get_voucher_id($fyrdtls->sl_no);
        $v_srl = $sl_no->sl_no;
		$v_id = $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;	
        $drsum = $dt['data']['tot_amt'];
	    if($dt['data']['igst'] == 0){
			$crsum = round($dt['data']['cgst'],2) + round($dt['data']['sgst'],2)+ round($dt['data']['other_tax'],2) + round($dt['data']['taxable_amt'],2);
		}else{
			$crsum = round($dt['data']['igst'],2) + round($dt['data']['other_tax'],2) + round($dt['data']['taxable_amt'],2);
		}
		if($dt['data']['unit_id'] == 3){
		      $sale_dr = 1116;
			  $sale_cr = 2207;
		}else{
			  $sale_dr = 10079;
			  $sale_cr = 10078;
		}	
		 $tot_roundoff =	$drsum - $crsum;
         $input_data = array(
        'voucher_date'   => $dt['data']['tr_dt'],
        'sl_no'          => $v_srl,
        'voucher_id'     => $v_id,
	    'unit_id'        => $dt['data']['unit_id'],
		'unit_name'      => $dt['data']['unit_name'],	
        'branch_id'      => $dt['data']['br_cd'],
        'trans_no'       => $dt['data']['bill_no'],
        'trans_dt'       => $dt['data']['tr_dt'],  
        'voucher_type'   => 'SL',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => $sale_dr,
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
        'approved_by'    => 'SYSTEM',
        'approved_dt'    => $dt['data']['created_dt'],
        'fin_yr'         => $dt['data']['fin_yr']    
    );
	if($dt['data']['other_tax'] > 0){
		
		$input_othtax = array(
			'voucher_date'   => $dt['data']['tr_dt'],
			 'sl_no'          => $v_srl,
			'voucher_id'     => $v_id,
			'unit_id'        => $dt['data']['unit_id'],
		    'unit_name'      => $dt['data']['unit_name'],
			'branch_id'      => $dt['data']['br_cd'],
			'trans_no'       => $dt['data']['bill_no'],
			'trans_dt'       => $dt['data']['tr_dt'],  
			'voucher_type'   => 'SL',
			'transfer_type'  => 'T',
			'voucher_mode'   => 'J',
			'voucher_through'=> 'A',
			'acc_code'       => 8248,            //   Change on 31/03/2023 will active from 01/04/2023
			'dr_cr_flag'     => 'CR',
			'amount'         => $dt['data']['other_tax'],
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
			'approved_by'    => 'SYSTEM',
			'approved_dt'    => $dt['data']['created_dt'],
			'fin_yr'         => $dt['data']['fin_yr']    
		);
        $this->db->insert('td_vouchers', $input_othtax);
	
	}		
    if($dt['data']['igst'] == 0){
		
		$input_cgst = array(
			'voucher_date'   => $dt['data']['tr_dt'],
			 'sl_no'          => $v_srl,
			'voucher_id'     => $v_id,
			'unit_id'        => $dt['data']['unit_id'],
		    'unit_name'      => $dt['data']['unit_name'],
			'branch_id'      => $dt['data']['br_cd'],
			'trans_no'       => $dt['data']['bill_no'],
			'trans_dt'       => $dt['data']['tr_dt'],  
			'voucher_type'   => 'SL',
			'transfer_type'  => 'T',
			'voucher_mode'   => 'J',
			'voucher_through'=> 'A',
			'acc_code'       => 8245,            //   Change on 31/03/2023 will active from 01/04/2023
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
			'approved_by'    => 'SYSTEM',
			'approved_dt'    => $dt['data']['created_dt'],
			'fin_yr'         => $dt['data']['fin_yr']    
		);
        $this->db->insert('td_vouchers', $input_cgst);
		
		$input_sgst = array(
			'voucher_date'   => $dt['data']['tr_dt'],
			'sl_no'          => $v_srl,
			'voucher_id'     => $v_id,
			'unit_id'        => $dt['data']['unit_id'],
		    'unit_name'      => $dt['data']['unit_name'],
			'branch_id'      => $dt['data']['br_cd'],
			'trans_no'       => $dt['data']['bill_no'],
			'trans_dt'       => $dt['data']['tr_dt'],  
			'voucher_type'   => 'SL',
			'transfer_type'  => 'T',
			'voucher_mode'   => 'J',
			'voucher_through'=> 'A',
			'acc_code'       => 8246,        //   Change on 31/03/2023 will active from 01/04/2023
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
			'approved_by'    => 'SYSTEM',
			'approved_dt'    => $dt['data']['created_dt'],
			'fin_yr'         => $dt['data']['fin_yr']    
		);
		 $this->db->insert('td_vouchers', $input_sgst);
		
	}else{
		$input_igst = array(
			'voucher_date'   => $dt['data']['tr_dt'],
			'sl_no'          => $v_srl,
			'voucher_id'     => $v_id,
			'unit_id'        => $dt['data']['unit_id'],
		    'unit_name'      => $dt['data']['unit_name'],
			'branch_id'      => $dt['data']['br_cd'],
			'trans_no'       => $dt['data']['bill_no'],
			'trans_dt'       => $dt['data']['tr_dt'],  
			'voucher_type'   => 'SL',
			'transfer_type'  => 'T',
			'voucher_mode'   => 'J',
			'voucher_through'=> 'A',
			'acc_code'       => 8247,       
			'dr_cr_flag'     => 'CR',
			'amount'         => $dt['data']['igst'],
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
			'approved_by'    => 'SYSTEM',
			'approved_dt'    => $dt['data']['created_dt'],
			'fin_yr'         => $dt['data']['fin_yr']    
		);
		
		$this->db->insert('td_vouchers', $input_igst); 
	}
     
        $input_sale = array(
            'voucher_date'   => $dt['data']['tr_dt'],
            'sl_no'          =>  $v_srl,
            'voucher_id'     => $v_id,
			'unit_id'        => $dt['data']['unit_id'],
		    'unit_name'      => $dt['data']['unit_name'],
            'branch_id'      => $dt['data']['br_cd'],
            'trans_no'       => $dt['data']['bill_no'],
            'trans_dt'       => $dt['data']['tr_dt'],  
            'voucher_type'   => 'SL',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => $sale_cr,
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
            'approved_by'    => 'SYSTEM',
            'approved_dt'    => $dt['data']['created_dt'],
            'fin_yr'         => $dt['data']['fin_yr']    
        );
        if($tot_roundoff > 0){
	    $roundoff_data = array(
				'voucher_date'   => $dt['data']['tr_dt'],
				'sl_no'          => $v_srl,
				'voucher_id'     => $v_id,
			    'unit_id'        => $dt['data']['unit_id'],
		        'unit_name'      => $dt['data']['unit_name'],
				'branch_id'      => $dt['data']['br_cd'],
				'trans_no'       => $dt['data']['bill_no'],
				'trans_dt'       => $dt['data']['tr_dt'],  
				'voucher_type'   => 'SL',
				'transfer_type'  => 'T',
				'voucher_mode'   => 'J',
				'voucher_through'=> 'A',
				'acc_code'       => 2211,
				'dr_cr_flag'     => 'CR',
				'amount'         => abs($tot_roundoff),
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
				'approved_by'    => 'SYSTEM',
				'approved_dt'    => $dt['data']['created_dt'],
				'fin_yr'         => $dt['data']['fin_yr']    
			);
			$this->db->insert('td_vouchers', $roundoff_data); 
		 }elseif($tot_roundoff < 0){
		
		  $roundoff_data = array(
				'voucher_date'   => $dt['data']['tr_dt'],
				'sl_no'          => $v_srl,
				'voucher_id'     => $v_id,
			    'unit_id'        => $dt['data']['unit_id'],
		        'unit_name'      => $dt['data']['unit_name'],
				'branch_id'      => $dt['data']['br_cd'],
				'trans_no'       => $dt['data']['bill_no'],
				'trans_dt'       => $dt['data']['tr_dt'],  
				'voucher_type'   => 'SL',
				'transfer_type'  => 'T',
				'voucher_mode'   => 'J',
				'voucher_through'=> 'A',
				'acc_code'       => 2211,
				'dr_cr_flag'     => 'DR',
				'amount'         => abs($tot_roundoff),
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
				'approved_by'    => 'SYSTEM',
				'approved_dt'    => $dt['data']['created_dt'],
				'fin_yr'         => $dt['data']['fin_yr']    
			);
			$this->db->insert('td_vouchers', $roundoff_data);
		
		}	 
        if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_sale) ){
			
			$rdata =array('status'=>'Success');
		    echo json_encode($rdata);
		}else{
			$rdata =array('status'=>'Fail');
			echo json_encode($rdata);
		}  
                     
        }
		public function sale_voucher_return(){
             
        $input = file_get_contents("php://input");
        $dt = json_decode($input, true);
        $tot_roundoff = 0;
		$drsum        = 0;
        $fyrdtls= $this->Api_model->f_fin_yr_dtls_by_date($dt['data']['trans_dt']);
		$dt['data']['fin_fulyr'] = $fyrdtls->fin_yr;	
		$dt['data']['fin_yr'] = $fyrdtls->sl_no;
		$sl_no    = $this->Transaction_model->f_get_voucher_id($fyrdtls->sl_no);
        $v_srl = $sl_no->sl_no;
		$v_id = $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;	
        $drsum = $dt['data']['tot_amt'];
	    $dt['data']['bill_no'] = 	$dt['data']['bill_no'].'_RTN'.$dt['data']['return_id'];

	    if($dt['data']['igst'] == 0){
			$crsum = $dt['data']['cgst'] + $dt['data']['sgst']+$dt['data']['other_tax'] + $dt['data']['taxable_amt'];
		}else{
			$crsum = $dt['data']['igst'] + $dt['data']['other_tax'] + $dt['data']['taxable_amt'];
		}
		 $tot_roundoff =	$drsum - $crsum;
         $input_data = array(
        'voucher_date'   => $dt['data']['trans_dt'],
        'sl_no'          => $v_srl,
        'voucher_id'     => $v_id,
	    'unit_id'        => $dt['data']['unit_id'],
		'unit_name'      => $dt['data']['unit_name'],	
        'branch_id'      => $dt['data']['br_cd'],
        'trans_no'       => $dt['data']['bill_no'],
        'trans_dt'       => $dt['data']['trans_dt'],  
        'voucher_type'   => 'SLRTN',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => 1116,
        'dr_cr_flag'     => 'CR',
        'amount'         => $dt['data']['tot_amt'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'R',
        'user_flag'      =>'',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'created_ip'    => $dt['data']['created_ip'],
        'approved_by'    => 'SYSTEM',
        'approved_dt'    => $dt['data']['created_dt'],
        'fin_yr'         => $dt['data']['fin_yr']    
    );
	if($dt['data']['other_tax'] > 0){
		
		$input_othtax = array(
			'voucher_date'   => $dt['data']['trans_dt'],
			 'sl_no'          => $v_srl,
			'voucher_id'     => $v_id,
			'unit_id'        => $dt['data']['unit_id'],
		    'unit_name'      => $dt['data']['unit_name'],
			'branch_id'      => $dt['data']['br_cd'],
			'trans_no'       => $dt['data']['bill_no'],
			'trans_dt'       => $dt['data']['trans_dt'],  
			'voucher_type'   => 'SLRTN',
			'transfer_type'  => 'T',
			'voucher_mode'   => 'J',
			'voucher_through'=> 'A',
			'acc_code'       => 8248,            //   Change on 31/03/2023 will active from 01/04/2023
			'dr_cr_flag'     => 'DR',
			'amount'         => $dt['data']['other_tax'],
			'ins_no'         => '',
			'ins_dt'         => '',
			'bank_name'      => '',
			'remarks'        => $dt['data']['rem'],
			'approval_status'=> 'R',
			'user_flag'      => '',
			'created_dt'     => $dt['data']['created_dt'],
			'created_by'     => $dt['data']['created_by'],
			'created_ip'     => $dt['data']['created_ip'],
			'approved_by'    => 'SYSTEM',
			'approved_dt'    => $dt['data']['created_dt'],
			'fin_yr'         => $dt['data']['fin_yr']    
		);
        $this->db->insert('td_vouchers', $input_othtax);
	
	}		
    if($dt['data']['igst'] == 0){
		
		$input_cgst = array(
			'voucher_date'   => $dt['data']['trans_dt'],
			 'sl_no'          => $v_srl,
			'voucher_id'     => $v_id,
			'unit_id'        => $dt['data']['unit_id'],
		    'unit_name'      => $dt['data']['unit_name'],
			'branch_id'      => $dt['data']['br_cd'],
			'trans_no'       => $dt['data']['bill_no'],
			'trans_dt'       => $dt['data']['trans_dt'],  
			'voucher_type'   => 'SLRTN',
			'transfer_type'  => 'T',
			'voucher_mode'   => 'J',
			'voucher_through'=> 'A',
			'acc_code'       => 8245,            //   Change on 31/03/2023 will active from 01/04/2023
			'dr_cr_flag'     => 'DR',
			'amount'         => $dt['data']['cgst'],
			'ins_no'         => '',
			'ins_dt'         => '',
			'bank_name'      => '',
			'remarks'        => $dt['data']['rem'],
			'approval_status'=> 'R',
			'user_flag'      => '',
			'created_dt'     => $dt['data']['created_dt'],
			'created_by'     => $dt['data']['created_by'],
			'created_ip'    => $dt['data']['created_ip'],
			'approved_by'    => 'SYSTEM',
			'approved_dt'    => $dt['data']['created_dt'],
			'fin_yr'         => $dt['data']['fin_yr']    
		);
        $this->db->insert('td_vouchers', $input_cgst);
		
		$input_sgst = array(
			'voucher_date'   => $dt['data']['trans_dt'],
			'sl_no'          => $v_srl,
			'voucher_id'     => $v_id,
			'unit_id'        => $dt['data']['unit_id'],
		    'unit_name'      => $dt['data']['unit_name'],
			'branch_id'      => $dt['data']['br_cd'],
			'trans_no'       => $dt['data']['bill_no'],
			'trans_dt'       => $dt['data']['trans_dt'],  
			'voucher_type'   => 'SLRTN',
			'transfer_type'  => 'T',
			'voucher_mode'   => 'J',
			'voucher_through'=> 'A',
			'acc_code'       => 8246,        //   Change on 31/03/2023 will active from 01/04/2023
			'dr_cr_flag'     => 'DR',
			'amount'         => $dt['data']['sgst'],
			'ins_no'         => '',
			'ins_dt'         => '',
			'bank_name'      => '',
			'remarks'        => $dt['data']['rem'],
			'approval_status'=> 'R',
			'user_flag'      => '',
			'created_dt'     => $dt['data']['created_dt'],
			'created_by'     => $dt['data']['created_by'],
			'created_ip'    =>  $dt['data']['created_ip'],
			'approved_by'    => 'SYSTEM',
			'approved_dt'    => $dt['data']['created_dt'],
			'fin_yr'         => $dt['data']['fin_yr']    
		);
		 $this->db->insert('td_vouchers', $input_sgst);
		
	}else{
		$input_igst = array(
			'voucher_date'   => $dt['data']['trans_dt'],
			'sl_no'          => $v_srl,
			'voucher_id'     => $v_id,
			'unit_id'        => $dt['data']['unit_id'],
		    'unit_name'      => $dt['data']['unit_name'],
			'branch_id'      => $dt['data']['br_cd'],
			'trans_no'       => $dt['data']['bill_no'],
			'trans_dt'       => $dt['data']['trans_dt'],  
			'voucher_type'   => 'SLRTN',
			'transfer_type'  => 'T',
			'voucher_mode'   => 'J',
			'voucher_through'=> 'A',
			'acc_code'       => 8247,       
			'dr_cr_flag'     => 'DR',
			'amount'         => $dt['data']['igst'],
			'ins_no'         => '',
			'ins_dt'         => '',
			'bank_name'      => '',
			'remarks'        => $dt['data']['rem'],
			'approval_status'=> 'R',
			'user_flag'      => '',
			'created_dt'     => $dt['data']['created_dt'],
			'created_by'     => $dt['data']['created_by'],
			'created_ip'    => $dt['data']['created_ip'],
			'approved_by'    => 'SYSTEM',
			'approved_dt'    => $dt['data']['created_dt'],
			'fin_yr'         => $dt['data']['fin_yr']    
		);
		
		$this->db->insert('td_vouchers', $input_igst); 
	}
     
        $input_sale = array(
            'voucher_date'   => $dt['data']['trans_dt'],
            'sl_no'          =>  $v_srl,
            'voucher_id'     => $v_id,
			'unit_id'        => $dt['data']['unit_id'],
		    'unit_name'      => $dt['data']['unit_name'],
            'branch_id'      => $dt['data']['br_cd'],
            'trans_no'       => $dt['data']['bill_no'],
            'trans_dt'       => $dt['data']['trans_dt'],  
            'voucher_type'   => 'SLRTN',
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
            'approval_status'=> 'R',
            'user_flag'      => '',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
           'created_ip'    => $dt['data']['created_ip'],
            'approved_by'    => 'SYSTEM',
            'approved_dt'    => $dt['data']['created_dt'],
            'fin_yr'         => $dt['data']['fin_yr']    
        );
        if($tot_roundoff > 0){
	    $roundoff_data = array(
				'voucher_date'   => $dt['data']['trans_dt'],
				'sl_no'          => $v_srl,
				'voucher_id'     => $v_id,
			    'unit_id'        => $dt['data']['unit_id'],
		        'unit_name'      => $dt['data']['unit_name'],
				'branch_id'      => $dt['data']['br_cd'],
				'trans_no'       => $dt['data']['bill_no'],
				'trans_dt'       => $dt['data']['trans_dt'],  
				'voucher_type'   => 'SLRTN',
				'transfer_type'  => 'T',
				'voucher_mode'   => 'J',
				'voucher_through'=> 'A',
				'acc_code'       => 2211,
				'dr_cr_flag'     => 'DR',
				'amount'         => abs($tot_roundoff),
				'ins_no'         => '',
				'ins_dt'         => '',
				'bank_name'      => '',
				'remarks'        => $dt['data']['rem'],
				'approval_status'=> 'R',
				'user_flag'      =>'',
				'created_dt'     => $dt['data']['created_dt'],
				'created_by'     => $dt['data']['created_by'],
				'created_ip'    => $dt['data']['created_ip'],
				'approved_by'    => 'SYSTEM',
				'approved_dt'    => $dt['data']['created_dt'],
				'fin_yr'         => $dt['data']['fin_yr']    
			);
			$this->db->insert('td_vouchers', $roundoff_data); 
		 }elseif($tot_roundoff < 0){
		
		  $roundoff_data = array(
				'voucher_date'   => $dt['data']['trans_dt'],
				'sl_no'          => $v_srl,
				'voucher_id'     => $v_id,
			    'unit_id'        => $dt['data']['unit_id'],
		        'unit_name'      => $dt['data']['unit_name'],
				'branch_id'      => $dt['data']['br_cd'],
				'trans_no'       => $dt['data']['bill_no'],
				'trans_dt'       => $dt['data']['trans_dt'],  
				'voucher_type'   => 'SLRTN',
				'transfer_type'  => 'T',
				'voucher_mode'   => 'J',
				'voucher_through'=> 'A',
				'acc_code'       => 2211,
				'dr_cr_flag'     => 'CR',
				'amount'         => abs($tot_roundoff),
				'ins_no'         => '',
				'ins_dt'         => '',
				'bank_name'      => '',
				'remarks'        => $dt['data']['rem'],
				'approval_status'=> 'R',
				'user_flag'      =>'',
				'created_dt'     => $dt['data']['created_dt'],
				'created_by'     => $dt['data']['created_by'],
				'created_ip'    => $dt['data']['created_ip'],
				'approved_by'    => 'SYSTEM',
				'approved_dt'    => $dt['data']['created_dt'],
				'fin_yr'         => $dt['data']['fin_yr']    
			);
			$this->db->insert('td_vouchers', $roundoff_data);
		
		}	 
        if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_sale) ){
			
			$rdata =array('status'=>'Success');
		    echo json_encode($rdata);
		}else{
			$rdata =array('status'=>'Fail');
			echo json_encode($rdata);
		}  
                     
        }
		
	public function void_voucher(){
             
        $input = file_get_contents("php://input");
        $dt = json_decode($input, true);
      
		$where  = array('unit_id'=>$dt['data']['unit_id'],
						'trans_no' => $dt['data']['bill_no'],
						'approval_status'=> 'A');
			
		$this->db->where($where);
		$this->db->delete("td_vouchers");
		
        if($this->db->affected_rows() > 0){
			
			$rdata =array('status'=>'Success');
		    echo json_encode($rdata);
		}else{
			$rdata =array('status'=>'Fail');
			echo json_encode($rdata);
		}  
                     
     }

		/****************************************************** */

		 public function delete_voucher_dr(){
			$input = file_get_contents("php://input");
			$dt = json_decode($input, true);
			 $input_bank     = array(
				'voucher_id'     =>$dt['data']['paid_id'],
			);

			$data=$this->Transaction_model->f_select('td_vouchers',null,$input_bank,0);
			foreach ($data as $keydata) {
				$keydata->delete_by = $dt['data']['delete_by'];
				$keydata->delete_dt = date('Y-m-d H:m:s');
				// print_r($keydata);
				$this->db->insert('td_vouchers_delete', $keydata);

			}

			if($this->db->delete('td_vouchers', $input_bank) ){
				echo 1;
			}else{
				echo 0;
			}  
		 }


      // **********************************************   Samabyaka Purchase    *****//   
      public function purchase_voucher(){
        
        $cramt=0.0;
        $dramt=0.0;
        $rndoff = 0.0;
        $tot_roundoff = 0;
		$vendor_acccode = 0;
        $input = file_get_contents("php://input");
        $dt = json_decode($input, true);
		$fyrdtls= $this->Api_model->f_fin_yr_dtls_by_date($dt['data']['trans_dt']);
		$dt['data']['fin_fulyr'] = $fyrdtls->fin_yr;	
		$dt['data']['fin_yr'] = $fyrdtls->sl_no;
       
        $sl_no    = $this->Transaction_model->f_get_voucher_id($fyrdtls->sl_no);
        $v_srl=$sl_no->sl_no;
		$vendor_acccode =   $this->Transaction_model->f_get_vendor_acccode($dt['data']['vendor_id'],$dt['data']['vendor_name']);
        $v_id= $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;
      
		$cramt = $dt['data']['tot_amt'];
		if($dt['data']['igst'] == 0){
			$dramt = $dt['data']['cgst'] + $dt['data']['sgst']+$dt['data']['other_tax'] + $dt['data']['taxable_amt'];
		}else{
			$dramt = $dt['data']['igst'] + $dt['data']['other_tax'] + $dt['data']['taxable_amt'];
		}
		$tot_roundoff =	$dramt - $cramt;
        $dramt=round($cramt,2);
        $cramt= round($cramt,2);
		if($dt['data']['unit_id'] == 3){
			$dr_achead = 2208;
		}else{
			$dr_achead = 10080;
		}
		
        $dt['data']['br'] = $dt['data']['br_cd'];
        $dt['data']['rem'] = 'Purchase From '.$dt['data']['vendor_name'];
        if($cramt == $dramt){
                $input_data = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
                'voucher_id'     => $v_id,
				'unit_id'        => $dt['data']['unit_id'],
		        'unit_name'      => $dt['data']['unit_name'],
                'branch_id'      => $dt['data']['br'],
                'trans_no'       => $dt['data']['challan_no'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'PUR',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => $vendor_acccode,
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
                'created_ip'     => $dt['data']['created_ip'],
                'approved_by'    => 'SYSTEM',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );
			
		 if($dt['data']['other_tax'] > 0){
		 $input_othertax = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
                'voucher_id'     => $v_id,
			    'unit_id'        => $dt['data']['unit_id'],
		        'unit_name'      => $dt['data']['unit_name'],
                'branch_id'      => $dt['data']['br'],
                'trans_no'       => $dt['data']['challan_no'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'PUR',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => 8248,             // Change on 31/03/2023  will effect from 01/04/2023
                'dr_cr_flag'     => 'DR',
                'amount'         => $dt['data']['other_tax'],
                'ins_no'         => '',
                'ins_dt'         => '',
                'bank_name'      => '',
                'remarks'        => $dt['data']['rem'],
                'approval_status'=> 'A',
                'user_flag'      => '',
                'created_dt'     => $dt['data']['created_dt'],
                'created_by'     => $dt['data']['created_by'],
			    'created_ip'     => $dt['data']['created_ip'],
                'approved_by'    => 'SYSTEM',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );
            $this->db->insert('td_vouchers', $input_othertax); 
		 
		 }
          if($dt['data']['igst'] == 0){
            $input_cgst = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
                'voucher_id'     => $v_id,
				'unit_id'        => $dt['data']['unit_id'],
		        'unit_name'      => $dt['data']['unit_name'],
                'branch_id'      => $dt['data']['br'],
                'trans_no'       => $dt['data']['challan_no'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'PUR',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => 8197,             // Change on 31/03/2023  will effect from 01/04/2023
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
				'created_ip'     => $dt['data']['created_ip'],
                'approved_by'    => 'SYSTEM',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );
            $this->db->insert('td_vouchers', $input_cgst); 
            $input_sgst = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
                'voucher_id'     => $v_id,
				'unit_id'        => $dt['data']['unit_id'],
		        'unit_name'      => $dt['data']['unit_name'],
                'branch_id'      => $dt['data']['br'],
                'trans_no'       => $dt['data']['challan_no'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'PUR',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => 8198,      // Change on 31/03/2023  will effect from 01/04/2023
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
                'created_ip'     => $dt['data']['created_ip'],
                'approved_by'    => 'SYSTEM',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );
			  $this->db->insert('td_vouchers', $input_sgst); 
		  }else{
			  
			   $input_igst = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
                'voucher_id'     => $v_id,
				 'unit_id'        => $dt['data']['unit_id'],
		        'unit_name'      => $dt['data']['unit_name'],
                'branch_id'      => $dt['data']['br'],
                'trans_no'       => $dt['data']['challan_no'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'PUR',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => 8198,      // Change on 31/03/2023  will effect from 01/04/2023
                'dr_cr_flag'     => 'DR',
                'amount'         => $dt['data']['igst'],
                'ins_no'         => '',
                'ins_dt'         => '',
                'bank_name'      => '',
                'remarks'        => $dt['data']['rem'],
                'approval_status'=> 'A',
                'user_flag'      => '',
                'created_dt'     => $dt['data']['created_dt'],
                'created_by'     => $dt['data']['created_by'],
                'created_ip'     => $dt['data']['created_ip'],
                'approved_by'    => 'SYSTEM',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );
		  $this->db->insert('td_vouchers', $input_igst); 
		  }

                $input_pur= array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
					'unit_id'        => $dt['data']['unit_id'],
		            'unit_name'      => $dt['data']['unit_name'],
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => $dt['data']['challan_no'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'PUR',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => $dr_achead,
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
                    'created_ip'     => $dt['data']['created_ip'],
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );

		if($tot_roundoff > 0){
	    $roundoff_data = array(
				'voucher_date'   => $dt['data']['trans_dt'],
				'sl_no'          => $v_srl,
				'voucher_id'     => $v_id,
			    'unit_id'        => $dt['data']['unit_id'],
		        'unit_name'      => $dt['data']['unit_name'],
				'branch_id'      => $dt['data']['br_cd'],
				'trans_no'       => $dt['data']['challan_no'],
				'trans_dt'       => $dt['data']['trans_dt'],  
				'voucher_type'   => 'PUR',
				'transfer_type'  => 'T',
				'voucher_mode'   => 'J',
				'voucher_through'=> 'A',
				'acc_code'       => 2211,
				'dr_cr_flag'     => 'CR',
				'amount'         => abs($tot_roundoff),
				'ins_no'         => '',
				'ins_dt'         => '',
				'bank_name'      => '',
				'remarks'        => $dt['data']['rem'],
				'approval_status'=> 'A',
				'user_flag'      =>'',
				'created_dt'     => $dt['data']['created_dt'],
				'created_by'     => $dt['data']['created_by'],
				'created_ip'     => $dt['data']['created_ip'],
				'approved_by'    => 'SYSTEM',
				'approved_dt'    => $dt['data']['created_dt'],
				'fin_yr'         => $dt['data']['fin_yr']    
			);
			$this->db->insert('td_vouchers', $roundoff_data); 
		 }elseif($tot_roundoff < 0){
		
		  $roundoff_data = array(
				'voucher_date'   => $dt['data']['trans_dt'],
				'sl_no'          => $v_srl,
				'voucher_id'     => $v_id,
			    'unit_id'        => $dt['data']['unit_id'],
		        'unit_name'      => $dt['data']['unit_name'],
				'branch_id'      => $dt['data']['br_cd'],
				'trans_no'       => $dt['data']['challan_no'],
				'trans_dt'       => $dt['data']['trans_dt'],  
				'voucher_type'   => 'PUR',
				'transfer_type'  => 'T',
				'voucher_mode'   => 'J',
				'voucher_through'=> 'A',
				'acc_code'       => 2211,
				'dr_cr_flag'     => 'DR',
				'amount'         => abs($tot_roundoff),
				'ins_no'         => '',
				'ins_dt'         => '',
				'bank_name'      => '',
				'remarks'        => $dt['data']['rem'],
				'approval_status'=> 'A',
				'user_flag'      =>'',
				'created_dt'     => $dt['data']['created_dt'],
				'created_by'     => $dt['data']['created_by'],
				'created_ip'     => $dt['data']['created_ip'],
				'approved_by'    => 'SYSTEM',
				'approved_dt'    => $dt['data']['created_dt'],
				'fin_yr'         => $dt['data']['fin_yr']    
			);
			$this->db->insert('td_vouchers', $roundoff_data);
		
		}
        
        if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_pur) ){
            echo json_encode(1);
        }
        else{
            echo json_encode(0);
        }  

    }else{
        
        echo json_encode(0);
    }
      
    
    }
    public function purchase_return_voucher(){
        
            $cramt=0.0;
            $dramt=0.0;
            $rndoff = 0.0;
            $tot_roundoff = 0;
            $vendor_acccode = 0;
            $input = file_get_contents("php://input");
            $dt = json_decode($input, true);
            $fyrdtls= $this->Api_model->f_fin_yr_dtls_by_date($dt['data']['trans_dt']);
            $dt['data']['fin_fulyr'] = $fyrdtls->fin_yr;	
            $dt['data']['fin_yr'] = $fyrdtls->sl_no;
           
            $sl_no    = $this->Transaction_model->f_get_voucher_id($fyrdtls->sl_no);
            $v_srl=$sl_no->sl_no;
            $vendor_acccode =   $this->Transaction_model->f_get_vendor_acccode($dt['data']['vendor_id'],$dt['data']['vendor_name']);
            $v_id= $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;
          
            $cramt = $dt['data']['tot_amt'];
            if($dt['data']['igst'] == 0){
                $dramt = $dt['data']['cgst'] + $dt['data']['sgst']+$dt['data']['other_tax'] + $dt['data']['taxable_amt'];
            }else{
                $dramt = $dt['data']['igst'] + $dt['data']['other_tax'] + $dt['data']['taxable_amt'];
            }
            $tot_roundoff =	$dramt - $cramt;
            $dramt=round($cramt,2);
            $cramt= round($cramt,2);
            $dt['data']['br'] = $dt['data']['br_cd'];
            $dt['data']['rem'] = 'Purchase From '.$dt['data']['vendor_name'];
            if($cramt == $dramt){
                    $input_data = array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'unit_id'        => $dt['data']['unit_id'],
                    'unit_name'      => $dt['data']['unit_name'],
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => $dt['data']['challan_no'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'PURRTN',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => $vendor_acccode,
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
                    'created_ip'     => $dt['data']['created_ip'],
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
                
             if($dt['data']['other_tax'] > 0){
             $input_othertax = array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'unit_id'        => $dt['data']['unit_id'],
                    'unit_name'      => $dt['data']['unit_name'],
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => $dt['data']['challan_no'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'PURRTN',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 8248,             // Change on 31/03/2023  will effect from 01/04/2023
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $dt['data']['other_tax'],
                    'ins_no'         => '',
                    'ins_dt'         => '',
                    'bank_name'      => '',
                    'remarks'        => $dt['data']['rem'],
                    'approval_status'=> 'A',
                    'user_flag'      => '',
                    'created_dt'     => $dt['data']['created_dt'],
                    'created_by'     => $dt['data']['created_by'],
                    'created_ip'     => $dt['data']['created_ip'],
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
                $this->db->insert('td_vouchers', $input_othertax); 
             
             }
              if($dt['data']['igst'] == 0){
                $input_cgst = array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'unit_id'        => $dt['data']['unit_id'],
                    'unit_name'      => $dt['data']['unit_name'],
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => $dt['data']['challan_no'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'PURRTN',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 8197,             // Change on 31/03/2023  will effect from 01/04/2023
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
                    'created_ip'     => $dt['data']['created_ip'],
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
                $this->db->insert('td_vouchers', $input_cgst); 
                $input_sgst = array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'unit_id'        => $dt['data']['unit_id'],
                    'unit_name'      => $dt['data']['unit_name'],
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => $dt['data']['challan_no'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'PURRTN',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 8198,      // Change on 31/03/2023  will effect from 01/04/2023
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
                    'created_ip'     => $dt['data']['created_ip'],
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
                  $this->db->insert('td_vouchers', $input_sgst); 
              }else{
                  
                   $input_igst = array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                     'unit_id'        => $dt['data']['unit_id'],
                    'unit_name'      => $dt['data']['unit_name'],
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => $dt['data']['challan_no'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'PURRTN',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 8198,      // Change on 31/03/2023  will effect from 01/04/2023
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $dt['data']['igst'],
                    'ins_no'         => '',
                    'ins_dt'         => '',
                    'bank_name'      => '',
                    'remarks'        => $dt['data']['rem'],
                    'approval_status'=> 'A',
                    'user_flag'      => '',
                    'created_dt'     => $dt['data']['created_dt'],
                    'created_by'     => $dt['data']['created_by'],
                    'created_ip'     => $dt['data']['created_ip'],
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
              $this->db->insert('td_vouchers', $input_igst); 
              }
    
                    $input_pur= array(
                        'voucher_date'   => $dt['data']['trans_dt'],
                        'sl_no'          => $v_srl,
                        'voucher_id'     => $v_id,
                        'unit_id'        => $dt['data']['unit_id'],
                        'unit_name'      => $dt['data']['unit_name'],
                        'branch_id'      => $dt['data']['br'],
                        'trans_no'       => $dt['data']['challan_no'],
                        'trans_dt'       => $dt['data']['trans_dt'],  
                        'voucher_type'   => 'PURRTN',
                        'transfer_type'  => 'T',
                        'voucher_mode'   => 'J',
                        'voucher_through'=> 'A',
                        'acc_code'       => 2208,
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
                        'created_ip'     => $dt['data']['created_ip'],
                        'approved_by'    => 'SYSTEM',
                        'approved_dt'    => $dt['data']['created_dt'],
                        'fin_yr'         => $dt['data']['fin_yr']    
                    );
    
            if($tot_roundoff > 0){
            $roundoff_data = array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'unit_id'        => $dt['data']['unit_id'],
                    'unit_name'      => $dt['data']['unit_name'],
                    'branch_id'      => $dt['data']['br_cd'],
                    'trans_no'       => $dt['data']['challan_no'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'PURRTN',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 2211,
                    'dr_cr_flag'     => 'DR',
                    'amount'         => abs($tot_roundoff),
                    'ins_no'         => '',
                    'ins_dt'         => '',
                    'bank_name'      => '',
                    'remarks'        => $dt['data']['rem'],
                    'approval_status'=> 'A',
                    'user_flag'      =>'',
                    'created_dt'     => $dt['data']['created_dt'],
                    'created_by'     => $dt['data']['created_by'],
                    'created_ip'     => $dt['data']['created_ip'],
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
                $this->db->insert('td_vouchers', $roundoff_data); 
             }elseif($tot_roundoff < 0){
            
              $roundoff_data = array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'unit_id'        => $dt['data']['unit_id'],
                    'unit_name'      => $dt['data']['unit_name'],
                    'branch_id'      => $dt['data']['br_cd'],
                    'trans_no'       => $dt['data']['challan_no'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'PURRTN',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 2211,
                    'dr_cr_flag'     => 'CR',
                    'amount'         => abs($tot_roundoff),
                    'ins_no'         => '',
                    'ins_dt'         => '',
                    'bank_name'      => '',
                    'remarks'        => $dt['data']['rem'],
                    'approval_status'=> 'A',
                    'user_flag'      =>'',
                    'created_dt'     => $dt['data']['created_dt'],
                    'created_by'     => $dt['data']['created_by'],
                    'created_ip'     => $dt['data']['created_ip'],
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
                $this->db->insert('td_vouchers', $roundoff_data);
            
            }
            
            if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_pur) ){
                echo json_encode(1);
            }
            else{
                echo json_encode(0);
            }  
    
        }else{
            
            echo json_encode(0);
        }  
        
    }
   
      /******************************************** */
		
		public function salary_voucher(){
        
        $cramt=0.0;
        $dramt=0.0;
        $rndoff = 0.0;
        $input = file_get_contents("php://input");
        $dt = json_decode($input, true);
			
		$fyrdtls= $this->Api_model->f_fin_yr_dtls_by_date($dt['data']['trans_dt']);
		$dt['data']['fin_fulyr'] = $fyrdtls->fin_yr;	
		$dt['data']['fin_yr'] = $fyrdtls->sl_no;
       
        $sl_no    = $this->Transaction_model->f_get_voucher_id($fyrdtls->sl_no);
        $v_srl=$sl_no->sl_no;
        $v_id= 'SLRY/'.$dt['data']['fin_fulyr'].'/'.$v_srl;
		$cramt = $dt['data']['net_amt'];

		$dramt = $dt['data']['net_amt'] ;
        $dramt=round($cramt,2);
        $cramt= round($cramt,2);
        $dt['data']['br'] = $dt['data']['br_cd'];
        if($cramt == $dramt){
               
            $input_salarydr = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
                'voucher_id'     => $v_id,
                'branch_id'      => $dt['data']['br'],
                'trans_no'       => '',
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'SLRY',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => 8107,
                'dr_cr_flag'     => 'DR',
                'amount'         => $dt['data']['net_amt'],
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
                'approved_by'    => 'SYSTEM',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );

                $input_salarycr= array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => '',
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'SLRY',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => $dt['data']['acc_cr_code'],
                    'dr_cr_flag'     => 'CR',
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
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
        
				if($this->db->insert('td_vouchers', $input_salarydr) && $this->db->insert('td_vouchers', $input_salarycr) ){
					echo json_encode(1);
				}
				else{
					echo json_encode(0);
				}  

			}else{

				echo json_encode(0);
			}
    
         }
		
		public function sal_dedct_voucher(){
        
        $cramt=0.0;
        $dramt=0.0;
        $rndoff = 0.0;
        $input = file_get_contents("php://input");
        $dt = json_decode($input, true);
			
		$fyrdtls= $this->Api_model->f_fin_yr_dtls_by_date($dt['data']['trans_dt']);
		$dt['data']['fin_fulyr'] = $fyrdtls->fin_yr;	
		$dt['data']['fin_yr'] = $fyrdtls->sl_no;
       
        $sl_no    = $this->Transaction_model->f_get_voucher_id($fyrdtls->sl_no);
        $v_srl=$sl_no->sl_no;
        $v_id= 'SLRY/'.$dt['data']['fin_fulyr'].'/'.$v_srl;
		//$cramt = $dt['data']['net_amt'];

		$dramt = $dt['data']['tot_deduction'] ;
        //$dramt=round($cramt,2);
        //$cramt= round($cramt,2);
        $dt['data']['br'] = $dt['data']['br_cd'];
               
            $input_salarydr = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
                'voucher_id'     => $v_id,
                'branch_id'      => $dt['data']['br'],
                'trans_no'       => '',
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'SLRY',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => 8107,
                'dr_cr_flag'     => 'DR',
                'amount'         => $dt['data']['tot_deduction'],
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
                'approved_by'    => 'SYSTEM',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
                );
             if($dt['data']['insuarance'] > 0){
                $input_sal_insu_cr= array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => '',
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'SLRY',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 7283,
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $dt['data']['insuarance'],
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
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
				$this->db->insert('td_vouchers', $input_sal_insu_cr); 
			 }
			 if($dt['data']['ccs']+$dt['data']['tf'] > 0){
			 $input_sal_ccs_cr= array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => '',
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'SLRY',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 5764,
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $dt['data']['ccs']+$dt['data']['tf'],
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
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
			$this->db->insert('td_vouchers', $input_sal_ccs_cr);
			 }
			if($dt['data']['hbl']+$dt['data']['comp_loan'] > 0){
			$input_sal_hbl_cr= array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => '',
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'SLRY',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 7383,
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $dt['data']['hbl']+$dt['data']['comp_loan'],
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
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
			   $this->db->insert('td_vouchers', $input_sal_hbl_cr);
			}
			if($dt['data']['telephone'] > 0){
			$input_sal_telephone_cr= array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => '',
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'SLRY',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 8136,
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $dt['data']['telephone'],
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
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
			   $this->db->insert('td_vouchers', $input_sal_telephone_cr);
			}
			if($dt['data']['festival_adv']+$dt['data']['med_adv'] > 0){
			$input_sal_festival_adv_cr= array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => '',
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'SLRY',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 9150,
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $dt['data']['festival_adv']+$dt['data']['med_adv'],
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
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
			   $this->db->insert('td_vouchers', $input_sal_festival_adv_cr);
			}
			if($dt['data']['med_ins'] > 0){
			$input_sal_med_ins_cr= array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => '',
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'SLRY',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 8103,
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $dt['data']['med_ins'],
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
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
			 $this->db->insert('td_vouchers', $input_sal_med_ins_cr);
			}
			if($dt['data']['itax'] > 0){
			$input_sal_itax_cr= array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => '',
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'SLRY',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 5880,
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $dt['data']['itax'],
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
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
			   $this->db->insert('td_vouchers', $input_sal_itax_cr);
			}
			if($dt['data']['gpf'] > 0){
			$input_sal_gpf_cr= array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => '',
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'SLRY',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 8106,
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $dt['data']['gpf'],
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
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
			   $this->db->insert('td_vouchers', $input_sal_gpf_cr);
			}
			if($dt['data']['epf'] > 0 ){
			$input_sal_epf_cr= array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => '',
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'SLRY',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 5765,
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $dt['data']['epf'],
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
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
			   $this->db->insert('td_vouchers', $input_sal_epf_cr);
			}
			if($dt['data']['ptax'] > 0){
			$input_sal_ptax_cr= array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => '',
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'SLRY',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 5884,
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $dt['data']['ptax'],
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
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
			   $this->db->insert('td_vouchers', $input_sal_ptax_cr);
			}
			if($dt['data']['other_deduction'] > 0){
			$input_sal_other_deduction_cr= array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => '',
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'SLRY',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 8119,
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $dt['data']['other_deduction'],
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
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
			   $this->db->insert('td_vouchers', $input_sal_other_deduction_cr);
		       }
				if($this->db->insert('td_vouchers', $input_salarydr) ){
					echo json_encode(1);
				}
				else{
					echo json_encode(0);
				}  
    
         }
		
		public function gov_pur_voucher(){
        
        $cramt=0.0;
        $dramt=0.0;
        $rndoff = 0.0;
        $input = file_get_contents("php://input");
        $dt = json_decode($input, true);
		$fyrdtls= $this->Api_model->f_fin_yr_dtls_by_date($dt['data']['trans_dt']);
		$dt['data']['fin_fulyr'] = $fyrdtls->fin_yr;	
		$dt['data']['fin_yr'] = $fyrdtls->sl_no;
       
        $sl_no    = $this->Transaction_model->f_get_voucher_id($fyrdtls->sl_no);
        $v_srl=$sl_no->sl_no;
        $v_id= $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;
      
		$cramt = $dt['data']['tot_amt'];
		$dramt = $dt['data']['cgst'] + $dt['data']['sgst'] + $dt['data']['taxable_amt'];
        $dramt=round($cramt,2);
        $cramt= round($cramt,2);
       $dt['data']['br'] = $dt['data']['br_cd'];
      
        if($cramt == $dramt){
                $input_data = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
                'voucher_id'     => $v_id,
                'branch_id'      => $dt['data']['br'],
                'trans_no'       => $dt['data']['trans_do'],
				'unit_id'       => $dt['data']['unit_id'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'GOVPUR',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => $dt['data']['cr_acc_code'],
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
                'approved_by'    => 'SYSTEM',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );

            $input_cgst = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
                'voucher_id'     => $v_id,
                'branch_id'      => $dt['data']['br'],
                'trans_no'       => $dt['data']['trans_do'],
				'unit_id'       => $dt['data']['unit_id'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'GOVPUR',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => 8197,             // Change on 31/03/2023  will effect from 01/04/2023
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
                'approved_by'    => 'SYSTEM',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );
    
            $input_sgst = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
                'voucher_id'     => $v_id,
                'branch_id'      => $dt['data']['br'],
                'trans_no'       => $dt['data']['trans_do'],
				'unit_id'       => $dt['data']['unit_id'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'GOVPUR',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => 8198,      // Change on 31/03/2023  will effect from 01/04/2023
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
                'approved_by'    => 'SYSTEM',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );

                $input_pur= array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => $dt['data']['trans_do'],
					'unit_id'       => $dt['data']['unit_id'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'GOVPUR',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 10267,
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
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );

        
        if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_cgst) && $this->db->insert('td_vouchers', $input_sgst) && $this->db->insert('td_vouchers', $input_pur) ){
            echo json_encode(1);
        }
        else{
            echo json_encode(0);
        }  

			}else{

				echo json_encode(0);
			}
      
        }
		  
		public function gov_sale_voucher(){
             
        $input = file_get_contents("php://input");
        $dt = json_decode($input, true);
        
        $fyrdtls= $this->Api_model->f_fin_yr_dtls_by_date($dt['data']['trans_dt']);
		$dt['data']['fin_fulyr'] = $fyrdtls->fin_yr;	
		$dt['data']['fin_yr'] = $fyrdtls->sl_no;
		$sl_no    = $this->Transaction_model->f_get_voucher_id($fyrdtls->sl_no);
        $v_srl = $sl_no->sl_no;
		$v_id = $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;	
      
         $input_data = array(
        'voucher_date'   => $dt['data']['trans_dt'],
        'sl_no'          => $v_srl,
        'voucher_id'     => $v_id,
        'branch_id'      => $dt['data']['br_cd'],
        'trans_no'       => $dt['data']['trans_do'],
			 'unit_id'       => $dt['data']['unit_id'],
        'trans_dt'       => $dt['data']['trans_dt'],  
        'voucher_type'   => 'GOVSL',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => $dt['data']['dr_acc_code'],
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
        'approved_by'    => 'SYSTEM',
        'approved_dt'    => $dt['data']['created_dt'],
        'fin_yr'         => $dt['data']['fin_yr']    
    );
    $input_cgst = array(
        'voucher_date'   => $dt['data']['trans_dt'],
         'sl_no'          => $v_srl,
        'voucher_id'     => $v_id,
        'branch_id'      => $dt['data']['br_cd'],
        'trans_no'       => $dt['data']['trans_do'],
		'unit_id'       => $dt['data']['unit_id'],
        'trans_dt'       => $dt['data']['trans_dt'],  
        'voucher_type'   => 'GOVSL',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => 8245,            //   Change on 31/03/2023 will active from 01/04/2023
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
        'approved_by'    => 'SYSTEM',
        'approved_dt'    => $dt['data']['created_dt'],
        'fin_yr'         => $dt['data']['fin_yr']    
    );
    
    $input_sgst = array(
        'voucher_date'   => $dt['data']['trans_dt'],
        'sl_no'          => $v_srl,
        'voucher_id'     => $v_id,
        'branch_id'      => $dt['data']['br_cd'],
        'trans_no'       => $dt['data']['trans_do'],
		'unit_id'       => $dt['data']['unit_id'],
        'trans_dt'       => $dt['data']['trans_dt'],  
        'voucher_type'   => 'GOVSL',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => 8246,        //   Change on 31/03/2023 will active from 01/04/2023
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
        'approved_by'    => 'SYSTEM',
        'approved_dt'    => $dt['data']['created_dt'],
        'fin_yr'         => $dt['data']['fin_yr']    
    );
     
        $input_sale = array(
            'voucher_date'   => $dt['data']['trans_dt'],
            'sl_no'          =>  $v_srl,
            'voucher_id'     => $v_id,
            'branch_id'      => $dt['data']['br_cd'],
            'trans_no'       => $dt['data']['trans_do'],
			'unit_id'       => $dt['data']['unit_id'],
            'trans_dt'       => $dt['data']['trans_dt'],  
            'voucher_type'   => 'GOVSL',
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
            'approved_by'    => 'SYSTEM',
            'approved_dt'    => $dt['data']['created_dt'],
            'fin_yr'         => $dt['data']['fin_yr']    
        );

     

        if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_cgst) && $this->db->insert('td_vouchers', $input_sgst) && $this->db->insert('td_vouchers', $input_sale) ){
			//echo $this->db->last_query();
			//exit;
			$rdata =array('status'=>'Success');
		   echo json_encode($rdata);
           //return json_encode($rdata);
    }else{
			$rdata =array('status'=>'Fail');
		   echo json_encode($rdata);
       // return 0;
    }  
                     
        }
		public function vendorpayment_jouranl(){
        
        $cramt=0.0;
        $dramt=0.0;
        $rndoff = 0.0;
        $input = file_get_contents("php://input");
        $dt = json_decode($input, true);
		$fyrdtls= $this->Api_model->f_fin_yr_dtls_by_date($dt['data']['trans_dt']);
		$dt['data']['fin_fulyr'] = $fyrdtls->fin_yr;	
		$dt['data']['fin_yr'] = $fyrdtls->sl_no;
       
        $sl_no    = $this->Transaction_model->f_get_voucher_id($fyrdtls->sl_no);
        $v_srl=$sl_no->sl_no;
        $v_id= $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;
      
		$cramt = $dt['data']['tot_amt'];
		$dramt = $dt['data']['tot_amt'];
        $dramt=round($cramt,2);
        $cramt= round($cramt,2);
       $dt['data']['br'] = $dt['data']['br_cd'];
      
        if($cramt == $dramt){
                $input_data = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
                'voucher_id'     => $v_id,
				'unit_id'        => $dt['data']['unit_id'],
                'branch_id'      => $dt['data']['br'],
                'trans_no'       => $dt['data']['trans_do'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'SUPPAY',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => $dt['data']['cr_acc_code'],
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
                'approved_by'    => 'SYSTEM',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );
                $input_pur= array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
					'unit_id'        => $dt['data']['unit_id'],
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => $dt['data']['trans_do'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'SUPPAY',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => $dt['data']['dr_cc_code'],
                    'dr_cr_flag'     => 'DR',
                    'amount'         => $dt['data']['tot_amt'],
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
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );

        
        if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_pur) ){
            echo json_encode(1);
        }
        else{
            echo json_encode(0);
        }  

			}else{

				echo json_encode(0);
			}
      
        }
		//   Api voucher for govt sale     ****    ///
		public function customerpayment_jouranl(){
        
        $cramt=0.0;
        $dramt=0.0;
        $rndoff = 0.0;
        $input = file_get_contents("php://input");
        $dt = json_decode($input, true);
		$fyrdtls= $this->Api_model->f_fin_yr_dtls_by_date($dt['data']['trans_dt']);
		$dt['data']['fin_fulyr'] = $fyrdtls->fin_yr;	
		$dt['data']['fin_yr'] = $fyrdtls->sl_no;
       
        $sl_no    = $this->Transaction_model->f_get_voucher_id($fyrdtls->sl_no);
        $v_srl=$sl_no->sl_no;
        $v_id= $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;
      
		$cramt = $dt['data']['tot_amt'];
		$dramt = $dt['data']['tot_amt'];
        $dramt=round($cramt,2);
        $cramt= round($cramt,2);
       $dt['data']['br'] = $dt['data']['br_cd'];
      
        if($cramt == $dramt){
                $input_data = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
                'voucher_id'     => $v_id,
				'unit_id'        => $dt['data']['unit_id'],
                'branch_id'      => $dt['data']['br'],
                'trans_no'       => $dt['data']['trans_do'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'GOVTPAY',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => $dt['data']['cr_acc_code'],
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
                'approved_by'    => 'SYSTEM',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );
                $input_pur= array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
					'unit_id'        => $dt['data']['unit_id'],
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => $dt['data']['trans_do'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'SUPPAY',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => $dt['data']['dr_cc_code'],
                    'dr_cr_flag'     => 'DR',
                    'amount'         => $dt['data']['tot_amt'],
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
                    'approved_by'    => 'SYSTEM',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );

        
        if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_pur) ){
            echo json_encode(1);
        }
        else{
            echo json_encode(0);
        }  

			}else{

				echo json_encode(0);
			}
      
        }
		
		public function delete_gov_transaction_jouranl(){
        
        $cramt=0.0;
        $dramt=0.0;
        $rndoff = 0.0;
        $input = file_get_contents("php://input");
        $dt = json_decode($input, true);
        $trans_no = $dt['data']['trans_do'];
		$remarks= $dt['data']['rem'];
		
		$del1 = $this->db->delete('td_vouchers', array('remarks'=>$remarks,'voucher_type'=>'GOVPUR','trans_no'=>$trans_no));
		$del2 = $this->db->delete('td_vouchers', array('remarks'=>$remarks,'voucher_type'=>'GOVSL','trans_no'=>$trans_no));
		
        
        if($del1 && $del2){
           echo json_encode(1);
        }
        else{
            echo json_encode(0);
        }  
      
        }
                
    }
?>
