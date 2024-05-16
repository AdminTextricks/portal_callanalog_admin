

  

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

 <link href="/resources/css/font-face.css" rel="stylesheet" media="all"> 
 <link href="/resources/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all"> 

<link href="/resources/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all"> 
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="/resources/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

 <link href="/resources/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">

<link href="/resources/vendor/select2/select2.min.css" rel="stylesheet" media="all">
<link href="/resources/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
<link href="/resources/css/theme.css" rel="stylesheet" media="all">
<link href="/resources/css/custom_style.css" rel="stylesheet" media="all">
 <link rel="icon" href="/resources/images/favicon.png" sizes="32x32"/>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

<script>
$(document).ready(function(){
    $(".show_btn_togle").click(function(){
    	//$(this).removeClass("mini_sidebar");
        $(".menu-sidebar").addClass("mini_sidebar");
        $(".show_btn_togle").hide();
        $(".close_btn_togle").show();
        $(".page-container").addClass("full_width_page_container");
        $(".header-desktop").addClass("header_desktop_full_width");
    });
    $(".close_btn_togle").click(function(){
    	$(".menu-sidebar").removeClass("mini_sidebar");
    	$(".show_btn_togle").show();
        $(".close_btn_togle").hide();
        $(".page-container").removeClass("full_width_page_container");
        $(".header-desktop").removeClass("header_desktop_full_width");
    });
});

</script>

</head>
<body class="animsition">

			
<div class="page-wrapper">

<header class="header-mobile d-block d-lg-none">
<div class="header-mobile__bar">
<div class="container-fluid">
<div class="header-mobile-inner">
<a class="logo" href="/">
<img src="/resources/images/icon/logo.png" alt="CoolAdmin" />
</a>
<button class="hamburger hamburger--slider" type="button">
<span class="hamburger-box">
<span class="hamburger-inner"></span>
</span>
</button>
</div>
</div>
</div>
<nav class="navbar-mobile">
<div class="container-fluid">
<ul class="navbar-mobile__list list-unstyled">
<li class="has-sub">
<a class="js-arrow" href="index.html">
<i class="fas fa-tachometer-alt"></i>Dashboard</a>
</li>

<li>
<a href="#">
<i class="fa fa-podcast" aria-hidden="true"></i>Big Live</a>
</li>
<li>
<a href="manage-queue.html">
<i class="fa fa-quora" aria-hidden="true"></i>Manage Queue</a>
</li>
<li>
<a href="#">
<i class="fa fa-etsy" aria-hidden="true"></i>Manage Extension</a>
</li>
<li>
<a href="#">
<i class="fas fa-calendar-alt"></i>Inbound Route</a>
</li>
<li>
<a href="#">
<i class="fa fa-opera" aria-hidden="true"></i>Outbound Route</a>
</li>
<li>
<a href="#">
<i class="far fa-check-square"></i>Manage Extension</a>
</li>

<li>
<a href="#">
<i class="fas fa-map-marker-alt"></i>Trunk</a>
</li>

<li>
<a href="#">
<i class="fa fa-users" aria-hidden="true"></i>Company</a>
</li>

<li>
<a href="#">
<i class="fas fa-map-marker-alt"></i>BlackList</a>
</li>


</ul>
</div>
</nav>
</header>





<aside class="menu-sidebar d-none d-lg-block">
<div class="logo">
	<span class="mini_logo"><img src="/resources/images/mini_logo.png" alt="mini logo" /></span>
<a class="full_logo" href="/dashboard">
<img src="/resources/images/BigPbx-logo-_Color.png" style="width: 165px;" alt="logo" />
</a>

</div>
<div class="menu-sidebar__content js-scrollbar1">
<nav class="navbar-sidebar">
<ul class="list-unstyled navbar__list">







<li class="has-sub" id="menu1">
<a href="/dashboard">
<i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
</li>































<li class="has-sub" id="menu2">
<a href="/pbx/live">
<i class="fa fa-podcast"></i> <span>Big Live</span></a>
</li>































<li class="has-sub" id="menu3">
<a href="/showqueues">
<i class="fa fa-quora"></i> <span>Manage Queue</span></a>
</li>































<li class="has-sub" id="menu4">
<a href="/showextensions">
<i class="fa fa-etsy"></i> <span>Manage Extension</span></a>
</li>































<li class="has-sub" id="menu5">
<a href="/showinbounds">
<i class="fas fa-calendar-alt"></i> <span>Inbound Route</span></a>
</li>































<li class="has-sub" id="menu6">
<a href="/showoutbounds">
<i class="fa fa-opera"></i> <span>Outbound Route</span></a>
</li>































<li class="has-sub" id="menu7">
<a href="/showtrunks">
<i class="fas fa-map-marker-alt"></i> <span>Trunk</span></a>
</li>































<li class="has-sub" id="menu8">
<a href="/showusers">
<i class="fa fa-users"></i> <span>Users</span></a>
</li>































<li class="has-sub" id="menu9">
<a href="/showblacklist">
<i class="fa fa-lock"></i> <span>BlackList</span></a>
</li>































<li class="has-sub" id="menu10">
<a href="/reports">
<i class="fa fa-flag"></i> <span>Reports</span></a>
</li>































<li class="has-sub" id="menu11">
<a href="/message/form">
<i class="fa fa-envelope"></i> <span>Messaging</span></a>
</li>



























































<li class="has-sub" id="menu13">
<a href="/show/clients">
<i class="fa fa-users"></i> <span>Manage Clients</span></a>
</li>































<li class="has-sub" id="menu14">
<a href="/show/ivrs">
<i class="fas fa-microphone"></i> <span>Manage IVR</span></a>
</li>




</ul>
</nav>
 </div>
</aside>




<div class="page-container">

 
 
