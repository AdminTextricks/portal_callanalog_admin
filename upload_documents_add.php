<?php
require_once('header.php');

$message = '';

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['login_user_id'];
    $accountcode = $_SESSION['login_usernames'];
    $fileExtArr = array('jpg', 'jpeg', 'png', 'webp', 'pdf');
    // Process file_one
    $file_one1 = $_FILES["file_one"]["name"];
    $fileExt1 = strtolower(pathinfo($file_one1, PATHINFO_EXTENSION));
    $file_one = "one" . $accountcode . $file_one1;
    $tempname_one = $_FILES["file_one"]["tmp_name"];
    $folder_one = "upload/" . $file_one;

    // Process file_two
    $file_two2 = $_FILES["file_two"]["name"];
    $fileExt2 = strtolower(pathinfo($file_two2, PATHINFO_EXTENSION));
    $file_two = "two" . $accountcode . $file_two2;
    $tempname_two = $_FILES["file_two"]["tmp_name"];
    $folder_two = "upload/" . $file_two;

    // Process file_three
    $file_three3 = $_FILES["file_three"]["name"];
    $fileExt3 = strtolower(pathinfo($file_three3, PATHINFO_EXTENSION));
    $file_three = "three" . $accountcode . $file_three3;
    $tempname_three = $_FILES["file_three"]["tmp_name"];
    $folder_three = "upload/" . $file_three;

    if (!in_array($fileExt1, $fileExtArr) or !in_array($fileExt2, $fileExtArr) or !in_array($fileExt3, $fileExtArr)) {
        $message = "Please Upload Document Only JPG, JPEG, WEBP, PNG, PDF Format...!!!";
    } else {
        $sql_one = "INSERT INTO `upload_documents` (`user_id`, `accountcode`, `file_one`, `status`) VALUES ('$user_id', '$accountcode', '$file_one', 'Pending')";
        $query_one = mysqli_query($con, $sql_one);

        $sql_two = "INSERT INTO `upload_documents` (`user_id`, `accountcode`, `file_one`, `status`) VALUES ('$user_id', '$accountcode', '$file_two', 'Pending')";
        $query_two = mysqli_query($con, $sql_two);

        $sql_three = "INSERT INTO `upload_documents` (`user_id`, `accountcode`, `file_one`, `status`) VALUES ('$user_id', '$accountcode', '$file_three', 'Pending')";
        $query_three = mysqli_query($con, $sql_three);

        if (move_uploaded_file($tempname_one, $folder_one) && move_uploaded_file($tempname_two, $folder_two) && move_uploaded_file($tempname_three, $folder_three)) {

            $result_queue = $query_three;
            if ($result_queue) {
                $qmr_active = "select * from users_login where id = '" . $user_id . "'";
                $query_user_doc_active = mysqli_query($con, $qmr_active);
                if (mysqli_num_rows($query_user_doc_active) > 0) {
                    while ($row_active = mysqli_fetch_assoc($query_user_doc_active)) {
                        $user_doc_uload_name = $row_active['name'];
                        $user_doc_uload_clientId = $row_active['clientId'];
                    }
                }
                $activity_type = 'Document Uploaded';
                $msg = 'User : ' . $user_doc_uload_name . ' ' . 'Document Uploaded! ';
                user_activity_log($user_id, $user_doc_uload_clientId, $activity_type, $msg);
                $message = 'Document Uploaded!';
            }
            $message = "<h3>Files uploaded successfully!</h3>";
        } else {
            $message = "<h3>Failed to upload files!</h3>";
        }
    }
}
function endsWith($string, $suffix)
{
    return substr($string, -strlen($suffix)) === $suffix;
}
?>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <div class="overview-wrap">
                        <div class="table-data__tool-right">
                            <h2 class="title-1">Upload Document Information </h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="overview-wrap">
                        <div class="table-data__tool-right">
                            <a href="upload_documents_list.php">
                                <button class=" text-end au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="fa fa-eye" aria-hidden="true"></i> Upload Document
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <span style="margin-left:70px;color:blue;">
                <?php echo $message; ?>
            </span>
            <div class="big_live_outer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="queue_info">
                            <form id="documentform" action="" method="post" enctype="multipart/form-data">
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Front of Your Govt.
                                            ID*</label>
                                    </div>
                                    <div class="col-12 col-md-8 row">
                                        <div class="col-sm-6">
                                            <?php if (isset($_FILES["file_one"]) && $_FILES["file_one"]["tmp_name"]) {
                                                if (endsWith($folder_one, ".pdf")) {
                                                    echo '<embed src="' . $folder_one . '" width="50%">';
                                                } else {
                                                    echo '<img src="' . $folder_one . '" width="50%">';
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <input class="form-control" type="file" name="file_one" value="" required />
                                        </div>

                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Back of Your Govt.
                                            ID*</label>
                                    </div>
                                    <div class="col-12 col-md-8 row">
                                        <div class="col-sm-6">
                                            <?php if (isset($_FILES["file_two"]) && $_FILES["file_two"]["tmp_name"]) {
                                                if (endsWith($folder_two, ".pdf")) {
                                                    echo '<embed src="' . $folder_two . '" width="50%">';
                                                } else {
                                                    echo '<img src="' . $folder_two . '" width="50%">';
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <input class="form-control" type="file" name="file_two" value="" required />
                                        </div>

                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Selfie with Govt.
                                            ID*</label>
                                    </div>
                                    <div class="col-12 col-md-8 row">
                                        <div class="col-sm-6">
                                            <?php if (isset($_FILES["file_three"]) && $_FILES["file_three"]["tmp_name"]) {
                                                if (endsWith($folder_three, ".pdf")) {
                                                    echo '<embed src="' . $folder_three . '" width="50%">';
                                                } else {
                                                    echo '<img src="' . $folder_three . '" width="50%">';
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <input class="form-control" type="file" name="file_three" value=""
                                                required />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group pull-right">
                                    <button type="submit" name="submit" class="btn btn-primary btn-sm">Submit</button>
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
<script>
    $(document).ready(function () {
        window.history.replaceState("", "", window.location.upload_documents_add);
    });
</script>
<?php require_once('footer.php'); ?>