<?php 
    class HTransportC_model extends CI_Model{
        function customar_entry($data){
            $this->db->insert('md_htc_customer',$data);
            return;
        }

        function get_customar_list(){
            // $q=$this->db->get('md_htc_customer');
            // return $q->result();

            $this->db->select()->from('md_htc_customer');
            $this->db->join('md_district', 'md_district.district_code = md_htc_customer.cust_dist')->order_by('md_htc_customer.id','DESC');
            $q=$this->db->get();
            return $q->result();
        }

        function get_customar_edit($id){
            $q=$this->db->where('id',$id)->get('md_htc_customer');
            return $q->result_array();
        }

        function updatecustomer($id,$data){
            $this->db->where('id',$id)->update('md_htc_customer',$data);
        }

        function fetch_customer(){
            // $this->db->select('cust_name','id');
            $q=$this->db->get('md_htc_customer');
            return $q->result();
        }
        function insert_htc_add($postData){
            $this->db->insert('td_htc',$postData);
        }
        
        function fetch_htcdata(){

            $this->db->select('*')->from('td_htc');
            $this->db->join('md_htc_customer','md_htc_customer.id=td_htc.customer_id')->order_by('td_htc.sl_no','DESC');
            $q=$this->db->get();
            return $q->result();
        }

        function htc_edit($id,$postData){
            $this->db->where('sl_no',$id)->update('td_htc',$postData);
        }
        function htc_select($id){
            $this->db->where('sl_no',$id);
            $q=$this->db->get('td_htc');
            return $q->row();        
        }
        function getGst($c_ac){
            $this->db->where('id',$c_ac);
            $q=$this->db->get('md_htc_customer');
            return $q->row();
        }
        function productData($product_id){
           return $this->db->where('sl_no',$product_id)->get('md_rent_product')->result();
            
        }

        function fetchhtc($customar){
            $this->db->where('customer_id',$customar);
            $q=$this->db->get('td_htc');
            return $q->row();
        }

        public function invoice_no(){
            $q=$this->db->order_by('trans_no','desc')->limit(1)->get('td_htc_rent_collection');
            return $q->row();
        }



        public function fetch_rent_collection($where=null){
            $this->db->select('')->from('td_htc_rent_collection');
            $this->db->join('md_rent_product','md_rent_product.sl_no=td_htc_rent_collection.prod_id');
            $this->db->join(' md_htc_customer ',' md_htc_customer.id=td_htc_rent_collection.cust_id');
            // $this->db->join('md_godown','md_godown.id=td_htc_rent_collection.godown_id');
            if($where!=''||$where!=null){
                $this->db->where('trans_no',$where);
            }
            $this->db->order_by('td_htc_rent_collection.trans_no','desc');
            $q=$this->db->get();
            return $q->result();
            
        }


        public function fetch_rent_collectionedit($where=null){
            $this->db->select('')->from('td_htc_rent_collection');
            $this->db->join('md_rent_product','md_rent_product.sl_no=td_htc_rent_collection.prod_id');
            $this->db->join('md_htc_customer','md_htc_customer.id=td_htc_rent_collection.cust_id');
          
            if($where!=''||$where!=null){
                $this->db->where('trans_no',$where);
            }
            $this->db->where('pay_flag','N');
            $this->db->where(array('ack_no !=' => ''));
            $this->db->where(array('ack_dt !=' => '0000-00-00'));
            $this->db->order_by('td_htc_rent_collection.trans_no','desc');
            $q=$this->db->get();
            return $q->result();
            
        }





        public function f_get_receiptReport_dtls($trans_do)
		{
	
		  $sql = $this->db->query("SELECT a.suppliers_ref, a.trans_dt as do_dt,'' as sale_due_dt,a.trans_no ,
                                        a.invoice_no as trans_do,b.gst_no as gstin,b.cust_name as soc_name,
								         b.cust_addr as soc_add,b.fms_id as mfms,a.taxable_amt,a.cgst_amt  as  cgst,
                                         a.sgst_amt  as sgst ,a.qty,a.cgst_rt+a.sgst_rt as gst_rt,
                                         a.total_amt as tot_amt,a.cust_id,d.product_desc as prod_desc,
                                         b.sac_code  as hsn_code,a.taxable_amt as sale_rt
								   
								   from td_htc_rent_collection a,md_htc_customer b,md_rent_product d
								   where a.cust_id=b.id
                                   
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
									from td_htc_rent_collection a 
									where  a.invoice_no='$trans_do'  group by a.remarks ");
											
		  return $sql->row();
	
		}


        
        public function fetch_htc_collectreport($where=null,$first_date=null,$second_date=null){
            $this->db->select('')->from('td_htc_rent_collection');
            $this->db->join('md_rent_product','md_rent_product.sl_no=td_htc_rent_collection.prod_id');
            $this->db->join('md_htc_customer','md_htc_customer.id=td_htc_rent_collection.cust_id');
       
            // $this->db->join('md_achead','md_achead.sl_no=td_rent_collection.cr_bnk');
            if($where!=''||$where!=null){
                $this->db->where('trans_no',$where);
            }
            $this->db->where('pay_flag','Y');
            $this->db->where(array('ack_no !=' => ''));
            $this->db->where(array('ack_dt !=' => '0000-00-00'));
            
            $this->db->where('trans_dt >=',$first_date); 
            $this->db->where('trans_dt <=',$second_date);
            $this->db->order_by('td_htc_rent_collection.trans_no','desc');
            $q=$this->db->get();
            return $q->result();
            
        }


        public function f_get_api_data($trans_do){
            $this->db->select('td_htc_rent_collection.fin_yr,
            td_htc_rent_collection.trans_dt,
            td_htc_rent_collection.trans_no,
            td_htc_rent_collection.invoice_no,
            td_htc_rent_collection.trans_type,
            td_htc_rent_collection.prod_id,
            td_htc_rent_collection.cust_id,
          
            td_htc_rent_collection.qty,
        
            td_htc_rent_collection.taxable_amt,
            td_htc_rent_collection.cgst_rt,
            td_htc_rent_collection.cgst_amt,
            td_htc_rent_collection.sgst_rt,
            td_htc_rent_collection.sgst_amt,
            td_htc_rent_collection.total_amt,
            td_htc_rent_collection.irn,
            td_htc_rent_collection.ack_no,
            td_htc_rent_collection.ack_dt,
            td_htc_rent_collection.colc_brn,
            td_htc_rent_collection.cr_bnk,
            td_htc_rent_collection.rf_date,
            td_htc_rent_collection.rf_no,
            td_htc_rent_collection.pay_flag,
            td_htc_rent_collection.payment_date,
            td_htc_rent_collection.remarks,
        
            a.district_name as seller_district,
            a.district_code as dcode,
            a.pin as sellet_pin,
            a.addr as sellet_addr,
        
            b.district_name as buyer_district,
            b.district_code as buyer_dcode,
            b.pin as buyer_pin,
            b.addr as buyer_addr,
        
            
        
            c.id as branch_idd,
            c.dist_sort_code,
            c.districts_catered,
            c.ho_flag,
            c.br_manager,
            c.contact_no,
            c.addr,
            c.benfed_dist_code,
        
            
        
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
            f.fms_id,
            f.dr_bnk,
            f.sac_code
            '
            
            )->from('td_htc_rent_collection');
            $this->db->where('invoice_no',$trans_do);
            $this->db->join('md_branch as c','c.id='.$this->session->userdata("loggedin")["branch_id"].'');
            
            $this->db->join('md_district as a','c.districts_catered=a.district_code','left');
        
            $this->db->join('md_rent_product as d','d.sl_no=td_htc_rent_collection.prod_id');
        
            // $this->db->join('md_godown as e','e.id=td_htc_rent_collection.godown_id');
            // $this->db->join('md_district as g','e.gdn_dist=g.district_code','left');
        
            $this->db->join('md_htc_customer as f','f.id=td_htc_rent_collection.cust_id');
            $this->db->join('md_district as b','f.cust_dist=b.district_code','left');
            $q=$this->db->get();
            return $q->result();
        }

        public function f_get_api_service_data($trans_do){
            $this->db->select('td_service_charge.*,
            a.district_name as seller_district,
            a.district_code as dcode,
            a.pin as sellet_pin,
            a.addr as sellet_addr'
            )->from('td_service_charge');
            $this->db->where('invoice_no',$trans_do);
            $this->db->join('md_district as a','td_service_charge.colc_brn=a.district_code','left');
            $q=$this->db->get();
            return $q->result();
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
            if($this->db->update('td_htc_rent_collection', $input)){
                return 1;
            }else{
                return 0;
            }
        }


    }


    // e.id as godownid ,
    // e.gdn_name,
    // e.gdn_addr,
    // e.gdn_dist,
    // g.district_name as godownDist,
    // e.sac_code,
    // e.cnct_person,
    // e.cnct_no,
    // td_rent_collection.godown_id,
?>