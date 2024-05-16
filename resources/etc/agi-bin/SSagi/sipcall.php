!#/usr/bin/php -q
<?php
require'phpagi/phpagi.php';
$exten = $argv[exten];
$agi->set_variable("CALLERID(num)","".$caller_phone."");
$agi->exec('Dial', "SIP/".$dialed_no.",25,r");
exit(0);


