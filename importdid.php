<?php require_once ('header.php'); ?>

<?php
if (isset($_POST['submit'])) {

    $filename = str_replace(" ", "_", $_FILES["import"]["name"]);
    $tempname = $_FILES["import"]["tmp_name"];
    $_FILES["import"]["size"];
    $FileType = pathinfo($filename, PATHINFO_EXTENSION);
    $fileName = pathinfo($filename, PATHINFO_FILENAME);
    $filename = $fileName . date("Ymdhis") . '.' . $FileType;
    $folder = "import_did/" . $filename;
    if ($FileType !== "csv") {
        $fileErr = "sorry,only CSV file is allowed";
        $error = 'true';
    } else {
        move_uploaded_file($tempname, $folder);
        $created_at = date("Y-m-d h:i:s");
        $import_sql = "INSERT INTO import_did_details(`file_name` , `status`, `created_at`) VALUES ('" . $filename . "','0','" . $created_at . "')";
        $result_import = mysqli_query($connection, $import_sql);
        $last_id = mysqli_insert_id($connection);
        $handle = fopen($folder, "r");
        $headers = fgetcsv($handle, 1000, ",");

        $sql = "";
        $sql .= "INSERT IGNORE INTO cc_did(did, did_provider , id_cc_didgroup, id_cc_country, activated, fixrate, connection_charge, selling_rate, aleg_retail_initblock, aleg_retail_increment) VALUES ";
        while (($line = fgetcsv($handle)) !== FALSE) {
            $data = $line;
            if (!empty($data[0])) {
                $sql .= "('" . trim($data[0]) . "','" . trim($data[1]) . "','" . trim($data[2]) . "','" . trim($data[3]) . "','" . trim($data[4]) . "','" . trim($data[5]) . "','" . trim($data[6]) . "','" . trim($data[7]) . "','" . trim($data[8]) . "','" . trim($data[9]) . "'),";
            }
        }
        fclose($handle);
        $sql = rtrim($sql, ",");

        $result = mysqli_query($connection, $sql) or die("quer failed : sql");
        $updated_at = date("Y-m-d h:i:s");
        $update_sql = "UPDATE import_did_details SET `status`='1' , `updated_at` ='" . $updated_at . "' WHERE `id` = '" . $last_id . "' ";
        $result_update = mysqli_query($connection, $update_sql);
    }

}

?>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap ">
                        <h2 class="title-1">Import Did</h2>
                    </div>
                </div>
            </div>

            <div class="reports_inner_outer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="classic_queue_info">
                            <div class="row">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="col-md-12 text-center">
                                        <?php if (isset($fileErr)): ?>
                                            <div class="alert alert-danger" role="alert">
                                                <strong><?php echo strtoupper($fileErr); ?></strong>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text-input" class=" form-control-label"
                                                style="color:black;margin-left:0px;font-weight:bold;">Choose CSV</label>
                                            <input type="file" name="import" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">

                                            <button type="submit" name="submit" id="submit" style="margin-top:30px;"
                                                class="btn btn-primary btn-sm">Import</button>
                                        </div>
                                    </div>
                                    <div class="form-group " style="text-align: right; padding-right: 10px;">

                                        <a href="/demo.csv" download="demo.csv" class="btn btn-danger btn-sm blink"
                                            style="margin-top:30px;">Download Demo CSV</a>


                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
                        <!-- Table -->

                        <table id='empTable' class='display dataTable table manage_queue_table'>
                            <thead>
                                <tr>
                                    <th>SNo.</th>
                                    <th style="text-align:left;">CSV File Name</th>
                                    <th style="text-align:left;">Status</th>
                                    <th style="text-align:left;">Created At</th>
                                    <th style="text-align:left;">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Script -->
            <script>

                $('#empTable').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'order': [[0, 'desc']],
                    'pageLength': 25,
                    'serverMethod': 'post',
                    'ajax': {
                        'url': 'ajaximportdid.php',

                    },
                    'columns': [
                        { data: 'id' },
                        { data: 'file_name' },
                        { data: 'status' },
                        { data: 'created_at' },
                        { data: 'action' },
                    ]
                }); 
            </script>

            <br>
            <br>
            <br>

        </div>
    </div>
</div>
</div>
</div>

<?php require_once ('footer.php'); ?>