<?php require_once ('header.php');
// require_once('connection.php');
// echo"<pre>";print_r($_SESSION);die;


// echo"<pre>";print_r($extname);die;
?>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1"> Sip Registration List <span style="margin-left:50px;"></span></h2>

                        <div class="table-data__tool-right">
                            <!--  <a href="">
                                <button class="au-btn au-btn-icon au-btn--blue">
                                    <i class="fa fa-user-times"></i>Unregister</button></a> -->
                            <a href="">
                                <button class="au-btn au-btn-icon au-btn--blue">
                                    <i class="fa fa-refresh"></i>Refresh</button></a>
                        </div>


                    </div>
                </div>
            </div>

            <?php
            if (isset($_SESSION['msg']) && $_SESSION['msg'] != '') {
                echo "<div class='text-center bg-light' style='background:lightblue; padding:5px;'><h3 class='text-white'>" . $_SESSION['msg'] . "</h3></div>";
                unset($_SESSION['msg']);
            }
            ?>
            <div class="row">
                <div class="col-md-12">

                    <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">

                        <!-- Table -->
                        <table id='empTable' class='display dataTable table manage_queue_table style="width: 0px;"'>
                            <thead>
                                <tr>
                                    <!-- <th><input type="checkbox" id="select_all"> Select </th> -->
                                    <?php
                                    if ($_SESSION['userroleforpage'] == 1) { ?>
                                        <th>Company Name</th>
                                    <?php }
                                    ?>
                                    <th>Agent Name</th>
                                    <th>User Type</th>

                                    <!-- <th>Email</th> -->
                                    <th>Name</th>
                                    <th>IP Address</th>
                                    <th>Forcerport</th>
                                    <th>Comedia</th>
                                    <th>Port</th>
                                    <th>Status</th>
                                    <!--  <th>Action</th> -->
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Script -->
                    <script>
                        $(document).ready(function () {
                            $('#empTable').DataTable({
                                'processing': true,
                                'serverSide': true,
                                "bPaginate": false,
                                'serverMethod': 'post',
                                'ajax': {
                                    'url': 'sipregistration_ajax.php'
                                },
                                'columns': [
                                    // { data: 'Select' },
                                    <?php
                                    if ($_SESSION['userroleforpage'] == 1) { ?>
                                            { data: 'companyName' },
                                    <?php }
                                    ?>
                                    { data: 'agent_name' },
                                    { data: 'userType' },
                                    { data: 'name' },
                                    { data: 'host' },
                                    { data: 'forceport' },
                                    { data: 'comedia' },
                                    { data: 'port' },
                                    { data: 'status' }
                                    //{ data: 'action' }
                                    // { data: 'description' },
                                    // { data: 'realtime' },
                                ],
                               /*  fnRowCallback: function (nRow, data, iDisplayIndex, iDisplayIndexFull) {
                                    if (data.status == "UNREACHABLE  ") {
                                        $('td', nRow).css('background-color', 'white');
                                    }
                                }, */
                            });
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
    function sip_unregister(ext_name) {
        if (confirm('Are you sure want to Unregister this user?')) {
            $.ajax({
                url: 'ajaxsipunregister.php',
                type: 'get',
                data: { ext: ext_name },
                success: function (data) {
                    if (data) {
                        window.location.href = "";
                    }
                }
            });
        }
    }

    // $("#sip_unregister").on("click", function () {
    //     alert("hello");
    // });
</script>
<?php require_once ('footer.php'); ?>