<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction_model extends CI_Model
{
    public function f_select($table, $select = NULL, $where = NULL, $type=NULL)
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

    public function jurnalVoucher($table, $select,$where, $group ){
        // $this->db->select('voucher_date,voucher_id,voucher_type,voucher_mode, SUM(amount) AS amount');
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->group_by($group);
        $value=$this->db->get();
        return $value->result();

    }



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

    public function f_delete($table_name, $where)
    {
        $this->db->delete($table_name, $where);
        return;
    }
    public function select_purchase_appview($fYear,$br_cd){
        $data=$this->db->query("select voucher_date,
        voucher_id,
        approval_status,
        sum(dr_amount)dr_amt,sum(cr_amount) cr_amount
from(
select voucher_date,
        voucher_id,
    approval_status,
    sum(amount) dr_amount,
    0 cr_amount
    from td_vouchers
    where branch_id = ".$br_cd."
    and  approval_status in ('U','H')
    and  fin_yr = ".$fYear."
    and  dr_cr_flag = 'Dr'
    group by voucher_date,voucher_id,approval_status
UNION
select voucher_date,
        voucher_id,
    approval_status,
    0 dr_amount,
    sum(amount) cr_amount
    from td_vouchers
    where branch_id = ".$br_cd."
    and  approval_status in ('U','H')
    and  fin_yr = ".$fYear."
    and  dr_cr_flag = 'Cr'
    group by voucher_date,voucher_id,approval_status)a
 group by  voucher_date,
        voucher_id,
        approval_status");
        return $data->result();
    }

    function get_gr_dtls($achead_id)
    {
        $this->db->select('b.name as gr_name, c.name as subgr_name,a.benfed_ac_code');
        $this->db->join('mda_mngroup b', 'a.mngr_id=b.sl_no');
        $this->db->join('mda_subgroub c', 'a.subgr_id=c.sl_no');
        $this->db->where(array(
            'a.sl_no' => $achead_id
        ));
        $query = $this->db->get('md_achead a');
        return $query->row();
    }

    public function f_get_voucher_id($fin_yr)
    {
        $this->db->select('IFNULL(MAX(sl_no), 0)+1 as sl_no');
		$this->db->where(array(
                        'fin_yr =' => $fin_yr
                         ));
        $result = $this->db->get('td_vouchers');
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return 0;
        }
    }

    public function f_select_fertidb($table, $select = NULL, $where = NULL, $type=NULL)
    {
        //$db2 = $this->load->database('seconddb', TRUE);
        //if (isset($select)) {
       //     $db2->select($select);
        //}

        //if (isset($where)) {
          //  $db2->where($where);
       // }

       // $value = $db2->get($table);

       // if ($type == 1) {
         //   return $value->row();
        //} else {
        //    return $value->result();
       // }
		return NULL;
    }


    public function f_get_mnthend($br_cd ){
       
         $data= $this->db->query("select 
         DATE_ADD(last_day(concat(concat(concat(concat(end_yr,'-'),if(LENGTH(end_mnth)=1,concat('0',end_mnth),end_mnth)),'-'),'01')),INTERVAL 1 DAY) as mnthdt
                      from   td_month_end
                      where branch_id=$br_cd");
         $result = $data->result();
        
         return $result;
 }


 public function  get_monthendDate(){
			
    $branchId=$this->session->userdata['loggedin']['branch_id'];
    return $this->db->query('SELECT * FROM td_month_end  where branch_id = '.$branchId.' and   sl_no = (select max(sl_no) from td_month_end  where  branch_id = '.$branchId.')')->row();
}
	public function f_get_vendor_acccode($vendor_id,$vendor_name){
		$query    = $this->db->get_where('md_achead',array('vendor_id'=>$vendor_id));
		$rowcount = $query->num_rows();
		if($rowcount == 1 ){
			$vendor_acc = $this->f_select('md_achead', array('sl_no'),array('vendor_id'=>$vendor_id), 1);
			return 	$vendor_acc->sl_no;						  
		 }else{
			$data = array(
				         'vendor_id'=>$vendor_id,'ac_name'=>$vendor_name,
				          'mngr_id'=>3,'subgr_id'=>196,
				          'br_id'  =>337,'created_by'=>'SYSTEM API','created_dt'=>date('Y-m-d H:i:s')
			              );
			$this->db->insert('md_achead', $data);
			return $this->db->insert_id();
		}
	
	
	}

    
}
