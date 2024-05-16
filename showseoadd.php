<?php require_once('header.php'); 

if(isset($_POST['submit']))
{
	if($_POST['teamId'] == 1)
	{
		$insertteam = "insert into seo_members ( member_name,tl_id) value ( '".$_POST['name']."','0')";
		$result_insert = mysqli_query($con,$insertteam);
		$lastinsertid = mysqli_insert_id($con);
		
		$updateteam = "update seo_members set team_id='".$lastinsertid."' where id='".$lastinsertid."'";
		$inserted = mysqli_query($con,$updateteam);	
		
		$message = " Team Leader successfully inserted! ";
		
	}else {
		$insertteam = "insert into seo_members ( member_name) value ( '".$_POST['name']."')";
		$result_insert = mysqli_query($con,$insertteam);
		$lastinsertid = mysqli_insert_id($con);
		
		$updateteam = "update seo_members set team_id='".$_POST['tlId']."',tl_id='".$_POST['tlId']."' where id='".$lastinsertid."'";
		$inserted = mysqli_query($con,$updateteam);	
		
		$message = " SEO Member successfully inserted! ";
	}
	
	
}

// $select_agent = "select * from AgentInfo where id='".$_GET['id']."'";
// $result_agent = mysqli_query($con,$select_agent);

// $row_data = mysqli_fetch_assoc($result_agent);

$select_tl = "SELECT * FROM `seo_members` WHERE tl_id =0";
$result_tl = mysqli_query($con,$select_tl);

?>
<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
<h2 class="title-1"> Add Seo Member/TL <span style="margin-left:50px;"></span></h2>
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
				<input id="name" name="name" class="form-control" type="text" value=""/>
				</div>
				</div>
				
				<div class="row form-group">
				<div class="col col-md-3">
				<label for="text-input" class="form-control-label">Seo Role*</label>
				</div>
				<div class="col-12 col-md-9">
				<select id="teamId" name="teamId" class="form-control">
				<option value="0" selected="selected">Please Select</option>
				<option value="1" >TL</option>
				<option value="2" >Member</option>
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
				<option value="<?php echo $rowtl['id']; ?>" ><?php echo $rowtl['member_name']; ?></option>
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
 
