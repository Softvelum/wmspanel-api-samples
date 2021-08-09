<?php
// WMSPanel publish/un-publish streams events notification sample

if($_SERVER['REQUEST_METHOD'] !== "POST") {
    die("notifications are only sent as a POST request.");
}

$data = file_get_contents("php://input");

$fp = fopen('log.txt', 'a+');

fwrite($fp, $data);

fwrite($fp, "\r\n\r\n");

/*

// Use this further processing in case you have PECL installed

$notification = json_decode($data, true);

// example of human-readable notification for Wowza output
$response = 
    date("Y-m-d H:i:s", time()) . ": stream published: " .
    $notification['ApiSyncRequest']['Publish']['VHostName'] . '/' .
    $notification['ApiSyncRequest']['Publish']['AppName'] . '/' .
    $notification['ApiSyncRequest']['Publish']['AppInstanceName'] . '/' .
    $notification['ApiSyncRequest']['Publish']['StreamName'];

// example for Nimble Streamer
$response = 
    date("Y-m-d H:i:s", time()) . ": stream published: " .
    $notification['publish'][0]['stream'];


//saving to log file
fwrite($fp, $response);
fwrite($fp, "\r\n\r\n");

*/

fclose($fp);
