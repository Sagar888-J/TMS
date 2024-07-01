<?php
include "designs/header.php";
include "designs/sidebar.php";

if (isset($_SESSION['email'])) {
    if ($_SESSION['role'] === "customer") {
        echo "<script>";
        echo "swal({
                title: 'Access Denied',
                text: 'You are not authorized to access this page.',
                icon: 'warning',
                buttons: {
                    confirm: {
                        text: 'OK',
                        className: 'sweet-alert-confirm-btn',
                        closeModal: true
                    }
                },
                dangerMode: true,
            }).then((value) => {
                window.location.href = 'detail.php';
            });";
        echo "</script>";
        exit;
    }
}

?>
<!-- Customer Detail Start -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <table class="table table-hover table-purple">
            <thead>
                <tr>
                    <td>
                        <h2>All Customer's Transaction</h2>
                    </td>
                </tr>
            </thead>
        </table>
        <div class="table-responsive">
            <div class="col-lg-12">
                <table class="table table-hover table-purple">
                    <thead>
                        <tr align="center">
                            <th>Sr.No.</th>
                            <th>User Email</th>
                            <th>Type of Method</th>
                            <th>Payment Method</th>
                            <th>Card Brand</th>
                            <th>Payment ID</th>
                            <th>Payment Email</th>
                            <th>Card Number</th>
                            <th>Expiry Date</th>
                            <th>CVC</th>
                            <th>Cardholder Name</th>
                            <th>Country</th>
                            <th>Total Payment</th>
                            <th>Currency</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $t = "SELECT * FROM `transaction`";
                        $result = $con->query($t);
                        if ($result->num_rows > 0) {
                            $s = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<td align='center'>" . $s . "</td>";
                                echo "<td>" . $row['user_id'] . "</td>";
                                echo "<td>" . $row['selected_method'] . "</td>";
                                echo "<td>" . $row['method_of_pay'] . "</td>";
                                echo "<td>" . $row['brand'] . "</td>";
                                echo "<td>" . $row['transaction_id'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>****" . $row['card_number'] . "</td>";
                                echo "<td>" . $row['expiry_date'] . "</td>";
                                echo "<td>" . $row['cvc'] . "</td>";
                                echo "<td>" . $row['cardholder_name'] . "</td>";
                                echo "<td>" . $row['country'] . "</td>";
                                echo "<td>$" . $row['total_payment'] . "</td>";
                                echo "<td>" . $row['currency'] . "</td>";
                                echo "</tr>";
                                $s++;
                            }
                        } else {
                            echo "<tr><td colspan='14'>No transaction record found!</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- 
<script>
    //Customer insertion script//
    $(document).ready(function() {
        $('#form').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: 'functions/register.php',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        swal("Success!", response.msg, "success").then(function() {
                            window.location.href = "login.php";
                        });
                    } else if (response.status == 'error') {
                        showErrorMessages(response.errors);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("An error occurred while processing your request. Please try again later.");
                }
            });
        });

        function showErrorMessages(errors) {
            $('.error').remove();
            for (let field in errors) {
                let errorMsg = errors[field];
                let inputField = $('[name="' + field + '"]');
                if (field === 'gender') {
                    $('#gender').html('<span class="error text-danger">' + errorMsg + '</span>');
                } else {
                    let errorElement = $('<span class="error text-danger">' + errorMsg + '</span>');
                    inputField.after(errorElement);
                }
            }
            setTimeout(function() {
                $('.error').fadeOut(500, function() {
                    $(this).remove();
                });
            }, 1500);
        }
    });
    //Customer delete Function//
    function deleteCustomer(id) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this customer!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'POST',
                        url: 'functions/delete.php',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 'success') {
                                swal("Success!", response.msg, "success");
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else if (response.status == 'error') {
                                swal("Error!", response.msg, "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            console.log(error);
                            swal("Error!", "An error occurred while processing your request. Please try again later.", "error");
                        }
                    });
                } else {
                    swal("Cancelled", "Customer deletion cancelled!", "info");
                }
            });
    }
    //Customer Edit Function//
    function editCustomer(id) {
        window.location.href = "edit.php?id=" + id;
    }
</script> -->
<?php
include "designs/footer.php";
?>