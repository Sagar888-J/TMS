<?php
include "config.php";
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $array = array();
    $package_name = $_POST['package_name'];
    $place_name = $_POST['place_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $filename = $_FILES["upload"]["name"];
    $tempname = $_FILES["upload"]["tmp_name"];

    $errors = [];

    if (empty($package_name)) {
        $errors['package_name'] = "Package name is required.";
    } elseif (!preg_match("/^[a-zA-Z\s\-]+$/", $package_name)) {
        $errors['package_name'] = "Package name should contain only alphabets, spaces, and hyphens.";
    } elseif (empty($place_name)) {
        $errors['place_name'] = "Place name is required.";
    } elseif (!preg_match("/^[a-zA-Z\s\-]+$/", $place_name)) {
        $errors['place_name'] = "Place name should contain only alphabets, spaces, and hyphens.";
    } elseif (empty($filename)) {
        $errors['upload'] = "Image is required.";
    } elseif (empty($price)) {
        $errors['price'] = "Price is required.";
    } elseif (!is_numeric($price)) {
        $errors['price'] = "Price should contain only numeric values.";
    } elseif (empty($description)) {
        $errors['description'] = "Description is required.";
    } else {
        $folder = "uploads/" . $filename;
        if (move_uploaded_file($tempname, $folder)) {
            $query = "INSERT INTO `package`(`package_name`, `place_name`, `image`, `price`, `description`) 
                  VALUES ('$package_name','$place_name','$folder','$price','$description')";
            if ($con->query($query) === TRUE) {
                $array['status'] = "success";
                $array['msg'] = "Package created successfully.";
            } else {
                $array['status'] = "error";
                $array['msg'] = "Error: " . $query . "<br>" . $con->error;
            }
        } else {
            $array['status'] = "error";
            $array['msg'] = "Sorry, there was an error uploading your file.";
        }
    }

    if (!empty($errors)) {
        $array['status'] = "error";
        $array['errors'] = $errors;
    }

    echo json_encode($array);
}
