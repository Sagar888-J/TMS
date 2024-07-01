<?php
session_start();
$host = "localhost";
$username = "root";
$password = "";
$database = "tour_management";

// Create connection
$con = new mysqli($host, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
