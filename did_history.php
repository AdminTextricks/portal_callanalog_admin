<?php require_once('header.php'); ?>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1"> DID Buying History <span style="margin-left:50px;"></span></h2>
                        <div class="table-data__tool-right">
                            <!-- <a href="didadd.php">
                                <button class="au-btn au-btn-icon au-btn--blue">
                                    <i class="fa fa-plus-circle"></i>DID</button></a> -->
                        </div>
                    </div>
                </div>
            </div>

            <?php /* if($_SESSION['userroleforpage'] == 1){ ?>
<div class="row">
<div class="col-md-12">
<div class="overview-wrap table_top_heading">
  <a href="didadd.php"><button class="au-btn au-btn-icon au-btn--blue"><i class="fa fa-plus-circle"></i>Add DID</button></a>
</div> 
</div>
</div>
<?php } */ ?>

            <div class="row">
                <div class="col-md-12">

                    <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">

                        <!-- Table -->
                        <table id='empTable' class='display dataTable table manage_queue_table'>
                            <thead>
                                <tr>
                                    <th>Client Name</th>
                                    <th>DID</th>
                                    <th>Purchase Date</th>
                                    <th>Expiry Date</th>
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
                                    'url': 'did_history_ajax.php'
                                },
                                'columns': [
                                    { data: 'clientName' },
                                    { data: 'did' },
                                    { data: 'purchase_date' },
                                    { data: 'expiry_date' },
                                ]
                            });
                        });
                    </script>

                    <br>
                    <br>
                    <br>
                    <?php require_once('footer.php'); ?>