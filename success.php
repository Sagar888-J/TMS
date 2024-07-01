<?php
include "functions/config.php";
require 'vendor/autoload.php';

use Stripe\StripeClient;

$stripe = new StripeClient('sk_test_51PTbQmFR1i2uVQl69TzN3RqJCcVB4ov642JR8YWws4Onwh3sb06UoJRdrU3ABRCQ0Gm9H0iUtwyN6sAkn6HTJxjn00ZZAtWPAd');
\Stripe\Stripe::setApiKey('sk_test_51PTbQmFR1i2uVQl69TzN3RqJCcVB4ov642JR8YWws4Onwh3sb06UoJRdrU3ABRCQ0Gm9H0iUtwyN6sAkn6HTJxjn00ZZAtWPAd');

if (isset($_GET['session_id'])) {
    $session_id = $_GET['session_id'];
    try {
        $checkout_session = $stripe->checkout->sessions->retrieve($session_id, []);
        if ($checkout_session->payment_status === 'paid') {
            $user_id = $_SESSION['email'];
            $first_name = $_GET['first_name'];
            $last_name = $_GET['last_name'];
            $country = $_GET['country'];
            $city = $_GET['city'];
            $state = $_GET['state'];
            $zip_code = $_GET['zip_code'];
            $bill_email = $_GET['bill_email'];
            $phone = $_GET['phone'];
            $totalPrice = $_GET['totalPrice'];
            $packageName = $_GET['packageName'];
            $cartId = $_GET['cartId'];

            $sql = "INSERT INTO `billing` (`user_id`, `cart_id`, `first_name`, `last_name`, `country`, `city`, `state`, `zip_code`, `email`, `phone`, `status`)
                    VALUES ('$user_id', '$cartId', '$first_name', '$last_name', '$country', '$city', '$state', '$zip_code', '$bill_email', '$phone', 'approved')";
            if ($con->query($sql) === TRUE) {
                $bill_id = $con->insert_id;

                $payment_intent_id = $checkout_session->payment_intent;

                $payment_intent = $stripe->paymentIntents->retrieve($payment_intent_id);
                $paymentMethodId = $payment_intent->payment_method;
                $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentMethodId);

                $brand = $paymentMethod->card->brand;
                $email = $checkout_session->customer_details->email;
                $card_number = $paymentMethod->card->last4;
                $card_expiry_month = $paymentMethod->card->exp_month;
                $card_expiry_year = $paymentMethod->card->exp_year;
                $expiry = $card_expiry_month . "/" . $card_expiry_year;
                $cvc = $paymentMethod->card->checks->cvc_check;
                $cardholder_name = $checkout_session->customer_details->name;
                $country = $paymentMethod->card->country;
                $currency = $payment_intent->currency;

                $transaction_sql = "INSERT INTO `transaction`(`user_id`, `bill_id`, `selected_method`, `method_of_pay`, `brand`, `transaction_id`, `email`, `card_number`, `expiry_date`, `cvc`, `cardholder_name`, `country`, `total_payment`, `currency`) 
                                    VALUES ('$user_id', '$bill_id', 'Stripe', 'Card', '$brand', '$paymentMethodId', '$email', '$card_number', '$expiry', '$cvc', '$cardholder_name', '$country', '$totalPrice', '$currency')";
                if ($con->query($transaction_sql) === TRUE) {
?>
                    <!DOCTYPE html>
                    <html lang="en">

                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Payment Success</title>
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
                    </head>

                    <body>
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                            <?php if (isset($_SESSION['email'])) { ?>
                                Swal.fire({
                                    title: 'Payment Successful!',
                                    text: 'Click OK to go back.',
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    allowOutsideClick: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'packages.php';
                                    }
                                });
                            <?php } else { ?>
                                Swal.fire({
                                    title: '404 Not Found',
                                    text: 'The requested page could not be found.',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    allowOutsideClick: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'login.php';
                                    }
                                });
                            <?php } ?>
                        </script>
                    </body>

                    </html>
<?php
                } else {
                    echo "Error inserting transaction details: " . $con->error;
                }
            } else {
                echo "Error inserting billing details: " . $con->error;
            }
        } else {
            echo "Payment not successful.";
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo "Session ID is missing.";
}
