<?php 

$connection = mysqli_connect("localhost", "root", "tumko34h1se",'myphonesystem');

if(isset($_POST['submit']))
{
$update = "update cc_sip_buddies set callerid='".$_POST['callerid']."' where name in (801,802,803,804)";
$update_result = mysqli_query($connection,$update);

$insert = "insert into cc_newcallerid (callerid) values ('".$_POST['callerid']."')";
$insert_result = mysqli_query($connection,$insert);

if($update)
{
	$message = 'Your caller id '. $_POST['callerid'] .' has been successfully updated';
}

}

?>

<!DOCTYPE html>
<html>
<body>

<h2>Enter new caller id in input box</h2>


<form action="" name="myform" method="post">
  <label for="callerid">Caller ID:</label><br><br>
  <input type="text" id="callerid" name="callerid" maxlength="13"><br><br>
  
  <input type="submit" name="submit" value="Submit">
  
</form>


<br><br><br>
<hr>
<center>List of CLI which you need to you daily one by one</center>
<hr>
<h3>
61385926458
<br>
61385926459
<br>
61385926460
<br>
61385926461
<br>
61385926462
<br>
</h3>
<br>
<br>
<?php echo $message; ?>
</body>
</html>

