<?php require_once('header.php');
$msg = '';
if (isset($_POST['submit'])) {


    $carrier_id = $_POST['carrier_id'];
    $carrier_name = $_POST['carrier_name'];
    $carrier_description = $_POST['carrier_description'];
    $registration_string = $_POST['registration_string'];
    $account_entry = $_POST['account_entry'];
    $protocall = $_POST['protocall'];
    $server_ip = $_POST['server_ip'];
    $active  =  $_POST['active'];
    $insert_trunk = "insert into server_carriers (carrier_id,carrier_name,carrier_description,registration_string,account_entry,protocall,server_ip,active) value ('" . $carrier_id . "','" . $carrier_name . "','" . $carrier_description . "','" . $registration_string . "','" . $account_entry . "','" . $protocall . "','" . $server_ip . "','" .  $active  . "')";
    // $result_trunk = mysqli_query($con, $insert_trunk);
    // echo $insert_trunk;exit;

    $webrtc_conf_path = "/var/www/html/callanalog/admin/portal_carrier.conf";
    $current_content = file_get_contents($webrtc_conf_path);

    if ($_POST['active'] == 'Y') {
        $register_string =
            "\n\n\n;[$carrier_name]\nregister=>$registration_string\n\n\n;PORTAL Carrier: $carrier_name - $carrier_name\n;$carrier_name\n$account_entry";
        if (strpos($current_content, "[$carrier_name]") !== false) {
            $current_content = preg_replace("/\[$carrier_name\].*?;\[.*?\]/s", $register_string, $current_content);
        } else {
            $current_content .= $register_string;
        }
        file_put_contents($webrtc_conf_path, $current_content, LOCK_EX);

        echo "PORTAL Carrier registration successful. The Server name $carrier_name has been added or updated in the portal_carrier.conf file.";
    } else {
        $lines = explode("\n", $current_content);
        $output = '';
        $found = false;

        foreach ($lines as $line) {
            if (strpos($line, "[$carrier_name]") !== false) {
                $found = true;
                continue;
            }
            if ($found && strpos($line, ";[") === 0) {
                $found = false;
            }
            if (!$found) {
                $output .= $line . "\n";
            }
        }
        file_put_contents($webrtc_conf_path, $output, LOCK_EX);
        echo "PORTAL Carrier removed. The Server name $carrier_name has been removed from the portal_carrier.conf file.";
    }

    if ($active == 'Y' || $active == 'N') {
        $result = shell_exec('sudo /var/www/html/callanalog/admin/testtransfer.sh');
        if ($result) {
            echo "File Transfer Successfully..";
        } else {
            echo "The File Transfer Failed ..";
        }
        sip_reload();
    }

    $result_trunk = mysqli_query($con, $insert_trunk);

    if ($result_trunk) {

        $_SESSION['msg'] = 'Inbound added successfully!';
        // echo "<script>window.location = 'inboundroute.php';</script>";
    }
}


$select_pagetrunk = "select server_ip from cc_servers";
$result_showtrunk = mysqli_query($con, $select_pagetrunk);
?>


<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1"> Inbound Add <span style="margin-left:50px;color:blue;"><?php echo $msg; ?></span></h2>
                        <div class="table-data__tool-right">
                            <a href="inboundroute.php">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="fa fa-eye" aria-hidden="true"></i> Inbound</button></a>
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
                                    <div class="col col-md-4">
                                        <label for="text-input" class="form-control-label">Carrier ID</label>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <input id="provider" name="carrier_id" placeholder="Carrier ID" class="form-control" type="text" value="" />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class="form-control-label">Carrier Name:</label>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <input id="trunkcode" name="carrier_name" placeholder="Carrier Name" class="form-control" type="text" value="" />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class="form-control-label">Carrier Description:</label>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <input id="trunkprefix" name="carrier_description" placeholder="Carrier Description" class="form-control" type="text" value="" />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class="form-control-label">Registration String</label>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <input id="removeprefix" name="registration_string" placeholder="Registration String" class="form-control" type="text" value="" />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class="form-control-label">Account Entry</label>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <textarea name="account_entry" placeholder="Account Entry" class="form-control" type="text"> </textarea>
                                    </div>
                                </div>


                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class="form-control-label">Protocol</label>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <select name="protocall" id="protocall" class="form-control">
                                            <option value="SIP">SIP</option>
                                            <option value="PJSIP">PJSIP</option>
                                            <!-- <option value="IAX2">IAX2</option>
                                            <option value="EXTERNAL">EXTERNAL</option> -->
                                        </select>


                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class="form-control-label">Server IP</label>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <select id="server_ip" name="server_ip" placeholder="Server IP" class="form-control">
                                            <option value="">Choose Server IP</option>
                                            <option value="37.61.219.110">37.61.219.110</option>
                                            <option value="85.195.76.161">85.195.76.161</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class="form-control-label">Active</label>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <select id="active" name="active" class="form-control">
                                            <option value="Y">Active</option>
                                            <option value="N">Inactive</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group pull-right">
                                    <button type="submit" name="submit" value="submit" class="btn btn-primary btn-sm">Submit</button>
                                </div>
                                <p style="color:blue;"><?php echo $msg; ?></p>
                            </form>

                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>