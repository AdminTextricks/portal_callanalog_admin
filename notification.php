<?php require_once('header.php');
if ($_SESSION['userroleforpage'] == 1) {
    $query_client = "SELECT Client.clientName,Client.clientId FROM `Client`";
    $result_client = mysqli_query($connection, $query_client);
} 
?>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <?php
            //if($_SESSION['userroleforpage'] == 1){ ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap ">
                        <h2 class="title-1">Notifications</h2>
                    </div>
                </div>
            </div>
            <?php //} /?>
            <div class="reports_inner_outer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="classic_queue_info">
                            <div class="row">
                                <?php
                                if ($_SESSION['userroleforpage'] == 1) { ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text-input" class=" form-control-label"
                                                style="color:black;margin-left:0px;font-weight:bold;">Select User</label>
                                            <select id="clientId" name="clientId" data-show-subtext="false"
                                                data-live-search="true" class="form-control selectpicker filter" required>
                                                <option value="" selected="selected">All</option>
                                                <?php while ($row = mysqli_fetch_array($result_client)) { ?>
                                                    <option <?php if ($row['clientId'] == $_POST['clientId']) {
                                                        echo 'selected="selected"';
                                                    } else {
                                                        echo '';
                                                    } ?>
                                                        value="<?php echo $row['clientId']; ?>">
                                                        <?php echo $row['clientName']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <input type="hidden" name="clientId" id="clientId"
                                        value="<?php echo $_SESSION['userroleforclientid']; ?>">
                                <?php } ?>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input" class=" form-control-label"
                                            style="color:black;margin-left:0px;font-weight:bold;">Item Type</label>
                                        <select id="item_type" name="item_type" class="form-control filter">
                                            <option value="">All</option>
                                            <option <?php if (isset($_POST['item_type']) && $_POST['item_type'] == 'DID') {
                                                echo 'selected="selected"';
                                            } else {
                                                echo '';
                                            } ?>   value="<?php echo 'DID' ?>">
                                                <?php echo 'DID'; ?>
                                            </option>
                                            <option <?php if (isset($_POST['item_type']) && $_POST['item_type'] == 'Extension') {
                                                echo 'selected="selected"';
                                            } else {
                                                echo '';
                                            } ?> value="<?php echo 'Extension' ?>">
                                                <?php echo 'Extension'; ?>
                                            </option>
                                            <option <?php if (isset($_POST['item_type']) && $_POST['item_type'] == 'Amount Credit') {
                                                echo 'selected="selected"';
                                            } else {
                                                echo '';
                                            } ?>   value="<?php echo 'Amount Credit' ?>">
                                                <?php echo 'Amount Credit'; ?>
                                            </option>
                                            <option <?php if (isset($_POST['item_type']) && $_POST['item_type'] == 'Ring') {
                                                echo 'selected="selected"';
                                            } else {
                                                echo '';
                                            } ?>   value="<?php echo 'Ring' ?>">
                                                <?php echo 'Ring'; ?>
                                            </option>
                                            <option <?php if (isset($_POST['item_type']) && $_POST['item_type'] == 'Queue') {
                                                echo 'selected="selected"';
                                            } else {
                                                echo '';
                                            } ?> value="<?php echo 'Queue' ?>">
                                                <?php echo 'Queue'; ?>
                                            </option>
                                            <option <?php if (isset($_POST['item_type']) && $_POST['item_type'] == 'Conference') {
                                                echo 'selected="selected"';
                                            } else {
                                                echo '';
                                            } ?> value="<?php echo 'Conference' ?>">
                                                <?php echo 'Conference'; ?>
                                            </option>
                                            <option <?php if (isset($_POST['item_type']) && $_POST['item_type'] == 'Voice Mail') {
                                                echo 'selected="selected"';
                                            } else {
                                                echo '';
                                            } ?>   value="<?php echo 'Voice Mail' ?>">
                                                <?php echo 'Voice Mail'; ?>
                                            </option>
                                            <option <?php if (isset($_POST['item_type']) && $_POST['item_type'] == 'IVR') {
                                                echo 'selected="selected"';
                                            } else {
                                                echo '';
                                            } ?>   value="<?php echo 'IVR' ?>">
                                                <?php echo 'IVR'; ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input" class=" form-control-label "
                                            style="color:black;margin-left:0px;font-weight:bold;">Notification
                                            Type</label>
                                        <select id="notification_type" name="notification_type"
                                            class="form-control filter">
                                            <option value="">All</option>
                                            <option <?php if (isset($_POST['notification_type']) && $_POST['notification_type'] == 'Generate') {
                                                echo 'selected="selected"';
                                            } else {
                                                echo '';
                                            } ?> value="<?php echo 'Generate' ?>">
                                                <?php echo 'Generate'; ?>
                                            </option>
                                            <option <?php if (isset($_POST['notification_type']) && $_POST['notification_type'] == 'Purchase') {
                                                echo 'selected="selected"';
                                            } else {
                                                echo '';
                                            } ?> value="<?php echo 'Purchase' ?>">
                                                <?php echo 'Purchase'; ?>
                                            </option>
                                            <option <?php if (isset($_POST['notification_type']) && $_POST['notification_type'] == 'Add') {
                                                echo 'selected="selected"';
                                            } else {
                                                echo '';
                                            } ?> value="<?php echo 'Add' ?>">
                                                <?php echo 'Add'; ?>
                                            </option>
                                            <option <?php if (isset($_POST['notification_type']) && $_POST['notification_type'] == 'Update') {
                                                echo 'selected="selected"';
                                            } else {
                                                echo '';
                                            } ?> value="<?php echo 'Update' ?>">
                                                <?php echo 'Update'; ?>
                                            </option>
                                            <option <?php if (isset($_POST['notification_type']) && $_POST['notification_type'] == 'Delete') {
                                                echo 'selected="selected"';
                                            } else {
                                                echo '';
                                            } ?> value="<?php echo 'Delete' ?>">
                                                <?php echo 'Delete'; ?>
                                            </option>
                                            <!-- <option <?php if (isset($_POST['notification_type']) && $_POST['notification_type'] == 'Conference') {
                                                echo 'selected="selected"';
                                            } else {
                                                echo '';
                                            } ?> value="<?php echo 'Conference' ?>">
                                                    <?php echo 'Conference'; ?>
                                                </option>
                                                <option <?php if (isset($_POST['notification_type']) && $_POST['notification_type'] == 'Voice Mail') {
                                                    echo 'selected="selected"';
                                                } else {
                                                    echo '';
                                                } ?> value="<?php echo 'Voice Mail' ?>">
                                                    <?php echo 'Voice Mail'; ?>
                                                </option>
                                                <option <?php if (isset($_POST['notification_type']) && $_POST['notification_type'] == 'IVR') {
                                                    echo 'selected="selected"';
                                                } else {
                                                    echo '';
                                                } ?> value="<?php echo 'IVR' ?>">
                                                    <?php echo 'IVR'; ?>
                                                </option> -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <button type="button" id="submit" style="margin-top:30px;"
                                            class="btn btn-primary btn-sm">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
                        <!-- Table -->
                        <input type="hidden" name="" id="user_id" value="<?php echo $_SESSION['login_user_id'] ?>">
                        <table id='empTable' class='display dataTable table manage_queue_table'>
                            <thead>
                                <tr>
                                <th>SNo.</th>
                                    <?php if ($_SESSION['userroleforpage'] == 1) { ?>
                                        
                                        <th style="text-align:left;">User Name</th>
                                    <?php } ?>
                                    <th style="text-align:left;">Notification Type</th>
                                    <th style="text-align:left;">Message</th>
                                    <th style="text-align:left;">Date</th>
                                    <th style="text-align:left;">IP_address</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Script -->
            <script>
                $(document).ready(function () {
                    getData();

                    $("#submit").on("click", function (e) {
                        e.preventDefault();
                        getData();
                    });

                    function getData() {

                        var clientId = $("#clientId").val();
                        var item_type = $("#item_type").val();
                        var notification_type = $("#notification_type").val();

                        $('#empTable').DataTable({
                            'processing': true,
                            'serverSide': true,
                            'order': [[0, 'desc']],
                            'pageLength': 25,
                            'serverMethod': 'post',
                            'ajax': {
                                'url': 'ajaxnotification.php',
                                data: { clientId: clientId, item_type: item_type, notification_type: notification_type },
                            },
                            'columns': [
                                { data: 'id' },
                                <?php if ($_SESSION['userroleforpage'] == 1) { ?>
                                        { data: 'clientName' },
                                <?php } ?>
                                { data: 'activity_type' },
                                { data: 'message' },
                                { data: 'activity_time' },
                                { data: 'IP_address' },
                            ],
                            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                                if (aData.noti_status == "0") {
                                    $('td', nRow).css('background-color', '#A7C2E5');
                                }
                            },
                            stateSave: false,
                            "bDestroy": true
                        });
                    }
                });
            </script>
            
            <br>
            <br>
            <br>

        </div>
    </div>
</div>
</div>
</div>
<script>
    function deleteContentRing(id) {
        if (confirm('Are you sure you want to delete this ?')) {
            window.location = 'ringdata_delete.php?id=' + id;
        }
        return false;
    }
</script>
<script>
    $(document).ready(function () {
        $(window).on("load", function () {
            <?php if ($_SESSION['userroleforpage'] == 2) { ?>
                var user_id = $("#user_id").val();
                // alert(user_id);
                setTimeout(function () {
                    $.ajax({
                        url: "ajaxnotification_update.php",
                        type: "POST",
                        data: { user_id: user_id },
                        success: function (data) {
                            if (data) {
                                $("#empTable tbody td").removeAttr('style');
                            }
                        }
                    });
                }, 5000);
            <?php } else { ?>
                setTimeout(function () {
                    $.ajax({
                        url: "ajaxnotification_update.php",
                        type: "POST",
                        // data : {user_id : user_id},
                        success: function (data) {
                            if (data) {
                                $("#empTable tbody td").removeAttr('style');
                            }
                        }
                    });
                }, 5000);
            <?php } ?>
        });

    });
</script>
<?php require_once('footer.php'); ?>