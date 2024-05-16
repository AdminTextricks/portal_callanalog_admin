<?php
require_once('header.php');
$user_id = $_GET['user_id'];
$select_users_login = "SELECT * FROM `users_login` WHERE `id`='" . $user_id . "'";
// echo $select_users_login;exit;
$result_users_login = mysqli_query($connection, $select_users_login) or die("query failed");
if (mysqli_num_rows($result_users_login) > 0) {
    $rowss = mysqli_fetch_assoc($result_users_login);
    $fetch_password = $rowss['password'];
    $clientId = $rowss['clientId'];
}
// echo '<pre>';print_r($rowss);exit;
if (isset($_POST['update'])) {
    $old_password = md5($_POST['old']);
    $new_password = md5($_POST['new']);
    $confirm_pass = md5($_POST['confirm']);
    if ($old_password == $fetch_password) {
        if ($new_password == $confirm_pass) {
            $query1 = "UPDATE `users_login` SET `password` = '" . $new_password . "'  WHERE `id`='" . $user_id . "'";
            mysqli_query($connection, $query1) or die("query failed");
            $query2 = "UPDATE `cc_card`  SET `uipass` = '" . $new_password . "' WHERE `id`='" . $user_id . "'";
            mysqli_query($connection, $query2) or die("query failed");
            $query3 = "UPDATE `Client` SET `clientEmailPass` = '" . $new_password . "' ,`loginPass` ='" . $new_password . "' WHERE `clientid` = '" . $clientId . "'";
            mysqli_query($connection, $query3) or die("query failed");
            $message = 'Password Updated successfully.';
        } else {
            $msg1 = "New/Confirm Password Does not matched ";
        }
    } else {
        $msg2 = "Old Password not Matched";
    }
}
if ($_SESSION['userroleforpage'] == 2 && $rowss['id'] !== $_SESSION['login_user_id']) { ?>
<script>
		window.location = 'access_denied.php';    
	</script>
<?php } ?>
<style>

    .p-viewer {
	z-index: 9999;
	position: absolute;
	left: 413px;
	margin-top: -29px;
}
    
.fa-eye{
    cursor: pointer;
}


@media only screen and (max-width: 992px) {
.p-viewer {
    z-index: 9999;
    position: absolute;
    left: 327px!important;
    margin-top: -29px;
}
}
    </style>
<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Edit Password <span style="margin-left:50px;color:blue;">
                                <?php echo $message; ?>
                            </span></h2>
                        <div class="table-data__tool-right">
                        </div>
                    </div>
                </div>
            </div>
            <div class="big_live_outer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-9">
                            <div class="queue_info">
                                <form id="userForm" action="" method="post" enctype="multipart/form-data">
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">Old Password</label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <input id="old" name="old" placeholder="Enter Your Old Password"
                                                class="form-control" type="password" value="<?php if(isset($_POST['old'])) {echo $_POST['old'];} else {echo '';}?>" required />
                                                <span class="p-viewer">
                                                    <i class="fa fa-eye" id="togglePassword" aria-hidden="true"></i>
                                                     </span>
                                            <b><span style="color:red;">
                                                    <?php echo $msg2; ?>
                                                </span></b>
                                        </div>
                                        
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">New Password</label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <input id="new" name="new" placeholder="Enter Your New Password"
                                                class="form-control" type="password" value="<?php if(isset($_POST['new'])) {echo $_POST['new'];} else { echo '';} ?>" required />
                                                <span class="p-viewer">
                                                    <i class="fa fa-eye" id="ntogglePassword" aria-hidden="true"></i>
                                                     </span>
                                            <span style="color:red;">
                                                <?php //echo $addressErr; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="text-input" class=" form-control-label">Confirm Password</label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <input id="confirm" name="confirm" placeholder="Confirm Your Password"
                                                class="form-control" type="password" value="<?php if(isset($_POST['confirm'])) {echo $_POST['confirm'];} else{echo '';} ?>"  required />
                                                <span class="p-viewer">
                                                    <i class="fa fa-eye" id="ctogglePassword" aria-hidden="true"></i>
                                                     </span>
                                            <b><span style="color:red;">
                                                    <?php echo $msg1; ?>
                                                </span></b>
                                        </div>
                                    </div>
                            </div>
                            <div class="alert alert-danger" id="error-message" style="display:none;"></div>
                            <div class="alert alert-success" id="success-message" style="display:none;"></div>
                            <div class="form-group pull-right">
                                <button type="submit" name="update" class="btn btn-primary btn-sm">Update</button>
                            </div>
                            <p style="color:blue;"></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<br>
<script>
    const togglePassword = document.querySelector('#togglePassword');
		const opassword = document.querySelector('#old');

		togglePassword.addEventListener('click', function (e) {
			// toggle the type attribute
			const type = opassword.getAttribute('type') === 'password' ? 'text' : 'password';
			opassword.setAttribute('type', type);
			// toggle the eye slash icon
			this.classList.toggle('fa-eye-slash');
		});
        const ntogglePassword = document.querySelector('#ntogglePassword');
		const npassword = document.querySelector('#new');

		ntogglePassword.addEventListener('click', function (e) {
			// toggle the type attribute
			const type = npassword.getAttribute('type') === 'password' ? 'text' : 'password';
			npassword.setAttribute('type', type);
			// toggle the eye slash icon
			this.classList.toggle('fa-eye-slash');
		});
        const ctogglePassword = document.querySelector('#ctogglePassword');
		const cpassword = document.querySelector('#confirm');

		ctogglePassword.addEventListener('click', function (e) {
			// toggle the type attribute
			const type = cpassword.getAttribute('type') === 'password' ? 'text' : 'password';
			cpassword.setAttribute('type', type);
			// toggle the eye slash icon
			this.classList.toggle('fa-eye-slash');  
		});
    </script>
<?php require_once('footer.php'); ?>





