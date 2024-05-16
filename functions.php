<?php
include 'connection.php';
include 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require_once __DIR__ . '/vendor_pdf/autoload.php';
try {
    $mpdf = new \Mpdf\Mpdf([
        'tempDir' => __DIR__ . '/../tmp', // uses the current directory's parent "tmp" subfolder
        'setAutoTopMargin' => 'stretch',
        'setAutoBottomMargin' => 'stretch'
    ]);
} catch (\Mpdf\MpdfException $e) {
    print "Creating an mPDF object failed with" . $e->getMessage();
}
// Include mpdf library file

function midStr($start, $end, $str)
{
    $str = substr($str, strpos($str, $start) + strlen($start));
    return substr($str, 0, strpos($str, $end));
}
function user_activity_log($user_id, $client_id, $activity_type, $message)
{
    global $connection;
    $activity_date = date('Y-m-d');
    $IP_address = $_SERVER['REMOTE_ADDR'];
    $activity_time = date("Y-m-d H:i:s");
    $log_query = "INSERT INTO `user_activity_log`(`user_id`,`client_id`,`activity_date`,`IP_address`,`activity_time`,`activity_type`,`message`) VALUES('" . $user_id . "','" . $client_id . "','" . $activity_date . "','" . $IP_address . "','" . $activity_time . "','" . $activity_type . "','" . $message . "')";
    $result_query = mysqli_query($connection, $log_query);
}


function wh_log($log_msg)
{
    $log_filename = 'extedit_log_';
    if (!file_exists($log_filename)) {
        // create directory/folder uploads.
        mkdir($log_filename, 0777, true);
    }
    $log_file_data = $log_filename . '/extedit_log_' . date('d-M-Y') . '.log';
    file_put_contents($log_file_data, PHP_EOL . $log_msg . '\n', FILE_APPEND);
    return true;
}


function getAccountcode()
{
    global $connection;
    $username_alias = "";
    while (1) {
        $accountcode = rand(0, 99999);
        $accountcode = str_pad($accountcode, 5, '0', STR_PAD_RIGHT);
        $accSql = "select id from cc_card where username='" . $accountcode . "'";
        $accRes = mysqli_query($connection, $accSql) or die('query failed : accSql');
        if (mysqli_num_rows($accRes) > 0) {
            continue;
        } else {
            $username_alias = $accountcode;
            break;
        }
    }
    return $username_alias;
}


