<?php
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
fputs($socket, "Command: sip show peers\r\n\r\n");
fputs($socket, "Action: Logoff\r\n\r\n");
while (!feof($socket))
    $response .= fread($socket, 8192);
// $response .= fread($socket, 4783);
fclose($socket);

echo '<pre>';print_r($response);exit;


/* if (in_array('A', $columns)) {
    unset($columns[5]);
    $columns = array_values($columns);
    $user_type = "Soft Phone";
} else {
    $user_type = "Web Phone";
} */

/* 
$localFilePath = '/var/www/html/callanalog/admin/webrtc_template.conf';
$remoteFilePath = '/var/www/html/webrtc_template.conf';
$remoteServer = '37.61.219.110';
$port = 19645; // Change this to your desired port.
$username = 'asteruser';
$privateKeyFile = '/var/www/.ssh/id_rsa';
$publicKeyFile = '/var/www/.ssh/id_rsa.pub'; // Replace with the actual path to your public key file


// Establish an SSH2 connection to the remote server.
$connection = ssh2_connect($remoteServer, $port);

if (!$connection) {
    die("Unable to connect to the remote server.");
}
// Authenticate with the private key.

if (ssh2_auth_pubkey_file($connection, $username, $publicKeyFile, $privateKeyFile)) {
    // Securely transfer the file to the remote server.
    if (ssh2_scp_send($connection, $localFilePath, $remoteFilePath, 0644)) {
        echo "File transferred successfully.";
    } else {
        echo "Failed to transfer the file.";
    }
} else {
    echo "Authentication failed.";
}

// Close the SSH2 connection.
ssh2_disconnect($connection); */
?>