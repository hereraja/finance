<?php
defined('BASEPATH') or exit('No direct script access allowed');
class HTransportC extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->helper('checksess_helper');
        $this->load->model('Rent_calculation_model');
        $this->load->model('HTransportC_model');
        $this->load->model('Transaction_model');
        $this->load->helper('currecyword_helper');
        if (!isset($this->session->userdata['loggedin']['user_id'])) {
            redirect('login');
        }
    }
    public function index()
    {
        $data['customar_list'] = $this->HTransportC_model->get_customar_list();
        $this->load->view('post_login/finance_main');
        $this->load->view("hTransportC/customer/customer_list", $data);
        $this->load->view('post_login/footer');
    }

    public function customar_entry()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $postData = array(
                "cust_name" => $this->input->post("customerName"),
                "cust_dist" => $this->input->post("district"),
                "cust_addr" => $this->input->post("customerAddress"),
                "cnct_no" => $this->input->post("contactNumber"),
                "cnct_person" => $this->input->post("contactPerson"),
                "email_id" => $this->input->post("email"),
                "gst_no" => $this->input->post("gstNumber"),
                "sac_code" => $this->input->post("sac_code"),
                "pan_no" => $this->input->post("panNo"),
                "fms_id" => $this->input->post("fmsid"),
                "acchead" => $this->input->post("acchead"),
                // "gst_rt" => $this->input->post("gst_rt"),
                "pin_code" => $this->input->post("pincode"),
                "created_by" => $this->session->userdata("loggedin")["user_id"],
                "created_dt" => date("Y-m-d H:i:s"),
                "acchead" => $this->input->post("acchead")
            );
            $this->HTransportC_model->customar_entry($postData);
            redirect("handling-trandport-charges/customar");
        } else {

            $where = array(
                // 'BNK_flag' => 'B',
                // 'sl_no'=>
                'br_id' => $this->session->userdata("loggedin")["branch_id"],
            );
            $data["district"] = $this->Rent_calculation_model->fetch_district();
            $data["bank"] = $this->Rent_calculation_model->f_select('md_achead', null, $where, 0);
            // echo $this->db->last_query();
            // exit();
            $this->load->view('post_login/finance_main');
            $this->load->view("hTransportC/customer/customer_add", $data);
            $this->load->view('post_login/footer');
        }
    }
    public function customar_edit($id)
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $dataupdate = array(
                "cust_name" => $this->input->post("customerName"),
                "cust_dist" => $this->input->post("district"),
                "cust_addr" => $this->input->post("customerAddress"),
                "cnct_no" => $this->input->post("contactNumber"),
                "cnct_person" => $this->input->post("contactPerson"),
                "email_id" => $this->input->post("email"),
                "sac_code" => $this->input->post("sac_code"),
                "gst_no" => $this->input->post("gstNumber"),
                "acchead" => $this->input->post("acchead"),
                // "gst_rt" => $this->input->post("gst_rt"),
                "pan_no" => $this->input->post("panNo"),
                "fms_id" => $this->input->post("fmsid"),
                "pin_code" => $this->input->post("pincode"),
                "modified_by" => $this->session->userdata("loggedin")["user_id"],
                "modified_dt" => date("Y-m-d H:i:s"),
            );
            $this->HTransportC_model->updatecustomer($id, $dataupdate);
            redirect("handling-trandport-charges/customar");
        } else {


            $where = array(
                // 'BNK_flag' => 'B',
                'br_id' => $this->session->userdata("loggedin")["branch_id"],
            );
            $data["editData"] = $this->HTransportC_model->get_customar_edit($id);
            $data["district"] = $this->Rent_calculation_model->fetch_district();
            $data["bank"] = $this->Rent_calculation_model->f_select('md_achead', $select = null, $where, 0);


            $this->load->view("post_login/finance_main");
            $this->load->view("hTransportC/customer/customer_edit", $data);
            $this->load->view("post_login/footer");
        }
    }

    public function customar_htc_entry(){
        if($_SERVER["REQUEST_METHOD"] == "POST") {

            
            $postData=array(
                "effective_date"=>$this->input->post('effectiveDate'),
                
                "customer_id"=>$this->input->post('customer'),
                "htc_start_date"=>$this->input->post('startDate'),
                "htc_end_date"=>$this->input->post('endDate'),
               
                "htc_amt"=>$this->input->post('amount'),
                "created_by"=>$this->session->userdata("loggedin")["user_id"],
                "created_dt"=>date("Y-m-d H:i:s")
            );
            $this->HTransportC_model->insert_htc_add($postData);
            redirect("handling-trandport-charges/htc_list");
            // td_htc 
        }else{
 
        
        $data["customer"]=$this->HTransportC_model->fetch_customer();
        
            // echo $this->db->last_query();
            // print_r($data["customer"]);
            // exit();
         $this->load->view("post_login/finance_main");
         $this->load->view("hTransportC/htc/htc", $data);
         $this->load->view("post_login/footer");
        }

        
    }
    public function htc_list(){
        $data["listData"]=$this->HTransportC_model->fetch_htcdata();
        $this->load->view("post_login/finance_main");
        $this->load->view("hTransportC/htc/htc_list", $data);
        $this->load->view("post_login/footer");
    }

    public function htc_edit($id){
        if($_SERVER["REQUEST_METHOD"] == "POST") {

            // print_r($this->input->post());
            // exit();
            $postData=array(

               
                "customer_id"=>$this->input->post('customer'),
                "htc_start_date"=>$this->input->post('startDate'),
                "htc_end_date"=>$this->input->post('endDate'),
                "htc_amt"=>$this->input->post('amount'),
                "cgst"=>$this->input->post('cgst'),
                "sgst"=>$this->input->post('sgst'),
                "modified_by"=>$this->session->userdata("loggedin")["user_id"],
                "modified_dt"=>date("Y-m-d H:i:s")
            );
            $this->HTransportC_model->htc_edit($id,$postData);
            redirect("handling-trandport-charges/htc_list");
        }else{
 
           
        $data["customer"]=$this->HTransportC_model->fetch_customer();

        $data['godownrentData']=$this->HTransportC_model->htc_select($id);
            
         $this->load->view("post_login/finance_main");
         $this->load->view("hTransportC/htc/htcedit", $data);
         $this->load->view("post_login/footer");
        }

        
    }
    public function get_htc_persentage(){
        $c_ac= $this->input->post('c_id');
       $data= $this->HTransportC_model->getGst($c_ac);
    //    print_r($data);
       $gst_rt=($data->gst_rt)/2;
       echo json_encode($gst_rt);
    }

    public function customar_raise_invoice(){
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $mode=$this->input->post('mode');
            $last_invoice_no=$this->HTransportC_model->invoice_no();

            $select	=	array("acchead","cust_name");
            $where = array('id' =>$this->input->post('customer'));
            $dr_acccd =$this->Transaction_model->f_select("md_htc_customer", $select, $where , 1);
            $customarName=$dr_acccd->cust_name;
            $indoiceRemarks=$this->input->post('remarks');


            if(empty($last_invoice_no)){
                $gettrans_no=0;
            }else{
                $gettrans_no=$last_invoice_no->trans_no;
            }
            $trans_no="HTC-".$this->session->userdata['loggedin']['fin_yr']."-".($gettrans_no+1);
            // echo $trans_no;
            // exit();
            
                $data=array(
                    "fin_yr"        =>  $this->session->userdata['loggedin']['fin_id'],
                    "trans_dt"      =>  $this->input->post('effectiveDate'),
                    "invoice_no"    =>  $trans_no,
                    "trans_type"    =>  $this->input->post('mode'),
                    "prod_id"       =>  $this->input->post('product'),
                    "cust_id"       =>  $this->input->post('customer'),
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
                    "remarks"       =>  $this->input->post('remarks'),
                    "suppliers_ref" =>  $this->input->post('supplier_Ref'),
                    "colc_brn"      =>  $this->session->userdata['loggedin']['branch_id'],
                    "created_by"    =>  $this->session->userdata("loggedin")["user_id"],
                    "created_dt"    =>  date("Y-m-d H:i:s"),
                );
                $this->Rent_calculation_model->f_insert('td_htc_rent_collection', $data);
                // exit();
                $sl_no    = $this->Transaction_model->f_get_voucher_id($this->session->userdata('loggedin')['fin_id']);
     
                $v_srl=$sl_no->sl_no;
                $v_id= 'HO/'.$this->session->userdata('loggedin')['fin_yr'].'/'.$v_srl;


                $cramt=($this->input->post('amount')+$this->input->post('cgst')+$this->input->post('sgst'));
                $dramt=$this->input->post('totalAmount');
                if($cramt==$dramt){

                
// H&t vouchers
                    $vouchersCr = array(
                        'voucher_date'   => date("Y-m-d"),
                        'sl_no'          =>  $v_srl,
                        'voucher_id'     => $v_id,
                        'branch_id'      => 342,
                        'trans_no'       => $trans_no,
                        // 'trans_no'       =>  "HTC-".$this->session->userdata['loggedin']['fin_yr']."-".($trans_no+1),
                        'trans_dt'       => $this->input->post('effectiveDate'),  
                        'voucher_type'   => 'R',
                        'transfer_type'  => 'T',
                        'voucher_mode'   => 'J',
                        'voucher_through'=> 'A',
                        'acc_code'       => 8147,
                        'dr_cr_flag'     => 'CR',
                        'amount'         => $this->input->post('amount'),
                        'ins_no'         => $this->input->post('rfNo'),
                        'ins_dt'         => $this->input->post('rfDate'),
                        'bank_name'      => '',
                        'remarks'        => 'HTC Collection from '.$customarName.' '.$indoiceRemarks,
                        'approval_status'=> 'A',
                        'user_flag'      => '',
                        'created_dt'     => date("Y-m-d H:i:s"),
                        'created_by'     => $this->session->userdata("loggedin")["user_id"],
                        'modified_by'    => '',
                        'modified_dt'    => '',
                        'approved_by'    => '',
                        'approved_dt'    => '',
                        'fin_yr'         => $this->session->userdata('loggedin')['fin_id']    
                    );
                   
                    // print_r($vouchersCr);
                    // exit();
                    $this->Transaction_model->f_insert('td_vouchers', $vouchersCr);

                //}
            
                $vouchersDr = array(
                    'voucher_date'   => date("Y-m-d"),
                    'sl_no'          =>  $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => 342,
                     'trans_no'       => $trans_no,
                    // 'trans_no'       =>  $this->input->post('invoice_no'),
                    'trans_dt'       => $this->input->post('effectiveDate'),  
                    'voucher_type'   => 'R',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => $dr_acccd->acchead,
                    'dr_cr_flag'     => 'DR',
                    'amount'         => $this->input->post('totalAmount'),
                    'ins_no'         => $this->input->post('rfNo'),
                    'ins_dt'         => $this->input->post('rfDate'),
                    'bank_name'      => '',
                    'remarks'        => 'HTC Collection from '.$customarName.' '.$indoiceRemarks,
                    'approval_status'=> 'A',
                    'user_flag'      => '',
                    'created_dt'     => date("Y-m-d Y-m-d H:i:s"),
                    'created_by'     =>  $this->session->userdata("loggedin")["user_id"],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => '',
                    'approved_dt'    => '',
                    'fin_yr'         => $this->session->userdata('loggedin')['fin_id']    
                );
                 $this->Transaction_model->f_insert('td_vouchers', $vouchersDr);

                
                $vouchersCgst = array(
                    'voucher_date'   => date("Y-m-d"),
                    'sl_no'          =>  $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => 342,
                    'trans_no'       => $trans_no,
                    // 'trans_no'       => $this->input->post('invoice_no'),
                    'trans_dt'       => $this->input->post('effectiveDate'),  
                    'voucher_type'   => 'R',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 2205,
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $this->input->post('cgst'),
                    'ins_no'         => $this->input->post('rfNo'),
                    'ins_dt'         => $this->input->post('rfDate'),
                    'bank_name'      => '',
                    'remarks'        => 'HTC Collection from '.$customarName.' '.$indoiceRemarks,
                    'approval_status'=> 'A',
                    'user_flag'      => '',
                    'created_dt'     => date("Y-m-d H:i:s"),
                    'created_by'     =>  $this->session->userdata("loggedin")["user_id"],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => '',
                    'approved_dt'    => '',
                    'fin_yr'         => $this->session->userdata('loggedin')['fin_id']    
                );
                $this->Transaction_model->f_insert('td_vouchers', $vouchersCgst);

                $vouchersSgst = array(
                    'voucher_date'   => date("Y-m-d"),
                    'sl_no'          =>  $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => 342,
                    'trans_no'       => $trans_no,
                    // 'trans_no'       =>  $this->input->post('invoice_no'),
                    'trans_dt'       => $this->input->post('effectiveDate'),  
                    'voucher_type'   => 'R',
                    'transfer_type'  =>  'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 2206,
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $this->input->post('sgst'),
                    'ins_no'         => $this->input->post('rfNo'),
                    'ins_dt'         => $this->input->post('rfDate'),
                    'bank_name'      => '',
                    'remarks'        => 'HTC Collection from '.$customarName.' '.$indoiceRemarks,
                    'approval_status'=> 'A',
                    'user_flag'      => '',
                    'created_dt'     => date("Y-m-d H:i:s"),
                    'created_by'     =>  $this->session->userdata("loggedin")["user_id"],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => '',
                    'approved_dt'    => '',
                    'fin_yr'         => $this->session->userdata('loggedin')['fin_id']    
                );
                $this->Transaction_model->f_insert('td_vouchers', $vouchersSgst);
              
               
                
            }else{
                $this->session->set_flashdata('msg', 'Dr Amount Cr amount are not equal');
            }
               
                // $this->session->set_flashdata('msg', 'Successfully Added');


                return redirect('/handling-trandport-charges/htc_raise_invoice_list');
                // print_r($data);
            
        }else{
            

            $where=array(
                'BNK_flag' => 'B',
                'br_id' => $this->session->userdata("loggedin")["branch_id"],
            );
            $data=array(
                "godown"=>$this->Rent_calculation_model->fetch_godown(),
                "customer"=>$this->HTransportC_model->fetch_customer(),
                "bank"=>$this->Rent_calculation_model->f_select('md_achead', $select=null, $where,0),
                "rent_product"=>$this->Rent_calculation_model->f_select('md_rent_product', $select=null, array('sl_no'=>1),0),
            );
            $this->load->view("post_login/finance_main");
            $this->load->view("hTransportC/htc_collection/htc_collection_add",$data);
            $this->load->view("post_login/footer");
        }
    }

    public function fetchhtc(){
        $customar=$this->input->post('customer');
        $data=$this->HTransportC_model->fetchhtc($customar);
        // echo $this->db->last_query();
       // print_r($data);
        $res=array(
            'htc_amt'=>$data->htc_amt,
        );
        echo json_encode($res);
    }


    public function productData(){
        $product_id=$this->input->post('product_id');
        $data=$this->HTransportC_model->productData($product_id);
        $res=array(
            'cgst_rt'=>'<b>'.$data->cgst_rt.'</b>',
            'sgst_rt'=>'<b>'.$data->sgst_rt.'</b>',
            'htm_cgst_rt'=>$data->cgst_rt,
            'htm_sgst_rt'=>$data->sgst_rt
         );
         echo json_encode($res);
    }


    public function customar_raise_invoice_list(){
        $data["listData"]=$this->HTransportC_model->fetch_rent_collection($where=null);
            //  $data["listData"]=$this->Rent_calculation_model->fetch_rent_collection($where=null);
        $this->load->view("post_login/finance_main");
        $this->load->view("hTransportC/htc_collection/htc_collection_list", $data);
        $this->load->view("post_login/footer");
    }


    public function htc_collection_edit($id=null) {
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
               
                // "customer"=>$this->Rent_calculation_model->fetch_customer(),
                "customer"=>$this->HTransportC_model->fetch_customer(),
                "bank"=>$this->Rent_calculation_model->f_select('md_achead', $select=null, $where,0),
                "rent_product"=>$this->Rent_calculation_model->f_select('md_rent_product', $select=null, $whereeee=null,0),
                "listData"=>$this->HTransportC_model->fetch_rent_collection($id),
            );
            $this->load->view("post_login/finance_main");
            $this->load->view("hTransportC/htc_collection/htc_collection_edite",$data);
            $this->load->view("post_login/footer");
        }
    
    }

