<?php
require_once('header.php');

$message = '';
$fileExtArr = array('jpg', 'jpeg', 'png', 'webp', 'pdf');
$query = "SELECT * FROM upload_documents WHERE id='" . $_GET['id'] . "'";
$result = mysqli_query($con, $query);
$data = mysqli_fetch_assoc($result);
/* echo $_SESSION['userroleforpage'];
echo $data['status']; */
if (isset($_POST['submit'])) {
    $user_id = $_SESSION['login_user_id'];
    $accountcode = $_SESSION['login_usernames'];

    if (isset($_FILES["file_one"]["name"]) && !empty($_FILES["file_one"]["name"])) {
        $file_one1 = $_FILES["file_one"]["name"];
        $file_ext = strtolower(pathinfo($file_one1, PATHINFO_EXTENSION));
        if (!in_array($file_ext, $fileExtArr)) {
            $message = '<h3>Please Upload Document Only JPG, JPEG, WEBP, PNG, PDF Format...!!!</h3>';
        } else {
            $file_one = "one" . $accountcode . $file_one1;
            $tempname_one = $_FILES["file_one"]["tmp_name"];
            move_uploaded_file($tempname_one, "upload/" . $file_one);

            if ($_SESSION['userroleforpage'] == 1) {
                $sql = "UPDATE `upload_documents` SET `status`='" . $_POST['status'] . "' WHERE id='" . $_GET['id'] . "'";
                $query = mysqli_query($con, $sql);

                if ($query) {
                    $message = "<h3>Document Data updated successfully!</h3>";
                } else {
                    $message = "<h3>Failed to updated!</h3>";
                }
            } else {
                $sql = "UPDATE `upload_documents` SET `file_one`='$file_one', `status`= 'Pending' WHERE id='" . $_GET['id'] . "'";
                $query = mysqli_query($con, $sql);

                if ($query) {
                    $result_queue = $query;
                    if ($result_queue) {
                        $qmr_active = "select * from users_login where id = '" . $user_id . "'";
                        $query_user_doc_active = mysqli_query($con, $qmr_active);
                        if (mysqli_num_rows($query_user_doc_active) > 0) {
                            while ($row_active = mysqli_fetch_assoc($query_user_doc_active)) {
                                $user_doc_uload_id = $row_active['id'];
                                $user_doc_uload_name = $row_active['name'];
                                $user_doc_uload_clientId = $row_active['clientId'];
                            }
                        }

                        $activity_type = 'Rejected Document Uploaded';
                        $msg = 'User : ' . $user_doc_uload_name . ' ' . 'Rejected Document Uploaded! ';

                        user_activity_log($user_doc_uload_id, $user_doc_uload_clientId, $activity_type, $msg);
                        $message = 'Rejected Document Uploaded!';
                    }
                    $message = "<h3>Image uploaded successfully!</h3>";
                } else {
                    $message = "<h3>Failed to upload image!</h3>";
                }
            }
        }

    } else {
        $file_one = $data['file_one'];
    }


}

$query1 = "SELECT * FROM upload_documents WHERE id='" . $_GET['id'] . "'";
$result = mysqli_query($con, $query1);
$data = mysqli_fetch_assoc($result);

function endsWith($string, $suffix)
{
    return substr($string, -strlen($suffix)) === $suffix;
}
?>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1"> Upload Document Information <span style="margin-left:50px;color:blue;">
                                <?php echo $message; ?>
                            </span></h2>
                        <div class="table-data__tool-right">
                            <a href="upload_documents_list.php">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="fa fa-eye" aria-hidden="true"></i> Upload Document</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="big_live_outer">
                <div class="row">


                    <div class="col-md-12">
                        <div class="queue_info" style="width:1000px!important;">
                            <form id="documentform" action="" method="post" enctype="multipart/form-data">
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Document One*</label>
                                    </div>
                                    <div class="col-12 col-md-8 row">
                                        <div class="col-sm-6">
                                            <?php
                                            if ($data['file_one'] !== '') {
                                                if (endsWith($data['file_one'], ".pdf")) {
                                                    echo '<embed src="upload/' . $data['file_one'] . '" width="100%">';
                                                } else if (endsWith($data['file_one'], ".doc")) {
                                                    echo '<a href="upload/' . $data['file_one'] . '" width="100%">' . $data['file_one'] . '</a>';
                                                } else {
                                                    echo '<img src="upload/' . $data['file_one'] . '" width="100%" class="img-responsive img-fluid">';
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?php
                                            if ($_SESSION['userroleforpage'] == '2' && $data['status'] == "Rejected") {
                                                ?>
                                                <input class="form-control" type="file" name="file_one"
                                                    accept=".jpg,.jpeg,.png,.pdf" required/>
                                                <?php if ($data['file_one'] !== '') { ?>
                                                    <input type="hidden" name="file_one"
                                                        value="<?php echo $data['file_one']; ?>" />
                                                <?php }
                                            } else {
                                                echo "";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($_SESSION['userroleforpage'] == '1') { ?>
                                    <div class="row form-group">
                                        <div class="col-md-4">
                                            <label for="text-input" class=" form-control-label">Status</label>
                                        </div>
                                        <!-- <div class="col-md-4"></div> -->
                                        <div class="col-md-4">
                                            <select name="status" id="status" class="form-control">
                                                <option <?php if ($data['status'] == 'Pending') {
                                                    echo 'selected';
                                                } else {
                                                    '';
                                                } ?> value="Pending">Pending</option>
                                                <option <?php if ($data['status'] == 'Approved') {
                                                    echo 'selected';
                                                } else {
                                                    '';
                                                } ?> value="Approved">Approved</option>
                                                <option <?php if ($data['status'] == 'Rejected') {
                                                    echo 'selected';
                                                } else {
                                                    '';
                                                } ?> value="Rejected">Rejected</option>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="row form-group">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4 text-center">
                                        <button type="submit" name="submit"
                                            class="btn btn-primary btn-sm">Submit</button>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>

<?php require_once('footer.php'); ?>