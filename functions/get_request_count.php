<?php
include "config.php";

if (isset($_SESSION['email'])) {
    $userId = $_SESSION['email'];
    $sql = "SELECT COUNT(*) AS `count` FROM `cart` WHERE `status` = 'request'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    echo $row['count'];
} else {
    echo '0';
}
