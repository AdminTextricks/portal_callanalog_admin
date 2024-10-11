<?php require_once ('header.php'); ?>

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
            <style>
                .form-control {
                    height: 45px;
                }
            </style>

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <div class="card">
                        <h4 class="card-header bg-primary text-white text-center p-4" style="padding: 10px;">
                            Call Analog Payment Form</h4>
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
                                    <div id="payment-errors"></div>
                                    <form method="post" id="paymentFrm" enctype="multipart/form-data"
                                        action="process_payment.php">

                                        <div class="form-group">
                                            <input name="gatway_invoice_id" id="gatway_invoice_id"
                                                class="form-control input-field-pay" type="text"
                                                value="<?php echo $rowid['invoice_id']; ?>" required />
                                        </div>

                                        <div class="form-group">
                                            <input name="invoice_id" id="invoice_id" class="form-control input-field-pay"
                                                type="hidden" value="<?php echo $rowid['id']; ?>" required />
                                        </div>

                                        <div class="form-group">
                                            <input name="stripeAmount" id="stripeAmount" class="form-control input-field-pay"
                                                type="text" value="<?php echo $rowid['invoice_amount']; ?>" required />
                                        </div>

                                        <div class="form-group">
                                            <input name="stripeCurrency" id="stripeCurrency"
                                                class="form-control input-field-pay" type="text"
                                                value="<?php echo $rowid['invoice_currency']; ?>" required />
                                        </div>

                                        <div class="form-group">
                                            <input name="payment_type" id="payment_type" class="form-control input-field-pay"
                                                type="hidden" value="Crypto" required />
                                        </div>

                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control input-field-pay"
                                                placeholder="Name" value="<?php echo $user_row['firstname']; ?>" required />
                                        </div>


                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control input-field-pay"
                                                placeholder="example@gmail.com" value="<?php echo $_SESSION['login_user']; ?>"
                                                required />
                                        </div>
                                        <div class="form-group" style="display:none;">
                                            <input type="text" id="user_id" name="user_id" class="form-control input-field-pay"
                                                value="<?php echo $user_id; ?>" required>
                                        </div>
                                        <div class="form-group" style="display:none;">
                                            <input name="item_name" id="item_name" class="form-control input-field-pay"
                                                type="text" value="<?php echo 'Crypto Myphonesystems'; ?>">
                                        </div>
                                        <div class="form-group" style="display:none;">
                                            <input name="item_number" id="item_number" class="form-control input-field-pay"
                                                type="text" value="<?php echo $item_str; ?>">
                                        </div>
                                        <div class="form-group" style="display:none;">
                                            <input name="item_type" id="item_type" class="form-control input-field-pay"
                                                type="text" value="<?php echo $item_type; ?>">
                                        </div>
                                        <input type="hidden" name="renew_item" value="<?php echo $_GET['renew']; ?>" />
                                        <!--<div class="form-group" style="display:none;">
                        <input name="gatway_order_id" id="gatway_order_id" class="form-control input-field-pay" type="text" value="<?php echo $invoice['order_id']; ?>"  required />
                        </div>  -->
                                        <div class="form-group text-right">
                                            <button class="btn btn-secondary " type="reset">Reset</button>
                                            <input type="submit" name="btn_type" class="btn btn-primary btn_type"
                                                value="Pay with USDTTRC-20" />
                                            <!-- <input type="submit" name="btn_type" class="btn btn-primary" value="Pay with USD" /> -->
                                            <!--  <input type="submit" name="btn_type" class="btn btn-primary"
                                                value="Pay with Ethereum (ETH)" /> -->

                                            <!-- <button type="submit" name="BTC" value="BTC" class="btn btn-primary">Pay with BTC</button> -->
                                            <!-- <button type="submit" name="USD" class="btn btn-primary">Pay with USD</button>
                          <button type="submit" name="ETH" class="btn btn-primary">Pay with Ethereum (ETH)</button> -->
                                        </div>
                                    </form>
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
            <script>
                $(document).ready(function async() {
                    $("#paymentFrm").submit(function (event) {
                        event.preventDefault();
                        document.getElementsByClassName("loader")[0].style.display = "block";
                        $(this).prop("disabled", true);
                        $(this).css({
                            "opacity": ".2",
                            "cursor": "progress"
                        });
                        var form = $(this);
                        form["btn_type"] = await $(".btn_type").val();
                        // console.log(form);
                        form.get(0).submit();
                        return false;
                    });
                });
            </script>
            <?php require_once ('footer.php'); ?>