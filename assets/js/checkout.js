// Get API Key
let STRIPE_PUBLISHABLE_KEY = document.currentScript.getAttribute('STRIPE_PUBLISHABLE_KEY');

// Create an instance of the Stripe object and set your publishable API key
const stripe = Stripe(STRIPE_PUBLISHABLE_KEY);

// Define card elements
let elements;

// Select payment form element
const paymentFrm = document.querySelector("#paymentFrm");

// Get payment_intent_client_secret param from URL
const clientSecretParam = new URLSearchParams(window.location.search).get(
    "payment_intent_client_secret"
);
 
// Check whether the payment_intent_client_secret is already exist in the URL
setProcessing(true);
if(!clientSecretParam){
	
    setProcessing(false);
    
    // Create an instance of the Elements UI library and attach the client secret
    initialize();
}

// Check the PaymentIntent creation status
checkStatus();

// Attach an event handler to payment form
paymentFrm.addEventListener("submit", handleSubmit);

// Fetch a payment intent and capture the client secret
let payment_intent_id;
async function initialize() {
	
	let stripeAmount 	= document.getElementById("stripeAmount").value;
	let gatway_invoice_id = document.getElementById("gatway_invoice_id").value;
	let invoice_id 		= document.getElementById("invoice_id").value;
	let stripeCurrency 	= document.getElementById("stripeCurrency").value;	
	let payment_type 	= document.getElementById("payment_type").value;
	let user_id 		= document.getElementById("user_id").value;
	let item_name 		= document.getElementById("item_name").value;
	let item_number 	= document.getElementById("item_number").value;
	let item_type 		= document.getElementById("item_type").value;
	
	//console.log('stripeAmount>>>>>>>>>>>'+ stripeAmount+'++'+stripeCurrency+'<<item_name>>>'+item_number);
	
    const { id, clientSecret } = await fetch("payment_init.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ request_type:'create_payment_intent', stripeAmount: stripeAmount, stripeCurrency: stripeCurrency, item_name: item_number }),
    }).then((r) => r.json());
    
    const appearance = {
        theme: 'stripe',
        rules: {
            '.Label': {
                fontWeight: 'bold',
                textTransform: 'uppercase',				
            }
        }
    };
    
    elements = stripe.elements({ clientSecret, appearance });
    
    const paymentElement = elements.create("payment");
    paymentElement.mount("#paymentElement");
    
    payment_intent_id = id;
}

// Card form submit handler
async function handleSubmit(e) {
	e.preventDefault();
    setLoading(true);
    
    let customer_name 	= document.getElementById("name").value;
    let customer_email 	= document.getElementById("email").value;
    
    const { id, customer_id } = await fetch("payment_init.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ request_type:'create_customer', payment_intent_id: payment_intent_id, name: customer_name, email: customer_email }),
    }).then((r) => r.json());
   
    const { error } = await stripe.confirmPayment({
        elements,
        confirmParams: {			
			// Make sure to change this to your payment completion page
            return_url: window.location.href+'?customer_id='+customer_id,
        },
    });
    
    // This point will only be reached if there is an immediate error when
    // confirming the payment. Otherwise, your customer will be redirected to
    // your `return_url`. For some payment methods like iDEAL, your customer will
    // be redirected to an intermediate site first to authorize the payment, then
    // redirected to the `return_url`.
    if (error.type === "card_error" || error.type === "validation_error") {
        showMessage(error.message);
    } else {
        showMessage("An unexpected error occured.");
    }
    
    setLoading(false);
}

// Fetch the PaymentIntent status after payment submission
async function checkStatus() {
	
    const clientSecret = new URLSearchParams(window.location.search).get(
        "payment_intent_client_secret"
    );
    
    const customerID = new URLSearchParams(window.location.search).get(
        "customer_id"
    );
    
    if (!clientSecret) {
        return;
    }
    //console.log('clientSecret>>>>>>>>>'+clientSecret);
	//console.log('customerID>>>>>>>>>'+customerID);
	
	let stripeAmount 	= document.getElementById("stripeAmount").value;
	let gatway_invoice_id = document.getElementById("gatway_invoice_id").value;
	let invoice_id 		= document.getElementById("invoice_id").value;
	let stripeCurrency 	= document.getElementById("stripeCurrency").value;	
	let payment_type 	= document.getElementById("payment_type").value;
	let user_id 		= document.getElementById("user_id").value;
	let item_name 		= document.getElementById("item_name").value;
	let item_number 	= document.getElementById("item_number").value;
	let item_type 		= document.getElementById("item_type").value;
	let customer_name 	= document.getElementById("name").value;
    let customer_email 	= document.getElementById("email").value;
	let renew_item	= document.getElementById("renew_item").value;
	
    const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);
    
    if (paymentIntent) {
        switch (paymentIntent.status) { 
            case "succeeded":
                // Post the transaction info to the server-side script and redirect to the payment status page
                fetch("payment_init.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ request_type:'payment_insert', payment_intent: paymentIntent, customer_id: customerID,user_id:user_id,gatway_invoice_id:gatway_invoice_id,invoice_id:invoice_id, payment_type:payment_type,item_name:item_name,item_number:item_number,item_type:item_type,stripeAmount:stripeAmount, stripeCurrency:stripeCurrency,customer_name:customer_name,customer_email:customer_email,renew_item:renew_item }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.payment_txn_id) {
                        window.location.href = 'payment-status.php?pid='+data.payment_txn_id;
                    } else {
                        showMessage(data.error);
                        setReinit();
                    }
                })
                .catch(console.error);
                
                break;
            case "processing":
                showMessage("Your payment is processing.");
                setReinit();
                break;
            case "requires_payment_method":
                showMessage("Your payment was not successful, please try again.");
                setReinit();
                break;
            default:
                showMessage("Something went wrong.");
                setReinit();
                break;
        }
    } else {
        showMessage("Something went wrong.");
        setReinit();
    }
}


// Display message
function showMessage(messageText) {
    const messageContainer = document.querySelector("#paymentResponse");
    
    messageContainer.classList.remove("hidden");
    messageContainer.textContent = messageText;
    
    setTimeout(function () {
        messageContainer.classList.add("hidden");
        messageText.textContent = "";
    }, 5000);
}

// Show a spinner on payment submission
function setLoading(isLoading) {
    if (isLoading) {
        // Disable the button and show a spinner
        document.querySelector("#submitBtn").disabled = true;
        document.querySelector("#spinner").classList.remove("hidden");
        document.querySelector("#buttonText").classList.add("hidden");
    } else {
        // Enable the button and hide spinner
        document.querySelector("#submitBtn").disabled = false;
        document.querySelector("#spinner").classList.add("hidden");
        document.querySelector("#buttonText").classList.remove("hidden");
    }
}

// Show a spinner on payment form processing
function setProcessing(isProcessing) {
    if (isProcessing) {
        paymentFrm.classList.add("hidden");
        document.querySelector("#frmProcess").classList.remove("hidden");
    } else {
        paymentFrm.classList.remove("hidden");
        document.querySelector("#frmProcess").classList.add("hidden");
    }
}

// Show payment re-initiate button
function setReinit() {
    document.querySelector("#frmProcess").classList.add("hidden");
    document.querySelector("#payReinit").classList.remove("hidden");
}