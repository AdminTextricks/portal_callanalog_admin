<?php
require_once('header.php');
$messages = '';
if (isset($_POST['submit'])) {

    $create = date('Y-m-d h:i:s');

    // $insert_trunk = "insert into cc_trunk (trunkcode,trunkprefix,removeprefix,providertech,failover_trunk,providerip,status,id_provider) value 
// ('".$_POST['trunkcode']."','".$_POST['trunkprefix']."','".$_POST['removeprefix']."','".$_POST['providertech']."','".$_POST['failover_trunk']."','".$_POST['providerip']."','".$_POST['status']."','".$lastproviderid."')";	
// $result_trunk = mysqli_query($con,$insert_trunk);

    $update_trunk = "update cc_trunk set trunkcode='" . $_POST['trunkcode'] . "',trunkprefix='" . $_POST['trunkprefix'] . "',removeprefix='" . $_POST['removeprefix'] . "',providertech='" . $_POST['providertech'] . "',failover_trunk='" . $_POST['failover_trunk'] . "',providerip='" . $_POST['providerip'] . "',status='" . $_POST['status'] . "', trunk_show='0' where id_trunk='" . $_GET['id'] . "'";
    $result_trunk = mysqli_query($con, $update_trunk);
    if ($result_trunk) {
        $_SESSION['msg'] = 'Outbound updated successfully!';
        echo '<script>window.location.href="outboundroute.php"</script>';
    } else {
        $_SESSION['msg'] = 'Outbound does not updated successfully!';
        echo '<script>window.location.href="outboundroute.php"</script>';
    }
}

$selecttrunks = "select * from cc_trunk where id_trunk='" . $_GET['id'] . "'";
$resulttrunks = mysqli_query($connection, $selecttrunks);
while ($rowtrunk = mysqli_fetch_array($resulttrunks)) {
    $providerid = $rowtrunk['id_provider'];
    $trunkname = $rowtrunk['trunkcode'];
    $trunkprefixs = $rowtrunk['trunkprefix'];
    $trunkremoves = $rowtrunk['removeprefix'];
    $trunktech = $rowtrunk['providertech'];
    $trunkfail = $rowtrunk['failover_trunk'];
    $trunkproviderip = $rowtrunk['providerip'];
    $trunkstatuss = $rowtrunk['status'];
}

$selectproviders = "select * from cc_provider where id='" . $providerid . "'";
$resultproviders = mysqli_query($connection, $selectproviders);
while ($rowproviders = mysqli_fetch_array($resultproviders)) {
    $providername = $rowproviders['provider_name'];


}

$select_pagetrunk = "select * from cc_trunk";
$result_showtrunk = mysqli_query($con, $select_pagetrunk);
?>


<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1"> Outbound Information <span style="margin-left:50px;color:blue;">
                                <?php echo $messages; ?>
                            </span></h2>
                        <div class="table-data__tool-right">
                            <a href="outboundroute.php">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="fa fa-eye" aria-hidden="true"></i> Outbound</button></a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="big_live_outer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="queue_info">
                            <form id="outboundCCTrunkForm" name="outboundtrunk" action="" method="post">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Provider Name</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input id="provider" readonly name="provider" placeholder="Provider name"
                                            class="form-control" type="text" value="<?php echo $providername; ?>" />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Trunk Name</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input id="trunkcode" name="trunkcode" placeholder="trunkcode name"
                                            class="form-control" type="text" value="<?php echo $trunkname; ?>" />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Add Prefix</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input id="trunkprefix" name="trunkprefix" placeholder="add prefix name"
                                            class="form-control" type="text" value="<?php echo $trunkprefixs; ?>" />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Remove Prefix</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input id="removeprefix" name="removeprefix" placeholder="remove prefix name"
                                            class="form-control" type="text" value="<?php echo $trunkremoves; ?>" />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                    <label for="text-input" class="form-control-label">Provider Tech</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select id="providertech" name="providertech" class="form-control" placeholder="provider tech">
                                        <option <?php if ( $trunktech=='sip') {
                                                echo 'selected="selected"';
                                            } else {
                                                echo '';
                                            } ?> value="sip">SIP</option>
                                              <option <?php if ( $trunktech=='pjsip') {
                                                echo 'selected="selected"';
                                            } else {
                                                echo '';
                                            } ?> value="pjsip">PJSIP</option>
                                        </select>
                                    </div>
                                </div>


                               

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Provider IP</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input id="providerip" name="providerip" placeholder="provider ip"
                                            class="form-control" type="text" value="<?php echo $trunkproviderip; ?>" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Failover Trunk</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select id="failover_trunk" name="failover_trunk" class="form-control">
                                        <option value="-1">Not Defined</option>
                                            <?php while ($row = mysqli_fetch_array($result_showtrunk)) { ?>
                                                <option <?php if ($trunkfail == $row['id_trunk']) {
                                                    echo 'selected="selected"';
                                                } else {
                                                    echo '';
                                                } ?>
                                                    value="<?php echo $row['id_trunk']; ?>">
                                                    <?php echo $row['trunkcode']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Status</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select id="status" name="status" class="form-control">
                                            <option <?php if ($trunkstatuss == 1) {
                                                echo 'selected="selected"';
                                            } else {
                                                echo '';
                                            } ?> value="1">Active</option>
                                            <option <?php if ($trunkstatuss == 0) {
                                                echo 'selected="selected"';
                                            } else {
                                                echo '';
                                            } ?> value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group pull-right">
                                    <button type="submit" name="submit" value="submit"
                                        class="btn btn-primary btn-sm">Submit</button>
                                </div>
                                <p style="color:blue;">
                                    <?php echo $messages; ?>
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