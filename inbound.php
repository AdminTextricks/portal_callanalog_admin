<?php require_once('header.php'); ?>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1"> Inbound Information <span style="margin-left:50px;"></span></h2>
                        <?php if ($_SESSION['userroleforpage'] == 1) { ?>
    <div class="table-data__tool-right" style="display: flex; gap: 10px;">
        <button class="au-btn au-btn-icon au-btn--green" type="submit" id="export" name="export" value="submit">
            <i class="fa fa-download"></i>Download CSV
        </button>
        <a href="inboundadd.php">
            <button class="au-btn au-btn-icon au-btn--blue">
                <i class="fa fa-plus-circle"></i>Add Destination
            </button>
        </a>
    </div>
<?php } ?>

                        <?php if ($_SESSION['userroleforpage'] == 2) { ?>
                            <div class="table-data__tool-right">
                                <a href="did_search_purchase.php">
                                    <button class="au-btn au-btn-icon au-btn--blue">
                                        <i class="fa fa-plus-circle"></i>Purchase DID</button></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <?php
            if (isset($_SESSION['msg']) && $_SESSION['msg'] != '') {
                echo "<div id='message' class='text-center bg-light' style='background:lightblue; padding:5px;'><h3 class='text-white'>" . $_SESSION['msg'] . "</h3></div>";
                unset($_SESSION['msg']);
            }
            ?>
            <script>
                setTimeout(function () {
                    var element = document.getElementById('message');
                    element.parentNode.removeChild(element);
                }, 2000);
            </script>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
                        <!-- Table -->
                        <table id='empTable' class='display dataTable table manage_queue_table'>
                            <thead>
                                <tr>
                                    <th>TFN</th>
                                    <?php if ($_SESSION['userroleforpage'] == 1) { ?>
                                        <th>User Type</th>
                                    <?php } ?>
                                    <?php if ($_SESSION['userroleforpage'] == 1) { ?>
                                        <th>User</th>
                                    <?php } ?>
                                    <?php if ($_SESSION['userroleforpage'] != 1) { ?>
                                        <th>Email</th>
                                    <?php } ?>
                                    <th>Company</th>
                                    <?php if ($_SESSION['userroleforpage'] == 1) { ?>
                                        <th>Carieer</th>
                                    <?php } ?>
                                    <th>Destination Type</th>
                                    <th>Destination</th>
                                    <th>Dial Status</th>
                                    <th>Status</th>
                                    <th>Expiration date</th>
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
                                    'url': 'ajaxinbund.php'
                                },
                                'columns': [
                                    { data: 'did' },
                                    <?php if ($_SESSION['userroleforpage'] == 1) { ?>
                            { data: 'userType' },
                                    <?php } ?>
                                    <?php if ($_SESSION['userroleforpage'] == 1) { ?>
                                        { data: 'username' },
                                    <?php } ?> 
                                    <?php if ($_SESSION['userroleforpage'] != 1) { ?>
                        { data: 'email' },
                                    <?php } ?>
                                    { data: 'clientName' },
                                    <?php if ($_SESSION['userroleforpage'] == 1) { ?>
                            { data: 'carieer' },
                                    <?php } ?>
                    { data: 'didtype' },
                                    { data: 'call_destination' },
                                    { data: 'call_screening_action' },
                                    { data: 'status' },
                                    { data: 'expire' },
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
    function InbounddeleteContent(id) {
        if (confirm('Are you sure you want to delete this ?')) {
            window.location = 'inbounddata_delete.php?id=' + id;
        }
        return false;
    }
</script>
<script>
	$(document).ready(function () {
		$('#export').click(function (event) {
			event.preventDefault();
			$.ajax({
				url: 'did_csv.php',
				success: function (response) {
					var downloadLink = document.createElement('a');
					downloadLink.href = 'did_csv.php';
					downloadLink.download = 'did_csv.csv';
					downloadLink.click();
				}
			});
		});
	});
</script>
<?php require_once('footer.php'); ?>