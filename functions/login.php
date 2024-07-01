<?php
include "config.php";

error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $array = array();
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email and password
    if (empty($email)) {
        $array['status'] = "error";
        $array['errors']['email'] = "Please enter your email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $array['status'] = "error";
        $array['errors']['email'] = "Invalid email format.";
    } elseif (empty($password)) {
        $array['status'] = "error";
        $array['errors']['password'] = "Please enter your password.";
    } else {
        $query = "SELECT * FROM `customer_form` WHERE `email` = '$email'";
        $result = $con->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (md5($password) === $row['con_password']) {
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $row['role'];
                if ($row['role'] === "admin") {
                    $array['status'] = "success";
                    $array['msg'] = "Admin login successful!";
                } else {
                    $array['status'] = "success";
                    $array['msg'] = "Customer Login successful!";
                }
            } else {
                $array['status'] = "error";
                $array['errors']['password'] = "Incorrect password.";
            }
        } else {
            $array['status'] = "error";
            $array['errors']['email'] = "Email does not exist!";
        }
    }

    // Return JSON response
    echo json_encode($array);
}
