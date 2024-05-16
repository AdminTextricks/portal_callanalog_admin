<?php

$AGI = '';
$did = '18552064674';
$ivrObj = new ivrClass();

$ivr_details = $ivrObj->getIVRFile($AGI, $did);
echo '<pre>'; print_r($ivr_details);
$ivrObj->play_ivr($AGI, $ivr_details['did'], $ivr_details['file'], $ivr_details['id_ivr'], $ivr_details['user_id']);




class ivrClass{

    public $con;

    public function __construct(){

        $this->dbConnection();
    }

    public function dbConnection(){
        $this->con = mysqli_connect("localhost", "root", "tumko34h1se", "myphonesystem");
        
    }

    public function getIVRFile($AGI, $did){

        $sql_did ="select cc_card.username, cc_card.id, cc_did.id_ivr from cc_card, cc_did where cc_card.id=cc_did.iduser and cc_did.did='".$did."' LIMIT 1";
        //$AGI->verbose("Query: $sql_did");
        $result_did = mysqli_query($this->con,$sql_did);
        $did_row    = mysqli_fetch_assoc($result_did);
        
        $username = $did_row['username'];
        //$AGI->verbose("username--: $username");
        
        $user_account_code    = $did_row['username'];
        $user_id    = $did_row['id'];
        $id_ivr     = $did_row['id_ivr'];

        //$AGI->verbose("Accountcode $user_account_code");
        //$AGI->set_variable('CDR(accountcode)', $user_account_code);

        $sql_music = "select * from music where user_id='".$user_id."' and id='".$id_ivr."' LIMIT 1";
        //$AGI->verbose("Query: $sql_music");
        $result_music = mysqli_query($this->con,$sql_music);
        $music_row  = mysqli_fetch_assoc($result_music);
        
        $ivr_name   = $music_row['name'];
        $status     = $music_row['status'];
        $file       = $music_row['upload_music'];
        $tmp        = explode(".",$file);
        $file       = $tmp[0];   
        $file       = "/var/www/html/myphonesystems/myphone/admin/assets/audio/".$file;
    //$AGI->verbose("SSSSSSSSSSSSKOIHAA");
        $retrun_aray = array(
                            'did'     => $did,
                            'file'    => $file,
                            'id_ivr'  => $id_ivr,
                            'user_id' => $user_id
                        );
        return $retrun_aray;
    }

    public function play_ivr($AGI, $did, $file, $id_ivr, $user_id)
    {
        sleep(1);

        // $AGI->verbose("START PLAY Function : $file,$id_ivr,$user_id");
        //$AGI->exec("Read","$input,$file,1,,3,10000");
        //$AGI->exec("Read", "input,$file,1,,3,30");
        //$AGI->verbose("In PLAY IVR FUNCTION $input");
        //$temp   = $AGI->get_variable("input");
        $digits = trim($temp["data"]);
        // $AGI->verbose("In PLAY IVR FUNCTION $digits");

        $sql_ivr_option = "select * from ivr_option where ivr_id='".$id_ivr."' and input_digit='".$digits."'";
        $result_ivr_option = mysqli_query($this->con,$sql_ivr_option);
        $ivr_option_row = mysqli_fetch_assoc($result_ivr_option);
        //$route_id     = $ivr_option_row['id']; 
        $ivr_dest_type  = $ivr_option_row['ivr_dest_type'];
        $ivr_dest_no    = $ivr_option_row['ivr_dest_no'];
        // $AGI->verbose("In PLAY IVR FUNCTION: Digits: $digits, Route_id=$route_id,Action:$ivr_dest_type,Action data : $ivr_dest_no");


        $sql_ivr_selection = "select * from cc_selection_did where id='".$ivr_dest_type."'";
        $result_ivr_selection = mysqli_query($this->con,$sql_ivr_selection);

        // $exten=$AGI->request['agi_exten'];
        if(mysqli_num_rows($result_ivr_selection) > 0 ){
            
            $ivr_selection_row = mysqli_fetch_assoc($result_ivr_selection);
            //$AGI->exec("Goto",$ivr_selection_row['selection_value'],$ivr_dest_no,1);
        }/* else{
            //$this->play_ivr($AGI, $did, $file, $id_ivr, $user_id);
        } */
        
    }

}

?>