<?php 


class Reports_model extends CI_Model{


    public function daily_entry_report($params){

        $res = $this->db->query("select a.docid, to_char(a.createdon,'DD/MM/YYYY HH24:MI:SS') createdon, to_char(a.cdt,'DD/MM/YYYY') cdt, a.empid, a.mcempid, a.dept, a.design, b.division, a.imgname,
        case when a.imgname is not null then 'http://erp.crgarments.com:8082/axpattach/CR/empunifhel/'||imgname else null end imgurl from uniftrackmast a, div_mast b
        where a.division = b.div_mastid and a.cdt between to_date('".$params['from_dt']."','YYYY-MM-DD') and to_date('".$params['to_dt']."','YYYY-MM-DD')
        order by createdon desc")->result_array();

        return $res;

    }

}

?>