<?php require_once('header.php'); ?>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Rate Information<span style="margin-left:50px;"></span></h2>
                        <div class="table-data__tool-right">
                            <a href="rateAdd.php">
                                <button class="au-btn au-btn-icon au-btn--blue">
                                    <i class="fa fa-plus-circle"></i>Rate</button></a>
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
                                    <th>S.No.</th>
                                    <th>Tarrif Name</th>
                                    <th>Country Prefix</th>
                                    <th>Selling Price</th>
                                    <th>Billing Initial</th>
                                    <th>Billing Block</th>
                                    <th>Status</th>
                                    <th>Carrier</th>
                                    <th>Action</th>
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
                                'serverMethod': 'post',
                                'ajax': {
                                    'url': 'ajaxrate.php'
                                },
                                'columns': [
                                    { data: 'id' },
                                    { data: 'group_name' },
                                    { data: 'prefix' },
                                    { data: 'initial_rate' },
                                    { data: 'init_block' },
                                    {data: 'billing_block'},
                                    { data: 'dial_status' },
                                    { data: 'trunk' },
                                    { data: 'action' },
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
    function ratedeleteContent(id) {
        if (confirm('Are you sure you want to delete this ?')) {
            window.location = 'ratedata_delete.php?id=' + id;
        }
        return false;
    }
</script>
<?php require_once('footer.php'); ?>