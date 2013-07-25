<?php
// Log entire incoming request to see what we have in it.
$fp = fopen('/var/tmp/request.log', 'w');
fwrite($fp, $HTTP_RAW_POST_DATA);
fclose($fp);

// Return IDs of clients which needs to be denied. Their IDs are 1 and 2 here.
// Those viewers will be disconnected immediatelly and will not be allowed to connect anymore.
header('Content-Type: application/json');
$arr = array('DenyList' => array('ID' => array(1, 2)));
echo json_encode($arr);
?>