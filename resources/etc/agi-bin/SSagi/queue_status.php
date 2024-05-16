#!/usr/bin/php -q
<?php
set_time_limit(30);
require('phpagi/phpagi.php');
error_reporting(E_ALL);
$agi = new AGI();
$con=mysqli_connect("localhost","root","GFDUedThsS","bigdialer");
if (mysqli_connect_errno())
  {
  $agi->verbose("Connection Failed!!");
 }
else
$ext = $argv[1];
$agi->verbose("Agent No is : $ext");
$query = ("select paused from queue_member_table where membername= $ext");
$result = mysqli_query($con,$query);
//print "$result";
//while($row = mysql_fetch_array($result))
while($row = mysqli_fetch_array($result))
{$pstatus = "$row[paused]";

if ($pstatus == 1 || $pstatus == 0) {
        if ($pstatus == 1) {
                $agi->verbose("it is $pstatus, turning it to 0");
                //$agi->stream_file("youarereadytotakecallsw","#");
                $query = ("UPDATE `bogpbxdialer`.`queue_member_table` SET `paused` = '0' WHERE `queue_member_table`.`membername` = $ext");
                $result = mysqli_query($con,$query);
                $agi->exec('Playback','readyforcallw');

        } else {
                $agi->verbose("it is $pstatus, turning it to 1");
                $query = ("UPDATE `mya2billing`.`queue_member_table` SET `paused` = '1' WHERE `queue_member_table`.`membername` = $ext");
                $result = mysqli_query($con,$query);
                $agi->exec('Playback','notreadyw');
                //$agi->stream_file("pauseloggedoffw","#");
        }

} else {
        $agi->verbose("it is nor 0 niether 1, doing nothing.");

        $agi->stream_file("pauseadminw");

        $agi->hangup();


}

}

mysqli_close($con);

?>

