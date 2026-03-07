<?php 


class Reports_model extends CI_Model{


    public function daily_entry_report($params){

        $res = $this->db->query("select a.docid, to_char(a.createdon,'DD/MM/YYYY HH24:MI:SS') createdon, to_char(a.cdt,'DD/MM/YYYY') cdt, a.mastid, initcap(a.empid)empid, a.mcempid, initcap(a.dept)dept, 
        initcap(a.design)design, initcap(b.division)division, UPPER(a.prepby)prepby, initcap(a.remarks)remarks, a.imgname, case when a.imgname is not null then 'http://erp.crgarments.com:8082/axpattach/CR/empunifhel/empunif/'||imgname else null end imgurl from uniftrackmast a, div_mast b
        where a.division = b.div_mastid and a.cdt between to_date('".$params['from_dt']."','YYYY-MM-DD') and to_date('".$params['to_dt']."','YYYY-MM-DD')
        order by createdon desc")->result_array();

        return $res;

    }
    
    public function emp_entry_report($params){

        $datas['user_info'] = $this->db->query("select a.docid, to_char(a.createdon,'DD/MM/YYYY HH24:MI:SS') createdon, to_char(a.cdt,'DD/MM/YYYY') cdt, a.mastid, initcap(a.empid)empid, a.mcempid, initcap(a.dept)dept, 
        initcap(a.design)design, initcap(b.division)division, UPPER(a.prepby)prepby, initcap(a.remarks)remarks, a.imgname, case when a.imgname is not null then 'https://erp.crgarments.com:8443/axpattach/CR/empunifhel/empunif/'||imgname else null end imgurl from uniftrackmast a, div_mast b
        where a.division = b.div_mastid and upper(docid) = upper('".$params['docid']."') and upper(mcempid) = upper('".$params['mcempid']."') order by createdon desc")->result_array(); 
        
        $datas['user_img'] = $this->db->query("select img, ftype  from cremsimg WHERE RECORDID = ".$params['mastid']." " )->row_array();

        return $datas;

    }

}

?>