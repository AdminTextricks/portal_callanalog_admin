<?php

include 'connection.php';

$bargechannel = "select agent_channel,user_id from cc_live_calls where agent_number='".$_POST['hidden_ext']."'";
$result_barge = mysqli_query($connection,$bargechannel);
while($rowbarge = mysqli_fetch_array($result_barge))
{
	$channelbarge = $rowbarge['agent_channel'];
	$user_id = $rowbarge['user_id'];
}
$channelbarge = substr($channelbarge, 4);

$callbackUrl = "https://portal.callanalog.com/callanalog/dialer_api/bargeIn.php?bargeNumber=".$_POST['barge']."&bargeChannel=".$channelbarge.""; 

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $callbackUrl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

/*if(curl_exec($curl) === false)
{
    echo 'Curl error: ' . curl_error($curl);
}*/
curl_close($curl);

$newRespone = $response;

$new_arr = json_decode($newRespone,true);

$srcFile = explode('/', $new_arr['fileName']);

// /home/tmp/65154d6e2fec25568.call
if(file_exists($new_arr['fileName'])){
    $filename = end($srcFile);
    $srcFile  = $new_arr['fileName'];
    $dstFile  = '/var/www/html/bargecallanalog/'.$filename;

	
	$user_server = "SELECT server_ip, server_id, sip_port FROM `cc_servers` where user_id='".$user_id."' LIMIT 1";
	$user_barge  = mysqli_query($connection,$user_server);
	$userbarge   = mysqli_fetch_array($user_barge);
	
	$server_ip = $userbarge['server_ip'];
	$server_id = $userbarge['server_id'];
	$sip_port  = $userbarge['sip_port'];
	
	if($server_id == 1){

		$conn = ssh2_connect(RHOST, RPORT);

		if (!$conn) {
			die("Unable to connect to the remote server.");
		}
		// Authenticate with the private key.

		if (ssh2_auth_pubkey_file($conn, RUSERNAME, PUBLIC_KEY, PRIVATE_KEY)) {
			// Securely transfer the file to the remote server.
			if (ssh2_scp_send($conn, $srcFile, $dstFile, 0644)) {
				ssh2_sftp_chmod($conn, $dstFile, 0777);
				echo "File transferred successfully on server 1.";
			} else {
				echo "Failed to transfer the file on server 1.";
			}
		} else {
			echo "Authentication failed.";
		}

		// Close the SSH2 connection.
		ssh2_disconnect($conn);
	}

	if($server_id == 2){

		$conn_ = ssh2_connect(SECOND_RHOST, SECOND_RPORT);

		if (!$conn_) {
			die("Unable to connect to the remote server.");
		}
		// Authenticate with the private key.

		if (ssh2_auth_pubkey_file($conn_, SECOND_RUSERNAME, SECOND_PUBLIC_KEY, SECOND_PRIVATE_KEY)) {
			// Securely transfer the file to the remote server.
			if (ssh2_scp_send($conn_, $srcFile, $dstFile, 0644)) {
				ssh2_sftp_chmod($conn_, $dstFile, 0777);
				echo "File transferred successfully on server 2.";
			} else {
				echo "Failed to transfer the file on server 2.";
			}
		} else {
			echo "Authentication failed.";
		}

		// Close the SSH2 connection.
		ssh2_disconnect($conn_);
	}
}

// ssh2_scp_send($conn, $srcFile, $dstFile, 0644);
// echo '<pre>';print_r($new_arr);exit;
echo $response;



?>
