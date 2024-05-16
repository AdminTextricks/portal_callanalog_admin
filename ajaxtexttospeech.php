<?php 
 require_once('connection.php'); 
// connect to DB

$txt = !empty($_POST['message']) ? $_POST['message'] : '';
$voice = !empty($_POST['voice']) ? $_POST['voice'] : '';
$values = explode("|",$voice);
$value['list']=$values['0'];

//    $list=''.$voice['voice'].'';
$lang =$value['list'];
 if(isset($txt)){
     $txt=htmlspecialchars($txt);
     $txt=rawurlencode($txt);
     $data=array();
     $audio=file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$txt.'&tl='.$lang.'');
     $test="  <source src='data:audio/mpeg;base64,".base64_encode($audio)."'>";
     $speech="<audio controls='controls' autoplay> ".$test."</audio>";
 //   $newaudiofile= file_put_contents($file, $audio);
   
     
    print_r($speech); 
 }

?>
