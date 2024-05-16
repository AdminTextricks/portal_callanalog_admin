<?php require_once('header.php'); ?>



<!-- $created_at = date('Y-m-d h:i:s');
$updated_at = date('Y-m-d h:i:s');
$insert_queue = "INSERT INTO cc_queue_table(name, queue_name, description, maxlen, reportholdtime, periodic_announce_frequency, periodic_announce, strategy, joinempty,leavewhenempty, autopause, announce_round_seconds, retry, wrapuptime, 
announce_holdtime, announce_position, announce_frequency, timeout, context, 
    musicclass, autofill, ringinuse, musiconhold, monitor_type, 
monitor_format, servicelevel, queue_thankyou, queue_youarenext, queue_thereare, 
queue_callswaiting, queue_holdtime, queue_minutes, queue_seconds, queue_lessthan, 
queue_reporthold, relative_periodic_announce, queue_timeout, fail_status, fail_dest, 
fail_data, status, user_id, email, created_at, 
updated_at, domain, assigned_user, announce, eventmemberstatus, 
eventwhencallled, memberdelay, setinterfacevar, timeoutrestart, weight, 
clientId, play_ivr) VALUES 
('".$_POST['queueNum']."','".$_POST['queueName']."','".$_POST['description']."','".$_POST['queuemaxlen']."','".$_POST['_queuereportholdtime']."','".$_POST['q_periodic_announce_frequency']."',
'".$_POST['q_periodic_announce']."','".$_POST['stratergy']."','".$_POST['_q_joinempty']."','".$_POST['_q_leavewhenempty']."','".$_POST['_q_autopause']."','".$_POST['q_announce_round_seconds']."','".$_POST['q_retry']."','".$_POST['q_wrapuptime']."',
'".$_POST['_q_announce_holdtime']."','','".$_POST['q_announce_frequency']."','".$_POST['queue_timeout']."','".$_POST['q_context']."',
'".$_POST['q_musicclass']."','".$_POST['q_autofill']."','".$_POST['_q_ringinuse']."','".$_POST['queue_musiconhold']."','".$_POST['q_monitor_type']."',
'".$_POST['q_monitor_format']."','".$_POST['q_servicelevel']."','".$_POST['q_queue_thankyou']."','".$_POST['q_queue_youarenext']."','".$_POST['q_queue_thereare']."',
'".$_POST['q_queue_callswaiting']."','".$_POST['q_queue_holdtime']."','".$_POST['q_queue_minutes']."','".$_POST['q_queue_seconds']."','".$_POST['q_queue_lessthan']."',
'".$_POST['q_queue_reporthold']."','".$_POST['q_relative_periodic_announce']."','".$_POST['queue_timeout']."','','',
'','".$_POST['status']."','2','','".$created_at."','".$updated_at."','','".$selectedUser."','','0',
'0','0','','0','0','".$_POST['clientId']."','".$_POST['ivr']."')";
$result_queue = mysqli_query($connection , $insert_queue);
if($result_queue){
    $message = 'Queue Added Succesfully!';
} -->

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1"> Add Price <span style="margin-left:50px;color:blue;">
                                <?php echo $message; ?>
                            </span></h2>
                        <div class="table-data__tool-right">
                            <a href="users.php">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="fa fa-eye" aria-hidden="true"></i> User</button></a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="big_live_outer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="queue_info">
                            <form id="userForm" action="" name="add" method="post">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Country</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select id="country" name="country" class="form-control">
                                            <option value="">Select</option>
                                            <?php
                                            $sql = "SELECT * FROM `cc_country`";
                                            $result = mysqli_query($connection, $sql) or die("query failed.");
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <option value="<?php echo $row['countryprefix']; ?>">
                                                        <?php echo $row['countryname']; ?>
                                                    </option>

                                                <?php }
                                            } ?>

                                        </select>
                                    </div>
                                </div>


                                <input id="role" name="role" value="2" class="form-control" type="hidden" value="0" />

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Price*</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input id="price" name="price" placeholder="price" class="form-control"
                                            type="text" value="<?php if (isset($_POST['price'])) {
                                                echo $_POST['price'];
                                            } else {
                                                echo "";
                                            } ?>" />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Type*</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input id="type" name="type" placeholder="DID/Extension" class="form-control"
                                            type="text" value="<?php if (isset($_POST['type'])) {
                                                echo $_POST['type'];
                                            } else {
                                                echo "";
                                            } ?>" />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Tax Type*</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" name="tax_type" id="tax_type" placeholder="Tax Type"
                                            class="form-control" />
                                    </div>
                                </div>

                                <?php echo $msg; ?>

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Tax % </label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input id="tax_per" name="tax_per" placeholder="Tax %" class="form-control"
                                            type="text" value="" />
                                    </div>
                                </div>
                                <div class="form-group pull-right">
                                    <button name="submit" value="submit" type="submit" id="submit"
                                        class="btn btn-primary btn-sm">Submit</button>
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
    <script>
        $(document).ready(function () {
            function loadTable() {
                $.ajax({
                    url: 'did_price_load.php',
                    type: 'POST',
                    success: function (data) {
                        $("#table-data").html(data);
                    }
                });
            }
            loadTable();

            // insert new record.
            $("#submit").on("click", function (e) {
                e.preventDefault();
                var country_id = $("#country").val();
                var price = $("#price").val();
                var type = $("#type").val();
                var tax_type = $("#tax_type").val();
                var tax_per = $("#tax_per").val();

                $.ajax({
                    url: 'insert-price.php',
                    type: 'POST',
                    data: { country_id: country_id, price: price, type: type, tax_type: tax_type, tax_per: tax_per },
                    success: function (data) {
                        if (data == '1') {
                            $("#userForm").trigger("reset");
                            loadTable();
                        }
                    }
                });


            });
        });
    </script>
    <?php require_once('footer.php'); ?>