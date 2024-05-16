<?php require_once ('header.php');

if ($_SESSION['userroleforpage'] !== '1') {
  ?>
  <script>
    window.location.href = "access_denied.php";
  </script>
  <?php
}

$query_user = "select * from users_login where role = '2' or role='3'";
$result_user = mysqli_query($connection, $query_user);
$message = '';


if (isset($_POST['submit'])) {
  $error = "false";

  if ($_POST['clientId'] == "") {
    $error = "true";
    $message = "You haven't Select any user...!!";
  }


  if ($error == "false") {
    $select_cust_credit = "select credit from cc_card where id='" . $_POST['clientId'] . "'";
    $result_cust = mysqli_query($connection, $select_cust_credit);
    while ($rowcredit = mysqli_fetch_array($result_cust)) {
      $current_credit = $rowcredit['credit'];
    }
    $updated_credit = ($current_credit + $_POST['credit']);
    $created_at = date('Y-m-d h:i:s');
    $update_credit = "update cc_card set credit='" . $updated_credit . "' where id='" . $_POST['clientId'] . "'";
    $resultupdate = mysqli_query($connection, $update_credit);

    $insert_cerdit = "insert into recharge_history (`user_id`,`current_bal`,`add_bal`,`total_bal`,`currency`,`recharged_by`,`created_at`) values ('" . $_POST['clientId'] . "','" . $current_credit . "','" . $_POST['credit'] . "','" . $updated_credit . "','USD','Super Admin','" . $created_at . "')";

    $resultinsert = mysqli_query($connection, $insert_cerdit);

    $sql_user = "select clientId from users_login where id='" . $_POST['clientId'] . "'";
    $result_sql_user = mysqli_query($connection, $sql_user);
    $result_sql_arr = mysqli_fetch_array($result_sql_user);

    $message = "Amount Credit in Wallet Successfully";
    $activity_type = 'Amount Credit in Wallet By Admin';
    $msg = '$' . $_POST['credit'] . ' ' . 'Credit in User Account Succesfully!';
    user_activity_log($_POST['clientId'], $result_sql_arr['clientId'], $activity_type, $msg);
  }
}

?>


<div class="main-content">
  <div class="section__content section__content--p30 page_mid">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="overview-wrap">
            <h2 class="title-1"> User Credit Add <span style="margin-left:50px;"></span></h2>
            <div class="table-data__tool-right">
              <a href="users.php">
                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                  <i class="fa fa-eye" aria-hidden="true"></i> User</button></a>
            </div>

          </div>
        </div>
      </div>

      <div class="big_live_outer">
        <div class="row">
          <div class="col-md-12">
            <div class="queue_info">
              <form id="userForm" action="" method="post" name="creditform">
                <div class="row form-group">
                  <div class="col col-md-3">
                    <label for="text-input" class=" form-control-label">User Name</label>
                  </div>
                  <div class="col-12 col-md-9">
                    <select id="clientId" name="clientId" data-show-subtext="false" data-live-search="true"
                      onchange="showUser(this.value)" class="form-control selectpicker">
                      <option value="">Select</option>
                      <?php while ($rows = mysqli_fetch_array($result_user)) { ?>
                        <option value="<?php echo $rows['id']; ?>">
                          <?php echo $rows['name'] . ' / ' . $rows['email']; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col col-md-3">
                    <label for="text-input" class=" form-control-label">Credit</label>
                  </div>
                  <div class="col-12 col-md-9">
                    <input id="credit" name="credit" placeholder="credit" required class="form-control" type="number"
                      value="<?php if (isset($_POST['credit'])) {
                        echo $_POST['credit'];
                      } else {
                        echo "";
                      } ?>" />
                  </div>
                </div>
                <div class="form-group pull-right">
                  <button type="submit" name="submit" value="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>
                <p id="txtHint"><strong>Credit Available : 0.0</strong></p>
                <span style="color:blue;font-size:18px;">
                  <?php echo $message; ?>
                </span>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function showUser(str) {
    if (str == "") {
      document.getElementById("txtHint").innerHTML = "";
      return;
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    }
    xmlhttp.open("GET", "creditajax.php?q=" + str, true);
    xmlhttp.send();
  }
</script>

<?php require_once ('footer.php'); ?>