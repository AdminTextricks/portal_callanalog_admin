<?php
$extension = $_REQUEST['agent'];
$dialphonenumber = $_REQUEST['dialphone'];
$timeout = 10;
$asterisk_ip = "127.0.0.1";
$socket = fsockopen($asterisk_ip,"5038", $errno, $errstr, $timeout);
fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: cron\r\n");
fputs($socket, "Secret: 1234\r\n\r\n");
$wrets=fgets($socket,128);
echo $wrets;
fputs($socket, "Action: Originate\r\n" );
fputs($socket, "Channel: SIP/$extension\r\n" );
fputs($socket, "Exten: $dialphonenumber\r\n" );
fputs($socket, "Context: trunkinbound\r\n" ); 
fputs($socket, "Priority: 1\r\n" );
fputs($socket, "Async: yes\r\n\r\n" );
$wrets=fgets($socket,128);
echo $wrets;

?>
