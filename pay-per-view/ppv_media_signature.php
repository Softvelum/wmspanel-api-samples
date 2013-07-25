<?php
$today = gmdate("n/j/Y g:i:s A");

// URL of media we want to handle with pay-per-view
$initial_url = "rtsp://127.0.0.1:1935/vod/sample.mp4";
// client ID which is defined based on customer's database of users
$id = "5"; 
// A password entered in WMSAuth rule via web interface
$key = "defaultpassword"; 
// How long the link would be valid for playback
$validminutes = 240;

$str2hash = $id . $key . $today . $validminutes;
$md5raw = md5($str2hash, true);
$base64hash = base64_encode($md5raw);
$urlsignature = 
  'server_time=' . $today . '&hash_value=' . $base64hash . 
  '&validminutes=' . $validminutes . '&id=' . $id;
$base64urlsignature = base64_encode($urlsignature);
$signedurlwithvalidinterval = $initial_url . "?wmsAuthSign=$base64urlsignature";

// New protected media URL
echo $signedurlwithvalidinterval;
?>
