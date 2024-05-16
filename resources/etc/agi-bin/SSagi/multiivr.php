#!/usr/bin/php -q
<?php
set_time_limit(30);
require('phpagi/phpagi.php');
error_reporting(E_ALL);

$agi = new AGI();

//$con=mysqli_connect("localhost","root","cce55c5c21","mya2billing");

//if (mysqli_connect_errno())
//  {

//  $agi->verbose("Connection Failed!!");

// }

//else
$extension = $agi->get_variable("EXTEN");
$agi->verbose("extension number is $extension[data]");
$random_key = rand(1,9);
$agi->verbose("random key is $random_key");
$audio = "custom"."/"."press".$random_key."w";
$agi->verbose("audio name is $audio");


$keys="Nil";
$count=0;
do
{
        if($count>2)break;
        $result = $agi->get_data("$audio",5000,1);
        $keys = $result['result'];
        if($keys== $random_key) break;
        if($count<2){
        $agi->exec('Playback','no-valid-responce-pls-try-again');
        }
        $count++;
}while(($keys!=$random_key));



if($keys!=$random_key)
{
        //$agi->exec('Playback','custom/callrecordingw');
        //$agi->exec_goto(devices,$extension[data],1);
$agi->verbose("key did not match");
exit();
}

$random_key = rand(1,8);
$random_key_plus_one = $random_key + 1;
$audio1 = "custom"."/"."npress".$random_key."w";
$audio2 = "custom"."/"."npress".$random_key_plus_one."w";
$keys="Nil";
$count=0;
$agi->verbose("random key is $random_key");

$agi->verbose("random key is $random_key_plus_one");
$agi->verbose("random key is $audio1");
$agi->verbose("random key is $audio2");


do
{
        if($count>2)break;
        //$result = $agi->get_data("$audio",5000,1);
        $agi->exec("Read","execKey,custom/nforenglishw&$audio1&custom/nforspanishw&$audio2,1,,1,4");
        $temp = $agi->get_variable("execKey");
        $keys = trim($temp["data"]);
        if($keys== $random_key || $keys== $random_key_plus_one) break;
        if($count<2){
        $agi->exec('Playback','no-valid-responce-pls-try-again');
        }
        $count++;
}while(($keys!=$random_key || $keys!=$random_key_plus_one));


if($keys== $random_key || $keys== $random_key_plus_one)
{
        $agi->exec('Playback','custom/callrecordingw');
        $agi->exec_goto(devices,$extension[data],1);

}










//mysqli_close($con);

?>

