<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_model extends CI_Model
{
    public function f_insert($table_name, $data_array)
    {

        $this->db->insert($table_name, $data_array);

        return;
    }

    public function f_edit($table_name, $data_array, $where)
    {

        $this->db->where($where);

        $this->db->update($table_name, $data_array);

        return;
    }

    public function f_select($table, $select = NULL, $where = NULL, $type)
    {

        if (isset($select)) {
            $this->db->select($select);
        }

        if (isset($where)) {
            $this->db->where($where);
        }

        $value = $this->db->get($table);

        if ($type == 1) {
            return $value->row();
        } else {
            return $value->result();
        }
    }

    function get_sub_group_dtls($id)
    {
        $this->db->select('a.sl_no, a.mngr_id,a.benfed_subgr_id, a.name, b.name as group_name, b.type');
        $this->db->join('mda_mngroup b', 'a.mngr_id=b.sl_no');
        if ($id > 0) {
            $this->db->where(array(
                'a.sl_no' => $id
            ));
        }
        $query = $this->db->get('mda_subgroub a');
        return $query->result();
    }

    function sub_gr_save($data)
    {
        $user_name = $this->session->userdata['loggedin']['user_name'];
        $datetime = date('Y-m-d h:m:s');
        if ($data['id'] > 0) {
            $input = array(
                'mngr_id' => $data['gr_name'],
                'benfed_subgr_id'   => $data['benfed_subgr_id'],
                'name' => $data['sub_gr'],
                'modified_by' => $user_name,
                'modified_dt' => $datetime
            );
            $this->db->where(array(
                'sl_no' => $data['id']
            ));
            $this->db->update('mda_subgroub', $input);
            return true;
        } else {
            $input = array(
                'mngr_id' => $data['gr_name'],
                'benfed_subgr_id'   => $data['benfed_subgr_id'],
                'name' => $data['sub_gr'],
                'created_by' => $user_name,
                'created_dt' => $datetime
            );
            $this->db->insert('mda_subgroub', $input);
            return true;
        }
    }

    function get_ac_head_dtls($id){
        $this->db->select('a.sl_no,a.benfed_ac_code, a.mngr_id, a.subgr_id, a.ac_name, b.name as gr_name, b.type, c.name as subgr_name,d.branch_name');
        $this->db->join('mda_mngroup b', 'a.mngr_id=b.sl_no');
        $this->db->join('mda_subgroub c', 'a.subgr_id=c.sl_no');
        $this->db->join('md_branch d', 'a.br_id=d.id');
		
        if ($id > 0) {
            $this->db->where(array(
                'a.sl_no' => $id
            ));
        }
        //  $this->db->where(array(
       //     'a.br_id' => $this->session->userdata['loggedin']['branch_id']
        //));
        $query = $this->db->get('md_achead a');
        return $query->result();
    }




    function get_ac_head_dtls_pagenation($id)
    {
        $this->db->select('a.sl_no,a.benfed_ac_code, a.mngr_id, a.subgr_id, a.ac_name, b.name as gr_name, b.type, c.name as subgr_name,d.branch_name');
        $this->db->join('mda_mngroup b', 'a.mngr_id=b.sl_no');
        $this->db->join('mda_subgroub c', 'a.subgr_id=c.sl_no');
        $this->db->join('md_branch d', 'a.br_id=d.id');
		
        if ($id > 0) {
            $this->db->where(array(
                'a.sl_no' => $id
            ));
        }
        //  $this->db->where(array(
       //     'a.br_id' => $this->session->userdata['loggedin']['branch_id']
        //));
        $query = $this->db->get('md_achead a');
        return $query->result();
    }

    function get_subgr_dtls_by_gr_id($gr_id)
    {
        $this->db->select('sl_no as id, name');
        $this->db->where(array(
            'mngr_id' => $gr_id
        ));
        $query = $this->db->get('mda_subgroub');
        return $query->result();
    }



// =========================================================================

    function make_query($serch){

        // ================================
        $query =" SELECT a.sl_no, a.benfed_ac_code, a.mngr_id, a.subgr_id, a.ac_name, b.name as gr_name, b.type, c.name as subgr_name, d.branch_name FROM md_achead a JOIN mda_mngroup b ON a.mngr_id=b.sl_no JOIN mda_subgroub c ON a.subgr_id=c.sl_no JOIN md_branch d ON a.br_id=d.id";

           // $query = " SELECT * FROM tbl_online_exam WHERE status='1'";
           if($serch !=null || $serch !=''){
            $serch=ltrim($serch, "0");
               $query .= "
               WHERE CONCAT_WS('', a.sl_no, a.benfed_ac_code, a.mngr_id, a.subgr_id, a.ac_name, b.name, b.type, c.name, d.branch_name) LIKE '%".$serch."%' ";
           }
        //    if(isset($toDate, $fDAte) && !empty($fDAte) &&  !empty($toDate)){
        //     $query .= "
        //         AND tbl_store.create_at BETWEEN '".$fDAte."' AND '".$toDate."'
        //     ";
        //     }
            // $query .= "
            //     AND tbl_store.stock BETWEEN '".$stock."' AND '".$stock."'
            // ";
        
        //    $query.=" ORDER BY tbl_store.store_id DESC";
           return $query;
       }

    function count_all_achead($serch){
        $query = $this->make_query($serch);
        $data = $this->db->query($query);
        return $data->num_rows();
    }

    function fetch_data_achead($limit, $start, $serch){
        $query = $this->make_query($serch);

        $query .= ' LIMIT '.$start.', ' . $limit;

        $data = $this->db->query($query);

        $output = '';
        if($data->num_rows() > 0){
            $i=$start;
            foreach($data->result_array() as $row){
// print_r($row);
// exit();
                $i++;
                

              
                $delete=site_url('/achead/entry?id=').$row['sl_no'];

               
           
                $output .='<tr>
                <td> '.$i.' </td>
                <td> '.$row['sl_no'].' </td>
                <td> '.$row['branch_name'].' </td>
                <td> '.$row['gr_name'].' </td>
                <td> '.$row['subgr_name'].' </td>
                <td> '.$row['ac_name'].' </td>
               
                <td>
                    <a href="'.$delete.'" data-placement="bottom" title="Edit">
                        <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
                    </a>
                </td>
            
              
            </tr>
                ';
            }
        }else{
            $output = '<tr><td colspan="4"><div class="col-lg-12"><div class="feat_property list"><div class="thumb"><div class="card is-loading"><div class="image"></div></div></div><div class="details"><div class="tc_content"><div class="card is-loading"><div class="content"><h2></h2><h2></h2><p>No Data Found</p></div></div></div><div class="fp_footer"></div></div></div></div></td></tr>
            ';
        }
        return $output;
    }


    // =======================================================================
}
