<?php


function ImageDecoder($img, $type){
    $bs4 = $img->load();
    $bs4_url = "data:image/".$type.";base64,".$bs4;
    return $bs4_url;

}


?>