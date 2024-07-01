<?php
include "functions/config.php";

if (isset($_SESSION['cart_id'])) {
    $cart_id = $_SESSION['cart_id'];
    unset($_SESSION['cart_id']);

    $update_sql = "UPDATE `billing` SET `status` = 'approved' WHERE `cart_id` = '$cart_id'";

    if ($con->query($update_sql) === TRUE) {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Payment Success</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
        </head>

        <body>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    title: 'Payment Successful!',
                    text: 'Click OK to go back.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'packages.php';
                    }
                });
            </script>
        </body>

        </html>
    <?php
    } else {
        echo "Error updating billing status: " . $con->error;
    ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Error</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
        </head>

        <body>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    title: '404 Not Found',
                    text: 'The requested page could not be found.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'login.php';
                    }
                });
            </script>
        </body>

        </html>
<?php
    }
} else {
    echo "Cart ID not found in session.";
}
?>