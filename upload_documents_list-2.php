<?php require_once('header.php'); 
// $draw = $_POST['draw'];
// $row = $_POST['start'];
// $rowperpage = $_POST['length']; // Rows display per page
// $columnIndex = $_POST['order'][0]['column']; // Column index
// $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
// $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
// $searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value

// ## Search 
// $searchQuery = " ";
// if($searchValue != ''){
// 	$searchQuery = " and (accountcode like '%".$searchValue."%' or 
//         file_one like '%".$searchValue."%' or
//         file_two like '%".$searchValue."%' or  
//         file_three like '%".$searchValue."%' ) ";
// }
// // $query_queue = "select cqt.queue_name as queue_name,cqt.name as name,Client.clientName as clientName, cqt.strategy as strategy, cqt.musicclass as musicclass , cqt.status as status from cc_queue_table cqt left join Client ON cqt.clientid=Client.clientId";
// // $result = mysqli_query($connection,$query_queue);

// ## Total number of records without filtering
// $sel = mysqli_query($con,"select count(*) as allcount from upload_documents");
// $records = mysqli_fetch_assoc($sel);
// $totalRecords = $records['allcount'];

// ## Total number of records with filtering
// $sel1 = "SELECT count(*) as allcount FROM upload_documents WHERE 1 ".$searchQuery;
// $selll = mysqli_query($con,$sel1);
// $recordss = mysqli_fetch_assoc($selll);
// $totalRecordwithFilter = $recordss['allcount'];

## Fetch records
//$empQuery = "select cdid.did as did, cdid.carieer as carieer, cdid.didtype as didtype, cdid.call_destination as call_destination,cdid.status as status,cdid.call_screening_action as call_screening_action from cc_did cdid WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
// $empQuery = "SELECT clientId, clientName,clientEmail,clientEmailPass,hostName,portNumber,modifyDate FROM Client WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
function endsWith($string, $suffix)
{
    return substr($string, -strlen($suffix)) === $suffix;
}
// echo "<pre>";print_r($_SESSION);die;


if($_SESSION['userroleforpage'] == 1){
    $empQuery = "select crg.*, cc_card.username, cc_card.uipass, cc_card.email,cc_card.firstname from upload_documents crg left join cc_card ON crg.accountcode=cc_card.username WHERE 1 ";	
    }else{
    $empQuery = "select crg.*, cc_card.username, cc_card.uipass, cc_card.email,cc_card.firstname from upload_documents crg left join cc_card ON crg.accountcode=cc_card.username WHERE cc_card.id='".$_SESSION['login_user_id']."' ";	
    }
    $empRecords = mysqli_query($con, $empQuery);
       
        
// echo "<pre>";print_r($data['id']);die
?>

<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">

<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
<h2 class="title-1"> Upload Document <span style="margin-left:50px;"></span></h2>

<div class="table-data__tool-right">    
<a href="upload_documents_add.php">
<button class="au-btn au-btn-icon au-btn--blue">
<i class="fa fa-plus-circle"></i>Upload Document Add</button></a>
</div>

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

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
        
            <!-- Table -->
            <table id='empTable' class='display dataTable table manage_queue_table style="width: 0px;"'>
                <thead>
                <tr>
                   <th>Client Name </th>
                    <th>First </th>
                    <th>Second </th>
                    <th>Third</th>
                    <th>Action</th>
                </tr>
                </thead>
                <?php  while ($data = mysqli_fetch_assoc($empRecords)) { if(mysqli_num_rows($data)>0){ ?> 
                <tbody>
                <tr>
                   <td><?php echo $data['firstname'];?></td>
                   <td><?php 
                   if (endsWith($data['file_one'], ".pdf")) {
                    echo '<embed src="upload/' . $_SESSION['login_usernames'] . '/' . $data['file_one'] . '" width="50%">';
                } else if (endsWith($data['file_one'], ".doc")) {
                    echo '<a href="upload/' . $_SESSION['login_usernames'] . '/' . $data['file_one'] . '" width="50%">' . $data['file_one'] . '</a>';
                } else  {
                echo '<img src="upload/' . $_SESSION['login_usernames'] . '/' . $data['file_one'] . '" width="50%">';
                }
                   ?></td>
                   <td><?php if (endsWith($data['file_two'], ".pdf")) {
                        echo '<embed src="upload/' . $_SESSION['login_usernames'] . '/' . $data['file_two'] . '" width="50%">';
                    } else if (endsWith($data['file_two'], ".doc")) {
                        echo '<a href="upload/' . $_SESSION['login_usernames'] . '/' . $data['file_two'] . '" width="50%">' . $data['file_two'] . '</a>';
                    } else  {
                    echo '<img src="upload/' . $_SESSION['login_usernames'] . '/' . $data['file_two'] . '" width="50%">';
                    } ?></td>
                   <td><?php  if (endsWith($data['file_three'], ".pdf")) {
                        echo '<embed src="upload/' . $_SESSION['login_usernames'] . '/' . $data['file_three'] . '" width="50%">';
                    } else if (endsWith($data['file_three'], ".doc")) {
                        echo '<a href="upload/' . $_SESSION['login_usernames'] . '/' . $data['file_three'] . '" width="50%">' . $data['file_three'] . '</a>';
                    } else  {
                    echo '<img src="upload/' . $_SESSION['login_usernames'] . '/' . $data['file_three'] . '" width="50%">';
                    }?></td>
                   <td>
                   <div class="table-data-feature">
<a href="upload_documents_edit.php?id=<?php echo $data['id']?>" >
<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
<i class="fa fa-pencil-square-o"></i>
</button></a>
<a href="javascript:void(0)" onclick="return UploadDocdatadeleteContent('<?php echo $data['id']?>');" type="button" >
<button class="item" data-toggle="tooltip" type="button" data-placement="top" title="" data-original-title="delete">
<i class="fa fa-trash-o"></i></button></a>
</div>
                   </td>
                </tr>
                </tbody> 
                <?php } else{ ?>
            <td>No Record Found!</td>
<?php } }?>
            </table>
        </div>
        
        <!-- Script -->
        <!-- <script>
        $(document).ready(function(){
            $('#empTable').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'upload_documents_ajax.php'
                },
                'columns': [
                    { data: 'clientName' },
					{ data: 'file_one' },
                    { data: 'file_two' },
                    { data: 'file_three' },
                    { data: 'action' },
                ]
            });
        });
        </script> -->
		
		<br>
<br>
<br>
</div>
    </div>
    </div>
    </div>
	  </div>
<script>
    function UploadDocdatadeleteContent(id) {
        if(confirm('Are you sure you want to delete this ?')) {
        window.location='upload_documents_delete.php?id='+id;
        }
    return false;
    }
</script>
<?php require_once('footer.php'); ?> 
 
