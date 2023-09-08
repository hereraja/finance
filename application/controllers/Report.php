<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Report_Model');
		$this->load->model('master_model');
		//$this->db2 = $this->load->database('seconddb', TRUE);
		if(!isset($this->session->userdata['loggedin']['user_id'])){
            redirect('login');
        }
    }
	
    public function ledgercodedtl()
    {
        // $voucher_id = $this->input->get('voucher_id');
        $adv['ledgcodedtls']    = $this->Report_Model->f_get_acccodedtls();
    
        $this->load->view('post_login/finance_main');
        $this->load->view('report/acccodedtls.php',$adv);
        $this->load->view('post_login/footer');
        
    }
	
	    public function cashjrnlprn()
{
	$voucher_id = $this->input->get('voucher_id');
	$adv['voucher']    = $this->Report_Model->f_get_cashjrnl_prt($voucher_id);
	// echo $this->db->last_query();
    // die();
	$adv['receipt_no'] = $voucher_id;
	

    $this->load->view('post_login/finance_main');
    $this->load->view('report/jrnl_prn/adv_jrnl.php',$adv);
    $this->load->view('post_login/footer');
	
}

public function bankjrnlprn()
{
	$voucher_id = $this->input->get('voucher_id');
	$adv['voucher']    = $this->Report_Model->f_get_cashjrnl_prt($voucher_id);
	// echo $this->db->last_query();
    // die();
	$adv['receipt_no'] = $voucher_id;
	

    $this->load->view('post_login/finance_main');
    $this->load->view('report/jrnl_prn/adv_jrnl.php',$adv);
    $this->load->view('post_login/footer');
	
}

