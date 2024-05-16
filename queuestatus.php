<?php
/*
 * This class can be used to retrieve messages from an IMAP, POP3 and NNTP server
 * @author Mohd Maroof Ali
 Email->'maroofali551@gmail.com'
 
 */
  ?>
  <?php

$qcalls = 0;
$queue = "";
if(isset($_POST['queue'])){ $queue = $_POST['queue']; }

  require_once('agi-bin/phpagi-asmanager.php');

  $asm = new AGI_AsteriskManager();
  if($asm->connect())
  { 
    $result = $asm->Command("queue show $queue");
  }
  $asm->disconnect();

    if(!strpos($result['data'], ':'))
      echo $peer['data'];
    else
    {
      $data = array();
     echo "<table border='1'; cellpadding=6pt;>";
      //echo "<table class='table'>";
      echo "<tr class='heading';>
      <td>Queue Number</td>
      <td>Calls in queue</td>
      <td>Answered calls</td>
       <td>Abandoned calls</td>
       <td>Average hold time</td>
       <td>Average talk time</td></tr>";
      foreach(explode("\n", $result['data']) as $line)
      {
         if (preg_match("/talktime/i", $line) && !preg_match("/default/i", $line)) {
          echo "<tr>";
          $pieces = explode(" ", $line);
          echo "<td class='large';>$pieces[0] </td>";
          echo "<td class='large';>$pieces[2] </td> "; 
          $qcalls = $qcalls + $pieces[2];
          echo "<td class='large';>".trim($pieces[14], "C:,")."</td> ";
          echo "<td class='large';>".trim($pieces[15], "A:,")."</td> ";
          echo "<td class='large';>".trim($pieces[9], "(s")." </td> ";
          echo "<td class='large';>".trim($pieces[11], "s")." </td> ";
          echo "</tr>";
         }
      }
      echo "</table>";
      
      echo "<br /><p class='total'>Total calls queuing :- $qcalls</p><br />";
    }

?>
