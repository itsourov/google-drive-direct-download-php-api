<?php

$apiKey = 'your api key';

if (!isset($_GET['id'])) {
    echo "returning";
return;
}

$filename =getName($_GET['id']);
if ($filename=="") {
    return;
}

$file_url = 'https://www.googleapis.com/drive/v3/files/'. $_GET['id'].'?key='.$apiKey.'&supportsAllDrives=true&alt=media';
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"" . $filename . "\""); 
readfile($file_url); 

function getName($id){
    global $apiKey;

    $url ='https://www.googleapis.com/drive/v3/files/'.$id.'?key='.$apiKey.'&supportsAllDrives=true';
    
    if (substr(get_headers($url)[0], 9, 3) == 200) {
        $json = file_get_contents($url);
        $data=array();
        $data = json_decode($json, true);
       return $data['name'];
    }else{
        $options = array(
            'http' => array(
              'ignore_errors' => true,
              'header' => "Content-Type: application/json\r\n"
              )
          );
          $context  = stream_context_create($options);
          $result = file_get_contents($url, false, $context);
          header('Content-type: application/json; charset=UTF-8');
         print $result;
    }

 
}
?>
