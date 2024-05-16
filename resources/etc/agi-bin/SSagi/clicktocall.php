<?php

if (true )
{

$asterisk_ip = $_REQUEST['Aip'];
$ext = $_REQUEST['ext'];
$user ="cron";
$pass = "1234";
$num = $_REQUEST['phone'];


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
                fputs($socket, "Priority: 1\r\n" );
                fputs($socket, "Async: yes\r\n" );
                fputs($socket, "WaitTime: 15\r\n" );
                fputs($socket, "Callerid: $num\r\n\r\n" );
              fputs ($socket, "Action: Logoff\r\n\r\n");

                                while (!feof($socket)) {
  $wrets .= fread($socket, 8192);
}
fclose($socket);
echo <<<ASTERISKMANAGEREND
ASTERISK MANAGER OUTPUT:
$wrets
ASTERISKMANAGEREND;




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


/*
IP = 78.141.218.211
ext = gs102
pass = test
url http://78.141.218.211
*/



?>

