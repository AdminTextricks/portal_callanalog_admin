<?php
include 'connection.php';

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = "Client." .$_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con, $_POST['search']['value']); // Search value

## Search 
$searchQuery = " ";
if ($searchValue != '') {
    $searchQuery = " and (crg.status like '%".$searchValue."%' OR 
    cc_card.firstname like '%" . $searchValue . "%' OR 
    cc_card.email like '%" . $searchValue . "%' ) ";
}

## Total number of records without filtering
$user_id = $_SESSION['login_user_id'];
if ($_SESSION['userroleforpage'] == 1) {
    $sel_u =  "SELECT COUNT(*) AS allcount FROM upload_documents WHERE 1";
}else{
    $sel_u =  "SELECT COUNT(*) AS allcount FROM upload_documents WHERE user_id='".$user_id."'";
}

$sel = mysqli_query($con,$sel_u);
if(mysqli_num_rows($sel)>0 ){
	$records = mysqli_fetch_assoc($sel);
	$totalRecords = $records['allcount'];
}else{
	$totalRecords = 1;
}

## Total number of records with filtering
if ($_SESSION['userroleforpage'] == 1) {
  $sel2 = "select count(*) as allcount from upload_documents crg left join cc_card on crg.user_id=cc_card.id WHERE 1 " . $searchQuery;
} else {
  $sel2 = "select count(*) as allcount from upload_documents crg WHERE user_id=" . $user_id . "" . $searchQuery;
}
    // echo"<pre>"; print_r($sel2);
    
    $sel2 = mysqli_query($con,$sel2);
    
    if(mysqli_num_rows($sel2)> 0 ){
    $records = mysqli_fetch_assoc($sel2);
    $totalRecordwithFilter = $records['allcount'];
    }else{
        $totalRecordwithFilter = 1;
    }

## Fetch records
if ($_SESSION['userroleforpage'] == 1) {
    $empQuery = "SELECT crg.*, cc_card.username, Client.clientName, cc_card.uipass, cc_card.email, cc_card.firstname FROM upload_documents crg LEFT JOIN cc_card ON crg.accountcode = cc_card.username LEFT JOIN Client ON crg.user_id = Client.clientId WHERE 1 " . $searchQuery . " order by crg.id DESC limit ".$row.",".$rowperpage;
} else {
    $empQuery = "SELECT crg.*, cc_card.username, Client.clientName, cc_card.uipass, cc_card.email, cc_card.firstname FROM upload_documents crg LEFT JOIN cc_card ON crg.accountcode = cc_card.username LEFT JOIN Client ON crg.user_id = Client.clientId WHERE cc_card.username='" . $_SESSION['login_usernames'] . "' " . $searchQuery . "order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
}