<style>
#queryNumber {border: 1px solid gainsboro;padding: 6px 0 6px 10px;}	
#getQueryBtn {float: left;margin: 0 20px 0 5px;padding: 6px 15px;background: #2aa9de;color: white;}
@media(max-width:767px){ #queryNumber, #getQueryBtn {display:none} }
</style>
<header class="header-desktop">
<div class="section__content section__content--p30">
<div class="container-fluid">
<div class="header-wrap">
	<div class="left_slide_icon">
		
		<i class="fa fa-bars zmdi zmdi-menu show_btn_togle" aria-hidden="true"></i>
		<i class="fa fa-bars zmdi zmdi-menu close_btn_togle" aria-hidden="true"></i>
	</div>


<div class="header-button">
	<input type="text" placeholder="Enter Phone No" class="numbersOnly" id="queryNumber" />
	<input type="button"   value="Get Query" id="getQueryBtn" />

<div class="account-wrap">
<div class="account-item clearfix js-item-menu">
<div class="image">
<span>A</span>
</div>
<div class="content">
<a class="js-acc-btn" href="#">Alok Sir</a>
</div>
<div class="account-dropdown js-dropdown">
<div class="info clearfix">
<div class="image">
<a href="#">

<span>A</span>
</a>
</div>
<div class="content">
<h5 class="name">
<a href="#">Alok Sir</a>
</h5>
<!-- <span class="email"><a href="#" class="__cf_email__" data-cfemail="9ff5f0f7f1fbf0fadffae7fef2eff3fab1fcf0f2">[email&#160;protected]</a></span>  -->
</div>
</div>
<div class="account-dropdown__footer">
<a href="/resetpassword">
<i class="fa fa-sign-out zmdi zmdi-power" aria-hidden="true"></i> Reset Password</a>
</div>
<div class="account-dropdown__footer">
<a href="/logout">
<i class="fa fa-sign-out zmdi zmdi-power" aria-hidden="true"></i> Logout</a>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</header>

<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        Modal body..
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<script>
$("#getQueryBtn").click(function(){
var queryNumber = $("#queryNumber").val();
if(queryNumber.length < 10){
	alert("Please enter valid phone number");
	return;
}	
$.get('/callback/query?phone='+queryNumber,  // url
      function (data, textStatus, jqXHR) {  // success callback
	  
          var res = JSON.parse(data);
		  $(".modal-title").html(res.name);
		  $(".modal-body").html(res.message);
		  $("#myModal").modal();
    });
})
$('.numbersOnly').keyup(function () {
        	    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
        	       this.value = this.value.replace(/[^0-9\.]/g, '');
        	    }
        	});	
</script>


<input type="hidden" id="userId" value="3">			
<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">

<div class="row">
<div class="col-md-12">
<div class="overview-wrap">

<h2 class="title-1">Queue Summary</h2>

</div>
</div>
</div>


<div class="row">
<div class="col-md-12">

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
   <!-- <h4 class="table_title">Careerera PPC</h4> -->
<table class="table manage_queue_table">
<thead>
<tr>
<th>Queue</th>
<th>Queue Name</th>
<th>Customer Name</th>
<th>Inbound/Outbound</th>
<th>Paused/Total</th>
<th>Calls Waiting</th>
<th>Total Calls</th>
<th>Abandoned Calls</th>
<th>Last Update Time</th>
</tr>
</thead>
<tbody>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td> 0001</td>
<td>Kunden Team</td>
<td>Admin </td>
<td class="desc" id="outin- 0001">0/0</td>
<td>0/10</td>
<td id="waiting- 0001">0</td>
<td>0</td>
<td>0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>0002</td>
<td>Mohit Team</td>
<td>Admin </td>
<td class="desc" id="outin-0002">0/0</td>
<td>0/16</td>
<td id="waiting-0002">0</td>
<td>29</td>
<td>14</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>0003</td>
<td>Vikram Team</td>
<td>Admin </td>
<td class="desc" id="outin-0003">0/0</td>
<td>4/12</td>
<td id="waiting-0003">0</td>
<td>18</td>
<td>6</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>0004</td>
<td>Neha Team</td>
<td>Admin </td>
<td class="desc" id="outin-0004">0/0</td>
<td>0/18</td>
<td id="waiting-0004">0</td>
<td>625</td>
<td>393</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>0005</td>
<td>Pooja Team</td>
<td>Admin </td>
<td class="desc" id="outin-0005">0/0</td>
<td>0/10</td>
<td id="waiting-0005">0</td>
<td>315</td>
<td>217</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>0006</td>
<td>Sandeep Team</td>
<td>Admin </td>
<td class="desc" id="outin-0006">0/0</td>
<td>3/57</td>
<td id="waiting-0006">0</td>
<td>2085</td>
<td>1252</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>0007</td>
<td>Kanishka and SaurabhTeam</td>
<td>Admin </td>
<td class="desc" id="outin-0007">0/0</td>
<td>0/16</td>
<td id="waiting-0007">0</td>
<td>73</td>
<td>50</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>0008</td>
<td>Rohit Team</td>
<td>Admin </td>
<td class="desc" id="outin-0008">0/0</td>
<td>11/34</td>
<td id="waiting-0008">0</td>
<td>613</td>
<td>373</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>80001</td>
<td>IT-QUEUE</td>
<td>Admin </td>
<td class="desc" id="outin-80001">0/0</td>
<td>0/3</td>
<td id="waiting-80001">0</td>
<td>0</td>
<td>0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>5001</td>
<td>Ranveer-Team</td>
<td>Admin </td>
<td class="desc" id="outin-5001">0/0</td>
<td>2/2</td>
<td id="waiting-5001">0</td>
<td>0</td>
<td>0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>2001</td>
<td>HR-Team</td>
<td>Admin </td>
<td class="desc" id="outin-2001">0/0</td>
<td>2/10</td>
<td id="waiting-2001">0</td>
<td>0</td>
<td>0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>2002</td>
<td>PM-Team</td>
<td>Admin </td>
<td class="desc" id="outin-2002">0/0</td>
<td>0/2</td>
<td id="waiting-2002">0</td>
<td>0</td>
<td>0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>0009</td>
<td>Amber(US Team)</td>
<td>Admin </td>
<td class="desc" id="outin-0009">0/0</td>
<td>3/8</td>
<td id="waiting-0009">0</td>
<td>106</td>
<td>20</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>00011</td>
<td>EDUKASION SUPPORT</td>
<td>Admin </td>
<td class="desc" id="outin-00011">0/0</td>
<td>0/1</td>
<td id="waiting-00011">0</td>
<td>0</td>
<td>0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>5526</td>
<td>Scrumversity</td>
<td>Admin </td>
<td class="desc" id="outin-5526">0/0</td>
<td>0/2</td>
<td id="waiting-5526">0</td>
<td>0</td>
<td>0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>9120</td>
<td>OutBond Travoment</td>
<td>Admin </td>
<td class="desc" id="outin-9120">0/0</td>
<td>1/1</td>
<td id="waiting-9120">0</td>
<td>0</td>
<td>0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>99001</td>
<td>Shivam</td>
<td>Admin </td>
<td class="desc" id="outin-99001">0/0</td>
<td>2/4</td>
<td id="waiting-99001">0</td>
<td>0</td>
<td>0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>00001</td>
<td>Extenal-TFN-Queue</td>
<td>Admin </td>
<td class="desc" id="outin-00001">0/0</td>
<td>0/1</td>
<td id="waiting-00001">0</td>
<td>0</td>
<td>0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>5506</td>
<td>CareerEra_Vikaram_TL</td>
<td>Admin </td>
<td class="desc" id="outin-5506">0/0</td>
<td>0/5</td>
<td id="waiting-5506">0</td>
<td>0</td>
<td>0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>5532</td>
<td>Interview Edukasion</td>
<td>Admin </td>
<td class="desc" id="outin-5532">0/0</td>
<td>0/0</td>
<td id="waiting-5532">0</td>
<td>0</td>
<td>0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>550051</td>
<td>Munish_Dabra</td>
<td>Admin </td>
<td class="desc" id="outin-550051">0/0</td>
<td>2/2</td>
<td id="waiting-550051">0</td>
<td>0</td>
<td>0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>900221</td>
<td>CRM_CALL_QUEUE</td>
<td>Admin </td>
<td class="desc" id="outin-900221">0/0</td>
<td>0/0</td>
<td id="waiting-900221">0</td>
<td>0</td>
<td>0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>10000</td>
<td>Wines_Queue</td>
<td>Admin </td>
<td class="desc" id="outin-10000">0/0</td>
<td>0/4</td>
<td id="waiting-10000">0</td>
<td>4</td>
<td>4</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>72900</td>
<td>testing729004</td>
<td>Admin </td>
<td class="desc" id="outin-72900">0/0</td>
<td>2/2</td>
<td id="waiting-72900">0</td>
<td>0</td>
<td>0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>0055</td>
<td>Jeevach_Queue</td>
<td>Admin </td>
<td class="desc" id="outin-0055">0/0</td>
<td>1/12</td>
<td id="waiting-0055">0</td>
<td>467</td>
<td>330</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>0066</td>
<td>AshwiniG_Queue</td>
<td>Admin </td>
<td class="desc" id="outin-0066">0/0</td>
<td>5/14</td>
<td id="waiting-0066">0</td>
<td>0</td>
<td>0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>005550</td>
<td>TL_QUEUE</td>
<td>Admin </td>
<td class="desc" id="outin-005550">0/0</td>
<td>0/9</td>
<td id="waiting-005550">0</td>
<td>0</td>
<td>0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>0044</td>
<td>Vikram_Aus</td>
<td>Admin </td>
<td class="desc" id="outin-0044">0/0</td>
<td>3/5</td>
<td id="waiting-0044">0</td>
<td>5</td>
<td>0</td>
<td class="lastTime">--</td>
</tr>


</tbody>
</table>
</div>
</div>
</div>
<input type="hidden" value=" 0001,0002,0003,0004,0005,0006,0007,0008,80001,5001,2001,2002,0009,00011,5526,9120,99001,00001,5506,5532,550051,900221,10000,72900,0055,0066,005550,0044," id="queueNumbers" />
<div class="row">
<div class="col-md-12">
<div class="overview-wrap">


<h2 class="title-1">Waiting Status</h2>

</div>
</div>
</div>


<div class="row">
<div class="col-md-12">

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title"></h4>
<table class="table manage_queue_table">
<thead>
<tr>
<th>Queue Name</th>
<th>TFN</th>
<th>Duration</th>
<th>CLID</th>
<th>Action</th>
</tr>
</thead>
<tbody id="callWaiting">



</tbody>
</table>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div class="overview-wrap">


<h2 class="title-1">Agent Status</h2>

</div>
</div>
</div>


<div class="row">
<div class="col-md-12">

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Kunden Team</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td> 0001 / Kunden Team</td>
<td class="name" id="name- 0001-100">Kundan Singh </td>
<td class="desc">100</td>
<td class="duration" id="duration- 0001-100">--</td>
<td class="did" id="did- 0001-100">--</td>
<td class="clid" id="clid- 0001-100">--</td>
<td class="status" id="status- 0001-100">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext=" 0001-100">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td> 0001 / Kunden Team</td>
<td class="name" id="name- 0001-109">Vipin </td>
<td class="desc">109</td>
<td class="duration" id="duration- 0001-109">--</td>
<td class="did" id="did- 0001-109">--</td>
<td class="clid" id="clid- 0001-109">--</td>
<td class="status" id="status- 0001-109">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext=" 0001-109">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td> 0001 / Kunden Team</td>
<td class="name" id="name- 0001-108">Prakhar </td>
<td class="desc">108</td>
<td class="duration" id="duration- 0001-108">--</td>
<td class="did" id="did- 0001-108">--</td>
<td class="clid" id="clid- 0001-108">--</td>
<td class="status" id="status- 0001-108">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext=" 0001-108">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td> 0001 / Kunden Team</td>
<td class="name" id="name- 0001-106">Abhishek Mishra </td>
<td class="desc">106</td>
<td class="duration" id="duration- 0001-106">--</td>
<td class="did" id="did- 0001-106">--</td>
<td class="clid" id="clid- 0001-106">--</td>
<td class="status" id="status- 0001-106">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext=" 0001-106">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td> 0001 / Kunden Team</td>
<td class="name" id="name- 0001-105">GlobalcallbyVipin </td>
<td class="desc">105</td>
<td class="duration" id="duration- 0001-105">--</td>
<td class="did" id="did- 0001-105">--</td>
<td class="clid" id="clid- 0001-105">--</td>
<td class="status" id="status- 0001-105">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext=" 0001-105">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td> 0001 / Kunden Team</td>
<td class="name" id="name- 0001-104">Juhi Dubey </td>
<td class="desc">104</td>
<td class="duration" id="duration- 0001-104">--</td>
<td class="did" id="did- 0001-104">--</td>
<td class="clid" id="clid- 0001-104">--</td>
<td class="status" id="status- 0001-104">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext=" 0001-104">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td> 0001 / Kunden Team</td>
<td class="name" id="name- 0001-103">Anuradha </td>
<td class="desc">103</td>
<td class="duration" id="duration- 0001-103">--</td>
<td class="did" id="did- 0001-103">--</td>
<td class="clid" id="clid- 0001-103">--</td>
<td class="status" id="status- 0001-103">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext=" 0001-103">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td> 0001 / Kunden Team</td>
<td class="name" id="name- 0001-102">Shruti Verma </td>
<td class="desc">102</td>
<td class="duration" id="duration- 0001-102">--</td>
<td class="did" id="did- 0001-102">--</td>
<td class="clid" id="clid- 0001-102">--</td>
<td class="status" id="status- 0001-102">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext=" 0001-102">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td> 0001 / Kunden Team</td>
<td class="name" id="name- 0001-101">GlobalcallbyShruti </td>
<td class="desc">101</td>
<td class="duration" id="duration- 0001-101">--</td>
<td class="did" id="did- 0001-101">--</td>
<td class="clid" id="clid- 0001-101">--</td>
<td class="status" id="status- 0001-101">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext=" 0001-101">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td> 0001 / Kunden Team</td>
<td class="name" id="name- 0001-110">Prince Tyagi  </td>
<td class="desc">110</td>
<td class="duration" id="duration- 0001-110">--</td>
<td class="did" id="did- 0001-110">--</td>
<td class="clid" id="clid- 0001-110">--</td>
<td class="status" id="status- 0001-110">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext=" 0001-110">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Mohit Team</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0002 / Mohit Team</td>
<td class="name" id="name-0002-200">Mohit Purthi </td>
<td class="desc">200</td>
<td class="duration" id="duration-0002-200">--</td>
<td class="did" id="did-0002-200">--</td>
<td class="clid" id="clid-0002-200">--</td>
<td class="status" id="status-0002-200">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0002-200">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0002 / Mohit Team</td>
<td class="name" id="name-0002-234">MiddleEast Calling User5 </td>
<td class="desc">234</td>
<td class="duration" id="duration-0002-234">--</td>
<td class="did" id="did-0002-234">--</td>
<td class="clid" id="clid-0002-234">--</td>
<td class="status" id="status-0002-234">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0002-234">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0002 / Mohit Team</td>
<td class="name" id="name-0002-233">MiddleEast Calling User4 </td>
<td class="desc">233</td>
<td class="duration" id="duration-0002-233">--</td>
<td class="did" id="did-0002-233">--</td>
<td class="clid" id="clid-0002-233">--</td>
<td class="status" id="status-0002-233">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0002-233">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0002 / Mohit Team</td>
<td class="name" id="name-0002-232">MiddleEast Calling User3 </td>
<td class="desc">232</td>
<td class="duration" id="duration-0002-232">--</td>
<td class="did" id="did-0002-232">--</td>
<td class="clid" id="clid-0002-232">--</td>
<td class="status" id="status-0002-232">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0002-232">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0002 / Mohit Team</td>
<td class="name" id="name-0002-231">MiddleEast Calling User2 </td>
<td class="desc">231</td>
<td class="duration" id="duration-0002-231">--</td>
<td class="did" id="did-0002-231">--</td>
<td class="clid" id="clid-0002-231">--</td>
<td class="status" id="status-0002-231">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0002-231">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0002 / Mohit Team</td>
<td class="name" id="name-0002-230">MiddleEast Calling User1 </td>
<td class="desc">230</td>
<td class="duration" id="duration-0002-230">--</td>
<td class="did" id="did-0002-230">--</td>
<td class="clid" id="clid-0002-230">--</td>
<td class="status" id="status-0002-230">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0002-230">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0002 / Mohit Team</td>
<td class="name" id="name-0002-209">Gobalcallbysonu </td>
<td class="desc">209</td>
<td class="duration" id="duration-0002-209">--</td>
<td class="did" id="did-0002-209">--</td>
<td class="clid" id="clid-0002-209">--</td>
<td class="status" id="status-0002-209">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0002-209">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0002 / Mohit Team</td>
<td class="name" id="name-0002-208">Chintu </td>
<td class="desc">208</td>
<td class="duration" id="duration-0002-208">--</td>
<td class="did" id="did-0002-208">--</td>
<td class="clid" id="clid-0002-208">--</td>
<td class="status" id="status-0002-208">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0002-208">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0002 / Mohit Team</td>
<td class="name" id="name-0002-207">Abhisekh Tiwari </td>
<td class="desc">207</td>
<td class="duration" id="duration-0002-207">--</td>
<td class="did" id="did-0002-207">--</td>
<td class="clid" id="clid-0002-207">--</td>
<td class="status" id="status-0002-207">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0002-207">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0002 / Mohit Team</td>
<td class="name" id="name-0002-206">Saurabh </td>
<td class="desc">206</td>
<td class="duration" id="duration-0002-206">--</td>
<td class="did" id="did-0002-206">--</td>
<td class="clid" id="clid-0002-206">--</td>
<td class="status" id="status-0002-206">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0002-206">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0002 / Mohit Team</td>
<td class="name" id="name-0002-205">Nanka kumari </td>
<td class="desc">205</td>
<td class="duration" id="duration-0002-205">--</td>
<td class="did" id="did-0002-205">--</td>
<td class="clid" id="clid-0002-205">--</td>
<td class="status" id="status-0002-205">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0002-205">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0002 / Mohit Team</td>
<td class="name" id="name-0002-204">Sonu kumar </td>
<td class="desc">204</td>
<td class="duration" id="duration-0002-204">--</td>
<td class="did" id="did-0002-204">--</td>
<td class="clid" id="clid-0002-204">--</td>
<td class="status" id="status-0002-204">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0002-204">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0002 / Mohit Team</td>
<td class="name" id="name-0002-203">dheeraj </td>
<td class="desc">203</td>
<td class="duration" id="duration-0002-203">--</td>
<td class="did" id="did-0002-203">--</td>
<td class="clid" id="clid-0002-203">--</td>
<td class="status" id="status-0002-203">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0002-203">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0002 / Mohit Team</td>
<td class="name" id="name-0002-202">Gobalcallbydeeraj </td>
<td class="desc">202</td>
<td class="duration" id="duration-0002-202">--</td>
<td class="did" id="did-0002-202">--</td>
<td class="clid" id="clid-0002-202">--</td>
<td class="status" id="status-0002-202">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0002-202">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0002 / Mohit Team</td>
<td class="name" id="name-0002-201">Ashutosh kr Maurya </td>
<td class="desc">201</td>
<td class="duration" id="duration-0002-201">--</td>
<td class="did" id="did-0002-201">--</td>
<td class="clid" id="clid-0002-201">--</td>
<td class="status" id="status-0002-201">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0002-201">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0002 / Mohit Team</td>
<td class="name" id="name-0002-235">MiddleEast Calling User6 </td>
<td class="desc">235</td>
<td class="duration" id="duration-0002-235">--</td>
<td class="did" id="did-0002-235">--</td>
<td class="clid" id="clid-0002-235">--</td>
<td class="status" id="status-0002-235">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0002-235">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Vikram Team</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0003 / Vikram Team</td>
<td class="name" id="name-0003-306">Yogesh Nagar </td>
<td class="desc">306</td>
<td class="duration" id="duration-0003-306">--</td>
<td class="did" id="did-0003-306">--</td>
<td class="clid" id="clid-0003-306">--</td>
<td class="status" id="status-0003-306">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0003-306">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0003 / Vikram Team</td>
<td class="name" id="name-0003-301">Honey Jaggi </td>
<td class="desc">301</td>
<td class="duration" id="duration-0003-301">--</td>
<td class="did" id="did-0003-301">--</td>
<td class="clid" id="clid-0003-301">--</td>
<td class="status" id="status-0003-301">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0003-301">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0003 / Vikram Team</td>
<td class="name" id="name-0003-302">Kunj Malhotra </td>
<td class="desc">302</td>
<td class="duration" id="duration-0003-302">--</td>
<td class="did" id="did-0003-302">--</td>
<td class="clid" id="clid-0003-302">--</td>
<td class="status" id="status-0003-302">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0003-302">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0003 / Vikram Team</td>
<td class="name" id="name-0003-303">Rateesh Srivastava </td>
<td class="desc">303</td>
<td class="duration" id="duration-0003-303">--</td>
<td class="did" id="did-0003-303">--</td>
<td class="clid" id="clid-0003-303">--</td>
<td class="status" id="status-0003-303">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0003-303">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0003 / Vikram Team</td>
<td class="name" id="name-0003-304">Manish </td>
<td class="desc">304</td>
<td class="duration" id="duration-0003-304">--</td>
<td class="did" id="did-0003-304">--</td>
<td class="clid" id="clid-0003-304">--</td>
<td class="status" id="status-0003-304">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0003-304">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0003 / Vikram Team</td>
<td class="name" id="name-0003-305">Chinnmay </td>
<td class="desc">305</td>
<td class="duration" id="duration-0003-305">--</td>
<td class="did" id="did-0003-305">--</td>
<td class="clid" id="clid-0003-305">--</td>
<td class="status" id="status-0003-305">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0003-305">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0003 / Vikram Team</td>
<td class="name" id="name-0003-307">ManishUSA </td>
<td class="desc">307</td>
<td class="duration" id="duration-0003-307">--</td>
<td class="did" id="did-0003-307">--</td>
<td class="clid" id="clid-0003-307">--</td>
<td class="status" id="status-0003-307">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0003-307">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0003 / Vikram Team</td>
<td class="name" id="name-0003-308">HoneyUSA </td>
<td class="desc">308</td>
<td class="duration" id="duration-0003-308">--</td>
<td class="did" id="did-0003-308">--</td>
<td class="clid" id="clid-0003-308">--</td>
<td class="status" id="status-0003-308">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0003-308">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0003 / Vikram Team</td>
<td class="name" id="name-0003-310">ChimamayaUSA </td>
<td class="desc">310</td>
<td class="duration" id="duration-0003-310">--</td>
<td class="did" id="did-0003-310">--</td>
<td class="clid" id="clid-0003-310">--</td>
<td class="status" id="status-0003-310">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0003-310">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0003 / Vikram Team</td>
<td class="name" id="name-0003-309">SudhanshuUSA </td>
<td class="desc">309</td>
<td class="duration" id="duration-0003-309">--</td>
<td class="did" id="did-0003-309">--</td>
<td class="clid" id="clid-0003-309">--</td>
<td class="status" id="status-0003-309">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0003-309">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0003 / Vikram Team</td>
<td class="name" id="name-0003-300">Vikram TL </td>
<td class="desc">300</td>
<td class="duration" id="duration-0003-300">--</td>
<td class="did" id="did-0003-300">--</td>
<td class="clid" id="clid-0003-300">--</td>
<td class="status" id="status-0003-300">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0003-300">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0003 / Vikram Team</td>
<td class="name" id="name-0003-311">EmptyUSA </td>
<td class="desc">311</td>
<td class="duration" id="duration-0003-311">--</td>
<td class="did" id="did-0003-311">--</td>
<td class="clid" id="clid-0003-311">--</td>
<td class="status" id="status-0003-311">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0003-311">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Neha Team</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0004 / Neha Team</td>
<td class="name" id="name-0004-400">Neha </td>
<td class="desc">400</td>
<td class="duration" id="duration-0004-400">--</td>
<td class="did" id="did-0004-400">--</td>
<td class="clid" id="clid-0004-400">--</td>
<td class="status" id="status-0004-400">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0004-400">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0004 / Neha Team</td>
<td class="name" id="name-0004-447">Nitin Anand </td>
<td class="desc">447</td>
<td class="duration" id="duration-0004-447">--</td>
<td class="did" id="did-0004-447">--</td>
<td class="clid" id="clid-0004-447">--</td>
<td class="status" id="status-0004-447">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0004-447">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0004 / Neha Team</td>
<td class="name" id="name-0004-446">Amit Kumar </td>
<td class="desc">446</td>
<td class="duration" id="duration-0004-446">--</td>
<td class="did" id="did-0004-446">--</td>
<td class="clid" id="clid-0004-446">--</td>
<td class="status" id="status-0004-446">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0004-446">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0004 / Neha Team</td>
<td class="name" id="name-0004-445">Divya </td>
<td class="desc">445</td>
<td class="duration" id="duration-0004-445">--</td>
<td class="did" id="did-0004-445">--</td>
<td class="clid" id="clid-0004-445">--</td>
<td class="status" id="status-0004-445">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0004-445">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0004 / Neha Team</td>
<td class="name" id="name-0004-444">Sharda </td>
<td class="desc">444</td>
<td class="duration" id="duration-0004-444">--</td>
<td class="did" id="did-0004-444">--</td>
<td class="clid" id="clid-0004-444">--</td>
<td class="status" id="status-0004-444">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0004-444">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0004 / Neha Team</td>
<td class="name" id="name-0004-443">Pooja baghel </td>
<td class="desc">443</td>
<td class="duration" id="duration-0004-443">--</td>
<td class="did" id="did-0004-443">--</td>
<td class="clid" id="clid-0004-443">--</td>
<td class="status" id="status-0004-443">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0004-443">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0004 / Neha Team</td>
<td class="name" id="name-0004-442">Nupur Pandey </td>
<td class="desc">442</td>
<td class="duration" id="duration-0004-442">--</td>
<td class="did" id="did-0004-442">--</td>
<td class="clid" id="clid-0004-442">--</td>
<td class="status" id="status-0004-442">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0004-442">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0004 / Neha Team</td>
<td class="name" id="name-0004-441">Empty </td>
<td class="desc">441</td>
<td class="duration" id="duration-0004-441">--</td>
<td class="did" id="did-0004-441">--</td>
<td class="clid" id="clid-0004-441">--</td>
<td class="status" id="status-0004-441">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0004-441">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0004 / Neha Team</td>
<td class="name" id="name-0004-409">Sarfaraz </td>
<td class="desc">409</td>
<td class="duration" id="duration-0004-409">--</td>
<td class="did" id="did-0004-409">--</td>
<td class="clid" id="clid-0004-409">--</td>
<td class="status" id="status-0004-409">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0004-409">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0004 / Neha Team</td>
<td class="name" id="name-0004-408">Nishi Paliwal </td>
<td class="desc">408</td>
<td class="duration" id="duration-0004-408">--</td>
<td class="did" id="did-0004-408">--</td>
<td class="clid" id="clid-0004-408">--</td>
<td class="status" id="status-0004-408">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0004-408">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0004 / Neha Team</td>
<td class="name" id="name-0004-407">Deepak </td>
<td class="desc">407</td>
<td class="duration" id="duration-0004-407">--</td>
<td class="did" id="did-0004-407">--</td>
<td class="clid" id="clid-0004-407">--</td>
<td class="status" id="status-0004-407">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0004-407">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0004 / Neha Team</td>
<td class="name" id="name-0004-406">Saurabh Kumar </td>
<td class="desc">406</td>
<td class="duration" id="duration-0004-406">--</td>
<td class="did" id="did-0004-406">--</td>
<td class="clid" id="clid-0004-406">--</td>
<td class="status" id="status-0004-406">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0004-406">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0004 / Neha Team</td>
<td class="name" id="name-0004-405">Prachi </td>
<td class="desc">405</td>
<td class="duration" id="duration-0004-405">--</td>
<td class="did" id="did-0004-405">--</td>
<td class="clid" id="clid-0004-405">--</td>
<td class="status" id="status-0004-405">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0004-405">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0004 / Neha Team</td>
<td class="name" id="name-0004-404">Sandeep sharma </td>
<td class="desc">404</td>
<td class="duration" id="duration-0004-404">--</td>
<td class="did" id="did-0004-404">--</td>
<td class="clid" id="clid-0004-404">--</td>
<td class="status" id="status-0004-404">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0004-404">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0004 / Neha Team</td>
<td class="name" id="name-0004-403">Shabaaz Pathan </td>
<td class="desc">403</td>
<td class="duration" id="duration-0004-403">--</td>
<td class="did" id="did-0004-403">--</td>
<td class="clid" id="clid-0004-403">--</td>
<td class="status" id="status-0004-403">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0004-403">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0004 / Neha Team</td>
<td class="name" id="name-0004-402">Uddeshya Pratap Singh </td>
<td class="desc">402</td>
<td class="duration" id="duration-0004-402">--</td>
<td class="did" id="did-0004-402">--</td>
<td class="clid" id="clid-0004-402">--</td>
<td class="status" id="status-0004-402">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0004-402">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0004 / Neha Team</td>
<td class="name" id="name-0004-401">Vishal Pandey </td>
<td class="desc">401</td>
<td class="duration" id="duration-0004-401">--</td>
<td class="did" id="did-0004-401">--</td>
<td class="clid" id="clid-0004-401">--</td>
<td class="status" id="status-0004-401">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0004-401">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0004 / Neha Team</td>
<td class="name" id="name-0004-448">Hardhik soni </td>
<td class="desc">448</td>
<td class="duration" id="duration-0004-448">--</td>
<td class="did" id="did-0004-448">--</td>
<td class="clid" id="clid-0004-448">--</td>
<td class="status" id="status-0004-448">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0004-448">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Pooja Team</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0005 / Pooja Team</td>
<td class="name" id="name-0005-500">Pooja  </td>
<td class="desc">500</td>
<td class="duration" id="duration-0005-500">--</td>
<td class="did" id="did-0005-500">--</td>
<td class="clid" id="clid-0005-500">--</td>
<td class="status" id="status-0005-500">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0005-500">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0005 / Pooja Team</td>
<td class="name" id="name-0005-508">Saurabh </td>
<td class="desc">508</td>
<td class="duration" id="duration-0005-508">--</td>
<td class="did" id="did-0005-508">--</td>
<td class="clid" id="clid-0005-508">--</td>
<td class="status" id="status-0005-508">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0005-508">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0005 / Pooja Team</td>
<td class="name" id="name-0005-507">ronnie </td>
<td class="desc">507</td>
<td class="duration" id="duration-0005-507">--</td>
<td class="did" id="did-0005-507">--</td>
<td class="clid" id="clid-0005-507">--</td>
<td class="status" id="status-0005-507">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0005-507">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0005 / Pooja Team</td>
<td class="name" id="name-0005-506"> Hardik soni  </td>
<td class="desc">506</td>
<td class="duration" id="duration-0005-506">--</td>
<td class="did" id="did-0005-506">--</td>
<td class="clid" id="clid-0005-506">--</td>
<td class="status" id="status-0005-506">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0005-506">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0005 / Pooja Team</td>
<td class="name" id="name-0005-505">Ankur Jaiswal </td>
<td class="desc">505</td>
<td class="duration" id="duration-0005-505">--</td>
<td class="did" id="did-0005-505">--</td>
<td class="clid" id="clid-0005-505">--</td>
<td class="status" id="status-0005-505">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0005-505">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0005 / Pooja Team</td>
<td class="name" id="name-0005-504">Dilpal </td>
<td class="desc">504</td>
<td class="duration" id="duration-0005-504">--</td>
<td class="did" id="did-0005-504">--</td>
<td class="clid" id="clid-0005-504">--</td>
<td class="status" id="status-0005-504">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0005-504">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0005 / Pooja Team</td>
<td class="name" id="name-0005-503">Rishav Raj </td>
<td class="desc">503</td>
<td class="duration" id="duration-0005-503">--</td>
<td class="did" id="did-0005-503">--</td>
<td class="clid" id="clid-0005-503">--</td>
<td class="status" id="status-0005-503">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0005-503">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0005 / Pooja Team</td>
<td class="name" id="name-0005-502">Sarfaraz </td>
<td class="desc">502</td>
<td class="duration" id="duration-0005-502">--</td>
<td class="did" id="did-0005-502">--</td>
<td class="clid" id="clid-0005-502">--</td>
<td class="status" id="status-0005-502">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0005-502">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0005 / Pooja Team</td>
<td class="name" id="name-0005-501">Mrinal </td>
<td class="desc">501</td>
<td class="duration" id="duration-0005-501">--</td>
<td class="did" id="did-0005-501">--</td>
<td class="clid" id="clid-0005-501">--</td>
<td class="status" id="status-0005-501">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0005-501">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0005 / Pooja Team</td>
<td class="name" id="name-0005-509">Rahul Malhotra </td>
<td class="desc">509</td>
<td class="duration" id="duration-0005-509">--</td>
<td class="did" id="did-0005-509">--</td>
<td class="clid" id="clid-0005-509">--</td>
<td class="status" id="status-0005-509">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0005-509">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Sandeep Team</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-656">Twinkle kumari </td>
<td class="desc">656</td>
<td class="duration" id="duration-0006-656">--</td>
<td class="did" id="did-0006-656">--</td>
<td class="clid" id="clid-0006-656">--</td>
<td class="status" id="status-0006-656">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-656">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-641">Shubhra </td>
<td class="desc">641</td>
<td class="duration" id="duration-0006-641">--</td>
<td class="did" id="did-0006-641">--</td>
<td class="clid" id="clid-0006-641">--</td>
<td class="status" id="status-0006-641">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-641">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-640">Lalita </td>
<td class="desc">640</td>
<td class="duration" id="duration-0006-640">--</td>
<td class="did" id="did-0006-640">--</td>
<td class="clid" id="clid-0006-640">--</td>
<td class="status" id="status-0006-640">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-640">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-639">Shubra </td>
<td class="desc">639</td>
<td class="duration" id="duration-0006-639">--</td>
<td class="did" id="did-0006-639">--</td>
<td class="clid" id="clid-0006-639">--</td>
<td class="status" id="status-0006-639">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-639">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-638">Akash </td>
<td class="desc">638</td>
<td class="duration" id="duration-0006-638">--</td>
<td class="did" id="did-0006-638">--</td>
<td class="clid" id="clid-0006-638">--</td>
<td class="status" id="status-0006-638">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-638">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-637">Nitesh </td>
<td class="desc">637</td>
<td class="duration" id="duration-0006-637">--</td>
<td class="did" id="did-0006-637">--</td>
<td class="clid" id="clid-0006-637">--</td>
<td class="status" id="status-0006-637">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-637">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-636">Chesta </td>
<td class="desc">636</td>
<td class="duration" id="duration-0006-636">--</td>
<td class="did" id="did-0006-636">--</td>
<td class="clid" id="clid-0006-636">--</td>
<td class="status" id="status-0006-636">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-636">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-635">Tariq </td>
<td class="desc">635</td>
<td class="duration" id="duration-0006-635">--</td>
<td class="did" id="did-0006-635">--</td>
<td class="clid" id="clid-0006-635">--</td>
<td class="status" id="status-0006-635">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-635">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-634">Shivani  </td>
<td class="desc">634</td>
<td class="duration" id="duration-0006-634">--</td>
<td class="did" id="did-0006-634">--</td>
<td class="clid" id="clid-0006-634">--</td>
<td class="status" id="status-0006-634">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-634">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-633">Aditya </td>
<td class="desc">633</td>
<td class="duration" id="duration-0006-633">--</td>
<td class="did" id="did-0006-633">--</td>
<td class="clid" id="clid-0006-633">--</td>
<td class="status" id="status-0006-633">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-633">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-632">Vikash </td>
<td class="desc">632</td>
<td class="duration" id="duration-0006-632">--</td>
<td class="did" id="did-0006-632">--</td>
<td class="clid" id="clid-0006-632">--</td>
<td class="status" id="status-0006-632">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-632">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-631">Anik </td>
<td class="desc">631</td>
<td class="duration" id="duration-0006-631">--</td>
<td class="did" id="did-0006-631">--</td>
<td class="clid" id="clid-0006-631">--</td>
<td class="status" id="status-0006-631">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-631">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-642">Numan </td>
<td class="desc">642</td>
<td class="duration" id="duration-0006-642">--</td>
<td class="did" id="did-0006-642">--</td>
<td class="clid" id="clid-0006-642">--</td>
<td class="status" id="status-0006-642">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-642">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-643">DIVYA </td>
<td class="desc">643</td>
<td class="duration" id="duration-0006-643">--</td>
<td class="did" id="did-0006-643">--</td>
<td class="clid" id="clid-0006-643">--</td>
<td class="status" id="status-0006-643">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-643">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-644">DIVYA </td>
<td class="desc">644</td>
<td class="duration" id="duration-0006-644">--</td>
<td class="did" id="did-0006-644">--</td>
<td class="clid" id="clid-0006-644">--</td>
<td class="status" id="status-0006-644">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-644">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-655">Shubham Sharma   </td>
<td class="desc">655</td>
<td class="duration" id="duration-0006-655">--</td>
<td class="did" id="did-0006-655">--</td>
<td class="clid" id="clid-0006-655">--</td>
<td class="status" id="status-0006-655">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-655">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-654">Pulkit Mehta </td>
<td class="desc">654</td>
<td class="duration" id="duration-0006-654">--</td>
<td class="did" id="did-0006-654">--</td>
<td class="clid" id="clid-0006-654">--</td>
<td class="status" id="status-0006-654">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-654">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-653">Sonia Sharma </td>
<td class="desc">653</td>
<td class="duration" id="duration-0006-653">--</td>
<td class="did" id="did-0006-653">--</td>
<td class="clid" id="clid-0006-653">--</td>
<td class="status" id="status-0006-653">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-653">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-652">Rishika </td>
<td class="desc">652</td>
<td class="duration" id="duration-0006-652">--</td>
<td class="did" id="did-0006-652">--</td>
<td class="clid" id="clid-0006-652">--</td>
<td class="status" id="status-0006-652">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-652">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-651">Harinder Malhotra </td>
<td class="desc">651</td>
<td class="duration" id="duration-0006-651">--</td>
<td class="did" id="did-0006-651">--</td>
<td class="clid" id="clid-0006-651">--</td>
<td class="status" id="status-0006-651">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-651">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-650">Janvi Giri </td>
<td class="desc">650</td>
<td class="duration" id="duration-0006-650">--</td>
<td class="did" id="did-0006-650">--</td>
<td class="clid" id="clid-0006-650">--</td>
<td class="status" id="status-0006-650">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-650">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-649">Sapna Singh </td>
<td class="desc">649</td>
<td class="duration" id="duration-0006-649">--</td>
<td class="did" id="did-0006-649">--</td>
<td class="clid" id="clid-0006-649">--</td>
<td class="status" id="status-0006-649">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-649">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-648">AMIT </td>
<td class="desc">648</td>
<td class="duration" id="duration-0006-648">--</td>
<td class="did" id="did-0006-648">--</td>
<td class="clid" id="clid-0006-648">--</td>
<td class="status" id="status-0006-648">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-648">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-647">Astitv </td>
<td class="desc">647</td>
<td class="duration" id="duration-0006-647">--</td>
<td class="did" id="did-0006-647">--</td>
<td class="clid" id="clid-0006-647">--</td>
<td class="status" id="status-0006-647">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-647">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-646">DEEPSHIKHA </td>
<td class="desc">646</td>
<td class="duration" id="duration-0006-646">--</td>
<td class="did" id="did-0006-646">--</td>
<td class="clid" id="clid-0006-646">--</td>
<td class="status" id="status-0006-646">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-646">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-645">Anuvind </td>
<td class="desc">645</td>
<td class="duration" id="duration-0006-645">--</td>
<td class="did" id="did-0006-645">--</td>
<td class="clid" id="clid-0006-645">--</td>
<td class="status" id="status-0006-645">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-645">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-630">Shivangi </td>
<td class="desc">630</td>
<td class="duration" id="duration-0006-630">--</td>
<td class="did" id="did-0006-630">--</td>
<td class="clid" id="clid-0006-630">--</td>
<td class="status" id="status-0006-630">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-630">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-629">Dipankar </td>
<td class="desc">629</td>
<td class="duration" id="duration-0006-629">--</td>
<td class="did" id="did-0006-629">--</td>
<td class="clid" id="clid-0006-629">--</td>
<td class="status" id="status-0006-629">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-629">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-614">vaishali </td>
<td class="desc">614</td>
<td class="duration" id="duration-0006-614">--</td>
<td class="did" id="did-0006-614">--</td>
<td class="clid" id="clid-0006-614">--</td>
<td class="status" id="status-0006-614">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-614">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-613">Arun Chawla </td>
<td class="desc">613</td>
<td class="duration" id="duration-0006-613">--</td>
<td class="did" id="did-0006-613">--</td>
<td class="clid" id="clid-0006-613">--</td>
<td class="status" id="status-0006-613">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-613">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-612">Anubhav  </td>
<td class="desc">612</td>
<td class="duration" id="duration-0006-612">--</td>
<td class="did" id="did-0006-612">--</td>
<td class="clid" id="clid-0006-612">--</td>
<td class="status" id="status-0006-612">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-612">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-610">Sahil </td>
<td class="desc">610</td>
<td class="duration" id="duration-0006-610">--</td>
<td class="did" id="did-0006-610">--</td>
<td class="clid" id="clid-0006-610">--</td>
<td class="status" id="status-0006-610">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-610">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-609">Sandeep Yadav </td>
<td class="desc">609</td>
<td class="duration" id="duration-0006-609">--</td>
<td class="did" id="did-0006-609">--</td>
<td class="clid" id="clid-0006-609">--</td>
<td class="status" id="status-0006-609">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-609">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-607">Shamim Sammani </td>
<td class="desc">607</td>
<td class="duration" id="duration-0006-607">--</td>
<td class="did" id="did-0006-607">--</td>
<td class="clid" id="clid-0006-607">--</td>
<td class="status" id="status-0006-607">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-607">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-605">Rahul Sharma </td>
<td class="desc">605</td>
<td class="duration" id="duration-0006-605">--</td>
<td class="did" id="did-0006-605">--</td>
<td class="clid" id="clid-0006-605">--</td>
<td class="status" id="status-0006-605">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-605">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-604">Shilpa Kamra </td>
<td class="desc">604</td>
<td class="duration" id="duration-0006-604">--</td>
<td class="did" id="did-0006-604">--</td>
<td class="clid" id="clid-0006-604">--</td>
<td class="status" id="status-0006-604">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-604">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-602">Shilpa </td>
<td class="desc">602</td>
<td class="duration" id="duration-0006-602">--</td>
<td class="did" id="did-0006-602">--</td>
<td class="clid" id="clid-0006-602">--</td>
<td class="status" id="status-0006-602">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-602">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-601">VISHAL </td>
<td class="desc">601</td>
<td class="duration" id="duration-0006-601">--</td>
<td class="did" id="did-0006-601">--</td>
<td class="clid" id="clid-0006-601">--</td>
<td class="status" id="status-0006-601">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-601">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-600">Lakshita </td>
<td class="desc">600</td>
<td class="duration" id="duration-0006-600">--</td>
<td class="did" id="did-0006-600">--</td>
<td class="clid" id="clid-0006-600">--</td>
<td class="status" id="status-0006-600">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-600">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-615">Simran </td>
<td class="desc">615</td>
<td class="duration" id="duration-0006-615">--</td>
<td class="did" id="did-0006-615">--</td>
<td class="clid" id="clid-0006-615">--</td>
<td class="status" id="status-0006-615">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-615">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-616">Beena </td>
<td class="desc">616</td>
<td class="duration" id="duration-0006-616">--</td>
<td class="did" id="did-0006-616">--</td>
<td class="clid" id="clid-0006-616">--</td>
<td class="status" id="status-0006-616">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-616">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-628">Luisa Sachdeva </td>
<td class="desc">628</td>
<td class="duration" id="duration-0006-628">--</td>
<td class="did" id="did-0006-628">--</td>
<td class="clid" id="clid-0006-628">--</td>
<td class="status" id="status-0006-628">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-628">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-627">Rateesh </td>
<td class="desc">627</td>
<td class="duration" id="duration-0006-627">--</td>
<td class="did" id="did-0006-627">--</td>
<td class="clid" id="clid-0006-627">--</td>
<td class="status" id="status-0006-627">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-627">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-626">Honey </td>
<td class="desc">626</td>
<td class="duration" id="duration-0006-626">--</td>
<td class="did" id="did-0006-626">--</td>
<td class="clid" id="clid-0006-626">--</td>
<td class="status" id="status-0006-626">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-626">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-625">yogesh </td>
<td class="desc">625</td>
<td class="duration" id="duration-0006-625">--</td>
<td class="did" id="did-0006-625">--</td>
<td class="clid" id="clid-0006-625">--</td>
<td class="status" id="status-0006-625">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-625">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-624">Jatin </td>
<td class="desc">624</td>
<td class="duration" id="duration-0006-624">--</td>
<td class="did" id="did-0006-624">--</td>
<td class="clid" id="clid-0006-624">--</td>
<td class="status" id="status-0006-624">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-624">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-623">Kumar Kaushal </td>
<td class="desc">623</td>
<td class="duration" id="duration-0006-623">--</td>
<td class="did" id="did-0006-623">--</td>
<td class="clid" id="clid-0006-623">--</td>
<td class="status" id="status-0006-623">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-623">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-622">Suhail </td>
<td class="desc">622</td>
<td class="duration" id="duration-0006-622">--</td>
<td class="did" id="did-0006-622">--</td>
<td class="clid" id="clid-0006-622">--</td>
<td class="status" id="status-0006-622">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-622">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-621">Ayush </td>
<td class="desc">621</td>
<td class="duration" id="duration-0006-621">--</td>
<td class="did" id="did-0006-621">--</td>
<td class="clid" id="clid-0006-621">--</td>
<td class="status" id="status-0006-621">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-621">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-620">Surbhi </td>
<td class="desc">620</td>
<td class="duration" id="duration-0006-620">--</td>
<td class="did" id="did-0006-620">--</td>
<td class="clid" id="clid-0006-620">--</td>
<td class="status" id="status-0006-620">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-620">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-619">Rumky </td>
<td class="desc">619</td>
<td class="duration" id="duration-0006-619">--</td>
<td class="did" id="did-0006-619">--</td>
<td class="clid" id="clid-0006-619">--</td>
<td class="status" id="status-0006-619">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-619">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-618">Kritika  </td>
<td class="desc">618</td>
<td class="duration" id="duration-0006-618">--</td>
<td class="did" id="did-0006-618">--</td>
<td class="clid" id="clid-0006-618">--</td>
<td class="status" id="status-0006-618">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-618">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-617">Shubham </td>
<td class="desc">617</td>
<td class="duration" id="duration-0006-617">--</td>
<td class="did" id="did-0006-617">--</td>
<td class="clid" id="clid-0006-617">--</td>
<td class="status" id="status-0006-617">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0006-617">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-657">Empty </td>
<td class="desc">657</td>
<td class="duration" id="duration-0006-657">--</td>
<td class="did" id="did-0006-657">--</td>
<td class="clid" id="clid-0006-657">--</td>
<td class="status" id="status-0006-657">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0006-657">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-658">Empty </td>
<td class="desc">658</td>
<td class="duration" id="duration-0006-658">--</td>
<td class="did" id="did-0006-658">--</td>
<td class="clid" id="clid-0006-658">--</td>
<td class="status" id="status-0006-658">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0006-658">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0006 / Sandeep Team</td>
<td class="name" id="name-0006-659">Empty </td>
<td class="desc">659</td>
<td class="duration" id="duration-0006-659">--</td>
<td class="did" id="did-0006-659">--</td>
<td class="clid" id="clid-0006-659">--</td>
<td class="status" id="status-0006-659">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0006-659">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Kanishka and SaurabhTeam</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0007 / Kanishka and SaurabhTeam</td>
<td class="name" id="name-0007-700">KANISHKA TL </td>
<td class="desc">700</td>
<td class="duration" id="duration-0007-700">--</td>
<td class="did" id="did-0007-700">--</td>
<td class="clid" id="clid-0007-700">--</td>
<td class="status" id="status-0007-700">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0007-700">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0007 / Kanishka and SaurabhTeam</td>
<td class="name" id="name-0007-718">Gagandeep </td>
<td class="desc">718</td>
<td class="duration" id="duration-0007-718">--</td>
<td class="did" id="did-0007-718">--</td>
<td class="clid" id="clid-0007-718">--</td>
<td class="status" id="status-0007-718">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0007-718">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0007 / Kanishka and SaurabhTeam</td>
<td class="name" id="name-0007-717">Ambuj </td>
<td class="desc">717</td>
<td class="duration" id="duration-0007-717">--</td>
<td class="did" id="did-0007-717">--</td>
<td class="clid" id="clid-0007-717">--</td>
<td class="status" id="status-0007-717">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0007-717">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0007 / Kanishka and SaurabhTeam</td>
<td class="name" id="name-0007-716">Vishal </td>
<td class="desc">716</td>
<td class="duration" id="duration-0007-716">--</td>
<td class="did" id="did-0007-716">--</td>
<td class="clid" id="clid-0007-716">--</td>
<td class="status" id="status-0007-716">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0007-716">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0007 / Kanishka and SaurabhTeam</td>
<td class="name" id="name-0007-715">Chandan </td>
<td class="desc">715</td>
<td class="duration" id="duration-0007-715">--</td>
<td class="did" id="did-0007-715">--</td>
<td class="clid" id="clid-0007-715">--</td>
<td class="status" id="status-0007-715">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0007-715">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0007 / Kanishka and SaurabhTeam</td>
<td class="name" id="name-0007-714">Mohit </td>
<td class="desc">714</td>
<td class="duration" id="duration-0007-714">--</td>
<td class="did" id="did-0007-714">--</td>
<td class="clid" id="clid-0007-714">--</td>
<td class="status" id="status-0007-714">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0007-714">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0007 / Kanishka and SaurabhTeam</td>
<td class="name" id="name-0007-713">Kshitij </td>
<td class="desc">713</td>
<td class="duration" id="duration-0007-713">--</td>
<td class="did" id="did-0007-713">--</td>
<td class="clid" id="clid-0007-713">--</td>
<td class="status" id="status-0007-713">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0007-713">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0007 / Kanishka and SaurabhTeam</td>
<td class="name" id="name-0007-712">Ashu </td>
<td class="desc">712</td>
<td class="duration" id="duration-0007-712">--</td>
<td class="did" id="did-0007-712">--</td>
<td class="clid" id="clid-0007-712">--</td>
<td class="status" id="status-0007-712">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0007-712">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0007 / Kanishka and SaurabhTeam</td>
<td class="name" id="name-0007-711">Deepak </td>
<td class="desc">711</td>
<td class="duration" id="duration-0007-711">--</td>
<td class="did" id="did-0007-711">--</td>
<td class="clid" id="clid-0007-711">--</td>
<td class="status" id="status-0007-711">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0007-711">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0007 / Kanishka and SaurabhTeam</td>
<td class="name" id="name-0007-710">Abhay </td>
<td class="desc">710</td>
<td class="duration" id="duration-0007-710">--</td>
<td class="did" id="did-0007-710">--</td>
<td class="clid" id="clid-0007-710">--</td>
<td class="status" id="status-0007-710">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0007-710">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0007 / Kanishka and SaurabhTeam</td>
<td class="name" id="name-0007-709">Saurabhold </td>
<td class="desc">709</td>
<td class="duration" id="duration-0007-709">--</td>
<td class="did" id="did-0007-709">--</td>
<td class="clid" id="clid-0007-709">--</td>
<td class="status" id="status-0007-709">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0007-709">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0007 / Kanishka and SaurabhTeam</td>
<td class="name" id="name-0007-708">Saurabh </td>
<td class="desc">708</td>
<td class="duration" id="duration-0007-708">--</td>
<td class="did" id="did-0007-708">--</td>
<td class="clid" id="clid-0007-708">--</td>
<td class="status" id="status-0007-708">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0007-708">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0007 / Kanishka and SaurabhTeam</td>
<td class="name" id="name-0007-707">Kushal </td>
<td class="desc">707</td>
<td class="duration" id="duration-0007-707">--</td>
<td class="did" id="did-0007-707">--</td>
<td class="clid" id="clid-0007-707">--</td>
<td class="status" id="status-0007-707">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0007-707">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0007 / Kanishka and SaurabhTeam</td>
<td class="name" id="name-0007-705">Abhay Sharma </td>
<td class="desc">705</td>
<td class="duration" id="duration-0007-705">--</td>
<td class="did" id="did-0007-705">--</td>
<td class="clid" id="clid-0007-705">--</td>
<td class="status" id="status-0007-705">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0007-705">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0007 / Kanishka and SaurabhTeam</td>
<td class="name" id="name-0007-703">Sanjay </td>
<td class="desc">703</td>
<td class="duration" id="duration-0007-703">--</td>
<td class="did" id="did-0007-703">--</td>
<td class="clid" id="clid-0007-703">--</td>
<td class="status" id="status-0007-703">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0007-703">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0007 / Kanishka and SaurabhTeam</td>
<td class="name" id="name-0007-719">Ubaid </td>
<td class="desc">719</td>
<td class="duration" id="duration-0007-719">--</td>
<td class="did" id="did-0007-719">--</td>
<td class="clid" id="clid-0007-719">--</td>
<td class="status" id="status-0007-719">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0007-719">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Rohit Team</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-800">ROHIT KAUL  </td>
<td class="desc">800</td>
<td class="duration" id="duration-0008-800">--</td>
<td class="did" id="did-0008-800">--</td>
<td class="clid" id="clid-0008-800">--</td>
<td class="status" id="status-0008-800">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-800">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-815">Neha Chauhan </td>
<td class="desc">815</td>
<td class="duration" id="duration-0008-815">--</td>
<td class="did" id="did-0008-815">--</td>
<td class="clid" id="clid-0008-815">--</td>
<td class="status" id="status-0008-815">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-815">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-816">Shishir UK </td>
<td class="desc">816</td>
<td class="duration" id="duration-0008-816">--</td>
<td class="did" id="did-0008-816">--</td>
<td class="clid" id="clid-0008-816">--</td>
<td class="status" id="status-0008-816">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-816">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-817">Empty </td>
<td class="desc">817</td>
<td class="duration" id="duration-0008-817">--</td>
<td class="did" id="did-0008-817">--</td>
<td class="clid" id="clid-0008-817">--</td>
<td class="status" id="status-0008-817">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-817">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-818">Empty </td>
<td class="desc">818</td>
<td class="duration" id="duration-0008-818">--</td>
<td class="did" id="did-0008-818">--</td>
<td class="clid" id="clid-0008-818">--</td>
<td class="status" id="status-0008-818">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-818">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-888">Abhishek Anand UK </td>
<td class="desc">888</td>
<td class="duration" id="duration-0008-888">--</td>
<td class="did" id="did-0008-888">--</td>
<td class="clid" id="clid-0008-888">--</td>
<td class="status" id="status-0008-888">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-888">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-881">Keerti Singh UK </td>
<td class="desc">881</td>
<td class="duration" id="duration-0008-881">--</td>
<td class="did" id="did-0008-881">--</td>
<td class="clid" id="clid-0008-881">--</td>
<td class="status" id="status-0008-881">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-881">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-882">Yash Taneja UK </td>
<td class="desc">882</td>
<td class="duration" id="duration-0008-882">--</td>
<td class="did" id="did-0008-882">--</td>
<td class="clid" id="clid-0008-882">--</td>
<td class="status" id="status-0008-882">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-882">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-883">Ankit Bhatnagar UK </td>
<td class="desc">883</td>
<td class="duration" id="duration-0008-883">--</td>
<td class="did" id="did-0008-883">--</td>
<td class="clid" id="clid-0008-883">--</td>
<td class="status" id="status-0008-883">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-883">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-884">Ashwini Kumar UK </td>
<td class="desc">884</td>
<td class="duration" id="duration-0008-884">--</td>
<td class="did" id="did-0008-884">--</td>
<td class="clid" id="clid-0008-884">--</td>
<td class="status" id="status-0008-884">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-884">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-885">Empty </td>
<td class="desc">885</td>
<td class="duration" id="duration-0008-885">--</td>
<td class="did" id="did-0008-885">--</td>
<td class="clid" id="clid-0008-885">--</td>
<td class="status" id="status-0008-885">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-885">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-814">Prithvi Chaudhary UK </td>
<td class="desc">814</td>
<td class="duration" id="duration-0008-814">--</td>
<td class="did" id="did-0008-814">--</td>
<td class="clid" id="clid-0008-814">--</td>
<td class="status" id="status-0008-814">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-814">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-813">Sweta Chakraborty UK </td>
<td class="desc">813</td>
<td class="duration" id="duration-0008-813">--</td>
<td class="did" id="did-0008-813">--</td>
<td class="clid" id="clid-0008-813">--</td>
<td class="status" id="status-0008-813">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-813">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-805">Tarun Bhushan UK </td>
<td class="desc">805</td>
<td class="duration" id="duration-0008-805">--</td>
<td class="did" id="did-0008-805">--</td>
<td class="clid" id="clid-0008-805">--</td>
<td class="status" id="status-0008-805">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-805">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-804">empty UK </td>
<td class="desc">804</td>
<td class="duration" id="duration-0008-804">--</td>
<td class="did" id="did-0008-804">--</td>
<td class="clid" id="clid-0008-804">--</td>
<td class="status" id="status-0008-804">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-804">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-803">Sujeet Mishra UK </td>
<td class="desc">803</td>
<td class="duration" id="duration-0008-803">--</td>
<td class="did" id="did-0008-803">--</td>
<td class="clid" id="clid-0008-803">--</td>
<td class="status" id="status-0008-803">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-803">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-802">Rajib Biswas UK </td>
<td class="desc">802</td>
<td class="duration" id="duration-0008-802">--</td>
<td class="did" id="did-0008-802">--</td>
<td class="clid" id="clid-0008-802">--</td>
<td class="status" id="status-0008-802">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-802">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-801">Manish Gupta USA </td>
<td class="desc">801</td>
<td class="duration" id="duration-0008-801">--</td>
<td class="did" id="did-0008-801">--</td>
<td class="clid" id="clid-0008-801">--</td>
<td class="status" id="status-0008-801">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-801">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-806">Sujeet Mishra USA </td>
<td class="desc">806</td>
<td class="duration" id="duration-0008-806">--</td>
<td class="did" id="did-0008-806">--</td>
<td class="clid" id="clid-0008-806">--</td>
<td class="status" id="status-0008-806">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-806">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-808">Ashutosh Sharma UK </td>
<td class="desc">808</td>
<td class="duration" id="duration-0008-808">--</td>
<td class="did" id="did-0008-808">--</td>
<td class="clid" id="clid-0008-808">--</td>
<td class="status" id="status-0008-808">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-808">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-809">Sweta USA </td>
<td class="desc">809</td>
<td class="duration" id="duration-0008-809">--</td>
<td class="did" id="did-0008-809">--</td>
<td class="clid" id="clid-0008-809">--</td>
<td class="status" id="status-0008-809">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-809">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-811">Utsav Srivastava UK </td>
<td class="desc">811</td>
<td class="duration" id="duration-0008-811">--</td>
<td class="did" id="did-0008-811">--</td>
<td class="clid" id="clid-0008-811">--</td>
<td class="status" id="status-0008-811">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-811">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-812">Manish Gupta UK </td>
<td class="desc">812</td>
<td class="duration" id="duration-0008-812">--</td>
<td class="did" id="did-0008-812">--</td>
<td class="clid" id="clid-0008-812">--</td>
<td class="status" id="status-0008-812">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0008-812">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-829">Empty </td>
<td class="desc">829</td>
<td class="duration" id="duration-0008-829">--</td>
<td class="did" id="did-0008-829">--</td>
<td class="clid" id="clid-0008-829">--</td>
<td class="status" id="status-0008-829">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0008-829">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-828">Empty </td>
<td class="desc">828</td>
<td class="duration" id="duration-0008-828">--</td>
<td class="did" id="did-0008-828">--</td>
<td class="clid" id="clid-0008-828">--</td>
<td class="status" id="status-0008-828">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0008-828">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-827">Empty </td>
<td class="desc">827</td>
<td class="duration" id="duration-0008-827">--</td>
<td class="did" id="did-0008-827">--</td>
<td class="clid" id="clid-0008-827">--</td>
<td class="status" id="status-0008-827">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0008-827">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-826">Empty </td>
<td class="desc">826</td>
<td class="duration" id="duration-0008-826">--</td>
<td class="did" id="did-0008-826">--</td>
<td class="clid" id="clid-0008-826">--</td>
<td class="status" id="status-0008-826">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0008-826">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-825">Empty </td>
<td class="desc">825</td>
<td class="duration" id="duration-0008-825">--</td>
<td class="did" id="did-0008-825">--</td>
<td class="clid" id="clid-0008-825">--</td>
<td class="status" id="status-0008-825">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0008-825">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-824">Empty </td>
<td class="desc">824</td>
<td class="duration" id="duration-0008-824">--</td>
<td class="did" id="did-0008-824">--</td>
<td class="clid" id="clid-0008-824">--</td>
<td class="status" id="status-0008-824">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0008-824">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-823">Empty </td>
<td class="desc">823</td>
<td class="duration" id="duration-0008-823">--</td>
<td class="did" id="did-0008-823">--</td>
<td class="clid" id="clid-0008-823">--</td>
<td class="status" id="status-0008-823">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0008-823">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-822">Empty </td>
<td class="desc">822</td>
<td class="duration" id="duration-0008-822">--</td>
<td class="did" id="did-0008-822">--</td>
<td class="clid" id="clid-0008-822">--</td>
<td class="status" id="status-0008-822">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0008-822">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-821">Empty </td>
<td class="desc">821</td>
<td class="duration" id="duration-0008-821">--</td>
<td class="did" id="did-0008-821">--</td>
<td class="clid" id="clid-0008-821">--</td>
<td class="status" id="status-0008-821">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0008-821">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-820">Empty </td>
<td class="desc">820</td>
<td class="duration" id="duration-0008-820">--</td>
<td class="did" id="did-0008-820">--</td>
<td class="clid" id="clid-0008-820">--</td>
<td class="status" id="status-0008-820">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0008-820">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0008 / Rohit Team</td>
<td class="name" id="name-0008-819">Empty </td>
<td class="desc">819</td>
<td class="duration" id="duration-0008-819">--</td>
<td class="did" id="did-0008-819">--</td>
<td class="clid" id="clid-0008-819">--</td>
<td class="status" id="status-0008-819">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0008-819">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> IT-QUEUE</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>80001 / IT-QUEUE</td>
<td class="name" id="name-80001-400">Neha </td>
<td class="desc">400</td>
<td class="duration" id="duration-80001-400">--</td>
<td class="did" id="did-80001-400">--</td>
<td class="clid" id="clid-80001-400">--</td>
<td class="status" id="status-80001-400">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="80001-400">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>80001 / IT-QUEUE</td>
<td class="name" id="name-80001-500">Pooja  </td>
<td class="desc">500</td>
<td class="duration" id="duration-80001-500">--</td>
<td class="did" id="did-80001-500">--</td>
<td class="clid" id="clid-80001-500">--</td>
<td class="status" id="status-80001-500">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="80001-500">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>80001 / IT-QUEUE</td>
<td class="name" id="name-80001-609">Sandeep Yadav </td>
<td class="desc">609</td>
<td class="duration" id="duration-80001-609">--</td>
<td class="did" id="did-80001-609">--</td>
<td class="clid" id="clid-80001-609">--</td>
<td class="status" id="status-80001-609">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="80001-609">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Ranveer-Team</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5001 / Ranveer-Team</td>
<td class="name" id="name-5001-5002">Ranveer </td>
<td class="desc">5002</td>
<td class="duration" id="duration-5001-5002">--</td>
<td class="did" id="did-5001-5002">--</td>
<td class="clid" id="clid-5001-5002">--</td>
<td class="status" id="status-5001-5002">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5001-5002">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5001 / Ranveer-Team</td>
<td class="name" id="name-5001-5003">Parichit </td>
<td class="desc">5003</td>
<td class="duration" id="duration-5001-5003">--</td>
<td class="did" id="did-5001-5003">--</td>
<td class="clid" id="clid-5001-5003">--</td>
<td class="status" id="status-5001-5003">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5001-5003">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> HR-Team</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>2001 / HR-Team</td>
<td class="name" id="name-2001-211">Lata </td>
<td class="desc">211</td>
<td class="duration" id="duration-2001-211">--</td>
<td class="did" id="did-2001-211">--</td>
<td class="clid" id="clid-2001-211">--</td>
<td class="status" id="status-2001-211">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="2001-211">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>2001 / HR-Team</td>
<td class="name" id="name-2001-219">Suryamani Singh </td>
<td class="desc">219</td>
<td class="duration" id="duration-2001-219">--</td>
<td class="did" id="did-2001-219">--</td>
<td class="clid" id="clid-2001-219">--</td>
<td class="status" id="status-2001-219">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="2001-219">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>2001 / HR-Team</td>
<td class="name" id="name-2001-218">Ashwini  </td>
<td class="desc">218</td>
<td class="duration" id="duration-2001-218">--</td>
<td class="did" id="did-2001-218">--</td>
<td class="clid" id="clid-2001-218">--</td>
<td class="status" id="status-2001-218">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="2001-218">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>2001 / HR-Team</td>
<td class="name" id="name-2001-217">Akansha </td>
<td class="desc">217</td>
<td class="duration" id="duration-2001-217">--</td>
<td class="did" id="did-2001-217">--</td>
<td class="clid" id="clid-2001-217">--</td>
<td class="status" id="status-2001-217">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="2001-217">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>2001 / HR-Team</td>
<td class="name" id="name-2001-223">Janvi </td>
<td class="desc">223</td>
<td class="duration" id="duration-2001-223">--</td>
<td class="did" id="did-2001-223">--</td>
<td class="clid" id="clid-2001-223">--</td>
<td class="status" id="status-2001-223">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="2001-223">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>2001 / HR-Team</td>
<td class="name" id="name-2001-215">Ruchi </td>
<td class="desc">215</td>
<td class="duration" id="duration-2001-215">--</td>
<td class="did" id="did-2001-215">--</td>
<td class="clid" id="clid-2001-215">--</td>
<td class="status" id="status-2001-215">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="2001-215">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>2001 / HR-Team</td>
<td class="name" id="name-2001-214">Anubhav </td>
<td class="desc">214</td>
<td class="duration" id="duration-2001-214">--</td>
<td class="did" id="did-2001-214">--</td>
<td class="clid" id="clid-2001-214">--</td>
<td class="status" id="status-2001-214">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="2001-214">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>2001 / HR-Team</td>
<td class="name" id="name-2001-213">Apurva </td>
<td class="desc">213</td>
<td class="duration" id="duration-2001-213">--</td>
<td class="did" id="did-2001-213">--</td>
<td class="clid" id="clid-2001-213">--</td>
<td class="status" id="status-2001-213">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="2001-213">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>2001 / HR-Team</td>
<td class="name" id="name-2001-212">Megha_HR </td>
<td class="desc">212</td>
<td class="duration" id="duration-2001-212">--</td>
<td class="did" id="did-2001-212">--</td>
<td class="clid" id="clid-2001-212">--</td>
<td class="status" id="status-2001-212">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="2001-212">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>2001 / HR-Team</td>
<td class="name" id="name-2001-216">Deepanker malik </td>
<td class="desc">216</td>
<td class="duration" id="duration-2001-216">--</td>
<td class="did" id="did-2001-216">--</td>
<td class="clid" id="clid-2001-216">--</td>
<td class="status" id="status-2001-216">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="2001-216">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> PM-Team</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>2002 / PM-Team</td>
<td class="name" id="name-2002-221">PM SIR </td>
<td class="desc">221</td>
<td class="duration" id="duration-2002-221">--</td>
<td class="did" id="did-2002-221">--</td>
<td class="clid" id="clid-2002-221">--</td>
<td class="status" id="status-2002-221">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="2002-221">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>2002 / PM-Team</td>
<td class="name" id="name-2002-222">Empty </td>
<td class="desc">222</td>
<td class="duration" id="duration-2002-222">--</td>
<td class="did" id="did-2002-222">--</td>
<td class="clid" id="clid-2002-222">--</td>
<td class="status" id="status-2002-222">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="2002-222">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Amber(US Team)</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0009 / Amber(US Team)</td>
<td class="name" id="name-0009-900">Mr. Amber </td>
<td class="desc">900</td>
<td class="duration" id="duration-0009-900">--</td>
<td class="did" id="did-0009-900">--</td>
<td class="clid" id="clid-0009-900">--</td>
<td class="status" id="status-0009-900">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0009-900">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0009 / Amber(US Team)</td>
<td class="name" id="name-0009-904">Akshay </td>
<td class="desc">904</td>
<td class="duration" id="duration-0009-904">--</td>
<td class="did" id="did-0009-904">--</td>
<td class="clid" id="clid-0009-904">--</td>
<td class="status" id="status-0009-904">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0009-904">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0009 / Amber(US Team)</td>
<td class="name" id="name-0009-905">Ashraf </td>
<td class="desc">905</td>
<td class="duration" id="duration-0009-905">--</td>
<td class="did" id="did-0009-905">--</td>
<td class="clid" id="clid-0009-905">--</td>
<td class="status" id="status-0009-905">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0009-905">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0009 / Amber(US Team)</td>
<td class="name" id="name-0009-906">Mr. Amber </td>
<td class="desc">906</td>
<td class="duration" id="duration-0009-906">--</td>
<td class="did" id="did-0009-906">--</td>
<td class="clid" id="clid-0009-906">--</td>
<td class="status" id="status-0009-906">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0009-906">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0009 / Amber(US Team)</td>
<td class="name" id="name-0009-907">Manish </td>
<td class="desc">907</td>
<td class="duration" id="duration-0009-907">--</td>
<td class="did" id="did-0009-907">--</td>
<td class="clid" id="clid-0009-907">--</td>
<td class="status" id="status-0009-907">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0009-907">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0009 / Amber(US Team)</td>
<td class="name" id="name-0009-901">empty </td>
<td class="desc">901</td>
<td class="duration" id="duration-0009-901">--</td>
<td class="did" id="did-0009-901">--</td>
<td class="clid" id="clid-0009-901">--</td>
<td class="status" id="status-0009-901">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0009-901">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0009 / Amber(US Team)</td>
<td class="name" id="name-0009-902">Empty </td>
<td class="desc">902</td>
<td class="duration" id="duration-0009-902">--</td>
<td class="did" id="did-0009-902">--</td>
<td class="clid" id="clid-0009-902">--</td>
<td class="status" id="status-0009-902">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0009-902">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0009 / Amber(US Team)</td>
<td class="name" id="name-0009-903">Empty </td>
<td class="desc">903</td>
<td class="duration" id="duration-0009-903">--</td>
<td class="did" id="did-0009-903">--</td>
<td class="clid" id="clid-0009-903">--</td>
<td class="status" id="status-0009-903">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0009-903">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> EDUKASION SUPPORT</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>00011 / EDUKASION SUPPORT</td>
<td class="name" id="name-00011-700">KANISHKA TL </td>
<td class="desc">700</td>
<td class="duration" id="duration-00011-700">--</td>
<td class="did" id="did-00011-700">--</td>
<td class="clid" id="clid-00011-700">--</td>
<td class="status" id="status-00011-700">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="00011-700">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Scrumversity</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5526 / Scrumversity</td>
<td class="name" id="name-5526-700">KANISHKA TL </td>
<td class="desc">700</td>
<td class="duration" id="duration-5526-700">--</td>
<td class="did" id="did-5526-700">--</td>
<td class="clid" id="clid-5526-700">--</td>
<td class="status" id="status-5526-700">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5526-700">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5526 / Scrumversity</td>
<td class="name" id="name-5526-712">Ashu </td>
<td class="desc">712</td>
<td class="duration" id="duration-5526-712">--</td>
<td class="did" id="did-5526-712">--</td>
<td class="clid" id="clid-5526-712">--</td>
<td class="status" id="status-5526-712">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5526-712">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> OutBond Travoment</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>9120 / OutBond Travoment</td>
<td class="name" id="name-9120-004">TravomentUser </td>
<td class="desc">004</td>
<td class="duration" id="duration-9120-004">--</td>
<td class="did" id="did-9120-004">--</td>
<td class="clid" id="clid-9120-004">--</td>
<td class="status" id="status-9120-004">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="9120-004">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Shivam</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>99001 / Shivam</td>
<td class="name" id="name-99001-9901">Shivam </td>
<td class="desc">9901</td>
<td class="duration" id="duration-99001-9901">--</td>
<td class="did" id="did-99001-9901">--</td>
<td class="clid" id="clid-99001-9901">--</td>
<td class="status" id="status-99001-9901">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="99001-9901">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>99001 / Shivam</td>
<td class="name" id="name-99001-9902">Test Agent </td>
<td class="desc">9902</td>
<td class="duration" id="duration-99001-9902">--</td>
<td class="did" id="did-99001-9902">--</td>
<td class="clid" id="clid-99001-9902">--</td>
<td class="status" id="status-99001-9902">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="99001-9902">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Extenal-TFN-Queue</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>00001 / Extenal-TFN-Queue</td>
<td class="name" id="name-00001-999991">CALLTFN </td>
<td class="desc">999991</td>
<td class="duration" id="duration-00001-999991">--</td>
<td class="did" id="did-00001-999991">--</td>
<td class="clid" id="clid-00001-999991">--</td>
<td class="status" id="status-00001-999991">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="00001-999991">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> CareerEra_Vikaram_TL</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5506 / CareerEra_Vikaram_TL</td>
<td class="name" id="name-5506-315">Vikaram Team data science </td>
<td class="desc">315</td>
<td class="duration" id="duration-5506-315">--</td>
<td class="did" id="did-5506-315">--</td>
<td class="clid" id="clid-5506-315">--</td>
<td class="status" id="status-5506-315">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5506-315">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5506 / CareerEra_Vikaram_TL</td>
<td class="name" id="name-5506-316">Vikaram Team data science </td>
<td class="desc">316</td>
<td class="duration" id="duration-5506-316">--</td>
<td class="did" id="did-5506-316">--</td>
<td class="clid" id="clid-5506-316">--</td>
<td class="status" id="status-5506-316">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5506-316">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5506 / CareerEra_Vikaram_TL</td>
<td class="name" id="name-5506-317">Vikaram Team data science </td>
<td class="desc">317</td>
<td class="duration" id="duration-5506-317">--</td>
<td class="did" id="did-5506-317">--</td>
<td class="clid" id="clid-5506-317">--</td>
<td class="status" id="status-5506-317">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5506-317">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5506 / CareerEra_Vikaram_TL</td>
<td class="name" id="name-5506-318">Vikaram Team data science </td>
<td class="desc">318</td>
<td class="duration" id="duration-5506-318">--</td>
<td class="did" id="did-5506-318">--</td>
<td class="clid" id="clid-5506-318">--</td>
<td class="status" id="status-5506-318">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5506-318">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5506 / CareerEra_Vikaram_TL</td>
<td class="name" id="name-5506-319">Vikaram Team data science </td>
<td class="desc">319</td>
<td class="duration" id="duration-5506-319">--</td>
<td class="did" id="did-5506-319">--</td>
<td class="clid" id="clid-5506-319">--</td>
<td class="status" id="status-5506-319">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5506-319">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Interview Edukasion</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Munish_Dabra</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>550051 / Munish_Dabra</td>
<td class="name" id="name-550051-55101">Manish Dabara </td>
<td class="desc">55101</td>
<td class="duration" id="duration-550051-55101">--</td>
<td class="did" id="did-550051-55101">--</td>
<td class="clid" id="clid-550051-55101">--</td>
<td class="status" id="status-550051-55101">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="550051-55101">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>550051 / Munish_Dabra</td>
<td class="name" id="name-550051-55102">Manish Dabara </td>
<td class="desc">55102</td>
<td class="duration" id="duration-550051-55102">--</td>
<td class="did" id="did-550051-55102">--</td>
<td class="clid" id="clid-550051-55102">--</td>
<td class="status" id="status-550051-55102">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="550051-55102">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> CRM_CALL_QUEUE</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Wines_Queue</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>10000 / Wines_Queue</td>
<td class="name" id="name-10000-111">Vikram_Aus </td>
<td class="desc">111</td>
<td class="duration" id="duration-10000-111">--</td>
<td class="did" id="did-10000-111">--</td>
<td class="clid" id="clid-10000-111">--</td>
<td class="status" id="status-10000-111">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="10000-111">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>10000 / Wines_Queue</td>
<td class="name" id="name-10000-112">Vikram  </td>
<td class="desc">112</td>
<td class="duration" id="duration-10000-112">--</td>
<td class="did" id="did-10000-112">--</td>
<td class="clid" id="clid-10000-112">--</td>
<td class="status" id="status-10000-112">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="10000-112">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>10000 / Wines_Queue</td>
<td class="name" id="name-10000-113">Devendra Sharma  </td>
<td class="desc">113</td>
<td class="duration" id="duration-10000-113">--</td>
<td class="did" id="did-10000-113">--</td>
<td class="clid" id="clid-10000-113">--</td>
<td class="status" id="status-10000-113">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="10000-113">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>10000 / Wines_Queue</td>
<td class="name" id="name-10000-114">Aman  </td>
<td class="desc">114</td>
<td class="duration" id="duration-10000-114">--</td>
<td class="did" id="did-10000-114">--</td>
<td class="clid" id="clid-10000-114">--</td>
<td class="status" id="status-10000-114">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="10000-114">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> testing729004</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>72900 / testing729004</td>
<td class="name" id="name-72900-9901">Shivam </td>
<td class="desc">9901</td>
<td class="duration" id="duration-72900-9901">--</td>
<td class="did" id="did-72900-9901">--</td>
<td class="clid" id="clid-72900-9901">--</td>
<td class="status" id="status-72900-9901">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="72900-9901">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>72900 / testing729004</td>
<td class="name" id="name-72900-9902">Test Agent </td>
<td class="desc">9902</td>
<td class="duration" id="duration-72900-9902">--</td>
<td class="did" id="did-72900-9902">--</td>
<td class="clid" id="clid-72900-9902">--</td>
<td class="status" id="status-72900-9902">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="72900-9902">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Jeevach_Queue</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0055 / Jeevach_Queue</td>
<td class="name" id="name-0055-550">Aman </td>
<td class="desc">550</td>
<td class="duration" id="duration-0055-550">--</td>
<td class="did" id="did-0055-550">--</td>
<td class="clid" id="clid-0055-550">--</td>
<td class="status" id="status-0055-550">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0055-550">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0055 / Jeevach_Queue</td>
<td class="name" id="name-0055-560">Empty </td>
<td class="desc">560</td>
<td class="duration" id="duration-0055-560">--</td>
<td class="did" id="did-0055-560">--</td>
<td class="clid" id="clid-0055-560">--</td>
<td class="status" id="status-0055-560">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0055-560">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0055 / Jeevach_Queue</td>
<td class="name" id="name-0055-559">Manmeet Sulja </td>
<td class="desc">559</td>
<td class="duration" id="duration-0055-559">--</td>
<td class="did" id="did-0055-559">--</td>
<td class="clid" id="clid-0055-559">--</td>
<td class="status" id="status-0055-559">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0055-559">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0055 / Jeevach_Queue</td>
<td class="name" id="name-0055-558">Umag Gupta </td>
<td class="desc">558</td>
<td class="duration" id="duration-0055-558">--</td>
<td class="did" id="did-0055-558">--</td>
<td class="clid" id="clid-0055-558">--</td>
<td class="status" id="status-0055-558">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0055-558">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0055 / Jeevach_Queue</td>
<td class="name" id="name-0055-557">Aftab Alam </td>
<td class="desc">557</td>
<td class="duration" id="duration-0055-557">--</td>
<td class="did" id="did-0055-557">--</td>
<td class="clid" id="clid-0055-557">--</td>
<td class="status" id="status-0055-557">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0055-557">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0055 / Jeevach_Queue</td>
<td class="name" id="name-0055-556">Deepak Mishra </td>
<td class="desc">556</td>
<td class="duration" id="duration-0055-556">--</td>
<td class="did" id="did-0055-556">--</td>
<td class="clid" id="clid-0055-556">--</td>
<td class="status" id="status-0055-556">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0055-556">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0055 / Jeevach_Queue</td>
<td class="name" id="name-0055-554">Mayank Grover </td>
<td class="desc">554</td>
<td class="duration" id="duration-0055-554">--</td>
<td class="did" id="did-0055-554">--</td>
<td class="clid" id="clid-0055-554">--</td>
<td class="status" id="status-0055-554">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0055-554">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0055 / Jeevach_Queue</td>
<td class="name" id="name-0055-553">Ajeet Jha </td>
<td class="desc">553</td>
<td class="duration" id="duration-0055-553">--</td>
<td class="did" id="did-0055-553">--</td>
<td class="clid" id="clid-0055-553">--</td>
<td class="status" id="status-0055-553">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0055-553">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0055 / Jeevach_Queue</td>
<td class="name" id="name-0055-552">Akash Kumar </td>
<td class="desc">552</td>
<td class="duration" id="duration-0055-552">--</td>
<td class="did" id="did-0055-552">--</td>
<td class="clid" id="clid-0055-552">--</td>
<td class="status" id="status-0055-552">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0055-552">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0055 / Jeevach_Queue</td>
<td class="name" id="name-0055-551">Danish Hussain </td>
<td class="desc">551</td>
<td class="duration" id="duration-0055-551">--</td>
<td class="did" id="did-0055-551">--</td>
<td class="clid" id="clid-0055-551">--</td>
<td class="status" id="status-0055-551">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0055-551">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0055 / Jeevach_Queue</td>
<td class="name" id="name-0055-561">Empty </td>
<td class="desc">561</td>
<td class="duration" id="duration-0055-561">--</td>
<td class="did" id="did-0055-561">--</td>
<td class="clid" id="clid-0055-561">--</td>
<td class="status" id="status-0055-561">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0055-561">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0055 / Jeevach_Queue</td>
<td class="name" id="name-0055-555">Empty </td>
<td class="desc">555</td>
<td class="duration" id="duration-0055-555">--</td>
<td class="did" id="did-0055-555">--</td>
<td class="clid" id="clid-0055-555">--</td>
<td class="status" id="status-0055-555">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0055-555">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> AshwiniG_Queue</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0066 / AshwiniG_Queue</td>
<td class="name" id="name-0066-660">ADITYA RASTOGI </td>
<td class="desc">660</td>
<td class="duration" id="duration-0066-660">--</td>
<td class="did" id="did-0066-660">--</td>
<td class="clid" id="clid-0066-660">--</td>
<td class="status" id="status-0066-660">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0066-660">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0066 / AshwiniG_Queue</td>
<td class="name" id="name-0066-668">BISWARUP DEY  </td>
<td class="desc">668</td>
<td class="duration" id="duration-0066-668">--</td>
<td class="did" id="did-0066-668">--</td>
<td class="clid" id="clid-0066-668">--</td>
<td class="status" id="status-0066-668">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0066-668">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0066 / AshwiniG_Queue</td>
<td class="name" id="name-0066-667">JITENDRA KUMAR  </td>
<td class="desc">667</td>
<td class="duration" id="duration-0066-667">--</td>
<td class="did" id="did-0066-667">--</td>
<td class="clid" id="clid-0066-667">--</td>
<td class="status" id="status-0066-667">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0066-667">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0066 / AshwiniG_Queue</td>
<td class="name" id="name-0066-665">AMAN CHAUDHARY </td>
<td class="desc">665</td>
<td class="duration" id="duration-0066-665">--</td>
<td class="did" id="did-0066-665">--</td>
<td class="clid" id="clid-0066-665">--</td>
<td class="status" id="status-0066-665">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0066-665">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0066 / AshwiniG_Queue</td>
<td class="name" id="name-0066-664">ASHISH ARORA </td>
<td class="desc">664</td>
<td class="duration" id="duration-0066-664">--</td>
<td class="did" id="did-0066-664">--</td>
<td class="clid" id="clid-0066-664">--</td>
<td class="status" id="status-0066-664">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0066-664">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0066 / AshwiniG_Queue</td>
<td class="name" id="name-0066-663">RIMMY KUMARI   </td>
<td class="desc">663</td>
<td class="duration" id="duration-0066-663">--</td>
<td class="did" id="did-0066-663">--</td>
<td class="clid" id="clid-0066-663">--</td>
<td class="status" id="status-0066-663">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0066-663">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0066 / AshwiniG_Queue</td>
<td class="name" id="name-0066-662">SHREYA BANIK </td>
<td class="desc">662</td>
<td class="duration" id="duration-0066-662">--</td>
<td class="did" id="did-0066-662">--</td>
<td class="clid" id="clid-0066-662">--</td>
<td class="status" id="status-0066-662">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0066-662">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0066 / AshwiniG_Queue</td>
<td class="name" id="name-0066-661">DISHA PALTANI </td>
<td class="desc">661</td>
<td class="duration" id="duration-0066-661">--</td>
<td class="did" id="did-0066-661">--</td>
<td class="clid" id="clid-0066-661">--</td>
<td class="status" id="status-0066-661">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0066-661">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0066 / AshwiniG_Queue</td>
<td class="name" id="name-0066-669">ADITYA JAIN </td>
<td class="desc">669</td>
<td class="duration" id="duration-0066-669">--</td>
<td class="did" id="did-0066-669">--</td>
<td class="clid" id="clid-0066-669">--</td>
<td class="status" id="status-0066-669">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0066-669">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0066 / AshwiniG_Queue</td>
<td class="name" id="name-0066-6615">Empty </td>
<td class="desc">6615</td>
<td class="duration" id="duration-0066-6615">--</td>
<td class="did" id="did-0066-6615">--</td>
<td class="clid" id="clid-0066-6615">--</td>
<td class="status" id="status-0066-6615">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0066-6615">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0066 / AshwiniG_Queue</td>
<td class="name" id="name-0066-6614">Empty </td>
<td class="desc">6614</td>
<td class="duration" id="duration-0066-6614">--</td>
<td class="did" id="did-0066-6614">--</td>
<td class="clid" id="clid-0066-6614">--</td>
<td class="status" id="status-0066-6614">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0066-6614">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0066 / AshwiniG_Queue</td>
<td class="name" id="name-0066-6612">Empty </td>
<td class="desc">6612</td>
<td class="duration" id="duration-0066-6612">--</td>
<td class="did" id="did-0066-6612">--</td>
<td class="clid" id="clid-0066-6612">--</td>
<td class="status" id="status-0066-6612">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0066-6612">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0066 / AshwiniG_Queue</td>
<td class="name" id="name-0066-6611">Empty </td>
<td class="desc">6611</td>
<td class="duration" id="duration-0066-6611">--</td>
<td class="did" id="did-0066-6611">--</td>
<td class="clid" id="clid-0066-6611">--</td>
<td class="status" id="status-0066-6611">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0066-6611">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0066 / AshwiniG_Queue</td>
<td class="name" id="name-0066-6610">Empty </td>
<td class="desc">6610</td>
<td class="duration" id="duration-0066-6610">--</td>
<td class="did" id="did-0066-6610">--</td>
<td class="clid" id="clid-0066-6610">--</td>
<td class="status" id="status-0066-6610">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0066-6610">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> TL_QUEUE</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>005550 / TL_QUEUE</td>
<td class="name" id="name-005550-100">Kundan Singh </td>
<td class="desc">100</td>
<td class="duration" id="duration-005550-100">--</td>
<td class="did" id="did-005550-100">--</td>
<td class="clid" id="clid-005550-100">--</td>
<td class="status" id="status-005550-100">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="005550-100">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>005550 / TL_QUEUE</td>
<td class="name" id="name-005550-200">Mohit Purthi </td>
<td class="desc">200</td>
<td class="duration" id="duration-005550-200">--</td>
<td class="did" id="did-005550-200">--</td>
<td class="clid" id="clid-005550-200">--</td>
<td class="status" id="status-005550-200">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="005550-200">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>005550 / TL_QUEUE</td>
<td class="name" id="name-005550-300">Vikram TL </td>
<td class="desc">300</td>
<td class="duration" id="duration-005550-300">--</td>
<td class="did" id="did-005550-300">--</td>
<td class="clid" id="clid-005550-300">--</td>
<td class="status" id="status-005550-300">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="005550-300">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>005550 / TL_QUEUE</td>
<td class="name" id="name-005550-400">Neha </td>
<td class="desc">400</td>
<td class="duration" id="duration-005550-400">--</td>
<td class="did" id="did-005550-400">--</td>
<td class="clid" id="clid-005550-400">--</td>
<td class="status" id="status-005550-400">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="005550-400">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>005550 / TL_QUEUE</td>
<td class="name" id="name-005550-500">Pooja  </td>
<td class="desc">500</td>
<td class="duration" id="duration-005550-500">--</td>
<td class="did" id="did-005550-500">--</td>
<td class="clid" id="clid-005550-500">--</td>
<td class="status" id="status-005550-500">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="005550-500">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>005550 / TL_QUEUE</td>
<td class="name" id="name-005550-609">Sandeep Yadav </td>
<td class="desc">609</td>
<td class="duration" id="duration-005550-609">--</td>
<td class="did" id="did-005550-609">--</td>
<td class="clid" id="clid-005550-609">--</td>
<td class="status" id="status-005550-609">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="005550-609">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>005550 / TL_QUEUE</td>
<td class="name" id="name-005550-700">KANISHKA TL </td>
<td class="desc">700</td>
<td class="duration" id="duration-005550-700">--</td>
<td class="did" id="did-005550-700">--</td>
<td class="clid" id="clid-005550-700">--</td>
<td class="status" id="status-005550-700">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="005550-700">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>005550 / TL_QUEUE</td>
<td class="name" id="name-005550-800">ROHIT KAUL  </td>
<td class="desc">800</td>
<td class="duration" id="duration-005550-800">--</td>
<td class="did" id="did-005550-800">--</td>
<td class="clid" id="clid-005550-800">--</td>
<td class="status" id="status-005550-800">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="005550-800">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>005550 / TL_QUEUE</td>
<td class="name" id="name-005550-900">Mr. Amber </td>
<td class="desc">900</td>
<td class="duration" id="duration-005550-900">--</td>
<td class="did" id="did-005550-900">--</td>
<td class="clid" id="clid-005550-900">--</td>
<td class="status" id="status-005550-900">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="005550-900">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Vikram_Aus</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0044 / Vikram_Aus</td>
<td class="name" id="name-0044-115">VikramTL </td>
<td class="desc">115</td>
<td class="duration" id="duration-0044-115">--</td>
<td class="did" id="did-0044-115">--</td>
<td class="clid" id="clid-0044-115">--</td>
<td class="status" id="status-0044-115">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0044-115">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0044 / Vikram_Aus</td>
<td class="name" id="name-0044-116">Devendra Sharma </td>
<td class="desc">116</td>
<td class="duration" id="duration-0044-116">--</td>
<td class="did" id="did-0044-116">--</td>
<td class="clid" id="clid-0044-116">--</td>
<td class="status" id="status-0044-116">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0044-116">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0044 / Vikram_Aus</td>
<td class="name" id="name-0044-117">VikramTL </td>
<td class="desc">117</td>
<td class="duration" id="duration-0044-117">--</td>
<td class="did" id="did-0044-117">--</td>
<td class="clid" id="clid-0044-117">--</td>
<td class="status" id="status-0044-117">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0044-117">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0044 / Vikram_Aus</td>
<td class="name" id="name-0044-118">VikramTL </td>
<td class="desc">118</td>
<td class="duration" id="duration-0044-118">--</td>
<td class="did" id="did-0044-118">--</td>
<td class="clid" id="clid-0044-118">--</td>
<td class="status" id="status-0044-118">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0044-118">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0044 / Vikram_Aus</td>
<td class="name" id="name-0044-119">VikramTL </td>
<td class="desc">119</td>
<td class="duration" id="duration-0044-119">--</td>
<td class="did" id="did-0044-119">--</td>
<td class="clid" id="clid-0044-119">--</td>
<td class="status" id="status-0044-119">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="0044-119">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
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


</div>
</div>



<script src="/resources/vendor/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="/resources/vendor/jquery-1.19.2-validation.js" type="text/javascript"></script>
<script src="/resources/vendor/bootstrap-4.1/popper.min.js" type="text/javascript"></script>
<script src="/resources/vendor/bootstrap-4.1/bootstrap.min.js" type="text/javascript"></script>

<script src="/resources/vendor/animsition/animsition.min.js" type="text/javascript"></script>

<script src="/resources/vendor/perfect-scrollbar/perfect-scrollbar.js" type="text/javascript"></script>
<script src="/resources/vendor/select2/select2.min.js" type="text/javascript"></script>
<script src="/resources/js/main.js" type="text/javascript"></script>
<script>
	

$('input[name="agentPause"]').click(function () {
	var queuext = $(this).data("queuext");
	
	$.get("/pauseagent/"+queuext, function(data, status){
		
	});
})	

$(".advance_opt_toggle").click(function(){
	$(".advance_opt_form").slideToggle();
})


function createDynamicWaitOutInVars(queueSummmaryString){
	
	$.each(JSON.parse(queueSummmaryString), function(index, call) {
		window["waiting" + call.queueNum] = 0;
		window["outbound" + call.queueNum] = 0;
		window["inbound" + call.queueNum] = 0;
	})
	
}
function setDynamicWaitOutInVars(queueSummmaryString){
	$.each(JSON.parse(queueSummmaryString), function(index, call) {
		$("#waiting-"+call.queueNum).text(window["waiting" + call.queueNum]);
		$("#outin-"+call.queueNum).text(window["inbound" + call.queueNum]+"/"+window["outbound" + call.queueNum]);
	})
	
}
function getTimeDiff(callTime){
	var today = new Date();
var callDate = new Date(callTime);
/*var diffMs = (today - callDate); // milliseconds between now & Christmas
//var diffDays = Math.floor(diffMs / 86400000); // days
var diffHrs = Math.floor((diffMs % 86400000) / 3600000); // hours
var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000);
if(diffHrs.length == 1){
	diffHrs = "0"+diffHrs;
}
return diffHrs+":"+diffMins;*/
var currDateTime = today.getFullYear() + '-' +('0' + (today.getMonth()+1)).slice(-2)+ '-' +  ('0' + today.getDate()).slice(-2) + ' '+today.getHours()+ ':'+('0' + (today.getMinutes())).slice(-2)+ ':'+today.getSeconds();
 
$(".lastTime").text(currDateTime);
var delta = Math.abs(today - callDate) / 1000;
var days = Math.floor(delta / 86400);
delta -= days * 86400;
var hours = Math.floor(delta / 3600) % 24;
delta -= hours * 3600;
var minutes = Math.floor(delta / 60) % 60;
delta -= minutes * 60;
var seconds = Math.floor(delta % 60);
if(hours > 0){
	return hours+":"+minutes+":"+seconds;
}
return minutes+":"+seconds;
}

$(".queueHeading").click(function(){
	$(this).next().slideToggle();
})

if($("#userId").val() ==  5){
	$(".queue_agents").slideToggle();
}
setInterval(function(){
createDynamicWaitOutInVars('[{"queueName":"Kunden Team","queueNum":" 0001","totalCalls":0,"abandonCall":0,"totalExt":10,"paused":0},{"queueName":"Mohit Team","queueNum":"0002","totalCalls":29,"abandonCall":14,"totalExt":16,"paused":0},{"queueName":"Vikram Team","queueNum":"0003","totalCalls":18,"abandonCall":6,"totalExt":12,"paused":4},{"queueName":"Neha Team","queueNum":"0004","totalCalls":625,"abandonCall":393,"totalExt":18,"paused":0},{"queueName":"Pooja Team","queueNum":"0005","totalCalls":315,"abandonCall":217,"totalExt":10,"paused":0},{"queueName":"Sandeep Team","queueNum":"0006","totalCalls":2085,"abandonCall":1252,"totalExt":57,"paused":3},{"queueName":"Kanishka and SaurabhTeam","queueNum":"0007","totalCalls":73,"abandonCall":50,"totalExt":16,"paused":0},{"queueName":"Rohit Team","queueNum":"0008","totalCalls":613,"abandonCall":373,"totalExt":34,"paused":11},{"queueName":"IT-QUEUE","queueNum":"80001","totalCalls":0,"abandonCall":0,"totalExt":3,"paused":0},{"queueName":"Ranveer-Team","queueNum":"5001","totalCalls":0,"abandonCall":0,"totalExt":2,"paused":2},{"queueName":"HR-Team","queueNum":"2001","totalCalls":0,"abandonCall":0,"totalExt":10,"paused":2},{"queueName":"PM-Team","queueNum":"2002","totalCalls":0,"abandonCall":0,"totalExt":2,"paused":0},{"queueName":"Amber(US Team)","queueNum":"0009","totalCalls":106,"abandonCall":20,"totalExt":8,"paused":3},{"queueName":"EDUKASION SUPPORT","queueNum":"00011","totalCalls":0,"abandonCall":0,"totalExt":1,"paused":0},{"queueName":"Scrumversity","queueNum":"5526","totalCalls":0,"abandonCall":0,"totalExt":2,"paused":0},{"queueName":"OutBond Travoment","queueNum":"9120","totalCalls":0,"abandonCall":0,"totalExt":1,"paused":1},{"queueName":"Shivam","queueNum":"99001","totalCalls":0,"abandonCall":0,"totalExt":4,"paused":2},{"queueName":"Extenal-TFN-Queue","queueNum":"00001","totalCalls":0,"abandonCall":0,"totalExt":1,"paused":0},{"queueName":"CareerEra_Vikaram_TL","queueNum":"5506","totalCalls":0,"abandonCall":0,"totalExt":5,"paused":0},{"queueName":"Interview Edukasion","queueNum":"5532","totalCalls":0,"abandonCall":0,"totalExt":0,"paused":0},{"queueName":"Munish_Dabra","queueNum":"550051","totalCalls":0,"abandonCall":0,"totalExt":2,"paused":2},{"queueName":"CRM_CALL_QUEUE","queueNum":"900221","totalCalls":0,"abandonCall":0,"totalExt":0,"paused":0},{"queueName":"Wines_Queue","queueNum":"10000","totalCalls":4,"abandonCall":4,"totalExt":4,"paused":0},{"queueName":"testing729004","queueNum":"72900","totalCalls":0,"abandonCall":0,"totalExt":2,"paused":2},{"queueName":"Jeevach_Queue","queueNum":"0055","totalCalls":467,"abandonCall":330,"totalExt":12,"paused":1},{"queueName":"AshwiniG_Queue","queueNum":"0066","totalCalls":0,"abandonCall":0,"totalExt":14,"paused":5},{"queueName":"TL_QUEUE","queueNum":"005550","totalCalls":0,"abandonCall":0,"totalExt":9,"paused":0},{"queueName":"Vikram_Aus","queueNum":"0044","totalCalls":5,"abandonCall":0,"totalExt":5,"paused":3}]');
var queueNumbers = $("#queueNumbers").val();	
$.ajax({
                       type: "GET",
                       url: "/getlivecalls",
                        dataType: "text",
                          success: function(data) 
                          {
						  var callList = JSON.parse(data);
						  //console.log(callList);
						  var waitingHtml = "";
						  $(".duration").text("");$(".did").text("");$(".clid").text("");$(".listen").html("");
						 $(".status").text("").parent().removeClass("call_active");
						 // $(".name").text("").parent().removeClass("call_active");
						  $.each(callList, function(index, call) {
									/* if(call.status == 1){
										  $("#duration-"+call.queue_name+"-"+call.agent_number).text(getTimeDiff(call.created));
										  $("#did-"+call.queue_name+"-"+call.agent_number).text(call.source_number);
										  $("#clid-"+call.queue_name+"-"+call.agent_number).text(call.caller_number);
										  $("#status-"+call.queue_name+"-"+call.agent_number).text("Ringing");
										  //$("#name-"+call.queue_name+"-"+call.agent_number).text(call.agent_name);
										  if(call.call_status.indexOf("Outbound") >= 0){
											  window["outbound"+call.queue_name] = window["outbound"+call.queue_name]+1;
										  }
										  else if(call.call_status.indexOf("Inbound") >= 0){
											  window["inbound"+call.queue_name] = window["inbound"+call.queue_name]+1;
										  }
									  }	*/
									  if(call.status == 2){
										  if(queueNumbers.indexOf(call.queue_name) != -1){
										  waitingHtml = waitingHtml+"<tr class='call_wating'><td>"+call.queue_name+"</td><td>"+call.source_number+"</td><td>"+getTimeDiff(call.created)+"</td><td>"+call.caller_number+"</td>";
										 waitingHtml = waitingHtml+'<td style="cursor:pointer;" class="waitingCallKill" data-channel="'+call.agent_channel+'"><img src="/resources/images/call_waiting.png"></td></tr>';
										   window["waiting"+call.queue_name] = window["waiting"+call.queue_name]+1;
										  }
									  }
									  if(call.status == 3){
										  $("#duration-"+call.queue_name+"-"+call.agent_number).text(getTimeDiff(call.modified));
										  $("#did-"+call.queue_name+"-"+call.agent_number).text(call.source_number);
										  $("#clid-"+call.queue_name+"-"+call.agent_number).text(call.caller_number);
										  $("#status-"+call.queue_name+"-"+call.agent_number).text("Answered "+call.call_status);
										  //$("#name-"+call.queue_name+"-"+call.agent_number).text(call.agent_name);
										  $("#duration-"+call.queue_name+"-"+call.agent_number).parent().addClass("call_active");
										  if(call.call_status.indexOf("Outbound") >= 0){
											  window["outbound"+call.queue_name] = window["outbound"+call.queue_name]+1;
										  }
										  else if(call.call_status.indexOf("Inbound") >= 0){
											  window["inbound"+call.queue_name] = window["inbound"+call.queue_name]+1;
										  }
										  else if(call.call_status.indexOf("Forwarded") >= 0){
											  window["inbound"+call.queue_name] = window["inbound"+call.queue_name]+1;
										  }
										  else if(call.call_status.indexOf("Transfered") >= 0){
											  window["inbound"+call.queue_name] = window["inbound"+call.queue_name]+1;
										  }
										  else if(call.call_status.indexOf("-Call") >= 0){
											  window["inbound"+call.queue_name] = window["inbound"+call.queue_name]+1;
										  }
										  else if(call.call_status.indexOf("-TFN") >= 0){
											  window["outbound"+call.queue_name] = window["outbound"+call.queue_name]+1;
										  }
										  
									  }	
								});
								$("#callWaiting").html(waitingHtml);
								$(".waitingCallKill").on('click',function(){
										var channel = $(this).data("channel");
										channel = channel.replace("SIP/","");		
										 $.get("/callwaitingkill/"+channel, function(data, status){
											
										});
										})
								setDynamicWaitOutInVars('[{"queueName":"Kunden Team","queueNum":" 0001","totalCalls":0,"abandonCall":0,"totalExt":10,"paused":0},{"queueName":"Mohit Team","queueNum":"0002","totalCalls":29,"abandonCall":14,"totalExt":16,"paused":0},{"queueName":"Vikram Team","queueNum":"0003","totalCalls":18,"abandonCall":6,"totalExt":12,"paused":4},{"queueName":"Neha Team","queueNum":"0004","totalCalls":625,"abandonCall":393,"totalExt":18,"paused":0},{"queueName":"Pooja Team","queueNum":"0005","totalCalls":315,"abandonCall":217,"totalExt":10,"paused":0},{"queueName":"Sandeep Team","queueNum":"0006","totalCalls":2085,"abandonCall":1252,"totalExt":57,"paused":3},{"queueName":"Kanishka and SaurabhTeam","queueNum":"0007","totalCalls":73,"abandonCall":50,"totalExt":16,"paused":0},{"queueName":"Rohit Team","queueNum":"0008","totalCalls":613,"abandonCall":373,"totalExt":34,"paused":11},{"queueName":"IT-QUEUE","queueNum":"80001","totalCalls":0,"abandonCall":0,"totalExt":3,"paused":0},{"queueName":"Ranveer-Team","queueNum":"5001","totalCalls":0,"abandonCall":0,"totalExt":2,"paused":2},{"queueName":"HR-Team","queueNum":"2001","totalCalls":0,"abandonCall":0,"totalExt":10,"paused":2},{"queueName":"PM-Team","queueNum":"2002","totalCalls":0,"abandonCall":0,"totalExt":2,"paused":0},{"queueName":"Amber(US Team)","queueNum":"0009","totalCalls":106,"abandonCall":20,"totalExt":8,"paused":3},{"queueName":"EDUKASION SUPPORT","queueNum":"00011","totalCalls":0,"abandonCall":0,"totalExt":1,"paused":0},{"queueName":"Scrumversity","queueNum":"5526","totalCalls":0,"abandonCall":0,"totalExt":2,"paused":0},{"queueName":"OutBond Travoment","queueNum":"9120","totalCalls":0,"abandonCall":0,"totalExt":1,"paused":1},{"queueName":"Shivam","queueNum":"99001","totalCalls":0,"abandonCall":0,"totalExt":4,"paused":2},{"queueName":"Extenal-TFN-Queue","queueNum":"00001","totalCalls":0,"abandonCall":0,"totalExt":1,"paused":0},{"queueName":"CareerEra_Vikaram_TL","queueNum":"5506","totalCalls":0,"abandonCall":0,"totalExt":5,"paused":0},{"queueName":"Interview Edukasion","queueNum":"5532","totalCalls":0,"abandonCall":0,"totalExt":0,"paused":0},{"queueName":"Munish_Dabra","queueNum":"550051","totalCalls":0,"abandonCall":0,"totalExt":2,"paused":2},{"queueName":"CRM_CALL_QUEUE","queueNum":"900221","totalCalls":0,"abandonCall":0,"totalExt":0,"paused":0},{"queueName":"Wines_Queue","queueNum":"10000","totalCalls":4,"abandonCall":4,"totalExt":4,"paused":0},{"queueName":"testing729004","queueNum":"72900","totalCalls":0,"abandonCall":0,"totalExt":2,"paused":2},{"queueName":"Jeevach_Queue","queueNum":"0055","totalCalls":467,"abandonCall":330,"totalExt":12,"paused":1},{"queueName":"AshwiniG_Queue","queueNum":"0066","totalCalls":0,"abandonCall":0,"totalExt":14,"paused":5},{"queueName":"TL_QUEUE","queueNum":"005550","totalCalls":0,"abandonCall":0,"totalExt":9,"paused":0},{"queueName":"Vikram_Aus","queueNum":"0044","totalCalls":5,"abandonCall":0,"totalExt":5,"paused":3}]');
						  }
	})
	
											 
 }, 3000);
/* setInterval(function(){
	 window.location.href= "/pbx/live/details";
}, 30000);
 */
</script>
</body>

</html>
