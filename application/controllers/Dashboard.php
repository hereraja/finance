<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();

		if(!isset($this->session->userdata['loggedin']['user_id'])){
            
            redirect('login');

        }
        // $this->load->model('login_model');
        // $this->load->library('session');
        // $this->load->helper('captcha');
        // $this->load->helper('url');
        // $this->load->helper('form');
        // $this->load->library('email');
    }

    function index()
    {
        $dash_data = array();
        $this->load->view('post_login/finance_main');
        $this->load->view('post_login/home', $dash_data);
        $this->load->view('post_login/footer');
    }
}
