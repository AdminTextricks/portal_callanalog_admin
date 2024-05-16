<?php
require_once ('connection.php');
include "/var/www/html/callanalog/common/lib/phpagi/phpagi-asmanager.php";

$draw = $_POST['draw'];
$rowperpage = $_POST['length']; // Rows display per page
$searchValue = mysqli_real_escape_string($con, $_POST['search']['value']); // Search value

## Search
$searchQuery = " ";
if ($searchValue != '') {
    $searchQuery = " and (cc_sip_buddies.name like '%" . $searchValue . "%' or 
    Client.clientName like '%" . $searchValue . "%' or
    cc_sip_buddies.agent_name like '%" . $searchValue . "%' or
    users_login.email like '%" . $searchValue . "%') ";
}
$server_ip = "37.61.219.110";
// $socket = @fsockopen($server_ip, 5038);
$socket = @fsockopen($server_ip, 4783);
$response = "";
if (!is_resource($socket)) {
    echo "conn failed in Engconnect ";
    exit;
}
fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: NikasqkR\r\n");
fputs($socket, "Secret: }Sv*54#Gu(o]g83\r\n\r\n");
fputs($socket, "Action: Command\r\n");
fputs($socket, "Command: sip show peers\r\n\r\n");
fputs($socket, "Action: Logoff\r\n\r\n");
while (!feof($socket))
    $response .= fread($socket, 8192);
// $response .= fread($socket, 4783);
fclose($socket);
// $response = file_get_contents('sipregistration-list-sip.txt');

if ($_SESSION['userroleforpage'] == 1) {
    $query_ext1 = "SELECT cc_sip_buddies.`id_cc_card`,cc_sip_buddies.`name` FROM `cc_sip_buddies` JOIN `Client` ON cc_sip_buddies.clientId=Client.clientId JOIN users_login ON cc_sip_buddies.id_cc_card=users_login.id WHERE 1 " . $searchQuery . " ";
} else {
    $query_ext1 = "SELECT  cc_sip_buddies.`id_cc_card`,cc_sip_buddies.`name` FROM `cc_sip_buddies` JOIN `Client` ON cc_sip_buddies.clientId=Client.clientId JOIN users_login ON cc_sip_buddies.id_cc_card=users_login.id WHERE cc_sip_buddies.`id_cc_card` = '" . $_SESSION['login_user_id'] . "' " . $searchQuery . "";
}

// echo $query_ext1;exit;
$query_ext = mysqli_query($con, $query_ext1);
// echo"<pre>";print_r($query_ext1);die;

$data = array();
$Exname = array();
if (mysqli_num_rows($query_ext) > 0) {
    while ($row = mysqli_fetch_array($query_ext)) {

        // echo '<pre>';print_r($row);
        $user_id = $row['id_cc_card'];
        $extname = $row['name'];
        // $usernameE = $row['username'];
        // $agent = $row['agent_name'];
        if (!empty($extname)) {
            $Exname[] = trim($extname);
        }
    }
}
$lines = explode("\n", $response);

foreach ($lines as $line) {
    $line = trim($line); // Remove leading/trailing whitespace 

    if (empty($line)) {
        continue; // Skip empty lines
    }

    if (strpos($line, "OK") !== false || strpos($line, "UNREACHABLE") !== false || strpos($line, "LAGGED") !== false) {
        $columns = preg_split('/\s+/', $line);

        if (strpos($columns[1], "/") !== false) {
            $columns[1] = substr($columns[1], 0, strpos($columns[1], "/"));
        }

        $ext_sql = "select clientId,agent_name,play_ivr,id_cc_card from cc_sip_buddies where name='" . $columns[1] . "'";
        $res_client = mysqli_query($connection, $ext_sql);
        $rows = mysqli_fetch_assoc($res_client);
        $clientId = $rows['clientId'];
        $agent = $rows['agent_name'];
        $phone_type = $rows['play_ivr'];
        $user_id = $rows['id_cc_card'];
        $clt_sql = "SELECT `clientName` FROM `Client` WHERE `clientId` = '" . $clientId . "'";
        $clt_res = mysqli_query($connection, $clt_sql);
        $rowss = mysqli_fetch_assoc($clt_res);
        $client_name = $rowss['clientName'];
        $usr_sql = "select email from users_login where id='" . $user_id . "'";
        $usr_res = mysqli_query($connection, $usr_sql) or die('query failed : usr_sql');
        $rowsss = mysqli_fetch_assoc($usr_res);
        $email = $rowsss['email'];

        if (in_array('D', $columns)) {
            unset($columns[3]);
            $columns = array_values($columns);
        }

        if ($phone_type == 0) {
            $user_type = "Soft Phone";
        } else {
            $user_type = "Web Phone";
        }
        if (in_array('A', $columns)) {
            unset($columns[5]);
            $columns = array_values($columns);
            // $user_type = "Soft Phone";
        } else {
            // $user_type = "Web Phone";
        }
        // echo '<pre>';print_r($columns);exit;

        if (in_array($columns[1], $Exname)) {

            // $ext_name = substr($columns[1],0,6);
            $port = $columns[5];
            if ($columns[5] == 0) {
                $port = 'Unreachable';
            }

            $status = trim($columns[6] . ' ' . $columns[7] . ' ' . $columns[8]);
            if ($port == 0 || $status == 'UNREACHABLE') {
                if ($status == 'UNREACHABLE') {
                    $statusText = $status;
                } else {
                    $statusText = "Out of Network";
                }
                $status = "<div style='background:red;padding:6px;border-radius:15px;color:white;font-weight:bold;'>" . $statusText . "</div>";
            } else {
                $status = "<div style='background:green;padding:6px;border-radius:15px;color:white;font-weight:bold;'>REACHABLE<br>".trim($columns[7] . ' ' . $columns[8])."</div>";
            }
            // echo $ext_name;exit;
            $peerData = array(

                // "Select" => '<td><input type="checkbox" class="emp_checkbox" data-emp-id="'.$columns[1].'"></td>',
                "companyName" => $client_name,
                "agent_name" => $agent . '<br>' . $email,
                "userType" => $user_type,
                "name" => $columns[1] . '/' . $columns[1],
                "host" => $columns[2],
                "forceport" => $columns[3],
                "comedia" => $columns[4],
                "port" => $port,
                "status" => $status,
                "action" => '<button type="button" onclick="return sip_unregister(' . $columns[1] . ');" class="btn btn-danger btn-sm">Unregister</button>'
            );

            $data[] = $peerData;
        }
    }
}
// echo '<pre>';
// print_r($data);
// exit;


$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "data" => $data
);

echo json_encode($response);


?>