public function rentb2c_rep()
		{
			$trans_do = $this->input->get('invoice_no');
			$sale_rep['data'] = $this->HTransportC_model->f_get_receiptReport_dtls($trans_do);

			 $sale_rep['sum_data'] = $this->HTransportC_model->f_get_rentinv_tot($trans_do);
			// echo $this->db->last_query();
			// die();
			$sale_rep['trans_do'] = $trans_do;
		 
			 $this->load->view("post_login/finance_main");
		
			$this->load->view('hTransportC/rentb2c_invoice.php',$sale_rep);
		
			$this->load->view('post_login/footer');
			
		}
        public function rent_report(){

            if($_SERVER['REQUEST_METHOD'] == "POST") {
                $from_date=$this->input->post('from_date');
                $to_date=$this->input->post('to_date');
               
            $data["listData"]=$this->HTransportC_model->fetch_htc_collectreport(null,$from_date,$to_date);
            $data["todate"]=$to_date;
            $data["from_date"]=$from_date;
    
            // echo $this->db->last_query();
            // exit();
            $this->load->view("post_login/finance_main");
            $this->load->view("hTransportC/htc_report", $data);
            $this->load->view("post_login/footer");
            }else{
            $this->load->view("post_login/finance_main");
            $this->load->view("hTransportC/htc_report_ip");
            $this->load->view("post_login/footer");
            }
        }
    


}