public function jrnlprn()
{
    $this->load->helper('inflector');
    
	$voucher_id = $this->input->get('voucher_id');
	$adv['voucher']    = $this->Report_Model->f_get_cashjrnl_prt($voucher_id);
	// echo $this->db->last_query();
    // die();
	$adv['receipt_no'] = $voucher_id;

    $this->load->view('post_login/finance_main');
    $this->load->view('report/jrnl_prn/adv_jrnl.php',$adv);
    $this->load->view('post_login/footer');
	
}

    public function advjrnl(){
        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $frm_date     =   $_POST['from_date'];
            $to_date      =   $_POST['to_date'];
			$unit         =   $this->input->post('unit');
			$voucher_type =   '';
			if($this->session->userdata['loggedin']['branch_id']==342){ 
                $branch_id=$_POST['branch_id'];
            }else{
                $branch_id=$this->session->userdata['loggedin']['branch_id'];
            };
            
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $fin_yr= $this->session->userdata['loggedin']['fin_id'];

            $data['voucher']     = $this->Report_Model->f_get_voucher($frm_date,$to_date,$fin_yr,$branch_id,$unit);
            $data['advance']     = $this->Report_Model->f_get_advjnl($frm_date,$to_date,$fin_yr,$branch_id);
						   
			if($voucher_type == 'PUR'){
			    $data['voucher_type'] = 'Purchase';
			}elseif($voucher_type == 'A'){
				$data['voucher_type'] = 'Advance';
			}elseif($voucher_type == 'CRN'){
				$data['voucher_type'] = 'Credit note';
			}elseif($voucher_type == 'SL'){
				$data['voucher_type'] = 'Sale';
			}elseif($voucher_type == 'P'){
				$data['voucher_type'] = 'Payment';
			}elseif($voucher_type == 'R'){
				$data['voucher_type'] = 'Receive';
			}elseif($voucher_type == 'RNT'){
				$data['voucher_type'] = 'Rent';
			}elseif($voucher_type == 'OTH'){
				$data['voucher_type'] = 'Others';
			}else{
                $data['voucher_type'] = '';
            }
			$where = array('id' => $branch_id );
			$select = array('branch_name');
			$data['type']   = $this->input->post('voucher_type');
            if($unit == 0){ $unit_name = 'Consolidated';}elseif($unit == 3){$unit_name = 'Samabyika 1';}elseif($unit == 4){$unit_name = 'Samabyika 2';}elseif($unit == 1){$unit_name = 'Head Office';}
			$data['unit']   = $unit_name;
            $data['branch'] = $this->master_model->f_select("md_branch", $select, $where, 1);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/adv_jrnl/adv_jrnl.php',$data);
            $this->load->view('post_login/footer');

        }else{
			
			$data['branch'] = $this->master_model->f_select("md_branch", NULL, $where = null, 2);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/adv_jrnl/adv_jrnl_ip.php',$data);
            $this->load->view('post_login/footer');
        }

    }
	
	public function trailbal(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {


            $frm_date     =   $_POST['from_date'];
            $to_date      =   $_POST['to_date'];
			$unit         =   $this->input->post('unit');
			$mth        =  date('n',strtotime($frm_date));
            $yr         =  date('Y',strtotime($frm_date));
          
            if($mth > 3){

                $year = $yr;

            }else{

                $year = $yr - 1;
            }

            $opndt      =  date($year.'-04-01');

            $data['fd_date']=$frm_date;

            
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $fin_yr= $this->session->userdata['loggedin']['fin_id'];
            $brid=$this->session->userdata['loggedin']['branch_id'];
           // if($this->session->userdata['loggedin']['branch_id']!=342){

            $type=implode(',',$this->input->post('type'));

            $data['type']=$this->input->post('type');
                  if($unit == 0){ $unit_name = 'Consolidated';}elseif($unit == 3){$unit_name = 'Samabyika 1';}elseif($unit == 4){$unit_name = 'Samabyika 2';}
			$data['unit']   = $unit_name;
                 $data['trail_balnce']     = $this->Report_Model->f_get_trailbal_br($frm_date,$to_date,$opndt,$brid,$type,$unit);
                 $this->load->view('post_login/finance_main');
                 $this->load->view('report/trail_bal/trail_bal.php',$data);
                 $this->load->view('post_login/footer');
            // }else{

            // // $data['trail_balnce']     = $this->Report_Model->f_get_trailbal($frm_date,$to_date);
            //     $data['trail_balnce']     = $this->Report_Model->f_get_trailbal($frm_date,$to_date,$opndt);
            //     $this->load->view('post_login/finance_main');
            //     $this->load->view('report/trail_bal/trail_bal.php',$data);
            //     $this->load->view('post_login/footer');
            // }

        }else{
			
			$data['branch'] = $this->master_model->f_select("md_branch", NULL, $where = null, 2);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/trail_bal/trail_bal_ip.php',$data);
            $this->load->view('post_login/footer');
        }

    }

    public function consolidated_trailbal(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $frm_date     =   $_POST['from_date'];
            $to_date      =   $_POST['to_date'];
			  $mth        =  date('n',strtotime($frm_date));
            $yr         =  date('Y',strtotime($frm_date));

            
          
            if($mth > 3){

                $year = $yr;

            }else{

                $year = $yr - 1;
            }

            $opndt      =  date($year.'-04-01');

            
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));

            // $fin_yr= $this->session->userdata['loggedin']['fin_id'];
            // $brid=$this->session->userdata['loggedin']['branch_id'];
            // if($this->session->userdata['loggedin']['branch_id']!=342){
                 
                //  $data['trail_balnce']     = $this->Report_Model->f_get_trailbal_br($frm_date,$to_date,$opndt,$brid);

                //  $this->load->view('post_login/finance_main');
                //  $this->load->view('report/trail_bal/trail_bal.php',$data);
                //  $this->load->view('post_login/footer');

            // }
            // else{
                $type=implode(',',$this->input->post('type'));

                $data['type']=$this->input->post('type');
                $data['fd_date']=$frm_date;


            // $data['trail_balnce']     = $this->Report_Model->f_get_trailbal($frm_date,$to_date);
                $data['trail_balnce']     = $this->Report_Model->f_get_trailbal($frm_date,$to_date,$opndt,$type);
                // echo $this->db->last_query();
                // exit();
                $this->load->view('post_login/finance_main');
                $this->load->view('report/trail_bal/trail_bal.php',$data);
                $this->load->view('post_login/footer');
            // }

        }else{
			$sel=array('name','sl_no');
			$data['branch'] = $this->master_model->f_select("md_branch", NULL, $where = null, 2);
            $data['group'] = $this->master_model->f_select("mda_mngroup", $sel, $where = null, 0);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/trail_bal/consolidated_trail_bal_ip.php',$data);
            $this->load->view('post_login/footer');
        }

    }


    public function consolidated_trailbal_subgroup(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $frm_date     =   $_POST['from_date'];
            $to_date      =   $_POST['to_date'];
			  $mth        =  date('n',strtotime($frm_date));
            $yr         =  date('Y',strtotime($frm_date));

            $subgroupId = $this->input->post('subgroup');
          
            if($mth > 3){

                $year = $yr;

            }else{

                $year = $yr - 1;
            }

            $opndt      =  date($year.'-04-01');

            
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));

            
                $type=implode(',',$this->input->post('type'));

                $data['type']=$this->input->post('type');
                $data['fd_date']=$frm_date;
          
                $data['trail_balnce']     = $this->Report_Model->f_get_trailbal_subgroup($frm_date,$to_date,$opndt,$type,$subgroupId);
               // echo $this->db->last_query();die();
                $data['sbgrop']=$this->input->post('subgroupinputvalue');
                $this->load->view('post_login/finance_main');
                $this->load->view('report/trail_bal/consolidated_trail_bal_subgroup/trail_bal.php',$data);
                $this->load->view('post_login/footer');

        }else{
			$sel=array('name','sl_no');
			$data['branch'] = $this->master_model->f_select("md_branch", NULL, $where = null, 2);
            $data['group'] = $this->master_model->f_select("mda_mngroup", $sel, $where = null, 0);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/trail_bal/consolidated_trail_bal_subgroup/consolidated_trail_bal_ip.php',$data);
            $this->load->view('post_login/footer');
        }

    }

    public function consolidated_trailbal_group(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $frm_date     =   $_POST['from_date'];
            $to_date      =   $_POST['to_date'];
			$mth        =  date('n',strtotime($frm_date));
            $yr         =  date('Y',strtotime($frm_date));
            $subgroupId = $this->input->post('subgroup');
          
            if($mth > 3){
                $year = $yr;
            }else{
                $year = $yr - 1;
            }
            $opndt      =  date($year.'-04-01');
            
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            
                $type=implode(',',$this->input->post('type'));
                $data['type']=$this->input->post('type');
                $data['fd_date']=$frm_date;
                $group_id = $this->input->post('group_id');
                $data['trail_balnce']     = $this->Report_Model->f_get_trailbal_group($frm_date,$to_date,$opndt,$type,$group_id);
                //echo $this->db->last_query();die();
                $data['sbgrop']=$this->input->post('subgroupinputvalue');
                $this->load->view('post_login/finance_main');
                $this->load->view('report/trail_bal/consolidated_trail_bal_group/trail_bal.php',$data);
                $this->load->view('post_login/footer');

        }else{
			$sel=array('name','sl_no');
			$data['branch'] = $this->master_model->f_select("md_branch", NULL, $where = null, 2);
            $data['group'] = $this->master_model->f_select("mda_mngroup", $sel, $where = null, 0);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/trail_bal/consolidated_trail_bal_group/consolidated_trail_bal_ip.php',$data);
            $this->load->view('post_login/footer');
        }

    }

    public function get_subgroup(){
        // echo $this->input->get('group_id');
        $sel=array('mngr_id','name','benfed_subgr_id','sl_no');
        $where=array('mngr_id' => $this->input->get('group_id'));
        $data= $this->master_model->f_select("mda_subgroub", $sel, $where, 0);
        // print_r($data);
        $output='<option value="">Select Sub group</option>';
        foreach ($data as $key) {
            $output.='<option value="'.$key->sl_no.'">'.$key->name.'</option>';
        }
echo  $output;


    }
	
	public function trailbal_group(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $frm_date     =   $_POST['from_date'];
            $to_date      =   $_POST['to_date'];
            
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $fin_yr= $this->session->userdata['loggedin']['fin_id'];
			$data['trail_balnceg']    = $this->Report_Model->f_get_group_total($frm_date,$to_date);
			$data['trail_balnce']     = $this->Report_Model->f_get_trailbal($frm_date,$to_date);
			
            $this->load->view('post_login/finance_main');
            $this->load->view('report/trail_bal/trail_bal_group.php',$data);
            $this->load->view('post_login/footer');

        }else{
			
			$data['branch'] = $this->master_model->f_select("md_branch", NULL, $where = null, 2);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/trail_bal/trail_bal_ip_group.php',$data);
            $this->load->view('post_login/footer');
        }

    }
	
	/*public function trailbalsubgroup(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $frm_date     =   $_POST['from_date'];
            $to_date      =   $_POST['to_date'];
            
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $fin_yr= $this->session->userdata['loggedin']['fin_id'];
            $data['trail_balnce']     = $this->Report_Model->f_get_trailbalsubgroup($frm_date,$to_date);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/trail_bal/trail_bal_subgroup.php',$data);
            $this->load->view('post_login/footer');

        }else{
			
			$data['branch'] = $this->master_model->f_select("md_branch", NULL, $where = null, 2);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/trail_bal/trail_bal_subgroup.php',$data);
            $this->load->view('post_login/footer');
        }

    }*/

    public function crnjrnl(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {

			$frm_date    =   $_POST['from_date'];
            $to_date      =   $_POST['to_date'];
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $fin_yr= $this->session->userdata['loggedin']['fin_id'];
            $data['advance']     = $this->Report_Model->f_get_crjnl($frm_date,$to_date,$fin_yr);

            $this->load->view('post_login/finance_main');
            $this->load->view('report/crn_jrnl/crn_jrnl.php',$data);
            $this->load->view('post_login/footer');

        }else{

            $this->load->view('post_login/finance_main');
            $this->load->view('report/crn_jrnl/crn_jrnl_ip.php');
            $this->load->view('post_login/footer');
        }

    }
    public function salejrnl(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {
			
           
            $frm_date    =   $_POST['from_date'];
            $to_date      =   $_POST['to_date'];
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $fin_yr= $this->session->userdata['loggedin']['fin_id'];
            $data['advance']     = $this->Report_Model->f_get_sljnl($frm_date,$to_date,$fin_yr);

            $this->load->view('post_login/finance_main');
            $this->load->view('report/sale_jrnl/sale_jrnl.php',$data);
            $this->load->view('post_login/footer');

        }else{

            $this->load->view('post_login/finance_main');
            $this->load->view('report/sale_jrnl/sale_jrnl_ip.php');
            $this->load->view('post_login/footer');
        }
    }
	
    public function purjrnl(){

		if($_SERVER['REQUEST_METHOD'] == "POST") {

			$frm_date    =   $_POST['from_date'];
			$to_date      =   $_POST['to_date'];
			$_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
			$fin_yr= $this->session->userdata['loggedin']['fin_id'];

		    $data['advance']     = $this->Report_Model->f_get_purjnl($frm_date,$to_date,$fin_yr);

			$this->load->view('post_login/finance_main');
			$this->load->view('report/pur_jrnl/pur_jrnl.php',$data);
			$this->load->view('post_login/footer');

		}else{

			$this->load->view('post_login/finance_main');
			$this->load->view('report/pur_jrnl/pur_jrnl_ip.php');
			$this->load->view('post_login/footer');
		}

    }
	
	public function gl(){                           // **** Code for Gl report   20/12/2021

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $frm_date     =   $_POST['from_date'];
            $to_date      =   $_POST['to_date'];
			$opeto_dt  =   date('Y-m-d', strtotime('-1 day', strtotime($frm_date)));
			$acc_head     =   $this->input->post('acc_head');
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $fin_yr= $this->session->userdata['loggedin']['fin_id'];
			$data['opebalcal'] = $this->Report_Model->get_ope_gl($opeto_dt,$acc_head);
			
            $data['trail_balnce']     = $this->Report_Model->f_get_gl($frm_date,$to_date,$acc_head);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/gl/gl.php',$data);
            $this->load->view('post_login/footer');
            $this->load->view('post_login/footer');

        }else{
            $where=array(
                //'br_id'=> $this->session->userdata('loggedin')['branch_id'],
                'br_id in('.$this->session->userdata('loggedin')['branch_id'].',0)' => Null
                //'br_id in 0'=> null,
            );
		    $select = array('sl_no','ac_name');
			$data['acc_head'] = $this->master_model->f_select("md_achead", $select, $where, 2);
            
            $this->load->view('post_login/finance_main');
            $this->load->view('report/gl/gl_ip.php',$data);
            $this->load->view('post_login/footer');
        }

    }

