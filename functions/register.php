<?php
include "config.php";
error_reporting(E_ERROR | E_PARSE);

$array = array();
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $con_password = md5($_POST['con_password']);
    $phone = $_POST['phone'];

    $errors = [];
    // Validations //
    if (empty($first_name)) {
        $errors['first_name'] = "First name is required.";
    } elseif (!preg_match("/^[a-zA-Z]+$/", $first_name)) {
        $errors['first_name'] = "First name should contain only alphabetic characters.";
    } elseif (empty($last_name)) {
        $errors['last_name'] = "Last name is required.";
    } elseif (!preg_match("/^[a-zA-Z]+$/", $last_name)) {
        $errors['last_name'] = "Last name should contain only alphabetic characters.";
    } elseif (empty($dob)) {
        $errors['dob'] = "Date of birth is required.";
    } else {
        $current_date = new DateTime();
        $provided_dob = new DateTime($dob);
        $age = $current_date->diff($provided_dob)->y;
        if ($age < 18) {
            $errors['dob'] = "You must be at least 18 years old to register.";
        } elseif (empty($gender)) {
            $errors['gender'] = "Gender is required.";
        } elseif (empty($email)) {
            $errors['email'] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format.";
        } else {
            $email_query = "SELECT * FROM `customer_form` WHERE `email` = '$email'";
            $email_result = $con->query($email_query);
            if ($email_result->num_rows > 0) {
                $errors['email'] = "Email already exists. Please use a different email.";
            } elseif (empty($_POST['password'])) {
                $errors['password'] = "Password is required.";
            } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/', $_POST['password'])) {
                $errors['password'] = "Password should contains at least one uppercase letter, one lowercase letter, one numeric digit, and one special symbol.";
            } elseif (empty($_POST['con_password'])) {
                $errors['con_password'] = "Confirm password is required.";
            } elseif ($password !== $con_password) {
                $errors['con_password'] = "Passwords does not match.";
            } elseif (empty($phone)) {
                $errors['phone'] = "Phone number is required.";
            } elseif (!is_numeric($phone) || strlen($phone) !== 10) {
                $errors['phone'] = "Phone number should contain exactly 10 numeric characters.";
            } else {
                $query = "INSERT INTO `customer_form`(`first_name`, `last_name`, `dob`, `gender`, `email`, `password`, `con_password`, `phone`, `role`) 
                          VALUES ('$first_name','$last_name','$dob','$gender','$email','$password','$con_password','$phone','customer')";
                if ($con->query($query) === TRUE) {
                    $array['status'] = "success";
                    $array['msg'] = "Account created successfully";
                } else {
                    $array['status'] = "error";
                    $array['errors']['general'] = "Error: " . $query . "<br>" . $con->error;
                }
            }
        }
    }
    if (!empty($errors)) {
        $array['status'] = "error";
        $array['errors'] = $errors;
    }
}

echo json_encode($array);
