<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Model {

    public function f_get_particulars($table_name, $select=NULL,$where, $flag) {

        if(isset($select)) {

            $this->db->select($select);

        }
        if(isset($where)) {
            $this->db->where($where);
        }
        //$this->db->where('branch_id',$this->session->userdata['loggedin']['branch_id']);
        $result		=	$this->db->get($table_name);

        if($flag == 1) {

            return $result->row();
            
        }else {

            return $result->result();

        }

    }

    //For Distinct Value

    public function f_get_distinct($table_name, $select=NULL, $where=NULL) {

        $this->db->distinct();

        if(isset($select)) {

            $this->db->select($select);

        }

        if(isset($where)) {

            $this->db->where($where);

        }

        $result		=	$this->db->get($table_name);

        return $result->result();
        
    }

    // for getting user details--
    public function f_get_employee_dtls()
    {

        $sql = $this->db->query(" SELECT emp_code, emp_name FROM md_employee WHERE emp_status = 'A' ");
        return $sql->result();

    }

    public function f_get_employeeName($emp_cd)
    {

        $sql = $this->db->query(" SELECT emp_name FROM md_employee WHERE emp_code = '$emp_cd' ");
        return $sql->row();

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

}