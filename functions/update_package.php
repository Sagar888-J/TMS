<?php
include "config.php";
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $array = array();
    $id = $_POST['id'];
    $package_name = $_POST['package_name'];
    $place_name = $_POST['place_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $filename = $_FILES["upload"]["name"];
    $tempname = $_FILES["upload"]["tmp_name"];
    $folder = "uploads/";

    $errors = [];
    if (empty($package_name)) {
        $errors[] = "Package name is required.";
    }
    if (empty($place_name)) {
        $errors[] = "Place name is required.";
    }
    if (empty($price)) {
        $errors[] = "Price is required.";
    }
    if (empty($description)) {
        $errors[] = "Description is required.";
    }

    if (!empty($errors)) {
        $array['status'] = "error";
        $array['msg'] = implode(" ", $errors);
    } else {
        // Check if a new file is uploaded
        if (!empty($filename)) {
            // Append the filename to the upload folder path
            $folder .= $filename;

            // Move the uploaded file to the destination folder
            if (move_uploaded_file($tempname, $folder)) {
                // Prepare the UPDATE statement with image field included
                $query = "UPDATE `package` SET `package_name`=?, `place_name`=?, `price`=?, `image`=?, `description`=? WHERE `id`=?";
                $stmt = $con->prepare($query);

                if ($stmt) {
                    // Bind parameters
                    $stmt->bind_param("ssdssi", $package_name, $place_name, $price, $folder, $description, $id);

                    // Execute the statement
                    if ($stmt->execute()) {
                        $array['status'] = "success";
                        $array['msg'] = "Package updated successfully with new image.";
                    } else {
                        $array['status'] = "error";
                        $array['msg'] = "Error updating package: " . $stmt->error;
                    }

                    // Close statement
                    $stmt->close();
                } else {
                    $array['status'] = "error";
                    $array['msg'] = "Error preparing update statement: " . $con->error;
                }
            } else {
                $array['status'] = "error";
                $array['msg'] = "Sorry, there was an error uploading your new file.";
            }
        } else {
            // No new file uploaded, update without changing image field
            $query = "UPDATE `package` SET `package_name`=?, `place_name`=?, `price`=?, `description`=? WHERE `id`=?";
            $stmt = $con->prepare($query);

            if ($stmt) {
                // Bind parameters
                $stmt->bind_param("ssdsi", $package_name, $place_name, $price, $description, $id);

                // Execute the statement
                if ($stmt->execute()) {
                    $array['status'] = "success";
                    $array['msg'] = "Package updated successfully with existing data.";
                } else {
                    $array['status'] = "error";
                    $array['msg'] = "Error updating package: " . $stmt->error;
                }

                // Close statement
                $stmt->close();
            } else {
                $array['status'] = "error";
                $array['msg'] = "Error preparing update statement: " . $con->error;
            }
        }
    }

    // Output JSON response
    header('Content-Type: application/json');
    echo json_encode($array);
}
