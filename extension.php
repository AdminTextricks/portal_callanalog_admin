<?php require_once ('header.php');
$col4_admin = 'col-sm-4';
$col8_admin = 'col-sm-8';
?>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <?php //echo '<pre>'; print_r($_SESSION); echo '</pre>'; ?>
            <?php  //if($_SESSION['userroleforpage'] == 1){ ?>

            <div class="row">
                <div class="col-md-12">

                    <div class="overview-wrap">
                        <h2 class="title-1 <?php if ($_SESSION['userroleforpage'] != 1) {
                            echo $col4_admin;
                        } else {
                            echo '';
                        } ?>" id="info_heading"> Extension Information <span style="margin-left:50px;"></span></h2>
                        <div class="table-data__tool-right row text-end <?php if ($_SESSION['userroleforpage'] != 1) {
                            echo $col8_admin;
                        } else {
                            echo '';
                        } ?>">
                            <?php if ($_SESSION['userroleforpage'] != 1) {
                                if ($_SESSION['login_user_plan_id'] == 0) {
                                    ?>
                                    <a type="button" id="renew_ext" class="au-btn au-btn-icon au-btn--blue text-size pull-left"
                                        style='margin-right:7px;font-size:12px;text-decoration:none; display:none;'><span
                                            class="rows_selected">0</span>
                                        Renew <i class="fa fa-repeat"></i></a>
                                    <a type="button" id="expired_ext"
                                        class="au-btn au-btn-icon au-btn--blue text-size pull-left"
                                        style='margin-right:7px;font-size:12px;text-decoration:none;'>
                                        Expired <i class="fa fa-warning"></i></a>
                                    <a type="button" id="expire_soon"
                                        class="au-btn au-btn-icon au-btn--blue text-size pull-left"
                                        style='margin-right:7px;font-size:12px;text-decoration:none;'>
                                        Expire Soon <i class="fa fa-fighter-jet"></i></a>
                                    <a type="button" id="show_all" class="au-btn au-btn-icon au-btn--blue text-size pull-left"
                                        style='margin-right:7px;font-size:12px;text-decoration:none;display:none;'>
                                        Show all <i class="fa fa-eye"></i></a>
                                <?php } ?>
                                <a type="button" id="quick_view" class="au-btn au-btn-icon au-btn--blue text-size pull-left"
                                    style='margin-right:7px;font-size:12px;text-decoration:none;'>
                                    <button onclick="getExtdetails(<?php echo $_SESSION['login_user_id']; ?>)">
                                        <i class="fa fa-eye"></i>QUICK VIEW</button></a>&nbsp;
                            <?php } ?>
                            <?php if ($_SESSION['userroleforpage'] == 1) { ?>
                                <button class="au-btn au-btn-icon au-btn--green" type="submit" id="export" name="export"
                                value="submit">
                                <i class="fa fa-download"></i>Download CSV
                            </button>  
                            <a href="javascript:void(0);" class="pull-left au-btn au-btn-icon au-btn--blue text-size"
   id="extension_reset" style='margin-right:7px;font-size:12px;text-decoration:none;'>
   <i class="fa fa-circle"></i>Reset
</a>
<?php } ?>
                            <a type="button" id="delete_records"
                                class="au-btn au-btn-icon au-btn--blue text-size pull-left"
                                style='margin-bottom:5px;margin-right:8px;font-size:12px;text-decoration:none;'><span
                                    class="rows_selected" id="select_count">0</span>
                                Delete <i class="fa fa-trash-o"></i></a>
                            <?php //if($_SESSION['userroleforpage'] == 1){ ?>
                            <a type="button" id="edit_extension"
                                class="au-btn au-btn-icon au-btn--blue text-size pull-left"
                                style='margin-bottom:5px;margin-right:20px;font-size:12px;text-decoration:none;'><span
                                    class="rows_selected" id="select_count">0</span>
                                Edit <i class="fa fa-edit"></i></a>
                            <a href="extensionadd.php" class="pull-left au-btn au-btn-icon au-btn--blue text-size"
                                id="extension_add" style='margin-right:7px;font-size:12px;text-decoration:none;'>
                                <i class="fa fa-plus-circle"></i>Extension</a>
                            <?php //} ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php //} ?>
            <?php
            if (isset($_SESSION['msg']) && $_SESSION['msg'] != '') {
                echo "<div id='message' class='text-center bg-light' style='background:lightblue; padding:5px;'><h3 class='text-white'>" . $_SESSION['msg'] . "</h3></div>";
                unset($_SESSION['msg']);
            }
            ?>
            <script>
                setTimeout(function () {
                    var element = document.getElementById('message');
                    element.parentNode.removeChild(element);
                }, 2000);
            </script>
            <style>
                .show {
                    display: block !important;
                    opacity: 1;
                    background: #0000004d !important;
                }

                .panel-collapse {
                    background: white !important;
                }
            </style>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
                        <!-- Table -->
                        <table id='empTable' class='display dataTable table manage_queue_table'>
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="select_all"> Select </th>
                                    <th>Extension Name</th>
                                    <th>Extension Number</th>
                                    <th>Email</th>
                                    <?php if ($_SESSION['userroleforpage'] == 1) { ?>
                                        <th>Company</th>
                                        <th>User Type</th>
                                    <?php } ?>
                                    <th>Intercom</th>
                                    <th>Queue Assigned</th>
                                    <?php //if($_SESSION['userroleforpage'] == 1){ ?>
                                    <th>Host</th>
                                    <?php // } ?>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Script -->
                    <script>
                        $(document).ready(function () {
                            show_ext();
                            $("#expired_ext").on("click", function (e) {
                                e.preventDefault();
                                var ext_status = "0";
                                var host = "static";
                                show_ext(ext_status, host);
                                var button = $("#expired_ext");
                                button.removeClass("au-btn--blue");
                                button.addClass("au-btn--green");
                                $("#renew_ext").css("display", "block");
                                $('#select_all').prop('checked', false);
                                $("#edit_extension").css("display", "none");
                                $("#extension_assign").css("display", "none");
                                $("#extension_add").css("display", "none");
                                $("#quick_view").css("display", "none");
                                $("#info_heading").text("Expired Extension Information");
                                $("#show_all").css("display", "block");
                                $(".rows_selected").html('0');
                            });

                            $("#expire_soon").on("click", function (e) {
                                e.preventDefault();
                                var expire_days = 3;
                                show_ext("", "", expire_days);
                                $("#renew_ext").css("display", "block");
                                $('#select_all').prop('checked', false);
                                $("#edit_extension").css("display", "none");
                                $("#extension_assign").css("display", "none");
                                $("#extension_add").css("display", "none");
                                $("#quick_view").css("display", "none");
                                $("#info_heading").text("Expire Soon Extension Information");
                                $("#show_all").css("display", "block");
                                $(".rows_selected").html('0');
                            });

                            $("#show_all").on("click", function () {
                                show_ext();
                                var button = $("#expired_ext");
                                button.removeClass("au-btn--green");
                                button.addClass("au-btn--blue");
                                $("#renew_ext").css("display", "none");
                                $("#edit_extension").css("display", "block");
                                $("#extension_assign").css("display", "block");
                                $("#extension_add").css("display", "block");
                                $("#quick_view").css("display", "block");
                                $("#info_heading").text("Extension Information");
                                $("#show_all").css("display", "none");
                                $('#select_all').prop('checked', false);
                                $(".rows_selected").html('0');
                            });
                        });

                        function show_ext(ext_status = "", host = "", expire_days = "") {
                            $('#empTable').DataTable({
                                'processing': true,
                                'serverSide': true,
                                'serverMethod': 'post',
                                //'bSort': false,
                                'ajax': {
                                    'url': 'extensionfile.php',
                                    data: { ext_status: ext_status, host: host, expire_days: expire_days },
                                },
                                'columns': [
                                    { data: 'Select' },
                                    { data: 'agent_name' },
                                    { data: 'name' },
                                    { data: 'email' },
                                    <?php if ($_SESSION['userroleforpage'] == 1) { ?>
                                        { data: 'clientName' },
                                        { data: 'userType' },
                                    <?php } ?>
                                { data: 'lead_operator' },
                                    { data: 'queueassigned' },
                                    { data: 'host' },
                                    { data: 'action' },
                                ],
                                'columnDefs': [{
                                    'targets': [0], // column index (start from 0)
                                    'orderable': false, // set orderable false for selected columns
                                }],
                                'initComplete': function () {
                                    var table = this.api();
                                    $('#empTable').on('click', '.quickView', function () {
                                        var data = table.row($(this).closest('tr')).data();
                                        $('#modalName').text(data.name);
                                        $('#modalClientName').text(data.clientName);
                                        $('#modalPassword').text(data.secret);
                                        $('#register_on').text(data.register_on);
                                        $('#myModalOne').modal('show');
                                    });
                                    $('#empTable').on('click', '.renewMsg', function () {
                                        var data = table.row($(this).closest('tr')).data();
                                        $('#myModalTwo').modal('show');
                                    });
                                },
                                "bDestroy": true,
                                stateSave: false,
                            });
                        }
                    </script>
                    <br>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
