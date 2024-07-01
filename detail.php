<?php
include "designs/header.php";
include "designs/sidebar.php";

if (isset($_SESSION['email'])) {
    if ($_SESSION['role'] === "admin") {
?>
        <!-- All Customer's Detail Start -->
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="table-responsive">
                    <div class="col-lg-12">
                        <table class="table table-hover table-purple">
                            <thead>
                                <tr>
                                    <td>
                                        <h2>All Customer's Data</h2>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary create-button" data-toggle="modal" data-target="#createCustomerModal" title="Create customer"><i class="fas fa-fw fa-pencil-alt"></i></button>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        <table class="table table-hover table-purple">
                            <thead>
                                <tr align="center">
                                    <th>Sr.No.</th>
                                    <th>Name</th>
                                    <th>Date of birth</th>
                                    <th>Gender</th>
                                    <th>Email</th>
                                    <th>Phone No.</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $q = "SELECT * FROM `customer_form` WHERE `role` = 'customer'";
                                $result = $con->query($q);
                                $s = 1;
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td align='center'>" . $s . "</td>";
                                        echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                                        echo "<td>" . $row['dob'] . "</td>";
                                        echo "<td>" . $row['gender'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['phone'] . "</td>";
                                        echo "<td align='center'>
                                                <button type='submit' class='btn btn-primary form-control form-control-user' onclick='editCustomer(" . $row['id'] . ")' title='Edit'><i class='fas fa-fw fa-edit'></i></button>
                                              </td>
                                              <td>
                                                <button class='btn btn-danger form-control form-control-user' onclick='deleteCustomer(" . $row['id'] . ")' title='Delete'><i class='fas fa-fw fa-trash-alt'></i></button>
                                              </td>";
                                        echo "</tr>";
                                        $s++;
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>No Records Found!</td></tr>";
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End -->
        <!-- Customer insertion Modal Start -->
        <div class="modal fade" id="createCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Customer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
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
                    </div>
                </div>
            </div>
        </div>
        <!-- End -->
    <?php
    } else {
    ?>
        <!-- Customer Detail Start -->
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="table-responsive">
                    <div class="col-lg-12">
                        <table class="table table-hover table-purple">
                            <thead>
                                <tr>
                                    <td colspan="7">
                                        <h2>Customer Data</h2>
                                    </td>
                                </tr>
                                <tr align="center">
                                    <th>Sr.No.</th>
                                    <th>Name</th>
                                    <th>Date of birth</th>
                                    <th>Gender</th>
                                    <th>Email</th>
                                    <th>Phone No.</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $email = $_SESSION['email'];
                                $email = $con->real_escape_string($email);
                                $q = "SELECT * FROM `customer_form` WHERE `email` = '$email'";
                                $result = $con->query($q);
                                if ($result->num_rows > 0) {
                                    $s = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr id='customer-" . $row['id'] . "'>";
                                        echo "<td align='center'>" . $s . "</td>";
                                        echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                                        echo "<td>" . $row['dob'] . "</td>";
                                        echo "<td>" . $row['gender'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['phone'] . "</td>";
                                        echo "<td align='center'><button type='submit' class='btn btn-primary form-control form-control-user' onclick='editCustomer(" . $row['id'] . ")' title='Edit'><i class='fas fa-fw fa-edit'></i></button></td>";
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
        </div>
        <!-- End -->
<?php
    }
}
?>

<script>
    //Customer insertion script//
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
    //Customer delete Function//
    function deleteCustomer(id) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this customer!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'POST',
                        url: 'functions/delete.php',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 'success') {
                                swal("Success!", response.msg, "success");
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else if (response.status == 'error') {
                                swal("Error!", response.msg, "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            console.log(error);
                            swal("Error!", "An error occurred while processing your request. Please try again later.", "error");
                        }
                    });
                } else {
                    swal("Cancelled", "Customer deletion cancelled!", "info");
                }
            });
    }
    //Customer Edit Function//
    function editCustomer(id) {
        window.location.href = "edit.php?id=" + id;
    }
</script>
<?php
include "designs/footer.php";
?>