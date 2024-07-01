<?php
include "config.php";

if (isset($_SESSION['email'])) {
    $userId = $_SESSION['email'];
    $sql = "SELECT COUNT(*) AS `count` FROM `cart` WHERE `status` = 'request' AND `user_id` = '$userId'";
    $result = $con->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        echo $row['count'];
    } else {
        echo '0';
    }
} else {
    echo '0';
}