function make_pdf($invoice_id, $user_id)
{

    return true;

    /*  global $connection;
     $user_select = "SELECT firstname,username,phone,credit,address,state,country,zipcode FROM `cc_card` where id='" . $user_id . "'";
     $user_details = mysqli_query($connection, $user_select) or die("query failed : user_select");
     if (mysqli_num_rows($user_details) > 0) {
         $card_row = mysqli_fetch_assoc($user_details);
         $address = $card_row['address'];
         $state = $card_row['state'];
         $country = $card_row['country'];
         $zipcode = $card_row['zipcode'];
         $phone = $card_row['phone'];
     }

     $item_array = array();
     $invoice_items_sql = "SELECT COUNT(item_number) as allcount, item_type FROM `invoices_items` where invoice_id ='" . $invoice_id . "' ";
     $invoice_items_result = mysqli_query($connection, $invoice_items_sql) or die("query failed : invoice_items_sql");
     if (mysqli_num_rows($invoice_items_result) > 0) {
         $item_row = mysqli_fetch_assoc($invoice_items_result);
         $item_count = $item_row['allcount'];
         $item_type = $item_row['item_type'];
     }

     $sql_invoices = "SELECT invoice_id,createdDate,invoice_amount,invoice_subtotal_amount FROM `invoices` WHERE `id`='" . $invoice_id . "'";
     $result_invoices = mysqli_query($connection, $sql_invoices) or die("query failed : sql_invoices");
     if (mysqli_num_rows($result_invoices) > 0) {
         $rows = mysqli_fetch_assoc($result_invoices);
         $fetch_invoice_id = $rows['invoice_id'];
         $fetch_date = $rows['createdDate'];
         $fetch_total_amount = $rows['invoice_amount'];
         $sub_total_amount = $rows['invoice_subtotal_amount'];
     }

     $sql_gateway = "SELECT gatway_order_id,payment_type,email,transaction_id FROM `gateways_payments` WHERE `invoice_db_id`='" . $invoice_id . "'";
     $res_gateway = mysqli_query($connection, $sql_gateway) or die("query failed : sql_gateway");
     if (mysqli_num_rows($res_gateway) > 0) {
         $gateway_row = mysqli_fetch_assoc($res_gateway);
         $order_id = $gateway_row['gatway_order_id'];
         $pay_type = $gateway_row['payment_type'];
         $email = $gateway_row['email'];
         $txn_id = $gateway_row['transaction_id'];
     }


     $content = '';

     $content = 'Dear User,<br><br>Congratulation, You have Purchase ' . $item_count . ' ' . $item_type . ' Successfully.<br><br>Thanks and Regards <br><br>Team Callanalog';

     $mail = new PHPMailer(true);
     try {
         // $mail->SMTPDebug = 2;                                      
         $mail->isSMTP();
         $mail->Host = HOST;
         $mail->SMTPAuth = true;
         $mail->Username = EMAIL;
         $mail->Password = PASSWORD;
         $mail->SMTPSecure = 'tls';
         $mail->Port = PORT;

         $mail->setFrom(EMAIL, MYPHONE);
         $mail->addAddress($email);

         $mail->isHTML(true);
         $mail->Subject = $item_type . ' Purchase';
         $mail->Body = $content;
         // $mail->AddAttachment($pdfFilePath, $file_name);
         $mail->AltBody = 'Body in plain text for non-HTML mail clients';
         $mail->send();
         // echo "Invoice has been sent successfully!";
         $success_mail = "UPDATE `invoices` SET `email_status`='1', `email_msg`='Invoice Sent Successfully' where id='" . $invoice_id . "'";
         mysqli_query($connection, $success_mail) or die("query failed");
     } catch (Exception $e) {
         $error_mail = "UPDATE `invoices` SET `email_msg`='Invoice Not Sent' where id='" . $invoice_id . "'";
         mysqli_query($connection, $error_mail) or die("query failed");
         // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
     }
  */
    /************ END **********/
}




















// function make_pdf($invoice_id, $user_id)
// {

//     global $connection;
//     $user_select = "SELECT firstname,username,phone,credit,address,state,country,zipcode FROM `cc_card` where id='" . $user_id . "'";
//     $user_details = mysqli_query($connection, $user_select) or die("query failed : user_select");
//     if (mysqli_num_rows($user_details) > 0) {
//         $card_row = mysqli_fetch_assoc($user_details);
//         $address = $card_row['address'];
//         $state = $card_row['state'];
//         $country = $card_row['country'];
//         $zipcode = $card_row['zipcode'];
//         $phone = $card_row['phone'];
//     }

//     $item_array = array();
//     $invoice_items_sql = "SELECT * FROM `invoices_items` WHERE `invoice_id`='" . $invoice_id . "' ";
//     $invoice_items_result = mysqli_query($connection, $invoice_items_sql) or die("query failed : invoice_items_sql");
//     if (mysqli_num_rows($invoice_items_result) > 0) {
//         while ($item_row = mysqli_fetch_assoc($invoice_items_result)) {
//             $item_array[] = array('item_number' => $item_row['item_number'], 'item_type' => $item_row['item_type'], 'item_price' => $item_row['price']);
//         }
//     }
//     $sql_invoices = "SELECT * FROM `invoices` WHERE `id`='" . $invoice_id . "'";
//     $result_invoices = mysqli_query($connection, $sql_invoices) or die("query failed : sql_invoices");
//     if (mysqli_num_rows($result_invoices) > 0) {
//         $rows = mysqli_fetch_assoc($result_invoices);
//         $fetch_invoice_id = $rows['invoice_id'];
//         $fetch_date = $rows['createdDate'];
//         $fetch_total_amount = $rows['invoice_amount'];
//         $sub_total_amount = $rows['invoice_subtotal_amount'];
//     }

