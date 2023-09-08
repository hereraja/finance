<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaction_model');
		$this->load->model('Report_Model');
        $this->load->model('master_model');
        $this->load->library('form_validation');
		$this->load->helper('checksess_helper');
		if(!isset($this->session->userdata['loggedin']['user_id'])){ 
            redirect('login');
        }
    }

    function index()
    {

        $achead_where = array(
            'br_id' => $this->session->userdata['loggedin']['branch_id'],
            'mngr_id' => 6,
            'subgr_id' => 56
        );
        $cashcd = $this->transaction_model->f_select("md_achead", $select = null, $achead_where, 1);
       
       // $cashcd = $cashcd->sl_no; hello
        $select = array(
            "voucher_date",
            "voucher_id",
            "voucher_type",
            "voucher_mode",
            "amount",
            "approval_status"
        );
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			
			$fr_dt    = $this->input->post('fr_dt');
			$to_dt    = $this->input->post('to_dt');
			
			$where = array(
			"voucher_mode"    => 'C',
			"voucher_date >="    => $fr_dt,
			"voucher_date <="    => $to_dt,
			"voucher_through" => 'M',
			"branch_id"       =>  $this->session->userdata['loggedin']['branch_id'],
            "approval_status IN ('U','H')"=>NULL,
			"1 group by voucher_id " => NULL
            );
        
		}else{
			
			$where = array(
			"voucher_mode"    => 'C',
			"voucher_date"    => date('Y-m-d'),
			"voucher_through" => 'M',
			"branch_id"       =>  $this->session->userdata['loggedin']['branch_id'],
            "approval_status IN ('U','H')"=>NULL,
			"1 group by voucher_id " => NULL
            );
		}

        $this->load->helper('unaproved_helper');
        $voucher["count_data"]=unaproved_voucher($this->session->userdata['loggedin']['branch_id'],'U');

        $voucher['row']    = $this->transaction_model->f_select("td_vouchers", $select, $where, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/view", $voucher);
        $this->load->view('post_login/footer');
		
		
    }
