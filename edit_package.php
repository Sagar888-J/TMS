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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $q = "SELECT * FROM `package` WHERE `id` = '$id'";
    $result = $con->query($q);
    $row = $result->fetch_assoc();
}
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="text-center mb-4">
                <h2>Edit Package</h2>
            </div>
            <form method="post" enctype="multipart/form-data" id="update_package">
                <div class="row mb-3">
                    <div class="col-lg-4 text-center mt-2">
                        <label for="package_name">Package Name</label>
                    </div>
                    <div class="col-lg-8">
                        <input class="form-control form-control-user" type="text" name="package_name" value="<?php echo $row['package_name'] ?>" />
                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-4 text-center mt-2">
                        <label for="place_name">Place Name</label>
                    </div>
                    <div class="col-lg-8">
                        <input class="form-control form-control-user" type="text" name="place_name" value="<?php echo $row['place_name'] ?>" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-4 text-center mt-2">
                        <label for="upload">Image</label>
                    </div>
                    <div class="col-lg-8">
                        <input class="form-control form-control-user" type="file" name="upload" value="<?php echo $row['image'] ?>" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-4 text-center mt-2">
                        <label for="price">Price</label>
                    </div>
                    <div class="col-lg-8">
                        <input class="form-control form-control-user" type="tel" name="price" value="<?php echo $row['price'] ?>" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-4 text-center mt-2">
                        <label for="description">Description</label>
                    </div>
                    <div class="col-lg-8">
                        <textarea class="form-control form-control-user" name="description" rows="4" value="<?php echo $row['description'] ?>"><?php echo $row['description'] ?></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-6 text-right">
                        <button class="btn btn-primary btn-user btn-block" onclick="redirectTo('all_package.php')">Cancel</button>
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
        $('#update_package').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: 'functions/update_package.php',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        swal("Success!", response.msg, "success").then(function() {
                            window.location.href = "all_package.php";
                        });
                        $('#update_package')[0].reset();
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