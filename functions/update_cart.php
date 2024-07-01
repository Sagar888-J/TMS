<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $array = array();
    $packageId = $_POST['package_id'];
    $userId = $_SESSION['email'];
    $quantity = $_POST['quantity'];

    $existingCartItem = "SELECT * FROM `cart` WHERE `user_id`='$userId' AND `package_id`='$packageId'";

    if ($existingCartItem) {
        $newQuantity = $quantity;
        $sql = "UPDATE `cart` SET `quantity`='$newQuantity' WHERE `user_id`='$userId' AND `package_id`='$packageId'";

        if ($con->query($sql) === TRUE) {
            $array['status'] = "success";
            $array['msg'] = "Cart updated successfully";
        } else {
            $array['status'] = "error";
            $array['msg'] = "Error updating cart: " . $con->error;
        }
    } else {
        $array['status'] = "error";
        $array['msg'] = "Package not found in cart";
    }
}
echo json_encode($array);
