<?php
include "designs/header.php";
include "designs/sidebar.php";



?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="table-responsive">
            <div class="col-lg-12">
                <table class="table table-hover table-purple">
                    <thead>
                        <tr>
                            <td colspan="8">
                                <h3>Your Package Request</h3>
                            </td>
                        </tr>
                        <tr align="center">
                            <th>Sr.No.</th>
                            <th>Package Name</th>
                            <th>Place Name</th>
                            <th>Date</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $email = $_SESSION['email'];
                        $q = "SELECT cust.id AS CustomerID, p.place_name AS PlaceName, p.package_name AS PackageName, c.from_date AS FromDate, c.to_date AS ToDate,
                                p.price AS Price, c.quantity AS Quantity, p.price * c.quantity AS TotalPrice, COALESCE(b.status, 'no billing') AS BillingStatus,
                                c.status AS CartStatus, c.from_date AS CreatedAt
                            FROM cart c 
                                INNER JOIN package p ON c.package_id = p.id 
                                INNER JOIN customer_form cust ON c.user_id = cust.email 
                                LEFT JOIN billing b ON b.cart_id = c.id AND b.status = 'approved' 
                            WHERE c.user_id = '$email' AND c.status = 'approved'
                            ORDER BY b.cart_id DESC";
                        $result = $con->query($q);
                        $s = 1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td align='center'>" . $s . "</td>";
                                echo "<td>" . $row['PackageName'] . "</td>";
                                echo "<td>" . $row['PlaceName'] . "</td>";
                                echo "<td>" . date('Y-m-d', strtotime($row['FromDate'])) . " to " . date('Y-m-d', strtotime($row['ToDate'])) . "</td>";
                                echo "<td>" . $row['Price'] . "</td>";
                                echo "<td>" . $row['Quantity'] . "</td>";
                                echo "<td>" . $row['TotalPrice'] . "</td>";
                                echo "<td align='center'>";

                                if ($row['CartStatus'] == 'approved') {
                                    echo "<button type='button' class='btn btn-success form-control form-control-user' disabled>Approved</button>";
                                } elseif ($row['BillingStatus'] == 'pending') {
                                    echo "<button type='button' class='btn btn-primary form-control form-control-user' disabled>Payment....</button>";
                                } elseif ($row['BillingStatus'] == 'approved') {
                                    echo "<button type='button' class='btn btn-success form-control form-control-user' disabled>Approved</button>";
                                }

                                echo "</td>";
                                echo "</tr>";
                                $s++;
                            }
                        } else {
                            echo "<tr><td colspan='8'>No records found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include "designs/footer.php";
?>