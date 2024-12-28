<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Payment page</title>
  <script src="https://js.stripe.com/v3/"></script> <!-- Library for Stripe Checkout -->
  <link rel="stylesheet" type="text/css" href="styles/payment_style.css">
</head>
<body>
  <form id="payment-form">
    <div class="form-group">
      <label for="card-element">Card Details</label>
      <div id="card-element" class="form-control">
        <!-- Stripe Card Element will be inserted here -->
      </div>
    </div>
    
    <input type="hidden" name="amount" value="1000"> <!-- Value is in cents, so $10 = 1000 cents -->

    <button type="submit" class="btn btn-primary">Pay $10</button>
  </form>

  <script>
  // Replace 'pk_test_51NG9WBInZK0lv3xoeqbPQud0SGUHO65AD8z1aH1nMjyzSGriVfPzcExeaU02JWd6FSoI2rW1SUjBGvU1atE0oMcZ00ZwaMGOP3' with your own API key
  const stripe = Stripe('pk_test_51NG9WBInZK0lv3xoeqbPQud0SGUHO65AD8z1aH1nMjyzSGriVfPzcExeaU02JWd6FSoI2rW1SUjBGvU1atE0oMcZ00ZwaMGOP3');

  const elements = stripe.elements();
  const cardElement = elements.create('card');

  cardElement.mount('#card-element');

  const form = document.getElementById('payment-form');

  form.addEventListener('submit', async (event) => {
    event.preventDefault();

    // Disable the submit button to prevent multiple submissions
    form.querySelector('button').disabled = true;

    const { paymentMethod, error } = await stripe.createPaymentMethod({
      type: 'card',
      card: cardElement,
    });

    if (error) {
      // Display an error message to the user
      const errorElement = document.getElementById('card-errors');
      errorElement.textContent = error.message;
    } else {
      // The payment method was created successfully, you can send the paymentMethod.id to your server to complete the payment
      console.log(paymentMethod);
    }

    // Enable the submit button
    form.querySelector('button').disabled = false;
  });

  </script>
</body>
</html>