<?php
include "config.php";

error_reporting(E_ERROR | E_PARSE);

require '../vendor/autoload.php';

use Stripe\StripeClient;

$stripe = new StripeClient('sk_test_51PTbQmFR1i2uVQl69TzN3RqJCcVB4ov642JR8YWws4Onwh3sb06UoJRdrU3ABRCQ0Gm9H0iUtwyN6sAkn6HTJxjn00ZZAtWPAd');

$response = [];
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['paymentMethod']) && $_POST['paymentMethod'] === 'stripe') {
        $errors = [];
        $user_id = $_SESSION['email'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $country = $_POST['country'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip_code = $_POST['zip_code'];
        $bill_email = $_POST['bill_email'];
        $phone = $_POST['phone'];
        $totalPrice = $_POST['totalPrice'];
        $packageName = $_POST['packageName'];
        $cartId = $_POST['cartId'];

        $success_query = http_build_query([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'country' => $country,
            'city' => $city,
            'state' => $state,
            'zip_code' => $zip_code,
            'bill_email' => $bill_email,
            'phone' => $phone,
            'totalPrice' => $totalPrice,
            'packageName' => $packageName,
            'cartId' => $cartId
        ]);

        // Validation //
        if (empty($first_name)) {
            $errors['first_name'] = "First name is required.";
        } elseif (!ctype_alpha($first_name)) {
            $errors['first_name'] = "First name must contain only alphabetic characters.";
        } elseif (empty($last_name)) {
            $errors['last_name'] = "Last name is required.";
        } elseif (!ctype_alpha($last_name)) {
            $errors['last_name'] = "Last name must contain only alphabetic characters.";
        } elseif (empty($country)) {
            $errors['country'] = "Country is required.";
        } elseif (empty($city)) {
            $errors['city'] = "City is required.";
        } elseif (!ctype_alpha($city)) {
            $errors['city'] = "City must contain only alphabetic characters.";
        } elseif (empty($state)) {
            $errors['state'] = "State is required.";
        } elseif (!ctype_alpha($state)) {
            $errors['state'] = "State must contain only alphabetic characters.";
        } elseif (empty($zip_code)) {
            $errors['zip_code'] = "Zip code is required.";
        } elseif (!ctype_digit($zip_code)) {
            $errors['zip_code'] = "Zip code must contain only numeric characters.";
        } elseif (empty($bill_email)) {
            $errors['bill_email'] = "Email is required.";
        } elseif (!filter_var($bill_email, FILTER_VALIDATE_EMAIL)) {
            $errors['bill_email'] = "Email must be a valid email format.";
        } elseif (empty($phone)) {
            $errors['phone'] = "Phone is required.";
        } elseif (!ctype_digit($phone) || strlen($phone) !== 10) {
            $errors['phone'] = "Phone must be a 10-digit numeric value.";
        }
        if (empty($errors)) {
            $checkout_session = $stripe->checkout->sessions->create([
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'USD',
                        'product_data' => [
                            'name' => $packageName,
                        ],
                        'unit_amount' => $totalPrice * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => 'http://localhost/Sagar/success.php?session_id={CHECKOUT_SESSION_ID}&' . $success_query,
                'cancel_url' => 'http://localhost/Sagar/cancel.php?session_id={CHECKOUT_SESSION_ID}',
            ]);
            $response = [
                'status' => 'success',
                'msg' => $checkout_session->url
            ];
        } else {
            $response = [
                'status' => 'error',
                'msg' => $errors
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'msg' => 'Invalid payment method.'
        ];
    }
} else {
    $response = [
        'status' => 'error',
        'msg' => 'Invalid request method.'
    ];
}

echo json_encode($response);
