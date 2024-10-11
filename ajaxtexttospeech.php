<?php 
require_once('connection.php'); 
// connect to DB

$txt = !empty($_POST['message']) ? $_POST['message'] : '';
$voice = !empty($_POST['voice']) ? $_POST['voice'] : '';
$values = explode("|",$voice);
$value['list']=$values['0'];
$lang = $value['list'];

if(isset($txt)){
    $txt = htmlspecialchars($txt);
    $txt = rawurlencode($txt);
    $audio = file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$txt.'&tl='.$lang.'');
    
    
    $file = 'assets/audio/'.$txt.'.mp3';
    chmod($file, 0777);
    file_put_contents($file, $audio);
   
    $test = "<source src='data:audio/mpeg;base64,".base64_encode($audio)."'>";
    $speech = "<audio controls='controls' autoplay>".$test."</audio>";
    
    
    print_r($speech); 
}
?>