//     $sql_gateway = "SELECT * FROM `gateways_payments` WHERE `invoice_db_id`='" . $invoice_id . "'";
//     $res_gateway = mysqli_query($connection, $sql_gateway) or die("query failed");
//     if (mysqli_num_rows($res_gateway) > 0) {
//         $gateway_row = mysqli_fetch_assoc($res_gateway);
//         $order_id = $gateway_row['gatway_order_id'];
//         $pay_type = $gateway_row['payment_type'];
//         $email = $gateway_row['email'];
//         $txn_id = $gateway_row['transaction_id'];
//     }

//     /******* PDF create code start   **********/

//     $pdfcontent = '';
//     // Take PDF contents in a variable
//     $pdfcontent .= '<html>
//     <head>
//         <style type="text/css">
//             th {align=left; width=225px; border-bottom: solid 2px black;}
//             @page { margin: 20px;}
//             *
// {
//     border: 0;
//     box-sizing: content-box;
//     color: inherit;
//     font-family: inherit;
//     font-size: inherit;
//     font-style: inherit;
//     font-weight: inherit;
//     line-height: inherit;
//     list-style: none;
//     margin: 0;
//     padding: 0;
//     text-decoration: none;
//     vertical-align: middle;
// }
// body{margin: 20px;
//     padding: 20px;}
// /* content editable */
// *[contenteditable] { border-radius: 0.25em; min-width: 1em; outline: 0; }
// *[contenteditable] { cursor: pointer; }
// *[contenteditable]:hover, *[contenteditable]:focus, td:hover *[contenteditable], td:focus *[contenteditable], img.hover { background: #DEF; box-shadow: 0 0 1em 0.5em #DEF; }
// span[contenteditable] { display: inline-block; }
// /* heading */
// h1 { font: bold 100% sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; }
// /* table */
// table { font-size: 75%; table-layout: fixed; width: 100%; }
// table { border-collapse: separate; border-spacing: 2px; }
// th, td { border-width: 0px; padding: 0.5em; position: relative; text-align: left; }
// th, td { border-radius: 0.25em; border-style: solid; }
// th { background: #EEE; border-color: #BBB; }
// td { border-color: #DDD; }
// /* page */
// html { font: 16px/1 \'Open Sans\', sans-serif; overflow: auto; padding: 0.5in; }
// html { background: #999; cursor: default; }
// body { box-sizing: border-box; height: 11in; margin: 0 auto; overflow: hidden; padding: 0.5in; width: 8.5in; }
// body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }
// /* header */
// header { margin: 0 0 3em; }
// header:after { clear: both; content: ""; display: table; }
// header h1 { background: #03A9F4; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; }
// header address { float: left; font-size: 75%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; }
// header address p { margin: 0 0 0.25em; }
// header span, header img { display: block; float: right; }
// header span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
// header img { max-height: 100%; max-width: 100%; }
// header input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }
// /* article */
// article, article address, table.meta, table.inventory { margin: 0 0 3em; }
// article:after { clear: both; content: ""; display: table; }
// article h1 { clip: rect(0 0 0 0); position: absolute; }
// article address { float: left; font-size: 125%; font-weight: bold; }
// /* table meta & balance */
// table.meta, table.balance { float: right; width: 36%; }
// table.meta:after, table.balance:after { clear: both; content: ""; display: table; }
// /* table meta */
// table.meta th { width: 40%; }
// table.meta td { width: 60%; }
// /* table items */
// table.inventory { clear: both; width: 100%; }
// table.inventory th { font-weight: bold; text-align: center; }
// table.inventory td:nth-child(1) { width: 26%; }
// table.inventory td:nth-child(2) { width: 38%; }
// table.inventory td:nth-child(3) { text-align: right; width: 12%; }
// table.inventory td:nth-child(4) { text-align: right; width: 12%; }
// table.inventory td:nth-child(5) { text-align: right; width: 12%; }
// /* table balance */
// table.balance th, table.balance td { width: 50%; }
// table.balance td { text-align: right; }
// /* aside */
// aside h1 { border: none; border-width: 0 0 1px; margin: 0 0 1em; }
// aside h1 { border-color: #999; border-bottom-style: solid; }
// .border1{border:1px solid #999;}
// .tbmain{border:1px solid #999;}
//         </style>
//     </head>
//     <body>
//     <header>
//         <h1>Call Analog Invoice</h1>
//         </header>
//         <table>
//             <tr>
//             <td colspan="2"><b>Payment Details</b></td>
//                 <td align=right><b>Invoice ID #</b> :' .
//         $fetch_invoice_id;
//     $pdfcontent .= '</td>
//             </tr>
//             <tr>
//                 <td colspan="2"><b>Order ID</b>:' .
//         $order_id;
//     $pdfcontent .= '</td>
//                 <td align=right><b>Invoice Date</b> :' .
//         $fetch_date;
//     $pdfcontent .= '</td>
//             </tr>
//             <tr>
//                 <td colspan="2"><b>Payment Type</b>:' .
//         $pay_type;
//     $pdfcontent .= '</td>
//                 <td align=right><b>Address:</b>' .
//         $address . "<br>" . $state . " " . $country . "<br>" . $zipcode;

