<?php require_once('header.php'); ?>
<style>
   .show {
   display: block !important;
   opacity: 1;
   background: #0000004d!important;
   }
   .panel-collapse{
      background: white!important;
   }
</style>
<div class="main-content">
   <div class="section__content section__content--p30 page_mid">
      <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="overview-wrap">
                <h2 class="title-1"> IVR Information <span style="margin-left:50px;"></span></h2>                
                <div class="table-data__tool-right">    
                    <a href="ivradd.php">
                        <button class="au-btn au-btn-icon au-btn--blue">
                    <i class="fa fa-plus-circle"></i>IVR</button></a>
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
            
         <div class="row">
            <div class="col-md-12">
               <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
                  <table id='empTable' class='display dataTable table manage_queue_table'>
                     <thead>
                        <tr>
                           <th>IVR Name</th>
                           <th>IVR Description</th>
                           <?php if($_SESSION['userroleforpage'] == 1){?>
                           <th>Company</th>
                           <?php } ?>
                           <?php if($_SESSION['userroleforpage'] == 1) { ?>
                            <th>User Type </th>
                           <?php } ?>
                           <th>Announcement</th>
                           <th>IVR Timeout</th>
                           <th>IVR Status</th>
                           <th>Created At</th>
                           <th>View DTMF</th>
                           <th>Action</th>
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
                    'serverMethod': 'post',
                    'ajax': {
                        'url':'ajaxivr.php'
                    },
                    'columns': [
                        { data: 'ivr_name' },
                        { data: 'ivr_description' },
                        <?php if($_SESSION['userroleforpage'] == 1){ ?>
                        { data: 'clientName' },
                        <?php } ?>
                        <?php if($_SESSION['userroleforpage'] == 1){ ?>
                         { data: 'UserType'},
                           <?php } ?>
                        { data: 'ivr_announcement' },
                        { data: 'ivr_timeout' },
                        { data: 'ivr_status' },
                        { data: 'created_at' }, 
                        { data: 'view_dtmf'},                   
                        { data: 'action' },
                    ],
                    'initComplete': function() {
                        var table = this.api();
                        $('#empTable').on('click', '.btn-primary', function() {
                        });
                    }
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
   // $(document).ready(function(){
   //     $("#ivr_btn").on("click",function(){
   //         alert("hello");
   //     });
   // });
</script>
<script>
   function deleteContentIvr(id) {
       if(confirm('Are you sure you want to delete this ?')) {
       window.location='ivrdata_delete.php?id='+id;
       }
   return false;
   }
   function OptionContentIvr(id){
       // alert(id);
       $.ajax({
           url : "ajaxivroption.php",
           type : "POST",
           data : {id : id},
           success: function(data){
               $('#myModalOne').modal('show');
               $("#option_data").html(data);
           }
       });
   }
</script>
<div class="modal model-ext" id="myModalOne">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title text-center">IVR DTMF Details</h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            <table class='display dataTable table manage_queue_table' id="option_data"></table>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
<?php require_once('footer.php'); ?>