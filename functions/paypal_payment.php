<?php
include "config.php";

error_reporting(E_ERROR | E_PARSE);
$response = [];
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $input = json_decode(file_get_contents('php://input'), true);

    $first_name = $input['first_name'];
    $last_name = $input['last_name'];
    $country = $input['country'];
    $city = $input['city'];
    $state = $input['state'];
    $zip_code = $input['zip_code'];
    $bill_email = $input['bill_email'];
    $phone = $input['phone'];
    $totalPrice = $input['totalPrice'];
    $packageName = $input['packageName'];
    $cartID = $input['cartId'];

    if (isset($input['paymentMethod'])) {
        if ($input['paymentMethod'] === 'paypal') {
            $user_id = $_SESSION['email'];

            $billing_sql = "INSERT INTO `billing` (`user_id`, `cart_id`, `first_name`, `last_name`, `country`, `city`, `state`, `zip_code`, `email`, `phone`, `status`)
                            VALUES ('$user_id', '$cartID', '$first_name', '$last_name', '$country', '$city', '$state', '$zip_code', '$bill_email', '$phone', 'pending')";
            if ($con->query($billing_sql) === TRUE) {
                $bill_id = $con->insert_id;
                $_SESSION['cart_id'] = $cartID;
                // Extract transaction details
                $transactionDetails = $input['transactionDetails'];
                $transactionID = $transactionDetails['id'];
                $status = $transactionDetails['status'];
                $amount = $transactionDetails['purchase_units'][0]['amount']['value'];
                $currency = $transactionDetails['purchase_units'][0]['amount']['currency_code'];
                $email = $transactionDetails['payer']['email_address'];
                $card_number = substr($transactionDetails['payer']['payer_id'], -4);
                $expiry = 'N/A';
                $cvc = 'pass';
                $cardholder_name = $transactionDetails['payer']['name']['given_name'] . ' ' . $transactionDetails['payer']['name']['surname'];
                $brand = 'PayPal';
                // Insert transaction data
                $transaction_sql = "INSERT INTO `transaction`(`user_id`, `bill_id`, `selected_method`, `method_of_pay`, `brand`, `transaction_id`, `email`, `card_number`, `expiry_date`, `cvc`, `cardholder_name`, `country`, `total_payment`, `currency`) 
                                    VALUES ('$user_id', '$bill_id', 'PayPal', 'Card', '$brand', '$transactionID', '$email', '$card_number', '$expiry', '$cvc', '$cardholder_name', '$country', '$totalPrice', '$currency')";
                if ($con->query($transaction_sql) === TRUE) {
                    $response = [
                        'status' => 'success',
                        'msg' => 'http://localhost/Sagar/successful.php'
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'msg' => 'Transaction data insertion failed'
                    ];
                }
            } else {
                $response = [
                    'status' => 'error',
                    'msg' => 'Billing data insertion failed'
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
            'msg' => 'Payment method not specified.'
        ];
    }
}

echo json_encode($response);