//     $pdfcontent .= '</td>
//             </tr>
//             <tr>
//                 <td colspan="2"></td>
//                 <td align=right><b>Phone:</b>' .
//         $phone;
//     if ($pay_type == 'Pay') {
//         $pdfcontent .= '<tr>
//                     <td colspan="2"><b>Transaction ID</b>:' .
//             $txn_id;
//     }
//     $pdfcontent .= '</td>
//             </tr>
//         </table>
//         <br />
//         <br />
//         <br />
//         <table width="100%" class="tbmain">
//             <tr>
//                 <th align=center>Item</th>
//                 <th align=center>Number</th>
//                 <th align=center>Description</th>
//                 <th align=center>Rate</th>
//                 <th align=center>Quantity</th>
//                 <th align=center>Price</th>
//             </tr>';
//     $i = 1;
//     foreach ($item_array as $key => $item) {
//         $pdfcontent .= '<tr>
//                 <td align=center>' . $i . '</td>
//                 <td align=center>' . $item['item_number'] . '</td>
//                 <td align=center>' . $item['item_type'] . '</td>
//                 <td align=center>' . $item['item_price'] . '</td>
//                 <td align=center>1</td>
//                 <td align=center>' . $item['item_price'] . '</td>
//             </tr>';
//         $i++;
//     }
//     $pdfcontent .= '</table>
//         <br />
//         <br />
//         <br />
//         <hr>
//         <table>
//                 <tr>
//                 <td rowspan=2 colspan=4><img alt="" src="resources/images/logo.png" width="100px" height="80px"></td>
//                     <th class="border1" align="right"><span contenteditable >Total</span></th>
//                     <td class="border1"><span data-prefix>$</span><span>' .
//         $fetch_total_amount;
//     $pdfcontent .= '</span></td>
//                 </tr>
//                 <tr>';
//     if ($item['item_type'] != 'Wallet Credit') {
//         $pdfcontent .= '
//                     <th class="border1" align="right"><span contenteditable>Amount Paid</span></th>
//                     <td class="border1"><span data-prefix>$</span><span contenteditable>' .
//             $sub_total_amount;
//     }
//     $pdfcontent .= '</span></td>
//                 </tr>
//             </table>
//         <br />
//         <br />
//     <aside>
//             <h1><span contenteditable>Additional Notes</span></h1>
//             <div contenteditable>
//                 <p>A finance charge of 1.5% will be made on unpaid balances after 30 days.</p>
//             </div>
//         </aside>
//     </body>
// </html>';

