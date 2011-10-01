<?php 

ini_set('display_errors',0);

header('Content-type: application/json');

$app_id = '8964';
$key = 'ef8c48dfede24f30d0ad';
$secret = '3c0c97108338e87cf288';

require('../Pusher-PHP/lib/Pusher.php');

$event = $_GET['event'];
$message = $_GET['message'];

if (!$event || !$message) {
    echo json_encode(array('result' => 'wrong parameter'));
    return;
}

$pusher = new Pusher\Pusher($key, $secret, $app_id);
$pusher->trigger('bute2011', $event, $message);

echo json_encode(array('result' => 'success'));
