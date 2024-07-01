<?php
include "designs/header.php";
include "designs/sidebar.php";
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Packages</h2>
    <div class="row">
        <?php
        $q = "SELECT * FROM `package`";
        $result = $con->query($q);
        while ($row = $result->fetch_assoc()) {
            $packageId = $row['id'];
            $imageId = "imageModal" . $packageId;
            // Encode data into JSON format
            $packageData = json_encode(array(
                'packageId' => $packageId,
                'packageName' => $row['package_name'],
                'placeName' => $row['place_name'],
                'price' => $row['price']
            ));
        ?>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <img src="functions/<?php echo $row['image']; ?>" class="card-img-top" alt="Package Image" data-toggle="modal" data-target="#<?php echo $imageId; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['package_name']; ?></h5>
                        <p class="card-text"><?php echo $row['place_name']; ?></p>
                        <p class="card-text"><?php echo $row['description']; ?></p>
                        <p class="card-text">Price: $<?php echo $row['price']; ?></p>
                        <button class="btn btn-primary btn-block book-now-btn" type="button" data-toggle="modal" data-target="#datePickerModal" data-package='<?php echo htmlspecialchars($packageData); ?>'>
                            Book Now
                        </button>
                    </div>
                </div>
            </div>

            <!-- Start Modal For Image -->
            <div class="modal fade" id="<?php echo $imageId; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><?php echo $row['package_name']; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="functions/<?php echo $row['image']; ?>" class="img-fluid" alt="Package Image">
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->
        <?php
        }
        ?>
        <!-- Modal for DatePicker -->
        <div class="modal fade" id="datePickerModal" tabindex="-1" role="dialog" aria-labelledby="datePickerModalLabel" aria-hidden="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header dark">
                        <h5 class="modal-title" id="datePickerModalLabel">Select Dates</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="confirm">
                        <div class="modal-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <label for="startDate">Start</label>
                                    <input type="text" class="form-control datepicker" id="startDate" name="from_date" placeholder="Select Start Date" autocomplete="off">
                                </div>
                                <div class="col text-center">
                                    <span>To</span>
                                </div>
                                <div class="col">
                                    <label for="endDate">End</label>
                                    <input type="text" class="form-control datepicker" id="endDate" name="to_date" placeholder="Select End Date" autocomplete="off">
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title" id="p_name"></h4>
                                    <p class="card-text" id="p_place"></p>
                                    <p class="card-text">Price: $<span id="p_price"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="text" name="package_id" id="p_id" style="visibility: hidden;" />
                            <button type="submit" class="btn btn-primary confirm">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Modal -->
    </div>
</div>

<script>
    $(document).ready(function($) {
        // Initialize datepicker//
        $('#startDate').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            startDate: new Date()
        });
        $('#endDate').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            startDate: new Date()
        });
        //Dynamic data for Modal//
        $(document).on('click', '.book-now-btn', function() {
            let packageData = $(this).data('package');
            let p_id = packageData.packageId;
            let p_name = packageData.packageName;
            let p_place = packageData.placeName;
            let p_price = packageData.price;

            $('#datePickerModal #p_id').val(p_id);
            $('#datePickerModal #p_name').text(p_name);
            $('#datePickerModal #p_place').text(p_place);
            $('#datePickerModal #p_price').text(p_price);

            $('#datePickerModal').modal('show');
        });
        //Insertion in Database//
        $('#confirm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            // Append current time to selected dates
            var currentTime = new Date().toTimeString().split(' ')[0];
            var fromDate = $('#startDate').val() + ' ' + currentTime;
            var toDate = $('#endDate').val() + ' ' + currentTime;

            formData.set('from_date', fromDate);
            formData.set('to_date', toDate);
            $.ajax({
                type: 'POST',
                url: 'functions/add_to_cart.php',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        swal("Success!", response.msg, "success").then(function() {
                            location.reload();
                        });
                    } else {
                        swal("Error!", response.msg, "error");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    swal("Error!", "An error occurred. Please try again later.", "error");
                }
            });
        });
    });
</script>
<?php
include "designs/footer.php";
?>