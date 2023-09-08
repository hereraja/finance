<?php 
class Rent_calculation extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Rent_calculation_model");
        $this->load->model('Transaction_model');
         $this->load->helper('currecyword_helper');

        // $this->load->model('SaleModel');
        if(!isset($this->session->userdata['loggedin']['user_id'])){
            redirect('login');
        }
    }


    public function rentb2c_rep()
		{
			$trans_do = $this->input->get('invoice_no');
			$sale_rep['data'] = $this->Rent_calculation_model->f_get_receiptReport_dtls($trans_do);

			 $sale_rep['sum_data'] = $this->Rent_calculation_model->f_get_rentinv_tot($trans_do);
			// echo $this->db->last_query();
			// die();
			$sale_rep['trans_do'] = $trans_do;
		 
			 $this->load->view("post_login/finance_main");
		
			$this->load->view('report/rentb2c_invoice.php',$sale_rep);
		
			$this->load->view('post_login/footer');
			
		}
    public function godown_list(){
        $data["godownData"]=$this->Rent_calculation_model->godownData();
         $this->load->view("post_login/finance_main");
    $this->load->view("rent_calculation/godown/godown_list",$data);
       $this->load->view("post_login/footer");
    }

    public function godown_add() {
        if($_SERVER["REQUEST_METHOD"] == "POST") {

            $data=array(
                "gdn_name"=>$this->input->post("godown_Name"),
                "gdn_addr"=>$this->input->post("godown_Address"),
                "gdn_dist"=>$this->input->post("district"),
                "sac_code"=>$this->input->post("sac_Code"),
                "cnct_person"=>$this->input->post("contactPerson"),
                "cnct_no"=>$this->input->post("contactNumber"),
                "created_by"=>$this->session->userdata("loggedin")["user_id"],
                "created_dt"=>date("Y-m-d H:i:s")
            );
        //    $godown_Name = $this->input->post("godown_Name");
        //    $godown_Address = $this->input->post("godown_Address");
        //    $district = $this->input->post("district");
        //    $sac_Codes = $this->input->post("sac_Code");
        //    $contactPerson = $this->input->post("contactPerson");
        //    $contactNumber = $this->input->post("contactNumber");
        $this->Rent_calculation_model->addGodown($data);

        redirect("godown");
        }else{
       $data["district"]=$this->Rent_calculation_model->fetch_district();

        $this->load->view("post_login/finance_main");
        $this->load->view("rent_calculation/godown/godown_add", $data);
        $this->load->view("post_login/footer");
        }
    }




    public function godown_edit($id=null) {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $dataupdate=array(
                "gdn_name"=>$this->input->post("godown_Name"),
                "gdn_addr"=>$this->input->post("godown_Address"),
                "gdn_dist"=>$this->input->post("district"),
                "sac_code"=>$this->input->post("sac_Code"),
                "cnct_person"=>$this->input->post("contactPerson"),
                "cnct_no"=>$this->input->post("contactNumber"),
                "modified_by"=>$this->session->userdata("loggedin")["user_id"],
                "modified_dt"=>date("Y-m-d H:i:s")
            );
            $this->Rent_calculation_model->updateGodown($id,$dataupdate);
            redirect("godown");
            
        }else{
            $data["editData"]=$this->Rent_calculation_model->editgodownData($id);
       $data["district"]=$this->Rent_calculation_model->fetch_district();

        $this->load->view("post_login/finance_main");
        $this->load->view("rent_calculation/godown/godown_edit", $data);
        $this->load->view("post_login/footer");
        }
    
    }

    
    
    public function customer_list(){
        $data["customerData"]=$this->Rent_calculation_model->customerData();
        $this->load->view("post_login/finance_main");
     $this->load->view("rent_calculation/customer/customer_list", $data);
        $this->load->view("post_login/footer");
     }
 
     public function customer_add() {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $postData=array(
                "cust_name"=>$this->input->post("customerName"),
                "cust_dist"=>$this->input->post("district"),
                "cust_addr"=>$this->input->post("customerAddress"),
                "cnct_no"=>$this->input->post("contactNumber"),
                "cnct_person"=>$this->input->post("contactPerson"),
                "email_id"=>$this->input->post("email"),
                "gst_no"=>$this->input->post("gstNumber"),
                "pan_no"=>$this->input->post("panNo"),
                "fms_id"=>$this->input->post("fmsid"),
                "acchead"=>$this->input->post("acchead"),
                "gst_rt"=>$this->input->post("gst_rt"),
                "pin_code"=>$this->input->post("pincode"),
                "created_by"=>$this->session->userdata("loggedin")["user_id"],
                "created_dt"=>date("Y-m-d H:i:s"),
                "acchead"=>$this->input->post("acchead")
            );
            $this->Rent_calculation_model->insert_rent_customer($postData);
            redirect("customer");
        }else{
            $where=array(
                // 'BNK_flag' => 'B',
                'br_id' => $this->session->userdata("loggedin")["branch_id"],
            );
        $data["district"]=$this->Rent_calculation_model->fetch_district();
        $data["bank"]=$this->Rent_calculation_model->f_select('md_achead', $select=null, $where,0);
       
         $this->load->view("post_login/finance_main");
         $this->load->view("rent_calculation/customer/customer_add", $data);
         $this->load->view("post_login/footer");
        }
     }

     public function customer_edit($id=null) {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $dataupdate=array(
                "cust_name"=>$this->input->post("customerName"),
                "cust_dist"=>$this->input->post("district"),
                "cust_addr"=>$this->input->post("customerAddress"),
                "cnct_no"=>$this->input->post("contactNumber"),
                "cnct_person"=>$this->input->post("contactPerson"),
                "email_id"=>$this->input->post("email"),
                "gst_no"=>$this->input->post("gstNumber"),
                "acchead"=>$this->input->post("acchead"),
                "gst_rt"=>$this->input->post("gst_rt"),
                "pan_no"=>$this->input->post("panNo"),
                "fms_id"=>$this->input->post("fmsid"),
                "pin_code"=>$this->input->post("pincode"),
                "modified_by"=>$this->session->userdata("loggedin")["user_id"],
                "modified_dt"=>date("Y-m-d H:i:s"),
            );
            $this->Rent_calculation_model->updatecustomer($id,$dataupdate);
            redirect("customer");
            
        }else{
            $where=array(
                // 'BNK_flag' => 'B',
                'br_id' => $this->session->userdata("loggedin")["branch_id"],
            );
            $data["editData"]=$this->Rent_calculation_model->editcustomerData($id);
       $data["district"]=$this->Rent_calculation_model->fetch_district();
       $data["bank"]=$this->Rent_calculation_model->f_select('md_achead', $select=null, $where,0);
        $this->load->view("post_login/finance_main");
        $this->load->view("rent_calculation/customer/customer_edit", $data);
        $this->load->view("post_login/footer");
        }
    
    }


    public function godown_rent_add(){
        if($_SERVER["REQUEST_METHOD"] == "POST") {

            // print_r($this->input->post());
            // exit();
            $postData=array(
                "effective_date"=>$this->input->post('effectiveDate'),
                "godown_id"=>$this->input->post('godown'),
                "customer_id"=>$this->input->post('customer'),
                "rent_start_date"=>$this->input->post('startDate'),
                "rent_end_date"=>$this->input->post('endDate'),
                // "cgst_rate"=>$this->input->post('cgst'),
                // "sgst_rate"=>$this->input->post('sgst'),
                "rent_amt"=>$this->input->post('amount'),
                "created_by"=>$this->session->userdata("loggedin")["user_id"],
                "created_dt"=>date("Y-m-d H:i:s")
            );
            $this->Rent_calculation_model->insert_godown_rent_add($postData);
            redirect("godownrent");
        }else{
 
        $data["godown"]=$this->Rent_calculation_model->fetch_godown();
        $data["customer"]=$this->Rent_calculation_model->fetch_customer();
        
            
         $this->load->view("post_login/finance_main");
         $this->load->view("rent_calculation/godown_rent/godown_rent_add", $data);
         $this->load->view("post_login/footer");
        }
    }


    public function godown_rent_edit($id){
        if($_SERVER["REQUEST_METHOD"] == "POST") {

            // print_r($this->input->post());
            // exit();
            $postData=array(
                "godown_id"=>$this->input->post('godown'),
                "customer_id"=>$this->input->post('customer'),
                "rent_start_date"=>$this->input->post('startDate'),
                "rent_end_date"=>$this->input->post('endDate'),
                // "cgst_rate"=>$this->input->post('cgst'),
                // "sgst_rate"=>$this->input->post('sgst'),
                "rent_amt"=>$this->input->post('amount'),
                "modified_by"=>$this->session->userdata("loggedin")["user_id"],
                "modified_dt"=>date("Y-m-d H:i:s")
            );
            $this->Rent_calculation_model->f_edit('td_rent', $postData, array('sl_no'=>$id));
            redirect("godownrent");
        }else{
 
        $data["godown"]=$this->Rent_calculation_model->fetch_godown();
        $data["customer"]=$this->Rent_calculation_model->fetch_customer();

        $data['godownrentData']=$this->Rent_calculation_model->f_select('td_rent', $select = NULL,array('sl_no'=>$id), 1);
            
         $this->load->view("post_login/finance_main");
         $this->load->view("rent_calculation/godown_rent/godown_rent_edit", $data);
         $this->load->view("post_login/footer");
        }
    }

    public function godown_rent(){
        $data["listData"]=$this->Rent_calculation_model->fetch_rentdata();
        $this->load->view("post_login/finance_main");
        $this->load->view("rent_calculation/godown_rent/godown_rent_list", $data);
        $this->load->view("post_login/footer");
    }
    public function rent_collection(){
        
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $mode=$this->input->post('mode');
            $last_invoice_no=$this->Rent_calculation_model->invoice_no();

            $select	=	array("acchead");
            $where = array('id' =>$this->input->post('customer'));
            $dr_acccd =$this->Transaction_model->f_select("md_rent_customer", $select, $where , 1);
           
            if(empty($last_invoice_no)){
                $trans_no=0;
            }else{
                $trans_no=$last_invoice_no->trans_no;
            }
            
                $data=array(
                    "fin_yr"        =>  $this->session->userdata['loggedin']['fin_id'],
                    "trans_dt"      =>  $this->input->post('effectiveDate'),
                    "invoice_no"    =>  "RNT-".$this->session->userdata['loggedin']['fin_yr']."-".($trans_no+1),
                    "trans_type"    =>  $this->input->post('mode'),
                    "prod_id"       =>  $this->input->post('product'),
                    "cust_id"       =>  $this->input->post('customer'),
                    "godown_id"     =>  $this->input->post('godown'),
                    "qty"           =>  1,
                    "taxable_amt"   =>  $this->input->post('amount'),
                    "cgst_rt"       =>  $this->input->post('cgst_rt'),
                    "cgst_amt"      =>  $this->input->post('cgst'),
                    "sgst_rt"       =>  $this->input->post('sgst_rt'),
                    "sgst_amt"      =>  $this->input->post('sgst'),
                    "total_amt"     =>  $this->input->post('totalAmount'),
                    "irn"           =>  '',
                    "ack_no"        =>  '',
                    "ack_dt"        =>  '',
                    "remarks"        =>  $this->input->post('remarks'),
                    "colc_brn"      =>  $this->session->userdata['loggedin']['branch_id'],
                    "created_by"    =>  $this->session->userdata("loggedin")["user_id"],
                    "created_dt"    =>  date("Y-m-d H:i:s"),
                );
                $this->Rent_calculation_model->f_insert('td_rent_collection', $data);

                $sl_no    = $this->Transaction_model->f_get_voucher_id($this->session->userdata('loggedin')['fin_id']);
     
                $v_srl=$sl_no->sl_no;
                $v_id= 'HO/'.$this->session->userdata('loggedin')['fin_yr'].'/'.$v_srl;
            
                $vouchersDr = array(
                    'voucher_date'   => date("Y-m-d"),
                    'sl_no'          =>  $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => 342,
                     'trans_no'       => $trans_no+1,
                    'trans_no'       =>  $this->input->post('invoice_no'),
                    'trans_dt'       => $this->input->post('effectiveDate'),  
                    'voucher_type'   => 'RNTCOL',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'B',
                    'voucher_through'=> 'A',
                    'acc_code'       => $dr_acccd->acchead,
                    'dr_cr_flag'     => 'DR',
                    'amount'         => $this->input->post('totalAmount'),
                    'ins_no'         => $this->input->post('rfNo'),
                    'ins_dt'         => $this->input->post('rfDate'),
                    'bank_name'      => '',
                    'remarks'        => 'Rent Collection ',
                    'approval_status'=> 'U',
                    'user_flag'      => '',
                    'created_dt'     => date("Y-m-d"),
                    'created_by'     =>  $this->session->userdata("loggedin")["user_id"],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => '',
                    'approved_dt'    => '',
                    'fin_yr'         => $this->session->userdata('loggedin')['fin_id']    
                );

                $vouchersCr = array(
                    'voucher_date'   => date("Y-m-d"),
                    'sl_no'          =>  $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => 342,
                    'trans_no'       => $trans_no+1,
                    'trans_no'       =>  $this->input->post('invoice_no'),
                    'trans_dt'       => $this->input->post('effectiveDate'),  
                    'voucher_type'   => 'RNTCOL',
                    'transfer_type'  =>  'T',
                    'voucher_mode'   => 'B',
                    'voucher_through'=> 'A',
                    'acc_code'       =>8171,
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $this->input->post('amount'),
                    'ins_no'         => $this->input->post('rfNo'),
                    'ins_dt'         => $this->input->post('rfDate'),
                    'bank_name'      => '',
                    'remarks'        => 'Rent Collection ',
                    'approval_status'=> 'U',
                    'user_flag'      => '',
                    'created_dt'     => date("Y-m-d"),
                    'created_by'     =>  $this->session->userdata("loggedin")["user_id"],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => '',
                    'approved_dt'    => '',
                    'fin_yr'         => $this->session->userdata('loggedin')['fin_id']    
                );
                $vouchersCgst = array(
                    'voucher_date'   => date("Y-m-d"),
                    'sl_no'          =>  $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => 342,
                    'trans_no'       => $trans_no+1,
                    'trans_no'       => $this->input->post('invoice_no'),
                    'trans_dt'       => $this->input->post('effectiveDate'),  
                    'voucher_type'   => 'RNTCOL',
                    'transfer_type'  =>  'T',
                    'voucher_mode'   => 'B',
                    'voucher_through'=> 'A',
                    'acc_code'       => 2205,
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $this->input->post('cgst'),
                    'ins_no'         => $this->input->post('rfNo'),
                    'ins_dt'         => $this->input->post('rfDate'),
                    'bank_name'      => '',
                    'remarks'        => 'Rent Collection ',
                    'approval_status'=> 'U',
                    'user_flag'      => '',
                    'created_dt'     => date("Y-m-d"),
                    'created_by'     =>  $this->session->userdata("loggedin")["user_id"],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => '',
                    'approved_dt'    => '',
                    'fin_yr'         => $this->session->userdata('loggedin')['fin_id']    
                );
                $vouchersSgst = array(
                    'voucher_date'   => date("Y-m-d"),
                    'sl_no'          =>  $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => 342,
                    'trans_no'       => $trans_no+1,
                    'trans_no'       =>  $this->input->post('invoice_no'),
                    'trans_dt'       => $this->input->post('effectiveDate'),  
                    'voucher_type'   => 'RNTCOL',
                    'transfer_type'  =>  'T',
                    'voucher_mode'   => 'B',
                    'voucher_through'=> 'A',
                    'acc_code'       => 2206,
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $this->input->post('sgst'),
                    'ins_no'         => $this->input->post('rfNo'),
                    'ins_dt'         => $this->input->post('rfDate'),
                    'bank_name'      => '',
                    'remarks'        => 'Rent Collection ',
                    'approval_status'=> 'U',
                    'user_flag'      => '',
                    'created_dt'     => date("Y-m-d"),
                    'created_by'     =>  $this->session->userdata("loggedin")["user_id"],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => '',
                    'approved_dt'    => '',
                    'fin_yr'         => $this->session->userdata('loggedin')['fin_id']    
                );
              
                $this->Transaction_model->f_insert('td_vouchers', $vouchersDr);
                $this->Transaction_model->f_insert('td_vouchers', $vouchersCr);
                $this->Transaction_model->f_insert('td_vouchers', $vouchersCgst);
                $this->Transaction_model->f_insert('td_vouchers', $vouchersSgst);
                $this->session->set_flashdata('msg', 'Successfully Added');
                return redirect('/rent_collection');
                // print_r($data);
            
        }else{
            $where=array(
                'BNK_flag' => 'B',
                'br_id' => $this->session->userdata("loggedin")["branch_id"],
            );
            $data=array(
                "godown"=>$this->Rent_calculation_model->fetch_godown(),
                "customer"=>$this->Rent_calculation_model->fetch_customer(),
                "bank"=>$this->Rent_calculation_model->f_select('md_achead', $select=null, $where,0),
                "rent_product"=>$this->Rent_calculation_model->f_select('md_rent_product', $select=null, $whereeee=null,0),
            );
            $this->load->view("post_login/finance_main");
            $this->load->view("rent_calculation/rent_collection/rent_collection_add",$data);
            $this->load->view("post_login/footer");
        }
    }

    public function rent_collection_list(){
        $data["listData"]=$this->Rent_calculation_model->fetch_rent_collection($where=null);
        $this->load->view("post_login/finance_main");
        $this->load->view("rent_calculation/rent_collection/rent_collection_list", $data);
        $this->load->view("post_login/footer");
    }

    public function rent_collection_edit($id=null) {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
        $mode=$this->input->post('mode');
       
       
            $data=array(
                "trans_dt"      =>  $this->input->post('effectiveDate'),
               
                "trans_type"    =>  $this->input->post('mode'),
                "prod_id"       =>  $this->input->post('product'),
                "cust_id"       =>  $this->input->post('customer'),
                "godown_id"     =>  $this->input->post('godown'),
                "taxable_amt"   =>  $this->input->post('amount'),
                "cgst_rt"       =>  $this->input->post('cgst_rt'),
                "cgst_amt"      =>  $this->input->post('cgst'),
                "sgst_rt"       =>  $this->input->post('sgst_rt'),
                "sgst_amt"      =>  $this->input->post('sgst'),
                "total_amt"     =>  $this->input->post('totalAmount'),

                "irn"           =>  '',
                "ack_no"        =>  '',
                "ack_dt"        =>  '',
                "remarks"        =>  $this->input->post('remarks'),
                "colc_brn"      =>  $this->session->userdata['loggedin']['branch_id'],

                // "cr_bnk"        =>$this->input->post('crBank'),
                // "rf_date"       =>$this->input->post('rfDate'),
                // "rf_no"         =>$this->input->post('rfNo'),

                "modified_by"    =>  $this->session->userdata("loggedin")["user_id"],
                "modified_dt"    =>  date("Y-m-d H:i:s"),
            );

            // print_r($id);
            // exit();
            $this->Rent_calculation_model->f_edit('td_rent_collection', $data, array('trans_no'=>$id));
           return redirect('/rent_collection');
            // print_r($data);
        
        }else{
            $where=array(
                'BNK_flag' => 'B',
                'br_id' =>  $this->session->userdata("loggedin")["branch_id"],
            );
            $data=array(
                "godown"=>$this->Rent_calculation_model->fetch_godown(),
                "customer"=>$this->Rent_calculation_model->fetch_customer(),
                "bank"=>$this->Rent_calculation_model->f_select('md_achead', $select=null, $where,0),
                "rent_product"=>$this->Rent_calculation_model->f_select('md_rent_product', $select=null, $whereeee=null,0),
                "listData"=>$this->Rent_calculation_model->fetch_rent_collection($id),
            );
            $this->load->view("post_login/finance_main");
            $this->load->view("rent_calculation/rent_collection/rent_collection_edite",$data);
            $this->load->view("post_login/footer");
        }
    
    }

    public function collectRent(){
        $data["listData"]=$this->Rent_calculation_model->fetch_rent_collectionedit($where=null);
        $this->load->view("post_login/finance_main");
        $this->load->view("rent_calculation/rent_collect/rent_collection_list", $data);
        $this->load->view("post_login/footer");
    }

    public function collectRentEdit($id=null){
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $mode=$this->input->post('mode');
            $sl_no    = $this->Transaction_model->f_get_voucher_id($this->session->userdata('loggedin')['fin_id']);
     //       echo $this->db->last_query();
     //       exit();
                $v_srl=$sl_no->sl_no;
                $v_id= 'HO/'.$this->session->userdata('loggedin')['fin_yr'].'/'.$v_srl;
                
                $trans_no= $this->Rent_calculation_model->get_trans_no($this->session->userdata('loggedin')['fin_id'],342);
        

               
           if($this->input->post('mode')=='B'){
                $data=array(
                    "trans_type"        =>  $this->input->post('mode'),
                    "colc_brn"          =>  $this->session->userdata['loggedin']['branch_id'],
                    
                    "cr_bnk"            =>  $this->input->post('crBank'),
                    "rf_date"           =>  $this->input->post('rfDate'),
                    "rf_no"             =>  $this->input->post('rfNo'),
                    "pay_flag"          =>  'Y',
                    "payment_date"      =>  date("Y-m-d H:i:s"),
                    "bnk_trans_type"    =>  $this->input->post('transactionType'),
                    "payment_coll_by"   =>  $this->session->userdata("loggedin")["user_id"],
                    "payment_coll_dt"   =>  date("Y-m-d H:i:s"),
                );
                if($this->input->post('transactionType')=='NEFT'){
                    $transf_tupe='N';
                }else if($this->input->post('transactionType')=='RTGS'){
                    $transf_tupe='R';
                }else if($this->input->post('transactionType')=='IMPS'){
                    $transf_tupe='I';
                }else if($this->input->post('transactionType')=='CHEQUE'){
                    $transf_tupe='CH';
                }

               
                $vouchersData = array(
                    'voucher_date'   => date("Y-m-d"),
                    'sl_no'          =>  $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => 342,
                    // 'trans_no'       =>  $trans_no->trans_no,
                    'trans_no'       =>  $this->input->post('invoice_no'),
                    'trans_dt'       => $this->input->post('effectiveDate'),  
                    'voucher_type'   => 'RNT',
                    'transfer_type'  =>  $transf_tupe,
                    'voucher_mode'   => 'B',
                    'voucher_through'=> 'A',
                    'acc_code'       => $this->input->post('crBank'),
                    'dr_cr_flag'     => 'DR',
                    'amount'         => $this->input->post('totalAmount'),
                    'ins_no'         => $this->input->post('rfNo'),
                    'ins_dt'         => $this->input->post('rfDate'),
                    'bank_name'      => '',
                    'remarks'        => $this->input->post('remarks'),
                    'approval_status'=> 'U',
                    'user_flag'      => '',

                    'created_dt'     => date("Y-m-d"),
                    'created_by'     =>  $this->session->userdata("loggedin")["user_id"],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => '',
                    'approved_dt'    => '',
                    'fin_yr'         => $this->session->userdata('loggedin')['fin_id']    
                );

             
                $vouchersacc = array(
                    'voucher_date'   => date("Y-m-d"),
                    'sl_no'          =>  $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => 342,
                    'trans_no'       => $this->input->post('invoice_no'),
                    'trans_dt'       => $this->input->post('effectiveDate'),  
                    'voucher_type'   => 'RNT',
                    'transfer_type'  =>  $transf_tupe,
                    'voucher_mode'   => 'B',
                    'voucher_through'=> 'A',
                    'acc_code'       => $this->input->post('accherd'),
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $this->input->post('totalAmount'),
                    'ins_no'         => $this->input->post('rfNo'),
                    'ins_dt'         => $this->input->post('rfDate'),
                    'bank_name'      => '',
                    'remarks'        => $this->input->post('remarks'),
                    'approval_status'=> 'U',
                    'user_flag'      => '',

                    'created_dt'     => date("Y-m-d"),
                    'created_by'     =>  $this->session->userdata("loggedin")["user_id"],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => '',
                    'approved_dt'    => '',
                    'fin_yr'         => $this->session->userdata('loggedin')['fin_id']    
                );
               
            }else{
                $data=array(
                    "trans_type"        =>  $this->input->post('mode'),
                    "colc_brn"          =>  $this->session->userdata['loggedin']['branch_id'],
                    
                    "cr_bnk"            =>  6,
                   
                    "pay_flag"          =>  'Y',
                    "payment_date"      =>  date("Y-m-d"),
                    "bnk_trans_type"    =>  $this->input->post('transactionType'),
                    "payment_coll_by"   =>  $this->session->userdata("loggedin")["user_id"],
                    "payment_coll_dt"   =>  date("Y-m-d"),
                );
               
                $vouchersData = array(
                    'voucher_date'   => date("Y-m-d"),
                    'sl_no'          =>  $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => 342,
                    'trans_no'       =>   $this->input->post('invoice_no'),
                    'trans_dt'       => $this->input->post('effectiveDate'),  
                    'voucher_type'   => 'RNT',
                    'transfer_type'  => 'CH',
                    'voucher_mode'   => 'C',
                    'voucher_through'=> 'A',
                    'acc_code'       => 6,
                    'dr_cr_flag'     => 'DR',
                    'amount'         => $this->input->post('totalAmount'),
                    'ins_no'         => '',
                    'ins_dt'         => '',
                    'bank_name'      => '',
                    'remarks'        => $this->input->post('remarks'),
                    'approval_status'=> 'U',
                    'user_flag'      => '',

                    'created_dt'     => date("Y-m-d"),
                    'created_by'     =>  $this->session->userdata("loggedin")["user_id"],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => '',
                    'approved_dt'    => '',
                    'fin_yr'         => $this->session->userdata('loggedin')['fin_id']    
                );

               

                 $vouchersacc = array(
                    'voucher_date'   => date("Y-m-d"),
                    'sl_no'          =>  $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => 342,
                    'trans_no'       =>   $this->input->post('invoice_no'),
                    'trans_dt'       => $this->input->post('effectiveDate'),  
                    'voucher_type'   => 'RNT',
                    'transfer_type'  => 'CH',
                    'voucher_mode'   => 'C',
                    'voucher_through'=> 'A',
                    'acc_code'       => $this->input->post('accherd'),
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $this->input->post('totalAmount'),
                    'ins_no'         => '',
                    'ins_dt'         => '',
                    'bank_name'      => '',
                    'remarks'        => $this->input->post('remarks'),
                    'approval_status'=> 'U',
                    'user_flag'      => '',

                    'created_dt'     => date("Y-m-d"),
                    'created_by'     =>  $this->session->userdata("loggedin")["user_id"],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => '',
                    'approved_dt'    => '',
                    'fin_yr'         => $this->session->userdata('loggedin')['fin_id']    
                );
                
            }
            // print_r($vouchersData);
            // echo '<br>';
            // echo '<br>';
            // echo '<br>';
            // echo '<br>';
            // print_r($vouchersacc);
            // exit();
            
                // $this->db->insert('td_vouchers', $input_sale);
                $this->Rent_calculation_model->insertvouchers($vouchersData);
                //  echo $this->db->last_query();
                
                
                $this->Rent_calculation_model->insertvouchers($vouchersacc);
                 //exit();
           
                $this->Rent_calculation_model->f_edit('td_rent_collection', $data, array('trans_no'=>$id));
               return redirect('/collectRent');
                
            
            }else{
                $where=array(
                    'BNK_flag' => 'B',
                    'br_id' =>  $this->session->userdata("loggedin")["branch_id"],
                );
                $data=array(
                    "godown"=>$this->Rent_calculation_model->fetch_godown(),
                    "customer"=>$this->Rent_calculation_model->fetch_customer(),
                    "bank"=>$this->Rent_calculation_model->f_select('md_achead', $select=null, $where,0),
                    "rent_product"=>$this->Rent_calculation_model->f_select('md_rent_product', $select=null, $whereeee=null,0),
                    "listData"=>$this->Rent_calculation_model->fetch_rent_collectionedit($id),
                );
                
                $this->load->view("post_login/finance_main");
                $this->load->view("rent_calculation/rent_collect/rent_collection_edite",$data);
                $this->load->view("post_login/footer");
            }
    }

    public function rent_report(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $from_date=$this->input->post('from_date');
            $to_date=$this->input->post('to_date');
           
        $data["listData"]=$this->Rent_calculation_model->fetch_rent_collectreport(null,$from_date,$to_date);
        $data["todate"]=$to_date;
        $data["from_date"]=$from_date;

        // echo $this->db->last_query();
        // exit();
        $this->load->view("post_login/finance_main");
        $this->load->view("rent_calculation/report", $data);
        $this->load->view("post_login/footer");
        }else{
        $this->load->view("post_login/finance_main");
        $this->load->view("rent_calculation/report_ip");
        $this->load->view("post_login/footer");
        }
    }

    public function fetch_product(){
        $product_id=$this->input->post('product_id');
        $data=$this->Rent_calculation_model->f_select('md_rent_product', $select=null, array("sl_no"=>$product_id),1);
         $res=array(
            'cgst_rt'=>'<b>'.$data->cgst_rt.'</b>',
            'sgst_rt'=>'<b>'.$data->sgst_rt.'</b>',
            'htm_cgst_rt'=>$data->cgst_rt,
            'htm_sgst_rt'=>$data->sgst_rt
         );
         echo json_encode($res);
    }


    public function fetch_gst(){
        $cust_id=$this->input->post('cust_id');  
        $where=array(
            'id'=>$cust_id
          
        );
        $data=$this->Rent_calculation_model->f_select('md_rent_customer', $select=null, $where, 1);

    //    echo $this->db->last_query();
    //     exit();
        $gst_rt=$data->gst_rt;
        //print_r($data);
         echo json_encode($gst_rt);
    }
    public function fetch_amount(){
        $godown_id=$this->input->post('godown_id');
        $cust_id=$this->input->post('cust_id');
        $where=array(
            'customer_id'=>$cust_id,
            'godown_id'=>$godown_id,
            'effective_date = (SELECT Max(effective_date) FROM td_rent WHERE customer_id = '.$cust_id.' AND godown_id = '.$godown_id.')'=>null,
        );
        $data=$this->Rent_calculation_model->f_select('td_rent', $select=null, $where, 1);

    //    echo $this->db->last_query();
    //     exit();
        $amount=$data->rent_amt;
        //print_r($data);
         echo json_encode($amount);
    }

    public function fetch_godown(){
        $customer=$this->input->post('customer');
        $data=$this->Rent_calculation_model->fetchCustomer($customer);
       
        $pData="<option value=''>Select</option>";
        foreach ($data as $GodownData) {
            $pData.='<option value="'.$GodownData->godown_id.'">'.$GodownData->gdn_name.'</option>';
        }
        

        echo json_encode($pData);
    }

}
?>