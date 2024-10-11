<?php
require_once('header.php'); 
//require_once 'config.php';
?>
<script src="https://js.stripe.com/v3/"></script>
<script src="assets/js/checkout.js" STRIPE_PUBLISHABLE_KEY="<?php echo STRIPE_PUBLISHABLE_KEY; ?>" defer></script>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
        <?php
            //   echo '<pre>'; print_r($_SESSION); echo '</pre>';
            $id = base64_decode($_GET['id']);
            $user_id = $_SESSION['login_user_id'];
            $user_plan_id = $_SESSION['login_user_plan_id'];

            $user_row = '';
            $user_select = "SELECT firstname,address,city,country,zipcode,phone FROM `cc_card` where id='" . $user_id . "'";
            $user_details = mysqli_query($connection, $user_select);
            if (mysqli_num_rows($user_details) > 0) {
                $user_row = mysqli_fetch_assoc($user_details);
            }

            $user_login = "SELECT * FROM `master_plans` where id='" . $user_plan_id . "'";
            $user_login = mysqli_query($connection, $user_login);
            if (mysqli_num_rows($user_login) > 0) {
                $user_login = mysqli_fetch_assoc($user_login);
            }

            ?>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card">
                        <h4 class="card-header bg-primary text-white text-center p-4" style="padding: 10px;">Call Analog
                            Payment Form</h4>
                        <div class="card-body bg-light">
                        <?php
                            $query_inv = "select * from invoices where id='" . $id . "'";
                            $result_inv = mysqli_query($connection, $query_inv);
                            $item_type = '';
                            if (mysqli_num_rows($result_inv) > 0) {
                                $rowid = mysqli_fetch_assoc($result_inv);
                                $items = array();
                                $item_type = $rowid['item_type'];
                                $query_inv_item = "select * from invoices_items where invoice_id='" . $rowid['id'] . "'";
                                $result_inv_item = mysqli_query($connection, $query_inv_item);
                                if (mysqli_num_rows($result_inv_item) > 0) {
                                    while ($row_item = mysqli_fetch_assoc($result_inv_item)) {
                                        $items[] = $row_item['item_number'];
                                        //$item_type = $row_item['item_type'];
                                    }
                                    $item_str = implode('-', $items);
                                    ?>
                            <div class="panel">
                                <div class="panel-heading">
                                </div>
                                <div class="panel-body">
                                    <!-- Display status message -->
                                    <div id="paymentResponse" class="hidden"></div>

                                    <!-- Display a payment form -->
                                    <form id="paymentFrm" class="hidden">

                                    <div class="form-group">
                                            <input name="gatway_invoice_id" id="gatway_invoice_id"
                                                class="form-control input-field-pay" type="text"
                                                value="<?php echo $rowid['invoice_id']; ?>" required readonly />
                                        </div>

                                        <div class="form-group">
                                            <input name="invoice_id" id="invoice_id" class="form-control input-field-pay"
                                                type="hidden" value="<?php echo $rowid['id']; ?>" required readonly />
                                        </div>

                                        <div class="form-group">
                                            <input name="stripeAmount" id="stripeAmount" class="form-control input-field-pay"
                                                type="text" value="<?php echo $rowid['invoice_amount']; ?>" required readonly />
                                        </div>

                                        <div class="form-group">
                                            <input name="stripeCurrency" id="stripeCurrency"
                                                class="form-control input-field-pay" type="text"
                                                value="<?php echo $rowid['invoice_currency']; ?>" required readonly />
                                        </div>

                                        <div class="form-group">
                                            <input name="payment_type" id="payment_type" class="form-control input-field-pay"
                                                type="hidden" value="Stripe" required readonly />
                                        </div>

                                        <!---   default fields   -->
                                        <div class="form-group">
                                            <input type="text" id="name" class="form-control input-field-pay" placeholder="Enter name"
                                                required readonly autofocus="" value="<?php echo $user_row['firstname']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" id="email" class="form-control input-field-pay" placeholder="Enter email"
                                                required readonly value="<?php echo $_SESSION['login_user']; ?>">
                                        </div>

                                        <div id="paymentElement">
                                            <!--Stripe.js injects the Payment Element-->
                                        </div>

                                        <div class="form-group" style="display:none;">
                                            <input type="text" id="user_id" name="user_id" class="form-control input-field-pay"
                                                value="<?php echo $user_id; ?>" required="">
                                        </div>
                                        <div class="form-group" style="display:none;">
                                            <input name="item_name" id="item_name" class="form-control input-field-pay"
                                                type="text" value="<?php echo 'Stripe Myphonesystems'; ?>">
                                        </div>
                                        <div class="form-group" style="display:none;">
                                            <input name="item_number" id="item_number" class="form-control input-field-pay"
                                                type="text" value="<?php echo $item_str; ?>">
                                        </div>
                                        <div class="form-group" style="display:none;">
                                            <input name="item_type" id="item_type" class="form-control input-field-pay"
                                                type="text" value="<?php echo $item_type; ?>">
                                        </div>
                                        <input type="hidden" name="renew_item" id="renew_item" value="<?php echo $_GET['renew'];?>" />
                                        <!-- Form submit button -->
                                        <button id="submitBtn" class="btn btn-success">
                                            <div class="spinner hidden" id="spinner"></div>
                                            <span id="buttonText">Pay Now</span>
                                        </button>
                                    </form>

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
                            </div>
                            <?php } else { ?>
                                    <div id="payment-errors"> Something went wrong please try again.</div>
                                <?php }
                            } else { ?>
                                <div id="payment-errors"> Something went wrong please try again.</div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
</div>
<style>
label.p-FieldLabel.Label {
    display: none !important;
}
</style>
<?php require_once('footer.php'); ?>