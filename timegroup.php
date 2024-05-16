<?php require_once('header.php'); ?>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1"> Time Condition Information <span style="margin-left:50px;"></span></h2>
                        <div class="table-data__tool-right">
                            <a href="timegroupadd.php">
                                <button class="au-btn au-btn-icon au-btn--blue">
                                    <i class="fa fa-plus-circle"></i>TIME CONDITION</button></a>
                        </div>

                    </div>
                </div>
            </div>

            <?php
            if (isset($_SESSION['msg']) && $_SESSION['msg'] != '') {
                echo "<div id='message' class='text-center bg-light' style='background:lightblue; padding:5px;'><h3 class='text-white'>" . $_SESSION['msg'] . "</h3></div>";
                unset($_SESSION['msg']);
            }
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
                        <!-- Table -->
                        <table id='empTable' class='display dataTable table manage_queue_table'>
                            <thead>
                                <tr>
                                    <th>Destination-type</th>
                                    <th>Destination</th>
                                    <?php if ($_SESSION['userroleforpage'] == 1) { ?>
                                        <th> User Type </th>
                                    <?php } ?>
                                    <th>Sch_call</th>
                                    <th>StartTime</th>
                                    <th>StopTime</th>
                                    <th>StartDay</th>
                                    <th>StopDay</th>
                                    <th>AllTime</th>
                                    <th>Message</th>
                                    <th>IVR File </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function () {
                    $('#empTable').DataTable({
                        'processing': true,
                        'serverSide': true,
                        'serverMethod': 'post',
                        'ajax': {
                            'url': 'timegroupajax.php'
                        },
                        'columns': [{
                            data: 'destination_type'
                        },
                        {
                            data: 'destination'
                        },
                            <?php if ($_SESSION['userroleforpage'] == 1) { ?>

                                   { data: 'userType' },
                            <?php } ?>
                            {
                            data: 'sch_call'
                        },
                        {
                            data: 'starttime'
                        },
                        {
                            data: 'stoptime'
                        },
                        {
                            data: 'startday'
                        },
                        {
                            data: 'stopday'
                        },
                        {
                            data: 'all_time'
                        },
                        {
                            data: 'message'
                        },
                        {
                            data: 'ivr_file'
                        },
                        {
                            data: 'action'
                        }
                        ]
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
    function deleteContenttimegroup(id) {
        if (confirm('Are you sure you want to delete this ?')) {
            window.location = 'timegroup_delete.php?id=' + id;
        }
        return false;
    }
</script>
<?php require_once('footer.php'); ?>