<?php require_once ('connection.php');
require_once ('functions.php');

if (isset($_POST['id'])) {
    $extension_ids = explode(',', trim($_POST['id']));
    $extension_data_arrry = array();
    $extension_data_arrry1 = array();
    foreach ($extension_ids as $key => $ext_id) {
        $select_query = "SELECT `name`,`user_id`,`clientId`, sip_type,outbound_cid, recording, play_ivr, agent_name  FROM `cc_sip_buddies` WHERE `id`='" . $ext_id . "'";
        $result = mysqli_query($connection, $select_query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $select_voicemail = "SELECT count(uniqueid) as total , email FROM `cc_voicemail_users` where `mailbox` = '" . $row['name'] . "'";
            $result_voicemail = mysqli_query($connection, $select_voicemail);
            $row_voicemail = mysqli_fetch_assoc($result_voicemail);

            if ($row_voicemail['total'] > 0) {
                $row['voicemail'] = 'Yes';
                $row['email'] = $row_voicemail['email'];
            } else {
                $row['voicemail'] = 'No';
            }
            $extension_data_arrry1[] = $row;
        }
    }
}
$extension_data_arrry = $extension_data_arrry1;
$form = '';
$form .= '<table class="table">
  <thead>
    <tr>
      <th class="header-label">Extension</th>
      <th class="header-label">Barge Extension</th>
      <th class="header-label">VoiceMail</th>
      <th class="header-label">OutBound Call</th>
      <th class="header-label">Call Recording</th>
      <th class="header-label">Web Template</th>
    </tr>';
foreach ($extension_data_arrry as $key => $extension_data) {
    //print_r($extension_data);
    $form .= '<tr class="edit_exten" id="' . $extension_data['name'] . '"><th>' . $extension_data['name'] . '</th>
        <th><input type="hidden" name="name" value="' . $extension_data['name'] . '">
        <input type="hidden" name="clientId" value="' . $extension_data['clientId'] . '">
        <input type="hidden" name="user_id" value="' . $extension_data['user_id'] . '">
        <input type="hidden" name="agent_name" value="' . $extension_data['agent_name'] . '">
        <input type="checkbox" name="sip_type" value=""';
    if ($extension_data['sip_type'] == 'Yes') {
        $form .= 'checked="true"';
    }
    $form .= '></th>
        <th><input type="checkbox" name="VoiceMail" value=""';
    if ($extension_data['voicemail'] == 'Yes') {
        $form .= 'checked="true"';
    }
    $form .= '>
        
        <input class="form-control" type="text" name="email" value="';
    if ($extension_data['email'] != '') {
        $form .= $extension_data['email'];
    }
    $form .= '"> </th>
        <th><input type="checkbox" name="outbound_cid" value=""';
    if ($extension_data['outbound_cid'] == 1) {
        $form .= 'checked="true"';
    }
    $form .= '></th>
        <th><input type="checkbox" name="recording" value=""';
    if ($extension_data['recording'] == 1) {
        $form .= 'checked="true"';
    }
    $form .= '></th>
        <th><input type="checkbox" name="play_ivr" value=""';
    if ($extension_data['play_ivr'] == 1) {
        $form .= 'checked="true"';
    }
    $form .= '></th></tr>';
}

$form .= '
  </thead>
  <tbody>
  <tr><td  colspan="5"><span id="jsondata" class="hidden">' . json_encode($extension_data_arrry) . '</span><input type="hidden" id="jsondataUpdated" name="jsondataUpdated"></td></tr>
  </tbody>
  </table>
  <script> 
    $(document).ready(function() {
        $(".edit_exten").on("change", "input[type=\'checkbox\']" ,function(){
            var tr = $(this).closest(\'tr\');
            let name = tr.find(\'input[name="name"]\').val();
            let agent_name = tr.find(\'input[name="agent_name"]\').val();
            let user_id = tr.find(\'input[name="user_id"]\').val();
            let clientId = tr.find(\'input[name="clientId"]\').val();
            let sip_type = tr.find(\'input[name="sip_type"]\').prop(\'checked\');
            let VoiceMail = tr.find(\'input[name="VoiceMail"]\').prop(\'checked\');
            let email = tr.find(\'input[name="email"]\').val();
            let outbound_cid = tr.find(\'input[name="outbound_cid"]\').prop(\'checked\');
            let recording = tr.find(\'input[name="recording"]\').prop(\'checked\');
            let play_ivr = tr.find(\'input[name="play_ivr"]\').prop(\'checked\');            
if(VoiceMail == true && email == ""){
    alert(\'Please enter email id first\');
    tr.find(\'input[name="VoiceMail"]\').prop(\'checked\', false);
}
            var newData = [{name:name, agent_name:agent_name, user_id:user_id, clientId:clientId, sip_type:sip_type, VoiceMail:VoiceMail, email:email, outbound_cid:outbound_cid, recording:recording, play_ivr:play_ivr}];            

            var preData = JSON.parse($(\'#jsondata\').html());
            //console.log(newData[0].sip_type);
            var updatedData = preData.map((ext) => {
                    return ext.name == newData[0].name ? {
                    name: newData[0].name,
                    user_id: newData[0].user_id,
                    clientId: newData[0].clientId,
                    agent_name: newData[0].agent_name,
                    sip_type: newData[0].sip_type === true ? "Yes" : "No",
                    VoiceMail: newData[0].VoiceMail === true ? "Yes" : "No",
                    email: newData[0].VoiceMail ? newData[0].email : "",
                    outbound_cid: newData[0].outbound_cid === true ? "1" : "0",
                    recording: newData[0].recording === true ? "1" : "0",
                    play_ivr: newData[0].play_ivr === true ? "1" : "0"
                } : ext;
            });
            
            $(\'#jsondataUpdated\').val(JSON.stringify(updatedData));
            $(\'#jsondata\').text(JSON.stringify(updatedData));
            console.log(updatedData);
            
        });
    });
</script>';
echo $form;
?>