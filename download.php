<?php

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || isset($_SERVER['HTTP_USER_AGENT'])) {
    // echo "<pre>";
    // print_r($_SERVER);
    // echo "</pre>";
    http_response_code(405);
    exit;
}

$file = 'writable/uploads/resource_aov_icons.zip';

if (file_exists($file)) {
    
    ini_set('memory_limit', '-1');
    set_time_limit(0);
    
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
 
    flush();       
    readfile($file);
    exit;
}

http_response_code(404);
exit;

?>