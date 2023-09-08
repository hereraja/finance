<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();

        $this->load->model('master_model');
		if(!isset($this->session->userdata['loggedin']['user_id'])){
            
            redirect('login');

        }
    }
    // GROUP VIEW //
    function group()
    {
        $data = array(
            'group_dtls' => $this->master_model->f_select("mda_mngroup", $select = null, $where = null, 2),
            'group_type' => unserialize(GROUP_TYPE)
        );
        $this->load->view('post_login/finance_main');
        $this->load->view("master/group_view", $data);
        $this->load->view('post_login/footer');
    }

    // GROUP ADD //
    public function group_add()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $data_array = array(
                "name"       => $this->input->post('gr_name'),
                "benfed_srl"       => $this->input->post('benfed_srl'),
                "type"       =>  $this->input->post('ac_type'),
                "created_by"    =>  $this->session->userdata['loggedin']['user_name'],
                "created_dt"    =>  date('Y-m-d H:i:s')
            );

            $this->master_model->f_insert('mda_mngroup', $data_array);

            $this->session->set_flashdata('msg', 'Successfully Added');

            redirect('group');
        } else {

            $this->load->view('post_login/finance_main');

            $this->load->view("master/add");

            $this->load->view('post_login/footer');
        }
    }

    // GROUP EDIT //
    public function group_edit()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $data_array = array(

                "name"               =>  $this->input->post('gr_name'),
                "benfed_srl"         =>  $this->input->post('benfed_srl'),
                "type"               =>  $this->input->post('ac_type'),
                "modified_by"        =>  $this->session->userdata['loggedin']['user_name'],
                "modified_dt"        =>  date('Y-m-d H:i:s')
            );

            $where = array(
                "sl_no" => $this->input->post('sl_no')
            );


            $this->master_model->f_edit('mda_mngroup', $data_array, $where);

            $this->session->set_flashdata('msg', 'Successfully Updated');

            redirect('group');
        } else {
            $select = array(
                "sl_no","benfed_srl","name","type"
            );

            $where = array(

                "sl_no" => $this->input->get('id')

            );

            $sch['schdtls'] = $this->master_model->f_select("mda_mngroup", $select, $where, 1);

            $this->load->view('post_login/finance_main');

            $this->load->view("master/edit", $sch);

            $this->load->view("post_login/footer");
        }
    }

    // SUBHAM SAMANTA 06.09.2021 //
    // SUB-GROUP VIEW //
    function sub_group()
    {
        $data =  array(
            'sub_group_dtls' => json_encode($this->master_model->get_sub_group_dtls($id = 0))
        );
        $this->load->view('post_login/finance_main');

        $this->load->view("master/sub_group_view", $data);

        $this->load->view("post_login/footer");
    }

    // SUB-GROUP ADD AND EDIT //
    function sub_group_add()
    {
        $id = $this->input->get('id');
        $selected = array(
            'id' => '',
            'gr_id' => '',
            'benfed_subgr_id' => '',
            'sub_gr' => ''
        );
        // IF ID > 0 IT WILL BE EDIT //
        if ($id > 0) {
            $sub_gr_list = $this->master_model->get_sub_group_dtls($id);
            foreach ($sub_gr_list as $dt) {
                $selected = array(
                    'id' => $dt->sl_no,
                    'gr_id' => $dt->mngr_id,
                    'benfed_subgr_id' => $dt->benfed_subgr_id,
                    'sub_gr' => $dt->name
                );
            }
        }
        $gr_dtls = $this->master_model->f_select("mda_mngroup", $select = null, $where = null, 2);

        $data = array(
            'gr_dtls' => json_encode($gr_dtls),
            'selected' => $selected
        );

        $this->load->view('post_login/finance_main');

        $this->load->view("master/sub_group_entry", $data);

        $this->load->view("post_login/footer");
    }

    // SUB-GROUP INSERT AND UPDATE //
    function sub_group_save()
    {
        $data = $this->input->post();
        // var_dump($data);
        if ($this->master_model->sub_gr_save($data)) {
            $this->session->set_flashdata('msg', 'Successfully Updated');
            redirect('subgroup');
        } else {
            $this->session->set_flashdata('msg', 'Data Not Updated !!');
            redirect('subgroup/entry');
        }
    }

    // AC-HEAD VIEW //
    // function ac_head()
    // {
    //     $data =  array(
    //         'ac_head' => json_encode($this->master_model->get_ac_head_dtls($id = 0))
    //     );
    //     $this->load->view('post_login/finance_main');

    //     $this->load->view("master/ac_head_view", $data);

    //     $this->load->view("post_login/footer");
    // }



    function ac_head()
    {
       
        $this->load->view('post_login/finance_main');

        $this->load->view("master/ac_head_view");

        $this->load->view("post_login/footer");
    }







    

    // AC-HEAD ADD AND EDIT //
    function ac_head_add()
    {
        $id = $this->input->get('id');
        $selected = array(
            'id' => '',
            'gr_id' => '',
            'subgr_id' => '',
            'benfed_ac_code' => '',
            'br_id' => '',
            'achead' => ''
        );
        $subgr_dtls = array();
        if ($id > 0) {
            $ac_where = array('sl_no' => $id);
            $ac_dtls = $this->master_model->f_select("md_achead", $select = null, $ac_where, 1);
           
            $selected = array(
                'id' => $ac_dtls->sl_no,
                'gr_id' => $ac_dtls->mngr_id,
                'subgr_id' => $ac_dtls->subgr_id,
                'br_id' => $ac_dtls->br_id,
                'achead' => $ac_dtls->ac_name,
                'benfed_ac_code' => $ac_dtls->benfed_ac_code
            );
            $subgr_where = array('mngr_id' => $selected['gr_id']);
            $subgr_dtls = $this->master_model->f_select("mda_subgroub", $select = null, $subgr_where, 2);
        }

        $gr_dtls = $this->master_model->f_select("mda_mngroup", $select = null, $where = null, 2);
       // $where_br = array('id' =>$ac_dtls->br_id);
        $select = array("id", "branch_name");
        $br_dtls = $this->master_model->f_select("md_branch", $select, NULL, 0);
        // echo $this->db->last_query();
        // exit;
        $data = array(
            'gr_dtls' => json_encode($gr_dtls),
            'br_dtls' => json_encode($br_dtls),
            'subgr_dtls' => json_encode($subgr_dtls),
            'selected' => $selected
        );

        $this->load->view('post_login/finance_main');
        $this->load->view("master/ac_head_entry", $data);
        $this->load->view("post_login/footer");
    }

    // AC-HEAD INSERT AND UPDATE //
    function ac_head_save()
    {
        $data = $this->input->post();
        $id = $data['id'];
        // IF ID > 0 THEN IT WILL BE UPDATE ELSE INSERT //
        if ($id > 0) {
            $input = array(
                'mngr_id' => $data['gr_id'],
                'subgr_id' => $data['subgr_id'],
                'ac_name' => $data['achead'],
                'benfed_ac_code' => $data['benfed_ac_code'],
                'br_id' => $data['br_id'],
                'modified_by'    =>  $this->session->userdata['loggedin']['user_name'],
                'modified_dt'    =>  date('Y-m-d H:i:s')
            );
            $where = array('sl_no' => $id);
            $this->master_model->f_edit('md_achead', $input, $where);
        } else {
            $input = array(
                'mngr_id' => $data['gr_id'],
                'subgr_id' => $data['subgr_id'],
                'ac_name' => $data['achead'],
                'benfed_ac_code' => $data['benfed_ac_code'],
                'br_id' => $data['br_id'],
                'created_by'    =>  $this->session->userdata['loggedin']['user_name'],
                'created_dt'    =>  date('Y-m-d H:i:s')
            );
            $this->master_model->f_insert('md_achead', $input);
        }


        $this->session->set_flashdata('msg', 'Successfully Added');

        redirect('achead');
    }

    // AJAX GET SUB-GROUP BY GROUP ID //
    function get_subgr_dtls()
    {
        $gr_id = $this->input->get('gr_id');
        $data = $this->master_model->get_subgr_dtls_by_gr_id($gr_id);
        echo json_encode($data);
    }








    public function fetch_my_achead(){
        $data=$this->uri->segment('3');
		if(isset($data)){
		$serch=$this->input->post('serch');
		$toDate=$this->input->post('toDate');
		$fDAte=$this->input->post('fDAte');
		$stock=$this->input->post('stock');
		$this->load->library("pagination");
		$config = array();


        
		$config["base_url"] = "my-strock-fetch";
		$config["total_rows"] = $this->master_model->count_all_achead($serch);
		$config["per_page"] = 40;
		$config["uri_segment"] = 3;
		$config["use_page_numbers"] = TRUE;




        $config["full_tag_open"] = '<ul class="pagination justify-content-end mt-3">';
		$config["full_tag_close"] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">'; 
        $config['num_tag_close'] = '</li>'; 
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">'; 
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>'; 
        $config['next_link'] = 'Next'; 
        $config['prev_link'] = 'Previous'; 
        $config['next_tag_open'] = '<li class="page-item">'; 
        $config['next_tag_close'] = '</li>'; 
        $config['prev_tag_open'] = '<li class="page-item">'; 
        $config['prev_tag_close'] = '</li>'; 
        $config['first_tag_open'] = '<li class="page-item">'; 
        $config['first_tag_close'] = '</li>'; 
        $config['last_tag_open'] = '<li class="page-item">'; 
        $config['last_tag_close'] = '</li>';



		$config["num_links"] = 3;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
		$config['first_url'] = base_url() . 'Master/fetch_my_achead/';
		$this->pagination->initialize($config);
		$page = $this->uri->segment('3');
		$start = ($page - 1) * $config["per_page"];
		
		$output = array(
			'pagination_link'		=>	$this->pagination->create_links(),
			'product_list'			=>	$this->master_model->fetch_data_achead($config["per_page"], $start,$serch)
		);
		echo json_encode($output);
	}
    }
}
