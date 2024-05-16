<?php
 session_start();
 include 'db.php'; 
 ?> 
<?php

$sqlstr="SELECT DISTINCT i.InCampID, i.CampName, i.CampType,i.ACDCode,i.IfrmLink,i.Ccontxtname
FROM ( SELECT u.cval, a.CampID FROM ( SELECT * FROM  `uniqnos` ) AS u,  `agentmaster` AS a
WHERE a.AgentName = '".$_SESSION['a_name']."' HAVING a.CampID LIKE CONCAT( CONCAT(  '%,', u.cval ) ,',%' )) AS am LEFT JOIN incamp AS i ON am.cval = i.InCampID GROUP BY am.cval, i.ACDCode";

$dataob = mysql_query($sqlstr,$conn);
$obpop=mysql_fetch_array($dataob);

$cmpid=$obpop['InCampID'];
$cmpnm=$obpop['CampName'];
$cmptyp=$obpop['CampType'];
$acdcode=$obpop['ACDCode'];
$oblink=$obpop['IfrmLink'];
$obcont=$obpop['Ccontxtname'];

if (empty( $_REQUEST['command']))
{
	echo "command : can't be left blank.";
    header('location:index.php');
	return;
}

if ($_REQUEST['command'] == 'dial')
{
	if (empty($_REQUEST['number']))
	{
		echo "<script>alert('Please enter a number to dial.')</script>";
        header('location:index.php');
		return;
	}
	if(empty($_REQUEST['ext']))
	{
		echo "<script>alert('Please enter a Exten to dial') </script>";
        header('location:index.php');
        return;
	}

    else{

      //  $mcid = $_GET['id'];
        $num = $_REQUEST['number'];
        $ext = $_REQUEST['ext'];
        /*$cmpid = $_REQUEST['cmpidob'];*/
        /*$obcont = $_REQUEST['obcontext'];*/
       /* $cmpnm = $_REQUEST['cmpnmob'];*/
       /* $acdcode = $_REQUEST['acdcodeob'];
        $oblink = $_REQUEST['oblink'];*/
        ///$cmptyp = $_REQUEST['cmptypob'];

        $notpop = "SELECT `popstatus` FROM  `popup` WHERE  `AgentExt`='$ext' AND  `popstatus`='0'";
        $notpop1 = mysql_query($notpop, $conn);
        $row=mysql_fetch_array($notpop1);

        if ($row>1) {
           header('location:index.php');
        }
        else{

            $indno = "INSERT INTO `popup`(`date`, `callid`, `queuename`, `AgentExt`, `DID`, `QueUniuqId`, `CLI`, `InCampID`, `CampName`, `camptype`, `IfrmLink`, `C_Back`, `dis`, `Sub_Dis`, `call_back`, `min`, `hour`, `popstatus`,`sr_id`, `leadid`, `ctid`, `redial_datetime`, `remarks`, `visit_date`, `reminder_date`, `followup_date`, `post_feedback_date`, `uniqueid`, `singledis_status`) VALUES (NOW(),UNIX_TIMESTAMP(),'$acdcode','$ext','','','$num','$cmpid','$cmpnm','$cmptyp','$oblink','','','','','','','0','0' as sr_id,'' as leadid,'' as ctid,'0000:00:00 00:00:00' as `redial_datetime`,'' as remarks,'0000:00:00 00:00:00' as visit_date,'0000:00:00 00:00:00' as reminder_date,
               '0000:00:00 00:00:00' as followup_date,'0000:00:00 00:00:00' as post_feedback_date,'' as uniqueid,'0' as singledis_status )";
            $indno1 = mysql_query($indno, $conn);

        $timeout = 10;
        $asterisk_ip = "127.0.0.1";

        $socket = fsockopen($asterisk_ip,"5038", $errno, $errstr, $timeout);
        fputs($socket, "Action: Login\r\n");
        fputs($socket, "UserName: cron\r\n");
        fputs($socket, "Secret: 1234\r\n\r\n");
        $wrets=fgets($socket,128);
        //echo $wrets;
        //exit;
        $num = $_REQUEST['number'];
        $ext = $_REQUEST['ext'];

        fputs($socket, "Action: Originate\r\n" );
        fputs($socket, "Channel: Local/$ext@worxpbx-outcall\r\n" );
        //   fputs($socket, "Channel: SIP/$ext\r\n" );
        fputs($socket, "Exten: $num\r\n" );
        fputs($socket, "Callerid: $num\r\n" );
        //  fputs($socket, "Variable: san_from_no = $ext\r\n" );
        //  fputs($socket, "Variable: san_to_no = $num\r\n" );
        fputs($socket, "Context: $obcont\r\n" );
        //fputs($socket, "Context: from-pstn\r\n" );
        fputs($socket, "Priority: 1\r\n" );
        fputs($socket, "Async: yes\r\n\r\n" );
        $wrets=fgets($socket,128);
        sleep(1);
       echo $wrets;
        fputs($socket, "Action: Logoff\r\n\r\n" );
        fclose($socket);
      return;

/*      $mcdial = mysqli_query($conn,"UPDATE  `Misscall` SET  `data` =  '1' WHERE id =  '$mcid'") or die(mysqli_error($conn));
        //echo $result;   */

    /*  header('location:index.php');*/


    }      
}
}

?>	
