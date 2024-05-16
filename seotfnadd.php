<?php require_once('header.php'); 

if(isset($_POST['submit']))
{
	 $insert_seo = "insert into seo_tfns (member_id,queue,team_id,tfn,status) Values ('".$_POST['memberId']."','".$_POST['queue']."','".$_POST['teamId']."','".$_POST['tfn']."','1')";
	 $result_seo = mysqli_query($con,$insert_seo);	
	 if($result_seo)
	 {
		 $message = "SEO TFN added successfully.";
		 header('location : seotfn.php');
	 }
 
}
$select_tl = "SELECT * FROM `seo_members` WHERE tl_id =0";
$result_tl = mysqli_query($con,$select_tl);

$select_mem = "SELECT * FROM `seo_members`";
$result_mem = mysqli_query($con,$select_mem);

?>
<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
<h2 class="title-1"> Add SEO TFN <span style="margin-left:50px;"><?php echo $message; ?></span></h2>
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
            <form id="seoTfn" action="" name="seotfnadd" method="post">
                
				<div class="row form-group">
				<div class="col col-md-3">
				<label for="text-input" class="form-control-label">TFN*</label>
				</div>
				<div class="col-12 col-md-9">
				<input id="tfn" name="tfn" class="form-control numbersOnly" type="text" value=""/>
				</div>
				</div>
				
				<div class="row form-group">
				<div class="col col-md-3">
				<label for="text-input" class="form-control-label">Queue*</label>
				</div>
				<div class="col-12 col-md-9">
				<input id="queue" name="queue" class="form-control numbersOnly" type="text" value=""/>
				</div>
				</div>
				
				
				<div class="row form-group">
				<div class="col col-md-3">
				<label for="text-input" class="form-control-label">TL Name*</label>
				</div>
				<div class="col-12 col-md-9">
				<select id="teamId" name="teamId" class="form-control">
				<option value="0" selected="selected">Please Select</option>
				<?php while($rowtl = mysqli_fetch_array($result_tl)) { ?>
				<option value="<?php echo $rowtl['id']; ?>"><?php echo $rowtl['member_name']; ?></option>
				<?php } ?>
				</select>
				</div>
				</div>
				
				<div class="row form-group">
				<div class="col col-md-3">
				<label for="text-input" class="form-control-label">Member Name*</label>
				</div>
				<div class="col-12 col-md-9">
				<select id="memberId" name="memberId" class="form-control">
				<option value="0">Please Select</option>
				<?php while($rowdd = mysqli_fetch_array($result_mem)){ ?>
				<option value="<?php echo $rowdd['id']; ?>"><?php echo $rowdd['member_name']; ?></option>
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
<div class="copyright">
<p>Copyright Â© 2020 PBX. All rights reserved.</p>
</div>
</div>
<?php require_once('footer.php'); ?> 
 
