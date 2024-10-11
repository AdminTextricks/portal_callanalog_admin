<?php require_once ('header.php'); ?>



<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap ">
                        <h2 class="title-1">Deleted DID</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
                        <!-- Table -->

                        <table id='empTable' class='display dataTable table manage_queue_table'>
                            <thead>
                                <tr>
                                    <th>SNo.</th>
                                    <th style="text-align:left;">Username</th>
                                    <th style="text-align:left;">DID</th>
                                    <th style="text-align:left;">DID Provider</th>
                                    <th style="text-align:left;">Activation Date</th>
                                    <th style="text-align:left;">Expiration Date</th>
                                    <th style="text-align:left;">Deleted Date</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Script -->
            <script>

                $('#empTable').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'order': [[0, 'desc']],
                    'pageLength': 50,
                    'serverMethod': 'post',
                    'ajax': {
                        'url': 'ajax_did_deleted.php',

                    },
                    'columns': [
                        { data: 'id' },
                        { data: 'username' },
                        { data: 'did' },
                        { data: 'provider' },
                        { data: 'start' },
                        { data: 'expire' },
                        { data: 'delete' },
                    ]
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

<?php require_once ('footer.php'); ?>