<?php require_once('header.php'); 

if(isset($_POST['update']))
{
	$update_agent = "update AgentInfo set email='".$_POST['email']."',name='".$_POST['name']."',queue='".$_POST['queue']."',ext='".$_POST['ext']."' , status='".$_POST['status']."' where id='".$_GET['id']."'";
	$result_agent = mysqli_query($con,$update_agent);
	
	if($result_agent)
	{
		$message = 'Agent updated successfully.';
	}
	
}

$select_agent = "select * from AgentInfo where id='".$_GET['id']."'";
$result_agent = mysqli_query($con,$select_agent);

$row_data = mysqli_fetch_assoc($result_agent);


?>


<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
<h2 class="title-1"> Edit Agent <span style="margin-left:50px;"></span></h2>
<div class="table-data__tool-right">
<a href="showagent.php">
<button class="au-btn au-btn-icon au-btn--green au-btn--small">
<i class="fa fa-eye" aria-hidden="true"></i> Show Agents</button></a>
</div>

</div>
</div>
</div>

<div class="big_live_outer">
<div class="row">
    <div class="col-md-12">
        <div class="queue_info">
            <form id="agentedit" action="" method="post">
                
				<div class="row form-group">
				<div class="col col-md-3">
				<label for="text-input" class="form-control-label">Email*</label>
				</div>
				<div class="col-12 col-md-9">
				<input id="email" name="email" class="form-control" type="text" value="<?php echo $row_data['email']; ?>"/>
				</div>
				</div>
				
				<div class="row form-group">
				<div class="col col-md-3">
				<label for="text-input" class="form-control-label">Name*</label>
				</div>
				<div class="col-12 col-md-9">
				<input id="name" name="name" class="form-control" type="text" value="<?php echo $row_data['name']; ?>"/>
				</div>
				</div>
				
				<div class="row form-group">
				<div class="col col-md-3">
				<label for="text-input" class="form-control-label">Queue*</label>
				</div>
				<div class="col-12 col-md-9">
				<input id="queue" name="queue" class="form-control numbersOnly" type="text" value="<?php echo $row_data['queue']; ?>"/>
				</div>
				</div>
				
				<div class="row form-group">
				<div class="col col-md-3">
				<label for="text-input" class="form-control-label">Extension*</label>
				</div>
				<div class="col-12 col-md-9">
				<input id="ext" name="ext" class="form-control numbersOnly" type="text" value="<?php echo $row_data['ext']; ?>"/>
				</div>
				</div>
				
				
				
				<div class="row form-group">
                <div class="col col-md-3">
                <label for="text-input" class="form-control-label">Status*</label>
                </div>
                <div class="col-12 col-md-9">
                <select id="status" name="status" class="form-control">
				<option value="1" <?php if($row_data['status'] == 1) { echo 'selected="selected"'; }else { echo ''; } ?> >Active</option>
				<option value="0" <?php if($row_data['status'] == 0) { echo 'selected="selected"'; }else { echo ''; } ?> >Inactive</option>
				</select>
                </div>
                </div>
				
				<div class="row form-group">
				<div class="col col-md-3">
				<label for="text-input" class=" form-control-label">Instant Call Report</label>
				</div>
				<div class="col-12 col-md-9">

				<label class="switch switch-text switch-primary">
				<input id="instantCallMail1" name="instantCallMail" class="switch-input" type="checkbox" value="true"/><input type="hidden" name="_instantCallMail" value="on"/>
				<span data-on="On" data-off="Off" class="switch-label"></span>
				<span class="switch-handle"></span>
				</label>

				</div>
				</div>
				
						
			<div class="form-group pull-right">
			 <button type="submit" name="update" value="update" class="btn btn-primary btn-sm">Update</button>
			</div>
			
			<p style="color:blue;" ><?php echo $message; ?></p>
</form>
			
        </div>
    </div>
    </div>



</div>
</div>



</div>

<!-- footer section start here -->
<div class="copyright">
<p>Copyright Â© 2020 PBX. All rights reserved.</p>
</div>
<!-- footer section end here -->
</div>

<br>
<br>
<?php require_once('footer.php'); ?> 
 
