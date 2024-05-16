<?php require_once('connection.php'); 

if(!isset($_SESSION['login_user']))
{
	header('location: index.php');
}
?>
<!DOCTYPE html>
<html class=" ">
    <head>
        <!-- 
         * @Package: Ultra Admin - Responsive Theme
         * @Subpackage: Bootstrap
         * @Version: B4-1.3
         * This file is part of Ultra Admin Theme.
        -->
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>BIGPBX : Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />    <!-- Favicon -->
        <link rel="apple-touch-icon-precomposed" href="assets/images/apple-touch-icon-57-precomposed.png">	<!-- For iPhone -->
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/apple-touch-icon-114-precomposed.png">    <!-- For iPhone 4 Retina display -->
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/apple-touch-icon-72-precomposed.png">    <!-- For iPad -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/apple-touch-icon-144-precomposed.png">    <!-- For iPad Retina display -->

        <!-- CORE CSS FRAMEWORK - START -->
        <link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS FRAMEWORK - END -->

        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <link href="assets/plugins/morris-chart/css/morris.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/jquery-ui/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/jvectormap/jquery-jvectormap-2.0.1.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/icheck/skins/minimal/white.css" rel="stylesheet" type="text/css" media="screen"/>        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 

	  <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <link href="assets/plugins/jquery-ui/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/datepicker/css/datepicker.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/daterangepicker/css/daterangepicker-bs3.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/timepicker/css/bootstrap-timepicker.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/ios-switch/css/switch.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/select2/select2.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/typeahead/css/typeahead.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/multi-select/css/multi-select.css" rel="stylesheet" type="text/css" media="screen"/>        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 

        <!-- CORE CSS TEMPLATE - START -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css"/>
		
		<link href='assets/css/datatables.min.css' rel='stylesheet' type='text/css'>

        <!-- Datatable JS -->
        <script src="assets/js/datatables.min.js"></script>
		
        <!-- CORE CSS TEMPLATE - END -->
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

		<script language="javascript" type="text/javascript">
	var autoLoad = setInterval(
   function ()
   {
      $('#sample').load('biglives_content.php');
   }, 1000); // refresh page every 10 seconds
</script>

    </head>
	 <body class=" "><!-- START TOPBAR -->
	 
	         <div class='page-topbar '>
            <div class='logo-area'>

            </div>
            <div class='quick-area'>
                <div class='float-left'>
                    <ul class="info-menu left-links list-inline list-unstyled">
                       <li class="notify-toggle-wrapper list-inline-item">
                            <ul class="dropdown-menu notifications animated fadeIn">
                                
                                <li class="list dropdown-item">

                                </li>
                            </ul>
                        </li>
                        <li class="d-sm-none d-none searchform list-inline-item">
                            <div class="input-group">
                                <span class="input-group-addon input-focus">
                                    <i class="fa fa-search"></i>
                                </span>
                                <form action="search-page.html" method="post">
                                    <input type="text" class="form-control animated fadeIn" placeholder="Search & Enter">
                                    <input type='submit' value="">
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>		
                <div class='float-right'>
                    <ul class="info-menu right-links list-inline list-unstyled">
                        <li class="profile list-inline-item">
                            <a href="#" data-toggle="dropdown" class="toggle">
                                <img src="data/profile/profile.png" alt="user-image" class="rounded-circle img-inline">
                                <span>Sanjeet Sangwan <i class="fa fa-angle-down"></i></span>
                            </a>
                            <ul class="dropdown-menu profile animated fadeIn">
                                <li class="dropdown-item">
                                    <a href="#settings">
                                        <i class="fa fa-wrench"></i>
                                        Settings
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="#profile">
                                        <i class="fa fa-user"></i>
                                        Profile
                                    </a>
                                </li>
                                
                                <li class="last dropdown-item">
                                    <a href="logout.php">
                                        <i class="fa fa-lock"></i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                       
                    </ul>			
                </div>		
            </div>

        </div>
        <!-- END TOPBAR -->
		