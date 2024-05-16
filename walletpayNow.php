<?php require_once('header.php'); ?>
<style>
    .form-control {
        height:45px;
    }
</style>
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
        <div class="row">	
    <div class="col-md-3"></div>
        <div class="col-md-6">
            
            <div class="card">
                <h4 class="card-header bg-primary text-white text-center p-4" style="padding:10px;">Callanalog Payment Form</h4>
                <div class="card-body bg-light">
                    <div id="payment-errors"></div> 
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
                    <form method="post" id="paymentFrm">                     
                        <div class="form-group">
                            <input name="gatway_invoice_id" id="gatway_invoice_id" class="form-control input-field-pay" type="text" value="<?php echo $rowid['invoice_id']; ?>"  readonly required="">
                        </div>  
                        <div class="form-group" style="display:none;">
                            <input name="invoice_id" id="invoice_id" class="form-control input-field-pay" type="text" value="<?php echo $rowid['id']; ?>"  required />
                        </div> 
                        <div class="form-group">
                            <input name="paid_amount" id="paid_amount" class="form-control input-field-pay" type="hidden" value="<?php echo $rowid['invoice_amount']; ?>" readonly required="">
                        </div>  
                        <div class="form-group">
                            <input name="currency" id="currency" class="form-control input-field-pay" type="text" value="<?php echo $rowid['invoice_currency']; ?>" readonly required="">
                        </div>  

                        <div class="form-group">
                            <input type="text" name="user_name" id="user_name" class="form-control input-field-pay" placeholder="Card Holder Name" value="<?php echo $user_row['firstname']; ?>" readonly required="">
                        </div>                       

                        <div class="form-group">
                            <input type="email" id="email" name="email" class="form-control input-field-pay" placeholder="example@gmail.com" value="<?php echo $_SESSION['login_user']; ?>" readonly required="">
                        </div>

                        <div class="form-group" style="display:none;">
                            <input type="text" id="user_id" name="user_id" class="form-control input-field-pay"  value="<?php echo $user_id; ?>" required="">
                        </div>

                        <div class="form-group" style="display:none;">
                            <input name="item_name" id="item_name" class="form-control input-field-pay" type="text" value="<?php echo 'Stripe Myphonesystems'; ?>">
                        </div>  
                        <div class="form-group" style="display:block;">
                            <input name="item_number" id="item_number" class="form-control input-field-pay" type="text" value="<?php echo $item_str; ?>" readonly>
                        </div>

                        <div class="form-group" style="display:none;">
                            <input name="item_type" id="item_type" class="form-control input-field-pay" type="text" value="<?php echo $item_type; ?>">
                        </div>      

                        <div class="form-group text-right">
                          <button class="btn btn-warning " type="reset">Reset</button>
                          <button type="button" id="payBtn" name="submit" class="btn btn-primary">Submit Payment</button>
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
    </div>
    <script>

$(document).ready(function() 
{
    $("#payBtn").click(function(event) {
        event.preventDefault();

        document.getElementsByClassName("loader")[0].style.display = "block";
        $(this).prop("disabled", true);
        $(this).css({
            "opacity": ".2",
            "cursor": "progress"
        });

        var gatway_invoice_id = $('#gatway_invoice_id').val();
        var paid_amount = $('#paid_amount').val(); 
        var currency   = $('#currency').val();         
        var user_name  = $('#user_name').val();
        var email      = $('#email').val();
        var user_id    = $('#user_id').val();
        var item_name  = $('#item_name').val();
        var item_number  = $('#item_number').val();
        // alert(item_number);
        var item_type  = $('#item_type').val();  
        var invoice_id  = $('#invoice_id').val();          
        var payment_type = 'Wallet';
        if(user_name!="" && paid_amount!="" && gatway_invoice_id!="" )
        {
            $.ajax({
            type: "POST",
            url: "ajaxWalletPayments.php",
            dataType: 'JSON',
            data: {gatway_invoice_id:gatway_invoice_id,invoice_id:invoice_id, paid_amount:paid_amount, currency:currency,user_name:user_name, email:email, user_id:user_id, item_name:item_name, item_number:item_number, item_type:item_type,payment_type:payment_type },
            success: function(res){
                if(res){
                    if(res.Status == 'Success'){
                      //  alert('Payment Successful!');	
                        window.location.href = 'payment_successfull.php';
                    }else{
                        alert(res.message);
                        window.location.href = 'payment_error.php';
                    }                        
                }else{
                    alert('Data not saved');	
                }
            }
            });
        }else{
            alert("pls fill all fields first");
        }

    });
});
</script>


<?php require_once('footer.php'); ?> 
