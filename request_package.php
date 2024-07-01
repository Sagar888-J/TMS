<?php
include "designs/header.php";
include "designs/sidebar.php";

if (isset($_SESSION['email'])) {
    if ($_SESSION['role'] === "customer") {
        echo "<script>alert('Access Denied: You are not authorized to access this page.');</script>";
        echo "<script>window.location.href = 'detail.php';</script>";
        exit;
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="table-responsive">
            <div class="col-lg-12">
                <table class="table table-hover table-purple">
                    <thead>
                        <tr>
                            <td colspan="9">
                                <h3>All Customer's Package Request</h3>
                            </td>
                        </tr>
                        <tr align="center">
                            <th>Sr.No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Package Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $q = "SELECT DISTINCT cust.id AS CustomerID, CONCAT(cust.first_name, ' ', cust.last_name) AS Name, cust.email AS Email, 
                                p.package_name AS PackageName, p.price AS Price, c.quantity AS Quantity, p.price * c.quantity AS TotalPrice,
                                b.status AS BillingStatus, c.status AS CartStatus, c.from_date AS FromDate, c.to_date AS ToDate, b.cart_id AS BillingCartID
                            FROM cart c 
                                INNER JOIN package p ON c.package_id = p.id 
                                INNER JOIN customer_form cust ON c.user_id = cust.email 
                                LEFT JOIN billing b ON c.id = b.cart_id
                            WHERE c.from_date IS NOT NULL 
                            ORDER BY b.cart_id DESC";
                        $result = $con->query($q);
                        $s = 1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                if (($row['BillingStatus'] == 'approved') || ($row['CartStatus'] == 'approved') || ($row['BillingStatus'] == 'pending')) {
                                    echo "<tr>";
                                    echo "<td align='center'>" . $s . "</td>";
                                    echo "<td>" . $row['Name'] . "</td>";
                                    echo "<td>" . $row['Email'] . "</td>";
                                    echo "<td>" . $row['PackageName'] . "</td>";
                                    echo "<td>$" . $row['Price'] . "</td>";
                                    echo "<td>" . $row['Quantity'] . "</td>";
                                    echo "<td>$" . $row['TotalPrice'] . "</td>";
                                    echo "<td>" . date('Y-m-d', strtotime($row['FromDate'])) . " to " . date('Y-m-d', strtotime($row['ToDate'])) . "</td>";
                                    echo "<td align='center'>";
                                    if ($row['CartStatus'] == 'approved') {
                                        echo "<button type='button' class='btn btn-success form-control form-control-user' disabled>Approved</button>";
                                    } elseif ($row['BillingStatus'] == 'pending') {
                                        echo "<button type='button' class='btn btn-primary form-control form-control-user' disabled>Payment....</button>";
                                    } elseif ($row['BillingStatus'] == 'approved') {
                                        echo "<button type='button' class='btn btn-warning form-control form-control-user' onclick='updateStatus(" . $row['CustomerID'] . ", this)'>Approve</button>";
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                    $s++;
                                }
                            }
                        } else {
                            echo "<tr><td colspan='9'>No records found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function updateStatus(customerID) {
        $.ajax({
            url: 'functions/update_status.php',
            type: 'POST',
            data: {
                customerID: customerID
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                    swal("Success!", response.msg, "success").then(function() {
                        location.reload();
                    });
                } else if (response.status == 'error') {
                    swal("Error!", response.msg, "error");
                }
            }
        });
    }
</script>
<?php
include "designs/footer.php";
?>