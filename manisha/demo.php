<?php
$localFilePath = '/var/www/html/callanalog/admin/manisha/webrtc_template.conf';
$remoteFilePath = '/tmp/webrtc_template.conf';
$remoteServer = '37.61.219.110';
$port = 18634; // Change this to your desired port.
$username = 'root';
$privateKeyFile = '/root/.ssh/id_rsa';
$publicKeyFile = '/root/.ssh/id_rsa.pub'; // Replace with the actual path to your public key file

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
ssh2_disconnect($connection);
?>

