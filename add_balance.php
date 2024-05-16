<?php require_once('header.php'); 
// echo "<pre>"; print_r($_SESSION); exit;
?>
<style>
    .form-control {
        height: 45px;
    }
</style>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <?php


            $user_id = $_SESSION['login_user_id'];
            $user_plan_id = $_SESSION['login_user_plan_id'];
            $item_type = 'Wallet Credit';
            $query_inv = "select max(id) as id from invoices";
            $result_inv = mysqli_query($connection, $query_inv);
            if (mysqli_num_rows($result_inv) > 0) {
                $rowid = mysqli_fetch_array($result_inv);
                // echo "<pre>"; print_r($rowid); exit;
                $nn =  $rowid['id'] + 1;
                $invoice_id = "INV/" . date('Y') . "/000" . $nn;
            } else {
                $invoice_id = 'INV/' . date("Y") . '/00001';
            }

            ?>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <div class="card">
                        <h4 class="card-header bg-primary text-white text-center p-4" style="padding:10px;">Call Analog
                            Add Credit IN Wallet</h4>
                        <div class="card-body bg-light">

                            <div id="payment-errors"></div>
                            <form method="post" id="paymentFrm" enctype="multipart/form-data" onsubmit="return validateForm()">

                                <div class="form-group">
                                    <input name="stripeCurrency" id="stripeCurrency" class="form-control input-field-pay" type="text" value="USD" required readonly/>
                                </div>

                                <div class="form-group">
                                    <input name="stripeAmount" id="stripeAmount" class="form-control input-field-pay" type="number" value="" placeholder="Amount" required />
                                </div>

                                <div class="">
                                    <div class="form-group">
                                        <input name="invoice_id" id="invoice_id" class="form-control input-field-pay" type="hidden" value="<?php echo $nn; ?>" required />
                                    </div>

                                    <div class="form-group">
                                        <input name="gatway_invoice_id" id="gatway_invoice_id" class="form-control input-field-pay" type="hidden" value="<?php echo $invoice_id; ?>" required />
                                    </div>

                                </div>
                                <div class="form-group" style="display:none;">
                                    <input type="text" id="user_id" name="user_id" class="form-control input-field-pay" value="<?php echo $user_id; ?>" required="">
                                </div>
                                <div class="form-group" style="display:none;">
                                    <input name="item_name" id="item_name" class="form-control input-field-pay" type="text" value="<?php echo 'Stripe Wallet Pay'; ?>">
                                </div>

                                <div class="form-group" style="display:none;">
                                    <input name="item_type" id="item_type" class="form-control input-field-pay" type="text" value="<?php echo $item_type; ?>">
                                </div>
                                <div class="form-group">
                                    <input name="payment_type" id="payment_type" class="form-control input-field-pay" type="hidden" value="Stripe" required />
                                </div>
                                <div class="form-group text-right">
                                    <!-- <button class="btn btn-secondary " type="reset">Reset</button> -->
                                    <!-- <button type="submit" id="payBtnCrypto" name="crypto" class="btn btn-primary" value="Pay with BTC">Pay with Crypto</button> -->
                                    <button type="submit" id="payBtnCard" name="submit" class="btn btn-primary" value="Pay with Card">Pay with card</button>
                                </div>
                            </form> 
                            <script>
                                function validateForm() {
                                    var form = document.getElementById("paymentFrm");
                                    var actionUrl = '';
                                    /*if (document.getElementById("payBtnCrypto").clicked) {
                                        actionUrl = "process_wallet_payment.php";
                                    } else*/ if (document.getElementById("payBtnCard").clicked) {
                                        actionUrl = "add_credit_in_wallet_card.php";
                                    }
                                    form.action = actionUrl;

                                    return true;
                                }
                                /*
                                document.getElementById("payBtnCrypto").addEventListener("click", function() {
                                    document.getElementById("payBtnCrypto").clicked = true;
                                });
                                */  
                                document.getElementById("payBtnCard").addEventListener("click", function() {
                                    document.getElementById("payBtnCard").clicked = true;
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
                <!-- <div class="col-md-4">
            <div class="card">
                <h6 class="card-header bg-primary text-white">
                    Some Help?
                </h6>
                <div class="card-body">
                    <p>Get some real help by browsing these guide from offical source.</p>
                    <ol>
                        <li> <a href="https://stripe.com/docs" target="_blank">Stripe Docs</a> </li>
                        <li> <a href="https://stripe.com/docs/checkout" target="_blank">Stripe Checkout</a></li>
                        <li> <a href="https://stripe.com/docs/error-codes" target="_blank">Stripe Error Codes</a></li>

                    </ol>
                </div>
            </div>
        </div> -->
            </div>
        </div>
    </div>
</div>



<?php require_once('footer.php'); ?>