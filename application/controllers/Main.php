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
            $mcempid = $_GET['mcempid'];
            
            $params = array('recid' => $recid, 'mcempid' => $mcempid);
            
            $result = $this->User_model->emp_info($params);

            if(isset($result['user_img'])){
                $lob = $result['user_img'][0]['IMG'];
                $result['user_img'][0]['IMG'] = base64_encode($lob->load());
                echo json_encode($result);
            }else{
                echo json_encode(NULL);
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

            $filename = $_POST['mcempid'].'_'.$now.'.jpeg';     
            $cred['filename'] = $filename;

            // INSERT DATA TO DB
            $db_res = $this->User_model->sve_ufentry($cred);

        
            if(!empty($_FILES['uimg'])){
                
                // $type = substr($_FILES['uimg']['type'],6);

                // SET PUBLIC URL, BCZ FTP WORKS ON LOCALY(10.0.1.184) NET SO
                $target_url = "erp.crgarments.com:8082/empunif/assets/api/empunif_upload.php";
                // echo '<pre>'; print_r($target_url);exit;

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


}



?>          