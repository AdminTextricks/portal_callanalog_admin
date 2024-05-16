#!/usr/bin/php -q
<?php
set_time_limit(5);
require('phpagi.php');
error_reporting(E_ALL);

$agi = new AGI();
//$agi->set_music(true,"bigpbx")
$url = 'http://test.nobelmaila.net/user/addUserCall?authcode=Trav3103s987876';
$data = array("clid" => "999999999","extNo" => "788","didNo"=>"1800541254","uId"=>"8787070707");
$postdata = json_encode($data);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$result = curl_exec($ch);
$result = json_encode($result);
$agi->verbose("$result");
curl_close($ch);
//$agi->verbose("closed");
?>
 