//     global $mpdf;

//     $mpdf->WriteHTML($pdfcontent);

//     $mpdf->SetDisplayMode('fullpage');
//     $mpdf->list_indent_first_level = 0;

//     //call watermark content and image
//     $mpdf->SetWatermarkText('Call Analog');
//     $mpdf->showWatermarkText = true;
//     $mpdf->watermarkTextAlpha = 0.1;
//     $file_name = "invoice_" . date('YmdHis') . ".pdf";
//     $pdfFilePath = 'invoice_pdf/' . $file_name;
//     //output in browser
//     $mpdf->Output($pdfFilePath, 'F'); // SAVE in FOLDER		


//     $update_invoice = "update `invoices` set invoice_file='" . $file_name . "' where id='" . $invoice_id . "'";
//     $invo_details = mysqli_query($connection, $update_invoice);

//     // Mail pdf to the user

//     $mail = new PHPMailer(true);
//     try {
//         // $mail->SMTPDebug = 2;                                      
//         $mail->isSMTP();
//         $mail->Host = HOST;
//         $mail->SMTPAuth = true;
//         $mail->Username = EMAIL;
//         $mail->Password = PASSWORD;
//         $mail->SMTPSecure = 'tls';
//         $mail->Port = PORT;

//         $mail->setFrom(EMAIL, MYPHONE);
//         $mail->addAddress($email);

//         $mail->isHTML(true);
//         $mail->Subject = 'Invoice';
//         $mail->Body = "Your Invoice";
//         $mail->AddAttachment($pdfFilePath, $file_name);
//         $mail->AltBody = 'Body in plain text for non-HTML mail clients';
//         $mail->send();
//         // echo "Invoice has been sent successfully!";
//         $success_mail = "UPDATE `invoices` SET `email_status`='1', `email_msg`='Invoice Sent Successfully' where id='" . $invoice_id . "'";
//         mysqli_query($connection, $success_mail) or die("query failed");
//     } catch (Exception $e) {
//         $error_mail = "UPDATE `invoices` SET `email_msg`='Invoice Not Sent' where id='" . $invoice_id . "'";
//         mysqli_query($connection, $error_mail) or die("query failed");
//         // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
//     }

//     /************ END **********/
// }

function timezone($serverTime)
{
    global $connection;

    $user_query = "select timezone from users_login where id = '" . $_SESSION['login_user_id'] . "'";
    $user_res = mysqli_query($connection, $user_query) or die("query failed : user_query");
    $rows = mysqli_fetch_assoc($user_res);
    $userTimezone = $rows['timezone'];
    $date = new DateTime($serverTime, new DateTimeZone('America/New_York'));
    $date->setTimezone(new DateTimeZone($userTimezone));
    $newDate = $date->format('Y-m-d H:i:s');
    return $newDate;
}

function sip_reload()
{
    include "/var/www/html/callanalog/common/lib/phpagi/phpagi-asmanager.php";
    ini_set('allow_url_include', 1);
    set_error_handler("customError", E_USER_WARNING);

    $asm = new AGI_AsteriskManager();
    if ($asm->connect('37.61.219.110', 'NikasqkR', '}Sv*54#Gu(o]g83')) {
        $result = $asm->Command("sip reload");
    }

    if ($asm->connect('85.195.76.161', 'NikasqkR', '}Sv*54#Gu(o]g83')) {
        $result = $asm->Command("sip reload");
    }

    if ($result['Response'] == 'Success') {
        $asm->disconnect();
        return true;
    } else {
        $asm->disconnect();
        return false;
    }
}

?>