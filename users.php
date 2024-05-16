<?php
require_once ('header.php');
// echo '<pre>';print_r($_SESSION);
?>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1"> User Information <span style="margin-left:50px;"></span></h2>

                        <?php if ($_SESSION['userroleforpage'] == 1) { ?>
                            <div class="table-data__tool-right">
                                <a href="javascript:void(0)">
                                    <button type="button" id="show_reseller" class="au-btn au-btn-icon au-btn--blue">
                                        <i class="fa fa-user"></i>Show Resellers</button></a>&nbsp;
                                <a href="javascript:void(0)">
                                    <button type="button" onclick="change_price()" class="au-btn au-btn-icon au-btn--blue">
                                        <i class="fa fa-rupee"></i>Change Price</button></a>&nbsp;
                                <a href="javascript:void(0)">
                                    <button class="au-btn au-btn-icon au-btn--blue quickView">
                                        <i class="fa fa-eye"></i>Quick View</button></a>&nbsp;
                                <a href="user_add_admin.php">
                                    <button class="au-btn au-btn-icon au-btn--blue">
                                        <i class="fa fa-plus-circle"></i>USER ADD</button></a>&nbsp;
                                <a href="creditsadd.php">
                                    <button class="au-btn au-btn-icon au-btn--blue">
                                        <i class="fa fa-plus-circle"></i>ADD CREDIT</button></a>&nbsp;
                                <!-- <a href="countryadd.php">
                                    <button class="au-btn au-btn-icon au-btn--blue">
                                        <i class="fa fa-plus-circle"></i>ADD COUNTRY</button></a> -->
                            </div>
                        <?php } ?>

                        <?php if ($_SESSION['userroleforpage'] == 0) { ?>
                            <div class="table-data__tool-right">
                                <a href="user_add_admin.php">
                                    <button class="au-btn au-btn-icon au-btn--blue">
                                        <i class="fa fa-plus-circle"></i>USER ADD</button></a>&nbsp;

                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php
            if (isset($_SESSION['msg']) && $_SESSION['msg'] != '') {
                echo "<div id='message' class='text-center bg-light' style='background:lightblue; padding:5px;'><h3 class='text-white'>" . $_SESSION['msg'] . "</h3></div>";
                unset($_SESSION['msg']);
            }
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
                        <!-- Table -->
                        <table id='empTable' class='display dataTable table manage_queue_table'>
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="select_all"> Select </th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Company</th>
                                    <th>Role</th>
                                    <th>Balance</th>
                                    <th>Plan Name</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Script -->
                    <script>
                        $(document).ready(function () {
                            show_users();

                            $("#show_reseller").on("click", function (e) {
                                e.preventDefault();
                                var role = '3';
                                show_users(role);
                            });
                        });

                        function show_users(role = '') {

                            $('#empTable').DataTable({
                                'processing': true,
                                'serverSide': true,
                                'serverMethod': 'post',
                                'ajax': {
                                    'url': 'userfile.php',
                                    data: { role: role },
                                },
                                'columns': [
                                    { data: 'Select' },
                                    { data: 'name' },
                                    { data: 'email' },
                                    { data: 'clientId' },
                                    { data: 'role' },
                                    { data: 'credit' },
                                    { data: 'plan_name' },
                                    { data: 'status' },
                                    { data: 'createDate' },
                                    { data: 'action' },
                                ],
                                'columnDefs': [{
                                    'targets': [0, 9], // column index (start from 0)
                                    'orderable': false, // set orderable false for selected columns
                                }],
                                'initComplete': function () {
                                    var table = this.api();
                                    $('#empTable').on('click', '.quickView', function () {
                                        var modal = document.getElementById("myModalOne");
                                        $('#myModalOne').modal('show');
                                    });
                                },
                                stateSave: false,
                                "bDestroy": true
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
<script>
    function UserdeleteContent(id) {
        if (confirm('Are you sure you want to delete this ?')) {
            window.location = 'userdata_delete.php?id=' + id;
        }
        return false;
    }

    function change_price() {
        $("#change_price").modal('show');
        $.ajax({
            url: 'did_ext_price.php',
            dataType: 'json',
            success: function (response) {
                const { did, extension } = response;
                $("#did_price").val(did);
                $("#ext_price").val(extension);
            }
        });
    }

    $(document).ready(function () {


        $('input[name="change_price"]').on("change", function () {
            var value = $(this).val();
            if (value == 'yes') {
                $(".price").removeAttr("readonly");
            } else {
                $(".price").attr("readonly", true);
            }
        });

        $("#price_change").on("submit", function (e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                url: 'changePrice.php',
                type: 'post',
                data: form.serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.error == true) {
                        $("#error_message1").html('<div style="color:red;font-size:15px;font-weight:bold;margin-left:50px;">' + response.message + '</div>');
                    } else {
                        $("#error_message1").html('<div style="color:green;font-size:15px;font-weight:bold;margin-left:50px;">' + response.message + '</div>');
                        var timeout = setTimeout(function () {
                            $(".price").attr("readonly", true);
                            $("#error_message1").text('');
                            $("#change_price").modal("hide");
                            $("#price_change")[0].reset();
                        }, 1000);
                    }
                }
            });
        });

        /* delete selected records*/
        $('.quickView').on('click', function (e) {
            var employee = [];
            $(".emp_checkbox:checked").each(function () {
                //console.log($(this).siblings().data('extension-details'));
                employee.push($(this).siblings().data('extension-details'));
            });
            if (employee.length <= 0) {
                alert("Please select records.");
            }
            else {
                var exdata = '<div>';
                
        exdata += '<p>Portal login: portal.callanalog.com</p>';
        exdata += '<p>Domain/sip server: sip.callanalog.com:50070 </p>';
        exdata += '<p>For web phone  : agent.callanalog.com</p>';
                // console.log(employee);
                $.each(employee, function (i, j) {
                    $.each(j, function (k, l) {
                        console.log(l);
                        if (k == "username") {
                            exdata += '<h3 style=" border-bottom: 1px solid;font-size:20px; padding-bottom: 5px;"><b>Username:- ' + l + '</b></h3>';
                        }
                        if (k == 'ext_details' && l.length != 0) {
                            exdata += '<h4 style="font-weight:bold;">Extension Details</h4>';
                            $.each(l, function (m, n) {
                                //console.log(value);
                                exdata += '<h6>Extension Name: ' + n[0] + '</h6>';
                                exdata += '<h6 style="margin-top: 0px;  display: inline; border-bottom: 1px dashed; padding-bottom: 5px;">Extension Password: ' + n[1] + '</h6>';
                            });
                        }
                        if (k == 'did_details' && l.length != 0) {
                            x = 1;
                            exdata += '<h4 style="font-weight:bold;">DID Details</h4>';
                            $.each(l, function (m, n) {
                                exdata += '<h6>' + x + '. DID Number: ' + n + '</h6>';
                                x++;
                            });
                        }
                    });
                });
                $("#addExtensionDetails").html(exdata);
                $('#myModalOne').modal('show');
                //console.log(exdata);
            }
        });
    });

    $(document).on('click', '#select_all', function () {
        $(".emp_checkbox").prop("checked", this.checked);
        $("#select_count").html($("input.emp_checkbox:checked").length + " Selected");
    });
    $(document).on('click', '.emp_checkbox', function () {
        if ($('.emp_checkbox:checked').length == $('.emp_checkbox').length) {
            $('#select_all').prop('checked', true);
        } else {
            $('#select_all').prop('checked', false);
        }
        $("#select_count").html($("input.emp_checkbox:checked").length + " Selected");
    });


    $(document).ready(function () {
        // $(document).on('click', '.quickView', function() {
        //var data = table.row($(this).closest('tr')).data();
        //$('#modalName').text(data.name);
        //$('#modalClientName').text(data.clientName);
        //$('#modalPassword').text(data.secret);
        //   $('#myModalOne').modal('show');
        // });
    });

    function resetPassword(id) {
        $("#userId").val(id);
        $("#myModalOne12").modal('show');
    }


    $(document).ready(function () {
        $(".closee").click(function () {
            $('#password').val('');
            $('#cPassword').val('');
            $('#error_message').text('');
        });
    });
    $(document).ready(function () {
        $(".clocs").click(function () {
            $('#password').val('');
            $('#cPassword').val('');
            $('#error_message').text('');
        });
    });

    $(document).ready(function () {
        $("#reset_password").on("submit", function (e) {
            $("#error_message").text('');
            e.preventDefault();
            var form = $(this);
            $.ajax({
                url: 'resetpassword.php',
                type: 'post',
                data: form.serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.error == true) {
                        $("#error_message").html('<div style="color:red;font-size:15px;font-weight:bold;margin-left:50px;">' + response.message + '</div>');
                    } else {
                        $("#error_message").html('<div style="color:green;font-size:15px;font-weight:bold;margin-left:50px;">' + response.message + '</div>');
                        var timeout = setTimeout(function () {
                            $("#error_message").text('');
                            $("#myModalOne12").modal("hide");
                            $("#reset_password")[0].reset();
                        }, 1000);
                    }
                }
            });
        });


    });

