<?php

include "/var/www/html/callanalog/common/lib/phpagi/phpagi-asmanager.php";

$server_ip = "37.61.219.110";
// $socket = @fsockopen($server_ip, 5038);
$socket = @fsockopen($server_ip, 4783);
$response = "";
if (!is_resource($socket)) {
    echo "conn failed in Engconnect ";
    exit;
}
fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: NikasqkR\r\n");
fputs($socket, "Secret: }Sv*54#Gu(o]g83\r\n\r\n");
fputs($socket, "Action: Command\r\n");
fputs($socket, "Command: core show channels\r\n\r\n");
fputs($socket, "Action: Logoff\r\n\r\n");
while (!feof($socket))
    $response .= fread($socket, 8192);
fclose($socket);

// echo '<pre>';print_r($response);exit;

$output = explode("\n", $response);

foreach ($output as $value) {
    $value = trim($value);
    if (empty($value)) {
        continue;
    }
    $columns[] = preg_split('/\s+/', $value);
}
echo '<pre>';print_r($columns);
// echo $columns[12][1] . ' ' . $columns[12][2] . ' ' . $columns[12][3];
?>