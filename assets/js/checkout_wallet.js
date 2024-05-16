// Get API Key
let STRIPE_PUBLISHABLE_KEY = document.currentScript.getAttribute(
  "STRIPE_PUBLISHABLE_KEY"
);

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
if (!clientSecretParam) {
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
  let stripeAmount = document.getElementById("stripeAmount").value;
  let gatway_invoice_id = document.getElementById("gatway_invoice_id").value;
  let invoice_id = document.getElementById("invoice_id").value;
  let stripeCurrency = document.getElementById("stripeCurrency").value;
  let payment_type = document.getElementById("payment_type").value;
  let user_id = document.getElementById("user_id").value;
  let item_name = document.getElementById("item_name").value;
  let item_number = document.getElementById("item_number").value;
  let item_type = document.getElementById("item_type").value;

  // console.log('stripeAmount>>>>>>>>>>>'+ stripeAmount+'++'+stripeCurrency+'<<item_name>>>'+item_number);

  const { id, clientSecret } = await fetch("payment_init_wallet.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      request_type: "create_payment_intent",
      stripeAmount: stripeAmount,
      stripeCurrency: stripeCurrency,
      gatway_invoice_id: gatway_invoice_id,
      invoice_id: invoice_id,
      item_name: item_name,
      payment_type: payment_type,
      user_id: user_id,
      item_number: item_number,
      item_type: item_type,
    }),
  }).then((r) => r.json());

  const appearance = {
    theme: "stripe",
    rules: {
      ".Label": {
        fontWeight: "bold",
        textTransform: "uppercase",
      },
    },
  };

  elements = stripe.elements({
    clientSecret,
    appearance,
  });

  const paymentElement = elements.create("payment");
  paymentElement.mount("#paymentElement");

  payment_intent_id = id;
}

// Card form submit handler
async function handleSubmit(e) {
  e.preventDefault();
  setLoading(true);
  let stripeAmount = document.getElementById("stripeAmount").value;
  let gatway_invoice_id = document.getElementById("gatway_invoice_id").value;
  let invoice_id = document.getElementById("invoice_id").value;
  let stripeCurrency = document.getElementById("stripeCurrency").value;
  let payment_type = document.getElementById("payment_type").value;
  let user_id = document.getElementById("user_id").value;
  let item_name = document.getElementById("item_name").value;
  let item_number = document.getElementById("item_number").value;
  let item_type = document.getElementById("item_type").value;
  let customer_name = document.getElementById("name").value;
  let customer_email = document.getElementById("email").value;

  const { id, customer_id } = await fetch("payment_init_wallet.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      request_type: "create_customer",
      payment_intent_id: payment_intent_id,
      user_id: user_id,
      gatway_invoice_id: gatway_invoice_id,
      invoice_id: invoice_id,
      payment_type: payment_type,
      item_name: item_name,
      item_number: item_number,
      item_type: item_type,
      stripeAmount: stripeAmount,
      stripeCurrency: stripeCurrency,
      name: customer_name,
      email: customer_email,
    }),
  }).then((r) => r.json());

  console.log("sd>>>>>>>", gatway_invoice_id);
  const { error } = await stripe.confirmPayment({
    elements,
    confirmParams: {
      // Make sure to change this to your payment completion page
      return_url:
        window.location.href +
        "?customer_id=" +
        customer_id +
        "&gatway_invoice_id=" +
        gatway_invoice_id +
        "&invoice_id=" +
        invoice_id +
        "&item_name=" +
        item_name +
        "&stripeAmount=" +
        stripeAmount +
        "&stripeCurrency=" +
        stripeCurrency +
        "&name=" +
        name +
        "&email=" +
        email,
    },
  });

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

  const gatway_invoiceID = new URLSearchParams(window.location.search).get(
    "gatway_invoice_id"
  );

  const invoice_ID = new URLSearchParams(window.location.search).get(
    "invoice_id"
  );

  const item_nameID = new URLSearchParams(window.location.search).get(
    "item_name"
  );

  const stripeAmountID = new URLSearchParams(window.location.search).get(
    "stripeAmount"
  );

  const stripeCurrencyID = new URLSearchParams(window.location.search).get(
    "stripeCurrency"
  );

  const nameID = new URLSearchParams(window.location.search).get("name");

  const emailID = new URLSearchParams(window.location.search).get("email");

  if (!clientSecret) {
    return;
  }

  console.log("clientSecret>>>>>>>>>" + clientSecret);
  console.log("customerID>>>>>>>>>" + customerID);
  console.log("gatway_invoiceID>>>>>>>>>" + gatway_invoiceID);
  console.log("invoice_ID>>>>>>>>>" + invoice_ID);
  console.log("item_nameID>>>>>>>>>" + item_nameID);
  console.log("stripeAmountID>>>>>>>>>" + stripeAmountID);

  // var stripeAmount = document.getElementById("stripeAmount").value;
  // var gatway_invoice_id = document.getElementById("gatway_invoice_id").value;
  // var invoice_id = document.getElementById("invoice_id").value;
  // var stripeCurrency = document.getElementById("stripeCurrency").value;
  // var payment_type = document.getElementById("payment_type").value;
  // var user_id = document.getElementById("user_id").value;
  // var item_name = document.getElementById("item_name").value;
  //var customer_name = document.getElementById("name").value;
  var item_number = document.getElementById("item_number").value;
  var item_type = document.getElementById("item_type").value;
  var customer_email = document.getElementById("email").value;
  var payment_type = document.getElementById("payment_type").value;

  console.log(
    "Element val>>>>>>>>",
    document.getElementById("stripeAmount").value
  );

  const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);

  if (paymentIntent) {
    switch (paymentIntent.status) {
      case "succeeded":
        console.log("Value from variable>>>>>>>>>>>", stripeAmount);
        // Post the transaction info to the server-side script and redirect to the payment status page
        fetch("payment_init_wallet.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            request_type: "payment_insert",
            payment_intent: paymentIntent,
            customer_id: customerID,
            user_id: user_id,
            gatway_invoice_id: gatway_invoiceID,
            invoice_id: invoice_ID,
            payment_type: payment_type,
            item_name: item_nameID,
            item_number: item_number,
            item_type: item_type,
            stripeAmount: stripeAmountID,
            stripeCurrency: stripeCurrencyID,
            customer_name: nameID,
            customer_email: customer_email,
          }),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.payment_txn_id) {
              window.location.href =
                // "payment-status.php?pid=" + data.payment_txn_id;
                "payment_successfull.php"
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
