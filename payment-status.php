<?php
require_once('header.php'); 

 
$payment_ref_id = $statusMsg = ''; 
$status = 'error'; 
 
// Check whether the payment ID is not empty 
if(!empty($_GET['pid'])){ 
    $payment_txn_id  = base64_decode($_GET['pid']); 
     

    $select_gateway = "select id, transaction_id, paid_amount,paid_amount_currency, payment_status, name, email from gateways_payments where transaction_id ='$payment_txn_id'";
    $trans_details = mysqli_query($connection , $select_gateway);	
    if(mysqli_num_rows($trans_details) > 0 ){	
        $trans_row = mysqli_fetch_assoc($trans_details);

        ?>
        <div class="main-content" style="background-color:#fffefe61;">
        <div class="section__content section__content--p30 page_mid">
            <div class="container-fluid">  
        <div class="row mt-3">
            <!-- <div class="col-sm-4"></div> -->
            <div class="col-6 mx-auto">
                    <center><img class="card-imgs-top img-fluid" width="500px" height="400px" src="resources/images/giphy.gif" alt="Card image cap"></center>
                    <p class="card-text" style="text-align:center;font-size:30px;color:blue;">Payment Successfull</p>
                        <div class="card-block" style="padding: 20px;">                
                            <p class="card-text" style="text-align:center;font-size:20px;">We received your payment on your purchase, check your email for more information.</p>
                            <div class="col-sm-12 row" style="font-size:20px;">  
                            <div class="col-sm-3" style="margin-left:200px;"><a href="dashboard.php" class="btn btn-info btn-l float-right">Go To Dashboard</a></div>
                            <div class="col-sm-3"><a href="extension.php" class="btn btn-info btn-l float-right">Go To Extension</a></div>
                            <div class="col-sm-3"> <a href="inbound.php" class="btn btn-info btn-l float-right">Go To Destination</a></div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </div>
        <?php

    }else{ ?>
    <div class="main-content">
        <div class="section__content section__content--p30 page_mid">
            <div class="container-fluid">  
                <div class="row mt-3">
                    <div class="container" style="margin-top:100px;">
                        <div class="row mt-4">
                            <!-- <div class="col-sm-4"></div> -->
                            <div class="col-6 mx-auto">
                                <div class="card">
                                    <div class="card-header bg-danger text-white">
                                        <h4 class="card-text">Oops! Payment failed</h4>
                                    </div>
                                    <div class="card-body">
                                        Transaction has failed. Click here to navigate <a href="dashboard.php"> Dashboard</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    <?php }
}else{ 
    header("Location: index.php"); 
    exit; 
} 
?>
<?php require_once('footer.php'); ?> 
 


<?php 
/*
//require_once 'config.php'; 
include 'connection.php';
include 'functions.php';

// Include the configuration file  
 
// Include the database connection file  


        $payment_ref_id = $trans_row['id'];
        $txn_id         = $trans_row['transaction_id'];
        $paid_amount    = $trans_row['paid_amount'];
        $paid_amount_currency = $trans_row['paid_amount_currency'];
        $payment_status = $trans_row['payment_status'];
        $customer_name  = $trans_row['name'];
        $customer_email = $trans_row['email'];


        $status = 'success'; 
        $statusMsg = 'Your Payment has been Successful!'; 
    }else{
        $statusMsg = "Transaction has been failed!"; 
    }
    // Fetch transaction data from the database 
   

?>

<?php
/*
if(!empty($payment_ref_id)){ ?>
    <h1 class="<?php echo $status; ?>"><?php echo $statusMsg; ?></h1>
    
    <h4>Payment Information</h4>
    <p><b>Reference Number:</b> <?php echo $payment_ref_id; ?></p>
    <p><b>Transaction ID:</b> <?php echo $txn_id; ?></p>
    <p><b>Paid Amount:</b> <?php echo $paid_amount.' '.$paid_amount_currency; ?></p>
    <p><b>Payment Status:</b> <?php echo $payment_status; ?></p>
    
    <h4>Customer Information</h4>
    <p><b>Name:</b> <?php echo $customer_name; ?></p>
    <p><b>Email:</b> <?php echo $customer_email; ?></p>
    <?php 
    <h4>Product Information</h4>
    <p><b>Name:</b> <?php echo $itemName; ?></p>
    <p><b>Price:</b> <?php echo $itemPrice.' '.$currency; ?></p>  ?>
<?php }else{ ?>
    <h1 class="error">Your Payment been failed!</h1>
    <p class="error"><?php echo $statusMsg; ?></p>
<?php } */ ?>