public function voucher_dtls(){
              
            $branch_id=$this->session->userdata['loggedin']['branch_id'];
            $v_id   = $this->input->get('voucher_id');
            $voucher_type =   '';

            if($voucher_type == 'PUR'){
			    $data['voucher_type'] = 'Purchase';
			}elseif($voucher_type == 'A'){
				$data['voucher_type'] = 'Advance';
			}elseif($voucher_type == 'CRN'){
				$data['voucher_type'] = 'Credit note';
			}elseif($voucher_type == 'SL'){
				$data['voucher_type'] = 'Sale';
			}elseif($voucher_type == 'P'){
				$data['voucher_type'] = 'Payment';
			}elseif($voucher_type == 'R'){
				$data['voucher_type'] = 'Receive';
			}elseif($voucher_type == 'RNT'){
				$data['voucher_type'] = 'Rent';
			}elseif($voucher_type == 'OTH'){
				$data['voucher_type'] = 'Others';
			}else{
                $data['voucher_type'] = '';
            }
			$where = array('id' => $branch_id );
			$select = array('branch_name');
			$data['type']   = $this->input->post('voucher_type');
            $data['branch'] = $this->master_model->f_select("md_branch", $select, $where, 1);
            //    echo $this->db->last_query();
            //    exit;
                $data['voucher']     = $this->Report_Model->f_get_voucher_dtls($v_id);
                $data['advance']     = $this->Report_Model->f_get_advjnl_dtls($v_id);
                               
                $this->load->view('post_login/finance_main');
                $this->load->view('report/voucher_dtls/voucher_dtls.php',$data);
                $this->load->view('post_login/footer');
    
        }


	public function ac_detail(){                           // **** Code for Account Detail report   07/04/2022

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $branch_id  = $this->session->userdata['loggedin']['branch_id'];	
            $frm_date     =   $_POST['from_date'];
            $to_date      =   $_POST['to_date'];
			$opeto_dt  =   date('Y-m-d', strtotime('-1 day', strtotime($frm_date)));
			$acc_head     =   $this->input->post('acc_head');
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $fin_yr= $this->session->userdata['loggedin']['fin_id'];
			$fin_year_sort_code=substr($this->session->userdata['loggedin']['fin_yr'],0,4);
			$op_dt=$fin_year_sort_code.'-04'.'-01';
			//echo $op_dt;
			
			// $data['opebalcal'] = $this->Report_Model->get_ope_gl($opeto_dt,$acc_head);
            if( date('d-m',strtotime($frm_date))=='01-04'){
                $data['opebalcal'] = $this->Report_Model->get_ope_gl_re($op_dt,$acc_head);
			
			
            }else{
                $data['opebalcal'] = $this->Report_Model->get_ope_gl($op_dt,$frm_date,$acc_head);
			//	echo $this->db->last_query();
		
            }
            $data['accdetail'] = $this->Report_Model->f_select('md_achead',array('ac_name','benfed_ac_code'),array('sl_no' => $acc_head ),1);
        //    echo $this->input->post('allaccounthead');
            if($this->session->userdata('loggedin')['branch_id']==342){
                if($this->input->post('branch_id') == 0 ){
                    $data['trail_balnce']     = $this->Report_Model->f_get_acdeatil_all($frm_date,$to_date,$acc_head);

                }else{
                    $branch_id = $this->input->post('branch_id');
                    $data['trail_balnce']     = $this->Report_Model->f_get_acdeatil($frm_date,$to_date,$acc_head,$branch_id);
                }
            }else{
                $data['trail_balnce']     = $this->Report_Model->f_get_acdeatil($frm_date,$to_date,$acc_head,$branch_id);
            }
          
            $this->load->view('post_login/finance_main');
            $this->load->view('report/ac_detail/ac_detail.php',$data);
            $this->load->view('post_login/footer');
           // $this->load->view('post_login/footer');

        }else{
            // $where=array(,"ORDER BY ac_name"  => NULL);
            $branch_id  = $this->session->userdata['loggedin']['branch_id'];	
            $data['acc_head'] = $this->Report_Model->f_get_acheaddeatil();
            // $fin_yr= $this->session->userdata['loggedin']['fin_id'];
			// $fin_year_sort_code=substr($this->session->userdata['loggedin']['fin_yr'],0,4);
			// $data['acc_head'] = $this->master_model->f_select("md_achead ORDER BY 'ac_name'" , $select, $where = null, 2);
            $data['branch'] = $this->master_model->f_select("md_branch", NULL, array('1 order by branch_name asc'=> NULL), 0);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/ac_detail/ac_detail_ip.php',$data);
            $this->load->view('post_login/footer');
        }

    }
	public function f_get_soc(){

		$select   = array("soc_id","soc_add","gstin");
			
		$where   =array(
					"soc_id" =>$this->input->get("soc_id")
					) ;
		
		$soc    = $this->Report_Model->f_selects('mm_ferti_soc',$select,$where,0);
		echo json_encode($soc);
	}
	
	public function js_get_stock_point(){

		$ro = $this->input->get('ro');
		$result = $this->Report_Model->js_get_stock_point($ro);	
 		echo json_encode($result);

	}
	
	public function trans_detail(){                           // **** Code for Ro Detail   20/12/2021 
			
		$branch_id  = $this->session->userdata['loggedin']['branch_id'];
		$trans_no   = base64_decode($this->input->get('trans_no'));
		$trans_dt   = $this->input->get('trans_dt');
		$type       = base64_decode($this->input->get('type'));
		// $type       = $this->input->get('type');
		
		if($type == 'PUR'){
			
			$select = array(
				"a.*","b.*","c.*","d.*"
			);
			$where	=	array(
				"a.comp_id = b.COMP_ID" => Null,
				"a.prod_id = c.PROD_ID" => Null,
				"ro_no" => $trans_no,
				"a.unit = d.id"=>NULL			
			);	

			$product['stock'] = $this->Report_Model->f_selects("td_purchase a,mm_company_dtls b,mm_product c,mm_unit d",Null,$where,1);
			$stk_pt = array("soc_id","soc_name");
				
			$where_stk = array(
					 "stock_point_flag"	=>'Y'
					
			);

			$product['stockpoint'] = $this->Report_Model->f_selects("mm_ferti_soc",$stk_pt,$where_stk,0);
			$product['company'] = $this->Report_Model->f_selects("mm_company_dtls",NULL,NULL,0);
			$product['product'] = $this->Report_Model->f_selects("mm_product",NULL,NULL,0);	
			$product['unit'] = $this->Report_Model->f_selects("mm_unit",Null,Null,0);
			$select_sale = array(
				"count(sale_ro)as sale_cnt"
			);	
			$where_sale = array(
				"sale_ro"	=> $trans_no,
				"br_cd"     => $branch_id
			);
			$product['sale']= $this->Report_Model->f_selects("td_sale",$select_sale,$where_sale,0);
			$this->load->view('post_login/finance_main');
			$this->load->view("trans_detail_fertilizer/purchase",$product);
			$this->load->view("post_login/footer");
		
		}elseif($type == 'SL'){
			
			$select5                = array("sl_no","cate_desc");
			$product['catg']        = $this->Report_Model->f_selects('mm_category',$select5,NULL,0);
			
			$select4                = array("id","unit_name");
			$product['unit']        = $this->Report_Model->f_selects('mm_unit',$select4,NULL,0);
			
			$select3               = array("comp_id","comp_name");
			$product['compdtls']   = $this->Report_Model->f_selects('mm_company_dtls',$select3,NULL,0);
			
			$select2                = array("ro_no","qty");

			$product['rodtls']      = $this->Report_Model->f_selects('td_purchase',$select2,NULL,0);

			$select1                = array("soc_id","soc_name","soc_add","gstin");
			$product['socdtls']     = $this->Report_Model->f_selects('mm_ferti_soc',$select1,NULL,0);

			$select                = array("prod_id","prod_desc","gst_rt");
			$product['proddtls']   = $this->Report_Model->f_selects('mm_product',$select,NULL,0);	
			$product['prod_dtls']  = $this->Report_Model->f_selects("td_sale", NULL, array("trans_do" => $trans_no),0);

			$this->load->view('post_login/finance_main');
			$this->load->view("trans_detail_fertilizer/sale",$product);
			$this->load->view('post_login/footer');
		
		}elseif($type == 'A'){
			
			$select = array("trans_dt","receipt_no","soc_id","trans_type","cshbnk_flag","adv_amt","bank","remarks");
			$where = array(

				"receipt_no" => $trans_no
				
                );
			$select2          		= array("sl_no","bank_name");
			    
            $select1          		= array("soc_id","soc_name");
			$data['advDtls']        = $this->Report_Model->f_get_adv_dtls($trans_no);

			$data['societyDtls']    = $this->Report_Model->f_selects("mm_ferti_soc",$select1,NULL,0);
			
			$data['bnk_dtls']    = $this->Report_Model->f_selects("mm_feri_bank",$select2,NULL,0); 
			
            $this->load->view('post_login/finance_main');
            $this->load->view("trans_detail_fertilizer/advance",$data);
            $this->load->view("post_login/footer");
			
		}elseif($type == 'CRN'){
			
            $where3 = array(

              	"trans_dt" => $this->input->get('trans_dt'),
                    
                "trans_no" => $trans_no
            );

			$select        = array("soc_id soc_id","soc_name soc_name");

			$select1       = array("COMP_ID comp_id","COMP_NAME comp_name");

			$select3       =array("a.trans_dt",
									"a.trans_no",
									"a.soc_id",
									"a.comp_id",
									"a.invoice_no",
									"a.ro",
									"a.catg",
									"a.tot_amt",
									"a.trans_flag",
									"a.note_type",
									 "a.remarks",
									"b.cat_desc");
			$where =array("a.catg=b.sl_no"=>NULL,
							"trans_dt" => $trans_dt,
							"recpt_no" => $trans_no);
			 
			$product['socdtls']    = $this->Report_Model->f_selects('mm_ferti_soc',$select,NULL,0);
			
			$product['compdtls']   = $this->Report_Model->f_selects('mm_company_dtls',$select1,NULL,0);

			$product['dr_dtls']    = $this->Report_Model->f_selects('tdf_dr_cr_note a,mm_cr_note_category b ',$select3,$where,1);
		
	        $this->load->view('post_login/finance_main');
	        $this->load->view("trans_detail_fertilizer/dr_credit",$product);
	        $this->load->view('post_login/footer');
			
		}elseif($type=='RECV'){
            

        }

    }
	/*****Day Book Report Blocked On 07/10/2022*** */
	/*public function daybook(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $frm_date     =   $_POST['from_date'];
            $to_date      =   $_POST['to_date'];
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $fin_yr= $this->session->userdata['loggedin']['fin_id'];

            $data['daybook']     = $this->Report_Model->f_get_daybook($frm_date,$to_date);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/daybook/daybook.php',$data);
            $this->load->view('post_login/footer');

        }else{
			
            $this->load->view('post_login/finance_main');
            $this->load->view('report/daybook/daybook_ip.php');
            $this->load->view('post_login/footer');
        }
    }*/
	
    //Cash Book report  
	public function cashbook(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $frm_date     =   $_POST['from_date'];
            $to_date      =   $_POST['to_date'];
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $fin_yr= $this->session->userdata['loggedin']['fin_id'];

            
			$mth        =  date('n',strtotime($frm_date));
            $yr         =  date('Y',strtotime($frm_date));
          
            if($mth > 3){

                $year = $yr;

            }else{

                $year = $yr - 1;
            }

            $opndt      =  date($year.'-04-01');

            $data['cashbookop']     = $this->Report_Model->f_get_cashbook_opbal($opndt,$frm_date );
            
            
            $data['cashbook']     = $this->Report_Model->f_get_cashbook($frm_date,$to_date);
        
// echo $this->db->last_query();
//             exit();
            $this->load->view('post_login/finance_main');
            $this->load->view('report/cashbook/cashbook.php',$data);
            $this->load->view('post_login/footer');

        }else{
			
            $this->load->view('post_login/finance_main');
            $this->load->view('report/cashbook/cashbook_ip.php');
            $this->load->view('post_login/footer');
        }
    }

