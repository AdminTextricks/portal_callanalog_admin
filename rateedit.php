<?php require_once('header.php');
// echo '<pre>';print_r($_SESSION);exit;
$id = $_GET['id'];
$query = "select *,ratecard_group.group_name, cc_trunk.trunkcode from add_rate LEFT JOIN ratecard_group ON add_rate.rategroup_id=ratecard_group.id LEFT JOIN cc_trunk ON add_rate.id_trunk=cc_trunk.id_trunk WHERE add_rate.id = '".$id."'";
$result = mysqli_query($connection, $query) or die("query failed : query");
if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $group_name = $row['rategroup_id'];
    $prefix = $row['destination'];
    $initail_rate = $row['rateinitial'];
    $init_block = $row['initblock'];
    $billing_block = $row['billingblock'];
    $dial_status = $row['dialstatus'];
    $id_trunk = $row['id_trunk'];
}
$message = '';
if (isset($_POST['update'])) {
    $group_name = $_POST['rate_group'];
    $prefix = $_POST['prefix'];
    $initail_rate = $_POST['initail_rate'];
    $init_block = $_POST['init_block'];
    $billing_block = $_POST['billing_block'];
    $dial_status = $_POST['dial_status'];
    $trunk = $_POST['trunk'];
    $status = $_POST['status'];
    $updated_at = date("Y:m:d H:i:s");

    $sql = "UPDATE `add_rate` SET `rategroup_id`='".$group_name."',`destination`='".$prefix."',`rateinitial`='".$initail_rate."',`initblock`='".$init_block."',`billingblock`='".$billing_block."',`dialstatus`='".$dial_status."',`id_trunk`='".$trunk."',`stopdate`='".$updated_at."' WHERE id = '".$id."'";
    $result = mysqli_query($connection, $sql) or die("query failed : sql");
    if ($result) {
        $_SESSION['msg'] = "Rate Update Successfully...!!";
        $activity_type = 'Rate Update';
        $msg = 'Rate Card Group : ' . $_POST['group_name'] . ' ' . 'Rate Updated Successfully! By Admin';
        //user_activity_log($_SESSION['login_user_id'], $_SESSION['userroleforclientid'], $activity_type, $msg);
        echo '<script>window.location.href="rate.php"</script>';
    }
}


?>
<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Rate Information<span style="margin-left:50px;color:blue;">
                                <?php echo $message; ?>
                            </span><br></h2>
                        <div class="table-data__tool-right">
                            <span style="margin-left:50px;color:blue;">
                                <?php echo $registration; ?>
                            </span>
                            <a href="rate.php">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="fa fa-tty" aria-hidden="true"></i>Rate</button>
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
                                        <label for="text-input" class=" form-control-label">Prefix Name</label>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <select name="rate_group" class="form-control" required>
                                            <option value="">---Select---</option>
                                            <?php
                                            $select_rate = "SELECT * FROM `ratecard_group`";
                                            $result_rate = mysqli_query($connection, $select_rate) or die("query failed : select_rate");
                                            if (mysqli_num_rows($result_rate) > 0) {
                                                while ($row = mysqli_fetch_assoc($result_rate)) {
                                                    if (($_POST['rate_group'] == $row['id']) || $row['id']==$group_name) {
                                                        $select = "selected";
                                                    } else {
                                                        $select = "";
                                                    }
                                                    ?>
                                                    <option <?php echo $select; ?> value="<?php echo $row['id']; ?>">
                                                        <?php echo $row['group_name']; ?>
                                                    </option>
                                                <?php }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Country Prefix</label>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <input type="text" name="prefix" class="form-control" value="<?php if (isset($_POST['prefix'])) {
                                            echo $_POST['prefix'];
                                        } else {
                                            echo $prefix;
                                        } ?>" required />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Selling Price</label>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <input type="text" name="initail_rate" class="form-control" value="<?php
                                        if (isset($_POST['initail_rate'])) {
                                            echo $_POST['initail_rate'];
                                        } else {
                                            echo $initail_rate;
                                        }
                                        ?>" required />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Billing Initial</label>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <input type="text" name="init_block" class="form-control" value="<?php
                                        if (isset($_POST['init_block'])) {
                                            echo $_POST['init_block'];
                                        } else {
                                            echo $init_block;
                                        }
                                        ?>" required />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Billing Block</label>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <input type="text" name="billing_block" class="form-control" value="<?php 
                                        if(isset($_POST['billing_block'])){
                                            echo $_POST['billing_block'];
                                        }else{
                                            echo $billing_block;
                                        }
                                        ?>" required />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Status</label>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <select name="dial_status" class="form-control" required>
                                            <option value="">---Select---</option>
                                            <option <?php 
                                            if($dial_status == '1' || (isset($_POST['dial_status']) && $_POST['dial_status']=='1')){
                                                echo "selected";
                                            }
                                            ?> value="1">Active</option>
                                            <option <?php 
                                            if($dial_status == '0' ||(isset($_POST['dial_status']) && $_POST['dial_status']=='0')){
                                                echo "selected";
                                            }
                                            ?> value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Carrier</label>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <select id="trunk" name="trunk" class="form-control" required>
                                            <option value="">---Select---</option>
                                            <?php
                                            $select_trunk = "SELECT `id_trunk`,`trunkcode` FROM `cc_trunk`";
                                            $result_trunk = mysqli_query($connection, $select_trunk) or die("query failed : select_trunk");
                                            if (mysqli_num_rows($result_trunk) > 0) {
                                                while ($rows = mysqli_fetch_assoc($result_trunk)) {
                                                    if(($id_trunk == $rows['id_trunk']) || ($_POST['trunk'] == $rows['id_trunk'])){
                                                        $select = "selected";
                                                    }else{
                                                        $select = "";
                                                    }
                                                    ?>
                                                    <option <?php echo $select; ?> value="<?php echo $rows['id_trunk']; ?>">
                                                        <?php echo $rows['trunkcode']; ?>
                                                    </option>
                                                <?php }
                                            }
                                            ?>
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