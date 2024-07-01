<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tour Management System</title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.css?v=<?php echo rand(); ?>" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <!-- Bootstrap Datepicker CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <!-- Standard jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <!-- SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Package notification -->
    <script>
        // Cart request message //
        function updateCartCounter() {
            $.ajax({
                url: 'functions/get_cart_count.php',
                type: 'GET',
                success: function(data) {
                    $('#cartCount').text(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        updateCartCounter();
        // Payment request message //
        function updateRequestcounter() {
            $.ajax({
                url: 'functions/get_request_count.php',
                type: 'GET',
                success: function(data) {
                    $('#requestCount').text(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        updateRequestcounter();
    </script>

    <!-- Enquiry notification -->
    <script>
        //Admin notification//
        function adminMessage() {
            $.ajax({
                url: 'functions/admin_message.php',
                type: 'GET',
                success: function(data) {
                    $('#adminMessage').text(data);
                    $('#message').addClass('glow').attr('package-id', data.packageID);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        adminMessage();
        //Customer notification//
        function customerMessage() {
            $.ajax({
                url: 'functions/customer_message.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        $('#customerMessage').text(data.error);
                        $('#message').text(data.error);
                    } else {
                        $('#customerMessage').text(data.count);
                        $('#message').addClass('glow').attr('package-id', data.packageID);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        customerMessage();
    </script>
</head>