<?php
// UPLOAD IMG FROM EMPUNIF

header('Content-Type: application/json');

if(empty($_FILES['uimg']['tmp_name'])){
    echo json_encode(array('status' => 'error', 'message' => 'No Img File Recieved!!'));
    exit;
}


if($_FILES['uimg']['error'] !== 0){
    echo json_encode(array('status' => 'error', 'message' => 'Uploaded Img error'));
    exit;
}

$directory = '\\\\10.0.1.184\\axpattach\\CR\\empunifhel\\empunif';

$ext = pathinfo($_FILES['uimg']['name'], PATHINFO_EXTENSION);

$filename = $_FILES['uimg']['name'];

$from_path = $_FILES['uimg']['tmp_name'];
$to_path = $directory.'\\'.$filename;

if(move_uploaded_file($from_path, $to_path)){
    echo json_encode(array('status' => TRUE, 'message' => 'Uploaded', 'file' => $filename));
}else{
    echo json_encode(array('status' => 'error', 'message' => 'Upload Failed'));
}


?>


