<?php
include "config.php";

error_reporting(E_ERROR | E_PARSE);

$response = [];
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['paymentMethod']) && $_POST['paymentMethod'] === 'paypal') {
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

        // Validation//
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
            $response = [
                'status' => 'success',
                'msg' => 'success'
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
