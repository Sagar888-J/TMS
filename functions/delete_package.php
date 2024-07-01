<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $array = array();
    $id = $_POST['id'];
    $query = "DELETE FROM `package` WHERE `id` = '$id'";
    if ($con->query($query) === TRUE) {
        $array['status'] = "success";
        $array['msg'] = "Package Deleted successful.";
    } else {
        $array['status'] = "error";
        $array['msg'] = "Deleted unsuccessful Check!";
    }
    echo json_encode($array);
}
