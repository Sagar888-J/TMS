<?php
include "designs/header.php";
include "designs/sidebar.php";

if (isset($_SESSION['email'])) {
    if ($_SESSION['role'] === "admin") {
        $description = '';
        $sql = "SELECT `description` FROM `policies` LIMIT 1";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $description = $row['description'];
        }
?>
        <!-- Admin About Us -->
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
        <div class="container mt-5">
            <h2 class="text-center mb-4">Privacy Policies</h2>
        </div>
        <form method="post" id="policies">
            <textarea id="editor" name="editor"><?php echo htmlspecialchars($description); ?></textarea>
            <br>
            <div class="row justify-content-center text-center">
                <div class="col-lg-2">
                    <button type="submit" name="save" value="Save" class="btn btn-primary btn-user btn-block">Update</button>
                </div>
            </div><br>
        </form>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                ClassicEditor
                    .create(document.querySelector('#editor'))
                    .catch(error => {
                        console.error(error);
                    });
            });
            $(document).ready(function() {
                $('#policies').on('submit', function(e) {
                    e.preventDefault();
                    var formData = $(this).serialize();
                    $.ajax({
                        type: 'POST',
                        url: 'functions/privacy_policies.php',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 'success') {
                                swal("Success!", response.msg, "success");
                                $('#policies')[0].reset();
                            } else if (response.status == 'error') {
                                swal("Error!", response.msg, "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            console.log(error);
                            alert("An error occurred while processing your request. Please try again later.");
                        }
                    });
                });
            });
        </script>
    <?php
    } else {
    ?>
        <!-- Customer About Us -->
        <div class="container mt-5">
            <h2 class="text-center mb-4">Privacy Policies</h2>
            <div class="row text-left">
                <div class="col-lg-12">
                    <?php
                    $sql = "SELECT * FROM `policies`";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo $row['description'];
                        }
                    } else {
                        echo "No Data Found !";
                    }
                    ?>
                </div>
            </div>
        </div>
<?php
    }
}
?>
<?php
include "designs/footer.php";
?>