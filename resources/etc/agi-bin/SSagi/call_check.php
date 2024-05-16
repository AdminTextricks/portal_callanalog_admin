#!/usr/bin/php -q
<?php
set_time_limit(30);
require('phpagi/phpagi.php');
error_reporting(E_ALL);
$agi = new AGI();
$sessionID = $argv[1];
$cid =  $argv[2];
$clid = $argv[3];
        if(isset($sessionID) && trim($sessionID) != '')
        {
                $arrEx = explode("/",$sessionID);
                $sessionID =  $arrEx[1];
                $ch = curl_init();
                $date = date('m/d/Y h:i:s a', time());
                $uid = hashCode($date);
                $data = $customer_data = array("clid" => $cid,"extNo" => $sessionID,"didNo"=>$clid,"uniqueId"=>$uid);
                $data_string = json_encode($data);
                $headers = array('Content-Type:application/json', 'Content-Length: ' . strlen($data_string));
                curl_setopt($ch, CURLOPT_URL,"http://staging.nobelmail.net/user/addUserCall?authcode=Trav3103s987876");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
                curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);
                curl_close($ch);
                $objJson = json_decode($server_output,true);
                if ($objJson['baseResponse']['status'] == 1) {  $agi->verbose("######## Success #######");  } else {  $agi->verbose("********* Failure ******** "); }
        }
function hashCode($str) {
    $str = (string)$str;
    $hash = 0;
    $len = strlen($str);
    if ($len == 0 )
        return $hash;

    for ($i = 0; $i < $len; $i++) {
        $h = $hash << 5;
        $h -= $hash;
        $h += ord($str[$i]);
        $hash = $h;
        $hash &= 0xFFFFFFFF;
    }
    return $hash;
};

 ?>