function endsWith($string, $suffix)
{
    return substr($string, -strlen($suffix)) === $suffix;
}
$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_array($empRecords)) {
    $client_sql = "select clientId from users_login where id='" . $row['user_id'] . "'";
    $client_res = mysqli_query($connection, $client_sql) or die("query failed : client_sql");
    $client_row = mysqli_fetch_assoc($client_res);
    $clientId = $client_row['clientId'];

    $client_query = "select clientName from Client where clientId='" . $clientId . "'";
    $client_result = mysqli_query($connection, $client_query) or die("query failed : client_query");
    $clientRow = mysqli_fetch_assoc($client_result);
    $clientName = $clientRow['clientName'];
    // echo '<pre>'; print_r($row); exit;
    $fileOne = $view_button = '';
    if (endsWith($row['file_one'], ".pdf")) {
        $fileOne = '<a class="btn" href="upload/' . $row['file_one'] . '" target="_blank" ><svg xmlns="http://www.w3.org/2000/svg" width="15.320129mm" height="22.604164mm" viewBox="0 0 75.320129 92.604164">
        <g transform="translate(53.548057 -183.975276) scale(1.4843)">
          <path fill="#ff2116" d="M-29.632812 123.94727c-3.551967 0-6.44336 2.89347-6.44336 6.44531v49.49804c0 3.55185 2.891393 6.44532 6.44336 6.44532H8.2167969c3.5519661 0 6.4433591-2.89335 6.4433591-6.44532v-40.70117s.101353-1.19181-.416015-2.35156c-.484969-1.08711-1.275391-1.84375-1.275391-1.84375a1.0584391 1.0584391 0 0 0-.0059-.008l-9.3906254-9.21094a1.0584391 1.0584391 0 0 0-.015625-.0156s-.8017392-.76344-1.9902344-1.27344c-1.39939552-.6005-2.8417968-.53711-2.8417968-.53711l.021484-.002z" color="#000" font-family="sans-serif" overflow="visible" paint-order="markers fill stroke" style="line-height:normal;font-variant-ligatures:normal;font-variant-position:normal;font-variant-caps:normal;font-variant-numeric:normal;font-variant-alternates:normal;font-feature-settings:normal;text-indent:0;text-align:start;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000000;text-transform:none;text-orientation:mixed;white-space:normal;shape-padding:0;isolation:auto;mix-blend-mode:normal;solid-color:#000000;solid-opacity:1"/>
          <path fill="#f5f5f5" d="M-29.632812 126.06445h28.3789058a1.0584391 1.0584391 0 0 0 .021484 0s1.13480448.011 1.96484378.36719c.79889772.34282 1.36536982.86176 1.36914062.86524.0000125.00001.00391.004.00391.004l9.3671868 9.18945s.564354.59582.837891 1.20899c.220779.49491.234375 1.40039.234375 1.40039a1.0584391 1.0584391 0 0 0-.002.0449v40.74609c0 2.41592-1.910258 4.32813-4.3261717 4.32813H-29.632812c-2.415914 0-4.326172-1.91209-4.326172-4.32813v-49.49804c0-2.41603 1.910258-4.32813 4.326172-4.32813z" color="#000" font-family="sans-serif" overflow="visible" paint-order="markers fill stroke" style="line-height:normal;font-variant-ligatures:normal;font-variant-position:normal;font-variant-caps:normal;font-variant-numeric:normal;font-variant-alternates:normal;font-feature-settings:normal;text-indent:0;text-align:start;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000000;text-transform:none;text-orientation:mixed;white-space:normal;shape-padding:0;isolation:auto;mix-blend-mode:normal;solid-color:#000000;solid-opacity:1"/>
          <path fill="#ff2116" d="M-23.40766 161.09299c-1.45669-1.45669.11934-3.45839 4.39648-5.58397l2.69124-1.33743 1.04845-2.29399c.57665-1.26169 1.43729-3.32036 1.91254-4.5748l.8641-2.28082-.59546-1.68793c-.73217-2.07547-.99326-5.19438-.52872-6.31588.62923-1.51909 2.69029-1.36323 3.50626.26515.63727 1.27176.57212 3.57488-.18329 6.47946l-.6193 2.38125.5455.92604c.30003.50932 1.1764 1.71867 1.9475 2.68743l1.44924 1.80272 1.8033728-.23533c5.72900399-.74758 7.6912472.523 7.6912472 2.34476 0 2.29921-4.4984914 2.48899-8.2760865-.16423-.8499666-.59698-1.4336605-1.19001-1.4336605-1.19001s-2.3665326.48178-3.531704.79583c-1.202707.32417-1.80274.52719-3.564509 1.12186 0 0-.61814.89767-1.02094 1.55026-1.49858 2.4279-3.24833 4.43998-4.49793 5.1723-1.3991.81993-2.86584.87582-3.60433.13733zm2.28605-.81668c.81883-.50607 2.47616-2.46625 3.62341-4.28553l.46449-.73658-2.11497 1.06339c-3.26655 1.64239-4.76093 3.19033-3.98386 4.12664.43653.52598.95874.48237 2.01093-.16792zm21.21809-5.95578c.80089-.56097.68463-1.69142-.22082-2.1472-.70466-.35471-1.2726074-.42759-3.1031574-.40057-1.1249.0767-2.9337647.3034-3.2403347.37237 0 0 .993716.68678 1.434896.93922.58731.33544 2.0145161.95811 3.0565161 1.27706 1.02785.31461 1.6224.28144 2.0729-.0409zm-8.53152-3.54594c-.4847-.50952-1.30889-1.57296-1.83152-2.3632-.68353-.89643-1.02629-1.52887-1.02629-1.52887s-.4996 1.60694-.90948 2.57394l-1.27876 3.16076-.37075.71695s1.971043-.64627 2.97389-.90822c1.0621668-.27744 3.21787-.70134 3.21787-.70134zm-2.74938-11.02573c.12363-1.0375.1761-2.07346-.15724-2.59587-.9246-1.01077-2.04057-.16787-1.85154 2.23517.0636.8084.26443 2.19033.53292 3.04209l.48817 1.54863.34358-1.16638c.18897-.64151.47882-2.02015.64411-3.06364z"/>
          <path fill="#2c2c2c" d="M-20.930423 167.83862h2.364986q1.133514 0 1.840213.2169.706698.20991 1.189489.9446.482795.72769.482795 1.75625 0 .94459-.391832 1.6233-.391833.67871-1.056548.97958-.65772.30087-2.02913.30087h-.818651v3.72941h-1.581322zm1.581322 1.22447v3.33058h.783664q1.049552 0 1.44838-.39184.405826-.39183.405826-1.27345 0-.65772-.265887-1.06355-.265884-.41282-.587747-.50378-.314866-.098-1.000572-.098zm5.50664-1.22447h2.148082q1.560333 0 2.4909318.55276.9375993.55276 1.4133973 1.6443.482791 1.09153.482791 2.42096 0 1.3994-.4338151 2.49793-.4268149 1.09153-1.3154348 1.76324-.8816233.67172-2.5189212.67172h-2.267031zm1.581326 1.26645v7.018h.657715q1.378411 0 2.001144-.9516.6227329-.95858.6227329-2.5539 0-3.5125-2.6238769-3.5125zm6.4722254-1.26645h5.30372941v1.26645H-4.2075842v2.85478h2.9807225v1.26646h-2.9807225v4.16322h-1.5813254z" font-family="Franklin Gothic Medium Cond" letter-spacing="0" style="line-height:125%;-inkscape-font-specification:\'Franklin Gothic Medium Cond\'" word-spacing="4.26000023"/>
        </g>
      </svg></a>';
        $view_button = '<a href="upload/' . $row['file_one'] . '" target="_blank" >
                        <button type="button" class="btn btn-primary" >View</button></a>';
    } /* else if (endsWith($row['file_one'], ".docx")) {
        $fileOne = '<a class="btn" href="upload/' . $row['file_one'] . '" target="_blank" ><svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 64 64" id="doc-file"><path fill="#ededed" d="M39.124 2.5H14a4 4 0 0 0-4 4v50a4 4 0 0 0 4 4h36a4 4 0 0 0 4-4V17.376Z"></path><path fill="#c6c6c6" d="m53.707 17.083-14.29-14.29a1 1 0 0 0-1.707.707v11.29a4 4 0 0 0 4 4H53a1 1 0 0 0 .707-1.707Z"></path><path fill="#0461a0" d="M53 43.393H30.086l-2.4-2.745a2 2 0 0 0-1.505-.683H11a2 2 0 0 0-2 2V56.5a5.006 5.006 0 0 0 5 5h36a5.006 5.006 0 0 0 5-5V45.393a2 2 0 0 0-2-2Z"></path><path fill="#c6c6c6" d="M16 17.061h17.71v2H16zM30.29 30.248H48v2H30.29zM16 21.455h32v2H16zM16 25.851h32v2H16z"></path><path fill="#fff" d="M24.076 56.507h-2.941v-8.928h2.918a4.8 4.8 0 0 1 1.835.318 3.3 3.3 0 0 1 1.274.906 3.758 3.758 0 0 1 .741 1.41 6.566 6.566 0 0 1 .24 1.842 6.455 6.455 0 0 1-.252 1.89 3.511 3.511 0 0 1-.789 1.4 3.849 3.849 0 0 1-3.026 1.162zm-.022-7.3h-1.012v5.664h.988a2.342 2.342 0 0 0 1.09-.224 1.727 1.727 0 0 0 .675-.617 2.61 2.61 0 0 0 .343-.908 5.967 5.967 0 0 0 .1-1.095 4.926 4.926 0 0 0-.138-1.24 2.494 2.494 0 0 0-.4-.878 1.919 1.919 0 0 0-1.646-.698zm8.282 7.42a3.854 3.854 0 0 1-1.761-.366 3.179 3.179 0 0 1-1.168-1 4.129 4.129 0 0 1-.647-1.461 7.943 7.943 0 0 1 0-3.516 4.129 4.129 0 0 1 .647-1.464 3.179 3.179 0 0 1 1.168-1 4.407 4.407 0 0 1 3.517 0 3.209 3.209 0 0 1 1.162 1 4.128 4.128 0 0 1 .646 1.464 7.589 7.589 0 0 1 .2 1.758 5.231 5.231 0 0 1-.959 3.36 3.367 3.367 0 0 1-2.805 1.225zm0-7.536a1.513 1.513 0 0 0-1.408.726 4.342 4.342 0 0 0-.457 2.226 4.342 4.342 0 0 0 .457 2.226 1.717 1.717 0 0 0 2.8 0 4.331 4.331 0 0 0 .458-2.226 4.331 4.331 0 0 0-.458-2.226 1.5 1.5 0 0 0-1.392-.726zm7.83 7.536a3.467 3.467 0 0 1-1.7-.384 3.074 3.074 0 0 1-1.111-1.026 4.432 4.432 0 0 1-.6-1.464 7.968 7.968 0 0 1 0-3.414 4.375 4.375 0 0 1 .608-1.47 3.136 3.136 0 0 1 1.118-1.026 3.464 3.464 0 0 1 1.7-.384 3.661 3.661 0 0 1 1.92.5 2.195 2.195 0 0 1 .726.728 4.918 4.918 0 0 1 .534 1.259l-1.752.42a2.523 2.523 0 0 0-.528-.912 1.249 1.249 0 0 0-.96-.36 1.277 1.277 0 0 0-.63.151 1.393 1.393 0 0 0-.45.4 2.268 2.268 0 0 0-.294.562 3.942 3.942 0 0 0-.174.648 5.352 5.352 0 0 0-.078.659c-.012.218-.017.415-.017.593a4.483 4.483 0 0 0 .42 2.177 1.329 1.329 0 0 0 1.268.716 1.636 1.636 0 0 0 .594-.1 1.283 1.283 0 0 0 .427-.27 2.04 2.04 0 0 0 .323-.414 5.4 5.4 0 0 0 .276-.528l1.8.468A5.27 5.27 0 0 1 43 55.29a3.075 3.075 0 0 1-.737.746 3.532 3.532 0 0 1-2.097.591z"></path></svg></a>';
        $view_button = '<a href="upload/' . $row['file_one'] . '" target="_blank" >
                        <button type="button" class="btn btn-primary" >View</button></a>'; */
     else {
        //$fileOne = '<i class="fa fa-photo" style="font-size:48px;color:red;"></i>';
        $fileOne = '<img class="btn open_model" src="upload/' . $row['file_one'] . '" width="100%">';
        $view_button = '<button type="button" class="btn btn-primary open_model" >View</button>';
    }
    

    $status_options = '';

    if ($_SESSION['userroleforpage'] == 1) {
        $status_options = '<div class="table-data-feature">  
                            <select name="status" id="status'.$row['id'].'" class="form-control">
                                <option value="Pending" '; 
                                if($row['status'] == 'Pending'){ $status_options .='selected'; } 
                                $status_options .= '>Pending</option>
                                <option value="Approved" ';
                                if($row['status'] == 'Approved'){ $status_options .='selected'; }
                                $status_options .=' >Approved</option>
                                <option value="Rejected"';
                                if($row['status'] == 'Rejected'){ $status_options .='selected'; }
                                $status_options .=' >Rejected</option>
                            </select> &nbsp;&nbsp;&nbsp;
                            <a href="javascript:void(0)"onclick="return UploadDocStatus('.$row['id'].');">
                            <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                <i class="fa fa-check-square-o"></i>
                            </button>
                        </a>
                            </div>';
        $action = '<div class="table-data-feature">        
            <!--<a href="upload_documents_edit.php?id='.$row['id'].'">
                <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                    <i class="fa fa-pencil-square-o"></i>
                </button>
            </a> -->
           
            <a href="javascript:void(0)" onclick="return UploadDocdatadeleteContent('.$row['id'].');" type="button">
                <button class="item" data-toggle="tooltip" type="button" data-placement="top" title="" data-original-title="Delete">
                    <i class="fa fa-trash-o"></i>
                </button>
            </a>
        </div>';
    } elseif ($row['status']== 'Rejected'){             
        $action ='<a href="upload_documents_edit.php?id='.$row['id'].'"><button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button></a><br><b>Rejected<br>Please Upload Again</b>'; 
    } else {
        $action = '<b>'.$row['status'].'</b>';
    }
    $seleect = '';
     if ($_SESSION['userroleforpage'] == 1) { 
    $seleect = '<td><input type="checkbox" class="emp_checkbox" data-emp-id="'.$row["id"].'" style="float:left; margin-left:10px;"></td>';
    }
    $data[] = array(
    		//"serial"=>$i,
            "Select"=> $seleect,
    		"clientName"=>$clientName,
            "username"=>$row['firstname'],
    		"clientEmail"=>$row['email'],
    		"file_one"=>$fileOne,
            "view"=>$view_button,
            "status_options" => $status_options,
    		"action"=>$action
    	);
		$i++;	
}
## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);

// 
