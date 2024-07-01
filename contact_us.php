<?php
include "designs/header.php";
include "designs/sidebar.php";


if (isset($_SESSION['email'])) {
    if ($_SESSION['role'] === "admin") {
        $description = '';
        $sql = "SELECT `description` FROM `contact_us` LIMIT 1";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $description = $row['description'];
        }
?>
        <!-- Admin Contact Us -->
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
        <div class="container mt-5">
            <h2 class="text-center mb-4">Contact Us</h2>
        </div>
        <form method="post" id="contact">
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
                $('#contact').on('submit', function(e) {
                    e.preventDefault();
                    var formData = $(this).serialize();
                    $.ajax({
                        type: 'POST',
                        url: 'functions/contact_us.php',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 'success') {
                                swal("Success!", response.msg, "success");
                                $('#contact')[0].reset();
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
        <!-- Customer Contact Us -->
        <div class="container mt-5">
            <h2 class="text-center mb-4">Contact Us</h2>
            <div class="row">
                <div class="col-lg-12">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3430.2554884627!2d76.70312481057609!3d30.711217174488603!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390fee9fe6a743ff%3A0x384c4fd813517643!2sBaseline%20IT%20Development!5e0!3m2!1sen!2sin!4v1719287905284!5m2!1sen!2sin" width="1100" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <br>
            <div class="row text-left">
                <div class="col-lg-12">
                    <?php
                    $sql = "SELECT * FROM `contact_us`";
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