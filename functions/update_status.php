<?php
include 'config.php';

if (isset($_POST['customerID'])) {
    $array = array();
    $customerID = $_POST['customerID'];
    $query = "UPDATE `cart` SET `status` = 'approved' WHERE `user_id` = (
                SELECT `email` FROM `customer_form` WHERE `id` = '$customerID'
              )";
    if ($con->query($query) === TRUE) {
        $array['status'] = "success";
        $array['msg'] = "approved successful!";
    } else {
        $array['status'] = "error";
        $array['msg'] = "Error: " . $query . "<br>" . $con->error;
    }
    echo json_encode($array);
}
?>
