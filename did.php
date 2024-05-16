<?php require_once('header.php'); ?>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">

            <div class="row">
            <div class="col-md-12">
                    <div class="overview-wrap">
                        <div class="col-md-7">
                            <h2 class="title-1"> DID Information <span style="margin-left:50px;"></span></h2>
                        </div>
                        <div class="col-md-5">
                            <div class="table-data__tool-right">
                                <div class="col-md-6">
                                    <select class="form-control" id="searchType">
                                        <option value="">All</option>
                                        <option value="0">Free</option>
                                        <option value="1">Purchased</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" id="searchdid"
                                        class="au-btn au-btn-icon au-btn--blue">Apply</button>
                                    <a href="didadd.php">
                                        <button class="au-btn au-btn-icon au-btn--blue">
                                            <i class="fa fa-plus-circle"></i>DID</button></a>
                                </div>
                            </div>
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
                                    <th>DID</th>
                                    <th>Billing</th>
                                    <th>Ibound</th>
                                    <th>DID Group</th>
                                    <th>Monthly Rate</th>
                                    <th>Client Name</th>
                                    <th>Selling Rate</th>
                                    <th>Retail Min Duration</th>
                                    <th>Retail Billing Block</th>
                                    <th>Country</th>
                                    <th>Status</th>
                                    <?php if ($_SESSION['userroleforpage'] == 1) { ?>
                                        <th>Action</th>
                                    <?php } ?>
                                </tr>
                            </thead>

                        </table>
                    </div>

                    <!-- Script -->
                    <script>
                        $(document).ready(function () {
                            loadTable();
                            $("#searchdid").on("click", function (e) {
                                e.preventDefault();
                                loadTable();
                            });

                            function loadTable() {
                                var value = $("#searchType").val();
                                // alert(value);
                                $('#empTable').DataTable({
                                    'processing': true,
                                    'serverSide': true,
                                    'serverMethod': 'post',
                                    'ajax': {
                                        'url': 'ajaxdid.php',
                                        data: { value: value },
                                    },
                                    'columns': [
                                        { data: 'did' },
                                        { data: 'billingtype' },
                                        { data: 'did_provider' },
                                        { data: 'didgroupname' },
                                        { data: 'fixrate' },
                                        { data: 'connection_charge' },
                                        { data: 'selling_rate' },
                                        { data: 'aleg_retail_initblock' },
                                        { data: 'aleg_retail_increment' },
                                        { data: 'countryname' },
                                        { data: 'activated' },
                                        <?php if ($_SESSION['userroleforpage'] == 1) { ?>                                   
                                                                    { data: 'action' },
                                        <?php } ?>

                                    ],
                                    stateSave: false,
                                    "bDestroy": true,
                                });
                            }
                        });
                    </script>

                    <br>
                    <br>
                    <br>
                    <?php require_once('footer.php'); ?>