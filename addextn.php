<?php
/*
 * This class can be used to retrieve messages from an IMAP, POP3 and NNTP server
 * @author Mohd Maroof Ali
 Email->'maroofali551@gmail.com'
 
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Textricks</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.ui.min.js"></script>
  <style>
    @import url(https://fonts.googleapis.com/css?family=Roboto:400,100,900);

    body {
      /*background-color: #E0E0E0;*/
      font-family: 'Roboto', sans-serif
    }



    .modal-content {
      border: none;
      border-radius: 2px;
      box-shadow: 0 16px 28px 0 rgba(0, 0, 0, 0.22), 0 25px 55px 0 rgba(0, 0, 0, 0.21);
    }

    .modal-header {
      border-bottom: 0;
      padding-top: 15px;
      padding-right: 26px;
      padding-left: 26px;
      padding-bottom: 0px;
    }

    .modal-title {
      font-size: 34px;
    }

    .modal-body {
      border-bottom: 0;
      padding-top: 5px;
      padding-right: 26px;
      padding-left: 26px;
      padding-bottom: 10px;
      font-size: 15px;
    }

    .modal-footer {
      border-top: 0;
      padding-top: 0px;
      padding-right: 26px;
      padding-bottom: 26px;
      padding-left: 26px;
    }

    .btn-default,
    .btn-primary {
      border: none;
      border-radius: 2px;
      display: inline-block;
      color: #424242;
      background-color: #FFF;
      text-align: center;
      height: 36px;
      line-height: 36px;
      outline: 0;
      padding: 0 2rem;
      vertical-align: middle;
      -webkit-tap-highlight-color: transparent;
      box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
      letter-spacing: .5px;
      transition: .2s ease-out;
    }

    label {
      font-size: 12px !important;
    }

    .form-control {
      height: 20px !important;
      font-size: 12px !important;
    }

    .form-group {
      margin: 15px 196px;
    }
  </style>
</head>

<body>


  <div class="container text-center">
    <div class="costumModal">
      <div id="costumModal1" class="modal" data-easein="swoopIn" tabindex="-1" role="dialog"
        aria-labelledby="costumModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                ×
              </button>
            </div>
            <div class="modal-body">

              <form method="post">

                <div class="col-md-12">

                  <div class="form-group col-md-3">
                    <label for="name">Extension</label>
                    <input type="text" class="form-control" placeholder="Enter Extension" name="extnsn" required>
                  </div>

                  <!--<div class="form-group col-md-3">
      <label for="name">Action</label>
      <input type="text" class="form-control" placeholder="Enter Extension" name="actnex">
    </div>-->

                </div>
                <button type="submit" name="subextn" class="btn btn-default">Submit</button>
              </form>
            </div>

          </div>
        </div>
      </div>

      <script>
        $(".modal").each(function (l) { $(this).on("show.bs.modal", function (l) { var o = $(this).attr("data-easein"); "shake" == o ? $(".modal-dialog").velocity("callout." + o) : "pulse" == o ? $(".modal-dialog").velocity("callout." + o) : "tada" == o ? $(".modal-dialog").velocity("callout." + o) : "flash" == o ? $(".modal-dialog").velocity("callout." + o) : "bounce" == o ? $(".modal-dialog").velocity("callout." + o) : "swing" == o ? $(".modal-dialog").velocity("callout." + o) : $(".modal-dialog").velocity("transition." + o) }) });
      </script>

      <?php
      include '../common/admincon.php';
      if (isset($_POST['subextn'])) {
        $addex = $_POST['extnsn'];
        //$addac = $_POST['actnex'];
        $select = "SELECT * FROM `extension`";
        $run_select = mysqli_query($adb, $select);
        $check_name = "SELECT `ename` FROM `extension` WHERE `ename`='$addex'";
        $run_name = mysqli_query($adb, $check_name);

        $check = mysqli_num_rows($run_name);

        if ($check == 1) {
          echo "<script>alert('Extension already exits!')</script>";
          exit();
        } else {
          $sql = "insert into extension (ename) values ('$addex')";
          $run_sql = mysqli_query($adb, $sql);
          //exit();
          if ($run_sql) {
            echo "<script>window.open('index.php?exten','_self')</script>";
          }
        }
      }
      ?>

</body>

</html>