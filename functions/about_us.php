<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $_POST['editor'];
    $description = mysqli_real_escape_string($con, $description);

    $updateSql = "UPDATE `about_us` SET `description` = '$description'";
    if ($con->query($updateSql) === TRUE) {
        $response = [
            'status' => 'success',
            'msg' => 'About us updated successfully!'
        ];
    } else {
        $response = [
            'status' => 'error',
            'msg' => 'Error: ' . $updateSql . '<br>' . $con->error
        ];
    }
    echo json_encode($response);
}
