<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $array = array();
    $packageId = $_POST['package_id'];
    $userId = $_SESSION['email'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    $sql = "INSERT INTO `cart` (`user_id`, `package_id`, `status`, `quantity`, `from_date`, `to_date`)
            VALUES ('$userId', '$packageId', 'request', '1', '$from_date', '$to_date')";
    if ($con->query($sql) === TRUE) {
        $_SESSION['package_' . $packageId . '_status'] = 'request';
        $array['status'] = "success";
        $array['msg'] = "Package added to cart successfully";
        $array['cart_status'] = "request";
    } else {
        $array['status'] = "error";
        $array['msg'] = "Error: " . $sql . "<br>" . $con->error;
        $array['cart_status'] = "";
    }
}
echo json_encode($array);
