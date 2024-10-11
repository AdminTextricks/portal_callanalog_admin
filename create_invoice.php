<?php require_once ('header.php'); ?>


<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <?php
            //echo '<pre>'; print_r($_POST); echo '</pre>';
            $query_inv = "select max(id) as id from invoices";
            $result_inv = mysqli_query($connection, $query_inv);
            if (mysqli_num_rows($result_inv) > 0) {
                $rowid = mysqli_fetch_array($result_inv);
                $nn = $rowid['id'] + 1;
                $invoice_id = "INV/" . date('Y') . "/000" . $nn;
            } else {
                $invoice_id = 'INV/' . date("Y") . '/00001';
            }

            $user_id = $_SESSION['login_user_id'];
            $user_plan_id = $_SESSION['login_user_plan_id'];
            $invoice_currency = 'USD';
            if (isset($_GET['item_name'])) {
                $amountsql = "select price from cc_did_exten_price where user_id='0' and type='did'";
                $amtresult = mysqli_query($connection, $amountsql) or die("query failed : amountsql");
                if (mysqli_num_rows($amtresult) > 0) {
                    $amtrow = mysqli_fetch_assoc($amtresult);
                    $amount_array[] = $amtrow['price'];
                }
                $item_name[] = $_GET['item_name'];
                $quantity[] = 1;
                $renew = 1;
            } else {
                $item_name = $_POST['item_name'];
                $amount_array = $_POST['amount'];
                $quantity = $_POST['quantity'];
                $renew = "";
            }

            $invoice_amount = 0;
            $payment_status = 'Unpaid';
            $item_type = 'DID';

            $item_names_list = [];

            foreach ($amount_array as $key => $amount) {
                $invoice_amount = $invoice_amount + $amount;
            }

            $insert_invoice = "insert into 	invoices (user_id, invoice_id, item_type, invoice_currency, invoice_amount, invoice_subtotal_amount,payment_status) VALUES ('" . $user_id . "','" . $invoice_id . "','" . $item_type . "','" . $invoice_currency . "','" . $invoice_amount . "','" . $invoice_amount . "','" . $payment_status . "')";
            $query_res = mysqli_query($con, $insert_invoice);
            $invo_id = mysqli_insert_id($con);


            foreach ($item_name as $key => $item) {
                $item_price = $amount_array[$key];

                $insert_invoice_item = "insert into invoices_items (invoice_id, item_type, item_number, price) VALUES ('" . $invo_id . "','" . $item_type . "','" . $item . "','" . $item_price . "')";
                $query_res_invo = mysqli_query($con, $insert_invoice_item);
                $update_reserved = "UPDATE cc_did SET `reserved` = '1' WHERE `did`='" . $item . "'";
                mysqli_query($con, $update_reserved);
            }
            if ($renew == "") {
                $items = implode(",", $item_name);
                $activity_type = 'DID Invoice Generated';
                $message = 'DID No: ' . $items . ' ' . 'Invoice Generate Succesfully!';
                user_activity_log($_SESSION['login_user_id'], $_SESSION['userroleforclientid'], $activity_type, $message);
            }

            ?>
            <div class="row">
                <div class="col-12">
                    <div class="text-center text-150">
                        <img src="resources/images/logo.png" class="headerlogo" alt="logo"
                            style="width:40px;higth:40px">
                        <span class="text-default-d3">Call Analog</span>
                    </div>
                </div>
                <hr class="row brc-default-l1 mx-n1 mb-4">
            </div>
            <?php

            $user_row = '';
            $user_select = "SELECT firstname,address,city,country,zipcode,phone FROM `cc_card` where id='" . $user_id . "'";
            $user_details = mysqli_query($connection, $user_select);
            if (mysqli_num_rows($user_details) > 0) {
                $user_row = mysqli_fetch_assoc($user_details);
            }

            $select_plan = "SELECT * FROM `master_plans` where id='" . $user_plan_id . "'";
            $plan_res = mysqli_query($connection, $select_plan);
            if (mysqli_num_rows($plan_res) > 0) {
                $plan_details = mysqli_fetch_assoc($plan_res);
            }
            ?>
            <div class="row">
                <div class="col-sm-6 col-md-8">
                    <div>
                        <span class="text-sm text-grey-m2 align-middle">To:</span>
                        <span class="text-600 text-110 text-blue align-middle">
                            <?php echo $user_row['firstname']; ?>
                        </span>
                    </div>
                    <div class="text-grey-m2">
                        <div class="my-1">
                            <?php echo $user_row['address']; ?>
                        </div>
                        <div class="my-1">
                            <?php echo $user_row['city']; ?>,
                            <?php echo $user_row['country']; ?>
                        </div>
                        <div class="my-1">
                            <?php echo $user_row['zipcode']; ?>
                        </div>
                        <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b
                                class="text-600">
                                <?php echo $user_row['phone']; ?>
                            </b></div>
                    </div>
                </div>
                <!-- /.col -->

                <div class="text-95 col-sm-6 col-md-4 align-self-start d-sm-flex justify-content-end">
                    <div class="text-grey-m2">
                        <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">Invoice</div>

                        <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                class="text-600 text-90">ID:</span>
                            <?php echo $invoice_id; ?>
                        </div>
                        <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                class="text-600 text-90">Plan Type:</span>
                            <?php echo $plan_details['name']; ?>
                        </div>

                        <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                class="text-600 text-90">Issue Date:</span>
                            <?php echo date('Y-m-d H:i:s'); ?>
                        </div>

                        <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                class="text-600 text-90">Status:</span> <span
                                class="badge badge-warning badge-pill px-25">Unpaid</span></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless border-0 border-b-2 brc-default-l1">
                        <thead class="bg-none bgc-default-tp1">
                            <tr class="text-white">
                                <th class="opacity-2">SNo</th>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th width="140">Amount</th>
                            </tr>
                        </thead>

                        <tbody class="text-95 text-secondary-d3">
                            <tr></tr>
                            <?php $i = 1;
                            foreach ($item_name as $key => $item) { ?>
                                <tr>
                                    <td>
                                        <?php echo $i; ?>
                                    </td>
                                    <td>Destination:
                                        <?php echo $item; ?>
                                    </td>
                                    <td>
                                        <?php echo $quantity[$key]; ?>
                                    </td>
                                    <td class="text-95">$
                                        <?php echo $amount_array[$key]; ?>
                                    </td>
                                    <td class="text-secondary-d2">$
                                        <?php echo $amount_array[$key]; ?>
                                    </td>
                                </tr>
                                <?php $i++;
                            } ?>
                        </tbody>
                    </table>
                </div>

                <div class="row mt-3">
                    <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                        Extra note such as company or payment information...
                    </div>

                    <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                        <div class="row">
                            <div class="col-md-7">SubTotal</div>
                            <div class="col-md-5"><span class="text-120 text-secondary-d1">$
                                    <?php echo $invoice_amount; ?>
                                </span></div>
                        </div>
                        <?php if ($user_row['country'] == 'IND') { ?>
                            <div class="row">
                                <div class="col-md-7"> CGST (9.0000%) </div>
                                <div class="col-md-5"> <span class="text-110 text-secondary-d1">₹90.0000</span></div>
                            </div>
                            <div class="row">
                                <div class="col-md-7 ">SGST (9.0000%)</div>
                                <div class="col-md-5"><span class="text-110 text-secondary-d1">₹90.0000</span></div>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-7 ">Total Amount</div>
                            <div class="col-md-5"><span class="text-150 text-success-d3 opacity-2">$
                                    <?php echo $invoice_amount; ?>
                                </span></div>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="text-left">
                    <span class="text-secondary-d1 text-105">Thank you for your business</span>
                </div>
                <div class="text-right">
                    <a href="PayWithCrypto.php?id=<?php echo base64_encode($invo_id); ?>&renew=<?php echo $renew; ?>"
                        class="btn btn-info btn-bold px-4  mt-3 mt-lg-0">Pay With Crypto</a>
                    &nbsp;&nbsp;
                    <a href="PayNow.php?id=<?php echo base64_encode($invo_id); ?>&renew=<?php echo $renew; ?>"
                        class="btn btn-info btn-bold px-4  mt-3 mt-lg-0">Pay Now</a>
                    &nbsp;&nbsp;
                    <?php
                    //$_SESSION['login_user_credits'] = 500.000;
                    //echo '<pre>'; print_r($_SESSION['login_user_credits']); echo '</pre>';
                    if ($_SESSION['login_user_credits'] < $invoice_amount) { ?>
                        <button class="btn btn-info btn-bold px-4 float-right mt-3 mt-lg-0" id="lowbalance"
                            onclick="lowbalance()">Pay With Wallet</button>&nbsp;&nbsp;
                    <?php } else { ?>
                        <a href="walletpayNow.php?id=<?php echo base64_encode($invo_id); ?>&renew=<?php echo $renew; ?>"
                            class="btn btn-info btn-bold px-4 float-right mt-3 mt-lg-0">Pay With Wallet</a>&nbsp;&nbsp;
                    <?php } ?>
                </div>
            </div>

            <script>
                function lowbalance() {
                    alert("You have In sufficient balance in your Wallet. Please choose Pay Now Option.");
                }
            </script>
            <?php require_once ('footer.php'); ?>