function approvedjournal()
    {
        $select = array(
					"voucher_date",
					"voucher_id",
					"voucher_type",
					"voucher_mode",
					"amount"
                 );
		
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			
			$fr_dt    = $this->input->post('fr_dt');
			$to_dt    = $this->input->post('to_dt');
			
			$where = array(
			"voucher_mode"      => 'J',
			"voucher_date >="    => $fr_dt,
			"voucher_date <="    => $to_dt,
			//"voucher_through" => 'M',
			"branch_id"       =>  $this->session->userdata['loggedin']['branch_id'],
           // "approval_status" => 'A',
			"1 group by voucher_id ORDER BY voucher_date DESC" => NULL
            );
        
		}else{
			
			$where  = array(
            "voucher_mode"      => 'J',
			"voucher_date"    => date('Y-m-d'),
			//"voucher_through" => 'M',
			"branch_id"       =>  $this->session->userdata['loggedin']['branch_id'],
           // "approval_status" => 'A',
			"1 group by voucher_id ORDER BY voucher_date DESC" => NULL
			);
		}

        $voucher['row']    = $this->transaction_model->f_select("td_vouchers", $select, $where, 0);

        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/approvedjournal", $voucher);
        $this->load->view('post_login/footer');
    }
    function approvedbankvoucher()
    {
        $select = array("voucher_date","voucher_id","voucher_type","voucher_mode","dr_cr_flag","amount");
        
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			
			$fr_dt    = $this->input->post('fr_dt');
			$to_dt    = $this->input->post('to_dt');
			
			$where = array(
			"voucher_mode"    => 'B',
			"voucher_date >="    => $fr_dt,
			"voucher_date <="    => $to_dt,
			//"voucher_through" => 'M',
			"branch_id"       =>  $this->session->userdata['loggedin']['branch_id'],
           // "approval_status" => 'A',
			"1 group by voucher_id ORDER BY voucher_date DESC" => NULL
            );
        
		}else{
			
			$where  = array(
            "voucher_mode"    => 'B',
			"voucher_date"    => date('Y-m-d'),
			//"voucher_through" => 'M',
			"branch_id"       =>  $this->session->userdata['loggedin']['branch_id'],
            //"approval_status" => 'A',
			"1 group by voucher_id ORDER BY voucher_date DESC" => NULL
            );
		}
        $voucher['row']    = $this->transaction_model->f_select("td_vouchers", $select, $where, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view('transaction/approvedbankvoucher', $voucher);
        $this->load->view('post_login/footer');
    }
    function approvedCashvoucher()
    {
        $achead_where = array(
            'br_id' => $this->session->userdata['loggedin']['branch_id'],
            'mngr_id' => 6,
            'subgr_id' => 56
        );
        $cashcd = $this->transaction_model->f_select("md_achead", $select = null, $achead_where, 1);
       
       // $cashcd = $cashcd->sl_no;
        $select = array(
            "voucher_date",
            "voucher_id",
            "voucher_type",
            "voucher_mode",
            "amount"
        );
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			
			$fr_dt    = $this->input->post('fr_dt');
			$to_dt    = $this->input->post('to_dt');
			
			$where = array(
			"voucher_mode"    => 'C',
			"voucher_date >="    => $fr_dt,
			"voucher_date <="    => $to_dt,
		//	"voucher_through" => 'M',
			"branch_id"       =>  $this->session->userdata['loggedin']['branch_id'],
          //  "approval_status" => 'A',
			"1 group by voucher_id ORDER BY voucher_date DESC" => NULL
            );
        
		}else{
			
			$where = array(
			"voucher_mode"    => 'C',
			"voucher_date"    => date('Y-m-d'),
		//	"voucher_through" => 'M',
			"branch_id"       =>  $this->session->userdata['loggedin']['branch_id'],
            //"approval_status" => 'A',
			"1 group by voucher_id ORDER BY voucher_date DESC" => NULL
            );
		}
        $voucher['row']    = $this->transaction_model->f_select("td_vouchers", $select, $where, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/cashvoucherlst", $voucher);
        $this->load->view('post_login/footer');
		
		
    }

	
    public function f_get_onholdv(){

       $select          = array("count(*) as cnt_v");
        
       $where=array(
           "branch_id" =>$this->input->get("dist_cd"),
           "approval_status"=>'H'
           ) ;
    
        $cnt_v    = $this->Report_Model->f_select('td_vouchers',$select,$where,1);
        echo $cnt_v->cnt_v;
    }	

    public function f_get_lstmnth(){

        //$fin_id              = $this->session->userdata['loggedin']['fin_id'];
        $select_lastend      = array("(end_mnth) as end_mnth","end_yr",'closed_by','closed_dt');
        $where_lastend       = array(
            "branch_id" =>$this->input->get("dist_cd"),
            "1 ORDER BY sl_no DESC LIMIT 1"=>null
        );
        $data    = $this->Report_Model->f_select('td_month_end',$select_lastend,$where_lastend,1);
        
        echo json_encode($data);
    }	



    function month_end()
    {
      
        $fin_id              = $this->session->userdata['loggedin']['fin_id'];

        $where               = array("sl_no"=>$fin_id);
        $data['finyrdtls']   = $this->transaction_model->f_select('md_fin_year',NULL,$where,1);
       
        $select              = array("district_code","district_name");
        $data['distDtls']    = $this->transaction_model->f_select('md_district',$select,NULL,0);
        
        $select_lastend      = array("ifnull(max(end_mnth),0)+1 as mnth");
        $where_lastend       = array("end_yr"=>$fin_id);
        $data['lastend']     = $this->transaction_model->f_select('td_month_end',$select_lastend,$where_lastend,0);
          
        $where_mn            = array('id'=>$data['lastend'][0] ->mnth);
        $data['monthdtls']   = $this->transaction_model->f_select('md_month',NULL,$where_mn,1);
        // echo $this->db->last_query();
        // die();

        $data['row']         = $this->transaction_model->f_select("td_month_end", NULL, NULL, 0);

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            
            $data_array = array(
                "branch_id"         =>  $this->input->post('dist'),
                "end_yr"            =>  $this->input->post('yr_sl'),
                "end_mnth"          => $this->input->post('mnth_id'),
                "remarks"           =>  $this->input->post('remarks'),
                "closed_by"         =>  $this->session->userdata('loggedin')['user_id'],
                "closed_dt"         =>  date('Y-m-d H:i:s')
            );
            $dist_id=$this->input->post('dist');
            //$this->load->model('Api_voucher');

          

    
            $this->transaction_model->f_insert('td_month_end', $data_array);
            $this->inser_mntEnd($data_array);
            return redirect(site_url("mnthend"));
    
        }else{
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/month_end", $data);
        $this->load->view('post_login/footer');
        }
    
    }
    public function inser_mntEnd($data_array){
        $db2 = $this->load->database('seconddb', TRUE);
		$db2->insert('td_month_end',$data_array);
       
    }

    public function f_acc_code(){
		 
        $select	=	array("a.*");
        $data    = $this->transaction_model->f_select("md_achead a",$select,NULL,0);
        // $curl = curl_init();
        echo json_encode($data);
    }

    function entry()
    {
		$br_cd = $this->session->userdata['loggedin']['branch_id'];
        $where = array(
            //'mngr_id !=' => 6,
            // 'mngr_id' => 6,
            // 'subgr_id' => 56,
			// 'subgr_id !=' => 56,
            'br_id IN ('.$br_cd.', 0)' => NULL
			//'BNK_flag != C' => NULL
        );
        $achead_where = array(
            'br_id IN ('.$br_cd.', 0)' => NULL,
            'mngr_id' => 6,
            'subgr_id' => 56
        );
        
        $cashcd = $this->transaction_model->f_select("md_achead", $select = null, $achead_where, 0);
        $data['cash_head'] = $cashcd;//->ac_name;
        // $data['cash_code'] = $cashcd->sl_no;
        $data['row']   =   $this->transaction_model->f_select("md_achead", NULL, $where, 0);
        // $product['mntend'] = $this->transaction_model->f_get_mnthend($br_cd);
        $data['date']   = $this->transaction_model->get_monthendDate();

        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/entry", $data);
        $this->load->view('post_login/footer');
    }

    function save()
    {
        $data = $this->input->post();
        $where  = array('id' => $this->session->userdata['loggedin']['branch_id']);
		$fin_id = $this->session->userdata['loggedin']['fin_id'];
		$fin_yr = str_replace("-","",$this->session->userdata['loggedin']['fin_yr']);
        $dis = $this->transaction_model->f_select("md_branch", $select = null, $where, 1);
        $v_id    = $this->transaction_model->f_get_voucher_id($fin_id);  // Incremented Sl No
        $v_id    = $v_id->sl_no;
        $voucher_id = $dis->dist_sort_code .'-'. $fin_yr .'/'. $v_id;
        $v_code  = $data['acc_code'];
        $v_dc    =  $data['dc_flg'];
        $v_amt   =  $data['amount'];

        for ($i = 0; $i < count($v_code); $i++) {
            if ($v_code[$i] != '' || $v_code[$i] > 0) {
                $data_array = array(
                    "voucher_date"      =>  $data['voucher_dt'],
                    "sl_no"             =>  $v_id,
                    "voucher_id"        =>  $voucher_id,
					"unit_id"           =>  $this->session->userdata['loggedin']['unit_id'],
					"fin_yr"            =>  $fin_id,
                    "branch_id"         =>  $this->session->userdata['loggedin']['branch_id'],
                    "trans_no"          =>  0,
                    "voucher_type"      =>  $data['voucher_type'],
                    "voucher_mode"      =>  'C',
                    "voucher_through"   =>  'M',
                    "acc_code"          =>  $v_code[$i],
                    "dr_cr_flag"        =>  $v_dc[$i] == 'Debit' ? 'Dr' : 'Cr',
                    "remarks"           =>  $data['remarks'],
                    "amount"            =>  $v_amt[$i],
                    "approval_status"   =>  'U',
                    "user_flag"         =>  'S',
                    "ins_no"            =>  NULL,
                    "ins_dt"            =>  NULL,
                    "created_by"        =>  $this->session->userdata('loggedin')['user_id'],
                    "created_dt"        =>  date('Y-m-d H:i:s'),
                    'created_ip'        =>  $_SERVER['REMOTE_ADDR']
                );

                $this->transaction_model->f_insert('td_vouchers', $data_array);
            }
        }

        $row_array = array(
            "voucher_date"          =>  $data['voucher_dt'],
            "sl_no"                 =>  $v_id,
            "voucher_id"            =>  $voucher_id,
			"unit_id"           =>  $this->session->userdata['loggedin']['unit_id'],
			"fin_yr"                =>  $fin_id,
            "branch_id"             =>  $this->session->userdata['loggedin']['branch_id'],
            "trans_no"              =>  0,
            "voucher_type"          =>  $data['voucher_type'],
            "voucher_mode"          =>  'C',
            "voucher_through"       =>  'M',
            "acc_code"              =>  $data['topacc_cd'],
            "dr_cr_flag"            =>  $data['dr_cr_flag'] == 'Debit' ? 'Dr' : 'Cr',
            "remarks"               =>  $data['remarks'],
            "amount"                =>  $data['tot_amt'],
            "approval_status"       =>  'U',
            "user_flag"             =>  'M',
            "ins_no"                =>  NULL,
            "ins_dt"                =>  NULL,
            "created_by"            =>  $this->session->userdata('loggedin')['user_id'],
            "created_dt"            =>  date('Y-m-d H:i:s'),
            'created_ip'            =>  $_SERVER['REMOTE_ADDR']
        );

        $this->transaction_model->f_insert('td_vouchers', $row_array);


        $this->session->set_flashdata('msg', 'Successfully Added');

        redirect('cashVoucher');
    }

    function edit()
    {
        $id = $this->input->get('id');
        $ac_dtls = array();
        $head_tag = array();
		
		$data['voucher_detail']  = $this->transaction_model->f_select("td_vouchers", NULL,array('voucher_id' => $id), 1);
		$voucher_type            = $data['voucher_detail']->voucher_type;
        $where = array(
            //'mngr_id !=' => 6,
            //'br_id =' => $this->session->userdata['loggedin']['branch_id']
        );
		$br_cd = $this->session->userdata['loggedin']['branch_id'];
        $achead_where = array(
            'br_id IN ('.$br_cd.', 0)' => NULL,
            'mngr_id' => 6,
            'subgr_id' => 56
        );
        $cashcd = $this->transaction_model->f_select("md_achead", $select = null, $achead_where, 1);
		$select = array(
            'a.*','g.name gr_name','s.name subgr_name'
        );
		$vou_where = array('a.voucher_id' => $id,
		                   'a.dr_cr_flag' =>$voucher_type == 'P' ? 'Dr' : 'Cr',
						   'a.acc_code=b.sl_no' => null,
                           'b.mngr_id = g.sl_no' => null,
                           'b.subgr_id = s.sl_no' => null );
        $data['ac_dtls'] = $this->transaction_model->f_select("td_vouchers a,md_achead b,mda_mngroup g,mda_subgroub s", $select,$vou_where, 0);
        $data['cash_head'] = $cashcd->ac_name;
        $data['cash_code'] = $cashcd->sl_no;
        $data['row']   =   $this->transaction_model->f_select("md_achead", NULL, NULL, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/edit", $data);
        $this->load->view('post_login/footer');
    }

    function update()
    {
        $data = $this->input->post();
        $v_code  = $data['acc_code'];
		
        $v_dc    =  $data['dc_flg'];
        $v_amt   =  $data['amount'];
        for ($i = 0; $i < count($v_code); $i++) {
           // if ($v_code[$i] != '' || $v_code[$i] > 0) {
                //$select = array('COUNT(*) row');
                $where = array(
                    'voucher_id'   => $data['voucher_id'],
					'voucher_date' => $data['voucher_dt'],
					'acc_code'     => $v_code[$i]
                );
                    $data_array = array(
                        //"acc_code"          =>  $v_code[$i],
                        "remarks"           =>  $data['remarks'],
                        "amount"            =>  $v_amt[$i],
                        "modified_by"       =>  $this->session->userdata('loggedin')['user_id'],
                        "modified_dt"       =>  date('Y-m-d H:i:s'),
                        'modified_ip'       =>  $_SERVER['REMOTE_ADDR']
                    );
					
                    $this->transaction_model->f_edit('td_vouchers', $data_array, $where);

           // }
        }
		        $where = array(
                    'voucher_id'   => $data['voucher_id'],
					'voucher_date' => $data['voucher_dt'],
					'acc_code'     => $data['topacc_cd']
                );
                $data_array = array(
                      
                        "remarks"           =>  $data['remarks'],
                        "amount"            =>  $data['tot_amt'],
                        "modified_by"       =>  $this->session->userdata('loggedin')['user_id'],
                        "modified_dt"       =>  date('Y-m-d H:i:s'),
                        'modified_ip'       =>  $_SERVER['REMOTE_ADDR']
                );
					
                    $this->transaction_model->f_edit('td_vouchers', $data_array, $where);
	
		
        $this->session->set_flashdata('msg', 'Successfully Updated');
        redirect('cashVoucher');
    }

    function delete()
    {
        $where = array(
            "voucher_id"  =>  $this->input->get('id')
        );
        $this->session->set_flashdata('msg', 'Successfully Deleted!');
        $this->transaction_model->f_delete('td_vouchers', $where);
        redirect("cashVoucher");
    }

    function forward()
    {
        if (isset($_REQUEST['submit'])) {
            $input = array(
                'approval_status' => 'A',
                "approved_by"        =>  $this->session->userdata('loggedin')['user_id'],
                "approved_dt"        =>  date('Y-m-d H:i:s')
            );
            $ap_where = array(
                'voucher_id' => $this->input->post('voucher_id'),
            );
            $this->transaction_model->f_edit('td_vouchers', $input, $ap_where);
            $this->session->set_flashdata('msg', 'Successfully Approved');
            redirect('cashVoucher');
        }
        $id = $this->input->get('id');
        $ac_dtls = array();
        $head_tag = array();

        $select = array(
            'a.*', 'b.ac_name', 'c.name subgr_name', 'd.name gr_name'
        );
        $tnx_where = array(
            'a.voucher_id' => $id,
            'a.acc_code=b.sl_no' => null,
            'b.mngr_id = d.sl_no' => null,
            'b.subgr_id = c.sl_no' => null
        );
        $tnx_dtls = $this->transaction_model->f_select("td_vouchers a, md_achead b, mda_subgroub c, mda_mngroup d", $select, $tnx_where, 2);
        // var_dump($tnx_dtls);
        // exit;
        foreach ($tnx_dtls as $k => $dt) {
            $chk = $dt->voucher_type == 'R' ? 'Dr' : 'Cr';
            if ($dt->dr_cr_flag != $chk)
                foreach ($dt as $key => $val) {
                    $ac_dtls[$k][$key] = $val;
                }
            else {
                $head_tag = array(
                    'sl_no' => $dt->sl_no,
                    'voucher_id' => $dt->voucher_id,
                    'voucher_date' => $dt->voucher_date,
                    'voucher_type' => $dt->voucher_type,
                    'dr_cr_flag' => $dt->dr_cr_flag,
                    'ac_name' => $dt->ac_name,
                    'remarks' => $dt->remarks,
                    'tot_amt' => $dt->amount
                );
            }
        }
        $where = array(
            'mngr_id !=' => 6,
            'br_id =' => $this->session->userdata['loggedin']['branch_id']
        );
        $achead_where = array(
            'br_id' => $this->session->userdata['loggedin']['branch_id'],
            'mngr_id' => 6,
            'subgr_id' => 56
        );
        $cashcd = $this->transaction_model->f_select("md_achead", $select = null, $achead_where, 1);
        $data['ac_dtls'] = $ac_dtls;
        $data['head_tag'] = $head_tag;
        $data['cash_head'] = $cashcd->ac_name;
        $data['cash_code'] = $cashcd->sl_no;
        $data['row']   =   $this->transaction_model->f_select("md_achead", NULL, $where, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/approve", $data);
        $this->load->view('post_login/footer');
    }

    function bank_view()
    {
        $select = array("voucher_date","voucher_id","voucher_type","voucher_mode","dr_cr_flag","amount","approval_status");
        
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			
			$fr_dt    = $this->input->post('fr_dt');
			$to_dt    = $this->input->post('to_dt');
			
			$where = array(
			"voucher_mode"    => 'B',
			"voucher_date >="    => $fr_dt,
			"voucher_date <="    => $to_dt,
			"voucher_through" => 'M',
			"branch_id"       =>  $this->session->userdata['loggedin']['branch_id'],
            "approval_status IN ('U','H')"=>NULL,
			"1 group by voucher_id " => NULL
            );
        
		}else{
			
			$where  = array(
            "voucher_mode"    => 'B',
			"voucher_date"    => date('Y-m-d'),
			"voucher_through" => 'M',
			"branch_id"       =>  $this->session->userdata['loggedin']['branch_id'],			
            "approval_status IN ('U','H')"=>NULL,
			"1 group by voucher_id" => NULL
            );
		}

        $this->load->helper('unaproved_helper');
       $voucher["count_data"]=unaproved_voucher($this->session->userdata['loggedin']['branch_id'],'U');

        $voucher['row']    = $this->transaction_model->f_select("td_vouchers", $select, $where, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view('transaction/bank_view', $voucher);
        $this->load->view('post_login/footer');
    }
/************************Advance from Society Voucher Vu************************** */
function adv_appview()
{
    $select = array(
        "voucher_date",
        "voucher_id",
        "trans_no",
        "amount",
        "approval_status"
    );

    $where  = array(
        //"user_flag"       => 'M',
        "voucher_type"    => 'A',
        "approval_status" => 'U',
        "1 group by voucher_id" => NULL
    );
    $voucher['row']    = $this->transaction_model->f_select("td_vouchers", $select, $where, 0);
    $this->load->view('post_login/finance_main');
    $this->load->view('transaction/adv_appview', $voucher);
    $this->load->view('post_login/footer');
}
/***************************************** */

    /************************Cr note to Society Voucher Vu************************** */
function crn_appview()
{
    $select = array(
        "voucher_date",
        "voucher_id",
        "trans_no",
        "amount",
        "approval_status"
    );

    $where  = array(
        //"user_flag"       => 'M',
        "voucher_type"    => 'CRN',
        "approval_status" => 'U',
        "1 group by voucher_id" => NULL
    );
    $voucher['row']    = $this->transaction_model->f_select("td_vouchers", $select, $where, 0);
    $this->load->view('post_login/finance_main');
    $this->load->view('transaction/crn_appview', $voucher);
    $this->load->view('post_login/footer');
}
/***************************************** */
	/************************************************** */
    function purchase_appview(){
	    $br_cd =$this->session->userdata['loggedin']['branch_id'];
        $select = array(
            "voucher_date",
            "voucher_id",
            "trans_no",
            // "sum(amount) amount",
            "approval_status"

        );

        // if ($br_cd==342){
            // $where  = array(
                // "approval_status" => 'U',
                // "1 group by voucher_id" => NULL
            // );

        // }else{
            $where  = array(
                "branch_id"=>$br_cd,
                'fin_yr'   =>$this->session->userdata['loggedin']['fin_id'],
				"approval_status IN ('U','H') " => NULL,
                "dr_cr_flag"=>'Dr',
                // "1 group by voucher_date, voucher_id,trans_no,approval_status" => NULL
            );
        //}



        $voucher['row']    = $this->transaction_model->select_purchase_appview($this->session->userdata['loggedin']['fin_id'],$br_cd);
        //->f_select("td_vouchers", $select, $where, 0);
        //echo $this->db->last_query();
        //print_r($voucher['row']);
        //exit();
        $this->load->view('post_login/finance_main');
        $this->load->view('transaction/purchase_appview', $voucher);
        $this->load->view('post_login/footer');
    }
	
	function get_voucher(){
		
		$br_cd =$this->session->userdata['loggedin']['branch_id'];
		$vtype = $this->input->get('vtype');
        $select = array("voucher_date","voucher_id","trans_no","amount","approval_status");
        $where  = array(
			"branch_id"=>$br_cd,
			"approval_status" => 'U',
			"voucher_type" => $vtype,
			"1 group by voucher_id" => NULL
            );
        $voucher    = $this->transaction_model->f_select("td_vouchers", $select, $where, 0);
		echo json_encode($voucher);
	}
    /***************************************** */
    public function purchaseappv(){
        
            $id = $this->input->get('id');
            // $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $fin_yr= $this->session->userdata['loggedin']['fin_id'];
           
            $data['voucher']     = $this->Report_Model->f_get_purappvoucher($id);
            // print_r($data['voucher']);
            // exit();
			
            $data['advance']     = $this->Report_Model->f_get_purappjnl($id);
			
            $this->load->view('post_login/finance_main');
            // $this->load->view('report/adv_jrnl/adv_jrnl.php',$data);
            $this->load->view('transaction/purapp_jrnl.php',$data);
            $this->load->view('post_login/footer');
    }
    public function f_upd_app(){
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $data_array = array(
				          'approval_status'   => $this->input->post('appstatus'),
                          'approved_by'       => $this->session->userdata('loggedin')['user_id'],
                          'approved_dt'       => date('Y-m-d H:i:s')   
                          );
                
            $where = array(
                    "voucher_date" => $this->input->post('voucher_date'),
                    "voucher_id"   => $this->input->post('voucher_id')
            );
            $this->Report_Model->f_edit('td_vouchers', $data_array, $where);
            $this->session->set_flashdata('msg', 'Successfully Updated');
            $this->load->view('post_login/finance_main');
            $this->load->view('post_login/footer');
            redirect('purchasevu');
        }
    }


	/*******************************************/
    function bank_add()
    {
        $bnk_head_where = array(
            'mngr_id' => 6,
			'BNK_flag =' => 'B',
            'subgr_id' => 57,
            'br_id' => $this->session->userdata['loggedin']['branch_id']
        );
		$br_cd = $this->session->userdata['loggedin']['branch_id'];
        $achead_where = array(
            //'subgr_id !=' => '57',
            'br_id IN ('.$br_cd.', 0)' => NULL
        );
        $data['row']   =   $this->transaction_model->f_select("md_achead", NULL, $achead_where, 0);
        $data['bank']  =   $this->transaction_model->f_select("md_achead", NULL, $bnk_head_where, 0);

        $data['date']   = $this->transaction_model->get_monthendDate();
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/bank_entry", $data);
        $this->load->view('post_login/footer');
    }

    function bank_save()
    {
		
        $data = $this->input->post();
        $where          = array('id' => $this->session->userdata['loggedin']['branch_id']);
		$fin_id         = $this->session->userdata['loggedin']['fin_id'];
		$fin_yr         = str_replace("-","",$this->session->userdata['loggedin']['fin_yr']);
        $dis            = $this->transaction_model->f_select("md_branch", $select = null, $where, 1);
        $v_id           =   $this->transaction_model->f_get_voucher_id($fin_id);  // Incremented Sl No
        $v_id           =   $v_id->sl_no;
		$voucher_id     = $dis->dist_sort_code .'-'. $fin_yr .'/'. $v_id;
        $v_code         =   $data['acc_code'];
        $v_dc           =   $data['dc_flg'];
        $v_amt          =   $data['amount'];
        for ($i = 0; $i < count($v_code); $i++) {
            $data_array = array(
                "voucher_date"      =>  $data['voucher_dt'],
                "sl_no"             =>  $v_id,
                "voucher_id"        =>  $voucher_id,
				"unit_id"           =>  $this->session->userdata['loggedin']['unit_id'],
				"fin_yr"            =>  $fin_id,
				"fin_yr"            =>  $fin_id,
                "branch_id"         =>  $this->session->userdata['loggedin']['branch_id'],
                "trans_no"          =>  $data['inst_num'],
                "trans_dt"          =>  $data['inst_dt'],
                "voucher_type"      =>  $data['voucher_type'],
                "transfer_type"     =>  $data['transfer_type'],
                "voucher_mode"      =>  'B',
                "voucher_through"   =>  'M',
                "acc_code"          =>  $v_code[$i],
                "dr_cr_flag"        =>  $v_dc[$i] == 'Debit' ? 'Dr' : 'Cr',
                "remarks"           =>  $data['remarks'],
                "amount"            =>  $v_amt[$i],
                "approval_status"   =>  'U',
                "user_flag"         =>  'S',
                "ins_no"            =>  NULL,
                "ins_dt"            =>  NULL,
                "created_by"        =>  $this->session->userdata('loggedin')['user_id'],
                "created_dt"        =>  date('Y-m-d H:i:s'),
                'created_ip'            =>  $_SERVER['REMOTE_ADDR']
            );
            $this->transaction_model->f_insert('td_vouchers', $data_array);
        }
		//  Code start for Bank Entry As Debit  
        $row_array = array(
            "voucher_date"          =>  $data['voucher_dt'],
            "sl_no"                 =>  $v_id,
            "voucher_id"            =>  $voucher_id,
			"unit_id"               =>  $this->session->userdata['loggedin']['unit_id'],
			"fin_yr"                =>  $fin_id,
            "branch_id"             =>  $this->session->userdata['loggedin']['branch_id'],
            "trans_no"              =>  $data['inst_num'],
            "trans_dt"              =>  $data['inst_dt'],
            "voucher_type"          =>  $data['voucher_type'],
            "transfer_type"         =>  $data['transfer_type'],
            "voucher_mode"          =>  'B',
            "voucher_through"       =>  'M',
            "acc_code"              =>  $data['bank_cd'],
            "dr_cr_flag"            =>  $data['dr_cr_flag'] == 'Debit' ? 'Dr' : 'Cr',
            "remarks"               =>  $data['remarks'],
            "amount"                =>  $data['tot_amt'],
            "approval_status"       =>  'U',
            "user_flag"             =>  'M',
            "ins_no"                =>  NULL,
            "ins_dt"                =>  NULL,
            "created_by"            =>  $this->session->userdata('loggedin')['user_id'],
            "created_dt"            =>  date('Y-m-d H:i:s'),
            'created_ip'            =>  $_SERVER['REMOTE_ADDR']
        );
        $this->transaction_model->f_insert('td_vouchers', $row_array);
        //  Code start for Bank Entry As Debit 

        $this->session->set_flashdata('msg', 'Successfully Added');

        redirect('bankVoucher');
    }

    function bank_edit()
    {
        $id = $this->input->get('id');
        $ac_dtls = array();
        $head_tag = array();
		$data['voucher_detail']  = $this->transaction_model->f_select("td_vouchers", NULL,array('voucher_id' => $id), 1);
        $voucher_type            = $data['voucher_detail']->voucher_type;
		$data['bank_detail']     = $this->transaction_model->f_select("td_vouchers", NULL,array('voucher_id' => $id,'dr_cr_flag' =>$voucher_type == 'R' ? 'Dr' : 'Cr'), 1);
        
        $bnk_head_where = array(
            'mngr_id' => 6,
            'subgr_id' => 57,
            'br_id' => $this->session->userdata['loggedin']['branch_id']
        );
		$br_cd = $this->session->userdata['loggedin']['branch_id'];
        $achead_where = array(
			//'subgr_id !=' => 57,
            'br_id IN ('.$br_cd.', 0)' => NULL
        );
        $data['row']      =  $this->transaction_model->f_select("md_achead", NULL, $achead_where, 0);
        $data['bank']     =  $this->transaction_model->f_select("md_achead", NULL, $bnk_head_where, 0);
		$select = array(
            'a.*','g.name gr_name','s.name subgr_name'
        );
		$vou_where = array('a.voucher_id' => $id,
		                   'a.dr_cr_flag' =>$voucher_type == 'P' ? 'Dr' : 'Cr',
						   'a.acc_code=b.sl_no' => null,
                           'b.mngr_id = g.sl_no' => null,
                           'b.subgr_id = s.sl_no' => null);
        $data['ac_dtls'] = $this->transaction_model->f_select("td_vouchers a,md_achead b,mda_mngroup g,mda_subgroub s", $select,$vou_where, 0);
        $data['head_tag'] =  $head_tag;
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/bank_edit", $data);
        $this->load->view('post_login/footer');
    }

    function bank_update()
    {
        $data = $this->input->post();
        $data = $this->input->post();
		$fin_yr         = str_replace("-","",$this->session->userdata['loggedin']['fin_yr']);
        $v_code  = $data['acc_code'];
        $v_dc    =  $data['dc_flg'];
        $v_amt   =  $data['amount'];
        for ($i = 0; $i < count($v_code); $i++) {
            if ($v_code[$i] != '' || $v_code[$i] > 0) {
                $select = array('COUNT(*) count_row');
                $where = array(
                    'voucher_id' => $data['voucher_id'],
                    'acc_code' => $v_code[$i]
                );
                $dt = $this->transaction_model->f_select("td_vouchers", $select, $where, 1);
                if ($dt->count_row > 0) {
                    $data_array = array(
					    "trans_no"          =>  $data['inst_num'],
                        "trans_dt"          =>  $data['inst_dt'],
                        "remarks"           =>  $data['remarks'],
                        "amount"            =>  $v_amt[$i],
                        "modified_by"       =>  $this->session->userdata('loggedin')['user_id'],
                        "modified_dt"       =>  date('Y-m-d H:i:s'),
                        'modified_ip'       =>  $_SERVER['REMOTE_ADDR']
                    );

                    $this->transaction_model->f_edit('td_vouchers', $data_array, $where);
                } else {
                    $data_array = array(
                        "voucher_date"          =>  $data['voucher_dt'],
                        "sl_no"                 =>  $data['sl_no'],
                        "voucher_id"            =>  $data['voucher_id'],
						"fin_yr"                =>  $this->session->userdata['loggedin']['fin_id'],
                        "branch_id"             =>  $this->session->userdata['loggedin']['branch_id'],
                        "trans_no"              =>  $data['inst_num'],
                        "trans_dt"              =>  $data['inst_dt'],
                        "voucher_type"          =>  $data['voucher_type'],
                        "transfer_type"         =>  $data['transfer_type'],
                        "voucher_mode"          =>  'B',
                        "voucher_through"       =>  'M',
                        "acc_code"              =>  $v_code[$i],
                        "dr_cr_flag"            =>  $v_dc[$i] == 'Debit' ? 'Dr' : 'Cr',
                        "remarks"               =>  $data['remarks'],
                        "amount"                =>  $v_amt[$i],
                        "approval_status"       =>  'U',
                        "user_flag"             =>  'M',
                        "ins_no"                =>  NULL,
                        "ins_dt"                =>  NULL,
                        "created_by"            =>  $this->session->userdata('loggedin')['user_id'],
                        "created_dt"            =>  date('Y-m-d H:i:s'),
                        "modified_by"           =>  $this->session->userdata('loggedin')['user_id'],
                        "modified_dt"           =>  date('Y-m-d H:i:s')
                    );
                    $this->transaction_model->f_insert('td_vouchers', $data_array);
                }
            }
        }
        $where = array(
            'voucher_id' => $data['voucher_id'],
            'acc_code' => $data['bank_code']
        );
        $row_array = array(
            "trans_no"              =>  $data['inst_num'],
            "trans_dt"              =>  $data['inst_dt'],
            "remarks"               =>  $data['remarks'],
            "amount"                =>  $data['tot_amt'],
            "modified_by"           =>  $this->session->userdata('loggedin')['user_id'],
            "modified_dt"           =>  date('Y-m-d H:i:s'),
            'modified_ip'       =>  $_SERVER['REMOTE_ADDR']
        );

        $this->transaction_model->f_edit('td_vouchers', $row_array, $where);
        $this->session->set_flashdata('msg', 'Successfully Updated');
        redirect('bankVoucher');
    }

    function bank_delete()
    {
        $where = array(
            "voucher_id"  =>  $this->input->get('id')
        );
        $this->session->set_flashdata('msg', 'Successfully Deleted!');
        $this->transaction_model->f_delete('td_vouchers', $where);
        redirect("bankVoucher");
    }
	
	function bank_rowdelete()
    {
        $id    = explode("?",trim($this->input->get('id')));
        $where = array(
            "voucher_id"  =>  $id[1],
            'acc_code'    =>  $id[0]
        );
        $this->session->set_flashdata('msg', 'Successfully Deleted!');
        $this->transaction_model->f_delete('td_vouchers', $where);
        redirect("transaction/bank_edit?id=".$id[1]);
    }

    function bank_forward()
    {
        if (isset($_REQUEST['submit'])) {
            $input = array(
                'approval_status' => 'A',
                "approved_by"        =>  $this->session->userdata('loggedin')['user_id'],
                "approved_dt"        =>  date('Y-m-d H:i:s')
            );
            $ap_where = array(
                'voucher_id' => $this->input->post('voucher_id'),
            );
            $this->transaction_model->f_edit('td_vouchers', $input, $ap_where);
            $this->session->set_flashdata('msg', 'Successfully Approved');
            redirect('bankVoucher');
        }
        $id = $this->input->get('id');
        $ac_dtls = array();
        $head_tag = array();

        $select = array(
            'a.*', 'b.ac_name', 'c.name subgr_name', 'd.name gr_name'
        );
        $tnx_where = array(
            'a.voucher_id' => $id,
            'a.acc_code=b.sl_no' => null,
            'b.mngr_id = d.sl_no' => null,
            'b.subgr_id = c.sl_no' => null
        );
        $tnx_dtls = $this->transaction_model->f_select("td_vouchers a, md_achead b, mda_subgroub c, mda_mngroup d", $select, $tnx_where, 2);
        foreach ($tnx_dtls as $k => $dt) {
            $chk = $dt->voucher_type == 'R' ? 'Dr' : 'Cr';
            if ($dt->dr_cr_flag != $chk) {
                foreach ($dt as $key => $val) {
                    $ac_dtls[$k][$key] = $val;
                }
            } else {
                $head_tag = array(
                    'sl_no' => $dt->sl_no,
                    'voucher_id' => $dt->voucher_id,
                    'voucher_date' => $dt->voucher_date,
                    'voucher_type' => $dt->voucher_type,
                    'transfer_type' => $dt->transfer_type,
                    'trans_no' => $dt->trans_no,
                    'trans_dt' => $dt->trans_dt,
                    'acc_code' => $dt->acc_code,
                    'dr_cr_flag' => $dt->dr_cr_flag,
                    'ac_name' => $dt->ac_name,
                    'remarks' => $dt->remarks,
                    'tot_amt' => $dt->amount
                );
            }
        }
        $bnk_head_where = array(
            'mngr_id' => 6,
            'subgr_id' => 57,
            'br_id' => $this->session->userdata['loggedin']['branch_id']
        );
        $achead_where = array(
            'subgr_id !=' => 56,
            'br_id' => $this->session->userdata['loggedin']['branch_id']
        );
        $data['row']   =   $this->transaction_model->f_select("md_achead", NULL, $achead_where, 0);
        $data['bank']  =   $this->transaction_model->f_select("md_achead", NULL, $bnk_head_where, 0);
        $data['ac_dtls'] = $ac_dtls;
        $data['head_tag'] = $head_tag;
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/bank_approve", $data);
        $this->load->view('post_login/footer');
    }

    function jurnal_view(){
        $select = array(
					"voucher_date",
					"voucher_id",
					"voucher_type",
					"voucher_mode",
                    "approval_status",
					"SUM(amount) AS amount"
                 );
                 $group=array(
                    "voucher_id",
                    "voucher_type",
                    "voucher_mode",
                 );
		
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			
			$fr_dt    = $this->input->post('fr_dt');
			$to_dt    = $this->input->post('to_dt');
			
			$where = array(
            "dr_cr_flag"      => 'Cr',
			"voucher_mode"      => 'J',
			"voucher_date >="    => $fr_dt,
			"voucher_date <="    => $to_dt,
			"voucher_through" => 'M',
			"branch_id"       =>  $this->session->userdata['loggedin']['branch_id'],
            "approval_status IN ('U','H')"=>NULL
			// "1 group by voucher_id,voucher_type,voucher_mode " => NULL
            );
        
		}else{
			
			$where  = array(
            "dr_cr_flag"      => 'Cr',
            "voucher_mode"    => 'J',
			"voucher_date"    => date('Y-m-d'),
			"voucher_through" => 'M',
			"branch_id"       =>  $this->session->userdata['loggedin']['branch_id'],
            "approval_status IN ('U','H')"=>NULL
			// "1 group by voucher_id, voucher_type, voucher_mode" => NULL
			);
		}
        // $voucher['row']    = $this->transaction_model->f_select("td_vouchers", $select, $where, 0);
        $voucher['row']    = $this->transaction_model->jurnalVoucher("td_vouchers", $select, $where, $group);


        $this->load->helper('unaproved_helper');
       $voucher["count_data"]=unaproved_voucher($this->session->userdata['loggedin']['branch_id'],'U');


        //  echo $this->db->last_query(); die;
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/jurnal_view", $voucher);
        $this->load->view('post_login/footer');
    }

    function jurnal_entry()
    {
		$br_cd = $this->session->userdata['loggedin']['branch_id'];
        $achead_where = array(
            //'mngr_id !=' => 6,
			'subgr_id !=' => 56,
			'br_id IN ('.$br_cd.', 0)' => NULL
        );
        $data['row']   =   $this->transaction_model->f_select("md_achead", NULL, $achead_where, 0);

        $data['date']   = $this->transaction_model->get_monthendDate();

        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/jurnal_entry", $data);
        $this->load->view('post_login/footer');
    }
    function checked_MonthEnd(){
        $year=$this->input->get('year');
        $nowMon= date("F");
        
        $data=$this->transaction_model->f_select("md_month", NULL, array("month_name"=>$nowMon), 1);
       // echo $this->db->last_query();die();
        $month=$data->id;
        if($month >= $year){
            echo json_encode(1);
        }elseif($year == 12){
            echo json_encode(1);
        }else{
            echo json_encode(0);
        }
    }

    function jurnal_save(){
        $data = $this->input->post();
       
        $where          =   array('id' => $this->session->userdata['loggedin']['branch_id']);
		$fin_id         =   $this->session->userdata['loggedin']['fin_id'];
		$fin_yr         =   str_replace("-","",$this->session->userdata['loggedin']['fin_yr']);
        $dis            =   $this->transaction_model->f_select("md_branch", $select = null, $where, 1);
        $v_id           =   $this->transaction_model->f_get_voucher_id($fin_id);  // Incremented Sl No
        $v_id           =   $v_id->sl_no;
        $voucher_id     =   $dis->dist_sort_code .'-'. $fin_yr .'/'. $v_id;


        $v_code         =   $data['acc_code'];
        $v_dc           =   $data['dc_flg'];
        $v_amt          =   $data['amount'];


        $v_code_Debit   =   $data['acc_code_Debit'];
        $v_dc_Debit     =   $data['dc_flg_Debit'];
        $v_amt_Debit    =   $data['amount_Debit'];
        

        for ($i = 0; $i < count($v_code); $i++) {
            $data_array = array(
                "voucher_date"      =>  $data['voucher_dt'],
                "sl_no"             =>  $v_id,
                "voucher_id"        =>  $voucher_id,
				"unit_id"           =>  $this->session->userdata['loggedin']['unit_id'],
				"fin_yr"            =>  $fin_id,
                "branch_id"         =>  $this->session->userdata['loggedin']['branch_id'],
                "trans_no"          =>  0,
                "voucher_type"      =>  'P',
                "voucher_mode"      =>  'J',
                "voucher_through"   =>  'M',
                "acc_code"          =>  $v_code[$i],
                "dr_cr_flag"        =>  $v_dc[$i] == 'Debit' ? 'Dr' : 'Cr',
                "remarks"           =>  $data['remarks'],
                "amount"            =>  $v_amt[$i],
                "approval_status"   =>  'U',
                "user_flag"         =>  'S',
                "ins_no"            =>  NULL,
                "ins_dt"            =>  NULL,
                "created_by"        =>  $this->session->userdata('loggedin')['user_id'],
                "created_dt"        =>  date('Y-m-d H:i:s')
            );
            
        

            //$this->transaction_model->f_insert('td_vouchers', $data_array);
            echo '<pre>'; print_r($data_array);
        }

        
        for ($i = 0; $i < count($v_code_Debit); $i++) {
            $data_array = array(
                "voucher_date"      =>  $data['voucher_dt'],
                "sl_no"             =>  $v_id,
                "voucher_id"        =>  $voucher_id,
				"unit_id"           =>  $this->session->userdata['loggedin']['unit_id'],
				"fin_yr"            =>  $fin_id,
                "branch_id"         =>  $this->session->userdata['loggedin']['branch_id'],
                "trans_no"          =>  0,
                "voucher_type"      =>  'R',
                "voucher_mode"      =>  'J',
                "voucher_through"   =>  'M',
                "acc_code"          =>  $v_code_Debit[$i],
                "dr_cr_flag"        =>  $v_dc_Debit[$i] == 'Debit' ? 'Dr' : 'Cr',
                "remarks"           =>  $data['remarks'],
                "amount"            =>  $v_amt_Debit[$i],
                "approval_status"   =>  'U',
                "user_flag"         =>  'S',
                "ins_no"            =>  NULL,
                "ins_dt"            =>  NULL,
                "created_by"        =>  $this->session->userdata('loggedin')['user_id'],
                "created_dt"        =>  date('Y-m-d H:i:s')
            );

           // $this->transaction_model->f_insert('td_vouchers', $data_array);
           // echo '<pre>'; print_r($data_array);
        }


        // $row_array = array(
        //     "voucher_date"          =>  $data['voucher_dt'],
        //     "sl_no"                 =>  $v_id,
        //     "voucher_id"            =>  $voucher_id,
		// 	"fin_yr"                =>  $fin_id,
        //     "branch_id"             =>  $this->session->userdata['loggedin']['branch_id'],
        //     "trans_no"              =>  0,
        //     "voucher_type"          =>  'P',
        //     "voucher_mode"          =>  'J',
        //     "voucher_through"       =>  'M',
        //     //"acc_code"              =>  $data['acc_cd'],
        //     //"dr_cr_flag"            =>  $data['dr_cr_flag'] == 'Debit' ? 'Dr' : 'Cr',
        //     "remarks"               =>  $data['remarks'],
        //     "amount"                =>  $data['tot_amt'],
        //     "approval_status"       =>  'U',
        //     "user_flag"             =>  'M',
        //     "ins_no"                =>  NULL,
        //     "ins_dt"                =>  NULL,
        //     "created_by"            =>  $this->session->userdata('loggedin')['user_id'],
        //     "created_dt"            =>  date('Y-m-d H:i:s')
        // );


//var_export($row_array);
//echo "</pre>";


//exit();

        //$this->transaction_model->f_insert('td_vouchers', $row_array);


        $data = $this->input->post();
        $where          =   array('id' => $this->session->userdata['loggedin']['branch_id']);
		$fin_id         =   $this->session->userdata['loggedin']['fin_id'];
		$fin_yr         =   str_replace("-","",$this->session->userdata['loggedin']['fin_yr']);
        $dis            =   $this->transaction_model->f_select("md_branch", $select = null, $where, 1);
        $v_id           =   $this->transaction_model->f_get_voucher_id($fin_id);  // Incremented Sl No
        $v_id           =   $v_id->sl_no;
        $voucher_id     =   $dis->dist_sort_code .'-'. $fin_yr .'/'. $v_id;


        $v_code         =   $data['acc_code'];
        $v_dc           =   $data['dc_flg'];
        $v_amt          =   $data['amount'];


        $v_code_Debit   =   $data['acc_code_Debit'];
        $v_dc_Debit     =   $data['dc_flg_Debit'];
        $v_amt_Debit    =   $data['amount_Debit'];

        for ($i = 0; $i < count($v_code); $i++) {
            $data_array = array(
                "voucher_date"      =>  $data['voucher_dt'],
                "sl_no"             =>  $v_id,
                "voucher_id"        =>  $voucher_id,
				"unit_id"           =>  $this->session->userdata['loggedin']['unit_id'],
				"fin_yr"            =>  $fin_id,
                "branch_id"         =>  $this->session->userdata['loggedin']['branch_id'],
                "trans_no"          =>  0,
                "voucher_type"      =>  'P',
                "voucher_mode"      =>  'J',
                "voucher_through"   =>  'M',
                "acc_code"          =>  $v_code[$i],
                "dr_cr_flag"        =>  $v_dc[$i] == 'Debit' ? 'Dr' : 'Cr',
                "remarks"           =>  $data['remarks'],
                "amount"            =>  $v_amt[$i],
                "approval_status"   =>  'U',
                "user_flag"         =>  'S',
                "ins_no"            =>  NULL,
                "ins_dt"            =>  NULL,
                "created_by"        =>  $this->session->userdata('loggedin')['user_id'],
                "created_dt"        =>  date('Y-m-d H:i:s'),
                'created_ip'        =>  $_SERVER['REMOTE_ADDR']
            );

            $this->transaction_model->f_insert('td_vouchers', $data_array);
           // echo '<pre>'; print_r($data_array);
        }


        for ($i = 0; $i < count($v_code_Debit); $i++) {
            $data_array = array(
                "voucher_date"      =>  $data['voucher_dt'],
                "sl_no"             =>  $v_id,
                "voucher_id"        =>  $voucher_id,
				"unit_id"           =>  $this->session->userdata['loggedin']['unit_id'],
				"fin_yr"            =>  $fin_id,
                "branch_id"         =>  $this->session->userdata['loggedin']['branch_id'],
                "trans_no"          =>  0,
                "voucher_type"      =>  'R',
                "voucher_mode"      =>  'J',
                "voucher_through"   =>  'M',
                "acc_code"          =>  $v_code_Debit[$i],
                "dr_cr_flag"        =>  $v_dc_Debit[$i] == 'Debit' ? 'Dr' : 'Cr',
                "remarks"           =>  $data['remarks'],
                "amount"            =>  $v_amt_Debit[$i],
                "approval_status"   =>  'U',
                "user_flag"         =>  'S',
                "ins_no"            =>  NULL,
                "ins_dt"            =>  NULL,
                "created_by"        =>  $this->session->userdata('loggedin')['user_id'],
                "created_dt"        =>  date('Y-m-d H:i:s'),
                'created_ip'            =>  $_SERVER['REMOTE_ADDR']
            );

            $this->transaction_model->f_insert('td_vouchers', $data_array);
           // echo '<pre>'; print_r($data_array);
        }



        $this->session->set_flashdata('msg', 'Successfully Added');

        redirect('jurnalVoucher');
    }

    function jurnal_edit()
    {
        $id = $this->input->get('id');
        $ac_dtls = array();
        $head_tag = array();
		$data['voucher_detail']  = $this->transaction_model->f_select("td_vouchers", NULL,array('voucher_id' => $id), 1);
        $voucher_type            = $data['voucher_detail']->voucher_type;
		// $data['topacc_head']     = $this->transaction_model->f_select("td_vouchers", NULL,array('voucher_id' => $id,'dr_cr_flag' =>$voucher_type == 'R' ? 'Dr' : 'Cr'), 1);
        $br_cd = $this->session->userdata['loggedin']['branch_id'];
        $achead_where = array(
            'mngr_id !=' => 6,
			'subgr_id !=' => 56,
			'br_id IN ('.$br_cd.', 0)' => NULL
        );
        $achead_wheree = array(
            //'mngr_id !=' => 6,
			'subgr_id !=' => 56,
			'br_id IN ('.$br_cd.', 0)' => NULL
        );
        $data['row']   =   $this->transaction_model->f_select("md_achead", NULL, $achead_wheree, 0);
		$select = array(
            'a.*','g.name gr_name','s.name subgr_name'
        );
        $vou_where = array('a.voucher_id' => $id,
		                   'a.dr_cr_flag' =>'Cr',
						   'a.acc_code=b.sl_no' => null,
                           'b.mngr_id = g.sl_no' => null,
                           'b.subgr_id = s.sl_no' => null );
       
        $data['ac_dtls'] = $this->transaction_model->f_select("td_vouchers a,md_achead b,mda_mngroup g,mda_subgroub s", $select,$vou_where, 0);

        $vou_wheree = array('a.voucher_id' => $id,
        'a.dr_cr_flag' =>'Dr',
        'a.acc_code=b.sl_no' => null,
        'b.mngr_id = g.sl_no' => null,
        'b.subgr_id = s.sl_no' => null );
        $data['topacc_head'] = $this->transaction_model->f_select("td_vouchers a,md_achead b,mda_mngroup g,mda_subgroub s", $select,$vou_wheree, 0);
        $data['head_tag'] = $head_tag;
        $data['id']=$id;

        // $data['row_acc']   =   $this->transaction_model->f_select("md_achead", NULL, $achead_wheree, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/jurnal_edit", $data);
        $this->load->view('post_login/footer');
    }

    function jurnal_update()
    {
       
        $data = $this->input->post();
        
        $id        =   $data['id'];
        $v_code    =   $data['acc_code'];
        $v_amt     =   $data['amount'];
        $v_code_Debit   =   $data['acc_code_Debit'];
        
        $v_amt_Debit    =   $data['amount_Debit'];

        for ($i = 0; $i < count($v_amt); $i++) {
            $data_array = array(
                "branch_id"         =>  $this->session->userdata['loggedin']['branch_id'],
                "remarks"           =>  $data['remarks'],
                "amount"            =>  $v_amt[$i],
                "modified_by"        =>  $this->session->userdata('loggedin')['user_id'],
                "modified_dt"        =>  date('Y-m-d H:i:s'),
                'modified_ip'       =>  $_SERVER['REMOTE_ADDR']
            );
            $where = array(
                'voucher_id' => $id,
                'acc_code' => $v_code[$i],
                );
            $this->transaction_model->f_edit('td_vouchers', $data_array, $where);
        }
        for ($i = 0; $i < count($v_code_Debit); $i++) {
            $data_array = array(
                "branch_id"         =>  $this->session->userdata['loggedin']['branch_id'],
                "remarks"           =>  $data['remarks'],
                "amount"            =>  $v_amt_Debit[$i],
                "modified_by"        =>  $this->session->userdata('loggedin')['user_id'],
                "modified_dt"        =>  date('Y-m-d H:i:s'),
                'modified_ip'       =>  $_SERVER['REMOTE_ADDR']
            );
            $where = array(
                'voucher_id' => $id,
                'acc_code' => $v_code_Debit[$i],
                );
            $this->transaction_model->f_edit('td_vouchers', $data_array, $where);
           
        }
         $this->session->set_flashdata('msg', 'Successfully Updated');
         redirect('jurnalVoucher');
    }

    function jurnal_delete()
    {
        $where = array(
            "voucher_id"  =>  $this->input->get('id')
        );
        $this->session->set_flashdata('msg', 'Successfully Deleted!');
        $this->transaction_model->f_delete('td_vouchers', $where);
        redirect("jurnalVoucher");
    }
	function jurnal_rowdelete(){
        
        $id    = explode("?",trim($this->input->get('id')));
        $where = array(
            "voucher_id"  =>  $id[1],
            'acc_code'    =>  $id[0]
        );
        $this->session->set_flashdata('msg', 'Successfully Deleted!');
        $this->transaction_model->f_delete('td_vouchers', $where);
        redirect("transaction/jurnal_edit?id=".$id[1]);
    }

    function jurnal_approve()
    {
        if (isset($_REQUEST['submit'])) {
            $input = array(
                'approval_status' => 'A',
                "approved_by"        =>  $this->session->userdata('loggedin')['user_id'],
                "approved_dt"        =>  date('Y-m-d H:i:s')
            );
            $ap_where = array(
                'voucher_id' => $this->input->post('voucher_id'),
            );
            $this->transaction_model->f_edit('td_vouchers', $input, $ap_where);
            $this->session->set_flashdata('msg', 'Successfully Approved');
            redirect('jurnalVoucher');
        }
        $id = $this->input->get('id');
        $ac_dtls = array();
        $head_tag = array();

        $select = array(
            'a.*', 'b.ac_name', 'c.name subgr_name', 'd.name gr_name'
        );
        $tnx_where = array(
            'a.voucher_id' => $id,
            'a.acc_code=b.sl_no' => null,
            'b.mngr_id = d.sl_no' => null,
            'b.subgr_id = c.sl_no' => null
        );
        $tnx_dtls = $this->transaction_model->f_select("td_vouchers a, md_achead b, mda_subgroub c, mda_mngroup d", $select, $tnx_where, 2);
        foreach ($tnx_dtls as $k => $dt) {
            $chk = $dt->voucher_type == 'R' ? 'Dr' : 'Cr';
            if ($dt->dr_cr_flag != $chk) {
                foreach ($dt as $key => $val) {
                    $ac_dtls[$k][$key] = $val;
                }
            } else {
                $head_tag = array(
                    'sl_no' => $dt->sl_no,
                    'voucher_id' => $dt->voucher_id,
                    'voucher_date' => $dt->voucher_date,
                    'voucher_type' => $dt->voucher_type,
                    'transfer_type' => $dt->transfer_type,
                    'trans_no' => $dt->trans_no,
                    'trans_dt' => $dt->trans_dt,
                    'acc_code' => $dt->acc_code,
                    'dr_cr_flag' => $dt->dr_cr_flag,
                    'ac_name' => $dt->ac_name,
                    'remarks' => $dt->remarks,
                    'tot_amt' => $dt->amount
                );
            }
        }
        $achead_where = array(
            'mngr_id !=' => 6,
            'br_id' => $this->session->userdata['loggedin']['branch_id']
        );
        $data['row']   =   $this->transaction_model->f_select("md_achead", NULL, $achead_where, 0);
        $data['ac_dtls'] = $ac_dtls;
        $data['head_tag'] = $head_tag;
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/jurnal_approve", $data);
        $this->load->view('post_login/footer');
    }

    function get_gr_dtls()
    {
        $achead_id = $this->input->get('ac_id');
        $data = $this->transaction_model->get_gr_dtls($achead_id);
        echo json_encode($data);
    }
    //  *********     Start Code for cheque detail Screen     ****** //
    function cheqdtl()
    {
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			
			$fr_dt    = $this->input->post('fr_dt');
			$to_dt    = $this->input->post('to_dt');
			
			$where = array(
			"cheq_dt >="    => $fr_dt,
			"cheq_dt <="    => $to_dt,
			"branch_id"          => $this->session->userdata['loggedin']['branch_id'],
            "fin_yr"             => $this->session->userdata['loggedin']['fin_id']
            );
        
		}else{
			
			$where  = array(
			"cheq_dt"    => date('Y-m-d'),
			"branch_id"       =>  $this->session->userdata['loggedin']['branch_id'],
            "fin_yr"             => $this->session->userdata['loggedin']['fin_id']
			);
		}
        $br_cd = $this->session->userdata['loggedin']['branch_id'];
        $data['society']   =   $this->transaction_model->f_select_fertidb("mm_ferti_soc",array('soc_id','soc_name'),array('district =' => $br_cd), 0);
        $data['row']    = $this->transaction_model->f_select("td_chequedetail",NULL, $where, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/cheqdtl_view", $data);
        $this->load->view('post_login/footer');
    }

    function cheqdtladd()
    {
		$br_cd = $this->session->userdata['loggedin']['branch_id'];
        $where = array(
            'district =' => $br_cd
        );
        $data['row']   =   $this->transaction_model->f_select_fertidb("mm_ferti_soc", NULL, $where, 0);

        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/cheqdtl_entry", $data);
        $this->load->view('post_login/footer');
    }

    function cheqdtlsave()
    {
        $error ='';
		$fin_id         = $this->session->userdata['loggedin']['fin_id'];
        $this->form_validation->set_rules('soc_id', 'Soc Name', 'required');
        $this->form_validation->set_rules('cheq_no', 'Cheque No', 'required');
        $this->form_validation->set_rules('cheq_dt', 'Cheque date', 'required');
        $this->form_validation->set_rules('amt', 'Amount', 'required');
        $this->form_validation->set_rules('bank_name', 'Bank Name', 'required');

        if($this->form_validation->run() == TRUE){
            $data_array = array(
                "soc_id"         =>  $this->input->post('soc_id'),
                "cheq_no"        =>  trim($this->input->post('cheq_no')),
                "cheq_dt"        =>  trim($this->input->post('cheq_dt')),
                "amt"            =>  trim($this->input->post('amt')),
                "bank_name"      =>  trim($this->input->post('bank_name')),
                "remarks"        =>  $this->input->post('remarks'),
                "branch_id"      =>  $this->session->userdata['loggedin']['branch_id'],
				"fin_yr"         =>  $fin_id,
                "created_by"     =>  $this->session->userdata('loggedin')['user_id'],
                "created_dt"     =>  date('Y-m-d H:i:s')
            );
            $this->transaction_model->f_insert('td_chequedetail', $data_array);
            $this->session->set_flashdata('msg', 'Successfully Added');
            redirect('cheqdtl');
        }else{
            $error = validation_errors();
            $this->session->set_flashdata('msg', "'.$error.'");
            redirect('cheqdtl');
        }
        
    }

    function cheqdtledit()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $where      = array('id' => $this->input->post('id'));
            $data_array = array(
                "clear_dt"       =>  trim($this->input->post('clear_dt')),
                "remarks"        =>  $this->input->post('remarks'),
                "modified_by"     =>  $this->session->userdata('loggedin')['user_id'],
                "modified_dt"     =>  date('Y-m-d H:i:s')
            );
            $this->transaction_model->f_edit('td_chequedetail', $data_array,$where);
            $this->session->set_flashdata('msg', 'Successfully Updated');
           redirect('cheqdtl');
        }else{

            $id = $this->input->get('id');
            $br_cd = $this->session->userdata['loggedin']['branch_id'];
            $where = array(
                'district =' => $br_cd
            );
            $data['row']   =   $this->transaction_model->f_select_fertidb("mm_ferti_soc", NULL, $where, 0);
            $data['cheqdtl'] = $this->transaction_model->f_select("td_chequedetail",NULL,array('id' =>$id), 1);
            $this->load->view('post_login/finance_main');
            $this->load->view("transaction/cheqdtl_edit", $data);
            $this->load->view('post_login/footer');
        }
    }
    function cheqdtldelete()
    {
        $where = array("id"  =>  $this->input->get('id') );
        $this->session->set_flashdata('msg', 'Successfully Deleted!');
        $this->transaction_model->f_delete('td_chequedetail', $where);
        redirect("cheqdtl");
    }

    //  *********  End Code for cheque detail Screen     ****** //

    public function service_charge_list(){
      
        $data["listData"]=$this->transaction_model->f_select('td_service_charge',NULL,NULL,0);
            //  $data["listData"]=$this->Rent_calculation_model->fetch_rent_collection($where=null);
        $this->load->view("post_login/finance_main");
        $this->load->view("service/service_list", $data);
        $this->load->view("post_login/footer");
    }

    public function service_charge_invoice(){
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            
           
            $q=$this->db->order_by('trans_no','desc')->limit(1)->get('td_service_charge');
            $last_invoice_no =  $q->row();

            $customarName=$this->input->post('customer');
            $indoiceRemarks=$this->input->post('remarks');
            $gst         = $this->input->post('gst'); 

            if(empty($last_invoice_no)){
                $gettrans_no=0;
            }else{
                $gettrans_no=$last_invoice_no->trans_no;
            }
            $trans_no="SER-".$this->session->userdata['loggedin']['fin_yr']."-".($gettrans_no+1);
         
                $data=array(
                    "fin_yr"        =>  $this->session->userdata['loggedin']['fin_id'],
                    "trans_dt"      =>  $this->input->post('effectiveDate'),
                    "invoice_no"    =>  $trans_no,
                    "product_desc"       =>  $this->input->post('product_desc'),
                    "cust_name"       =>  $this->input->post('customer'),
                    "gst_no"       =>  $this->input->post('gst_no'),
                    "pan"       =>  $this->input->post('pan'),
                    "cust_addr"       =>  $this->input->post('cust_addr'),
                    "pin"       =>  $this->input->post('pin'),
                    "buyer_district"  =>  $this->input->post('district'),
                    "sac_code"       =>  $this->input->post('sac_code'),
                    "phone_num"       =>  $this->input->post('phone_num'),
                    "email"       =>  $this->input->post('email'),
                    "qty"           =>  1,
                    "taxable_amt"   =>  $this->input->post('amount'),
                    "cgst_rt"       =>  $gst/2,
                    "cgst_amt"      =>  $this->input->post('cgst'),
                    "sgst_rt"       =>  $gst/2,
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
               
                $this->transaction_model->f_insert('td_service_charge', $data);
                // exit();
                // $this->session->set_flashdata('msg', 'Successfully Added');

                return redirect('transaction/service_charge_list');
                // print_r($data);
            
        }else{
            

            $where=array(
                'BNK_flag' => 'B',
                'br_id' => $this->session->userdata("loggedin")["branch_id"],
            );
            $data=array(
               "customer"=>$this->transaction_model->f_select('md_rent_customer',NULL,NULL,0),
            );
            $this->load->view("post_login/finance_main");
            $this->load->view("service/service_add",$data);
            $this->load->view("post_login/footer");
        }
    }

    function service_delete()
    {
        $where = array(
            "trans_no"  =>  $this->input->get('id')
        );
        $this->session->set_flashdata('msg', 'Successfully Deleted!');
        $this->transaction_model->f_delete('td_service_charge', $where);
        redirect("transaction/service_charge_list");
    }

}