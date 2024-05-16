<?php 
require_once('header.php'); 
$message = '';
if(isset($_POST['submit']))
{	
//print_r($_POST);

$created_at = date('Y-m-d h:i:s');
$update_webtempdata = "UPDATE `cc_conf_templates` SET `template_id`='".$_POST['template_id']."',`template_name`='".$_POST['template_name']."',`template_contents`='".$_POST['template_contents']."' WHERE template_id='WEBRTC'"; 
$result_update_webtempdata = mysqli_query($connection,$update_webtempdata);
		
		if($result_update_webtempdata){
			$message = "Web Template updated Successfully!";
		}

}
$select_webtempdata = "select * from cc_conf_templates where template_id='WEBRTC'";
$result_webtempdata = mysqli_query($connection,$select_webtempdata);
?>


<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
				<div class="overview-wrap">
					<h2 class="title-1"> WEBRTC Information <span style="margin-left:50px;color:blue;"><?php echo $message; ?></span></h2>
				<div class="table-data__tool-right">
					<a href="webrtc_template.php">
					<button class="au-btn au-btn-icon au-btn--green au-btn--small">
					<i class="fa fa-eye" aria-hidden="true"></i> WEBRTC</button></a>
				</div>

			</div>
		</div>
	</div>

<div class="big_live_outer">
<div class="row">
    <div class="col-md-12">
        <div class="queue_info">
            <form id="WEBRTCForm" name="WEBRTCedit" action="" method="post">
                
<?php while($row = mysqli_fetch_array($result_webtempdata)) { 
		
		$template_id = $row['template_id'];
		$template_name = $row['template_name'];
		$template_contents = $row['template_contents'];

} ?>
<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Template Id*</label>
</div>
<div class="col-12 col-md-9">
<input id="template_id" name="template_id" placeholder="Template Id" class="form-control" type="text" required value="<?php echo $template_id; ?>" readonly/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Template Name*</label>
</div>
<div class="col-12 col-md-9">
<input id="template_name" name="template_name" placeholder="Template Name" class="form-control" required type="text" value="<?php echo $template_name; ?>" readonly>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Template Contents*</label>
</div>
<div class="col-12 col-md-9">
<textarea class="form-control" name="template_contents" id="template_contents" placeholder="Type Your Off Hours Messages" rowspan="8" style="height:500px;" ><?php echo $template_contents ?></textarea>
</div>
</div>




			
			<div class="form-group pull-right">
			 <button type="submit" name="submit" class="btn btn-primary btn-sm">Submit</button>
			</div>
			<p style="color:blue;"><?php echo $message; ?></p>
</form>
			
        </div>
    </div>
    </div>



</div>
</div>



</div>
</div>
<br>

<?php require_once('footer.php'); ?> 
 
