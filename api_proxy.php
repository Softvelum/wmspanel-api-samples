<?php

/*
   Simple WMSPanel API proxy
   use:
   https://you_server/api_proxy.php?path=/v1/server/[server_id]/rtmp/app/&client_id=[client_id]&api_key=[api_key]
   instead of:
   https://api.wmspanel.com/v1/server/[server_id]/rtmp/app/?client_id=[client_id]&api_key=[api_key]
*/

$allowed_ips = ['127.0.0.1','192.168.0.1'];

$ip = $_SERVER['REMOTE_ADDR'];
if (!empty($_SERVER["HTTP_CF_CONNECTING_IP"])) {
    $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
} elseif (!empty($_SERVER['HTTP_X_REAL_IP'])) {
    $ip = $_SERVER['HTTP_X_REAL_IP'];
} elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    $commapos = strrpos($ip, ',');
    $ip = trim( substr($ip, $commapos ? $commapos + 1 : 0) );
}

if (!in_array($ip, $allowed_ips)) {
  header('HTTP/1.0 403 Forbidden');
  die();
}

$path = $_GET['path'];
unset($_GET['path']);

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, 'https://api.wmspanel.com'.$path.'?'.http_build_query($_GET));
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $_SERVER['REQUEST_METHOD']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT') {
  $post_data = file_get_contents('php://input');
  curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($post_data))
  );
}

header('Content-Type: application/json');
curl_exec($curl);

?>
