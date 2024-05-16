<?php require_once('header.php'); 

if(isset($_POST['submit']))
{
	// $update_seo = "update seo_members set member_name='".$_POST['name']."',name='".$_POST['name']."',queue='".$_POST['queue']."',ext='".$_POST['ext']."' , status='".$_POST['status']."' where id='".$_GET['id']."'";
	// $result_seo = mysqli_query($con,$update_seo);
	
	// if($result_seo)
	// {
		// $message = 'SEO Member updated successfully.';
	// }
	
}

// $select_agent = "select * from AgentInfo where id='".$_GET['id']."'";
// $result_agent = mysqli_query($con,$select_agent);

// $row_data = mysqli_fetch_assoc($result_agent);

$select_tl = "SELECT * FROM `seo_members` WHERE tl_id =0";
$result_tl = mysqli_query($con,$select_tl);

//$select_member = "SELECT A.id AS id, B.id as ids, A.member_name AS name, B.member_name AS team FROM seo_members A, seo_members B WHERE A.id = B.team_id AND B.id = '".$_GET['id']."'";
$select_member = "SELECT B.id AS ids, A.id AS id, A.member_name AS name, B.member_name AS team FROM seo_members A, seo_members B WHERE A.id = B.team_id AND B.id = '".$_GET['id']."'";
$result_member = mysqli_query($con,$select_member);
$row_mem = mysqli_fetch_assoc($result_member);

?>
<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
<h2 class="title-1"> Edit Seo Member <span style="margin-left:50px;"></span></h2>
<div class="table-data__tool-right">
<a href="reports.php">
<button class="au-btn au-btn-icon au-btn--green au-btn--small">
<i class="fa fa-eye" aria-hidden="true"></i> Reports</button></a>
</div>

</div>
</div>
</div>

<div class="big_live_outer">
<div class="row">
    <div class="col-md-12">
        <div class="queue_info">
            <form id="seoMember" action="" name="seomember" method="post">
                
				<input type="hidden" id="seoMemberId" value="5" />
				<input type="hidden" id="seoTeamId" value="34" />
				
				<div class="row form-group">
				<div class="col col-md-3">
				<label for="text-input" class="form-control-label">Name*</label>
				</div>
				<div class="col-12 col-md-9">
				<input id="name" name="name" class="form-control" type="text" value="<?php echo $row_mem['team']; ?>"/>
				</div>
				</div>
				
				<div class="row form-group">
				<div class="col col-md-3">
				<label for="text-input" class="form-control-label">Seo Role*</label>
				</div>
				<div class="col-12 col-md-9">
				<select id="teamId" name="teamId" class="form-control">
				<option value="0">Please Select</option>
				<option value="1" <?php if($row_mem['ids'] == $row_mem['id']) { echo 'selected="selected"'; } else { echo ''; } ?> >TL</option>
				<option value="2" <?php if($row_mem['ids'] != $row_mem['id']) { echo 'selected="selected"'; } else { echo ''; } ?> >Member</option>
				</select>
				</div>
				</div>
				
				<div class="row form-group">
				<div class="col col-md-3">
				<?php //echo $row_mem['id'] .' id '. $row_mem['ids'].' ids '. $row_mem['name'].' name '.$row_mem['team']; ?>
				<label for="text-input" class="form-control-label">TL Name</label>
				</div>
				<div class="col-12 col-md-9">
				<select id="tlId" name="tlId" class="form-control">
				<option value="0">Please Select</option>
				<?php while($rowtl = mysqli_fetch_array($result_tl)) { ?>
				<option value="<?php echo $rowtl['id']; ?>" <?php if($rowtl['id'] == $row_mem['id']) { echo 'selected="selected"'; } else { echo ''; }  ?> ><?php echo $rowtl['member_name']; ?></option>
				<?php } ?>
				</select>
				</div>
				</div>
				
								
						
			<div class="form-group pull-right">
			 <button type="submit" name="submit" value="submit" class="btn btn-primary btn-sm">Submit</button>
			</div>
			
			<p style="color:blue;"><?php echo $message; ?></p>
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
 
