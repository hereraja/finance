<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        //$this->db2 = $this->load->database('seconddb', TRUE);
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
    public function f_selects($table, $select = NULL, $where = NULL, $type=NULL)   // For fertilizer Database
    {

        $db2 = $this->load->database('seconddb', TRUE);
        if (isset($select)) {
            $db2->select($select);
        }

        if (isset($where)) {
            $db2->where($where);
        }

        $value = $db2->get($table);

        if ($type == 1) {
            return $value->row();
        } else {
            return $value->result();
        }
    }

    public function js_get_sale_rate($br_cd, $comp_id, $ro_dt, $prod_id)
    {
        $db2 = $this->load->database('seconddb', TRUE);
        $sql = $db2->query("SELECT a.catg_id,b.cate_desc
									from  mm_sale_rate a,
	   					                  mm_category b    							   							
					                     where  a.catg_id = b.sl_no
					                     and a.district='$br_cd'
			                             and a.comp_id='$comp_id'
			                             and a.prod_id ='$prod_id'
			                             and a.frm_dt =(select  max(frm_dt) from mm_sale_rate where frm_dt<='$ro_dt' 
													and district='$br_cd'
													and comp_id='$comp_id'
													and prod_id ='$prod_id')");

        return $sql->result();
    }
    public function js_get_stock_qty($ro)
    {
        $db2 = $this->load->database('seconddb', TRUE);
        $sql = $db2->query("SELECT a.stock_qty -  (select  ifnull(sum(qty) ,0) from td_sale where sale_ro ='$ro') stkqty,a.prod_id ,b.gst_rt ,b.prod_id,b.prod_desc,a.unit,c.unit_name FROM td_purchase a ,mm_product b ,mm_unit c WHERE a.prod_id=b.prod_id and a.unit=c.id and  a.ro_no = '$ro'");
        return $sql->row();
    }

    public function js_get_stock_point($ro_no)
    {
        $db2 = $this->load->database('seconddb', TRUE);
        $query = $db2->query("select a.soc_id,a.soc_name
									from  mm_ferti_soc a,td_purchase b    							   							
									where  a.soc_id = b.stock_point
									and    a.stock_point_flag = 'Y'
									and    b.ro_no            = '$ro_no' ");
        return $query->row();
    }

    public function f_get_adv_dtls($recv_no)
    {
        $db2 = $this->load->database('seconddb', TRUE);
        $data   =   $db2->query("select  a.trans_dt ,a.sl_no,a.fin_yr,a.branch_id,a.soc_id,a.receipt_no,
			a.trans_type,a.adv_amt,a.bank,a.remarks,a.inv_no,a.ro_no,a.created_by,a.created_dt,b.bank_name,b.ac_no,
			a.cshbnk_flag
			from   tdf_advance a,mm_feri_bank b
			where  a.bank=b.sl_no
			and receipt_no = '$recv_no'");
        $result = $data->row();
        return $result;
    }
    /******************************* */
    function f_get_purappvoucher($vid)
    {
        $sql = "SELECT voucher_id,voucher_date,trans_dt,trans_no,transfer_type,ins_no,ins_dt,bank_name ,approval_status ,created_dt,created_by,
		       voucher_type
               FROM td_vouchers
               WHERE  voucher_id='$vid'
			    and approval_status IN('U','H')
			    GROUP BY voucher_id,voucher_date,trans_no,transfer_type,ins_no,ins_dt,bank_name,approval_status
               order by voucher_date ";

        $query  = $this->db->query($sql);

        return $query->result();
    }

    function f_get_purappjnl($vid)
    {
        $sql = "SELECT a.voucher_id, a.voucher_date,a.sl_no,a.remarks,a.amount,b.ac_name,a.dr_cr_flag,
                 a.voucher_type
				 FROM td_vouchers a,md_achead b
				 WHERE a.acc_code=b.sl_no 
				and  voucher_id='$vid'
				 order by a.voucher_date,a.sl_no";
        $query  = $this->db->query($sql);

        return $query->result();
    }

    /******************************* */
    function f_get_voucher($frm_date, $to_date, $fin_id, $branch_id,$unit)
    {
		if($unit == 0){
		$and ='';
		}else{
         $and ='and unit_id='.$unit;
		}
		$sql = "SELECT voucher_id,voucher_date,trans_dt,trans_no,transfer_type,ins_no,ins_dt,bank_name,voucher_type ,approval_status,created_by,created_dt,approved_by,approved_dt
               FROM td_vouchers
               WHERE voucher_date >= '$frm_date' AND voucher_date <= '$to_date'
			   and branch_id='$branch_id'
			   $and
			   GROUP BY voucher_id,voucher_date,trans_no,transfer_type,ins_no,ins_dt,bank_name
               order by voucher_date ";
         
        $query  = $this->db->query($sql);

        return $query->result();
    }

    function f_get_advjnl($frm_date, $to_date, $fin_id, $branch_id)
    {
        $sql = "SELECT a.voucher_id, a.voucher_date,a.sl_no,a.remarks,a.amount,b.ac_name,a.dr_cr_flag,
                 a.voucher_type
				 FROM td_vouchers a,md_achead b
				 WHERE a.acc_code=b.sl_no 
				 and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
				 and a.branch_id='$branch_id'
				 order by a.voucher_date,a.sl_no";
        $query  = $this->db->query($sql);

        return $query->result();
    }
    /********************************** */
    function f_get_voucher_dtls($v_id)
    {
        $sql = "SELECT voucher_id,voucher_date,trans_dt,trans_no,transfer_type,ins_no,ins_dt,bank_name FROM td_vouchers
               WHERE voucher_id='$v_id'
               and approval_status!='H'
			   GROUP BY voucher_id,voucher_date,trans_no,transfer_type,ins_no,ins_dt,bank_name
               order by voucher_date ";

        $query  = $this->db->query($sql);

        return $query->result();
    }
    function f_get_advjnl_dtls($v_id)
    {
        $sql = "SELECT a.voucher_id, a.voucher_date,a.sl_no,a.remarks,a.amount,b.ac_name,a.dr_cr_flag,
                 a.voucher_type
				 FROM td_vouchers a,md_achead b
				 WHERE a.acc_code=b.sl_no 
                 and voucher_id='$v_id'
				 and a.approval_status!='H'
				
				 order by a.voucher_date,a.sl_no";
        $query  = $this->db->query($sql);

        return $query->result();
    }

    /************************************ */
    function f_get_crjnl($frm_date, $to_date, $fin_yr)
    {
        $sql = "SELECT a.voucher_id, a.voucher_date,a.sl_no,a.remarks,a.amount,b.ac_name,a.dr_cr_flag,
                 a.voucher_type
         FROM td_vouchers a,md_achead b
          WHERE a.acc_code=b.sl_no 
          and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
          and a.voucher_type='CRN'
        
          order by a.voucher_date,a.sl_no ";

        $query  = $this->db->query($sql);

        return $query->result();
    }


    function f_get_sljnl($frm_date, $to_date, $fin_yr)
    {
        $sql = "SELECT a.voucher_id, a.voucher_date,a.sl_no,a.remarks,a.amount,b.ac_name,a.dr_cr_flag,
                 a.voucher_type
         FROM td_vouchers a,md_achead b
          WHERE a.acc_code=b.sl_no 
          and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
          and a.voucher_type='SL'
        
          order by a.voucher_id,a.sl_no,a.dr_cr_flag,a.voucher_date ";

        $query  = $this->db->query($sql);

        return $query->result();
    }

    function f_get_purjnl($frm_date, $to_date, $fin_yr)
    {
        $sql = "SELECT a.voucher_id, a.voucher_date,a.sl_no,a.remarks,a.amount,b.ac_name,a.dr_cr_flag,
                 a.voucher_type
         FROM td_vouchers a,md_achead b
          WHERE a.acc_code=b.sl_no 
          and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
          and a.voucher_type='PUR'
        
          order by a.voucher_id,a.sl_no,a.dr_cr_flag,a.voucher_date ";

        $query  = $this->db->query($sql);

        return $query->result();
    }


    public function f_get_cashjrnl_prt($receipt_no)
    {

        $sql = $this->db->query(" select  a.voucher_date,a.voucher_id,a.voucher_type,a.amount,a.transfer_type,
                           a.trans_no,a.trans_dt, a.ins_no,a.ins_dt,a.dr_cr_flag,a.acc_code,c.ac_name,
                           c.benfed_ac_code,
                           a.bank_name,a.remarks,b.district_name as branch_name,a.approval_status,a.created_by,a.created_dt,
                           a.approved_dt,a.approved_by
                             from td_vouchers a,md_district b,md_achead c
                             where a.voucher_id='$receipt_no'
                             and a.acc_code=c.sl_no
                             and a.branch_id=b.district_code
                             ORDER BY a.dr_cr_flag ASC");
        return $sql->result();
    }

    public function f_get_acccodedtls()
    {

        $sql = $this->db->query("Select  a.sl_no,a.benfed_ac_code,b.name as main_gr,c.name as sub_gr,a.ac_name,b.type 
                            from md_achead a,  mda_mngroup b,mda_subgroub c
                            where a.mngr_id=b.sl_no
                            and a.subgr_id=c.sl_no
                            and c.mngr_id=b.sl_no
                            order by b.type,b.sl_no,c.sl_no,a.benfed_ac_code");

        return $sql->result();
    }

    function f_get_acheaddeatil()
    {
        $this->db->select("sl_no,ac_name,benfed_ac_code");
        $this->db->from("md_achead");
        $br_id = $this->session->userdata('loggedin')['branch_id'];
        $this->db->where_in('br_id', array($br_id, 0));
        $this->db->order_by('ac_name');
        return $this->db->get()->result();
    }
    function f_get_trailbal($frm_date, $to_date, $op_dt, $type)
    {



        /* $sql ="select sum(op_dr)op_dr, sum(op_cr)op_cr, sum(dr_amt)dr_amt,
		      sum(cr_amt)cr_amt,ac_name,type,dr_cr_flag,benfed_ac_code,mngr_id
           
              from (
SELECT 0 op_dr,0 op_cr,if(dr_cr_flag='Dr',sum(a.amount),0)as dr_amt,b.mngr_id ,
		       if(dr_cr_flag='Cr',sum(a.amount),0)as cr_amt,b.ac_name,c.type,a.dr_cr_flag,b.benfed_ac_code
               FROM td_vouchers a,md_achead b,mda_mngroup c,td_opening d
               WHERE a.acc_code=b.sl_no
               and b.sl_no=d.acc_code
               and   b.mngr_id = c.sl_no and
			   a.voucher_date >=  '$frm_date' AND a.voucher_date <= '$to_date'
               group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id


 union 
              select if(trans_flag='DR',amount,0),if(trans_flag='CR',amount,0),0,b.mngr_id,0 ,b.ac_name,c.type,a.trans_flag,b.benfed_ac_code
               from  td_opening a,md_achead b,mda_mngroup c mda_subgroub
               WHERE a.acc_code=b.sl_no
              
               and   b.mngr_id = c.sl_no 
               and  balance_dt='$op_dt'
group by b.mngr_id,b.ac_name,c.type,a.trans_flag,b.benfed_ac_code)a
                  group by ac_name,type,benfed_ac_code,mngr_id" ;*/

// =========================================================================
$dmo = date('m-d', strtotime($frm_date));
if($dmo=='04-01'){


    $sql = "select sum(op_dr)op_dr,sum(op_cr)op_cr,sum(dr_amt)dr_amt,sum(cr_amt)cr_amt,mngr_id, ac_name,dr_cr_flag,type,benfed_ac_code
from(
SELECT sum(op_dr) op_dr,sum(op_cr)op_cr ,0 dr_amt,0 cr_amt,mngr_id,
ac_name,dr_cr_flag,type,benfed_ac_code from( select sum(op_dr)op_dr, sum(op_cr)op_cr,sum(trans_dr)trans_dr , sum(trans_cr)trans_cr,mngr_id, ac_name,type,dr_cr_flag,benfed_ac_code
from(SELECT 0 op_dr,0 op_cr,sum(if(a.dr_cr_flag='DR',a.amount,0 ))trans_dr , sum(if(a.dr_cr_flag='CR',a.amount,0 ))trans_cr,b.mngr_id, b.ac_name,c.type,
UPPER(a.dr_cr_flag)dr_cr_flag,b.benfed_ac_code
FROM td_vouchers a ,md_achead b,mda_mngroup c
WHERE a.acc_code=b.sl_no
and b.mngr_id = c.sl_no
and a.trans_dt>='$op_dt'
AND a.trans_dt<='$frm_date' and a.approval_status ='A'
group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id
union
SELECT if(d.trans_flag='DR',d.amount,0),if(d.trans_flag='CR',d.amount,0),0 ,0 ,b.mngr_id, b.ac_name,c.type,UPPER(d.trans_flag),b.benfed_ac_code
from md_achead b,mda_mngroup c,td_opening d
where d.balance_dt=(select max(balance_dt) from td_opening where balance_dt<='$frm_date')
and b.mngr_id = c.sl_no and b.sl_no=d.acc_code
group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id)b
group by mngr_id, ac_name,type,benfed_ac_code )a
group by benfed_ac_code
union
SELECT 0 op_dr,0 op_cr,sum(if(dr_cr_flag='Dr',a.amount,0))as dr_amt, sum(if(dr_cr_flag='Cr',a.amount,0))as cr_amt,b.mngr_id , b.ac_name,
a.dr_cr_flag,c.type,b.benfed_ac_code
FROM td_vouchers a,md_achead b,mda_mngroup c
WHERE a.acc_code=b.sl_no and b.mngr_id = c.sl_no
and a.voucher_date >= '$frm_date'
and a.approval_status = 'A'
AND a.voucher_date <= '$to_date'
group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id)C
 where type in (" . $type . ")
group by mngr_id, ac_name,type,benfed_ac_code
order by type,ac_name";

}else{

// ===========================================================================
        $sql = " select sum(op_dr)op_dr,sum(op_cr)op_cr,sum(dr_amt)dr_amt,sum(cr_amt)cr_amt,mngr_id, ac_name,dr_cr_flag,type,benfed_ac_code 
from(
SELECT if(type=2,sum(op_dr)-sum(op_cr)+trans_dr-trans_cr,0) op_dr,if(type=1,sum(op_cr)-sum(op_dr)+trans_cr-trans_dr,0)op_cr ,0 dr_amt,0 cr_amt,mngr_id, ac_name,dr_cr_flag,type,benfed_ac_code 
from( 
        select sum(op_dr)op_dr, sum(op_cr)op_cr,sum(trans_dr)trans_dr , sum(trans_cr)trans_cr,mngr_id, ac_name,type,dr_cr_flag,benfed_ac_code 
        from(SELECT 0 op_dr,0 op_cr,sum(if(a.dr_cr_flag='DR',a.amount,0 ))trans_dr , sum(if(a.dr_cr_flag='CR',a.amount,0 ))trans_cr,b.mngr_id,    
          b.ac_name,c.type,UPPER(a.dr_cr_flag)dr_cr_flag,b.benfed_ac_code 
          FROM td_vouchers a ,md_achead b,mda_mngroup c
          WHERE a.acc_code=b.sl_no 
          and b.mngr_id = c.sl_no 
          and a.trans_dt>='$op_dt' 
          AND a.trans_dt<='$frm_date' 
          and a.approval_status ='A'
          group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id 
          union 
          SELECT if(d.trans_flag='DR',d.amount,0),if(d.trans_flag='CR',d.amount,0),0 ,0 ,b.mngr_id, b.ac_name,c.type,UPPER(d.trans_flag),b.benfed_ac_code 
          from md_achead b,mda_mngroup c,td_opening d 
          where d.balance_dt=(select max(balance_dt) from td_opening 
                           where balance_dt<='$frm_date') 
          and b.mngr_id = c.sl_no and b.sl_no=d.acc_code group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id)b group by mngr_id, ac_name,type,benfed_ac_code )a
          group by benfed_ac_code 
union 
SELECT 0 op_dr,0 op_cr,sum(if(dr_cr_flag='Dr',a.amount,0))as dr_amt, sum(if(dr_cr_flag='Cr',a.amount,0))as cr_amt,b.mngr_id ,
b.ac_name,a.dr_cr_flag,c.type,b.benfed_ac_code
FROM td_vouchers a,md_achead b,mda_mngroup c 
WHERE a.acc_code=b.sl_no and b.mngr_id = c.sl_no and a.voucher_date >= '$frm_date'
and a.approval_status = 'A'
AND a.voucher_date <= '$to_date' group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id)C
where type in (" . $type . ")
group by mngr_id, ac_name,type,benfed_ac_code
order by type,ac_name";


}
        $query  = $this->db->query($sql);
        return $query->result();
    }



   
    function f_get_trailbal_subgroup($frm_date, $to_date, $op_dt, $type,$subgroupId)
    {


        $dmo = date('m-d', strtotime($frm_date));
if($dmo=='04-01'){

 
    $sql = "select sum(op_dr)op_dr,sum(op_cr)op_cr,sum(dr_amt)dr_amt,sum(cr_amt)cr_amt,mngr_id, ac_name,dr_cr_flag,type,benfed_ac_code
from( SELECT sum(op_dr) op_dr,sum(op_cr)op_cr ,0 dr_amt,0 cr_amt,mngr_id, ac_name,dr_cr_flag,type,benfed_ac_code
from( select sum(op_dr)op_dr, sum(op_cr)op_cr,sum(trans_dr)trans_dr , sum(trans_cr)trans_cr,mngr_id, ac_name,type,dr_cr_flag,benfed_ac_code
from(SELECT 0 op_dr,0 op_cr,sum(if(a.dr_cr_flag='DR',a.amount,0 ))trans_dr , sum(if(a.dr_cr_flag='CR',a.amount,0 ))trans_cr,
b.mngr_id, b.ac_name,c.type, UPPER(a.dr_cr_flag)dr_cr_flag,b.benfed_ac_code
FROM td_vouchers a ,md_achead b,mda_mngroup c,mda_subgroub d
WHERE a.acc_code=b.sl_no and c.sl_no= d.mngr_id and d.sl_no='$subgroupId'
     AND b.subgr_id =d.sl_no
and b.mngr_id = c.sl_no and a.trans_dt>='$op_dt'
AND a.trans_dt<='$frm_date'
and a.approval_status ='A'
group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id
union
SELECT if(d.trans_flag='DR',d.amount,0),if(d.trans_flag='CR',d.amount,0),0 ,0 ,b.mngr_id, b.ac_name,c.type,UPPER(d.trans_flag),b.benfed_ac_code
from md_achead b,mda_mngroup c,td_opening d, mda_subgroub e
     where d.balance_dt=(select max(balance_dt)
from td_opening where balance_dt<='$frm_date')
and b.mngr_id = c.sl_no and b.sl_no=d.acc_code and c.sl_no= e.mngr_id and e.sl_no='$subgroupId'
     AND b.subgr_id =e.sl_no
group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id)b
group by mngr_id, ac_name,type,benfed_ac_code )a
group by benfed_ac_code
union
SELECT 0 op_dr,0 op_cr,sum(if(dr_cr_flag='Dr',a.amount,0))as dr_amt, sum(if(dr_cr_flag='Cr',a.amount,0))as cr_amt,b.mngr_id ,
b.ac_name, a.dr_cr_flag,c.type,b.benfed_ac_code
FROM td_vouchers a,md_achead b,mda_mngroup c ,mda_subgroub d
WHERE a.acc_code=b.sl_no
and b.mngr_id = c.sl_no
AND b.subgr_id =d.sl_no
and a.voucher_date >= '$frm_date'
and a.approval_status = 'A'
AND a.voucher_date <= '$to_date'
and c.sl_no= d.mngr_id and d.sl_no='$subgroupId'
group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id)C
where type in (" . $type . ")
group by mngr_id, ac_name,type,benfed_ac_code
order by type,ac_name";

}else{

        $sql = " select sum(op_dr)op_dr,sum(op_cr)op_cr,sum(dr_amt)dr_amt,sum(cr_amt)cr_amt,mngr_id, ac_name,dr_cr_flag,type,benfed_ac_code 
from(
SELECT if(type=2,sum(op_dr)-sum(op_cr)+trans_dr-trans_cr,0) op_dr,if(type=1,sum(op_cr)-sum(op_dr)+trans_cr-trans_dr,0)op_cr ,0 dr_amt,0 cr_amt,mngr_id, ac_name,dr_cr_flag,type,benfed_ac_code 
from( 
        select sum(op_dr)op_dr, sum(op_cr)op_cr,sum(trans_dr)trans_dr , sum(trans_cr)trans_cr,mngr_id, ac_name,type,dr_cr_flag,benfed_ac_code 
        from(SELECT 0 op_dr,0 op_cr,sum(if(a.dr_cr_flag='DR',a.amount,0 ))trans_dr , sum(if(a.dr_cr_flag='CR',a.amount,0 ))trans_cr,b.mngr_id,    
          b.ac_name,c.type,UPPER(a.dr_cr_flag)dr_cr_flag,b.benfed_ac_code 
          FROM td_vouchers a ,md_achead b,mda_mngroup c,mda_subgroub d
          WHERE a.acc_code=b.sl_no and b.mngr_id = c.sl_no and a.trans_dt>='$op_dt' AND a.trans_dt<='$frm_date' 
          and a.approval_status ='A'
          and c.sl_no=  d.mngr_id
          and d.sl_no='$subgroupId'
          and b.subgr_id=d.sl_no
          group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id 
          union 
          SELECT if(d.trans_flag='DR',d.amount,0),if(d.trans_flag='CR',d.amount,0),0 ,0 ,b.mngr_id, b.ac_name,c.type,UPPER(d.trans_flag),b.benfed_ac_code 
          from md_achead b,mda_mngroup c,td_opening d, mda_subgroub e
          where d.balance_dt=(select max(balance_dt) from td_opening 
                           where balance_dt<='$frm_date') 
          and b.mngr_id = c.sl_no 
          and b.sl_no=d.acc_code
          and b.subgr_id=e.sl_no
          
          and c.sl_no=  e.mngr_id
          and e.sl_no='$subgroupId'

          group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id)b group by mngr_id, ac_name,type,benfed_ac_code )a
          group by benfed_ac_code 
union 
SELECT 0 op_dr,0 op_cr,sum(if(dr_cr_flag='Dr',a.amount,0))as dr_amt, sum(if(dr_cr_flag='Cr',a.amount,0))as cr_amt,b.mngr_id ,
b.ac_name,a.dr_cr_flag,c.type,b.benfed_ac_code
FROM td_vouchers a,md_achead b,mda_mngroup c,mda_subgroub d 
WHERE a.acc_code=b.sl_no and b.mngr_id = c.sl_no and a.voucher_date >= '$frm_date'
and a.approval_status = 'A'
and c.sl_no=  d.mngr_id
and d.sl_no='$subgroupId'
and b.subgr_id=d.sl_no
AND a.voucher_date <= '$to_date' group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id)C
where type in (" . $type . ")
group by mngr_id, ac_name,type,benfed_ac_code
order by type,ac_name";

}
        $query  = $this->db->query($sql);
        return $query->result();
    }

    function f_get_trailbal_group($frm_date, $to_date, $op_dt, $type,$group_id)
    {
        $dmo = date('m-d', strtotime($frm_date));
        // if($dmo=='04-01'){
        //     $sql = "select sum(op_dr)op_dr,sum(op_cr)op_cr,sum(dr_amt)dr_amt,sum(cr_amt)cr_amt,mngr_id, ac_name,dr_cr_flag,type,benfed_ac_code
        //     from( SELECT sum(op_dr) op_dr,sum(op_cr)op_cr ,0 dr_amt,0 cr_amt,mngr_id, ac_name,dr_cr_flag,type,benfed_ac_code
        //     from( select sum(op_dr)op_dr, sum(op_cr)op_cr,sum(trans_dr)trans_dr , sum(trans_cr)trans_cr,mngr_id, ac_name,type,dr_cr_flag,benfed_ac_code
        //     from(SELECT 0 op_dr,0 op_cr,sum(if(a.dr_cr_flag='DR',a.amount,0 ))trans_dr , sum(if(a.dr_cr_flag='CR',a.amount,0 ))trans_cr,
        //     b.mngr_id, b.ac_name,c.type, UPPER(a.dr_cr_flag)dr_cr_flag,b.benfed_ac_code
        //     FROM td_vouchers a ,md_achead b,mda_mngroup c,mda_subgroub d
        //     WHERE a.acc_code=b.sl_no and c.sl_no= d.mngr_id and d.sl_no='$group_id'
        //         AND b.subgr_id =d.sl_no
        //     and b.mngr_id = c.sl_no and a.trans_dt>='$op_dt'
        //     AND a.trans_dt<='$frm_date'
        //     and a.approval_status ='A'
        //     group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id
        //     union
        //     SELECT if(d.trans_flag='DR',d.amount,0),if(d.trans_flag='CR',d.amount,0),0 ,0 ,b.mngr_id, b.ac_name,c.type,UPPER(d.trans_flag),b.benfed_ac_code
        //     from md_achead b,mda_mngroup c,td_opening d, mda_subgroub e
        //         where d.balance_dt=(select max(balance_dt)
        //     from td_opening where balance_dt<='$frm_date')
        //     and b.mngr_id = c.sl_no and b.sl_no=d.acc_code and c.sl_no= e.mngr_id and e.sl_no='$group_id'
        //         AND b.subgr_id =e.sl_no
        //     group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id)b
        //     group by mngr_id, ac_name,type,benfed_ac_code )a
        //     group by benfed_ac_code
        //     union
        //     SELECT 0 op_dr,0 op_cr,sum(if(dr_cr_flag='Dr',a.amount,0))as dr_amt, sum(if(dr_cr_flag='Cr',a.amount,0))as cr_amt,b.mngr_id ,
        //     b.ac_name, a.dr_cr_flag,c.type,b.benfed_ac_code
        //     FROM td_vouchers a,md_achead b,mda_mngroup c ,mda_subgroub d
        //     WHERE a.acc_code=b.sl_no
        //     and b.mngr_id = c.sl_no
        //     AND b.subgr_id =d.sl_no
        //     and a.voucher_date >= '$frm_date'
        //     and a.approval_status = 'A'
        //     AND a.voucher_date <= '$to_date'
        //     and c.sl_no= d.mngr_id and d.sl_no='$group_id'
        //     group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id)C
        //     where type in (" . $type . ")
        //     group by mngr_id, ac_name,type,benfed_ac_code
        //     order by type,ac_name";

        // }else{

                $sql = "select sum(op_dr)op_dr,sum(op_cr)op_cr,sum(dr_amt)dr_amt,sum(cr_amt)cr_amt,mngr_id, name,dr_cr_flag,type
                    from(
                    SELECT if(type=2,sum(op_dr)-sum(op_cr)+trans_dr-trans_cr,0) op_dr,if(type=1,sum(op_cr)-sum(op_dr)+trans_cr-trans_dr,0)op_cr ,0 dr_amt,0 cr_amt,mngr_id, name,dr_cr_flag,type
                    from( select sum(op_dr)op_dr, sum(op_cr)op_cr,sum(trans_dr)trans_dr , sum(trans_cr)trans_cr,mngr_id, name,type,dr_cr_flag
                    from(
                    SELECT 0 op_dr,0 op_cr,sum(if(a.dr_cr_flag='DR',a.amount,0 ))trans_dr , sum(if(a.dr_cr_flag='CR',a.amount,0 ))trans_cr,b.mngr_id, d.name,c.type,UPPER(a.dr_cr_flag)dr_cr_flag
                    FROM td_vouchers a ,md_achead b,mda_mngroup c,mda_subgroub d
                    WHERE a.acc_code=b.sl_no
                    and b.mngr_id = c.sl_no and a.trans_dt>='$op_dt'
                    AND a.trans_dt<='$frm_date'
                    and a.approval_status ='A'
                    and c.sl_no= d.mngr_id
                    and b.subgr_id=d.sl_no
                        and c.sl_no=$group_id
                    group by d.name,c.type,b.mngr_id
                    union
                    SELECT if(d.trans_flag='DR',d.amount,0),if(d.trans_flag='CR',d.amount,0),0 ,0 ,b.mngr_id, e.name,c.type,UPPER(d.trans_flag)
                    from md_achead b,mda_mngroup c,td_opening d, mda_subgroub e
                    where d.balance_dt=(select max(balance_dt)
                    from td_opening where balance_dt<='$frm_date')
                    and b.mngr_id = c.sl_no
                    and b.sl_no=d.acc_code
                    and b.subgr_id=e.sl_no
                    and c.sl_no= e.mngr_id
                        and c.sl_no=$group_id
                    group by e.name,c.type,b.mngr_id)b
                    group by mngr_id, name,type)a

                    union
                    SELECT 0 op_dr,0 op_cr,sum(if(dr_cr_flag='Dr',a.amount,0))as dr_amt, sum(if(dr_cr_flag='Cr',a.amount,0))as cr_amt,b.mngr_id , d.name,a.dr_cr_flag,c.type
                    FROM td_vouchers a,md_achead b,mda_mngroup c,mda_subgroub d
                    WHERE a.acc_code=b.sl_no
                    and b.mngr_id = c.sl_no
                    and a.voucher_date >= '$frm_date'
                    and a.approval_status = 'A'
                    and c.sl_no= d.mngr_id
                    and b.subgr_id=d.sl_no
                        and c.sl_no=$group_id
                    AND a.voucher_date <= '$to_date'
                    group by d.name,a.dr_cr_flag,d.name,b.mngr_id)C
                    where type in (". $type . ")
                    group by mngr_id, name,type
                    order by type,name";
       // }
        $query  = $this->db->query($sql);
        return $query->result();
    }



    function f_get_trailbal_br($frm_date, $to_date, $op_dt, $brid, $type,$unit)
    {
     if($unit != 0){
	 $and = 'and a.unit_id ='.$unit;
	 }else{
	 $and = '';
	 }
// =========================================================================
    $dmo = date('m-d', strtotime($frm_date));
    if($dmo=='04-01'){

    $sql = "select sum(op_dr)op_dr,sum(op_cr)op_cr,sum(dr_amt)dr_amt,sum(cr_amt)cr_amt,mngr_id, ac_name,dr_cr_flag,type,benfed_ac_code
        from( SELECT sum(op_dr) op_dr,sum(op_cr)op_cr ,0 dr_amt,0 cr_amt,mngr_id, ac_name,dr_cr_flag,type,benfed_ac_code
        from( select sum(op_dr)op_dr, sum(op_cr)op_cr,sum(trans_dr)trans_dr , sum(trans_cr)trans_cr,mngr_id, ac_name,type,dr_cr_flag,benfed_ac_code
        from(SELECT 0 op_dr,0 op_cr,sum(if(a.dr_cr_flag='DR',a.amount,0 ))trans_dr , sum(if(a.dr_cr_flag='CR',a.amount,0 ))trans_cr,b.mngr_id, b.ac_name,c.type,
        UPPER(a.dr_cr_flag)dr_cr_flag,b.benfed_ac_code
        FROM td_vouchers a ,md_achead b,mda_mngroup c
        WHERE a.acc_code=b.sl_no and b.mngr_id = c.sl_no
        and a.trans_dt>='$op_dt'
        AND a.trans_dt<='$frm_date'
        and a.approval_status ='A'
        AND a.branch_id=$brid
		$and
        group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id
        union
        SELECT if(d.trans_flag='DR',d.amount,0),if(d.trans_flag='CR',d.amount,0),0 ,0 ,b.mngr_id, b.ac_name,c.type,UPPER(d.trans_flag),b.benfed_ac_code
        from md_achead b,mda_mngroup c,td_opening d
        where d.balance_dt=(select max(balance_dt)
        from td_opening
        where balance_dt<='$frm_date')
        and b.mngr_id = c.sl_no
        and b.sl_no=d.acc_code
        AND d.br_id=$brid
        group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id)b
        group by mngr_id, ac_name,type,benfed_ac_code )a
        group by benfed_ac_code
        union
        SELECT 0 op_dr,0 op_cr,sum(if(dr_cr_flag='Dr',a.amount,0))as dr_amt, sum(if(dr_cr_flag='Cr',a.amount,0))as cr_amt,b.mngr_id , b.ac_name,
        a.dr_cr_flag,c.type,b.benfed_ac_code
        FROM td_vouchers a,md_achead b,mda_mngroup c
        WHERE a.acc_code=b.sl_no and b.mngr_id = c.sl_no
        and a.voucher_date >= '$frm_date' and a.approval_status = 'A'
        AND a.voucher_date <= '$to_date'
        AND a.branch_id =$brid
		$and
        group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id)C
        where type in (" . $type . ")
        group by mngr_id, ac_name,type,benfed_ac_code
        order by type,ac_name";

    }else{
        
        $sql = "select sum(op_dr)op_dr,sum(op_cr)op_cr,sum(dr_amt)dr_amt,sum(cr_amt)cr_amt,mngr_id, ac_name,dr_cr_flag,type,benfed_ac_code
        from( SELECT if(type=2,sum(op_dr)-sum(op_cr)+trans_dr-trans_cr,0) op_dr,if(type=1,sum(op_cr)-sum(op_dr)+trans_cr-trans_dr,0)op_cr ,0 dr_amt,0 cr_amt,mngr_id, ac_name,dr_cr_flag,type,benfed_ac_code
        from( select sum(op_dr)op_dr, sum(op_cr)op_cr,sum(trans_dr)trans_dr , sum(trans_cr)trans_cr,mngr_id, ac_name,type,dr_cr_flag,benfed_ac_code
        from(SELECT 0 op_dr,0 op_cr,sum(if(a.dr_cr_flag='DR',a.amount,0 ))trans_dr , sum(if(a.dr_cr_flag='CR',a.amount,0 ))trans_cr,b.mngr_id, b.ac_name,c.type,UPPER(a.dr_cr_flag)dr_cr_flag,b.benfed_ac_code
        FROM td_vouchers a ,md_achead b,mda_mngroup c
        WHERE a.acc_code=b.sl_no
        and b.mngr_id = c.sl_no and a.trans_dt>='$op_dt'
        AND a.trans_dt<='$frm_date'
        and a.approval_status='A' and a.branch_id=$brid
        group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id
        union
        SELECT if(d.trans_flag='DR',d.amount,0),if(d.trans_flag='CR',d.amount,0),0 ,0 ,b.mngr_id, b.ac_name,c.type,UPPER(d.trans_flag),b.benfed_ac_code from md_achead b,mda_mngroup c,td_opening d where d.balance_dt=(select max(balance_dt)
        from td_opening
        where balance_dt<='$frm_date') and b.mngr_id = c.sl_no
        and b.sl_no=d.acc_code and b.br_id=$brid group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id )b group by mngr_id, ac_name,type,benfed_ac_code )a group by benfed_ac_code
        union
        SELECT 0 op_dr,0 op_cr,sum(if(dr_cr_flag='Dr',a.amount,0))as dr_amt, sum(if(dr_cr_flag='Cr',a.amount,0))as cr_amt,b.mngr_id , b.ac_name,a.dr_cr_flag,c.type,b.benfed_ac_code
        FROM td_vouchers a,md_achead b,mda_mngroup c
        WHERE a.acc_code=b.sl_no and b.mngr_id = c.sl_no
        and a.voucher_date >= '$frm_date'
        AND a.voucher_date <= '$to_date'
        And a.branch_id=$brid and a.approval_status='A'
        AND a.branch_id =$brid
        group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id )C
        where type in (1,2,3,4)
        group by mngr_id, ac_name,type,benfed_ac_code
        order by type, ac_name";

    }
        $query  = $this->db->query($sql);
        return $query->result();
    }


    /*function f_get_trailbalsubgroup($frm_date,$to_date){
		
		$sql ="SELECT if(dr_cr_flag='Dr',sum(a.amount),0)as dr_amt,b.subgr_id,
		       if(dr_cr_flag='Cr',sum(a.amount),0)as cr_amt,b.ac_name,c.type,a.dr_cr_flag
               FROM td_vouchers a,md_achead b,mda_mngroup c
               WHERE a.acc_code=b.sl_no
               and a.approval_status ='A'
               and   b.mngr_id = c.sl_no and
			   a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
               group by b.ac_name,a.dr_cr_flag,b.subgr_id" ;
        $query  = $this->db->query($sql);
        return $query->result();
	}*/

    function f_get_group_total($frm_date, $to_date)
    {

        $sql  = "select name,sum(dr_amt) as dr_amt,sum(cr_amt)as cr_amt,mngr_id from (SELECT if(dr_cr_flag='Dr',sum(a.amount),0)as dr_amt, if(dr_cr_flag='Cr',sum(a.amount),0)as cr_amt,a.dr_cr_flag,c.name,b.mngr_id FROM mda_mngroup c,td_vouchers a,md_achead b WHERE c.sl_no=b.mngr_id 
        and a.acc_code=b.sl_no and a.voucher_date >= '$frm_date'
         AND a.voucher_date <= '$to_date' 
         and a.approval_status!='H'
         group by c.name,a.dr_cr_flag,b.mngr_id) tt group by name,mngr_id";
        $query  = $this->db->query($sql);
        return $query->result();
    }

    function f_get_gl($frm_date, $to_date, $acc_head)
    {

        $sql = "SELECT if(dr_cr_flag='Dr',sum(a.amount),0)as dr_amt,b.mngr_id,a.voucher_date,c.type,
		       if(dr_cr_flag='Cr',sum(a.amount),0)as cr_amt,b.ac_name,a.dr_cr_flag
               FROM td_vouchers a,md_achead b,mda_mngroup c
               WHERE a.acc_code=b.sl_no
			   and   b.mngr_id   =c.sl_no
               and a.approval_status!='H'
			   and   b.sl_no   ='$acc_head'
               and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
               group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id,a.voucher_date";
        $query  = $this->db->query($sql);
        return $query->result();
    }

    function f_get_acdeatil($frm_date, $to_date, $acc_head, $branch_id)
    {

        /*$sql ="select a.acc_code,if(dr_cr_flag='Dr',a.amount,0)as dr_amt,a.voucher_date,a.remarks, if(dr_cr_flag='Cr',a.amount,0)as cr_amt,
        a.voucher_id,a.voucher_type,a.dr_cr_flag,b.ac_name,c.type from td_vouchers a,md_achead b,mda_mngroup c 
        where voucher_id in(SELECT a.voucher_id FROM td_vouchers a,md_achead b,mda_mngroup c WHERE a.acc_code=b.sl_no 
        and b.mngr_id =c.sl_no and b.sl_no ='$acc_head' and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date') 
        and a.acc_code !='$acc_head' and a.acc_code = b.sl_no and b.mngr_id = c.sl_no ORDER BY a.voucher_date ASC" ;*/
        $sql = "SELECT d.ac_name,sum(if(dr_cr_flag='Dr',a.amount,0))as dr_amt,a.voucher_date,a.remarks, sum(if(dr_cr_flag='Cr',a.amount,0))as       
	       cr_amt, a.voucher_id,a.voucher_mode,a.dr_cr_flag,c.type
        from td_vouchers a,md_achead b,mda_mngroup c,(SELECT max(acc_code)acc_cd,voucher_id,b.ac_name
                                                      from td_vouchers a,md_achead b
                                                      where a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date' and a.acc_code !='$acc_head' 
                                                      and a.approval_status='A' 
                                                      and a.branch_id=$branch_id
                                                      and voucher_id in(select a.voucher_id
                                                      from td_vouchers a
                                                      where a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date' and a.acc_code ='$acc_head' )
                                                      and acc_code=b.sl_no   
                                                      and a.branch_id=$branch_id
                                                      group by voucher_id)d
         where a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date' and a.acc_code ='$acc_head'
        and a.acc_code = b.sl_no and b.mngr_id = c.sl_no 
        and a.voucher_id=d.voucher_id
        and a.branch_id=$branch_id
        and a.approval_status='A'
        group by d.acc_cd,a.voucher_date,a.remarks, a.voucher_id,a.voucher_mode,a.dr_cr_flag,b.ac_name,c.type  ORDER BY a.voucher_date ASC";
        $query  = $this->db->query($sql);

        return $query->result();
    }



    function f_get_acdeatil_all($frm_date, $to_date, $acc_head)
    {

        /*$sql ="select a.acc_code,if(dr_cr_flag='Dr',a.amount,0)as dr_amt,a.voucher_date,a.remarks, if(dr_cr_flag='Cr',a.amount,0)as cr_amt,
        a.voucher_id,a.voucher_type,a.dr_cr_flag,b.ac_name,c.type from td_vouchers a,md_achead b,mda_mngroup c 
        where voucher_id in(SELECT a.voucher_id FROM td_vouchers a,md_achead b,mda_mngroup c WHERE a.acc_code=b.sl_no 
        and b.mngr_id =c.sl_no and b.sl_no ='$acc_head' and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date') 
        and a.acc_code !='$acc_head' and a.acc_code = b.sl_no and b.mngr_id = c.sl_no ORDER BY a.voucher_date ASC" ;*/
        $sql = "SELECT d.ac_name,sum(if(dr_cr_flag='Dr',a.amount,0))as dr_amt,a.voucher_date,a.remarks, sum(if(dr_cr_flag='Cr',a.amount,0))as       
	       cr_amt, a.voucher_id,a.trans_no,a.voucher_mode,a.dr_cr_flag,c.type
        from td_vouchers a,md_achead b,mda_mngroup c,(SELECT max(acc_code)acc_cd,voucher_id,b.ac_name
                                                      from td_vouchers a,md_achead b
                                                      where a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date' and a.acc_code !='$acc_head' 
                                                      and a.approval_status='A' 
                                                    
                                                      and voucher_id in(select a.voucher_id
                                                      from td_vouchers a
                                                      where a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date' and a.acc_code ='$acc_head' )
                                                      and acc_code=b.sl_no   
                                                    
                                                      group by voucher_id)d
         where a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date' and a.acc_code ='$acc_head'
        and a.acc_code = b.sl_no and b.mngr_id = c.sl_no 
        and a.voucher_id=d.voucher_id
        
        and a.approval_status='A'
        group by d.acc_cd,a.voucher_date,a.remarks, a.voucher_id,a.trans_no,a.voucher_mode,a.dr_cr_flag,b.ac_name,c.type  ORDER BY a.voucher_date ASC";
        $query  = $this->db->query($sql);

        return $query->result();
    }

    //***** Get Opening Balance Of Particular Account Head for Accounts Details Report**************************/

    function get_ope_gl($op_dt, $ope_date, $acc_head)
    {

        /*$sql ="SELECT if(dr_cr_flag='Dr',sum(a.amount),0)as dr_amt,b.mngr_id,
		       if(dr_cr_flag='Cr',sum(a.amount),0)as cr_amt,a.dr_cr_flag as trans_flag,c.type,c.name
               FROM td_vouchers a,md_achead b,mda_mngroup c
               WHERE a.acc_code=b.sl_no
			   and   b.mngr_id   =c.sl_no
			   and   b.sl_no   ='$acc_head'
               and a.voucher_date >='$op_dt' and a.voucher_date <= '$ope_date'
               group by a.dr_cr_flag,b.mngr_id,c.type,c.name" ;  */
        $sql = "SELECT sum(amt)dr_amt,0 cr_amt,type,mngr_id,acc_name, Case WHEN (type=2 or type=3)&& sum(amt) >0 THEN 'DR'
               WHEN (type=2 or type=3)&& sum(amt) <0 THEN 'CR'
                WHEN (type=1 or type=4)&& sum(amt) >0 THEN 'CR'
                WHEN (type=1 or type=4)&& sum(amt) <0 THEN 'DR'
                  ELSE ''
              END as trans_flag
               from(
               select if(((c.type=2 or c.type=3) && trans_flag='DR') or ((c.type=1 or c.type=4) && trans_flag='CR'),a.amount,-1*a.amount)amt,
               c.type,b.mngr_id,a.acc_name from td_opening a,md_achead b,mda_mngroup c WHERE a.acc_code=b.sl_no and b.mngr_id =c.sl_no
               and  acc_code='$acc_head'
               and a.balance_dt='$op_dt'
               union
               select if( type =2 or type= 3,sum(dr_amt)-sum(cr_amt),if(type =1 or type= 4,sum(cr_amt)-sum(dr_amt),0)),
               type,mngr_id,ac_name
               from(
               SELECT if(dr_cr_flag='Dr',sum(a.amount),0)as dr_amt,b.mngr_id, if(dr_cr_flag='Cr',sum(a.amount),0)as cr_amt,a.dr_cr_flag as trans_flag,c.type,b.ac_name
                FROM td_vouchers a,md_achead b,mda_mngroup c WHERE a.acc_code=b.sl_no and b.mngr_id =c.sl_no and b.sl_no ='$acc_head'
               and a.voucher_date >='$op_dt' and a.voucher_date < '$ope_date'
               and a.approval_status='A'
               group by a.dr_cr_flag,b.mngr_id,c.type,b.ac_name)a)b";
        $query  = $this->db->query($sql);
        return $query->row();
    }
    function get_ope_gl_re($ope_date, $acc_head)
    {

        $sql = "SELECT if(trans_flag='DR',sum(a.amount),0)as dr_amt,b.mngr_id,
		       if(trans_flag='CR',sum(a.amount),0)as cr_amt,a.trans_flag,c.type,c.name
               FROM td_opening a,md_achead b,mda_mngroup c
               WHERE a.acc_code=b.sl_no
			   and   b.mngr_id   =c.sl_no
			   and   b.sl_no   ='$acc_head'
               AND a.balance_dt = '$ope_date'
               AND c.type in(1,2,3,4)
               group by a.trans_flag,b.mngr_id,c.type,c.name";
        $query  = $this->db->query($sql);
        return $query->row();
    }
    /*****Day Book Report Blocked On 07/10/2022*** */
    /*function f_get_daybook($frm_date,$to_date){
		$branch_id = $this->session->userdata['loggedin']['branch_id'];
		$sql ="SELECT if(dr_cr_flag='Dr',a.amount,0)as dr_amt,b.mngr_id,a.voucher_id,a.voucher_date,a.voucher_type,
		       if(dr_cr_flag='Cr',a.amount,0)as cr_amt,b.ac_name,a.dr_cr_flag 
               FROM td_vouchers a,md_achead b
               WHERE a.acc_code=b.sl_no
			   and a.branch_id = '$branch_id'
               and a.approval_status='A'
               and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
			   order by a.voucher_date,a.voucher_type" ;  
        $query  = $this->db->query($sql);
        return $query->result();
	}*/

    //Cash Book Report 
    function f_get_cashbook($frm_date, $to_date)
    {
        $branch_id = $this->session->userdata['loggedin']['branch_id'];

        // $sql ="SELECT if(dr_cr_flag='Dr',a.amount,0)as dr_amt,b.mngr_id,a.voucher_id,a.voucher_date,a.voucher_type,
        //        if(dr_cr_flag='Cr',a.amount,0)as cr_amt,b.ac_name,a.dr_cr_flag,b.benfed_ac_code
        //         FROM td_vouchers a,md_achead b
        //         WHERE a.acc_code=b.sl_no
        //          and a.approval_status!='H'
        // 	        and a.branch_id = '$branch_id'
        //           and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
        // 	        order by a.voucher_date,a.voucher_type" ; 

        $sql = "SELECT a.dr_cr_flag,a.voucher_id, IF(a.dr_cr_flag='Dr',sum(a.amount),0)cr_amt, IF(a.dr_cr_flag='Cr',sum(a.amount),0)dr_amt ,b.mngr_id,a.voucher_date,b.benfed_ac_code,b.ac_name
FROM td_vouchers a,md_achead b WHERE a.acc_code=b.sl_no 
AND a.approval_status='A'
and a.voucher_date >= '$frm_date' 
AND a.voucher_date <= '$to_date' 
AND a.branch_id='$branch_id'
AND a.voucher_id in(SELECT a.voucher_id
                    FROM td_vouchers a,md_achead b WHERE a.acc_code=b.sl_no 
                    AND a.approval_status='A'
                    and a.voucher_date >= '$frm_date' 
                    AND a.voucher_date <= '$to_date' 
                    AND a.acc_code=(SELECT sl_no FROM md_achead WHERE mngr_id=6 and subgr_id=56 and br_id='$branch_id')
                    AND a.branch_id='$branch_id'
                    group by a.dr_cr_flag,b.mngr_id,a.voucher_date,b.benfed_ac_code,a.voucher_id)
AND a.acc_code<>(SELECT sl_no FROM md_achead WHERE mngr_id=6 and subgr_id=56 and br_id='$branch_id')
group by a.dr_cr_flag,b.mngr_id,a.voucher_date,b.benfed_ac_code,a.voucher_id ,b.ac_name 
ORDER BY a.voucher_date ASC";



        $query  = $this->db->query($sql);
        return $query->result();
    }

    //Getting opening balance For cash Book  branch wise
    function f_get_cashbook_opbal($opndt, $frm_date)
    {
        $branch_id = $this->session->userdata['loggedin']['branch_id'];
        // $sql =" SELECT amount,trans_flag FROM `td_opening` 
        //          WHERE `benfed_ac_code` =( SELECT `benfed_ac_code`FROM `md_achead` 
        //                                    WHERE `br_id`=$branch_id AND `mngr_id`=6 
        //                                    AND `subgr_id`=56 AND `balance_dt`='$opndt' )" ; 


        /*$sql ="SELECT sum(a.dr_amt)- sum(a.cr_amt) + (SELECT IF(trans_flag='DR' ,amount,-1*amount)
                                                    FROM `td_opening` 
                                                    WHERE `benfed_ac_code` =( SELECT `benfed_ac_code`FROM `md_achead` 
                                                                              WHERE `br_id`='$branch_id' 
                                                                              AND `mngr_id`=6 
                                                                              AND `subgr_id`=56 AND `balance_dt`='$opndt'))as amount,
                   IF(sum(a.dr_amt) - sum(a.cr_amt) + (SELECT IF(trans_flag='DR' ,amount,-1*amount)
                                                        FROM `td_opening` 
                                                        WHERE `benfed_ac_code` =( SELECT `benfed_ac_code`
                                                                                  FROM `md_achead` WHERE `br_id`='$branch_id'
                                                                                  AND `mngr_id`=6 AND `subgr_id`=56 
                                                                                  AND `balance_dt`='2022-04-01'))>0,'DR','CR')as trans_flag                                
      FROM(SELECT IF(dr_cr_flag='Dr',sum(a.amount),0)cr_amt, IF(dr_cr_flag='Cr',sum(a.amount),0)dr_amt 
           FROM `td_vouchers` a
           WHERE a.voucher_date >= '$opndt' 
           AND a.voucher_date < '$frm_date' 
           AND `acc_code`=6 AND `branch_id`='$branch_id'
           GROUP by dr_cr_flag)a";*/

        $sql = "SELECT sum(d.amt)amount,if(sum(d.amt)>0,'DR','CR')trans_flag
from(
select if(((c.type=2 or c.type=3) && trans_flag='DR') or ((c.type=1 or c.type=4) && trans_flag='CR'),a.amount,-1*a.amount)amt, c.type,b.mngr_id,a.acc_name 
from td_opening a,md_achead b,mda_mngroup c 
WHERE a.acc_code=b.sl_no 
and b.mngr_id =c.sl_no
and acc_code= (SELECT sl_no FROM md_achead WHERE mngr_id=6 and subgr_id=56 and br_id='$branch_id')
and a.balance_dt='$opndt' 
union 
select if( type =2 or type= 3,sum(dr_amt)-sum(cr_amt),if(type =1 or type= 4,sum(cr_amt)-sum(dr_amt),0)), type,mngr_id,ac_name 
from( SELECT if(dr_cr_flag='Dr',sum(a.amount),0)as dr_amt,b.mngr_id, if(dr_cr_flag='Cr',sum(a.amount),0)as cr_amt,a.dr_cr_flag as trans_flag,c.type,b.ac_name                                      FROM td_vouchers a,md_achead b,mda_mngroup c
    WHERE a.acc_code=b.sl_no 
    and b.mngr_id =c.sl_no 
    and b.sl_no =(SELECT sl_no FROM md_achead WHERE mngr_id=6 and subgr_id=56 and br_id='$branch_id')                                                           
    and a.voucher_date >='$opndt'                                                                                             
    and a.voucher_date < '$frm_date'                                                                                      
    and a.approval_status='A' 
    group by a.dr_cr_flag,b.mngr_id,c.type,b.ac_name)a)d";

        $query  = $this->db->query($sql);
        return $query->row();
    }
    /***Bank Book Report blocked on 07/10/2022 */
    /*function f_get_bankbook($frm_date,$to_date){
		$branch_id = $this->session->userdata['loggedin']['branch_id'];
		$sql ="SELECT if(dr_cr_flag='Dr',a.amount,0)as dr_amt,b.mngr_id,a.voucher_id,a.voucher_date,a.voucher_type,
		       if(dr_cr_flag='Cr',a.amount,0)as cr_amt,b.ac_name,a.dr_cr_flag
               FROM td_vouchers a,md_achead b
               WHERE a.acc_code=b.sl_no
			   and a.branch_id = '$branch_id'
               and b.BNK_flag  = 'B'
               and a.approval_status!='H'
               and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
			   order by a.voucher_date,a.voucher_type" ;  
        $query  = $this->db->query($sql);
        return $query->result();
	}*/



    function branch_bnk($branch_id)
    {
        return $this->db->where('br_id', $branch_id)->where('BNK_flag', 'B')->get('md_achead')->result();
    }

    function f_get_balsh_mngr_lib($frm_date, $to_date, $op_dt, $brid)
    {
        $sql = "select distinct c.mngr_id,g.name mng_name
            from( SELECT sum(op_dr) op_dr,sum(op_cr)op_cr ,0 dr_amt,0 cr_amt,mngr_id, subgr_id,ac_name,dr_cr_flag,type,benfed_ac_code 
                from( select sum(op_dr)op_dr, sum(op_cr)op_cr,sum(trans_dr)trans_dr , sum(trans_cr)trans_cr,mngr_id, ac_name,type,dr_cr_flag,benfed_ac_code ,subgr_id
            from(SELECT 0 op_dr,0 op_cr,sum(if(a.dr_cr_flag='DR',a.amount,0 ))trans_dr , sum(if(a.dr_cr_flag='CR',a.amount,0 ))trans_cr,b.mngr_id,b.subgr_id, b.ac_name,c.type, UPPER(a.dr_cr_flag)dr_cr_flag,b.benfed_ac_code 
            FROM td_vouchers a ,md_achead b,mda_mngroup c 
            WHERE a.acc_code=b.sl_no and b.mngr_id = c.sl_no 
            and a.trans_dt>='$op_dt' AND a.trans_dt<='$frm_date' and a.approval_status ='A' AND a.branch_id=$brid
            group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id ,b.subgr_id
                union 
                SELECT if(d.trans_flag='DR',d.amount,0),if(d.trans_flag='CR',d.amount,0),0 ,0 ,b.mngr_id, b.subgr_id,b.ac_name,c.type,UPPER(d.trans_flag),b.benfed_ac_code 
                from md_achead b,mda_mngroup c,td_opening d 
            where d.balance_dt=(select max(balance_dt) 
            from td_opening where balance_dt<='$frm_date') and b.mngr_id = c.sl_no and b.sl_no=d.acc_code AND d.br_id=$brid 
                group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id,b.subgr_id)b 
            group by mngr_id, subgr_id,ac_name,type,benfed_ac_code )a                                                                     group by benfed_ac_code 
                union 
                SELECT 0 op_dr,0 op_cr,sum(if(dr_cr_flag='Dr',a.amount,0))as dr_amt, sum(if(dr_cr_flag='Cr',a.amount,0))as cr_amt,b.mngr_id ,b.subgr_id, b.ac_name, a.dr_cr_flag,c.type,b.benfed_ac_code 
                FROM td_vouchers a,md_achead b,mda_mngroup c 
                WHERE a.acc_code=b.sl_no 
                and b.mngr_id = c.sl_no and a.voucher_date >= '$frm_date' 
                and a.approval_status = 'A' AND a.voucher_date <= '$to_date' AND a.branch_id =$brid group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id,b.subgr_id)C ,mda_subgroub f,mda_mngroup g
                where c.subgr_id=f.sl_no
                and c.mngr_id=g.sl_no
                and c.type =1   
				and c.op_dr+c.op_cr+c.dr_amt+c.cr_amt>0
            ORDER BY C.mngr_id ASC";
            $query  = $this->db->query($sql);
            return $query->result();
    }
    function f_get_balsh_mngr_asst($frm_date, $to_date, $op_dt, $brid)
    {
        $sql = "select distinct c.mngr_id,g.name mng_name
            from( SELECT sum(op_dr) op_dr,sum(op_cr)op_cr ,0 dr_amt,0 cr_amt,mngr_id, subgr_id,ac_name,dr_cr_flag,type,benfed_ac_code 
                from( select sum(op_dr)op_dr, sum(op_cr)op_cr,sum(trans_dr)trans_dr , sum(trans_cr)trans_cr,mngr_id, ac_name,type,dr_cr_flag,benfed_ac_code ,subgr_id
            from(SELECT 0 op_dr,0 op_cr,sum(if(a.dr_cr_flag='DR',a.amount,0 ))trans_dr , sum(if(a.dr_cr_flag='CR',a.amount,0 ))trans_cr,b.mngr_id,b.subgr_id, b.ac_name,c.type, UPPER(a.dr_cr_flag)dr_cr_flag,b.benfed_ac_code 
            FROM td_vouchers a ,md_achead b,mda_mngroup c 
            WHERE a.acc_code=b.sl_no and b.mngr_id = c.sl_no 
            and a.trans_dt>='$op_dt' AND a.trans_dt<='$frm_date' and a.approval_status ='A' AND a.branch_id=$brid
            group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id ,b.subgr_id
                union 
                SELECT if(d.trans_flag='DR',d.amount,0),if(d.trans_flag='CR',d.amount,0),0 ,0 ,b.mngr_id, b.subgr_id,b.ac_name,c.type,UPPER(d.trans_flag),b.benfed_ac_code 
                from md_achead b,mda_mngroup c,td_opening d 
            where d.balance_dt=(select max(balance_dt) 
            from td_opening where balance_dt<='$frm_date') and b.mngr_id = c.sl_no and b.sl_no=d.acc_code AND d.br_id=$brid 
                group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id,b.subgr_id)b 
            group by mngr_id, subgr_id,ac_name,type,benfed_ac_code )a                                                                     group by benfed_ac_code 
                union 
                SELECT 0 op_dr,0 op_cr,sum(if(dr_cr_flag='Dr',a.amount,0))as dr_amt, sum(if(dr_cr_flag='Cr',a.amount,0))as cr_amt,b.mngr_id ,b.subgr_id, b.ac_name, a.dr_cr_flag,c.type,b.benfed_ac_code 
                FROM td_vouchers a,md_achead b,mda_mngroup c 
                WHERE a.acc_code=b.sl_no 
                and b.mngr_id = c.sl_no and a.voucher_date >= '$frm_date' 
                and a.approval_status = 'A' AND a.voucher_date <= '$to_date' AND a.branch_id =$brid group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id,b.subgr_id)C ,mda_subgroub f,mda_mngroup g
                where c.subgr_id=f.sl_no
                and c.mngr_id=g.sl_no
                and c.type =2      
				and c.op_dr+c.op_cr+c.dr_amt+c.cr_amt>0
            ORDER BY C.mngr_id ASC";
            $query  = $this->db->query($sql);
            return $query->result();
    }

    function f_get_balsh_br_lib($frm_date, $to_date, $op_dt, $brid)
    {
        $dmo = date('m-d', strtotime($frm_date));

            $sql = "select sum(op_dr)op_dr,sum(op_cr)op_cr,sum(dr_amt)dr_amt,sum(cr_amt)cr_amt,c.mngr_id,c.subgr_id,g.name mng_name
            ,f.name ac_name,dr_cr_flag,c.type 
            from( SELECT sum(op_dr) op_dr,sum(op_cr)op_cr ,0 dr_amt,0 cr_amt,mngr_id, subgr_id,ac_name,dr_cr_flag,type,benfed_ac_code 
                from( select sum(op_dr)op_dr, sum(op_cr)op_cr,sum(trans_dr)trans_dr , sum(trans_cr)trans_cr,mngr_id, ac_name,type,dr_cr_flag,benfed_ac_code ,subgr_id
            from(SELECT 0 op_dr,0 op_cr,sum(if(a.dr_cr_flag='DR',a.amount,0 ))trans_dr , sum(if(a.dr_cr_flag='CR',a.amount,0 ))trans_cr,b.mngr_id,b.subgr_id, b.ac_name,c.type, UPPER(a.dr_cr_flag)dr_cr_flag,b.benfed_ac_code 
            FROM td_vouchers a ,md_achead b,mda_mngroup c 
            WHERE a.acc_code=b.sl_no and b.mngr_id = c.sl_no 
            and a.trans_dt>='$op_dt' AND a.trans_dt<='$frm_date' and a.approval_status ='A' AND a.branch_id=$brid 
            group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id ,b.subgr_id
                union 
                SELECT if(d.trans_flag='DR',d.amount,0),if(d.trans_flag='CR',d.amount,0),0 ,0 ,b.mngr_id, b.subgr_id,b.ac_name,c.type,UPPER(d.trans_flag),b.benfed_ac_code 
                from md_achead b,mda_mngroup c,td_opening d 
            where d.balance_dt=(select max(balance_dt) 
            from td_opening where balance_dt<='$frm_date') and b.mngr_id = c.sl_no and b.sl_no=d.acc_code AND d.br_id=$brid 
                group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id,b.subgr_id)b 
            group by mngr_id, subgr_id,ac_name,type,benfed_ac_code )a                                                                     group by benfed_ac_code 
                union 
                SELECT 0 op_dr,0 op_cr,sum(if(dr_cr_flag='Dr',a.amount,0))as dr_amt, sum(if(dr_cr_flag='Cr',a.amount,0))as cr_amt,b.mngr_id ,b.subgr_id, b.ac_name, a.dr_cr_flag,c.type,b.benfed_ac_code 
                FROM td_vouchers a,md_achead b,mda_mngroup c 
                WHERE a.acc_code=b.sl_no 
                and b.mngr_id = c.sl_no and a.voucher_date >= '$frm_date' 
                and a.approval_status = 'A' AND a.voucher_date <= '$to_date' AND a.branch_id =$brid group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id,b.subgr_id)C ,mda_subgroub f,mda_mngroup g
                where c.subgr_id=f.sl_no
                and c.mngr_id=g.sl_no
                and c.type=1
				and c.op_dr+c.op_cr+c.dr_amt+c.cr_amt>0
                group by c.mngr_id,c.subgr_id,f.name,g.name,c.type  
            ORDER BY C.mngr_id ASC";

        $query  = $this->db->query($sql);
        return $query->result();
    }
	function f_get_balsh_br_asst($frm_date, $to_date, $op_dt, $brid)
    {
            $sql = "select sum(op_dr)op_dr,sum(op_cr)op_cr,sum(dr_amt)dr_amt,sum(cr_amt)cr_amt,c.mngr_id,c.subgr_id,g.name mng_name
            ,f.name ac_name,dr_cr_flag,c.type 
            from( SELECT sum(op_dr) op_dr,sum(op_cr)op_cr ,0 dr_amt,0 cr_amt,mngr_id, subgr_id,ac_name,dr_cr_flag,type,benfed_ac_code 
                from( select sum(op_dr)op_dr, sum(op_cr)op_cr,sum(trans_dr)trans_dr , sum(trans_cr)trans_cr,mngr_id, ac_name,type,dr_cr_flag,benfed_ac_code ,subgr_id
            from(SELECT 0 op_dr,0 op_cr,sum(if(a.dr_cr_flag='DR',a.amount,0 ))trans_dr , sum(if(a.dr_cr_flag='CR',a.amount,0 ))trans_cr,b.mngr_id,b.subgr_id, b.ac_name,c.type, UPPER(a.dr_cr_flag)dr_cr_flag,b.benfed_ac_code 
            FROM td_vouchers a ,md_achead b,mda_mngroup c 
            WHERE a.acc_code=b.sl_no and b.mngr_id = c.sl_no 
            and a.trans_dt>='$op_dt' AND a.trans_dt<='$frm_date' and a.approval_status ='A' AND a.branch_id=$brid 
            group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id ,b.subgr_id
                union 
                SELECT if(d.trans_flag='DR',d.amount,0),if(d.trans_flag='CR',d.amount,0),0 ,0 ,b.mngr_id, b.subgr_id,b.ac_name,c.type,UPPER(d.trans_flag),b.benfed_ac_code 
                from md_achead b,mda_mngroup c,td_opening d 
            where d.balance_dt=(select max(balance_dt) 
            from td_opening where balance_dt<='$frm_date') and b.mngr_id = c.sl_no and b.sl_no=d.acc_code AND d.br_id=$brid 
                group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id,b.subgr_id)b 
            group by mngr_id, subgr_id,ac_name,type,benfed_ac_code )a                                                                     group by benfed_ac_code 
                union 
                SELECT 0 op_dr,0 op_cr,sum(if(dr_cr_flag='Dr',a.amount,0))as dr_amt, sum(if(dr_cr_flag='Cr',a.amount,0))as cr_amt,b.mngr_id ,b.subgr_id, b.ac_name, a.dr_cr_flag,c.type,b.benfed_ac_code 
                FROM td_vouchers a,md_achead b,mda_mngroup c 
                WHERE a.acc_code=b.sl_no 
                and b.mngr_id = c.sl_no and a.voucher_date >= '$frm_date' 
                and a.approval_status = 'A' AND a.voucher_date <= '$to_date' AND a.branch_id =$brid group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id,b.subgr_id)C ,mda_subgroub f,mda_mngroup g
                where c.subgr_id=f.sl_no
                and c.mngr_id=g.sl_no
                and c.type =2
				and c.op_dr+c.op_cr+c.dr_amt+c.cr_amt>0
                group by c.mngr_id,c.subgr_id,f.name,g.name,c.type  
            ORDER BY C.mngr_id ASC";
        $query  = $this->db->query($sql);
        return $query->result();
    }
	
	function f_get_balpl_main_group($frm_date, $to_date, $op_dt, $brid,$type)
    {
        $dmo = date('m-d', strtotime($frm_date));

            $sql = "select sum(op_dr)op_dr,sum(op_cr)op_cr,sum(dr_amt)dr_amt,sum(cr_amt)cr_amt,c.mngr_id,c.subgr_id,g.name mng_name
            ,f.name ac_name,dr_cr_flag,c.type 
            from( SELECT sum(op_dr) op_dr,sum(op_cr)op_cr ,0 dr_amt,0 cr_amt,mngr_id, subgr_id,ac_name,dr_cr_flag,type,benfed_ac_code 
                from( select sum(op_dr)op_dr, sum(op_cr)op_cr,sum(trans_dr)trans_dr , sum(trans_cr)trans_cr,mngr_id, ac_name,type,dr_cr_flag,benfed_ac_code ,subgr_id
            from(SELECT 0 op_dr,0 op_cr,sum(if(a.dr_cr_flag='DR',a.amount,0 ))trans_dr , sum(if(a.dr_cr_flag='CR',a.amount,0 ))trans_cr,b.mngr_id,b.subgr_id, b.ac_name,c.type, UPPER(a.dr_cr_flag)dr_cr_flag,b.benfed_ac_code 
            FROM td_vouchers a ,md_achead b,mda_mngroup c 
            WHERE a.acc_code=b.sl_no and b.mngr_id = c.sl_no 
            and a.trans_dt>='$op_dt' AND a.trans_dt<='$frm_date' and a.approval_status ='A' AND a.branch_id=$brid 
            group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id ,b.subgr_id
                union 
                SELECT if(d.trans_flag='DR',d.amount,0),if(d.trans_flag='CR',d.amount,0),0 ,0 ,b.mngr_id, b.subgr_id,b.ac_name,c.type,UPPER(d.trans_flag),b.benfed_ac_code 
                from md_achead b,mda_mngroup c,td_opening d 
            where d.balance_dt=(select max(balance_dt) 
            from td_opening where balance_dt<='$frm_date') and b.mngr_id = c.sl_no and b.sl_no=d.acc_code AND d.br_id=$brid 
                group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id,b.subgr_id)b 
            group by mngr_id, subgr_id,ac_name,type,benfed_ac_code )a                                                                     group by benfed_ac_code 
                union 
                SELECT 0 op_dr,0 op_cr,sum(if(dr_cr_flag='Dr',a.amount,0))as dr_amt, sum(if(dr_cr_flag='Cr',a.amount,0))as cr_amt,b.mngr_id ,b.subgr_id, b.ac_name, a.dr_cr_flag,c.type,b.benfed_ac_code 
                FROM td_vouchers a,md_achead b,mda_mngroup c 
                WHERE a.acc_code=b.sl_no 
                and b.mngr_id = c.sl_no and a.voucher_date >= '$frm_date' 
                and a.approval_status = 'A' AND a.voucher_date <= '$to_date' AND a.branch_id =$brid group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id,b.subgr_id)C ,mda_subgroub f,mda_mngroup g
                where c.subgr_id=f.sl_no
                and c.mngr_id=g.sl_no
                and c.type=$type
				and c.op_dr+c.op_cr+c.dr_amt+c.cr_amt>0
                group by c.mngr_id,c.subgr_id,f.name,g.name,c.type  
            ORDER BY C.mngr_id ASC";

        $query  = $this->db->query($sql);
        return $query->result();
    }
    
    function f_get_pl_br($frm_date, $to_date, $op_dt, $brid)
    {
        $dmo = date('m-d', strtotime($frm_date));
       
        $sql = "select sum(op_dr)op_dr,sum(op_cr)op_cr,sum(dr_amt)dr_amt,sum(cr_amt)cr_amt,c.mngr_id,c.subgr_id,g.name mng_name
                ,f.name ac_name,dr_cr_flag,c.type,benfed_ac_code 
                from( SELECT sum(op_dr) op_dr,sum(op_cr)op_cr ,0 dr_amt,0 cr_amt,mngr_id, subgr_id,ac_name,dr_cr_flag,type,benfed_ac_code 
                    from( select sum(op_dr)op_dr, sum(op_cr)op_cr,sum(trans_dr)trans_dr , sum(trans_cr)trans_cr,mngr_id, ac_name,type,dr_cr_flag,benfed_ac_code ,subgr_id
                from(SELECT 0 op_dr,0 op_cr,sum(if(a.dr_cr_flag='DR',a.amount,0 ))trans_dr , sum(if(a.dr_cr_flag='CR',a.amount,0 ))trans_cr,b.mngr_id,b.subgr_id, b.ac_name,c.type, UPPER(a.dr_cr_flag)dr_cr_flag,b.benfed_ac_code 
                FROM td_vouchers a ,md_achead b,mda_mngroup c 
                WHERE a.acc_code=b.sl_no and b.mngr_id = c.sl_no 
                and a.trans_dt>='$op_dt' AND a.trans_dt<='$frm_date' and a.approval_status ='A' AND a.branch_id=$brid 
                group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id ,b.subgr_id
                    union 
                    SELECT if(d.trans_flag='DR',d.amount,0),if(d.trans_flag='CR',d.amount,0),0 ,0 ,b.mngr_id, b.subgr_id,b.ac_name,c.type,UPPER(d.trans_flag),b.benfed_ac_code 
                    from md_achead b,mda_mngroup c,td_opening d 
                where d.balance_dt=(select max(balance_dt) 
                from td_opening where balance_dt<='$frm_date') and b.mngr_id = c.sl_no and b.sl_no=d.acc_code AND d.br_id=$brid 
                    group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id,b.subgr_id)b 
                group by mngr_id, subgr_id,ac_name,type,benfed_ac_code )a                                                                     group by benfed_ac_code 
                    union 
                    SELECT 0 op_dr,0 op_cr,sum(if(dr_cr_flag='Dr',a.amount,0))as dr_amt, sum(if(dr_cr_flag='Cr',a.amount,0))as cr_amt,b.mngr_id ,b.subgr_id, b.ac_name, a.dr_cr_flag,c.type,b.benfed_ac_code 
                    FROM td_vouchers a,md_achead b,mda_mngroup c 
                    WHERE a.acc_code=b.sl_no 
                    and b.mngr_id = c.sl_no and a.voucher_date >= '$frm_date' 
                    and a.approval_status = 'A' AND a.voucher_date <= '$to_date' AND a.branch_id =$brid group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id,b.subgr_id)C ,mda_subgroub f,mda_mngroup g
                    where c.subgr_id=f.sl_no
                    and c.mngr_id=g.sl_no
                    and c.type in (3,4)                                            
                    group by c.mngr_id,c.subgr_id,f.name,g.name,c.type  
                ORDER BY C.mngr_id ASC";
        
        $query  = $this->db->query($sql);
        return $query->result();
    }
	public function f_get_scroll_book($frm_date,$to_date){
		
		$sql = "select if(dr_cr_flag='Dr',a.amount,0) as dr_amt, if(dr_cr_flag='Cr',a.amount,0)as cr_amt,a.remarks,
		         a.voucher_date ,a.voucher_id,b.ac_name from td_vouchers a,md_achead b 
		      where a.acc_code = b.sl_no 
			  and a.voucher_date >='$frm_date' and a.voucher_date <= '$to_date' 
			  and a.acc_code in(1 )and a.unit_id = 1 ";
		
	     $query  = $this->db->query($sql);
        return $query->result();
	}
	
	
	public function f_get_op_bal($opndt,$frm_date,$unit_id){
		
		//$sql = "select amount,trans_flag
		     //   from td_opening_temp
		     //   where acc_code = 1
			  //  and balance_dt= '$opndt' 
			  //  and unit_id = $unit_id";
		
$sql = "select (op_amt+dr_amt)-cr_amt as amount
from(
select IFNULL(sum(if(dr_cr_flag='Dr',a.amount,0) ),0)dr_amt ,IFNULL(sum(if(dr_cr_flag='Cr',a.amount,0)),0)cr_amt, 
(select amount
		        from td_opening_temp
		        where acc_code = 1
			    and balance_dt= '$opndt' 
			    and unit_id = 1)op_amt
                 from td_vouchers a,md_achead b 
		      where a.acc_code = b.sl_no 
			  and a.voucher_date >='$opndt' and a.voucher_date <'$frm_date' 
			  and a.acc_code =1 and a.unit_id = $unit_id)a";
		
	
		
	     $query  = $this->db->query($sql);
        return $query->row();
	}
}
