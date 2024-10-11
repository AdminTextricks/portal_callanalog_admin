<?php 
require_once('header.php'); 

$query_client = "SELECT Client.clientName,Client.clientEmail, Client.clientId FROM `Client` LEFT JOIN `users_login` ON Client.clientId = users_login.clientId WHERE users_login.role !=4 and users_login.status = 'Active' and users_login.deleted = '0'";
$result_client = mysqli_query($connection, $query_client);

if(isset($_POST['selectedUser'])) { 
	$query_user = "select * from users_login where clientId='".$_POST['clientId']."'";
	$result_user_login = mysqli_query($connection , $query_user);
}
$message = '';
if($_SESSION['userroleforpage'] == '2'){
	$_POST['clientId'] = $_SESSION['userroleforclientid'];
	$_POST['selectedUser']= $_SESSION['login_user_id'];
}
if(isset($_POST['submit']))
{	
	$created_at = date('Y-m-d h:i:s');
	$updated_at = date('Y-m-d h:i:s');
	if($_POST['music'] == ''){
		$rec_msg = "Please Select one recording type.!";
	}else{
	//echo '<pre>'; print_r($_FILES); echo '</pre>'; //exit;
	$error = 'false';
	
	if(!empty($_FILES['uploadfile']['name'])){
		$recName = str_replace(" ","_",strtolower($_POST['name']));
		$filename = str_replace(" ","_",$_FILES["uploadfile"]["name"]);
		$tempname = $_FILES["uploadfile"]["tmp_name"];
		$folder = "./assets/audio/".$filename;
		$dbfilename =  pathinfo($filename,PATHINFO_FILENAME);
		$dbfilepath = pathinfo($filename, PATHINFO_EXTENSION);
		// Check file size
		if ($_FILES["uploadfile"]["size"] > 300000) {
			$sizeErr="Sorry, your Audio size is too large";
			$error = 'true';
		}
		if($error == 'false'){
			if(!move_uploaded_file($tempname,$folder)){
				$error = 'true';
			}
		}
	}else if(!empty(isset($_POST['message'])))
	{
		$txt2 = !empty($_POST['message']) ? $_POST['message'] : '';
		$txt=preg_replace('/\s+/', '', $txt2);
		$voice = !empty($_POST['voice']) ? $_POST['voice'] : '';
		$values = explode("|",$voice);
		$value['list']=$values['0'];
		//    $list=''.$voice['voice'].'';
		$lang =$value['list'];
		// $lang =$list;
		$recName = str_replace(" ","_",strtolower($_POST['name']));
		$dbfilename = $recName.date("ymdhis"); // use for store value in database.//
		$txt=htmlspecialchars($txt);
		$txt=rawurlencode($txt);
		$file = "assets/audio/".str_replace(" ","_",$dbfilename).".mp3";
		$filename = $txt.".mp3"; // use for store value in database.//
		$dbfilepath = "mp3";
		
		if (!is_dir("assets/audio/")){
			mkdir("assets/audio/");
		}else{
			if (substr(sprintf('%o', fileperms('audio/')), -4) != "0777"){
				chmod("assets/audio/", 0777);
			}				
		}
		$audio=file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$txt.'&tl='.$lang.'');
		$test="<source src='data:audio/mpeg;base64,".base64_encode($audio)."'>";
		$picture="<audio controls='controls' autoplay> ".$test."</audio>";
		$newaudiofile= file_put_contents($file, $audio);
		//$data['speech']=$test;
		//print_r($audio);   
	}

	if($error == 'false'){
		$insert_recording = "INSERT INTO music(clientId, user_id, `name`, `upload_music`,`file_ext`,`music_text`) VALUES ('".$_POST['clientId']."','".$_POST['selectedUser']."', '".$recName."','".$dbfilename."','".$dbfilepath."','".$_POST['message']."')";
		// echo $insert_recording; exit;
		$result_recording = mysqli_query($connection , $insert_recording);
		if($result_recording){

			if($_SESSION['userroleforpage']=='1'){
				$activity_type = 'Recording Assign to  User';
				$msg = 'Recording: '.$filename.' '.'Recording Added Succesfully! By Admin';
			}else{
				$activity_type = 'Recording Added By User';
				$msg = 'Recording: '.$filename.' '.'Recording Added Succesfully! By User';
			}
			user_activity_log($_POST['selectedUser'],$_POST['clientId'], $activity_type, $msg);
			$_SESSION['msg'] = 'Recording Information Added Succesfully!';
			echo '<script>window.location.href="recording.php"</script>';
		}
	}else{
		$message = 'Error occurred in adding Recording!';
	}
	
}
	
}
?>

