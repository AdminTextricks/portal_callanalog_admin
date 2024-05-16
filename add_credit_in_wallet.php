<?php require_once('header.php'); ?>
<style>
    .form-control {
        height: 45px;
    }
</style>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
    Stripe.setPublishableKey(PUBLISHABLE_KEY);

    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('#payBtn').removeAttr("disabled");
            // $('#payment-errors').attr('hidden', 'false');
            $('#payment-errors').addClass('alert alert-danger');
            $("#payment-errors").html(response.error.message);
        } else {
            var form$ = $("#paymentFrm");
            var token = response['id'];
            form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
            form$.get(0).submit();
        }
    }
    $(document).ready(function () {
        $("#paymentFrm").submit(function (event) {
            $('#payBtn').attr("disabled", "disabled");
            Stripe.createToken({
                number: $('#card_num').val(),
                cvc: $('#card-cvc').val(),
                exp_month: $('#card-expiry-month').val(),
                exp_year: $('#card-expiry-year').val()
            }, stripeResponseHandler);
            return false;
        });
    });
</script>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <?php
            $user_id = $_SESSION['login_user_id'];
            $user_plan_id = $_SESSION['login_user_plan_id'];
            $item_type = 'Wallet Credit';
            ?>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <div class="card">
                        <h4 class="card-header bg-primary text-white text-center p-4" style="padding:10px;">Call Analog
                            Add Credit IN Wallet</h4>
                        <div class="card-body bg-light">

                            <div id="payment-errors"></div>
                            <form method="post" id="paymentFrm" enctype="multipart/form-data"
                                action="ajaxCreditInWallet.php">

                                <div class="form-group">
                                    <input name="stripeCurrency" id="stripeCurrency"
                                        class="form-control input-field-pay" type="text" value="USD" required />
                                </div>

                                <div class="form-group">
                                    <input name="stripeAmount" id="stripeAmount" class="form-control input-field-pay"
                                        type="number" value="" placeholder="Amount" required />
                                </div>

                                <div class="form-group">
                                    <input type="text" name="name" class="form-control input-field-pay"
                                        placeholder="Card Holder Name" value="" required />
                                </div>

                                <div class="form-group">
                                    <input type="email" name="email" class="form-control input-field-pay"
                                        placeholder="example@gmail.com" value="<?php echo $_SESSION['login_user']; ?>"
                                        required />
                                </div>

                                <div class="form-group">
                                    <input type="number" name="card_num" id="card_num"
                                        class="form-control input-field-pay" placeholder="Card Number"
                                        autocomplete="off" value="" required>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <select name="exp_month" maxlength="2"
                                                        class="form-control input-field-pay" id="card-expiry-month">
                                                        <option>MM</option>
                                                        <option value="01">01</option>
                                                        <option value="02">02</option>
                                                        <option value="03">03</option>
                                                        <option value="04">04</option>
                                                        <option value="05">05</option>
                                                        <option value="06">06</option>
                                                        <option value="07">07</option>
                                                        <option value="08">08</option>
                                                        <option value="09">09</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <select name="exp_year" class="form-control input-field-pay"
                                                        maxlength="4" id="card-expiry-year">
                                                        <option>YYYY</option>
                                                        <?php
                                                        $from_year = date('Y');
                                                        $to_year = date('Y') + 10;
                                                        for ($from_year; $from_year <= $to_year; $from_year++) { ?>
                                                            <option value="<?php echo $from_year; ?>">
                                                                <?php echo $from_year; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" name="cvc" id="card-cvc" maxlength="3"
                                                class="form-control input-field-pay" autocomplete="off"
                                                placeholder="CVC" value="" required>
                                        </div>
                                    </div>
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
                                    <input name="item_type" id="item_type" class="form-control input-field-pay"
                                        type="text" value="<?php echo $item_type; ?>">
                                </div>
                                <div class="form-group">
                                    <input name="payment_type" id="payment_type" class="form-control input-field-pay"
                                        type="hidden" value="Stripe" required />
                                </div>
                                <div class="form-group text-right">
                                    <button class="btn btn-secondary " type="reset">Reset</button>
                                    <button type="submit" id="payBtn" class="btn btn-primary">Submit Payment</button>
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
<?php require_once('footer.php'); ?>