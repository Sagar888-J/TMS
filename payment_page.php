<?php
include "designs/header.php";
include "designs/sidebar.php";

$totalPrice = isset($_POST['totalPrice']) ? $_POST['totalPrice'] : '0.00';
$packageNames = isset($_POST['packageNames']) ? $_POST['packageNames'] : array();
$cartIds = isset($_POST['cartIds']) ? $_POST['cartIds'] : array();
?>

<script src="https://www.paypal.com/sdk/js?client-id=AZFR5cQSjcaK4vzF4veIhlTpH78Aty2mvJSU0jRN0CVseHQuTDFv_hKdimn-da_q5sz7aJMl63J2nIgh&currency=USD"></script>
<div class="container">
    <form class="user" method="post" id="payment">
        <div class="row">
            <div class="col-lg-7">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">BILLING DETAILS</h1>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" name="first_name" class="form-control form-control-user" id="exampleFirstName" placeholder="First Name">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="last_name" class="form-control form-control-user" id="exampleLastName" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 mb-0 mb-sm-0">
                            <input type="text" name="country" class="form-control form-control-user" id="exampleFirstName" placeholder="Country/Region">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <input type="text" name="city" class="form-control form-control-user" id="exampleFirstName" placeholder="Town/City">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" name="state" class="form-control form-control-user" id="exampleLastName" placeholder="State">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" name="zip_code" class="form-control form-control-user" id="exampleLastName" placeholder="Zip Code">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="email" name="bill_email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address">
                        </div>
                        <div class="col-sm-6">
                            <input type="tel" name="phone" class="form-control form-control-user" id="exampleInputEmail" placeholder="Phone Number">
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="col-lg-5 text-left">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">YOUR ORDER</h1>
                    </div>
                    <?php
                    $cartIdString = implode(",", $cartIds);
                    ?>
                    <input type="hidden" name="cartId" value="<?php echo $cartIdString ?>" />
                    <?php
                    echo "<h3>Package:</h3>";
                    echo "<ul>";
                    foreach ($packageNames as $packageName) {
                        echo "<li>$packageName</li>";
                    }
                    echo "</ul>";
                    $packageNameString = implode(",", $packageNames);
                    ?>
                    <input type="hidden" name="packageName" value="<?php echo $packageNameString; ?>" />
                    <input type="hidden" name="totalPrice" value="<?php echo $totalPrice; ?>" />
                    <h3>Total Price: $<?php echo $totalPrice; ?></h3>
                    <p>Please select a payment method:</p>
                    <input type="radio" id="stripe" name="paymentMethod" value="stripe" />
                    <label for="stripe">Stripe</label><br>
                    <input type="radio" id="paypal" name="paymentMethod" value="paypal" />
                    <label for="paypal">PayPal</label>
                    <div id="paypal-button-container" class="mt-2"></div>
                    <button class="btn btn-primary btn-user btn-block mt-2" id="payment_button" type="submit" name="payment">Place Order</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    //PayPal Gateway//
    paypal.Buttons({
        style: {
            layout: 'horizontal',
            color: 'gold',
            shape: 'pill',
            label: 'pay'
        },
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: <?= $totalPrice ?>
                    },
                }]
            });
        },
        onCancel: function(data) {
            window.location.href = 'cancel.php';
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                var formData = {
                    first_name: $("input[name='first_name']").val(),
                    last_name: $("input[name='last_name']").val(),
                    country: $("input[name='country']").val(),
                    city: $("input[name='city']").val(),
                    state: $("input[name='state']").val(),
                    zip_code: $("input[name='zip_code']").val(),
                    bill_email: $("input[name='bill_email']").val(),
                    phone: $("input[name='phone']").val(),
                    totalPrice: $("input[name='totalPrice']").val(),
                    packageName: $("input[name='packageName']").val(),
                    cartId: $("input[name='cartId']").val(),
                    paymentMethod: 'paypal',
                    orderID: data.orderID,
                    payerID: data.payerID,
                    transactionDetails: details
                };
                return $.ajax({
                    url: 'functions/paypal_payment.php',
                    type: 'POST',
                    dataType: 'json',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    success: function(response) {
                        if (response.status == 'success') {
                            swal({
                                title: "Please wait...",
                                text: "Redirecting you shortly.",
                                icon: "info",
                                buttons: false,
                                closeOnClickOutside: false,
                                closeOnEsc: false,
                            });
                            setTimeout(function() {
                                window.location.href = response.msg;
                            }, 2000);
                        } else if (response.status == 'error') {
                            swal("Error!", response.msg, "error");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error occurred:', error);
                        swal("Error!", "An error occurred while processing your request. Please try again later.", "error");
                    }
                });
            });
        }
    }).render('#paypal-button-container');

    //Ajax for Stripe & PayPal payment method//
    $(document).ready(function() {
        //Stripe or PayPal payment button able or disable//
        $('#paypal-button-container').hide();
        $('input[name="paymentMethod"]').change(function() {
            var paymentMethod = $(this).val();
            if (paymentMethod === 'stripe') {
                $('#paypal-button-container').hide();
                $('#payment_button').prop('disabled', false);
            } else if (paymentMethod === 'paypal') {
                $('#paypal-button-container').show();
            }
        });

        //PayPal radio button Ajax//
        $("input[name='paymentMethod'][value='paypal']").click(function(event) {
            event.preventDefault();
            var formData = $('#payment').serialize();
            $.ajax({
                type: 'POST',
                url: 'functions/valid.php',
                dataType: 'json',
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        $('#paypal-button-container').show();
                        $("input[name='paymentMethod'][value='paypal']").prop('checked', true);
                        $('#payment_button').prop('disabled', true);
                    } else if (response.status == 'error') {
                        showErrorMessages(response.msg);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    swal("Error!", "An error occurred while processing your request.", "error");
                }
            });
        });

        //Ajax for Stripe payment//
        $("button[name='payment']").click(function(event) {
            event.preventDefault();
            var paymentMethod = $("input[name='paymentMethod']:checked").val();

            if (!paymentMethod) {
                showSwalMessage('Please select a payment method.');
                return;
            }
            var paymentMethod = $("input[name='paymentMethod']:checked").val();
            var formData = {
                first_name: $("input[name='first_name']").val(),
                last_name: $("input[name='last_name']").val(),
                country: $("input[name='country']").val(),
                city: $("input[name='city']").val(),
                state: $("input[name='state']").val(),
                zip_code: $("input[name='zip_code']").val(),
                bill_email: $("input[name='bill_email']").val(),
                phone: $("input[name='phone']").val(),
                totalPrice: $("input[name='totalPrice']").val(),
                packageName: $("input[name='packageName']").val(),
                cartId: $("input[name='cartId']").val(),
                paymentMethod: paymentMethod
            };
            $.ajax({
                url: 'functions/stripe_payment.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        swal({
                            title: "Please wait...",
                            text: "Redirecting you shortly.",
                            icon: "info",
                            buttons: false,
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                        });
                        setTimeout(function() {
                            window.location.href = response.msg;
                        }, 2000);
                    } else if (response.status == 'error') {
                        showErrorMessages(response.msg);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        //Error message function//
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

        //Radio message function//
        function showSwalMessage(message) {
            swal({
                title: "Error!",
                text: message,
                icon: "error",
                buttons: {
                    confirm: {
                        text: "Okay",
                        className: "btn btn-primary"
                    },
                },
            });
        }
    });
</script>

<?php
include "designs/footer.php";
?>