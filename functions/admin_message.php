<?php
include "config.php";

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $sql = "SELECT `note` FROM `enquiry`";
    $result = $con->query($sql);
    if ($result && $result->num_rows > 0) {
        $adminNoteCount = 0;
        while ($row = $result->fetch_assoc()) {
            $notes = json_decode($row['note'], true);
            $lastNoteType = null;
            foreach ($notes as $note) {
                if (isset($note['type'])) {
                    $lastNoteType = $note['type'];
                }
            }
            if ($lastNoteType === 'customer') {
                $adminNoteCount++;
            }
        }
        echo $adminNoteCount;
    } else {
        echo "0";
    }
} else {
    echo "0";
}
