<?php
/*
 * This class can be used to retrieve messages from an IMAP, POP3 and NNTP server
 * @author Mohd Maroof Ali
 Email->'maroofali551@gmail.com'
 
 */
  ?>

 <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script type="text/javascript">
    setInterval("my_function();",2000); 
    function my_function(){
      $('#refresh').load(location.href + ' #time');
    }
  </script>
<?php
 $ip = $_SERVER['REMOTE_ADDR'];
   

require_once('phpagi-asmanager.php');
     
     
      $asm = new AGI_AsteriskManager();
      if($asm->connect())
      {


       $peers = $asm->command("sip show peers");
//echo $peers['data'];
  $rstrval=right($peers['data'],strlen($peers['data'])-16);
        if(strpos($rstrval, ':'))
  {


// echo ("<pre>");

// echo ("<pre/>");





 // $splittedstring=explode(" %7",$rstrval);




// foreach ($splittedstring as $key => $value) {

// echo $value."<br>"; }

    
    $remove = "\n";

    $split = explode($remove, $rstrval);

    $array[] = null;
    $tab = "\t";

    foreach ($split as $string)
    {
        $row = explode($tab, $string);
        array_push($array,$row);
  

    }


    echo "<a href='index.php?exten' role='button' style='color: white; background: #27c24c;
'>Extension List</a>";

echo "<div id='refresh'>";

    echo "<pre id='time' style='background-color:#d9edf7; color:#2779aa; border: 2px solid #2779aa;'>";

    // print_r($array);
  for($q=0; $q < count( $array) ; $q++)
  {   
  $tt1=$array[$q];



  echo "<hr style='border-top: 1px solid #2779aa;margin:-1px 0px -15px;'><br>";
  // echo count($array)."   ".strlen($tt1[0]);
  
 // echo count($tt1[0]);
  $ra=getdataarr($tt1[0]);
  // echo count($ra);
//echo $ra[5];
  echo $tt1[0];

$con = mysqli_connect("localhost", "root", "tumko34h1se",'myphonesystem');


  
	$uersql = "UPDATE  `agents_new` SET  `UserName` =  '".$ra[0]."', `Host` =  '".$ra[1]."', `Forcerport` =  '".$ra [3]."', `Dyn` =  '".$ra[2]."',
  `ACL` =  '".$ra[5]."', `Port` =  '".$ra[6]."', `Status` =  '".$ra[7]."',`Comedia` =  '".$ra [4]."'
  WHERE  `ename`=left('".$ra[0]."',4) and ((`Port`=0 and (".$ra[6].">0) ) or ( `Port`>0 and (".$ra[6]."=0))) ";
	
		$run_uersql=mysqli_query($con,$uersql);
	
				
		//if ($ra[5]>'0' and $ra[5]<>'Port')
		//{		
		//echo $uersql;	    
		// exit();
		//}
		// echo "<script>alert('Regestered Extension Updated')</script>";
	  
}      
    echo "</pre>";
       
echo "</div>";


  }
        else
        {
          $data = array();

   
          foreach(explode("\n", $peers['data']) as $line);

         
        }
     
        $asm->disconnect();
      }


function right($str, $length) {

     return substr($str, -$length);
}
  

function getdataarr($pArr)
{                
  

  $r[]=Null;
  $s="";
  $i=0;
  $j=0;
  for ($x = 0; $x <= strlen($pArr); $x++)
  {
    if(substr($pArr,$x,1)!=" ") 
    {
      $s=$s.substr($pArr,$x,1);
      $j++;
      
    }
    else
    {
      // echo $s;
      if($s!="")
      {
        $r[$i++]=$s;
        $s="";
      }
        
    }
    // echo substr($pArr,$x,1); 
  }
	/*
	if($i==9) 
	$r[7]=$r[6].$r[7].$r[8];
	else	
	
	$r[7]=$r[6].$r[7]; 
	
	$r[6]=$r[5];
	$r[5]=$r[4];
	$r[4]='';
*/
	//echo $r[0],$r[1],$r[2],$r[3],$r[4],$r[5],$r[6],"<br>";
	
  // echo $i,$j,$x,$r[0];
  return ($r);
}
                                                                                                                                                                                          
    ?>




