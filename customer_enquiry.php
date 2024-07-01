<?php
include "designs/header.php";
include "designs/sidebar.php";
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <table class="table table-hover table-purple">
            <thead>
                <tr>
                    <td>
                        <h2>Enquiry!</h2>
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
                            <th>Package Name</th>
                            <th>Place Name</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $q = "SELECT * FROM `package`";
                        $result = $con->query($q);
                        if ($result->num_rows > 0) {
                            $s = 1;
                            while ($row = $result->fetch_assoc()) {
                                $packageData = json_encode(array(
                                    'packageId' => $row['id'],
                                    'packageName' => $row['package_name'],
                                    'placeName' => $row['place_name'],
                                    'price' => $row['price']
                                ));
                                echo "<tr>";
                                echo "<td align='center'>" . $s . "</td>";
                                echo "<td style='display: none;'>" . $row['id'] . "</td>";
                                echo "<td>" . $row['package_name'] . "</td>";
                                echo "<td>" . $row['place_name'] . "</td>";
                                echo "<td><img src='functions/" . $row['image'] . "' height='100px' width='150px'/></td>";
                                echo "<td>" . $row['price'] . "</td>";
                                echo "<td align='center'>
                                        <button type='button' class='btn btn-primary form-control enquiry-modal' title='Enquiry' data-toggle='modal' data-target='#enquiry_modal' data-package='" . htmlspecialchars($packageData) . "'>
                                            <i class='fas fa-fw fa-file' id='message' package-id=''></i>
                                        </button>
                                      </td>";
                                echo "</tr>";
                                $s++;
                            }
                        } else {
                            echo "No records found for email: $email";
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
                            <div class="col-lg-7">
                                <table width='100%'>
                                    <tr align="left">
                                        <th>Package Name</th>
                                        <th>Price</th>
                                    </tr>
                                    <tr align="left">
                                        <th>
                                            <h4 class="card-title p_name"></h4>
                                            <input type="hidden" name="package_name" class="p_name" />
                                        </th>
                                        <td>
                                            <h5 class="card-title">Price: $<u><span class="p_price"></span></u></h5>
                                            <input type="hidden" name="price" class="p_price" />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class='note' style='height: 350px; overflow-y: scroll; overflow-x: hidden;'></div>
                            <br>
                            <div class="row">
                                <div class="col-lg-11">
                                    <textarea type="text" class="form-control" name="note" placeholder="Enter your enquiry..." rows="1"></textarea>
                                </div>
                                <div class="col-lg-1">
                                    <input type="hidden" name="package_id" id="p_id" />
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
            let packageData = $(this).data('package');
            $('#enquiry_modal #p_id').val(packageData.packageId);

            $('#enquiry_modal .p_name').val(packageData.packageName);
            $('#enquiry_modal .p_price').val(packageData.price);
            
            $('#enquiry_modal .p_name').text(packageData.packageName);
            $('#enquiry_modal .p_price').text(packageData.price);
            
            $('#enquiry_modal').modal('show');

            //Ajax for messages//
            $.ajax({
                url: 'functions/customer_panel.php',
                type: 'POST',
                data: {
                    package_id: packageData.packageId
                },
                success: function(response) {
                    if (response.trim() === '') {
                        $('.note').hide();
                    } else {
                        $('.note').html(response).show();
                    }
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
                url: 'functions/customer_enquiry.php',
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