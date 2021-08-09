<?php
// WMSPanel publish/un-publish streams events notification signature validation sample

/* Replace the token with your token from "Global push API" settings page before testing! */
$token = "INSERT_YOUR_TOKEN_HERE";

if($_SERVER['REQUEST_METHOD'] !== "POST")
{
    die("notifications are only sent as a POST request.");
}

/* Read POST data */
$data = file_get_contents("php://input");

/* Open a log file for debugging purposes. */
$fp = fopen('log.txt', 'a+');

/* Decode the JSON POST data */
$notification = json_decode($data, true);

/* Make sure that all required parameters are present for validation to work. */
if(!array_key_exists("ID", $notification) || !array_key_exists("Puzzle", $notification) || !array_key_exists("Signature", $notification))
{
    die("Not all required parameters for validation are present.");
}

$id = $notification['ID'];
$puzzle = $notification['Puzzle'];
$signature = $notification['Signature'];

/* Calculate the signature based on our "Token" from the "Global push API" settings page */
$calculatedSignature = base64_encode(md5($id . $puzzle . $token, true));

if($signature === $calculatedSignature)
{
    fwrite($fp, "The signature was validated successfully!");
}
else
{
    fwrite($fp, "The signature could not be validated.\r\n");
    fwrite($fp, "Expected signature: " . $signature . "\r\n");
    fwrite($fp, "Calculated signature: " . $calculatedSignature . "\r\n");
}

fwrite($fp, "\r\n\r\n");
fclose($fp);
