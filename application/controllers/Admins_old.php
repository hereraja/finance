<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admins extends CI_Controller {

    protected $sysdate;

    public function __construct(){

        //$this->sysdate  = $_SESSION['sys_date'];

        parent::__construct();

        //For Individual Functions
        $this->load->model('Admin');

        //For User's Authentication
        if(!isset($this->session->userdata['loggedin']['user_id'])){
            
            redirect('Welcome/index');

        }
        
    }

    /*********************For User Screen********************/
    
    public function index() {
        
        //Retriving User Details
        if($this->session->userdata['loggedin']['ho_flag']=="N")  {   
			$where = array("branch_id"=>$this->session->userdata['loggedin']['branch_id']);
            $user['user_dtls']    =   $this->Admin->f_get_particulars("md_users", NULL,$where, 0);
			$this->load->view('post_login/finance_main');
			$this->load->view("user/dashboard", $user);
			$this->load->view('post_login/footer');	

        }else{

			$user['user_dtls']    =   $this->Admin->f_get_particulars("md_users", NULL,NULL, 0);
			$this->load->view('post_login/finance_main');
			$this->load->view("user/dashboardho", $user);
			$this->load->view('post_login/footer');		
         
        }
		
        
    }
	
	public function get_userlist(){
		$select = array('a.*','b.branch_name');
		$where  = array("a.branch_id = b.id" => NULL,
						"a.user_status ="=>$this->input->get('user_status'));
        $user   = $this->Admin->f_get_particulars("md_users a,md_branch b", NULL,$where, 0);
		echo json_encode($user);
	}

    //User Add
    public function user_add() {

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            
            $data_array = array(
                "user_id"       =>  $this->input->post('user_id'),
				"emp_code"      =>  $this->input->post('emp_code'),
				"designation"   =>  $this->input->post('designation'),
                "password"      =>  password_hash($this->input->post('pass'), PASSWORD_DEFAULT),
                "user_name"     =>  $this->input->post('user_name'),
                "branch_id"     =>  $this->session->userdata['loggedin']['branch_id'],
                "user_status"   =>  'I',
				"user_type"     =>  'NULL',
                "st"            =>  0,
                "created_by"    =>  $this->session->userdata['loggedin']['user_name'],
                "created_dt"    =>  date('Y-m-d H:i:s')
            );

            
            $this->Admin->f_insert('md_users', $data_array);
            $this->session->set_flashdata('msg', 'Successfully added!');
            redirect('user');

        }
        else {
            $this->load->view('post_login/finance_main');
            $this->load->view("user/add");
            $this->load->view('post_login/footer');
        }
        
    }

    //User edit
    public function user_edit() {

        if($_SERVER['REQUEST_METHOD'] == "POST") {
			
			$where  =   array(

                    "user_id"     =>  $this->input->post('user_id')
            );
			if($this->session->userdata['loggedin']['ho_flag']=="Y") {
				$data_array = array(
				
						"user_name "    =>  $this->input->post('name'),
				        "emp_code"      =>  $this->input->post('emp_code'),
				        "designation"   =>  $this->input->post('designation'),
						"user_status"    =>  $this->input->post('user_status'),
						"user_type"      =>  $this->input->post('user_type'),
						"modified_by"    =>  $this->session->userdata['loggedin']['user_name'],
						"modified_dt"    =>  date('Y-m-d H:i:s')
				);
				$this->Admin->f_edit('md_users', $data_array, $where);
			}else{
            //unset($data_array);

			$data_array = array(

				"user_name "    =>  $this->input->post('name'),
				
				"emp_code"      =>  $this->input->post('emp_code'),
				
				"designation"   =>  $this->input->post('designation'),

				"modified_by"   =>  $this->session->userdata['loggedin']['user_name'],

				"modified_dt"   =>  date('Y-m-d H:i:s')

			);

            $where  =   array(

                "user_id"     =>  $this->input->post('user_id')
            );

            $this->Admin->f_edit('md_users', $data_array, $where);
			}

            $this->session->set_flashdata('msg', 'Successfully edited!');

            redirect('user');


        }
        else {
            $user['user_dtls']    =   $this->Admin->f_get_particulars("md_users", NULL, array( "user_id" => $this->input->get('user_id')), 1);

            $this->load->view('post_login/finance_main');

            $this->load->view("user/edit", $user);

            $this->load->view('post_login/footer');

        }
        
    }

    //User delete
    public function f_user_delete() {

        $where = array(
            
            "user_id"    =>  $this->input->get('user_id')
            
        );

        //Retriving the data row for backup
        $select = array (

            "user_id", "password", "user_name", "user_type", "user_status"

        );

        $data   =   (array) $this->Admin->f_get_particulars("md_users", $select, $where, 1);


        $audit  =   array(
            
            'deleted_by'    => $this->session->userdata['loggedin']['user_name'],
            
            'deleted_dt'    => date('Y-m-d H:i:s')

        );

        //Inserting Data
        $this->Admin->f_insert('md_users_deleted', array_merge($data, $audit));

        $this->session->set_flashdata('msg', 'Successfully deleted!');

        $this->Admin->f_delete('md_users', $where);

        redirect("admin/user");

    }

}    