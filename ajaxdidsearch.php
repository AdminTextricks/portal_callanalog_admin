<?php
include 'connection.php';

if($_POST['countryId'] !='' && $_POST['destination_tfn'] !=''){

	if($_POST['destination_tfn'] == 'Local'){
		$empQuery = "select id, did from cc_did WHERE iduser = '0' and clientId = '0' and id_cc_country='".$_POST['countryId']."'";	
	}else{
		$empQuery = "select id, did from cc_did WHERE did like '%".$_POST['numberpool']."%' and id_cc_country='".$_POST['countryId']."' and iduser = '0' and clientId = '0'";	
	}


	$searchTable = '<div class="row">
	<div class="col-sm-8"> 
		<div class="table-responsive">
			<table class="table table-bordered" id="numberss">
				<thead>
					<tr>
					<th>Number</th>
					<th>Price</th>
					<th>Test</th>
					<th>Add Card</th>
					</tr>
				</thead>
				<tbody>';
					
				

	## Fetch records
	$empRecords = mysqli_query($con, $empQuery);
	$data = array();
	$i = 1;
	if(mysqli_num_rows($empRecords) > 0){
		$priceQuery = "select * from cc_did_exten_price WHERE type='did' and country_id = '".$_POST['countryId']."'";
		$priceRecords = mysqli_query($con, $priceQuery);
		$price_row = mysqli_fetch_assoc($priceRecords);
		
		while ($row = mysqli_fetch_assoc($empRecords)) {

			$searchTable .= '<tr class="product">
			<td class="product-name">'.$row['did'].'</td>
			<td class="card-text text-success product-price">'.$price_row['price'].'</td>
			<td class="number_status">Buy</td>
			<td><button class="btn btn-primary btn-sm" type="button" data-action="add-to-cart">Add to cart</button></td>
		</tr>';
		
		}
	}
}else{
	$response = array('error'=>'please select all required fields and try again!');
}

$searchTable .='</tbody>
	</table>
		</div>
	</div>
	<div class="col-sm-4"> 
		<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
			<h4 class="badge-pill badge-light mt-3 mb-3 p-2 text-center text-black"> Number Cart</h4>
			<div class="cart"></div>
		</div>											
	</div>
	
</div>';
echo $searchTable;
//echo json_encode($response);

