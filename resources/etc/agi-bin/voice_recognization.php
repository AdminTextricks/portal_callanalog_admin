#!/usr/local/bin/php -q
<?PHP
	// Include the PHPAGI class
	require('/var/lib/asterisk/agi-bin/phpagi.php');
	// Include the mail function
	include('/var/lib/asterisk/agi-bin/mailer.php');

	// SQL Query Helper Function
	function sqlQuery($query)
	{
		global $mySql;
		$data = null;
		$result = mysql_query($query, $mySql);
			
		# This set's up an associative array (key->value pair) for all of the data returned
		if (sizeof($result) > 0)
		{
			$num_fields = mysql_num_fields($result);
			$row_cnt = 0;
			while ($row_data = mysql_fetch_array($result)) {
				for ($cnt = 0; $cnt < $num_fields; $cnt++) {
					$field_name = mysql_field_name($result, $cnt);
					$data[$row_cnt][$field_name] = $row_data[$cnt];
				}
				$row_cnt++;
			}
		}
		return $data;
	}	

	// A couple of variables for later use
	$welcome_back_audio = "/home/sve204/asterisk_sounds/welcome_back_audio";
	$greetings_we_have_never_met_audio = "/home/sve204/asterisk_sounds/greetings_we_have_never_met_audio";
	$please_record_your_name_audio = "/home/sve204/asterisk_sounds/please_record_your_name_audio";
	$where_would_you_like_to_go_audio = "/home/sve204/asterisk_sounds/where_would_you_like_to_go_audio";
	$names_location = "/home/sve204/public_html/names/";

	// Create an AGI Object
	$agi = new AGI();

	// Predefined AGI Variables, send them to the Asterisk console for debugging
	$agi->conlog($agi->request["agi_request"]);
	$agi->conlog($agi->request["agi_channel"]);
	$agi->conlog($agi->request["agi_language"]);
	$agi->conlog($agi->request["agi_uniqueid"]);
	$agi->conlog($agi->request["agi_callerid"]);
	$agi->conlog($agi->request["agi_dnid"]);
	$agi->conlog($agi->request["agi_rdnis"]);
	$agi->conlog($agi->request["agi_context"]);
	$agi->conlog($agi->request["agi_extension"]);
	$agi->conlog($agi->request["agi_priority"]);
	$agi->conlog($agi->request["agi_enhanced"]);
	$agi->conlog($agi->request["agi_accountcode"]);
	$agi->conlog($agi->request["agi_network"]);
	$agi->conlog($agi->request["agi_network_script"]);

	// Database connection variables
	$hostname = "itp.nyu.edu";
	$dbname = "sve204";
	$username = "sve204";
	$password = "xxx";
               
	// Connect to the database 
	$mySql = mysql_connect($hostname, $username, $password) or die (mysql_error());
	mysql_select_db($dbname, $mySql) or die(mysql_error());

	// Query the database to see if this caller has called before
	$query = "select id, caller_id, last_call_time, name_audio from callers where caller_id = '" . $agi->request["agi_callerid"] . "'";
	
	$result = sqlQuery($query, $mySql);
	if (sizeof($result) > 0)
	{
		$agi->conlog("Database ID: " . $result[0]['id']);

		// We got a result from the database, play welcome message
		$agi->stream_file($welcome_back_audio);
		$agi->stream_file($result[0]['name_audio']);
		// get_data is similar to the Dialplan command Background
		// it plays the audio file, has a timeout in milliseconds and a max number of digits to receive
		$whereto = $agi->get_data($where_would_you_like_to_go_audio, 10000, 2);

		// $whereto['result'] is the digits that are pressed
		// send them to the console for debugging
		// say them for debugging
		if (is_numeric($whereto['result']))
		{
			$agi->conlog("Result: " . $whereto['result']); 
			$agi->say_number($whereto['result']);

			// Save as the Goto Dialplan command
			$agi->goto("redial_sve204",$whereto['result'],1);
		}
		else
		{
			// Timeout.. Probably
			$agi->goto("redial_sve204","t",1);
		}
	}
	else
	{
		// We don't know this person, let's get them to record their name
		$agi->stream_file($greetings_we_have_never_met_audio);
		$agi->stream_file($please_record_your_name_audio);

		$record_file = $names_location . "name_" . $agi->request["agi_callerid"];	
		$agi->record_file($record_file, "WAV", "0123456789", 10000, 0, true, 5);

		// Insert this into the database	
		$query = "insert into callers (caller_id, name_audio) values ('" . $agi->request["agi_callerid"] . "', '" . $record_file . "')";
		$insert_result = mysql_query($query, $mySql);

		$whereto = $agi->get_data($where_would_you_like_to_go_audio, 10000, 2);
		if (is_numeric($whereto['result']))
		{
				$agi->conlog("Result: " . $whereto['result']);
				$agi->say_number($whereto['result']);

				$subject = "New Caller: " . $agi->request["agi_callerid"];
				$body = $agi->request["agi_callerid"] . " Has recorded their name.  Check the attachment or visit this page: http://asterisk.itp.tsoa.nyu.edu/~sve204/callers.php";
	
				$success = mailAttachment("Shawn.Van.Every@nyu.edu", "vanevery@walking-productions.com", $subject, $body, $record_file . ".WAV");

				// Same as the Goto Dialplan command
				$agi->goto("redial_sve204",$whereto['result'],1);
		}
		else
		{
				// Timeout.. Probably
				$agi->goto("redial_sve204","t",1);
		}
	}
?>
