<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $array = array();
    $cartID = $_POST['cart_id']; 
    $query = "DELETE FROM `cart` WHERE `id` = '$cartID'";
    if ($con->query($query) === TRUE) {
        $array['status'] = "success";
        $array['msg'] = "Package Remove successful.";
    } else {
        $array['status'] = "error";
        $array['msg'] = "Remove unsuccessful Check!";
    }
    echo json_encode($array);
}
?>