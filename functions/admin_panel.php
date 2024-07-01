<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['package_id'])) {
    $userId = $_POST['email'];
    $packageId = $_POST['package_id'];

    $fetch_sql = "SELECT `note` FROM `enquiry` WHERE `user_id` = '$userId' AND `package_id` = '$packageId'";
    $fetch_result = $con->query($fetch_sql);
    $all_notes = array();

    if ($fetch_result->num_rows > 0) {
        while ($row = $fetch_result->fetch_assoc()) {
            $notes = json_decode($row['note'], true);
            $all_notes = array_merge($all_notes, $notes);
        }
    }

    if (empty($all_notes)) {
        echo "";
    } else {
        foreach ($all_notes as $note) {
            if ($note['type'] == 'customer') {
                echo "<div class='row justify-content-start text-left'>";
                echo "<div class='col-lg-5 message_left ml-3'>";
            } else {
                echo "<div class='row justify-content-end text-right'>";
                echo "<div class='col-lg-5 message_right mr-3'>";
            }
            echo "<div class='chat-box'>";
            echo htmlspecialchars($note['note']);
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    }
} else {
    echo "Invalid request";
}
