<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Model {

	public function f_get_particulars($table_name, $select=NULL, $where=NULL, $flag) {

        if(isset($select)) {

            $this->db->select($select);

        }

        if(isset($where)) {

            $this->db->where($where);

        }

        $result		=	$this->db->get($table_name);

        if($flag == 1) {

            return $result->row();
            
        }else {

            return $result->result();

        }

    }

    //For inserting row

    public function f_insert($table_name, $data_array) {

        $this->db->insert($table_name, $data_array);

        return;

    }

    //For Editing row

    public function f_edit($table_name, $data_array, $where) {

        $this->db->where($where);
        $this->db->update($table_name, $data_array);

        return;

    }

    //For Deliting row

    public function f_delete($table_name, $where) {

        $this->db->delete($table_name, $where);

        return;

    }

    public function matchPass($oldPass){
    	$this->db->select('password');
    	$this->db->where('user_id', $this->session->userdata['loggedin']['user_id']);
    	
        $query = $this->db->get('md_users');
        
    	if ($query->num_rows() == 1) {
    		return $query->row();
    	}
    	else{
    		return false;
    	}
    }

    public function editPassProcess($newPass){
    	$value = array('password' => $newPass );
    	$this->db->where('user_id', $this->session->userdata['loggedin']['user_id']);
    	$this->db->update('md_users',$value);
    	return true;
    }

}