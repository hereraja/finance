<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profiles extends CI_Controller {

    public function __construct(){

        parent::__construct();

        $this->load->model('Profile');
        if(!isset($this->session->userdata['loggedin']['user_id'])){
            
            redirect('Welcome/index');

        }
        
    }

    public function index(){
        $this->load->view('post_login/finance_main');
        $this->load->view('profile/dashboard');

        $this->load->view('post_login/footer');

    }

    public function changepass(){
        
        
        
       $oldPass = $this->input->post('old_pass');
     
        $newPass = $this->input->post('new_pass');
        
        $matchPass = $this->Profile->matchPass($oldPass);
        
		$temp = password_verify($oldPass,$matchPass->password);
        
		if ($temp) {

			$password = password_hash($newPass, PASSWORD_DEFAULT);
            $msgPass = $this->Profile->editPassProcess($password);
            //Setting Messages
            $message    =   array( 
                    
                'message'   => 'Password changed!',
                
                'status'    => 'success'
                
            );

        }
        else{

            $message    =   array( 
                    
                'message'   => 'Old password was wrong',
                
                'status'    => 'danger'
                
            );

        }

        $this->session->set_flashdata('msg', $message);

        redirect('profiles');
    }

}

?>