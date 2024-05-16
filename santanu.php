<?php
    $ip = "123.123.34.56"; // Enclose the IP address in quotes
    // Use escapeshellarg() to escape the shell argument
    $escaped_ip = escapeshellarg($ip);
    // Execute the shell script with the IP address as an argument
    $result = shell_exec("sudo /var/www/html/callanalog/admin/transfer.sh $escaped_ip");
    if ($result) {
        echo "File Transfer Successfully..";
    } else {
        echo "File Transfer Failed..";
    }
?>
