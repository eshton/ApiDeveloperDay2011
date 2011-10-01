<?php

ini_set('display_errors',1);

header('Content-type: application/json');

$msisdn = $_GET['msisdn'];
$message = $_GET['message'];

if (!$msisdn || !$message) {
    echo json_encode(array('result' => 'wrong parameter'));
    return;
}

include '../lib/BUTESmsSender.php';

$test = new BUTESmsSender(false);
$test->send($msisdn, $message);

echo json_encode(array('result' => 'success'));
