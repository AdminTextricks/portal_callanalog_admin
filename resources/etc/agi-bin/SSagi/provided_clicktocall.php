<?php

if (true )
{
//xmlhttp.open("GET","http://localhost/clicktocall.php?Aip="+Aip+"&ext="+ext+"&user="+user+"&pass="+pass+"&phone="phoneNumber,true);
$asterisk_ip = $_REQUEST['Aip'];
$ext = $_REQUEST['ext'];
$user = $_REQUEST['cron'];
$pass = $_REQUEST['1234'];
$num = $_REQUEST['phone'];

     //  $num = "100";
      // $ext = '1422277';
//$asterisk_ip = "192.168.1.100";
//$user ="admin";
//$pass = "elastix";

	   $num = preg_replace( "/^\+7/", "8", $num );

	   $num = preg_replace( "/\D/", "", $num );
 
        if ( ! empty( $num ) )
        {
                echo "Dialing $num\r\n";
 
                $timeout = 10;
              // $asterisk_ip = "192.168.1.100";
 
                $socket = fsockopen($asterisk_ip,"5038", $errno, $errstr, $timeout);
                fputs($socket, "Action: Login\r\n");
                fputs($socket, "UserName: $user\r\n");
                fputs($socket, "Secret: $pass\r\n\r\n");
 
                $wrets=fgets($socket,128);
 
                echo $wrets;
 
                fputs($socket, "Action: Originate\r\n" );
                fputs($socket, "Channel: SIP/$ext\r\n" );
                fputs($socket, "Exten: $num\r\n" );
                fputs($socket, "Context: default\r\n" );
                fputs($socket, "Context:trunkinbound\r\n" );
		fputs($socket, "Priority: 1\r\n" );
                fputs($socket, "Async: yes\r\n" );
                fputs($socket, "WaitTime: 15\r\n" );
                fputs($socket, "Callerid: $num\r\n\r\n" );
 
                $wrets=fgets($socket,128);
                echo $wrets;
        }
        else
        {
                echo "Unable to determine number from (" . $_REQUEST['phone'] . ")\r\n";
        }
}
else
{
echo "please enter number";
}

?>