<form action="create_ext_invoice.php" id="renew_form" method="POST" style="display:none;">
    <input type="text" name="ext_id" id="ext_id" value="" />
    <input type="text" name="renew" id="" value="1" />
    <button type="submit" value="submit"></button>
</form>
<script>
    function ExtensiondeleteContent(id) {
        if (confirm('Are you sure you want to delete this ?')) {
            window.location = 'extensiondata_delete.php?id=' + id;
        }
        return false;
    }

    function getExtdetails(user_id) {
        $.ajax({
            url: 'getUserExt.php',
            type: 'post',
            data: { user_id: user_id },
            success: function (response) {
                $("#addExtensionDetails").html(response);
                $("#myModalTwo").modal('show');
            }

        });
    }
    $(document).ready(function () {
        /* delete selected records*/
        $('#delete_records').on('click', function (e) {
            var employee = [];
            $(".emp_checkbox:checked").each(function () {
                employee.push($(this).data('emp-id'));
            });
            if (employee.length <= 0) {
                alert("Please select records.");
            }
            else {
                WRN_PROFILE_DELETE = "Are you sure you want to delete " + (employee.length > 1 ? "these" : "this") + " row?";
                var checked = confirm(WRN_PROFILE_DELETE);
                if (checked == true) {
                    var selected_values = employee.join(",");
                    $.ajax({
                        type: "POST",
                        url: "extensiondata_delete.php",
                        cache: false,
                        data: 'id=' + selected_values,
                        success: function (response) {
                            /* remove deleted employee rows*/
                            /* var ids = response.split(",");
                            for (var i=0; i < ids.length; i++ ) {	
                                $("#"+ids[i]).remove(); 
                            } */
                            location.reload(true);
                        }
                    });
                }
            }
        });


        $('#renew_ext').on('click', function (e) {
            var employee = [];
            $(".emp_checkbox:checked").each(function () {
                employee.push($(this).data('emp-id'));
            });
            if (employee.length <= 0) {
                alert("Please select records.");
            } else {
                WRN_PROFILE_DELETE = "Are you sure you want to renew " + (employee.length > 1 ? "these" : "this") + " Extension?";
                var checked = confirm(WRN_PROFILE_DELETE);
                if (checked == true) {
                    var selected_values = employee.join(",");
                    $("#ext_id").val(selected_values);
                    var form = $("#renew_form");
                    form.get(0).submit();
                }
            }
        });
    });

    $(document).ready(function () {
        /* Edit selected records*/
        $('#edit_extension').on('click', function (e) {
            var extensions_id = [];
            $(".emp_checkbox:checked").each(function () {
                extensions_id.push($(this).data('emp-id'));
            });
            if (extensions_id.length <= 0) {
                alert("Please select records.");
            } else {
                //            console.log(extensions_id);
                var selected_values = extensions_id.join(",");
                $.ajax({
                    type: "POST",
                    url: "extensiondata_edit.php",
                    cache: false,
                    data: 'id=' + selected_values,
                    success: function (response) {
                        // console.log(response);
                        $('#EditExtensionModel').modal('show');
                        $('#addHTML').html(response);
                        /* remove deleted employee rows*/
                        /* var ids = response.split(",");
                        for (var i=0; i < ids.length; i++ ) {	
                            $("#"+ids[i]).remove(); 
                        } */
                    }
                });
            }
        });

        /*******Save Edit Extension Data  */

        $('.saveExtensionDetails').on('click', function (e) {

            var jsondataUpdated = $("input[name=jsondataUpdated]").val();

            if (jsondataUpdated == '') {
                alert('No Changes available');
            } else {
                // console.log(jsondataUpdated);        
                $.ajax({
                    type: "POST",
                    url: "extensiondata_save.php",
                    cache: false,
                    data: 'jsondataUpdated=' + jsondataUpdated,
                    success: function (response) {

                        $('#EditExtensionModel').modal('hide');
                        location.reload(true);
                        // $('#addHTML').html(response);                        
                    }
                });
            }

        });

    });



    $(document).on('click', '#select_all', function () {
        $(".emp_checkbox").prop("checked", this.checked);
        $(".rows_selected").html($("input.emp_checkbox:checked").length);
    });
    $(document).on('click', '.emp_checkbox', function () {
        if ($('.emp_checkbox:checked').length == $('.emp_checkbox').length) {
            $('#select_all').prop('checked', true);
        } else {
            $('#select_all').prop('checked', false);
        }
        $(".rows_selected").html($("input.emp_checkbox:checked").length);
    });
    $('#export').click(function (event) {
            event.preventDefault();
            $.ajax({
                url: 'extension_csv.php',
                success: function (response) {
                    var downloadLink = document.createElement('a');
                    downloadLink.href = 'extension_csv.php';
                    downloadLink.download = 'extension_csv.php';
                    downloadLink.click();
                }
            });
        });
    $(document).ready(function(){
        $("#extension_reset").click(function(){
            var confirmed = confirm("Are you sure you want to reset extensions?");
            if (confirmed) {
            $.ajax({
                url: "extension_reset.php",
                type: "POST",
                success: function(response) {
                    alert(response);
                },
                error: function() {
                    alert("An error occurred."); // Error handling
                }
            });
        }
        });
    });
</script>
<div class="modal model-ext" id="myModalOne">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-6">
                        <span>Extension Details</span>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <h4><b>Extension Name</b>: <span id="modalName"></span></h4>
                <h4><b>Extension Password</b>: <span id="modalPassword"></span></h4>
                <h4><b>IP/ DOMAIN </b>: <span id="modalDomain"><?php echo IPDOMAIN ?></span></h4>
                <h4><b>Register on</b>: <span id="register_on"></span></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal model-ext" id="EditExtensionModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-6">
                        <span>Edit Extensions</span>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div id="addHTML"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success saveExtensionDetails">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal model-ext" id="myModalTwo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-6">
                        <span>Extension Details</span>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <h6 style="margin-top: 0px; border-bottom: 1px solid; padding-bottom: 5px;">
                    <b>SIP.CALLANALOG.COM</b>: <span id="modalDomain">
                        <?php echo IPDOMAIN ?>
                    </span>
                </h6>
                <div id="addExtensionDetails"> </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php require_once ('footer.php'); ?>