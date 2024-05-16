#!/usr/bin/php -q
<?php
$calltime = $argv[1];
$agentname = $argv[2];
$exten = $argv[3];
$calltype = $argv[4];
$caller = $argv[5];
$duration = $argv[6];
$dnid = $argv[7];
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://10.130.8.101/getInstantCallDetails",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\"callTime\": \"$calltime\",\"agentName\": \"$agentname\",\"extension\": \"$exten\",\"callType\": \"$calltype\",\"callerId\": \"$caller\",\"duration\":\"$duration\",\"dnid\": \"$dnid\"}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

?>
