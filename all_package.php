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
    <div class="row">
        <div class="col-lg-12">
            <h2>All Packages</h2>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-purple">
            <thead>
                <tr align="center">
                    <th>Sr.No.</th>
                    <th>Package Name</th>
                    <th>Place Name</th>
                    <th>Image</th>
                    <th>Prices</th>
                    <th>Description</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $s = 1;
                $q = "SELECT * FROM `package`";
                $result = $con->query($q);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td align="center"><?php echo $s; ?></td>
                            <td><?php echo $row['package_name']; ?></td>
                            <td><?php echo $row['place_name']; ?></td>
                            <td>
                                <img src="functions/<?php echo $row['image']; ?>" height="100px" width="150px" class="img-fluid" />
                            </td>
                            <td align="center">$ <?php echo $row['price']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="editPackage(<?php echo $row['id']; ?>)" title="Edit"><i class='fas fa-fw fa-edit'></i></button>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="deletePackage(<?php echo $row['id']; ?>)" title="Delete"><i class='fas fa-fw fa-trash-alt'></i></button>
                            </td>
                        </tr>
                    <?php
                        $s++;
                    }
                } else {
                    ?>
                    <tr>
                        <td>No Records Founds!</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function deletePackage(id) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this package!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'POST',
                        url: 'functions/delete_package.php',
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
                    swal("Cancelled", "Package deletion cancelled!", "info");
                }
            });
    }

    function editPackage(id) {
        window.location.href = "edit_package.php?id=" + id;
    }
</script>
<?php
include "designs/footer.php";
?>