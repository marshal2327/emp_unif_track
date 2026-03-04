<?php 

class Main extends CI_Controller{
    
    public function __cosntruct(){
        parent::__construct();
        
        header("Access-Control-Allow-Origin:http://erp.crgarments.com:8082");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); 
    }




    public function index(){

        $emp_datas['emp_datas'] = $this->User_model->emp_details();

        // $img = ImageDecoder($emp_datas['emp_datas']['IMG']['IMG'], $emp_datas['emp_datas']['IMG']['FTYPE']);

        $this->load->view('pages/emp_entry',$emp_datas);

        // echo "<pre>"; print_r($emp_datas);exit;

    }

    public function get_user_det(){

        if(!empty($_GET)){
        
            $recid = $_GET['recid'];
            $docid = $_GET['docid'];
            $mcempid = $_GET['mcempid'];
            
            $params = array('recid' => $recid, 'docid' => $docid, 'mcempid' => $mcempid);
            
            $result = $this->User_model->emp_info($params);

            // echo '<pre>'; print_r($result['user_img']);
            
            if(!empty($result['user_img'])){

                $lob = $result['user_img']['IMG'];
                $result['user_img']['IMG'] = base64_encode($lob->load());
                            // echo '<pre>'; print_r($result['user_img']);exit;
                // echo 'TRUE';
                echo json_encode($result);
           
     
            }else{
                echo json_encode(array('status' => FALSE, 'message' => 'Img Get Failed'));
            }
            
        }

    }

    public function unif_entry(){

        date_default_timezone_set('Asia/Kolkata');

        if(!empty($_POST['recid'])){
            
            // echo '<pre>'; print_r($_POST);

            // $status = [];

            $cred = $_POST;

            $now = date('d-m-Y_H-i-s'); 

            $filename = !empty($_FILES['uimg']) ? $_POST['mcempid'].'_'.$now.'.jpeg' : '';     
            $cred['filename'] = $filename;

            // INSERT DATA TO DB
            $db_res = $this->User_model->sve_ufentry($cred);
        
            if(!empty($_FILES['uimg'])){
                
                // $type = substr($_FILES['uimg']['type'],6);

                // SET PUBLIC URL, BCZ FTP WORKS ON LOCALY(10.0.1.184) NET SO
                $target_url = "http://erp.crgarments.com:8082/empunif/assets/api/empunif_upload.php";
                // echo '<pre>'; print_r($_FILES);exit;

                // $url = "./assets/images/entries/";

                // $from_path = $_FILES['uimg']['tmp_name'];
                // $to_path = $url.$filename;

                // MOVE UPLOAD FILE CONCEPT
                // move_uploaded_file($from_path, $to_path);


                // CURL PROCESS
                $ch = curl_init();

                $post_fields = [
                    'uimg' => new CURLFILE($_FILES['uimg']['tmp_name'], $_FILES['uimg']['type'], $filename)
                ];

                curl_setopt($ch, CURLOPT_URL, $target_url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);

                if(curl_errno($ch)){

                    echo json_encode(array('status' => FALSE, 'message'=> curl_error($ch)));
                    return;

                }else{
                    $res = json_decode($response, true);
                    // echo '<pre>'; print_r($res);
                }   

                curl_close($ch);

            }

            if($db_res){
                echo json_encode(array('status' => TRUE, 'message' => 'INSERT SUCCESS'));
            }else{
                echo json_encode(array('status' => FALSE, 'message' => 'INSERT FAILED'));
                return;
            }

            // echo '<pre>'; print_r($_FILES);exit;        
        }

    }

// FOR DAILY REPORTS

public function unif_daily_report(){

    $from_dt = $_GET['from_dt'];
    $to_dt = $_GET['to_dt'];

    if(empty($from_dt) || empty($to_dt)){
        ?>  
        <script>alert("Date shouldn't be Empty !!");return;</script>
        <?php
    }

    $params = array('from_dt' => $from_dt, 'to_dt' => $to_dt);

    $results['results'] = $this->Reports_model->daily_entry_report($params);

}

public function unif_daily_rep_page(){

    $this->load->view('reports/unif_daily_reports');
    
}

public function unif_daily_rep(){
    // echo '<pre>'; print_r('DAILY REPORTS');

    $from_dt = $_GET['from_dt'];
    $to_dt = $_GET['to_dt'];

    if(empty($from_dt) || empty($to_dt)){
        ?>  
        <script>alert("Date shouldn't be Empty !!");return;</script>
        <?php
    }
    
    $params = array('from_dt' => $from_dt, 'to_dt' => $to_dt);
    
    $results = $this->Reports_model->daily_entry_report($params);
    echo json_encode($results);
    // echo '<pre>'; print_r($results);exit;

}

public function get_user_img(){

    // // $fname = $_GET['imgname'];

    // $fname = $_GET['imgname'];
    // // $fname='HOS41931_04-03-2026_12-38-59.jpeg';

    // $url = "http://erp.crgarments.com:8082/axpattach/cr/empunifhel/";

    // $blob = @file_get_contents($url.$fname);

    // if($blob){
    //     header("Content-Type: image/jpeg");
    //     echo $blob;
    // } else {
    //     header("HTTP/1.0 404 Not Found");
    // }
    
}

    

}



?>          