<?php require_once('header.php'); 
// require_once('connection.php');
// echo"<pre>";print_r($_SESSION);die;

  
        // echo"<pre>";print_r($extname);die;
?>

<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">

<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
<h2 class="title-1"> Sip Registration List <span style="margin-left:50px;"></span></h2>

<!-- <div class="table-data__tool-right">    
<a href="clientadd.php">
<button class="au-btn au-btn-icon au-btn--blue">
<i class="fa fa-plus-circle"></i>Sip Registration</button></a>
</div> -->

</div>
</div>
</div>

<?php
if(isset($_SESSION['msg']) && $_SESSION['msg'] != ''){
    echo "<div class='text-center bg-light' style='background:lightblue; padding:5px;'><h3 class='text-white'>".$_SESSION['msg']."</h3></div>";
    unset($_SESSION['msg']);
}
?>
<div class="row">
<div class="col-md-12">

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
        
 <table>
    <tr>
        <th>Name/Username</th>
        <th>Host</th>
        <th>Dyn</th>
        <th>Forcerport</th>
        <th>Comedia</th>
        <th>ACL</th>
        <th>Port</th>
        <th>Status</th>
        <th>Description</th>
        <th>Realtime</th>
    </tr>

    <?php

$timeout = 10;
$startTime = time();

$response = "";
while (!feof($socket)) {
    $response .= fgets($socket, 4096);
    if (strpos($response, "--END COMMAND--") !== false) {
        break;
    }
    if (time() - $startTime >= $timeout) {
        fclose($socket);
        break;
    }
}

$data = array();
$lines = explode("\n", $response);
foreach ($lines as $line) {
    if (preg_match('/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)/', $line, $matches)) {
        $peerData = array(
            'Name' => $matches[1],
            'Host' => $matches[2],
            'Dyn' => $matches[3],
            'Forcerport' => $matches[4],
            'Comedia' => $matches[5],
            'ACL' => $matches[6],
            'Port' => $matches[7]
        );
        $data[] = $peerData;
    }
}

// Insert SIP peer data into the database
$destinationConn = new mysqli($destinationHost, $destinationUser, $destinationPass, $destinationDb);

// Check connection
if ($destinationConn->connect_error) {
    die("Connection failed: " . $destinationConn->connect_error);
}

foreach ($data as $peerData) {
    $peerName = $peerData['Name'];
    $peerHost = $peerData['Host'];
    $peerPort = $peerData['Port'];
    $status = $peerData['Status'];
    
    $insertQuery = "INSERT INTO sip_peers (`name`, `host`, `port`, `status`) VALUES ('$peerName', '$peerHost', '$peerPort', '$status')";
    if ($destinationConn->query($insertQuery) === TRUE) {
        echo "Record inserted successfully.\n";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $destinationConn->error;
    }
}

$destinationConn->close();



    $file = fopen("manisha.txt", "r");
    if ($file) {
        while (($line = fgets($file)) !== false) {
            if (strpos($line, "/") !== false) {
                $fields = explode(" ", $line);
                echo "<tr>";
                foreach ($fields as $field) {
                    echo "<td>" . trim($field) . "</td>";
                }
                echo "</tr>";
            }
        }
        fclose($file);
    }
    ?>
    
<pre>
<?php
$file = fopen("manisha.txt", "r");
if ($file) {
    while (($line = fgets($file)) !== false) {
        echo $line;
    }
    fclose($file);
}
?>
</pre>
        </div>
        
        <!-- Script -->
        <script>
        $(document).ready(function(){
            $('#empTable').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'sipregistration_peers.php'
                },
                'columns': [
					{ data: 'name' },
                    { data: 'host' },
                    { data: 'dyn' },
                    { data: 'forcerport' },
                    { data: 'comedia' },
                    { data: 'acl' },
                    { data: 'port' },
                    { data: 'status' },
                    { data: 'description' },
                    { data: 'realtime' },

                ]
            });
        });
        </script>
		
		<br>
<br>
<br>
</div>
    </div>
    </div>
    </div>
	  </div>

<?php require_once('footer.php'); ?> 
 
