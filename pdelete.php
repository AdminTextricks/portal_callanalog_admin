<?php require_once('connection.php');
$user_id = $_POST['id'];

$sql = "SELECT `name`, `profile_image` FROM `users_login` WHERE `id`='".$user_id."'";
$result = mysqli_query($connection, $sql) or die("query failed");
if(mysqli_num_rows($result) > 0){
    while($rows = mysqli_fetch_assoc($result)){
        $name = $rows['name'];
        $filename = $rows['profile_image'];
    }
}

$querry1= "Update `users_login` set profile_image='' WHERE `id`='".$user_id."'";
if ( mysqli_query($connection , $querry1)){
    $folder = "profile_image/".$user_id.$name."_".$filename;
    unlink($folder);
    echo "1";
}else{
    echo "";
}

?>