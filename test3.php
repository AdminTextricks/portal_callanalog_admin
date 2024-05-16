<?php

/* $localFile = "/var/www/html/myphonesystems/admin/webrtc_template.conf";
$remoteDirectory = "/var/www/html/webrtc_template.conf";
$remoteServer = "37.61.219.110";
$remotePort = "18634";
$remoteUser = "root";

// Establish an SSH connection using public key authentication
$connection = ssh2_connect($remoteServer, $remotePort, array('hostkey' => 'ssh-rsa'));

if (!$connection) {
    die('Connection failed');
}

if (!ssh2_auth_pubkey_file($connection, $remoteUser, '/root/.ssh/id_rsa.pub', '/root/.ssh/id_rsa.pem', '')) {
    die('Authentication failed');
}

// Use ssh2_scp_send to transfer the file
if (!ssh2_scp_send($connection, $localFile, $remoteDirectory)) {
    die('File transfer failed');
}

echo 'File transferred successfully';

// Close the SSH connection
ssh2_disconnect($connection); */
?>

