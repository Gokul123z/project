<?php
session_start();
include('connection.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Pet Store</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fa;
            --accent-color: #ff6b6b;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
        }
        
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .cart-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        .cart-header {
            background-color: var(--primary-color);
            color: white;
            padding: 15px 20px;
        }
        
        .cart-item {
            border-bottom: 1px solid #eee;
            padding: 20px;
            transition: all 0.3s ease;
        }
        
        .cart-item:hover {
            background-color: rgba(0, 0, 0, 0.01);
        }
        
        .product-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #eee;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
        }
        
        .quantity-btn {
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            user-select: none;
        }
        
        .quantity-btn:hover {
            background-color: #f8f9fa;
        }
        
        .quantity-input {
            width: 50px;
            height: 30px;
            text-align: center;
            border: 1px solid #ddd;
            border-left: none;
            border-right: none;
            outline: none;
        }
        
        .delete-btn {
            color: var(--accent-color);
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .delete-btn:hover {
            transform: scale(1.1);
        }
        
        .summary-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            padding: 20px;
        }
        
        .summary-title {
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .total-row {
            font-weight: bold;
            font-size: 1.1rem;
            border-top: 1px solid #eee;
            padding-top: 15px;
            margin-top: 15px;
        }
        
        .checkout-btn {
            background-color: var(--primary-color);
            border: none;
            padding: 12px;
            font-weight: bold;
            width: 100%;
            margin-top: 20px;
        }
        
        .checkout-btn:hover {
            background-color: #3a5ccc;
        }
        
        .empty-cart {
            text-align: center;
            padding: 50px 20px;
        }
        
        .empty-cart i {
            font-size: 5rem;
            color: #ddd;
            margin-bottom: 20px;
        }
        
        .continue-shopping {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: bold;
        }
        
        .continue-shopping:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <?php include('usernav.php'); ?>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-container mb-4">
                    <div class="cart-header">
                        <h2 class="h4 mb-0"><i class="fas fa-shopping-cart me-2"></i>Your Shopping Cart</h2>
                    </div>
                    
                    <?php
                    include('connection.php');
                    $customer_id = $_SESSION['customer_id'];
                    
                    $sql = "SELECT c.cart_id, c.quantity as cart_quantity, 
                            p.productid, p.productname, p.image, 
                            ps.productsizeid, ps.size, ps.price, ps.stock
                            FROM tbl_cart c
                            JOIN tblproductsize ps ON c.productsizeid = ps.productsizeid
                            JOIN tblproduct p ON ps.productid = p.productid
                            WHERE c.customer_id = $customer_id";
                    
                    $result = mysqli_query($conn, $sql);
                    $cart_items = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    $total_items = count($cart_items);
                    
                    if ($total_items > 0): 
                        $subtotal = 0;
                    ?>
                        <?php foreach($cart_items as $item): 
                            $item_total = $item['price'] * $item['cart_quantity'];
                            $subtotal += $item_total;
                        ?>
                            <div class="cart-item">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['productname']; ?>" class="product-img">
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="mb-1"><?php echo $item['productname']; ?></h5>
                                        <p class="mb-1 text-muted">Size: <?php echo $item['size']; ?></p>
                                        <p class="mb-0 text-primary fw-bold">$<?php echo number_format($item['price'], 2); ?></p>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="quantity-control">
                                            <button class="quantity-btn minus" data-id="<?php echo $item['cart_id']; ?>">-</button>
                                            <input type="text" class="quantity-input" value="<?php echo $item['cart_quantity']; ?>" min="1" max="<?php echo $item['stock']; ?>">
                                            <button class="quantity-btn plus" data-id="<?php echo $item['cart_id']; ?>">+</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <h5 class="mb-0">$<?php echo number_format($item_total, 2); ?></h5>
                                    </div>
                                    <div class="col-md-1 text-end">
                                        <i class="fas fa-trash delete-btn" data-id="<?php echo $item['cart_id']; ?>"></i>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-cart">
                            <i class="fas fa-shopping-cart"></i>
                            <h3>Your cart is empty</h3>
                            <p>Looks like you haven't added anything to your cart yet</p>
                            <a href="products.php" class="continue-shopping">Continue Shopping</a>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if ($total_items > 0): ?>
                <div class="d-flex justify-content-between mb-4">
                    <a href="products.php" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                    </a>
                    <button class="btn btn-outline-danger" id="clear-cart">
                        <i class="fas fa-trash me-2"></i>Clear Cart
                    </button>
                </div>
                <?php endif; ?>
            </div>
            
            <?php if ($total_items > 0): ?>
            <div class="col-lg-4">
                <div class="summary-card">
                    <h4 class="summary-title">Order Summary</h4>
                    
                    <div class="summary-row">
                        <span>Subtotal (<?php echo $total_items; ?> items)</span>
                        <span>$<?php echo number_format($subtotal, 2); ?></span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>FREE</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Tax</span>
                        <span>$<?php echo number_format($subtotal * 0.1, 2); ?></span>
                    </div>
                    
                    <div class="summary-row total-row">
                        <span>Total</span>
                        <span>$<?php echo number_format($subtotal * 1.1, 2); ?></span>
                    </div>
                    
                    <button class="btn btn-primary checkout-btn">
                        Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                    
                    <div class="mt-3 text-center">
                        <small class="text-muted">
                            <i class="fas fa-lock me-1"></i> Secure Checkout
                        </small>
                    </div>
                </div>
                
                <div class="summary-card mt-4">
                    <h5 class="mb-3">Need Help?</h5>
                    <p><i class="fas fa-phone me-2 text-primary"></i> Call us: +012 345 6789</p>
                    <p><i class="fas fa-envelope me-2 text-primary"></i> Email: info@petstore.com</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include('indexfooter.php'); ?>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    $(document).ready(function() {
        // Quantity minus button
        $('.minus').click(function() {
            const cartId = $(this).data('id');
            const input = $(this).next('.quantity-input');
            let quantity = parseInt(input.val());
            
            if (quantity > 1) {
                quantity--;
                input.val(quantity);
                updateCartItem(cartId, quantity);
            }
        });
        
        // Quantity plus button
        $('.plus').click(function() {
            const cartId = $(this).data('id');
            const input = $(this).prev('.quantity-input');
            let quantity = parseInt(input.val());
            const max = parseInt(input.attr('max'));
            
            if (quantity < max) {
                quantity++;
                input.val(quantity);
                updateCartItem(cartId, quantity);
            } else {
                alert('Maximum available quantity reached');
            }
        });
        
        // Quantity input change
        $('.quantity-input').change(function() {
            const cartId = $(this).closest('.quantity-control').find('.minus').data('id');
            let quantity = parseInt($(this).val());
            const max = parseInt($(this).attr('max'));
            const min = parseInt($(this).attr('min'));
            
            if (quantity < min) {
                quantity = min;
                $(this).val(min);
            } else if (quantity > max) {
                quantity = max;
                $(this).val(max);
                alert('Maximum available quantity reached');
            }
            
            updateCartItem(cartId, quantity);
        });
        
        // Delete item
        $('.delete-btn').click(function() {
            if (confirm('Are you sure you want to remove this item from your cart?')) {
                const cartId = $(this).data('id');
                deleteCartItem(cartId);
            }
        });
        
        // Clear cart
        $('#clear-cart').click(function() {
            if (confirm('Are you sure you want to clear your entire cart?')) {
                clearCart();
            }
        });
        
        // Update cart item function
        function updateCartItem(cartId, quantity) {
            $.ajax({
                url: 'update_cart.php',
                type: 'POST',
                data: {
                    cart_id: cartId,
                    quantity: quantity
                },
                success: function(response) {
                    // Refresh the page to update totals
                    location.reload();
                },
                error: function() {
                    alert('Error updating cart item');
                }
            });
        }
        
        // Delete cart item function
        function deleteCartItem(cartId) {
            $.ajax({
                url: 'delete_cart_item.php',
                type: 'POST',
                data: {
                    cart_id: cartId
                },
                success: function(response) {
                    // Refresh the page to update the cart
                    location.reload();
                },
                error: function() {
                    alert('Error removing item from cart');
                }
            });
        }
        
        // Clear cart function
        function clearCart() {
            $.ajax({
                url: 'clear_cart.php',
                type: 'POST',
                success: function(response) {
                    // Refresh the page to update the cart
                    location.reload();
                },
                error: function() {
                    alert('Error clearing cart');
                }
            });
        }
    });
    </script>
</body>
</html>