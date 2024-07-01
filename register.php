<?php
include "designs/header.php";
?>

<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>
                        <form class="user" method="post" id="form">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" name="first_name" class="form-control form-control-user" id="exampleFirstName" placeholder="First Name">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" name="last_name" class="form-control form-control-user" id="exampleLastName" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="date" name="dob" class="form-control form-control-user" id="exampleDob">
                                </div>
                                <div class="col-sm-6 mt-3 mb-sm-0">
                                    <input type="radio" name="gender" id="exampleGenderMale" value="Male"> Male
                                    <input type="radio" name="gender" id="exampleGenderFemale" value="Female"> Female
                                    <input type="radio" name="gender" id="exampleGenderOther" value="Other"> Other
                                    <span id="gender"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" name="con_password" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Repeat Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="tel" name="phone" class="form-control form-control-user" id="examplePhone" placeholder="Phone Number">
                            </div>
                            <button class="btn btn-primary btn-user btn-block" type="submit" name="submit">Register Account</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="login.php">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#form').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: 'functions/register.php',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        swal("Success!", response.msg, "success").then(function() {
                            window.location.href = "login.php";
                        });
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
                if (field === 'gender') {
                    $('#gender').html('<span class="error text-danger">' + errorMsg + '</span>');
                } else {
                    let errorElement = $('<span class="error text-danger">' + errorMsg + '</span>');
                    inputField.after(errorElement);
                }
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