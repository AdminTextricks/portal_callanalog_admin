<?php require_once('connection.php'); 

?>
<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="au theme template">
<meta name="author" content="Hau Nguyen">
<meta name="keywords" content="au theme template">

<title>Big Live Detail</title>

 <link href="resources/css/font-face.css" rel="stylesheet" media="all"> 
 <link href="resources/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all"> 

<link href="resources/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all"> 
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="resources/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

 <link href="resources/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">

<link href="resources/vendor/select2/select2.min.css" rel="stylesheet" media="all">
<link href="resources/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
<link href="resources/css/theme.css" rel="stylesheet" media="all">
<link href="resources/css/custom_style.css" rel="stylesheet" media="all">
 <link rel="icon" href="resources/images/favicon.png" sizes="32x32"/>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

<!-- Date pickers start -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Date pickers end -->

<!-- <script src="resources/js/datatables.min.js"></script>
<link href='resources/css/datatables.min.css' rel='stylesheet' type='text/css'>


<script src="jquery-3.3.1.min_test.js"></script> -->
<script src="DataTables/datatables.min.js"></script>
<link href="DataTables/datatables.min.css" rel='stylesheet' type='text/css'>
<script>
 

</script>

<script language="javascript" type="text/javascript">
	var autoLoad = setInterval(
   function ()
   {
      $('#sample').load('biglives_content.php');
   }, 1000); // refresh page every 10 seconds
   
   var autoLoad = setInterval(
   function ()
   {
      $('#sample_barge').load('barge_content.php');
   }, 1000); // refresh page every 10 seconds
</script>

</head>
<body class="animsition">

			
<div class="page-wrapper">

 
 
<style>
#queryNumber {border: 1px solid gainsboro;padding: 6px 0 6px 10px;}	
#getQueryBtn {float: left;margin: 0 20px 0 5px;padding: 6px 15px;background: #2aa9de;color: white;}
@media(max-width:767px){ #queryNumber, #getQueryBtn {display:none} }
</style>
