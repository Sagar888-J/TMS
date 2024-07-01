<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = array();
    $error = [];

    $email = $_POST['email'];
    $packageId = $_POST['package_id'];
    $package_name = $_POST['package_name'];
    $price = $_POST['price'];
    $note = mysqli_real_escape_string($con, $_POST['note']);

    // Validation //
    if (empty($note)) {
        $error['note'] = "<h4>Please insert your enquiry!</h4>";
    } else {
        $fetch_sql = "SELECT `note` FROM `enquiry` WHERE `user_id` = '$email' AND `package_id` = '$packageId'";
        $fetch_result = $con->query($fetch_sql);

        if ($fetch_result->num_rows > 0) {
            $row = $fetch_result->fetch_assoc();
            $existing_notes = json_decode($row['note'], true);

            // Ensure existing_notes is an array
            if (!is_array($existing_notes)) {
                $existing_notes = array();
            }

            $existing_notes[] = array('type' => 'admin', 'note' => $note);
            $updated_note = json_encode($existing_notes);
            $update_sql = "UPDATE `enquiry` SET `note` = '$updated_note' WHERE `user_id` = '$email' AND `package_id` = '$packageId'";
            if ($con->query($update_sql) === TRUE) {
                $response['status'] = "success";
                $response['msg'] = "Response sent successfully";
            } else {
                $response['status'] = "error";
                $response['msg'] = "Error updating note: " . $con->error;
            }
        } else {
            $response['status'] = "error";
            $response['msg'] = "No existing enquiry found for this user and package.";
        }
    }

    if (!empty($error)) {
        $response['status'] = "error";
        $response['error'] = $error;
    }
    echo json_encode($response);
}
