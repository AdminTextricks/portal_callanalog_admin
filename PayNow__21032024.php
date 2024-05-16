<?php require_once('header.php'); ?>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">     
        <?php 
         //   echo '<pre>'; print_r($_SESSION); echo '</pre>';
            $id = base64_decode($_GET['id']);
            $user_id = $_SESSION['login_user_id'];
            $user_plan_id = $_SESSION['login_user_plan_id'];
           
            $user_row = '';
            $user_select = "SELECT firstname,address,city,country,zipcode,phone FROM `cc_card` where id='".$user_id."'";
            $user_details = mysqli_query($connection , $user_select);
            if(mysqli_num_rows($user_details) > 0 ){
                $user_row = mysqli_fetch_assoc($user_details);
            }            
      
            $user_login = "SELECT * FROM `master_plans` where id='".$user_plan_id."'";
            $user_login = mysqli_query($connection , $user_login);
            if(mysqli_num_rows($user_login) > 0 ){
                $user_login = mysqli_fetch_assoc($user_login);
            }
        ?>
        <style>
            .form-control {
                height:45px;
            }
            </style>


<script type="text/javascript" src="https://js.stripe.com/v2/"></script>    
    
    <script type="text/javascript">
        Stripe.setPublishableKey('pk_live_51JHZjxG71L2aH3X1DB6IwwPkiYZ3Bq0WN2I1RXjggZ3LDr8Sa5MJMOatI0Ha8jaUvcWUD1rCOCMlpVKrggPVQRFw00xi47rZgH');
        
        
        function stripeResponseHandler(status, response) {
            if (response.error) {
                $('#payBtn').removeAttr("disabled");
                // $('#payment-errors').attr('hidden', 'false');
                $('#payment-errors').addClass('alert alert-danger');
                $("#payment-errors").html(response.error.message);
            } else {
                var form$ = $("#paymentFrm");
                var token = response['id'];
                form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                form$.get(0).submit();
            }
        }
        $(document).ready(function() {
            $("#paymentFrm").submit(function(event) {
                $('#payBtn').attr("disabled", "disabled");
                Stripe.createToken({
                    number: $('#card_num').val(),
                    cvc: $('#card-cvc').val(),
                    exp_month: $('#card-expiry-month').val(),
                    exp_year: $('#card-expiry-year').val()
                }, stripeResponseHandler);
                return false;
            });
        });
    </script>


	
    <div class="row">	
    <div class="col-md-3"></div>
        <div class="col-md-6">
            
            <div class="card">
                <h4 class="card-header bg-primary text-white text-center p-4" style="padding: 10px;">Call Analog Payment Form</h4>
                <div class="card-body bg-light">
                <?php
                    $query_inv = "select * from invoices where id='".$id."'";
                    $result_inv = mysqli_query($connection , $query_inv);
                    $item_type = '';
                    if(mysqli_num_rows($result_inv) > 0 ){
                        $rowid = mysqli_fetch_assoc($result_inv);                
                        $items = array();
                        $item_type = $rowid['item_type'];
                        $query_inv_item = "select * from invoices_items where invoice_id='".$rowid['id']."'";
                        $result_inv_item = mysqli_query($connection , $query_inv_item);
                        if(mysqli_num_rows($result_inv_item) > 0 ){
                            while($row_item = mysqli_fetch_assoc($result_inv_item)){
                                $items[] = $row_item['item_number'];
                                //$item_type = $row_item['item_type'];
                            }
                        $item_str = implode('-',$items);
                        ?>
                    <div id="payment-errors"></div>  
                     <form method="post" id="paymentFrm" enctype="multipart/form-data" action="ajaxStripePayments.php"> 
                
                        <div class="form-group">
                        <input name="gatway_invoice_id" id="gatway_invoice_id" class="form-control input-field-pay" type="text" value="<?php echo $rowid['invoice_id']; ?>" readonly required />
                        </div>  

                        <div class="form-group">
                        <input name="invoice_id" id="invoice_id" class="form-control input-field-pay" type="hidden" value="<?php echo $rowid['id']; ?>"  required />
                        </div> 

                        <div class="form-group">
                        <input name="stripeAmount" id="stripeAmount" class="form-control input-field-pay" type="text" value="<?php echo $rowid['invoice_amount']; ?>" readonly required />
                        </div>  

                        <div class="form-group">
                            <input name="stripeCurrency" id="stripeCurrency" class="form-control input-field-pay" type="text" value="<?php echo $rowid['invoice_currency']; ?>" readonly required />								
                        </div>  

                      	<div class="form-group">
                            <input name="payment_type" id="payment_type" class="form-control input-field-pay" type="hidden" value="Stripe" required />								
                        </div>  

                        <div class="form-group">
                            <input type="text" name="name" class="form-control input-field-pay" placeholder="Card Holder Name" value="<?php echo $user_row['firstname']; ?>" required  />
                        </div>  


                        <div class="form-group">
                            <input type="email" name="email" class="form-control input-field-pay" placeholder="example@gmail.com" value="<?php echo $_SESSION['login_user']; ?>" required />
                        </div>

                         <div class="form-group">
                            <input type="number" name="card_num" id="card_num" class="form-control input-field-pay" placeholder="Card Number" autocomplete="off" value="" required>
                        </div>
                       
                        
                        <div class="row">

                            <div class="col-sm-8">
                                 <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select name="exp_month" maxlength="2" class="form-control input-field-pay" id="card-expiry-month">
                                                <option >MM</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            
                                            <select name="exp_year" class="form-control input-field-pay" maxlength="4" id="card-expiry-year" >
                                                <option>YYYY</option>
                                                <?php 
                                                 $from_year = date('Y'); 
                                                 $to_year = date('Y')+10; 
                                                 for($from_year; $from_year <=$to_year;  $from_year++){ ?>
                                                <option value="<?php echo $from_year; ?>"><?php echo $from_year; ?></option>
                                                <?php } ?>
                                                <!--
                                                <option value="23">2023</option>
                                                <option value="24">2024</option>
                                                <option value="25">2025</option>
                                                <option value="26">2026</option>
                                                <option value="27">2027</option>
                                                <option value="28">2028</option>
                                                <option value="29">2029</option>
                                                <option value="30">2030</option>-->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" name="cvc" id="card-cvc" maxlength="3" class="form-control input-field-pay" autocomplete="off" placeholder="CVC" value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="display:none;">
                            <input type="text" id="user_id" name="user_id" class="form-control input-field-pay"  value="<?php echo $user_id; ?>" required="">
                        </div>
                        <div class="form-group" style="display:none;">
                            <input name="item_name" id="item_name" class="form-control input-field-pay" type="text" value="<?php echo 'Stripe Myphonesystems'; ?>">
                        </div> 
                        <div class="form-group" style="display:none;">
                            <input name="item_number" id="item_number" class="form-control input-field-pay" type="text" value="<?php echo $item_str; ?>">
                        </div> 
                        <div class="form-group" style="display:none;">
                            <input name="item_type" id="item_type" class="form-control input-field-pay" type="text" value="<?php echo $item_type; ?>">
                        </div> 
                        <!--<div class="form-group" style="display:none;">
                        <input name="gatway_order_id" id="gatway_order_id" class="form-control input-field-pay" type="text" value="<?php echo $invoice['order_id']; ?>"  required />
                        </div>  -->
                       

                        <div class="form-group text-right">
                          <button class="btn btn-secondary " type="reset">Reset</button>
                          <button type="submit" id="payBtn" class="btn btn-primary">Submit Payment</button>
                        </div>
                    </form>     
                    <?php }else{ ?>
                        <div id="payment-errors"> Something went wrong please try again.</div> 
                        <?php }                
                        }else{ ?>
                        <div id="payment-errors"> Something went wrong please try again.</div> 
                    <?php }  ?> 
                </div>
            </div>
                 
        </div>

        
        <div class="col-md-3"></div>
        <!-- <div class="col-md-4">
        	<div class="card">
        		<h6 class="card-header bg-primary text-white">
        			Some Help?
        		</h6>
        		<div class="card-body">
        			<p>Get some real help by browsing these guide from offical source.</p>
        			<ol>
        				<li> <a href="https://stripe.com/docs" target="_blank">Stripe Docs</a> </li>
        				<li> <a href="https://stripe.com/docs/checkout" target="_blank">Stripe Checkout</a></li>
        				<li> <a href="https://stripe.com/docs/error-codes" target="_blank">Stripe Error Codes</a></li>

        			</ol>
        		</div>
        	</div>
        </div> -->

    </div>

    <script>
/*
$(document).ready(function() 
{
    $("#payBtn").click(function(event) {
        event.preventDefault();

            var gatway_invoice_id = $('#gatway_invoice_id').val();
            var paid_amount = $('#paid_amount').val(); 
            var currency   = $('#currency').val();         
            var user_name  = $('#user_name').val();
            var email      = $('#email').val();
            var user_id    = $('#user_id').val();
            var item_name  = $('#item_name').val();
            var item_type  = $('#item_type').val();            
            var payment_type = 'Stripe';
            if(user_name!="" && paid_amount!="" && gatway_invoice_id!="" )
            {
                $.ajax({
                type: "POST",
                url: "ajaxStripePayments.php",
                data: {gatway_invoice_id:gatway_invoice_id, paid_amount:paid_amount, currency:currency,user_name:user_name, email:email, user_id:user_id, item_name:item_name, item_type:item_type,payment_type:payment_type },
                success: function(res){
                   if(res){
                        alert('Payment Successful!');	
                        window.location.href = 'payment_successfull.php';
                    }else{
                        alert('Data not saved');	
                    }
                }
                });
            }else{
                alert("pls fill all fields first");
	        }
    
         });
}); */
</script>

<?php require_once('footer.php'); ?> 
 