/***Bank Book Report blocked on 07/10/2022 */
	public function bankbook(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $acc_head=$this->input->post('bank');

            $frm_date     =   $_POST['from_date'];
            $to_date      =   $_POST['to_date'];


            $branch_id  = $this->session->userdata['loggedin']['branch_id'];	
           
			
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
           
			$fin_year_sort_code=substr($this->session->userdata['loggedin']['fin_yr'],0,4);
			$op_dt=$fin_year_sort_code.'-04'.'-01';
			
            if( date('d-m',strtotime($frm_date))=='01-04'){
                $data['opebalcal'] = $this->Report_Model->get_ope_gl_re($op_dt,$acc_head);
			
            }else{
                $data['opebalcal'] = $this->Report_Model->get_ope_gl($op_dt,$frm_date,$acc_head);
			
            }
            $data['accdetail'] = $this->Report_Model->f_select('md_achead',array('ac_name','benfed_ac_code'),array('sl_no' => $acc_head ),1);
        
          if($this->input->post('allaccounthead')=='false'){
            $data['trail_balnce']     = $this->Report_Model->f_get_acdeatil_all($frm_date,$to_date,$acc_head);
           

          }else{
            $data['trail_balnce']     = $this->Report_Model->f_get_acdeatil($frm_date,$to_date,$acc_head,$branch_id);
          }

          
        //     $this->load->view('post_login/finance_main');
        //     $this->load->view('report/ac_detail/ac_detail.php',$data);
        //     $this->load->view('post_login/footer');
        //    // $this->load->view('post_login/footer');



            $this->load->view('post_login/finance_main');
            $this->load->view('report/bankbook/bankbook.php',$data);
            $this->load->view('post_login/footer');

        }else{
			$data = array(
                "banklist"=>$this->Report_Model->branch_bnk($this->session->userdata['loggedin']['branch_id']),
            );
            
            $this->load->view('post_login/finance_main');
            $this->load->view('report/bankbook/bankbook_ip.php',$data);
            $this->load->view('post_login/footer');
        }
    }

    // ******* Code Created for Balance Sheet by lokesh on 22/05/2023      *****   //     
    public function balsh(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $frm_date   =   $_POST['from_date'];
            $to_date    =   $_POST['to_date'];
			$mth        =  date('n',strtotime($frm_date));
            $yr         =  date('Y',strtotime($frm_date));
          
            if($mth > 3){
                $year = $yr;
            }else{
                $year = $yr - 1;
            }

            $opndt      =  date($year.'-04-01');
            $data['fd_date']=$frm_date;
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $fin_yr= $this->session->userdata['loggedin']['fin_id'];
            $brid=$this->session->userdata['loggedin']['branch_id'];
            $data['mngrl']           = $this->Report_Model->f_get_balsh_mngr_lib($frm_date,$to_date,$opndt,$brid);
			
            $data['mngra']           = $this->Report_Model->f_get_balsh_mngr_asst($frm_date,$to_date,$opndt,$brid);
            //echo $this->db->last_query();die();
            $data['lib_bal']   = $this->Report_Model->f_get_balsh_br_lib($frm_date,$to_date,$opndt,$brid);
			$data['assets_bal']   = $this->Report_Model->f_get_balsh_br_asst($frm_date,$to_date,$opndt,$brid);
			
            //echo $this->db->last_query();die();
            //echo $this->db->last_query(); die();
            $this->load->view('post_login/finance_main');
            $this->load->view('report/balsh/balsh.php',$data);
            $this->load->view('post_login/footer');

        }else{
			
			$data['branch'] = $this->master_model->f_select("md_branch", NULL, $where = null, 2);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/balsh/balsh_ip.php',$data);
            $this->load->view('post_login/footer');
        }

    }
	
	// ******* Code Created for profit & Loss by lokesh on 23/05/2023      *****   //
    public function pl(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $frm_date   =   $_POST['from_date'];
            $to_date    =   $_POST['to_date'];
			$mth        =  date('n',strtotime($frm_date));
            $yr         =  date('Y',strtotime($frm_date));
          
            if($mth > 3){
                $year = $yr;
            }else{
                $year = $yr - 1;
            }
            $opndt      =  date($year.'-04-01');
            $data['fd_date']=$frm_date;
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $fin_yr= $this->session->userdata['loggedin']['fin_id'];
            $brid=$this->session->userdata['loggedin']['branch_id'];
			$data['mngre']      = $this->Report_Model->f_get_balpl_main_group($frm_date,$to_date,$opndt,$brid,3);
            $data['mngrr']      = $this->Report_Model->f_get_balpl_main_group($frm_date,$to_date,$opndt,$brid,4);
            $data['trail_balnce']     = $this->Report_Model->f_get_pl_br($frm_date,$to_date,$opndt,$brid);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/pl/pl.php',$data);
            $this->load->view('post_login/footer');

        }else{
			
			$data['branch'] = $this->master_model->f_select("md_branch", NULL, $where = null, 2);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/pl/pl_ip.php',$data);
            $this->load->view('post_login/footer');
        }

    }
	public function scroll_book(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $frm_date   =   $this->input->post('from_date');
            $to_date    =   $this->input->post('to_date');
			$mth        =  date('n',strtotime($frm_date));
            $yr         =  date('Y',strtotime($frm_date));
          
            if($mth > 3){
                $year = $yr;
            }else{
                $year = $yr - 1;
            }
            $opndt      =  date($year.'-04-01');
			$unit_id    =1 ;
            $data['fd_date']=$frm_date;
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $fin_yr= $this->session->userdata['loggedin']['fin_id'];
            $brid=$this->session->userdata['loggedin']['branch_id'];
			 $data['op_bal']     = $this->Report_Model->f_get_op_bal($opndt,$frm_date,$unit_id);
			//echo $this->db->last_query();
			//die();
            $data['scroll_book']     = $this->Report_Model->f_get_scroll_book($frm_date,$to_date);
			
            $this->load->view('post_login/finance_main');
            $this->load->view('report/scroll_book/scroll_book.php',$data);
            $this->load->view('post_login/footer');

        }else{
			
			$data['branch'] = $this->master_model->f_select("md_branch", NULL, $where = null, 2);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/scroll_book/scroll_ip.php',$data);
            $this->load->view('post_login/footer');
        }

    }


}
