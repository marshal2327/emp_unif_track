<?php

class User_model extends CI_Model{


    // GET ALL USER DETAILS
    public function emp_details(){

        $datas = $this->db->query("select crempstmastid, MCEMPID, EMPID, DEPT, DESIGNATION, '('||mcempid||') / '||empid mid from crempstmast where appstatus = 'Live' order by mcempid")->result_array();

        return $datas;
        
    }

    // GET USER DET AND USER IMG BY ID
    public function emp_info($params){

        $datas['user_info'] = $this->db->query("select crempstmastid, MCEMPID, initcap(EMPID) empid, TRIM(initcap(DEPT)) dept, TRIM(initcap(designation)) designation from crempstmast where appstatus = 'Live' 
                                    and crempstmastid = ".$params['recid']." and upper(mcempid) = upper('".$params['mcempid']."') order by mcempid")->row_array();

        $datas['user_img'] = $this->db->query("select img, ftype  from cremsimg WHERE RECORDID = ".$params['recid']." " )->row_array();

        // echo "<pre>"; print_r($datas);exit; 
        return $datas;


    }

    // SAVE UF TRACK ENTRY
    public function sve_ufentry($cred){

        // UF/HL/25-26/0001

        $doc = $this->db->query("select max(docid)docid from uniftrackmast")->result();
        $docid = $doc[0]->DOCID ? $doc[0]->DOCID : 'UF/HL/25-26/0000';

        $inc = substr($docid,12)+1;

        $nxt_docid = "UF/HL/25-26/".str_pad($inc, 4,'0', STR_PAD_LEFT);

        // echo '<pre>'; print_r($docid);
        // echo '<pre>'; print_r($nxt_docid);

        // INSERT PROCESS

        $this->db->query("insert into uniftrackmast(uniftrackmastid,cancel, sourceid,modifiedon, createdon, app_level, app_desc, docid, cdt, mastid, empid, mcempid, dept, design, imgname)
                        values((select nvl(max(uniftrackmastid),0)+1 from uniftrackmast), 'F', 0, SYSDATE, SYSDATE, 1, 1, '".$nxt_docid."',TRUNC(SYSDATE), 
                        ".$cred['recid'].", upper('".$cred['empid']."'), upper('".$cred['mcempid']."'), upper('".$cred['design']."'), upper('".$cred['dept']."'), '".$cred['filename']."')");

        if($this->db->affected_rows()>0){
            return TRUE;
        }else{
            return FALSE;       
        }
        
    }


}

?>