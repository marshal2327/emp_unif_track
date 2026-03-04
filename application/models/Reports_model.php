<?php 


class Reports_model extends CI_Model{


    public function daily_entry_report($params){

        $res = $this->db->query("select docid, to_char(createdon,'DD/MM/YYYY HH24:MI:SS') createdon, to_char(cdt,'DD/MM/YYYY') cdt, empid, mcempid, dept, design, division, imgname,
        case when imgname is not null then 'http://erp.crgarments.com:8082/axpattach/CR/empunifhel/'||imgname else null end imgurl from uniftrackmast
        where cdt between to_date('".$params['from_dt']."','YYYY-MM-DD')
        and to_date('".$params['to_dt']."', 'YYYY-MM-DD')
        order by createdon desc")->result_array();

        return $res;

    }

}

?>