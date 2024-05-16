<?php require_once('header.php'); ?>

<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">

<div class="row">
        <div class="col-md-12">
            <div class="overview-wrap">
                <h2 class="title-1"> Conference Information <span style="margin-left:50px;"></span></h2>                
                <div class="table-data__tool-right">    
                    <a href="conferenceadd.php">
                        <button class="au-btn au-btn-icon au-btn--blue">
                    <i class="fa fa-plus-circle"></i>Conference</button></a>
                </div>                       
                
            </div>
        </div>
    </div>

<?php
if(isset($_SESSION['msg']) && $_SESSION['msg'] != ''){
    echo "<div id='message' class='text-center bg-light' style='background:lightblue; padding:5px;'><h3 class='text-white'>".$_SESSION['msg']."</h3></div>";
    unset($_SESSION['msg']);
}
?>
<script>
                setTimeout(function() {
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
                    <th>Conf Name</th>
                    <th>Conf Number</th>
                    <?php if($_SESSION['userroleforpage'] == 1){ ?>
                    <th>User Type</th>
                     <?php } ?>
                    <th>Pin</th>
                    <th>Admin Pin</th>
                    <th>Max Users</th>
                    <th>Status</th>
                    <?php if($_SESSION['userroleforpage'] == 1){ ?>
                    <th>Company</th>
                    <?php } ?>

                   <!-- <th>Ringing</th>
                    <th>Progress</th>-->
                    <th>Action</th>
                </tr>
                </thead>                
            </table>
        </div>        
        <!-- Script -->
        <script>
        $(document).ready(function(){
            $('#empTable').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'ajaxconference.php'
                },
                'columns': [
                    { data: 'confDesc' },
                    { data: 'confno' },
                    <?php if($_SESSION['userroleforpage'] == 1){ ?>
                    { data: 'userType'},
                    <?php  } ?>
                    { data: 'pin' },
                    { data: 'adminpin' },
                    { data: 'maxusers' },
                    { data: 'status' },
                    <?php if($_SESSION['userroleforpage'] == 1){ ?>
                    { data: 'clientName' },
                    <?php } ?>
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
    function ConferencedeleteContent(id) {
        if(confirm('Are you sure you want to delete this ?')) {
        window.location='conferencedata_delete.php?id='+id;
        }
    return false;
    }
</script>
<?php require_once('footer.php'); ?> 
 
