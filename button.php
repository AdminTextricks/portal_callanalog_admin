<?php
session_start();
echo $machine_id = $_GET['id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>On off toggle</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://write.corbpie.com/wp-content/litespeed/localres/cdnjs.cloudflare.com/ajax/libs/bootswatch/4.5.0/flatly/bootstrap.min.css"/>
    <script src="https://write.corbpie.com/wp-content/litespeed/localres/cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajax({
                type: "GET",
                url: "status.php",
                data: {"id": <?php echo $machine_id;?>},
                success: function (data) {
                    console.log(data)
                }
            });
        });
    </script>
</head>
<?php
if (isset($_POST['form_submit'])) {//Form was submitted
    (isset($_POST['machine_state'])) ? $status = 1 : $status = 0;
    //Update DB
    $db = new PDO('mysql:host=localhost;dbname=myphonesystem;charset=utf8mb4', 'root', 'tumko34h1se');
    $update = $db->prepare("UPDATE `cc_card` SET `webrtc` = 1 WHERE `id` = '".$machine_id."';");
    $update->execute([$status, $machine_id]);
} else {//Page was loaded
    $status = $_SESSION['status'];
}
if ($status) {//status = 1 (on)
    $status_str = "on";
    $checked_status = "checked";
} else {
    $status_str = "off";
    $checked_status = "";
}
?>
<body>
<div class="container">
    <div class="row text-center">
        <div class="col-12">
            <form method="post">
                <fieldset>
                    <legend>on/off status for machine: <?php echo $machine_id; ?></legend>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1"
                                   name='machine_state' <?php echo $checked_status; ?>>
                            <label class="custom-control-label"
                                   for="customSwitch1">Currently <?php echo $status_str; ?></label>
                        </div>
                        <input type="hidden" name="form_submit" value="">
                    </div>
                </fieldset>
                <input type="submit" class="btn btn-info btn-sm" name="submit" value="Update"/>
            </form>
        </div>
    </div>
</div>
</body>
</html>