<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="overview-wrap">
				<h2 class="title-1">Recording Add<span style="margin-left:50px;color:blue;"><?php echo $message; ?></span></h2>
				<div class="table-data__tool-right">
					<a href="recording.php">
						<button class="au-btn au-btn-icon au-btn--green au-btn--small">
					<i class="fa fa-eye" aria-hidden="true"></i>Recording</button></a>
				</div>
			</div>
		</div>
	</div>

<div class="big_live_outer">
<div class="row">
    <div class="col-md-12">
        <div class="queue_info">
            <form id="recordingForm" autocomplete="off" class="forms-sample" action="" method="post" enctype="multipart/form-data">
			<?php //echo '<pre>'; print_r($_SESSION); echo '</pre>'; 
			if($_SESSION['userroleforpage'] == '1'){  ?>
				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Client Name</label>
					</div>
					<div class="col-12 col-md-8">
						<select id="clientId" name="clientId"  data-show-subtext="false" data-live-search="true" class="form-control selectpicker" required>
							<option value="">Select</option>
							<?php while($row = mysqli_fetch_array($result_client)){ ?>
							<option value="<?php echo $row['clientId']; ?>"
							<?php if($row['clientId'] == $_POST['clientId']){ echo 'selected';} ?>
							><?php echo $row['clientName'].'/'.$row['clientEmail']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>			
				
				
				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class="form-control-label">Select User*</label>
					</div>
					<div class="col-12 col-md-8">
						<select id="selectedUser" name="selectedUser"  class="form-control" required >
							<?php 
							if(isset($_POST['selectedUser'])) {
								while($row_user = mysqli_fetch_array($result_user_login)){ ?>
								<option value="<?php echo $row_user['id']; ?>"
								<?php if($row_user['id'] == $_POST['selectedUser']){ echo 'selected'; } ?>
								><?php echo $row_user['name']; ?></option>
								<?php }
						 	} ?>
						</select><input type="hidden" name="_selectedUser" value="1"/>
					</div>
				</div>
				<?php }else{ ?>	
					<input id="clientId" name="clientId" value="<?php echo $_SESSION['userroleforclientid']; ?>" type="hidden">
					<input id="selectedUser" name="selectedUser" value="<?php echo $_SESSION['login_user_id']; ?>" type="hidden">

				<?php } ?>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class="form-control-label">Name</label>
					</div>
					<div class="col-12 col-md-8">
						<input type="text" class="form-control" id="name" name="name" value="<?php if(isset($_POST['name'])){ echo $_POST['name']; }else{ echo "";} ?>" placeholder="" required>
					</div>
				</div>	
			
                                    
				<div class="form-group row">
					<div class="col col-md-4">
						<label for="ext" class="form-control-label">Select Recording Type</label>
					</div>
					<div class="col-sm-8">
						<input type="radio" id="Uploadmusic" name="music" value="upload"
							onclick="upload();">
						<label for="Uploadmusic" style="color:#000;">Upload Recording</label> <br>
						<input type="radio" id="Createmusic" name="music" value="recording"
							onclick="recording()">
						<label for="Createmusic" style="color:#000;">Create Recording</label> <br>
						<span style="font-size:15px;color:red;" id="rec_msg"><b>
								<?php if (isset($rec_msg)) {
									echo $rec_msg;
								} else {
									echo '';
								} ?>
							</b></span>
					</div>
				</div>
     
				<div id="musicshide" style="display:none">		
					<div class="form-group row">
						<div class="col col-md-4">
							<label for="ext" class="form-control-label">Input Text</label>
						</div>
						<div class="col-sm-6">
						<input id="messagee" name="message" placeholder="" class="form-control" type="text" value="<?php if(isset($_POST['message'])) { echo $_POST['message']; } else { echo ''; } ?>"/>
							
						</div>
						<div class="col col-md-2">
							<button type="button" class="btn btn-primary" id="generate_button" onclick="clickcheck()">Generate</button>
						</div>
					</div>
					<div class="form-group row">
						<div class="col col-md-4">							
						</div>
						<div class="col col-md-8">
							<div id="speech"></div>
							<div id="speeak"></div>
						</div>
					</div>
					<div class="form-group row">     
						<div class="col col-md-4">
							<label for="ext" class="form-control-label">Choose voice</label>
						</div>
						<div class="col-sm-8">
							<select id="voices" name="voice" class="form-control-sm form-control"></select>
						</div>
						<div id="modal1" class="modal">
							<h4>Speech Synthesis not supported</h4>
							<p>Your browser does not support speech synthesis.</p>
							<p>We recommend you use Google Chrome.</p>
							<div id="speech"></div>
						</div>
					</div>
				</div>      
              
				<div id="uploadfile" style="display:none">
					<div class="form-group row">
						<div class="col col-md-4">
							<label for="ext" class="form-control-label">upload file</label>
						</div>
						<div class="col-sm-8">
							<input class="form-control" type="file" id="file" name="uploadfile">
						</div>
					</div>
				</div>			
				<div class="form-group row pull-right">
					<input type="hidden" id="id" name="id" value="">
					<button type="submit" class="btn btn-primary me-2" name="submit" value="submit_usertype">Submit</button>				
				</div>
			</form>	
        </div>
    </div>
    </div>
</div>
</div>
</div>
</div>

<script>
    function upload(){
    	document.getElementById('uploadfile').style.display="block";   
    	document.getElementById('musicshide').style.display="none";      
    } 

    function recording(){
    	document.getElementById('musicshide').style.display="block";
    	document.getElementById('uploadfile').style.display="none";
                // alert("test");
    } 
</script>

<script>
	$( "select[name='clientId']" ).change(function () {
    var clientsID = $(this).val();
	if(clientsID) {
        $.ajax({
            url: "ajaxpro.php",
            dataType: 'Json',
            data: {'id':clientsID},
            success: function(data) {
                $('select[name="selectedUser"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="selectedUser"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
            }
        });
    }else{
        $('select[name="selectedUser"]');
		$.each(data, function(key, value) {
            $('select[name="selectedUser"]').append('<option value="'+ key +'">'+ value +'</option>');
        });
    }
});
</script>
<script>
$(function(){

 if ('speechSynthesis' in window) {
  
    speechSynthesis.onvoiceschanged = function() {
      var $voicelist = $('#voices');

      if($voicelist.find('option').length == 0) {
        speechSynthesis.getVoices().forEach(function(voice, index) {
          var $option = $('<option>').val(voice.lang + "|"+index).html(voice.name + (voice.default ? ' (default)' :''));
          $voicelist.append($option);
		  // getvoice=$voicelist;          
        });      
      }
    }
 }

});

function clickcheck(){  
    var message = document.getElementById('messagee').value;
    var voice = document.getElementById("voices").value;

     if(message!=''){
     
      $.ajax({
          method: "POST",
          // dataType: 'json',      
          data: {message:message,voice:voice},
          url: "ajaxtexttospeech.php",          
          success: function(data){
            $("#speeak").html(data);
       
          },
          error: function(xhr, error) {
          alert(error);
        }
      });
    }else{
    
     }
     }
   
</script>
<script>
$(document).ready(function(){
	$("input[type=radio][name='music']").change(function(){
		$("#rec_msg").fadeOut();
		var value = $(this).val();
		if(value == 'upload'){
			$("#file").attr("required","true");
		}else{
			$("#messagee").attr("required","true");
		}
	});
});
</script>


<script>
    $('#speak').click(function(){
        // var mp3;
      var text = $('#messagee').val();
      var msg = new SpeechSynthesisUtterance();
      var voices = window.speechSynthesis.getVoices();
     
      msg.voice = voices[$('#voices').val()];
 
      msg.text = text;
   
      msg.onend = function(e) {
        console.log('Finished in ' + event.elapsedTime + ' seconds.');
      };

     speechSynthesis.speak(msg);
    });
  
</script>

<script>
   function changevoiceid() {
            var location = $("#inputlanguage").val();
            $(".voices").hide();
            if (location == "en-AU") {
                $(".nicolefemale").show();
                $("#nicolefemale").attr("checked", true);
                $(".russellmale").show();
            } else if (location == "en-GB") {
                $(".emmafemale").show();
                $("#emmafemale").attr("checked", true);
                $(".amyfemale").show();
                $(".brianmale").show();
            } else if (location == "en-IN") {
                $(".raveenafemale").show();
                $("#raveenafemale").attr("checked", true);
                $(".aditifemale").show();
            } else if (location == "en-US") {
                $(".sallifemale").show();
                $("#sallifemale").attr("checked", true);
                $(".kimberlyfemale").show();
                $(".kendrafemale").show();
                $(".joannafemale").show();
                $(".ivyfemale").show();
                $(".matthewmale").show();
                $(".justinmale").show();
                $(".joeymale").show();
            } else if (location == "en-GB-WLS") {
                $(".geriantmale").show();
                $("#geriantmale").attr("checked", true);
            }
          }
          changevoiceid();

$(document).ready(function () {
    $("audio").bind("contextmenu", function () {
        return false;
    });
});

</script>

<?php require_once('footer.php'); ?> 
