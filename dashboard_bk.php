<?php require_once('header.php'); 

$query_client = "select count(*) as totalclient from Client";
$result = mysqli_query($connection , $query_client);
while($row = mysqli_fetch_row($result)) {
	$totalclient =  $row[0];
}

$query_user = "select count(*) as totaluser from users";
$result_user = mysqli_query($connection , $query_user);
while($row_user = mysqli_fetch_row($result_user)) {
	$totaluser =  $row_user[0];
}

$query_queue = "select count(*) as totalqueue from cc_queue_table";
$result_queue = mysqli_query($connection , $query_queue);
while($row_que = mysqli_fetch_row($result_queue)) {
	$totalqueue =  $row_que[0];
}

$query_ext = "select count(*) as totalext from cc_sip_buddies";
$result_ext = mysqli_query($connection , $query_ext);
while($row_ext = mysqli_fetch_row($result_ext)) {
	$totalext =  $row_ext[0];
}

$query_inbound = "select count(*) as totalinbound from cc_did";
$result_inbound = mysqli_query($connection , $query_inbound);
while($row_inbound = mysqli_fetch_row($result_inbound)) {
	$totalinbound =  $row_inbound[0];
}

$query_outbound = "select count(*) as totaloutbound from cc_trunk";
$result_outbound = mysqli_query($connection , $query_outbound);
while($row_outbound = mysqli_fetch_row($result_outbound)) {
	$totaloutbound =  $row_outbound[0];
}

$query_blacklist = "select count(*) as totalblacklist from cc_blacklist";
$result_blacklist = mysqli_query($connection , $query_blacklist);
while($row_blacklist = mysqli_fetch_row($result_blacklist)) {
	$totalblacklist =  $row_blacklist[0];
}
?>
        <!-- START CONTAINER -->
        <div class="page-container row-fluid">
            <!-- SIDEBAR - START -->
            <div class="page-sidebar ">
                <!-- MAIN MENU - START -->
                <div class="page-sidebar-wrapper" id="main-menu-wrapper"> 
					<!-- USER INFO - END -->
					<?php require_once('menu.php'); ?>

                </div>
                <!-- MAIN MENU - END -->
            </div>
            <!--  SIDEBAR - END -->
            <!-- START CONTENT -->
            <section id="main-content" class=" ">
                <section class="wrapper main-wrapper" style=''>

                    <div class='col-xl-12 col-lg-12 col-md-12 col-12'>
                        <div class="page-title">

                            <div class="float-left">
                                <h1 class="title">Dashboard</h1>                            </div>


                        </div>
                    </div>
                    <div class="clearfix"></div>


                    <div class="col-xl-12">
                        <section class="box nobox">
                            <div class="content-body">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="r4_counter db_box">
                                            <i class='float-left fa fa-user icon-md icon-rounded icon-warning'></i>
                                            <div class="stats">
                                                <h4><strong><?php echo $totalclient; ?></strong></h4>
                                                <span>Clients</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="r4_counter db_box">
                                            <i class='float-left fa fa-users icon-md icon-rounded icon-red'></i>
                                            <div class="stats">
                                                <h4><strong><?php echo $totaluser; ?></strong></h4>
                                                <span>Users</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                       <a href="biglives.php">
									   <div class="r4_counter db_box">
                                            <i class='float-left fa fa-wifi icon-md icon-rounded icon-success'></i>
                                            <div class="stats">
                                                <h4><strong><?php echo $totalqueue; ?></strong></h4>
                                                <span>Big Lives</span>
                                            </div>
                                        </div>
										</a>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="r4_counter db_box">
                                            <i class='float-left fa fa-paw icon-md icon-rounded icon-warning'></i>
                                            <div class="stats">
                                                <h4><strong><?php echo $totalqueue; ?></strong></h4>
                                                <span>Queues</span>
                                            </div>
                                        </div>
                                    </div>
									
									 <div class="col-lg-3 col-md-6 col-12">
                                        <div class="r4_counter db_box">
                                            <i class='float-left fa fa-headphones icon-md icon-rounded icon-purple'></i>
                                            <div class="stats">
                                                <h4><strong><?php echo $totalext; ?></strong></h4>
                                                <span>Extensions</span>
                                            </div>
                                        </div>
                                    </div>
									 <div class="col-lg-3 col-md-6 col-12">
                                        <div class="r4_counter db_box">
                                            <i class='float-left fa fa-phone icon-md icon-rounded icon-success'></i>
                                            <div class="stats">
                                                <h4><strong><?php echo $totalinbound; ?></strong></h4>
                                                <span>Inbound Route</span>
                                            </div>
                                        </div>
                                    </div> <div class="col-lg-3 col-md-6 col-12">
                                        <div class="r4_counter db_box">
                                            <i class='float-left fa fa-reply icon-md icon-rounded icon-warning'></i>
                                            <div class="stats">
                                                <h4><strong><?php echo $totaloutbound; ?></strong></h4>
                                                <span>Outbound Route</span>
                                            </div>
                                        </div>
                                    </div>
									 <div class="col-lg-3 col-md-6 col-12">
                                        <div class="r4_counter db_box">
                                            <i class='float-left fa fa-share icon-md icon-rounded icon-danger'></i>
                                            <div class="stats">
                                                <h4><strong><?php echo $totaloutbound; ?></strong></h4>
                                                <span>Trunk</span>
                                            </div>
                                        </div>
                                    </div>
									 <div class="col-lg-3 col-md-6 col-12">
                                        <div class="r4_counter db_box">
                                            <i class='float-left fa fa-users icon-md icon-rounded icon-success'></i>
                                            <div class="stats">
                                                <h4><strong><?php echo $totaloutbound; ?></strong></h4>
                                                <span>BlackList</span>
                                            </div>
                                        </div>
                                    </div>
									 <div class="col-lg-3 col-md-6 col-12">
                                        <div class="r4_counter db_box">
                                            <i class='float-left fa fa-microphone icon-md icon-rounded icon-danger'></i>
                                            <div class="stats">
                                                <h4><strong><?php echo '0'; ?></strong></h4>
                                                <span>IVR</span>
                                            </div>
                                        </div>
                                    </div>
									 <div class="col-lg-3 col-md-6 col-12">
                                        <div class="r4_counter db_box">
                                            <i class='float-left fa fa-users icon-md icon-rounded icon-purple'></i>
                                            <div class="stats">
                                                <h4><strong><?php echo '--'; ?></strong></h4>
                                                <span>Reports</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- End .row -->	

                            </div>
                        </section></div>
                </section>
            </section>
            <!-- END CONTENT -->
            <div class="page-chatapi hideit">


                <div class="chat-wrapper">
                    
                </div>

            </div>
  </div>
<?php require_once('footer.php'); ?>