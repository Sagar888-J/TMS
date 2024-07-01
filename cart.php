<?php
include "designs/header.php";
include "designs/sidebar.php";

$user_id = $_SESSION['email'];

$approvedCartQuery = "SELECT DISTINCT cart_id FROM billing WHERE status = 'approved'";
$cartQuery = "SELECT cart.id AS cart_id, cart.*, package.* FROM `cart` INNER JOIN `package` ON cart.package_id = package.id WHERE cart.user_id='$user_id' 
              AND cart.status = 'request' AND cart.id NOT IN ($approvedCartQuery)";
$cartResult = $con->query($cartQuery);
$cartItems = [];
while ($row = $cartResult->fetch_assoc()) {
    $cartItems[] = $row;
}

if (count($cartItems) > 0) {
?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Your Cart</h2>
        <div class="row">
            <?php
            $totalPrice = 0;
            foreach ($cartItems as $row) {
                $price = (float)$row['price'];
                $quantity = (int)$row['quantity'];
                $subtotal = $price * $quantity;
                $totalPrice += $subtotal;
            ?>
                <div class="col-lg-4 mb-4">
                    <div class="card" style="position: relative;">
                        <img src="functions/<?php echo $row['image']; ?>">
                        <button class="btn btn-outline-danger remove-item-btn" type="button" data-cart-id="<?php echo $row['cart_id']; ?>" style="position: absolute; top: 0; right: 0;">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['package_name']; ?></h5>
                            <p class="card-text"><?php echo $row['place_name']; ?></p>
                            <p class="card-text">Price: $<?php echo $row['price']; ?></p>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary quantity-btn" type="button" data-package-id="<?php echo $row['package_id']; ?>" data-operation="decrease">-</button>
                                </div>
                                <input type="tel" class="form-control quantity-input" value="<?php echo $quantity; ?>" min="1" data-quantity="<?php echo $quantity; ?>" />
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary quantity-btn" type="button" data-package-id="<?php echo $row['package_id']; ?>" data-operation="increase">+</button>
                                </div>
                            </div>
                            <p class="card-text">Subtotal: $<span class="subtotal"><?php echo $subtotal; ?></span></p>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-lg-4">
                <p class="text-center">Total Price: $<span id="totalPrice"><?php echo $totalPrice; ?></span></p>
                <button class="btn btn-primary btn-block proceed-btn mt-2">Proceed</button>
            </div>
        </div>
    </div><br>
<?php
} else {
?>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Ready for your adventure? Your cart is eagerly awaiting your selections!</h2>
            </div>
        </div>
    </div>
<?php
}


?>

<script>
    $(document).ready(function() {
        // Update quantity in Cart
        $(".quantity-btn").click(function() {
            var packageId = $(this).data("package-id");
            var operation = $(this).data("operation");
            var inputField = $(this).closest(".input-group").find(".quantity-input");
            var quantity = parseInt(inputField.val());
            if (operation === "increase") {
                quantity++;
            } else if (operation === "decrease") {
                if (quantity > 1) {
                    quantity--;
                }
            }
            inputField.val(quantity);
            $.ajax({
                url: 'functions/update_cart.php',
                type: 'POST',
                data: {
                    package_id: packageId,
                    quantity: quantity
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        location.reload();
                    } else {
                        console.error("Session error: " + response.msg);
                        console.error("Error updating cart: " + response.msg);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Remove cart data from Cart
        $(".remove-item-btn").click(function() {
            var cartID = $(this).data("cart-id");
            console.log(cartID);
            $.ajax({
                url: 'functions/remove_cart.php',
                type: 'POST',
                data: {
                    cart_id: cartID
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        location.reload();
                    } else {
                        console.error("Error removing item from cart: " + response.msg);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Proceed for Payment
        $(".proceed-btn").click(function() {
            var totalPrice = $("#totalPrice").text();
            var packageNames = [];
            var cartIds = [];

            $(".card").each(function() {
                var packageName = $(this).find(".card-title").text();
                var cartId = $(this).find(".remove-item-btn").data("cart-id");
                packageNames.push(packageName);
                cartIds.push(cartId);
            });

            var form = $('<form action="payment_page.php" method="post">' +
                '<input type="hidden" name="totalPrice" value="' + totalPrice + '">' +
                '</form>');

            for (var i = 0; i < packageNames.length; i++) {
                form.append('<input type="hidden" name="packageNames[]" value="' + packageNames[i] + '">');
                form.append('<input type="hidden" name="cartIds[]" value="' + cartIds[i] + '">');
            }

            $('body').append(form);
            form.submit();
        });

        // Disabled proceed button
        if ($("#totalPrice").text() === "0") {
            $(".proceed-btn").prop("disabled", true);
        }
    });
</script>

<?php
include "designs/footer.php";
?>