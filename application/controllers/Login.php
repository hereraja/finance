<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();

		$this->load->model('login_model');
		$this->load->library('session');
		// $this->load->helper('captcha');
		// $this->load->helper('url');
		// $this->load->helper('form');
		// $this->load->library('email');
	}

	function index()
	{
		$data = array(
			'branch_data' => $this->login_model->get_branch(),
			'fin_yr' => $this->login_model->get_fin_year()
		);
		$this->load->view('login/login', $data);
	}

	function check_user()
	{
		header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
		$user_id = $this->input->get('user_id');
		$res = $this->login_model->check_user_by_id($user_id);

		if ($res) {
			$user_type = $res->user_type;
			echo $user_type;
		} else {
			echo '';
		}
	}

	function login_check()
	{
		$data = $this->input->post();
		
		if ($res = $this->login_model->login_check($data)) {
			
			if($res->user_type == 'O' && $this->input->post('branch_id') == 342){
				$this->session->set_flashdata('login_error', 'You Can not login in Headoffice');
			    redirect('login');
			}else if($res->user_type == 'O' && $this->input->post('branch_id') == ''){
				$this->session->set_flashdata('login_error', 'Please Selcet Branch');
			    redirect('login');
			}else{
				
				if($res->user_type == 'A' ||  $res->user_type == 'O'){
				$branchname = $this->login_model->get_branchname($this->input->post('branch_id'));
				$branch_id = $this->input->post('branch_id');
				}else{
				$branchname = $this->login_model->get_branchname($res->branch_id);	
				$branch_id = $res->branch_id;
				}
				$fin_year = $this->login_model->fin_year_by_id($data['fin_yr']);
			//	if($this->input->post('branch_id') == 337){
			//		$ho_flag = 'Y';
			//	}else{
			//		$ho_flag = 'N';
			///	}
				if($res->st == 1){
					$ho_flag = 'Y';
					 
				}else{
					$ho_flag = 'N';
				}
				$loggedin = array(
					'user_id' => $res->user_id,
					'user_type' => $res->user_type,
					'user_name' => $res->user_name,
					'user_status' => $res->user_status,
					'branch_id' => $branch_id,
					'branch_name' => $branchname,
					'ho_flag' => $ho_flag,
					'unit_id'  => $res->st,
					//'contact_no' => $res->contact_no,
					'fin_id' => $fin_year->sl_no,
					'fin_yr' => $fin_year->fin_yr
				);
				$this->session->set_userdata('loggedin', $loggedin);
				$audit_trail_id = $this->login_model->f_insert_audit_trail($data['user_id']);
				$this->session->set_userdata('audit_trail_id',$audit_trail_id);

				redirect('dashboard');
			}
		} else {
			$this->session->set_flashdata('login_error', 'Please Check Your UserId Or Password');
			redirect('login');
		}
		// var_dump($res);
	}
	
	function login_by_api()
	{
		//$data = $this->input->post();
		$data['user_id'] = $this->input->get('user_id');
		$data['user_pwd'] = $this->input->get('user_pwd');
		//if ($res = $this->login_model->login_check_by_api($data)) {
		//	$data['fin_yr'] = 1;
		//	if($res->user_type == 'O' && $this->input->post('branch_id') == 342){
			//	$this->session->set_flashdata('login_error', 'You Can not login in Headoffice');
			//    redirect('login');
		//	}else if($res->user_type == 'O' && $this->input->post('branch_id') == ''){
			//	$this->session->set_flashdata('login_error', 'Please Selcet Branch');
			//    redirect('login');
			//}else{
			//	$branchname = $this->login_model->get_branchname($res->branch_id);	
			//	$branch_id = $res->branch_id;
		
			//	$fin_year = $this->login_model->fin_year_by_id($data['fin_yr']);
			//	if($this->input->post('branch_id') == 342){
			//		$ho_flag = 'Y';
			//	}else{
		//			$ho_flag = 'N';
			//	}
		//		$loggedin = array(
		//			'user_id' => $res->user_id,
		//			'user_type' => $res->user_type,
		//			'user_name' => $res->user_name,
		//			'user_status' => $res->user_status,
		//			'branch_id' => $branch_id,
		//			'branch_name' => $branchname,
			//		'ho_flag' => $ho_flag,
		//			'fin_id' => $fin_year->sl_no,
		//			'fin_yr' => $fin_year->fin_yr
		//		);
		//		$this->session->set_userdata('loggedin', $loggedin);
		//		$audit_trail_id = $this->login_model->f_insert_audit_trail($data['user_id']);
		//		$this->session->set_userdata('audit_trail_id',$audit_trail_id);
		//		redirect('dashboard');
		//	}
		//} else {
			$this->session->set_flashdata('login_error', 'Please Check Your UserId Or Password');
			redirect('login');
		//}
		
	}
	
	public function logout(){

			if($this->session->userdata('loggedin')){
				$audit_trail_id  =  $this->session->userdata('audit_trail_id');
				$this->login_model->f_update_audit_trail($audit_trail_id);
				$this->session->unset_userdata('loggedin');
				redirect(base_url());

			}else{
				redirect(base_url());

			}
		}
}
