<?php require_once('header.php'); ?>

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

<div class="row">
<div class="col-md-12">

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">        
            <!-- Table -->
            <table id='empTable' class='display dataTable table manage_queue_table'>
                <thead>
                <tr>
                <th>Serial No</th>
                    <?php 
                    if($_SESSION['userroleforpage'] == 1){
                    ?>
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
        $(document).ready(function(){
            $('#empTable').DataTable({
                'processing': true,
                'serverSide': true,
                'order': [[3, 'desc']],
                'serverMethod': 'post',
                'ajax': {
                    'url':'ajaxnotification.php'
                },
                'columns': [
                    { data: 'id' },
                    <?php if($_SESSION['userroleforpage'] == 1){ ?>
                    { data: 'clientName' },
                    <?php } ?>
                    { data: 'activity_type' },
                    { data: 'message' },
                    { data: 'activity_time' },                   
                    { data: 'IP_address' },                    
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
    function deleteContentRing(id) {
        if(confirm('Are you sure you want to delete this ?')) {
        window.location='ringdata_delete.php?id='+id;
        }
    return false;
    }
</script>
<?php require_once('footer.php'); ?> 
 
