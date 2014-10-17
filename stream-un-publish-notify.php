<?php
// WMSPanel publish/un-publish streams events notification sample

$r = $HTTP_RAW_POST_DATA;

$fp = fopen('log.txt', 'a+');

fwrite($fp, $r);

fwrite($fp, "\r\n\r\n");

/*

// Use this further processing in case you have PECL installed

$notification = json_decode($r, true); 

//example of human-readable notification
$response = 
    date("Y-m-d H:i:s", time()) . ": stream published: " .
    $notification['ApiSyncRequest']['Publish']['VHostName'] . '/' .
    $notification['ApiSyncRequest']['Publish']['AppName'] . '/' .
    $notification['ApiSyncRequest']['Publish']['AppInstanceName'] . '/' .
    $notification['ApiSyncRequest']['Publish']['StreamName'];

//saving to log file
fwrite($fp, $response);
fwrite($fp, "\r\n\r\n");

*/

fclose($fp);
?>
