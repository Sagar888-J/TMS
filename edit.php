<?php
include "designs/header.php";
include "designs/sidebar.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $q = "SELECT * FROM `customer_form` WHERE `id` = '$id'";
    $result = $con->query($q);
    $row = $result->fetch_assoc();
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="text-center mb-4">
                <h2>Customer Edit Form</h2>
            </div>
            <form method="post" id="update">
                <div class="row mb-3">
                    <div class="col-lg-4 text-center mt-2">
                        <label for="firstName">First name</label>
                    </div>
                    <div class="col-lg-8">
                        <input class="form-control form-control-user" type="text" name="first_name" value="<?php echo $row['first_name'] ?>" />
                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-4 text-center mt-2">
                        <label for="lastname">Last name</label>
                    </div>
                    <div class="col-lg-8">
                        <input class="form-control form-control-user" type="text" name="last_name" value="<?php echo $row['last_name'] ?>" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-4 text-center mt-2">
                        <label for="date">Date</label>
                    </div>
                    <div class="col-lg-8">
                        <input class="form-control form-control-user" type="date" name="dob" value="<?php echo $row['dob'] ?>" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-4 text-center mt-2">
                        <label for="gender">Gender</label>
                    </div>
                    <div class="col-lg-8 mt-2">
                        <input type="radio" name="gender" value="Male" <?php if (isset($row['gender']) && $row['gender'] == "Male") echo "checked"; ?> /> Male
                        <input type="radio" name="gender" value="Female" <?php if (isset($row['gender']) && $row['gender'] == "Female") echo "checked"; ?> /> Female
                        <input type="radio" name="gender" value="Other" <?php if (isset($row['gender']) && $row['gender'] == "Other") echo "checked"; ?> /> Other
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-4 text-center mt-2">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-lg-8">
                        <input class="form-control form-control-user" type="email" name="email" value="<?php echo $row['email'] ?>" readonly />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-4 text-center mt-2">
                        <label for="phone">Phone No.</label>
                    </div>
                    <div class="col-lg-8">
                        <input class="form-control form-control-user" type="tel" name="phone" value="<?php echo $row['phone'] ?>" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-6 text-right">
                        <button class="btn btn-primary btn-user btn-block" onclick="redirectTo('detail.php')">Cancel</button>
                    </div>
                    <div class="col-lg-6 text-left">
                        <button class="btn btn-primary btn-user btn-block" type="submit" name="update">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    
<script>
    function redirectTo(page) {
        window.location.href = page;
    }

    $(document).ready(function() {
        $('#update').on('submit', function(e) {
            e.preventDefault();
            // Collect form data
            var formData = $(this).serialize();
            // AJAX request
            $.ajax({
                type: 'POST',
                url: 'functions/update.php',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        swal("Success!", response.msg, "success").then(function() {
                            window.location.href = "detail.php";
                        });
                        $('#form')[0].reset();
                    } else if (response.status == 'error') {
                        swal("Error!", response.msg, "error");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("An error occurred while processing your request. Please try again later.");
                }
            });
        });
    });
</script>

<?php
include "designs/footer.php";
?>