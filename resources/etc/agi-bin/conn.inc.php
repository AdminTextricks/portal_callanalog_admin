<?php
$link = mysql_connect('localhost', 'root', 'tumko34h1se');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db('dialout',$link);
?> 
