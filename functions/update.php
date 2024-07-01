<?php
include "config.php";
error_reporting(E_ERROR | E_PARSE);

//Customer Insertion//
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $array = array();
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if (empty($first_name) || empty($last_name) || empty($dob) || empty($email) || empty($phone)) {
        $array['status'] = "error";
        $array['msg'] = "Please fill in all fields.";
    } else {
        if (!preg_match("/^[a-zA-Z]+$/", $first_name)) {
            $array['status'] = "error";
            $array['msg'] = "First name should contain only alphabets.";
        } elseif (!preg_match("/^[a-zA-Z]+$/", $last_name)) {
            $array['status'] = "error";
            $array['msg'] = "Last name should contain only alphabets.";
        } elseif (empty($gender)) {
            $array['status'] = "error";
            $array['msg'] = "Please select gender.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $array['status'] = "error";
            $array['msg'] = "Invalid email format.";
        } elseif (!is_numeric($phone) || strlen($phone) < 10 || strlen($phone) > 10) {
            $array['status'] = "error";
            $array['msg'] = "Phone number should contain only numeric characters upto 10.";
        } else {
            // Check if date of birth is at least 18 years ago
            $current_date = new DateTime();
            $provided_dob = new DateTime($dob);
            $age = $current_date->diff($provided_dob)->y;

            if ($age < 18) {
                $array['status'] = "error";
                $array['msg'] = "You must be at least 18 years old to register.";
            } else {
                // Update data in the database
                $query = "UPDATE `customer_form` SET `first_name`='$first_name', `last_name`='$last_name', `dob`='$dob', `gender`='$gender', 
                            `email`='$email', `phone`='$phone', `role`='customer' WHERE `id` = '$id'";
                if ($con->query($query) === TRUE) {
                    $array['status'] = "success";
                    $array['msg'] = "Data updated successfully";
                } else {
                    $array['status'] = "error";
                    $array['msg'] = "Error updating record: " . $con->error;
                }
            }
        }
    }
}
echo json_encode($array);
