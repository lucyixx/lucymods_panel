<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require "google-play.php";
$google = new GooglePlay();

$packageId = isset($_GET['id']) ? $_GET['id'] : '';
$app=$google->parseApplication($packageId);

// print_r($app);

echo json_encode($app);
?>