#!/usr/bin/php -q
<?php 

set_time_limit(0); 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require ('/var/www/html/bigpbx/AGI/lib/phpagi/phpagi.php'); // I know very little about PHP and AGI

// Set Variable and initialize new AGI

$agi = new AGI();
$agi->answer();

#$no=preg_replace("#[^0-9]#","",$agi->request[agi_callerid]);
//$exten=$agi->request[agi_extension];
$dnid = $agi->request[agi_dnid];
$date = date('Y-m-d H:i:s');

//###############################################
$agi->verbose("Coming CID================:" .$no);

$agi->verbose("Dialed DID================:" .$dnid);


$db = 'bigdialer';
$dbuser = 'root';
$dbpass = 'cce55c5c21';
$dbhost = 'localhost';

$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$db);

// $q12="select did from cc_did where did='$exten'";
// $r12=mysqli_query($conn, $q12);
// while($row = mysqli_fetch_array($r12))
// {
// $didlist = $row['did'];
// }
$myquery_mod="select cc_did_mod from cc_did where did='$dnid'";
$myresult_mod=mysqli_query($conn, $myquery_mod);
while($row = mysqli_fetch_array($myresult_mod))
{
$did_mod_case = $row['cc_did_mod'];
}


$myquery="select cc_did_cid,cc_did_mod from cc_did where cc_did_mod='$did_mod_case' AND did='$dnid'";
$myresult=mysqli_query($conn, $myquery);
while($row = mysqli_fetch_array($myresult))
{
$phonelist = $row['cc_did_cid'];
$did_mod = $row['cc_did_mod'];
}
$phonelist = $phonelist;
$temp=explode(",",$phonelist);
$total = count($temp);
for($i=0; $i< $total; $i++)
{
  if($temp[$i] == $no)
    {
    $phonelist = $temp[$i];
    }
}

$agi->verbose("Searched for CID in Database================:" .$myquery);

$agi->verbose("After query CID NUMBER ================:" .$phonelist);
$agi->verbose("After query CID NUMBER ================:" .$did_mod);

if($did_mod_case == 0){
	if($no == $phonelist)
	{
	$agi->verbose("Call can not be procced to this================:" .$no);	
	$agi->hangup(); 
	}
	} 
else if($did_mod_case == 1){
	
			if($no == $phonelist )
		{
			$agi->verbose("Call can not be procced to this================:" .$no);
		}
	
	else{
		$agi->verbose("Call can not be procced to this================:" .$phonelist);	
		$agi->hangup(); 
	}
}
else{
	$agi->verbose("CID is Authorised to  procced the call================:" .$phonelist);
}

?>



