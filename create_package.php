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
        <div class="col-lg-6 pic"></div>
        <div class="col-lg-6">
            <div class="text-center mb-4">
                <h2>Create Package!</h2>
            </div>
            <form method="post" enctype="multipart/form-data" id="package">
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <input class="form-control form-control-user" type="text" name="package_name" placeholder="Package Name" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <input class="form-control form-control-user" type="text" name="place_name" placeholder="Place Name" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <input class="form-control form-control-user" type="file" name="upload" placeholder="Upload Image" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <input class="form-control form-control-user" type="tel" name="price" placeholder="Price">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <textarea class="form-control form-control-user" name="description" rows="3" placeholder="Describe...."></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-12 text-center">
                        <button class="btn btn-primary btn-user btn-block" type="submit" name="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#package').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: 'functions/package.php',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        swal("Success!", response.msg, "success").then(function() {
                            window.location.href = "all_package.php";
                        });
                        $('#package')[0].reset();
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