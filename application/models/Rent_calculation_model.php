<?php class Rent_calculation_model extends CI_Model{
    public function fetch_district(){
        $this->db->select()->from('md_district')->order_by('district_name');
        $q=$this->db->get();
        return $q->result();
    }

    
    public function addGodown($data){
        $this->db->insert('md_godown',$data);
    }

    
    public function godownData(){
        $this->db->select()->from('md_godown');
        $this->db->join('md_district', 'md_district.district_code = md_godown.gdn_dist')->order_by('md_godown.id','DESC');
        $q=$this->db->get();
        return $q->result();
    }
    public function editgodownData($id){
        $q=$this->db->where('id',$id)->get('md_godown');
        return $q->result_array();
    }
    public function updateGodown($id,$data){
        $this->db->where('id',$id)->update('md_godown',$data);
    }
    public function insert_rent_customer($postData){
        $this->db->insert('md_rent_customer',$postData);
    }

    public function customerData(){
        $this->db->select()->from('md_rent_customer');
        $this->db->join('md_district', 'md_district.district_code = md_rent_customer.cust_dist')->order_by('md_rent_customer.id','DESC');
        $q=$this->db->get();
        return $q->result();
    }

    public function editcustomerData($id){
        $q=$this->db->where('id',$id)->get('md_rent_customer');
        return $q->result_array();
    }
    public function updatecustomer($id,$data){
        $this->db->where('id',$id)->update('md_rent_customer',$data);
    }


    public function fetch_customer(){
       return $this->db->get('md_rent_customer')->result();
    }
    public function fetch_godown(){
        return $this->db->get('md_godown')->result();
    }
    public function insert_godown_rent_add($data){
        $this->db->insert('td_rent',$data);
    }

    public function fetch_rentdata(){
        $this->db->select('*')->from('td_rent')->join('md_godown','md_godown.id=td_rent.godown_id');
        $this->db->join('md_rent_customer','md_rent_customer.id=td_rent.customer_id')->order_by('td_rent.sl_no','DESC');
        $q=$this->db->get();
        return $q->result();
    }
    public function invoice_no(){
        $q=$this->db->order_by('trans_no','desc')->limit(1)->get('td_rent_collection');
        return $q->row();
    }

    public function fetch_rent_collection($where=null){
        $this->db->select('')->from('td_rent_collection');
        $this->db->join('md_rent_product','md_rent_product.sl_no=td_rent_collection.prod_id');
        $this->db->join('md_rent_customer','md_rent_customer.id=td_rent_collection.cust_id');
        $this->db->join('md_godown','md_godown.id=td_rent_collection.godown_id');
        if($where!=''||$where!=null){
            $this->db->where('trans_no',$where);
        }
        $this->db->order_by('td_rent_collection.trans_no','desc');
        $q=$this->db->get();
        return $q->result();
        
    }

    public function fetch_rent_collectionedit($where=null){
        $this->db->select('')->from('td_rent_collection');
        $this->db->join('md_rent_product','md_rent_product.sl_no=td_rent_collection.prod_id');
        $this->db->join('md_rent_customer','md_rent_customer.id=td_rent_collection.cust_id');
        $this->db->join('md_godown','md_godown.id=td_rent_collection.godown_id');
        if($where!=''||$where!=null){
            $this->db->where('trans_no',$where);
        }
        $this->db->where('pay_flag','N');
        $this->db->where(array('ack_no !=' => ''));
        $this->db->where(array('ack_dt !=' => '0000-00-00'));
        $this->db->order_by('td_rent_collection.trans_no','desc');
        $q=$this->db->get();
        return $q->result();
        
    }
    // function f_rentjnl($data){
        
        
    // }

    public function f_get_receiptReport_dtls($trans_do)
		{
	
		  $sql = $this->db->query("SELECT a.trans_dt as do_dt,'' as sale_due_dt,'' as ro_dt,a.trans_no ,
                                        a.invoice_no as trans_do,'' ro_no,b.gst_no as gstin,b.cust_name as soc_name,
								         b.cust_addr as soc_add,b.fms_id as mfms,a.taxable_amt,a.cgst_amt  as  cgst,
                                         a.sgst_amt  as sgst ,a.qty,a.cgst_rt+a.sgst_rt as gst_rt,
                                         a.total_amt as tot_amt,a.godown_id,a.cust_id,d.product_desc as prod_desc,
                                         c.sac_code  as hsn_code,a.taxable_amt as sale_rt
								   
								   from td_rent_collection a,md_rent_customer b,md_godown c,md_rent_product d
								   where a.cust_id=b.id
                                   and a.godown_id=c.id
                                   and a.prod_id=d.sl_no
								   and  a.invoice_no='$trans_do'");
											
		  return $sql->row();
	
		}

        public function f_get_rentinv_tot($trans_do)
		{
	
		  $sql = $this->db->query("SELECT a.invoice_no as trans_do,sum(a.qty)as qty,
									sum(a.taxable_amt)as taxable_amt,sum(a.cgst_amt)as cgst,sum(a.sgst_amt)as sgst,
									sum(a.cgst_amt+a.sgst_amt)as tot_gst,0 as dis,sum(a.total_amt)as tot_amt,
									sum(a.total_amt) as paid_amt,ROUND(sum(a.total_amt))as tot_amt_rnd,
                                    a.remarks as remarks
									from td_rent_collection a 
									where  a.invoice_no='$trans_do'  group by a.remarks ");
											
		  return $sql->row();
	
		}
    public function fetch_rent_collectreport($where=null,$first_date=null,$second_date=null){
        $this->db->select('')->from('td_rent_collection');
        $this->db->join('md_rent_product','md_rent_product.sl_no=td_rent_collection.prod_id');
        $this->db->join('md_rent_customer','md_rent_customer.id=td_rent_collection.cust_id');
        $this->db->join('md_godown','md_godown.id=td_rent_collection.godown_id');
        // $this->db->join('md_achead','md_achead.sl_no=td_rent_collection.cr_bnk');
        if($where!=''||$where!=null){
            $this->db->where('trans_no',$where);
        }
        $this->db->where('pay_flag','Y');
        $this->db->where(array('ack_no !=' => ''));
        $this->db->where(array('ack_dt !=' => '0000-00-00'));
        // $this->db->where('trans_type', 'B');
        $this->db->where('trans_dt >=',$first_date); 
        $this->db->where('trans_dt <=',$second_date);
        $this->db->order_by('td_rent_collection.trans_no','desc');
        $q=$this->db->get();
        return $q->result();
        
    }


public function fetchCustomer($customer){
    $this->db->select('')->from('md_godown');
    $this->db->where('customer_id',$customer);
    
    $this->db->group_by('godown_id');
    $this->db->join('td_rent','md_godown.id=td_rent.godown_id');
    $q=$this->db->get();
    return $q->result();
}



public function f_get_api_data($trans_do){
    $this->db->select('td_rent_collection.fin_yr,
    td_rent_collection.trans_dt,
    td_rent_collection.trans_no,
    td_rent_collection.invoice_no,
    td_rent_collection.trans_type,
    td_rent_collection.prod_id,
    td_rent_collection.cust_id,
    td_rent_collection.godown_id,
    td_rent_collection.qty,
    td_rent_collection.taxable_amt,
    td_rent_collection.cgst_rt,
    td_rent_collection.cgst_amt,
    td_rent_collection.sgst_rt,
    td_rent_collection.sgst_amt,
    td_rent_collection.total_amt,
    td_rent_collection.irn,
    td_rent_collection.ack_no,
    td_rent_collection.ack_dt,
    td_rent_collection.colc_brn,
    td_rent_collection.cr_bnk,
    td_rent_collection.rf_date,
    td_rent_collection.rf_no,
    td_rent_collection.pay_flag,
    td_rent_collection.payment_date,
    td_rent_collection.remarks,

    a.district_name as seller_district,
    a.district_code as dcode,
    a.pin as sellet_pin,
    a.addr as sellet_addr,

    b.district_name as buyer_district,
    b.district_code as buyer_dcode,
    b.pin as buyer_pin,
    b.addr as buyer_addr,

    g.district_name as godownDist,

    c.id as branch_idd,
    c.dist_sort_code,
    c.districts_catered,
    c.ho_flag,
    c.br_manager,
    c.contact_no,
    c.addr,
    c.benfed_dist_code,

    e.id as godownid ,
    e.gdn_name,
    e.gdn_addr,
    e.gdn_dist,
    e.sac_code,
    e.cnct_person,
    e.cnct_no,

    d.*,

    f.id as rent_customerid,
    f.cust_name,
    f.cust_dist,
    f.cust_addr,
    f.cnct_no,
    f.cnct_person,
    f.email_id,
    f.pin_code,
    f.gst_no,
    f.pan_no,
    f.fms_id')->from('td_rent_collection');
    $this->db->where('invoice_no',$trans_do);
    $this->db->join('md_branch as c','c.id='.$this->session->userdata("loggedin")["branch_id"].'');
    
    $this->db->join('md_district as a','c.districts_catered=a.district_code','left');

    $this->db->join('md_rent_product as d','d.sl_no=td_rent_collection.prod_id');

    $this->db->join('md_godown as e','e.id=td_rent_collection.godown_id');
    $this->db->join('md_district as g','e.gdn_dist=g.district_code','left');

    $this->db->join('md_rent_customer as f','f.id=td_rent_collection.cust_id');
    $this->db->join('md_district as b','f.cust_dist=b.district_code','left');
    $q=$this->db->get();
    return $q->result();
}

public function get_trans_no($fin_id,$branch_id){

    $sql="select ifnull(max(sl_no ),0) + 1 trans_no
             from td_vouchers where fin_yr = '$fin_id' ";

  $result = $this->db->query($sql);     

  return $result->row();

}



function save_irn($data){
    $input = array(
        'irn' => $data['irn'],
        'ack_no' => $data['ack'],
        'ack_dt' => $data['ack_dt'],
        'pay_flag'=>$data['trn_type']
    );
    $this->db->where(array(
        'invoice_no' => $data['trans_do']
    ));
    if($this->db->update('td_rent_collection', $input)){
        return 1;
    }else{
        return 0;
    }
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

    public function insertvouchers($data){
    $this->db->insert('td_vouchers',$data);
    }


    public function f_insert($table_name, $data_array){
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
    

}
 ?>