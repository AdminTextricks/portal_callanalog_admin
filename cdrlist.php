<?php require_once('header.php');

?>

<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">

<div class="row">
<div class="col-md-12">
<div class="overview-wrap table_top_heading">
    

</div>
</div>
</div>

<?php
if(isset($_SESSION['msg']) && $_SESSION['msg'] != ''){
    echo "<div class='text-center bg-light' style='background:lightblue; padding:5px;'><h3 class='text-white'>".$_SESSION['msg']."</h3></div>";
    unset($_SESSION['msg']);
}

?>

<div class="row">
<div class="col-md-12">
 
 <div class="table-responsive table-responsive-data2 big_live_dtl manage_cdr_table_outer">
        
            <!-- Table -->
            <table id='empTable' class='display dataTable table manage_cdrtable'>
                <thead>
                <tr>
                    <!-- <th>Serial No</th> -->
                    <th>Clid </th>
                    <th>Call Duration</th>
                    <th>Disposition</th>
                    <th>Accountcode</th>
                    <th>DID</th>  
                    <th>Cost</th>  
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
                    'url':'cdrajaxfile.php'
                },
                'columns': [
                    { data: 'clid' },
                    { data: 'duration' },
                    { data: 'disposition' },
                    { data: 'accountcode' },
                    { data: 'DID' },
                    { data: 'cost' },
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
    function CdrInbounddeleteContent(id) {
        if(confirm('Are you sure you want to delete this ?')) {
        window.location='cdrinbounddata_delete.php?id='+id;
        }
    return false;
    }
</script>
<?php require_once('footer.php'); ?> 
 
