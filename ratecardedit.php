<?php require_once('header.php');
// echo '<pre>';print_r($_SESSION);exit;
$message = '';
$id = $_GET['id'];
$query = "SELECT * FROM `ratecard_group` WHERE id = '" . $id . "'";
$result = mysqli_query($connection, $query) or die("query failed : query");
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $group_name = $row['group_name'];
    $status = $row['status'];
}

if (isset($_POST['update'])) {
    $group_name = $_POST['group_name'];
    $status = $_POST['status'];
    $updated_at = date("Y:m:d H:i:s");
    
    $sql = "UPDATE `ratecard_group` SET `group_name`='".$group_name."', `status`='".$status."',`updated_at`='".$updated_at."' WHERE `id`='".$id."'";
    $result = mysqli_query($connection, $sql) or die("query failed : sql");
    if ($result) {
        $_SESSION['msg'] = "Plan Update Successfully...!!";
        $activity_type = 'Plan Update';
        $msg = 'Plan : ' . $_POST['group_name'] . ' ' . 'Plan Update Succesfully! By Admin';
        user_activity_log($_SESSION['login_user_id'], $_SESSION['userroleforclientid'], $activity_type, $msg);
        echo '<script>window.location.href="ratecard.php"</script>';
    }
}
?>
<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Plan Information<span style="margin-left:50px;color:blue;">
                                <?php echo $message; ?>
                            </span><br></h2>
                        <div class="table-data__tool-right">
                            <span style="margin-left:50px;color:blue;">
                                <?php echo $registration; ?>
                            </span>
                            <a href="ratecard.php">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="fa fa-tty" aria-hidden="true"></i>Plan</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="big_live_outer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="queue_info">
                            <form id="ringForm" action="" method="post">

                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Tarrif Name</label>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <input id="group_name" name="group_name" placeholder="Tarrif Name" value="<?php if (isset($_POST['group_name'])) {
                                            echo $_POST['group_name'];
                                        } else {
                                            echo $group_name;
                                        } ?>" class="form-control" type="text" required />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Status</label>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <select id="status" name="status" class="form-control" required>
                                            <option <?php
                                            if ($status == 1 || (isset($_POST['status']) && $_POST['status'] == 1)) {
                                                echo 'selected';
                                            }
                                            ?> value="1">Active</option>
                                            <option <?php
                                            if ($status == 0 || (isset($_POST['status']) && $_POST['status'] == 0)) {
                                                echo 'selected';
                                            }
                                            ?> value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group pull-right">
                                    <button type="submit" name="update" value="submit"
                                        class="btn btn-primary btn-sm">Update</button>
                                </div>
                                <p style="color:blue;">
                                    <?php echo $message; ?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>