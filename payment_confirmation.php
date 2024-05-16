<?php require_once('header.php');
// include('phpqrcode/qrlib.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);
include('phpqrcode/qrlib.php');

$pay_address = $_GET['pay_address'];
$payment_id = $_GET['payment_id'];
$price_amount = $_GET['price_amount'];
$pay_currency = $_GET['pay_currency'];
$order_id = $_GET['order_id'];
$pay_amount = $_GET['pay_amount'];
$amount_received = $_GET['amount_received'];
$gateway_invo_id = $_GET['gateway_invo_id'];
$invoice_id = $_GET['invoice_id'];
$user_id = $_GET['user_id'];
$email = $_GET['email'];
$username = $_GET['username'];
$item_name = $_GET['item_name'];
$item_number = $_GET['item_number'];
$payment_type = $_GET['payment_type'];
$item_type = $_GET['item_type'];
$accountcode = $_GET['accountcode'];

// Debugging output
var_dump($pay_address, $price_amount, $pay_currency, $order_id, $payment_id, $pay_amount, $amount_received);

$tempDir = "qrcode/";
$fileName = '005_file_' . md5($pay_address) . '.png';
$pngAbsoluteFilePath = $tempDir . $fileName;
$urlRelativeFilePath = $tempDir . $fileName;
// Generating QR code without relying on external image creation
QRcode::png($pay_address, $pngAbsoluteFilePath, QR_ECLEVEL_L, 3, 4);
?>
<style>
    .common {
        font-weight: bold;
        text-align: center;
        margin-left: 50%;
    }

    .order {
        color: #8a8193;
        font-size: 20px;
    }

    .send {
        color: #066bbb;
        font-size: 20px;
    }
</style>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap"></div>
                </div>
            </div>
            <div class="big_live_outer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="queue_info">
                            <h2 class="common" style="margin-bottom: 30px;">NOW Payment</h2>
                            <div>
                                <h4 class="common">Total Amount Pay:</h4>
                                <p class="common order">
                                    <?php echo $pay_amount . " BTC"; ?> <br>
                                </p>
                            </div>
                            <div>
                                <p class="common order">
                                    <i class="fa fa-clock"></i> &nbsp;
                                    <?php echo date("h:i"); ?>
                                </p>
                                <h4 class="common">To Address:</h4>
                                <p class="common send">
                                    <?php echo $pay_address; ?>
                                </p>
                            </div>
                            <div>
                                <p class="common order">
                                    <?php
                                    echo 'Scan QR Code';
                                    //echo '<hr />';
                                    // echo 'Server PNG File: ' . $pngAbsoluteFilePath;
                                    // echo '<hr />';
                                    echo '<img src="' . $urlRelativeFilePath . '" class="common" style=" width: 55%;height: 40%;margin-left: 3%;"/>';
                                    ?>
                                </p>
                            </div>
                            <div>
                                <p class="common order">
                                    <button class="btn btn-primary">
                                        <span id="payment_status"></span>
                                    </button><br> <span>Please Do Not Back...<br>Until Payment Status Finished</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>
<script>
    var payment_id = <?php echo $payment_id; ?>;
    var invoice_id = <?php echo $invoice_id; ?>;
    var user_id = <?php echo $_SESSION['login_user_id']; ?>;
    var gateway_invo_id = <?php echo $gateway_invo_id; ?>;
    var email = '<?php echo $email; ?>';
    var username = '<?php echo $username; ?>';
    var item_name = '<?php echo $item_name; ?>';
    var item_number = '<?php echo $item_number; ?>';
    var payment_type = '<?php echo $payment_type; ?>';
    var item_type = '<?php echo $item_type; ?>';
    var accountcode = '<?php echo $accountcode; ?>';

    setInterval(get_status, 300000);
    function get_status() {
        $.ajax({
            url: 'ajaxpayment_confirmation.php',
            type: 'post',
            data: { payment_id: payment_id, invoice_id: invoice_id, user_id: user_id, gateway_invo_id: gateway_invo_id, email: email, username: username, item_name: item_name, item_number: item_number, payment_type: payment_type, item_type: item_type, accountcode: accountcode },
            success: function (data) {
                var a = data.replace(/^\s+|\s+$/gm, '');
                if (a == "finished" || a == "partially_paid") {
                    window.location.href = "payment_successfull.php";
                } else {
                    $("#payment_status").text(data);
                }
            }
        });
    }
    get_status();

</script>
