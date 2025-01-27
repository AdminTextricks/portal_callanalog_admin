<?php
function asterisk_Cmd($cmd) {
    include_once("AstManager.class.php");
    include("config.inc.php");
    $manager = new AsteriskManager();
    $manager->Connect($conf['astman']['user'], $conf['astman']['password']);
    return $manager->Run($cmd);
}

function asterisk_Reload() {
    include_once("AstManager.class.php");
    include("config.inc.php");

    $manager = new AsteriskManager();
    $manager->Connect($conf['astman']['user'], $conf['astman']['password']);

    $message = new AsteriskManagerMessage();
    $message->SetKey('Action', 'Reload');

    $manager->Send($message);
}

function asterisk_RecordSound($Extension, $Message, $TmpFile) {
    include_once("AstManager.class.php");
    include("config.inc.php");
    $manager = new AsteriskManager();
    $manager->Connect($conf['astman']['user'], $conf['astman']['password']);

    $message = new AsteriskManagerMessage();
    $message->SetKey('Action', 'Originate');
    $message->SetKey('Channel', 'SIP/' . $Extension);
    $message->SetKey('Exten', 's');
    $message->SetKey('Priority', '1');
    $message->SetKey('Context', 'record_web_sound');
    $message->SetVar('MESSAGE', $Message);
    $message->SetVar('FILE', $TmpFile);

    $manager->Send($message);
}

function asterisk_PlaySound($Extension, $File) {
    include_once("AstManager.class.php");
    include("config.inc.php");
    $manager = new AsteriskManager();
    $manager->Connect($conf['astman']['user'], $conf['astman']['password']);

    $message = new AsteriskManagerMessage();
    $message->SetKey('Action', 'Originate');
    $message->SetKey('Channel', 'SIP/' . $Extension);
    $message->SetKey('Exten', 's');
    $message->SetKey('Priority', '1');
    $message->SetKey('Context', 'play_sound');
    $message->SetVar('FILE', $File);

    $manager->Send($message);
}

?>
