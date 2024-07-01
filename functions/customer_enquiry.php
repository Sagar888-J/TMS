<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = array();
    $error = [];

    $userId = $_SESSION['email'];
    $packageId = $_POST['package_id'];
    $package_name = $_POST['package_name'];
    $price = $_POST['price'];
    $note = mysqli_real_escape_string($con, $_POST['note']);

    // Validation //
    if (empty($note)) {
        $error['note'] = "<h4>Please insert your enquiry!</h4>";
    } else {
        $fetch_sql = "SELECT `note` FROM `enquiry` WHERE `user_id` = '$userId' AND `package_id` = '$packageId'";
        $fetch_result = $con->query($fetch_sql);

        if ($fetch_result->num_rows > 0) {
            $row = $fetch_result->fetch_assoc();
            $existing_notes = json_decode($row['note'], true);

            $existing_notes[] = array('type' => 'customer', 'note' => $note);
            $updated_note = json_encode($existing_notes);
            $update_sql = "UPDATE `enquiry` SET `note` = '$updated_note' WHERE `user_id` = '$userId' AND `package_id` = '$packageId'";
            if ($con->query($update_sql) === TRUE) {
                $response['status'] = "success";
                $response['msg'] = "Enquiry sent successfully";
            } else {
                $response['status'] = "error";
                $response['msg'] = "Error updating note: " . $con->error;
            }
        } else {
            $noteJSON = json_encode(array(array('type' => 'customer', 'note' => $note)));
            $insert_sql = "INSERT INTO `enquiry`(`user_id`, `package_id`, `package_name`, `price`, `note`) VALUES ('$userId', '$packageId', '$package_name', '$price', '$noteJSON')";
            if ($con->query($insert_sql) === TRUE) {
                $response['status'] = "success";
                $response['msg'] = "Enquiry sent successfully";
            } else {
                $response['status'] = "error";
                $response['msg'] = "Error inserting new record: " . $con->error;
            }
        }
    }

    if (!empty($error)) {
        $response['status'] = "error";
        $response['error'] = $error;
    }
    echo json_encode($response);
}
