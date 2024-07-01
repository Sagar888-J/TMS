<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal</title>
</head>

<body>
    <div id="paypal-button-container"></div>
</body>

</html>
<script src="https://www.paypal.com/sdk/js?client-id=AZFR5cQSjcaK4vzF4veIhlTpH78Aty2mvJSU0jRN0CVseHQuTDFv_hKdimn-da_q5sz7aJMl63J2nIgh&currency=USD"></script>
<script>
    paypal.Buttons({
        style: {
            layout: 'vertical',
            color: 'gold',
            shape: 'pill',
            label: 'pay'
        },
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '99'
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                // alert('Transaction completed by ' + details.payer.name.given_name);
                // Optional: Redirect the user to a success page
                window.location.href = 'successful.php';
            });
        },
        onCancel(data) {
            // Show a cancel page, or return to cart
            window.location.href = 'cancel.php';
        }
    }).render('#paypal-button-container');
</script>