<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Login_Process extends CI_Model{

		public function f_select_password($user_id){
			$this->db->select('password,user_status');
			$this->db->where('user_id',$user_id);
			$data=$this->db->get('md_users');

			if($data->num_rows() > 0 )
			{
				return $data->row();
			}
			else
			{
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
		}

		public function f_get_user_inf($user_id){
			$this->db->select('*');
			$this->db->from('md_users');
			$this->db->where('md_users.user_id',$user_id);
			$this->db->join('md_branch', 'md_users.branch_id = md_branch.id', 'LEFT');
			$data=$this->db->get();
			return $data->row();
		}
		public function f_get_branch_inf($branch_id){
			$this->db->select('*');
			$this->db->from('md_branch');
			$this->db->where('md_branch.id',$branch_id);
			$data=$this->db->get();
			return $data->row();
		}
		public function f_get_branch_list(){
			$this->db->select('*');
			$this->db->from('md_branch');
			$this->db->order_by("branch_name", "asc");
			$data=$this->db->get();
			return $data->result();
		}

		public function f_get_dist_inf($dist_cd){

				$this->db->select('*');

				$this->db->where('district_code',$dist_cd);

				$data = $this->db->get('md_district');

				return $data->row();

		}

		public function f_get_kms_inf($sl_no){

			$this->db->select('*');

			$this->db->where('sl_no',$sl_no);

			$data = $this->db->get('md_kms_year');

			return $data->row();

	}


		public function f_get_kms_yr(){

			$this->db->select('*');

			$data = $this->db->get('md_kms_year');

			return $data->result();
		}

		public function f_update_audit_trail($user_id){
			$time = date("Y-m-d H:i:s");
			$sl_no= $this->session->userdata('sl_no')->sl_no;
			$value= array('logout'=>$time);
			$this->db->where('sl_no',$sl_no);
			$this->db->update('td_audit_trail',$value);
		}
		
		public function f_get_parameters($sl_no){
			$this->db->select('param_value');
			$this->db->where('sl_no',$sl_no);
			$data=$this->db->get('md_parameters');

			if($data->num_rows() > 0 ){
				return $data->row();
			}else{
				return false;
			}
		}
		
		public function f_audit_trail_value($user_id){
    		$this->db->select_max('sl_no');
    		$this->db->where('user_id', $user_id);
    		$details = $this->db->get('td_audit_trail');
    		return $details->row();
		}
		
		public function f_get_tot_paddy_procurement($kms_id,$branch_id){
		
			$this->db->select('ifnull(SUM(quantity), 0) tot_quantity,count(cheque_no) cheque_no,ifnull(SUM(amount), 0) amount');
			$this->db->where('kms_id',$kms_id);
			$this->db->where('branch_id',$branch_id);
			$data=$this->db->get('td_collections');
            return $data->row();
		}

		
		public function f_get_tot_paddy_procurement_ho($kms_id){
		
			$this->db->select('ifnull(SUM(quantity), 0) tot_quantity,count(cheque_no) cheque_no,ifnull(SUM(amount), 0) amount');
			$this->db->where('kms_id',$kms_id);
			$data=$this->db->get('td_collections');
            return $data->row();
		}
		public function f_tot_paddy_dispatch($where=NULL){

            $this->db->select('ifnull(SUM(paddy_qty), 0) paddy_qty');
			if(isset($where)) {
            $this->db->where($where);
            }	
			$data=$this->db->get('td_received');
            return $data->row();
		}
		public function f_get_tot_cheque_cleared($kms_id,$branch_id){

            $this->db->select('ifnull(SUM(amount), 0) tot_clr_cheque');
			$this->db->where('kms_id',$kms_id);
			$this->db->where('chq_status',"C");
			$this->db->where('branch_id',$branch_id);
			$data = $this->db->get('td_collections');
            return $data->row();

		}
		public function f_get_tot_amount_cleared($kms_id,$branch_id){

			$cond = array('S','P','A');

            $this->db->select('ifnull(SUM(amount), 0) tot_clr_cheque');
			$this->db->where('kms_id',$kms_id);
			$this->db->where_in('chq_status',$cond);
			$this->db->where('branch_id',$branch_id);
			$data = $this->db->get('td_collections');
            return $data->row();

		}
		public function f_get_tot_cheque_cleared_ho($kms_id){

            $this->db->select('ifnull(SUM(amount), 0) tot_clr_cheque');
			$this->db->where('kms_id',$kms_id);
			$this->db->where('chq_status',"C");
			$data = $this->db->get('td_collections');
            return $data->row();

		}
		public function f_get_tot_amount_cleared_ho($kms_id){

			$cond = array('S','P','A');
            $this->db->select('ifnull(SUM(amount), 0) tot_clr_cheque');
			$this->db->where('kms_id',$kms_id);
			$this->db->where_in('chq_status',$cond);
			$data = $this->db->get('td_collections');
            return $data->row();

		}
		public function f_get_tot_cmr_offered($kms_id,$branch_id){
		
			$this->db->select('ifnull(SUM(cmr_offered_now), 0) cmr_offered_now');
			$this->db->where('kms_year',$kms_id);
			$this->db->where('branch_id',$branch_id);
			$data=$this->db->get('td_cmr_offered');
            return $data->row();
		}
		public function f_get_tot_cmr_offered_ho($kms_id){
		
			$this->db->select('ifnull(SUM(cmr_offered_now), 0) cmr_offered_now');
			$this->db->where('kms_year',$kms_id);
			$data=$this->db->get('td_cmr_offered');
            return $data->row();
		}
		
		public function f_get_tot_cmr_delivery($kms_id,$branch_id){
		
			$this->db->select('ifnull(SUM(tot_delivery), 0) tot_delivery');
			$this->db->where('kms_year',$kms_id);
			$this->db->where('branch_id',$branch_id);
			$data=$this->db->get('td_cmr_delivery');
            return $data->row();
		}
		public function f_get_tot_cmr_delivery_ho($kms_id){
		
			$this->db->select('ifnull(SUM(tot_delivery), 0) tot_delivery');
			$this->db->where('kms_year',$kms_id);
			$data=$this->db->get('td_cmr_delivery');
            return $data->row();
		}

		public function f_get_tot_do_issued($kms_id,$branch_id){
		
			$this->db->select('SUM(sp)+sum(cp)+sum(fci) tot_do');
			$this->db->where('kms_year',$kms_id);
			$this->db->where('branch_id',$branch_id);
			$data=$this->db->get('td_do_isseued');
            return $data->row();
		}
		public function f_get_tot_do_issued_ho($kms_id){
		
			$this->db->select('ifnull(SUM(sp+cp+fci), 0) tot_do');
			$this->db->where('kms_year',$kms_id);
			$data=$this->db->get('td_do_isseued');
            return $data->row();
		}


		public function f_get_tot_wqsc_upload($kms_id,$branch_id){

			$sql = "SELECT sum(b.quantity)quantity 
					FROM   td_wqsc a,td_wqsc_dtls b 
					where  a.id = b.trans_id
					and    a.branch_id = $branch_id
					and    a.kms_id = $kms_id";
	
			$data=$this->db->query($sql);
            return $data->row();
		}

		public function f_get_tot_wqsc_ho($kms_id){

			$sql = "SELECT sum(b.quantity)quantity 
					FROM   td_wqsc a,td_wqsc_dtls b 
					where  a.id = b.trans_id
					and    a.kms_id = $kms_id";
	
			$data=$this->db->query($sql);
            return $data->row();
		}

		public function f_get_tot_mill_payment($kms_id,$branch_id){
		
			$this->db->select('ifnull(SUM(payble_amt), 0) payable_amt');
			$this->db->where('kms_id',$kms_id);
			$this->db->where('dist',$branch_id);
			$data=$this->db->get('td_payment_bill_dtls');
            return $data->row();
		}
		public function f_get_tot_mill_payment_ho($kms_id){
		
			$this->db->select('ifnull(SUM(payble_amt), 0) payable_amt');
			$this->db->where('kms_id',$kms_id);
			$data=$this->db->get('td_payment_bill_dtls');
            return $data->row();
		}

		public function f_get_tot_socy_payment($kms_id,$branch_id){
		
			$this->db->select('ifnull(SUM(paid_amt), 0) paid_amt');
			$this->db->where('kms_id',$kms_id);
			$this->db->where('branch_id',$branch_id);
			$data=$this->db->get('td_society_commision');
            return $data->row();
		}
		public function f_get_tot_socy_payment_ho($kms_id){
		
			$this->db->select('ifnull(SUM(paid_amt), 0) paid_amt');
			$this->db->where('kms_id',$kms_id);
			$data=$this->db->get('td_society_commision');
            return $data->row();
		}
		
		public function f_get_notice(){
			$sql = "select * from md_notice order by notice_date desc";
			$data = $this->db->query($sql)->result();
			
			return $data;
		}

		public function f_get_tot_req_fwd($kms_id,$branch_id){

			$sql = "SELECT sum(a.total_amt)total_amt
					FROM td_fund_requisition_dtls a,
						 td_fund_requisition b
					where a.req_no = b.req_no
					and   b.kms_id = '$kms_id'
					and   b.branch_id = '$branch_id'";
			$data=$this->db->query($sql);
            return $data->row();
		}

		public function f_get_tot_req_fwd_ho($kms_id){

			$sql = "SELECT sum(a.total_amt)total_amt
					FROM td_fund_requisition_dtls a,
						td_fund_requisition b
					where a.req_no = b.req_no
					and   b.kms_id = '$kms_id'";
	
			$data=$this->db->query($sql);
            return $data->row();
		}

		public function f_get_tot_req_sanc($kms_id,$branch_id){

			$sql = "SELECT sum(a.total_amt)total_amt
					FROM td_fund_requisition_dtls a,
						 td_fund_requisition b
					where a.req_no = b.req_no
					and   b.fund_flag = '1'
					and   b.kms_id = '$kms_id'
					and   b.branch_id = '$branch_id'";
			$data=$this->db->query($sql);
            return $data->row();
		}

		public function f_get_tot_req_sanc_ho($kms_id){

			$sql = "SELECT sum(a.total_amt)total_amt
					FROM td_fund_requisition_dtls a,
						td_fund_requisition b
					where a.req_no = b.req_no
					and   b.fund_flag = '1'
					and   b.kms_id = '$kms_id'";
	
			$data=$this->db->query($sql);
            return $data->row();
		}
		
		

	}	
?>
