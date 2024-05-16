 <?php 
      require_once('connection.php');
     


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
        $response_arr = array();
        $i=1;
        while (!feof($socket)) {
            $response = fgets($socket, 4096);

            if(strpos($response, "Output: ")!== false ){
                $res_str = str_replace("Output: ", "", $response);
                $output = preg_replace('/\s+/', ' ', $res_str);
                $response_arr[] = explode(" ",$output);
            }

            
            if (strpos($response, "--END COMMAND--") !== false) {
                break;
            }
            if (time() - $startTime >= $timeout) {
                // If the timeout has been reached, close the socket and exit the loop
                fclose($socket);
                break;
            }
            $i++;
        }

        
         echo"<pre>";print_r($response_arr);die;

        ## Total number of records without filtering
/* $sel = mysqli_query($con,"select count(*) as allcount from cc_sip_buddies");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel1 = "SELECT count(*) as allcount FROM cc_sip_buddies WHERE 1 ".$searchQuery;
$selll = mysqli_query($con,$sel1);
$recordss = mysqli_fetch_assoc($selll);
$totalRecordwithFilter = $recordss['allcount'];
   
 */
        ?>