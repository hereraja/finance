<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{
    function get_branch()
    {
        $query = $this->db->order_by("branch_name", "asc")->get('md_branch');
        return $query->result();
    }
	function get_branchname($branch_id)
    {   $this->db->where('id', $branch_id);
        $query = $this->db->get('md_branch');
        $result= $query->row();
		return $result->branch_name;
    }

    function get_fin_year()
    {
        $query = $this->db->get('md_fin_year');
        return $query->result();
    }

    function check_user_by_id($user_id)
    {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('md_users');
        return $query->row();
    }

    function login_check($data)
    {
        $this->db->where('user_id', $data['user_id']);
        $query = $this->db->get('md_users');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if (password_verify($data['user_pwd'], $row->password)) {
                $this->db->where('user_id', $data['user_id']);
				$this->db->where('user_status', 'A');
                //$this->db->join('md_branch', 'md_users.branch_id = md_branch.id', 'LEFT');
                $query_1 = $this->db->get('md_users');
                return $query_1->row();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
	function login_check_by_api($data)
    {
        $this->db->where('user_id', $data['user_id']);
		$this->db->where('password',$data['user_pwd']);
        $query = $this->db->get('md_users');
        if ($query->num_rows() > 0) {
            $row = $query->row();
         //   if (password_verify($data['user_pwd'], $row->password)) {
                $this->db->where('user_id', $data['user_id']);
				$this->db->where('user_status', 'A');
                $query_1 = $this->db->get('md_users');
                return $query_1->row();
           // } else {
          //      return false;
         //   }
        } else {
            return false;
        }
    }
    public function f_insert_audit_trail($user_id){

        $time = date("Y-m-d H:i:s");
        $pcaddr = $_SERVER['REMOTE_ADDR'];

        $value = array('login_dt'=> $time,
                   'user_id' => $user_id,
                         'terminal_name'=>$pcaddr);
        $this->db->insert('td_audit_trail',$value);
        return $this->db->insert_id();
    }

    public function f_update_audit_trail($audit_trail_id){
        $time = date("Y-m-d H:i:s");
        $value= array('logout'=>$time);
        $this->db->where('id',$audit_trail_id);
        $this->db->update('td_audit_trail',$value);
    }

    function fin_year_by_id($sl_no)
    {
        $this->db->where('sl_no', $sl_no);
        $data = $this->db->get('md_fin_year');
        return $data->row();
    }
}
