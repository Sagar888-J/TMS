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

<div class="container mt-5">
    <div class="row justify-content-center">
        <table class="table table-hover table-purple">
            <thead>
                <tr>
                    <td>
                        <h2>All Customer's Enquires</h2>
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
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Package Name</th>
                            <th>Price</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $q = "SELECT e.*, c.first_name, c.last_name, c.email, p.package_name, p.price FROM `enquiry` e
                                JOIN `customer_form` c ON e.user_id = c.email
                                JOIN `package` p ON e.package_id = p.id
                                WHERE e.user_id IS NOT NULL AND e.package_id IS NOT NULL
                                ORDER BY e.id DESC";
                        $result = $con->query($q);
                        if ($result->num_rows > 0) {
                            $s = 1;
                            while ($row = $result->fetch_assoc()) {
                                $enquiryData = json_encode(array(
                                    'id' => $row['id'],
                                    'user_id' => $row['user_id'],
                                    'first_name' => $row['first_name'],
                                    'last_name' => $row['last_name'],
                                    'email' => $row['email'],
                                    'package_id' => $row['package_id'],
                                    'package_name' => $row['package_name'],
                                    'price' => $row['price']
                                ));
                                echo "<tr>";
                                echo "<td align='center'>" . $s . "</td>";
                                echo "<td style='display: none;'>" . $row['id'] . "</td>";
                                echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['package_name'] . "</td>";
                                echo "<td>" . $row['price'] . "</td>";
                                echo "<td align='center'>
                                        <button type='button' class='btn btn-primary form-control enquiry-modal' title='Enquiry' data-toggle='modal' data-target='#enquiry_modal' data-enquiry='" . htmlspecialchars($enquiryData) . "'>
                                            <i class='fas fa-fw fa-file' id='message'></i>
                                        </button>
                                      </td>";
                                echo "</tr>";
                                $s++;
                            }
                        } else {
                            echo "<tr><td colspan='6'>No enquiry records found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Enquiry Modal -->
    <div class="modal fade" id="enquiry_modal" tabindex="-1" role="dialog" aria-labelledby="enquirymodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send Enquiry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="enquiry">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-10">
                                <table width='100%'>
                                    <tr align="left">
                                        <th>Customer Name</th>
                                        <th>Package Name</th>
                                        <th>Price</th>
                                    </tr>
                                    <tr align="left">
                                        <th>
                                            <h4 class="card-title email"></h4>
                                            <input type="hidden" name="email" class="email" />
                                        </th>
                                        <td>
                                            <h5 class="card-title package_name"></h5>
                                            <input type="hidden" name="package_name" class="package_name" />
                                        </td>
                                        <td>
                                            <h5 class="card-title">Price: $<u><span class="price"></span></u></h5>
                                            <input type="hidden" name="price" class="price" />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class='note' style='height: 350px; overflow-y: scroll; overflow-x: hidden;'></div>
                            <br>
                            <div class="row">
                                <div class="col-lg-11">
                                    <textarea type="text" class="form-control" name="note" placeholder="Enter your enquiry..." rows="1"></textarea>
                                </div>
                                <div class="col-lg-1">
                                    <input type="hidden" name="package_id" id="package_id" />
                                    <button type="submit" class="btn btn-primary send-button" title="Send">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Modal Data Dynamic //
        $(document).on('click', '.enquiry-modal', function() {
            let enquiryData = $(this).data('enquiry');
            $('#enquiry_modal #package_id').val(enquiryData.package_id);

            $('#enquiry_modal .email').val(enquiryData.email);
            $('#enquiry_modal .email').text(enquiryData.email);

            $('#enquiry_modal .package_name').val(enquiryData.package_name);
            $('#enquiry_modal .price').val(enquiryData.price);

            $('#enquiry_modal .package_name').text(enquiryData.package_name);
            $('#enquiry_modal .price').text(enquiryData.price);
            $('#enquiry_modal').modal('show');

            //Ajax for messages//
            $.ajax({
                url: 'functions/admin_panel.php',
                type: 'POST',
                data: {
                    package_id: enquiryData.package_id,
                    email: enquiryData.email
                },
                success: function(response) {
                    $('.note').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching customer notes:', error);
                }
            });
        });
        // Ajax for Enquiry //
        $('#enquiry').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'functions/admin_enquiry.php',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        swal("Success!", response.msg, "success");
                        $('#enquiry')[0].reset();
                        $('#enquiry_modal').modal('hide');
                    } else if (response.status === 'error') {
                        if (response.error) {
                            showErrorMessages(response.error);
                        } else {
                            swal("Error!", response.msg, "error");
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    console.log(error);
                    alert("An error occurred while processing your request. Please try again later.");
                }
            });
        });
        // Error function //
        function showErrorMessages(errors) {
            $('.error').remove();
            for (let field in errors) {
                let errorMsg = errors[field];
                let inputField = $('[name="' + field + '"]');
                let errorElement = $('<span class="error text-danger">' + errorMsg + '</span>');
                inputField.after(errorElement);
            }
            setTimeout(function() {
                $('.error').fadeOut(500, function() {
                    $(this).remove();
                });
            }, 1500);
        }
    });
</script>

<?php
include "designs/footer.php";
?>