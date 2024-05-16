
<?php
  $dbhost = 'localhost';
        $dbuser = 'root';
        $dbpass = 'tumko34h1se';
        $dbname = 'asterisk';
        $connA = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
        mysql_select_db($dbname,$connA);
?>

