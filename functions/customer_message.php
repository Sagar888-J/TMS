<?php
include "config.php";

$response = [];

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $sql = "SELECT `package_id`, `note` FROM `enquiry` WHERE `user_id` = '$email'";
    $result = $con->query($sql);
    if ($result && $result->num_rows > 0) {
        $count = 0;
        $packageID = '';
        while ($row = $result->fetch_assoc()) {
            $notes = json_decode($row['note'], true);
            $lastNoteType = null;
            $package_id = $row['package_id'];
            foreach ($notes as $note) {
                if (isset($note['type'])) {
                    $lastNoteType = $note['type'];
                }
            }
            if ($lastNoteType === 'admin') {
                $count++;
                $packageID = $package_id;
            }
        }
        $response['count'] = $count;
        $response['packageID'] = $packageID;
    } else {
        $response['count'] = 0;
        $response['id'] = '';
    }
} else {
    $response['error'] = 'User not logged in';
}

echo json_encode($response);