</script>

<div class="modal model-ext" id="change_price">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-6">
                        <span>Change DID and Extension Price</span>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="close1" data-dismiss="modal">&times;</button>
                    </div>
                </div>
            </div>
            <span id="error_message1"></span>
            <div class="modal-body">
                <form action="" method="post" id="price_change">
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <span for="text-input" class="form-control-label">Change Price</span>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="radio" name="change_price" id="yes" value="yes" /><label for="yes"
                                style="color:black;margin-left:12px;">Yes</label>
                            <input type="radio" name="change_price" id="no" value="no" checked /><label for="no"
                                style="color:black;margin-left:12px;">No</label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <span for="text-input" class="form-control-label">DID</span>
                        </div>
                        <div class="col-12 col-md-9">
                            <input id="did_price" name="did_price" class="form-control price" value="" type="number"
                                required readonly />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <span for="text-input" class="form-control-label">Extension</span>
                        </div>
                        <div class="col-12 col-md-9">
                            <input id="ext_price" name="ext_price" class="form-control price" value="" type="number"
                                required readonly />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="change">Change</button>
                        <button type="button" id="" class="btn btn-danger closee" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal model-ext" id="myModalOne">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-6">
                        <span>Extension Details</span>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="close clocs" data-dismiss="modal">&times;</button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <h6 style="margin-top: 0px; border-bottom: 1px solid; padding-bottom: 5px;">
                    <b>SIP.CALLANALOG.COM</b>: <span id="modalDomain">
                        <?php echo IPDOMAIN ?>
                    </span>
                </h6>
                <!--<h6><b>Extension Name</b>: <span id="modalName"></span></h6>
        <h6><b>Extension Password</b>:    <span id="modalPassword"></span></h6>-->
                <div id="addExtensionDetails"> </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal model-ext" id="myModalOne12">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-6">
                        <span>CHANGE PASSWORD</span>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="close clocs" data-dismiss="modal">&times;</button>
                    </div>
                </div>
            </div>
            <span id="error_message"></span>
            <div class="modal-body">
                <form action="" method="post" id="reset_password">
                    <input type="hidden" name="userId" id="userId" value="" />
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <span for="text-input" class="form-control-label">Password</span>
                        </div>
                        <div class="col-12 col-md-9">
                            <input id="password" name="password" placeholder="Enter Password" class="form-control"
                                type="password" required />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <span for="text-input" class="form-control-label">Confirm Password</span>
                        </div>
                        <div class="col-12 col-md-9">
                            <input id="cPassword" name="cPassword" placeholder="Confirm Password" class="form-control"
                                type="password" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="submit">Submit</button>
                        <button type="button" id="modal-close" class="btn btn-danger closee"
                            data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once ('footer.php'); ?>