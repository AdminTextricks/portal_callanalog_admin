<style>
  * {
    margin: 0;
    padding: 0;
  }

  .loader {
    display: none;
    top: 50%;
    left: 50%;
    position: absolute;
    transform: translate(-50%, -50%);
  }

  .loading {
    border: 2px solid #ccc;
    width: 90px;
    height: 90px;
    border-radius: 50%;
    border-top-color: #337ab7;
    border-left-color: #1ecd97;
    animation: spin 1s infinite ease-in;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  .btn-web {

    background: none repeat scroll 0 0 #337ab7;
    border: medium none;
    color: white;
    height: 35px;
    z-index: 99;
    margin: 0px;
    right: -75px;
    position: fixed;
    transform: rotate(90deg);
    top: 168px;
    width: 200px;
  }

  .btn-win {

    background: none repeat scroll 0 0 #337ab7;
    border: medium none;
    color: white;
    height: 35px;
    z-index: 99;
    margin: 0px;
    right: -75px;
    position: fixed;
    transform: rotate(90deg);
    top: 400px;
    width: 200px;
  }
</style>
<div class="loader">
  <div class="loading">
  </div>
</div>
<footer>
  <div class="copyright">
    <p>Copyright @ <a href="http://callanalog.com/">callanalog.com </a> <?php echo date('Y'); ?>. All rights <a
        href="https://portal.callanalog.com/callanalog/admin/" target="_blank">reserved.</a></p>
  </div>
  <!-- footer section end here -->
</footer>

<?php
$useriid = $_SESSION['login_user_id'];
$upstatus = 'Approved';
$currentUrl = "https://agent.callanalog.com/callanalog/agent/index.php";

// if($_SESSION['userroleforpage'] ==1){
// 	$upload_doc = "SELECT * FROM upload_documents WHERE 1";
// }else{
$upload_doc = "SELECT * FROM upload_documents WHERE user_id='" . $useriid . "' AND status NOT IN('" . $upstatus . "')";
// }
// echo $upload_doc;
$upload_doc_query = mysqli_query($connection, $upload_doc);
if (mysqli_num_rows($upload_doc_query) > 0) {
  while ($row_upload_doc = mysqli_fetch_assoc($upload_doc_query)) {
    $status[] = $row_upload_doc['status'];
  }
  if (!in_array('Rejected', $status) && in_array('Pending', $status)) {
    session_destroy();
    echo '<div id="freezePopup" style="display: block;">
            <div id="popupContent">
                <h2> Document Approval Required </h2>
                <p>Your document is currently pending approval by the admin. Please wait for approval.</p>
            </div>
        </div>';
  } else {
    echo '';
  }
}





mysqli_close($con);
mysqli_close($connection);
?>


<script>
  var documentRequiresApproval = <?php echo isset($_SESSION['documentRequiresApproval']) && $_SESSION['documentRequiresApproval'] ? 'true' : 'false'; ?>;
  // console.log(documentRequiresApproval);
  if (documentRequiresApproval) {
    $('#freezePopup').show();
  }

  function copyToClipboard() {
    var tempInput = document.createElement("input");
    tempInput.value = "<?php echo $currentUrl; ?>";
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);
    alert(" WEBPHONE URL COPIED");
  }
</script>

<style>
  #freezePopup {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
    z-index: 9999;
  }

  #popupContent {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    padding: 20px;
    text-align: center;
  }
</style>
<!--Start of Tawk.to Script-->
<?php
// Get the current page name

// Check if the current page is not 'inboundreports.php' and the SERVER_FLAG is set to 1
if (SERVER_FLAG == 1) { 
?>
  <script type="text/javascript">
    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    (function () {
      var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
      s1.async = true;
      s1.src = 'https://embed.tawk.to/65a8aa878d261e1b5f54a938/1hkddk9g6';
      s1.charset = 'UTF-8';
      s1.setAttribute('crossorigin', '*');
      s0.parentNode.insertBefore(s1, s0);
    })();
  </script>
<?php
}
?>

<!--End of Tawk.to Script-->

<!-- Datatable JS -->

<!-- <script src="jquery-3.3.1.min.js"></script>
        <script src="DataTables/datatables.min.js"></script>
    -->
<!--<script src="resources/vendor/jquery-3.2.1.min.js" type="text/javascript"></script> -->

<script src="resources/vendor/jquery-1.19.2-validation.js" type="text/javascript"></script>
<script src="resources/vendor/bootstrap-4.1/popper.min.js" type="text/javascript"></script>
<script src="resources/vendor/bootstrap-4.1/bootstrap.min.js" type="text/javascript"></script>

<script src="resources/vendor/animsition/animsition.min.js" type="text/javascript"></script>

<script src="resources/vendor/perfect-scrollbar/perfect-scrollbar.js" type="text/javascript"></script>
<script src="resources/vendor/select2/select2.min.js" type="text/javascript"></script>
<script src="resources/js/main.js" type="text/javascript"></script>
<?php
$current_page = basename($_SERVER['SCRIPT_FILENAME']);
if($current_page  != 'inboundRports.php') { ?>
<script src="resources/js/bootstrap-select.min.js" type="text/javascript"></script>
<?php } ?>

<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- <button type="button" class="btn btn-primary btn-web" onclick="copyToClipboard()"> COPY WEB PHONE URL</button>  -->
<button type="button" class="btn btn-primary btn-win"
  onclick="window.open('https://agent.callanalog.com/callanalog/agent/', '_blank')">OPEN WEB PHONE</button>



</body>
<script>
  setTimeout(function () {
    var element = document.getElementById('message');
    element.parentNode.removeChild(element);
  }, 2000);
</script>

</html>