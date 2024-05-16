<?php require_once('header.php'); ?>

<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">

<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
<h2 class="title-1"> Manage DID Price <span style="margin-left:50px;"></span></h2>
	
<?php if($_SESSION['userroleforpage'] == 1){ ?>
<div class="table-data__tool-right">  	
<a href="add_price.php">
<button class="au-btn au-btn-icon au-btn--blue">
<i class="fa fa-plus-circle"></i>ADD</button></a>&nbsp;
</div>
<?php } ?>

<?php if($_SESSION['userroleforpage'] == 0){ ?>
<div class="table-data__tool-right">  	
<a href="add_price.php">
<button class="au-btn au-btn-icon au-btn--blue">
<i class="fa fa-plus-circle"></i>ADD</button></a>&nbsp;
</div>
<?php } ?>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12">
 
 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
            <!-- Table -->
            <table id='manage_did_price' class='display dataTable table manage_queue_table'>
               <tr>
                <td id="table-data">

                </td>
               </tr> 
            </table>
        </div>
<div id="model">
    <div id="model-form">
        <h2>Edit Form</h2>
        <table cellpadding="0" width="100%">  
        </table>
    <div id="close-btn">X</div>
</div>
</div>	
<br>
<br>
<br>
<script>
    $(document).ready(function(){
        function loadTable(){
            $.ajax({
                url : 'did_price_load.php',
                type : 'POST',
                success : function(data){
                    $("#table-data").html(data);
                }
            });
        }
        loadTable();

        // Show Model Box
        $(document).on("click",".item",function(){
                $("#model").show();
                var id = $(this).data("p_id");
                $.ajax({
                    url : "update_did_price.php",
                    type : "POST",
                    data : {user_id : id},
                    success : function(data){
                        $("#model-form table").html(data);
                    }
                });
            });

            // Hide Model Box
            $("#close-btn").on("click",function(){
                $("#model").hide();
            });
    });
</script>
<?php require_once('footer.php'); ?> 
 
