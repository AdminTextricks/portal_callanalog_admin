<?php require_once ('header.php'); ?>
<?php
$cmsg = $message = '';

if (isset($_POST['submit'])) {
	if ($_POST['countryId'] != '') {
		$country = $_POST['countryId'];
	} else {
		$cmsg = "Please Select Country";
	}
}

?>
<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">
						<h2 class="title-1">Destination Information<span
								style="margin-left:50px;color:blue;"><?php echo $message; ?></span></h2>
						<div class="table-data__tool-right">
							<a href="inbound.php">
								<button class="au-btn au-btn-icon au-btn--green au-btn--small">
									<i class="fa fa-tty" aria-hidden="true"></i>Destination</button>
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="big_live_outer">
				<div class="row">
					<div class="col-md-12">
						<div class="queue_info">
							<form id="didForm" name="didForm" action="" method="post">

								<?php
								//$query_country = "select * from cc_country";
								//$result_country = mysqli_query($connection , $query_country);
								?>
								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Country*</label>
									</div>
									<div class="col-12 col-md-8">
										<select name="countryId" id="country-dropdown"
											class="form-control-sm form-control">
											<option value="">Select Country</option>
											<option <?php if (isset($_POST['countryId']) && $_POST['countryId'] == '225') {
												echo 'selected="selected"';
											} ?> value="225">United States</option>
											<?php /* while($row_country = mysqli_fetch_array($result_country)){ ?>
																<option value="<?php echo $row_country['id']; ?>"><?php echo $row_country['countryname']; ?></option>
																<?php } */ ?>
										</select>
										<span style="margin-left:25px;color:red;"><?php echo $cmsg; ?></span>

									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">TFN*</label>
									</div>
									<div class="col-12 col-md-8">
										<select name="destination_tfn" id="destination_tfn" required=""
											data-select2-id="destination_tfn" tabindex="-1" aria-hidden="true"
											class="form-control-sm form-control">
											<!-- <option value="">Select</option> -->
											<option <?php if (isset($_POST['destination_tfn']) && $_POST['destination_tfn'] == 'Toll Free') {
												echo 'selected="selected"';
											} ?> value="Toll Free" data-select2-id="2">Toll Free</option>
											<option <?php if (isset($_POST['destination_tfn']) && $_POST['destination_tfn'] == 'Local') {
												echo 'selected="selected"';
											} ?>
												value="Local">Local</option>
										</select>
									</div>
								</div>
								<div class="row form-group">
									<div class="showlocal" id="showlocal" <?php if (isset($_POST['destination_tfn']) && $_POST['destination_tfn'] == 'Local') { ?> style="display: block;" <?php } else { ?>
											style="display:none;" <?php } ?>>

										<div class="col col-md-4">
											<label for="text-input" class=" form-control-label">Local Area*</label>
										</div>
										<div class="col-12 col-md-8">
											<input id="Local_area" name="Local_area" placeholder="" class="form-control"
												type="text"
												value="<?php if (isset($_POST['Local_area'])) {
													echo $_POST['Local_area'];
												} else {
													echo '';
												} ?>" />
										</div>
									</div>

									<div class="showlpoolNumbers" id="showlpoolNumbers" <?php if (isset($_POST['destination_tfn']) && $_POST['destination_tfn'] == 'Local') { ?>
											style="display: none;" <?php } else { ?> style="display:block;" <?php } ?>>
										<div class="col col-md-4">
											<label for="selectSm" class=" form-control-label">Starting 3 digits*</label>
										</div>
										<div class="col-12 col-md-8">
											<select id="numberpool" name="numberpool"
												class="form-control-sm form-control">
												<option value="">All</option>
												<?php
												foreach ($numberpool as $value) { ?>
													<option <?php if (isset($_POST['numberpool']) && $_POST['numberpool'] == $value) {
														echo 'selected="selcted"';
													} ?>
														value="<?php echo $value; ?>"><?php echo $value ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group pull-right">
									<button type="submit" name="submit" value="submit" id="submit"
										class="btn btn-primary btn-sm">Submit</button>
								</div>
								<p style="color:blue;"><?php echo $message; ?></p>
							</form>

						</div>

						<!--
		<div class="row">
		 <div class="cart"></div>
			<div class="col-sm-12 col-md-12 col-lg-6 col-xs-12">
			  <h4 class="badge-pill badge-light mt-3 mb-3 p-2 text-center">Products</h4>
			  <div class="row">
				<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
				  <div class="shadow-sm card mb-3 product">
					<div class="card-body">					
					  <h5 class="card-title text-info bold product-name">7000324234</h5>
					  <span class='card-text text-success product-price' style='display:none;'>1</span>
					  <button class="btn badge badge-pill badge-secondary mt-2 float-right" type="button"
						data-action="add-to-cart">Add to cart</button>
					</div>
				  </div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
				  <div class="shadow-sm card mb-3 product">
					<div class="card-body">
					  <h5 class="card-title text-info product-name">9001241234</h5>
					  <p class="card-text text-success product-price" style="display:none;">1</p>
					  <button class="btn badge badge-pill badge-secondary mt-2 float-right" type="button"
					  data-action="add-to-cart">Add to cart</button>
					</div>
				  </div>
				</div>
			  </div>
			  <div class="row">
				<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
				  <div class="shadow-sm card mb-3 product">
					<div class="card-body">
					  <h5 class="card-title text-info product-name">800121323</h5>
					  <p class="card-text text-success product-price" style="display:none;">1</p>
					  <button class="btn badge badge-pill badge-secondary mt-2 float-right" type="button"
					  data-action="add-to-cart">Add to cart</button>
					</div>
				  </div>
				</div>
			  </div>
			</div>
			<div class="col-sm-12 col-md-12 col-lg-6 col-xs-12">
			  <h4 class="badge-pill badge-light mt-3 mb-3 p-2 text-center">Cart</h4>
			
			</div>
		</div>-->

						<?php
						if ($country != '' && $_POST['destination_tfn'] != '') { ?>
							<div class="row">

								<div class="col-sm-12 col-md-8 col-lg-8 col-xs-12">
									<!-- <h4 class="badge-pill badge-light mt-3 mb-3 p-2 text-center">Products</h4>-->

									<table class="table table-bordered" id="numberss">
										<thead>
											<tr>
												<th>Number</th>
												<th>Price</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if ($_POST['destination_tfn'] == 'Local') {
												$empQuery = "select id, did from cc_did WHERE iduser = '0' and clientId = '0' and id_cc_country='" . $_POST['countryId'] . "' or (status='Suspended' and activated='0' and  iduser = '" . $_SESSION['login_user_id'] . "')";
											} else {
												//$user_id = ;
										
												$user_sql = "select did_permission from users_login where id='" . $_SESSION['login_user_id'] . "'";
												$user_res = mysqli_query($connection, $user_sql) or die("query failed : user_sql");
												if (mysqli_num_rows($user_res) > 0) {
													$row = mysqli_fetch_assoc($user_res);
													$did_permission = str_replace(",", "','", $row['did_permission']);
												}
												$empQuery = "select id, did from cc_did WHERE did like '%" . $_POST['numberpool'] . "%' and id_cc_country='" . $_POST['countryId'] . "' and iduser = '0' and clientId = '0'  and did_provider IN ('" . $did_permission . "') or (status='Suspended' and activated='0' and  iduser = '" . $_SESSION['login_user_id'] . "')";
											}

											## Fetch records
											$empRecords = mysqli_query($con, $empQuery);
											$data = array();
											$i = 1;
											if (mysqli_num_rows($empRecords) > 0) {
												$priceQuery = "select * from cc_did_exten_price WHERE type='did' and country_id = '" . $_POST['countryId'] . "'";
												$priceRecords = mysqli_query($con, $priceQuery);
												$price_row = mysqli_fetch_assoc($priceRecords);
												//echo '<pre>'; print_r($price_row);exit;
												while ($row = mysqli_fetch_assoc($empRecords)) { ?>
													<tr class="product">
														<td>
															<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
																<div class="shadow-sm card mb-3 product">
																	<div class="card-body">
																		<h5 class="card-title text-info bold product-name">
																			<?php echo $row['did']; ?></h5>
														</td>
														<td>$<span
																class='card-text text-success product-price'><?php echo $price_row['price']; ?></span>
														</td>
														<td><button
																class="btn badge badge-pill badge-secondary mt-2 float-right btn btn-primary btn-sm"
																type="button" data-action="add-to-cart">Add to cart</button>
										</div>
									</div>
								</div>
								</td>
								</tr>
							<?php }
											} else { ?>
							<tr>
								<td colspan="3"> No Record Found.</td>
							</tr>
						<?php } ?>
						</tbody>
						</table>
					</div>
					<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
						<h4 class="badge-pill badge-light mt-3 mb-3 p-2 text-center"
							style=" border: 1px solid; padding: 10px; background: #f5f5f5;">Cart</h4>
						<div class="cart"></div>
					</div>
				</div>
			<?php
						}
						?>

		</div>
	</div>
</div>

</div>
</div>
<!-- footer section start here -->
<!-- <div class="copyright">
		<p>Copyright Â© 2020 PBX. All rights reserved.</p>
	</div> -->
<!-- footer section end here -->
</div>


<script>
	/*   On chnage TFN Dropdown  */

	$('#destination_tfn').change(function () {
		var destination_tfn = $(this).val();
		if (destination_tfn == 'Toll Free') {
			document.getElementById('showlpoolNumbers').style.display = "flex";
			document.getElementById('showlocal').style.display = "none";
			//$('#number-dropdown').find('option').not(':first').remove();
		} else {
			$('#Local_area').val('');
			document.getElementById('showlpoolNumbers').style.display = "none";
			document.getElementById('showlocal').style.display = "flex";
		}
	});

	/*   TFN ONchnage End  */


	$(document).ready(function () {

		/*	$("#submit").click(function (event) {
			   event.preventDefault();
			   /* Local Area onchange call ajax to get String 3 digit   Start *	
			   $.ajax({
				   url:'ajaxdidsearch.php',
				   type: 'POST', // GET/POST
				   data: $('#didForm').serialize(),
				   success: function(response){
					   $('.searchData').html(response);
					   add_to_cart();
				   }
			   });
			   /* Local Area End  
			   
		   });
	   */
	});
</script>
<script>
	"use strict";
	let cart = [];
	let cartTotal = 0;
	const cartDom = document.querySelector(".cart");
	const addtocartbtnDom = document.querySelectorAll('[data-action="add-to-cart"]');
	addtocartbtnDom.forEach(addtocartbtnDom => {
		addtocartbtnDom.addEventListener("click", () => {
			const productDom = addtocartbtnDom.parentNode.parentNode;
			const product = {
				name: productDom.querySelector(".product-name").innerText,
				price: productDom.querySelector(".product-price").innerText,
				quantity: 1
			};
			const IsinCart = cart.filter(cartItem => cartItem.name === product.name).length > 0;
			if (IsinCart === false) {
				cartDom.insertAdjacentHTML("beforeend", `<div class="row">
	  <div class="d-flex flex-row shadow-sm card cart-items mt-2 mb-3 animated flipInX">
		<div class="p-2 mt-3 col-sm-12 col-md-4 col-lg-4 col-xs-12 text-center">
			<p class="text-info cart_item_name">${product.name}</p>
		</div>
		<div class="p-2 mt-3 col-sm-12 col-md-4 col-lg-4 col-xs-12 text-center">
			<p class="text-success cart_item_price">${product.price}</p>
		</div>
		<div class="p-2 mt-3 ml-auto text-right col-sm-12 col-md-4 col-lg-4 col-xs-12 text-center">
		<div class="p-2 mt-3" style="display:none;">
		  <p class="text-success cart_item_quantity" >${product.quantity}</p>
		</div>
		<div class="p-2 mt-3">
		  <button class="btn badge badge-danger btn btn-danger btn-sm" type="button" data-action="remove-item">&times;
		</div>
		</div>
		</div>
	  </div> `);
				if (document.querySelector('.cart-footer') === null) {
					cartDom.insertAdjacentHTML("afterend", `
		  <div class="d-flex flex-row shadow-sm card cart-footer mt-2 mb-3 animated flipInX">
		  <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">		
			<div class="p-2">
			  <button class="btn badge-danger btn btn-danger btn-sm" type="button" data-action="clear-cart">Clear Cart
			</div>
			</div>
			<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">		
			<div class="p-2 ml-auto">
			  <button class="btn badge-dark btn btn-success btn-sm" type="button" data-action="check-out">Pay <span class="pay"></span>
				&#10137;
			</div>
			</div>
		  </div>`);
				}
				addtocartbtnDom.innerText = "In cart";
				addtocartbtnDom.disabled = true;
				cart.push(product);
				const cartItemsDom = cartDom.querySelectorAll(".cart-items");
				cartItemsDom.forEach(cartItemDom => {
					if (cartItemDom.querySelector(".cart_item_name").innerText === product.name) {
						cartTotal += parseInt(cartItemDom.querySelector(".cart_item_quantity").innerText)
							* parseInt(cartItemDom.querySelector(".cart_item_price").innerText);
						document.querySelector('.pay').innerText = cartTotal + " USD";
						//remove item from cart
						cartItemDom.querySelector('[data-action="remove-item"]').addEventListener("click", () => {
							cart.forEach(cartItem => {
								if (cartItem.name === product.name) {
									cartTotal -= parseInt(cartItemDom.querySelector(".cart_item_price").innerText);
									document.querySelector('.pay').innerText = cartTotal + " USD";
									cartItemDom.remove();
									cart = cart.filter(cartItem => cartItem.name !== product.name);
									addtocartbtnDom.innerText = "Add to cart";
									addtocartbtnDom.disabled = false;
								}
								if (cart.length < 1) {
									document.querySelector('.cart-footer').remove();
								}
							});
						});
						//clear cart
						document.querySelector('[data-action="clear-cart"]').addEventListener("click", () => {
							cartItemDom.remove();
							cart = [];
							cartTotal = 0;
							if (document.querySelector('.cart-footer') !== null) {
								document.querySelector('.cart-footer').remove();
							}
							addtocartbtnDom.innerText = "Add to cart";
							addtocartbtnDom.disabled = false;
						});
						document.querySelector('[data-action="check-out"]').addEventListener("click", () => {
							if (document.getElementById('paypal-form') === null) {
								checkOut();
							}
						});
					}
				});
			}
		});
	});

	function checkOut() {
		let paypalHTMLForm = `
	  <form id="paypal-form" action="create_invoice.php" method="post" >
		<input type="hidden" name="cmd" value="_cart">
		<input type="hidden" name="upload" value="1">
		<input type="hidden" name="business" value="basant000.amj@gmail.com">
		<input type="hidden" name="currency_code" value="USD">`;

		cart.forEach((cartItem, index) => {
			++index;
			paypalHTMLForm += ` <input type="hidden" name="item_name[]" value="${cartItem.name}">
		<input type="hidden" name="amount[]" value="${cartItem.price.replace("$", "")}">
		<input type="hidden" name="quantity[]" value="${cartItem.quantity}">`;
		});

		paypalHTMLForm += `<input type="submit" value="PayPal" class="paypal">
	  </form><div class="overlay">Please wait...</div>`;
		document.querySelector('body').insertAdjacentHTML("beforeend", paypalHTMLForm);
		document.getElementById("paypal-form").submit();
	}

</script>

<?php require_once ('footer.php'); ?>