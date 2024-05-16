#!/usr/bin/php -q
<?
require('phpagi.php');
$agi = new AGI();
$agi->exec('NoOp "' . '***Start***' . '"'); // debug begining
$qualification=$argv[4]; // the argument passed from elastix
if ($qualification <> '0') { // if something useful was pressed
$agi->exec('NoOp "' . 'qualifications: '.$qualification . '"'); // just for debug
// open database conection
$conexion=mysql_connect("localhost","root","tumko34h1se")
or die ("Error en Conexion");
mysql_select_db("worxpbx")
or die ("failure in mysql_select_db");
// query for insert
$sql ="insert into feedback (calling_cid,int_attend,qualification)";
$sql.="values ('$argv[2]','$argv[1]','$qualification')";
//$agi->exec('NoOp "' . $sql . '"');
// do the insert
mysql_query ($sql) or die(mysql_error());
mysql_close($conexion);
}
$agi->exec('NoOp "' . "*** END ***" . '"'); // en debug.
?>
