<?php require_once ('header.php');
if ($_SESSION['userroleforpage'] == 1) {
    $query_client = "SELECT Client.clientName,Client.clientId,Client.clientEmail FROM `Client` LEFT JOIN `users_login` ON Client.clientId = users_login.clientId WHERE users_login.role !=4 and users_login.status = 'Active' and users_login.deleted = '0'";
    $result_client = mysqli_query($connection, $query_client);
}
?>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <?php
            //if($_SESSION['userroleforpage'] == 1){               ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap ">
                        <h2 class="title-1">Recharge History</h2>
                    </div>
                </div>
            </div>
            <?php //} /              ?>

            <div class="reports_inner_outer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="classic_queue_info">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input" class=" form-control-label"
                                            style="color:black;margin-left:0px;font-weight:bold;">From Date</label>
                                        <input id="fromDate" name="fromDate" class="form-control hasDatepicker"
                                            type="date" value="<?php // echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input" class=" form-control-label"
                                            style="color:black;margin-left:0px;font-weight:bold;">To Date</label>
                                        <input id="toDate" name="toDate" class="form-control hasDatepicker" type="date"
                                            value="<?php // echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <?php
                                if ($_SESSION['userroleforpage'] == 1) { ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text-input" class=" form-control-label"
                                                style="color:black;margin-left:0px;font-weight:bold;">Client</label>
                                            <select id="clientId" name="clientId" data-show-subtext="false"
                                                data-live-search="true" class="form-control selectpicker filter" required>
                                                <option value="All" selected="selected">All</option>
                                                <?php while ($row = mysqli_fetch_array($result_client)) { ?>
                                                    <option <?php if ($row['clientId'] == $_POST['clientId']) {
                                                        echo 'selected="selected"';
                                                    } else {
                                                        echo '';
                                                    } ?>
                                                        value="<?php echo $row['clientId']; ?>">
                                                        <?php echo $row['clientName'].'/'.$row['clientEmail']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text-input" class=" form-control-label"
                                                style="color:black;margin-left:0px;font-weight:bold;">Users</label>
                                            <select id="selectedUser" name="selectedUser" class="form-control" required>
                                                <option value="" selected="selected">All</option>
                                                <?php if (isset($_POST['selectedUser'])) {
                                                    $row_user = $userDetails; ?>
                                                    <option <?php if ($row_user['id'] == $_POST['selectedUser']) {
                                                        echo 'selected="selected"';
                                                    } else {
                                                        echo '';
                                                    } ?>
                                                        value="<?php echo $row_user['id']; ?>">
                                                        <?php echo $row_user['name']; ?>
                                                    </option>
                                                    <?php
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input" class=" form-control-label"
                                            style="color:black;margin-left:0px;font-weight:bold;">Recharged By</label>
                                        <select id="recharged_by" name="recharged_by" class="form-control filter">
                                            <option value="">All</option>
                                            <option value="Self">Self</option>
                                            <option value="Super Admin">Super Admin</option>
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
                                    <th style="text-align:left;">Company</th>
                                    <th style="text-align:left;">old Balance</th>
                                    <th style="text-align:left;">Add Balance</th>
                                    <th style="text-align:left;">Total Balance</th>
                                    <th style="text-align:left;">Currency</th>
                                    <th style="text-align:left;">Recharged By</th>
                                    <th style="text-align:left;">Date</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Script -->
            <script>

                $(document).ready(function () {
                    var fromDate = null;
                    var toDate = null;
                    getData(fromDate, toDate);

                    $("#submit").on("click", function (e) {
                        e.preventDefault();
                        fromDate = $("#fromDate").val();
                        toDate = $("#toDate").val();
                        getData(fromDate, toDate);
                    });


                    function getData(fromDate, toDate) {

                        var userid = $("#selectedUser").val();
                        var recharged_by = $("#recharged_by").val();
                        $('#empTable').DataTable({
                            'processing': true,
                            'serverSide': true,
                            'order': [[0, 'desc']],
                            'pageLength': 25,
                            'serverMethod': 'post',
                            'ajax': {
                                'url': 'ajaxrecharge_history.php',
                                data: { fromDate: fromDate, toDate: toDate, userid: userid, recharged_by: recharged_by },
                            },
                            'columns': [
                                { data: 'id' },
                                { data: 'username' },
                                { data: 'old_bal' },
                                { data: 'add_bal' },
                                { data: 'total_bal' },
                                {data: 'currency'},
                                { data: 'recharged_by' },
                                { data: 'created_at' },
                            ],
                            stateSave: true,
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
    $("select[name='clientId']").change(function () {
        var clientsID = $(this).val();
        if (clientsID == "All") {
            $('select[name="selectedUser"]').html('<option value="">All</option>');
        } else if (clientsID) {
            $.ajax({
                url: "ajaxpro.php",
                dataType: 'Json',
                data: { 'id': clientsID },
                success: function (data) {
                    $('select[name="selectedUser"]').empty();
                    $.each(data, function (key, value) {
                        $('select[name="selectedUser"]').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        } else {
            $('select[name="selectedUser"]');
            $.each(data, function (key, value) {
                $('select[name="selectedUser"]').append('<option value="' + key + '">' + value + '</option>');
            });
        }
    });
</script>

<?php require_once ('footer.php'); ?>