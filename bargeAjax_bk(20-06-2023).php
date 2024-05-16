<?php

include 'connection.php';

$bargechannel = "select agent_channel from cc_live_calls where agent_number='".$_POST['hidden_ext']."'";
$result_barge = mysqli_query($connection,$bargechannel);
while($rowbarge = mysqli_fetch_array($result_barge))
{
$channelbarge = $rowbarge['agent_channel'];
}
$channelbarge = substr($channelbarge, 4);

$callbackUrl = "http://139.84.172.41/myphonesystems/myphone/dialer_api/bargeIn.php?bargeNumber=".$_POST['barge']."&bargeChannel=".$channelbarge.""; 


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
echo $response;

?>
