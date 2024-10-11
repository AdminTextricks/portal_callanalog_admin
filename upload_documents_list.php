<?php
require_once ('header.php');

?>
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
<div class="main-content">
  <div class="section__content section__content--p30 page_mid">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="overview-wrap">
            <h2 class="title-1"> Uploaded Document <span style="margin-left:50px;"></span></h2>
            <?php if ($_SESSION['userroleforpage'] == 1) { ?>
              <div class="table-data__tool-right">
                <select name="" class="rows_selected form-control" id="doc_status">
                  <option value=""><!-- <span class="rows_selected" id="select_count">0</span> -->Select</option>
                  <option value="Pending">Pending</option>
                  <option value="Approved">Approved</option>
                  <option value="Rejected">Rejected</option>
                </select>
              <?php } ?>
            </div>
            <!-- <div class="table-data__tool-right">
              <?php if ($_SESSION['userroleforpage'] == 2) { ?>
                <a href="upload_documents_add.php">
                  <button class="au-btn au-btn-icon au-btn--blue">
                    <i class="fa fa-plus-circle"></i>Upload Document Add</button>
                </a>
              <?php } ?>
            </div> -->
          </div>
        </div>
      </div>
      <?php
      if (isset($_SESSION['msg']) && $_SESSION['msg'] != '') {
        echo "<div class='text-center bg-light' style='background:lightblue; padding:5px;'><h3 class='text-white'>" . $_SESSION['msg'] . "</h3></div>";
        unset($_SESSION['msg']);
      }
      ?>
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
            <!-- Table -->
            <table id='empTable' class='display dataTable table manage_queue_table style="width: 0px;"'>
              <thead>
                <tr>
                  <?php if ($_SESSION['userroleforpage'] == 1) { ?>
                    <th><input type="checkbox" id="select_all"> Select </th> <?php } ?>
                  <th>Company</th>
                  <th>User Name</th>
                  <th>Client Email </th>
                  <th>First </th>
                  <!-- <th>View</th> -->
                  <!-- <th>Second </th>
                    <th>Third</th> -->
                  <?php if ($_SESSION['userroleforpage'] == 1) { ?>
                    <th>Status</th>
                    <th>Action</th>
                  <?php } else { ?>
                    <th>Status</th>
                  <?php } ?>


                </tr>
              </thead>
            </table>
          </div>
          <!-- Script -->
          <script>
            $(document).ready(function () {
              $('#empTable').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                  'url': 'upload_documents_ajax.php'
                },
                'columns': [
                  <?php if ($_SESSION['userroleforpage'] == 1) { ?>{ data: 'Select' },<?php } ?>
                  { data: 'clientName' },
                  { data: 'username' },
                  { data: 'clientEmail' },
                  { data: 'file_one' },
                  // { data: 'view' },
                  <?php if ($_SESSION['userroleforpage'] == 1) { ?>
                                              { data: 'status_options' },
                    { data: 'action' }
                        <?php } else { ?>
                                                { data: 'action' }
                        <?php } ?>

                ], 'columnDefs': [{
                  'targets': [0], // column index (start from 0)
                  'orderable': false, // set orderable false for selected columns
                }],
                'initComplete': function () {
                  var table = this.api();
                  $('#empTable').on('click', '.open_model', function () {
                    var data = table.row($(this).closest('tr')).data();
                    $('#file').html(data.file_one);
                    $('#myModalOne').modal('show');
                  });
                }
              });
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
<script>
  function UploadDocdatadeleteContent(id) {
    if (confirm('Are you sure you want to delete this ?')) {
      window.location = 'upload_documents_delete.php?id=' + id;
    }
    return false;
  }

  function UploadDocStatus(id) {
    // id
    var status = $('#status' + id).val();
    window.location = 'upload_documents_status.php?id=' + id + '&Status=' + status;
    return false;
  }

  $(document).on('click', '#select_all', function () {
    $(".emp_checkbox").prop("checked", this.checked);
    var extensions_id = [];
    $(".emp_checkbox:checked").each(function () {
      extensions_id.push($(this).data('emp-id'));
    });
    if (extensions_id.length > 3) {
      alert("Please select only 3 records.");
      $("#select_all").prop("checked", false);
      $(".emp_checkbox").prop("checked", false);
    }
    // $(".rows_selected").text($("input.emp_checkbox:checked").length);
  });
  $(document).on('click', '.emp_checkbox', function () {
    var extensions_id = [];
    $(".emp_checkbox:checked").each(function () {
      extensions_id.push($(this).data('emp-id'));
    });

    if (extensions_id.length > 3) {
      alert("Please select only 3 records.");
      $(this).prop('checked', false);
    } else {
      if ($('.emp_checkbox:checked').length == $('.emp_checkbox').length) {

        $('#select_all').prop('checked', true);
      } else {
        $('#select_all').prop('checked', false);
      }
    }
  });


  $(document).ready(function () {
    $('#doc_status').on('change', function (e) {
      var extensions_id = [];
      $(".emp_checkbox:checked").each(function () {
        extensions_id.push($(this).data('emp-id'));
      });
      if (extensions_id.length <= 0) {
        alert("Please select records.");
      } else if (extensions_id.length > 3) {
        alert("Please select only 3 records.");
      }
      else {

        var selected_values = extensions_id.join(",");
        var status = $("#doc_status").val();
        $.ajax({
          type: "GET",
          url: "upload_documents_status.php",
          cache: false,
          data: { id: selected_values, status: status },
          success: function (response) {
            location.reload(true);
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
            <span>Document Details</span>
          </div>
          <div class="col-md-6">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <!-- <h4><b>Extension Name</b>: <span id="modalName"></span></h4>
        <h4><b>Extension Password</b>:    <span id="modalPassword"></span></h4>
        <h4><b>Domain </b>:    <span id="modalDomain">139.84.172.41:50070</span></h4> -->

        <div id="file" style='text-align:center;'></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php require_once ('footer.php'); ?>