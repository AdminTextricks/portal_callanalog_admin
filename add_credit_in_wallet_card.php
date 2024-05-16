<?php require_once ('header.php'); ?>

<style>
    .form-control {
        height: 45px;
    }
</style>
<script src="https://js.stripe.com/v3/"></script>
<script src="assets/js/checkout_wallet.js" STRIPE_PUBLISHABLE_KEY="<?php echo STRIPE_PUBLISHABLE_KEY; ?>"
    defer></script>


<?php

$user_id = $_SESSION['login_user_id'];
$user_plan_id = $_SESSION['login_user_plan_id'];

$user_select = "SELECT firstname,address,city,country,zipcode,phone,credit FROM `cc_card` where id='" . $user_id . "'";
$user_details = mysqli_query($connection, $user_select);
if (mysqli_num_rows($user_details) > 0) {
    $user_row = mysqli_fetch_assoc($user_details);
    $name = $user_row['firstname'];
    $current_bal = $user_row['credit'];
}


if (isset($_POST['submit'])) {
    $amount_cents = $_POST['stripeAmount'];
    $currency_cents = $_POST['stripeCurrency'];
    $invoice_id = $_POST['invoice_id'];
    $gatway_invoice_id = $_POST['gatway_invoice_id'];
    $user_id = $_POST['user_id'];
    $item_name = $_POST['item_name'];
    $item_type = $_POST['item_type'];
    $payment_type = $_POST['payment_type'];
    $payment_status = "Unpaid";
    $item_number = 'UID-' . $user_id . '/ Amount-' . $amount_cents;
    $invoice_sql = "INSERT INTO `invoices`(`user_id`, `invoice_id`, `item_type`,`invoice_currency`, `invoice_amount`, `payment_status`) VALUES('" . $user_id . "','" . $invoice_id . "','" . $item_type . "','" . $currency_cents . "','" . $amount_cents . "','" . $payment_status . "')";

    // echo $invoice_sql; exit;
    $inv_res = mysqli_query($connection, $invoice_sql) or die("query failed : invoice_sql");
    $insert_invoice_item = "INSERT INTO `invoices_items`(`invoice_id`, `item_type`, `item_number`, `price`) VALUES ('" . $invoice_id . "','" . $item_type . "','" . $item_number . "','" . $amount_cents . "')";
    $query_res_invo = mysqli_query($connection, $insert_invoice_item);

    /* $total_bal = $current_bal + $amount_cents;
    $created_at = date('Y-m-d h:i:s');

    $ins_recharge = "INSERT INTO `recharge_history`(`user_id`,`current_bal`,`add_bal`,`total_bal`,`currency`,`recharged_by`,`created_at`) VALUES ('" . $user_id . "','" . $current_bal . "','" . $amount_cents . "','" . $total_bal . "','USD','Self','" . $created_at . "')";

    $res_recharge = mysqli_query($connection, $ins_recharge);
 */
}

$shoData1 = "select * from invoices where invoice_id = '" . $invoice_id . "'";
$shoData = mysqli_query($connection, $shoData1) or die("query failed : user_select");
if (mysqli_num_rows($shoData) > 0) {
    $row = mysqli_fetch_assoc($shoData);
    $nn = $row['id'];
    $currency = $row['invoice_currency'];
    $amount = $row['invoice_amount'];
    $invoice_id2 = "INV/" . date('Y') . "/000" . $nn;
    $item_type2 = $row['item_type'];
    $item_number2 = 'UID-' . $row['user_id'] . '/ Amount-' . $row['invoice_amount'];
    // echo"<pre>";print_r($invoice_id2 );die;
}


?>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <?php

            // $item_type = 'Wallet Credit';
            ?>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <div class="card">
                        <h4 class="card-header bg-primary text-white text-center p-4" style="padding:10px;">Call Analog
                            Add Credit IN Wallet</h4>
                        <div class="card-body bg-light">

                            <div id="payment-errors"></div>
                            <div id="paymentResponse" class="hidden"></div>
                            <form id="paymentFrm" class="hidden">

                                <div class="" style="display:none;">
                                    <div class="form-group">
                                        <input name="gatway_invoice_id" id="gatway_invoice_id"
                                            class="form-control input-field-pay" type="text"
                                            value="<?php echo $invoice_id2; ?>" required />
                                    </div>

                                    <div class="form-group">
                                        <input name="invoice_id" id="invoice_id" class="form-control input-field-pay"
                                            type="text" value="<?php echo $nn ?>" required />
                                    </div>

                                    <div class="form-group">
                                        <input name="stripeAmount" id="stripeAmount"
                                            class="form-control input-field-pay" type="number"
                                            value="<?php echo $amount_cents ?>" placeholder="Amount" required />
                                    </div>


                                    <div class="form-group">
                                        <input name="stripeCurrency" id="stripeCurrency"
                                            class="form-control input-field-pay" type="text"
                                            value="<?php echo $currency; ?>" required />
                                    </div>



                                    <div class="form-group">
                                        <input name="payment_type" id="payment_type"
                                            class="form-control input-field-pay" type="hidden"
                                            value="<?php echo $payment_type; ?> Stripe" required />
                                    </div>


                                    <div class="form-group">
                                        <input type="text" id="name" name="name" class="form-control input-field-pay"
                                            placeholder="Card Holder Name" value="<?php echo $name ?>" required />
                                    </div>

                                    <div class="form-group">
                                        <input type="email" id="email" name="email" class="form-control input-field-pay"
                                            placeholder="example@gmail.com"
                                            value="<?php echo $_SESSION['login_user']; ?>" required />
                                    </div>

                                </div>
                                <div class="row">
                                    <div id="paymentElement">
                                        <!--Stripe.js injects the Payment Element-->
                                    </div>

                                    <!-- Form submit button -->

                                </div>

                                <div class="form-group" style="display:none;">
                                    <input type="text" id="user_id" name="user_id" class="form-control input-field-pay"
                                        value="<?php echo $user_id; ?>" required="">
                                </div>
                                <div class="form-group" style="display:none;">
                                    <input name="item_name" id="item_name" class="form-control input-field-pay"
                                        type="text" value="<?php echo $item_name;
                                        ; ?>">
                                </div>
                                <div class="form-group" style="display:none;">
                                    <input name="item_number" id="item_number" class="form-control input-field-pay"
                                        type="text" value="<?php echo $item_number2; ?>" required />
                                </div>
                                <div class="form-group" style="display:none;">
                                    <input name="item_type" id="item_type" class="form-control input-field-pay"
                                        type="text" value="<?php echo $item_type2; ?>">
                                </div>


                                <div class="form-group text-right">
                                    <button class="btn btn-secondary " type="reset">Reset</button>
                                    <!-- <button type="submit" id="payBtn" class="btn btn-primary">Submit Payment</button> -->
                                    <button id="submitBtn" class="btn btn-success">
                                        <div class="spinner hidden" id="spinner"></div>
                                        <span id="buttonText">Pay Now</span>
                                    </button>
                                    <!-- Display processing notification -->
                                    <div id="frmProcess" class="hidden">
                                        <span class="ring"></span> Processing...
                                    </div>

                                    <!-- Display re-initiate button -->
                                    <div id="payReinit" class="hidden">
                                        <button class="btn btn-primary"
                                            onClick="window.location.href=window.location.href.split('?')[0]"><i
                                                class="rload"></i>Re-initiate Payment</button>
                                    </div>
                                </div>
                            </form>
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



<?php require_once ('footer.php'); ?>