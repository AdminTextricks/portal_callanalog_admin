 <?php 
      require_once('connection.php');
      $draw = $_POST['draw'];
      $row = $_POST['start'];
      $rowperpage = $_POST['length']; // Rows display per page
      $columnIndex = $_POST['order'][0]['column']; // Column index
      $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
      $searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value
      
      ## Search 
      $searchQuery = " ";
      if($searchValue != ''){
          $searchQuery = " and (name like '%".$searchValue."%' or 
              host like '%".$searchValue."%' or 
              dyn like '%".$searchValue."%' or 
              forcerport like '%".$searchValue."%' or 
              comedia like '%".$searchValue."%' or 
              port like '%".$searchValue."%' or 
              status like '%".$searchValue."%' or 
              realtime like'%".$searchValue."%' ) ";
      }



       $host = 'localhost';
        $port = 5038;
        $username = 'cron';
        $password = '1234';
        $errno  = '';
        $errstr = '';
        // Connect to the AMI
        $socket = fsockopen($host, $port, $errno, $errstr, 10);
        
        // echo"<pre>";print_r($socket);die;

        if (!$socket) {
            die("Unable to connect to AMI: $errstr ($errno)");
        }
        // Log in to the AMI
        fwrite($socket, "Action: Login\r\n");
        fwrite($socket, "Username: $username\r\n");
        fwrite($socket, "Secret: $password\r\n");
        fwrite($socket, "\r\n");

        // Wait for the response and check if login was successful
        $response = "";
        while (!feof($socket)) {
            $response .= fgets($socket, 4096);
            if (strpos($response, "Message: Authentication accepted") !== false) {
                break;
            }
        }
        if (strpos($response, "Response: Success") === false) {
            die("Unable to log in to AMI: $response");
        }

        // Send the "sip show peers" command
        fwrite($socket, "Action: Command\r\n");
        fwrite($socket, "Command: sip show peers\r\n");
        fwrite($socket, "\r\n");
        // echo"<pre>";print_r($socket);die;

        // Wait for the response and extract the SIP peers
        $timeout = 10;
        $startTime = time();

        $response = "";
        while (!feof($socket)) {
            $response .= fgets($socket, 4096);
            if (strpos($response, "--END COMMAND--") !== false) {
                break;
            }
            if (time() - $startTime >= $timeout) {
                // If the timeout has been reached, close the socket and exit the loop
                fclose($socket);
                break;
            }
        }
        // echo"<pre>";print_r($response);die;

        ## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from cc_sip_buddies");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel1 = "SELECT count(*) as allcount FROM cc_sip_buddies WHERE 1 ".$searchQuery;
$selll = mysqli_query($con,$sel1);
$recordss = mysqli_fetch_assoc($selll);
$totalRecordwithFilter = $recordss['allcount'];
   
       if($_SESSION['userroleforpage'] == 1){
        $query_ext1 =  "SELECT * FROM `cc_sip_buddies` WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
  
       }else{
        $query_ext1 =  "SELECT * FROM `cc_sip_buddies` WHERE `id_cc_card` = '".$_SESSION['login_user_id']."'".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
       }
        $query_ext= mysqli_query($con, $query_ext1);
        // $mainresult= mysqli_fetch_assoc($query_ext);
        // $extname = $mainresult['name'];
        // echo"<pre>";print_r($extname);die;

        $data = array();
        while ($row = mysqli_fetch_array($query_ext)) {
            // $mainresult= mysqli_fetch_assoc($query_ext);
            $extname = $row['name'];
        // Loop through each extension for this client
        if(!empty($extname)){
        // foreach ($extname as $extension) {
            $Exname = $extname.'/'.$extname;
            $lines = explode("\n", $response);
            foreach ($lines as $line) {
                if (strpos($line, "Cached RT") !== false) {
                    $columns = preg_split('/\s+/', $line);
    
                    if($columns[1] == $Exname){
                        $data[] = array(
                            "name" => $columns[1],
                            "host" => $columns[2],
                            "dyn" => $columns[3],
                            "forcerport" => $columns[4],
                            "comedia" => $columns[5],
                            "acl" => $columns[6],
                            "port" => $columns[7],
                            "status" => implode(" ", array_slice($columns, 8)),
                            "description" => $columns[9],
                            "realtime" => implode(" ", array_slice($columns, 10))
                        );
                    }
                }
            }
        }
    } 
 


    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "data" => $data
    );
    
    echo json_encode($response);
        ?>