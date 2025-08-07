<?php
include('connection.php');
include('indexheader.php');

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0; 
// $product_id = 15;
// Fetch product details
$product_query = "SELECT p.*, b.brandname, c.categoryname, pt.petname, sc.subcategoryname 
                  FROM tblproduct p
                  JOIN tblbrand b ON p.brand_id = b.brand_id
                  JOIN tblcategory c ON p.category_id = c.category_id
                  JOIN tblpet pt ON p.pet_id = pt.pet_id
                  JOIN tblsubcategory sc ON p.subcategoryid = sc.subcategoryid
                  WHERE p.productid = $product_id";
$product_result = mysqli_query($conn, $product_query);
$product = mysqli_fetch_assoc($product_result);

// Fetch available sizes
$sizes_query = "SELECT * FROM tblproductsize WHERE productid = $product_id AND stock > 0";
$sizes_result = mysqli_query($conn, $sizes_query);
$sizes = [];
while ($size = mysqli_fetch_assoc($sizes_result)) {
    $sizes[] = $size;
}

// Initialize variables
$selected_size = null;
$quantity = 1;
$total_price = 0;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selected_size_id = isset($_POST['size_id']) ? intval($_POST['size_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    // Find the selected size
    foreach ($sizes as $size) {
        if ($size['productsizeid'] == $selected_size_id) {
            $selected_size = $size;
            $total_price = $size['price'] * $quantity;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['productname']); ?> - Pet Store</title>
    <style>
        .product-detail-container {
            padding: 30px 0;
        }

        .product-image-container {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            height: 100%;
        }

        .product-image {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: contain;
        }

        .product-info {
            padding-left: 30px;
        }

        .product-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .product-meta {
            margin-bottom: 20px;
        }

        .product-meta span {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }

        .size-options {
            margin: 25px 0;
        }

        .size-box {
            display: inline-block;
            padding: 8px 15px;
            margin-right: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .size-box:hover,
        .size-box.selected {
            border-color: #7AB730;
            background-color: #f8f8f8;
        }

        .size-box.selected {
            background-color: #7AB730;
            color: white;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            margin: 25px 0;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            background: #f1f1f1;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        .quantity-input {
            width: 50px;
            height: 30px;
            text-align: center;
            margin: 0 5px;
            border: 1px solid #ddd;
        }

        .price-section {
            margin: 25px 0;
            font-size: 24px;
            font-weight: 600;
        }

        .action-buttons {
            margin-top: 30px;
        }

        .btn-add-to-cart,
        .btn-buy-now {
            padding: 12px 25px;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            margin-right: 15px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-add-to-cart {
            background-color: #333;
            color: white;
        }

        .btn-add-to-cart:hover {
            background-color: #555;
        }

        .btn-buy-now {
            background-color: #7AB730;
            color: white;
        }

        .btn-buy-now:hover {
            background-color: #689f2d;
        }

        .description-section {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
    </style>
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid border-bottom d-none d-lg-block">
        <div class="row gx-0">
            <div class="col-lg-4 text-center py-2">
                <div class="d-inline-flex align-items-center">
                    <i class="bi bi-geo-alt fs-1 text-primary me-3"></i>
                    <div class="text-start">
                        <h6 class="text-uppercase mb-1">Our Office</h6>
                        <span>123 Street, New York, USA</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center border-start border-end py-2">
                <div class="d-inline-flex align-items-center">
                    <i class="bi bi-envelope-open fs-1 text-primary me-3"></i>
                    <div class="text-start">
                        <h6 class="text-uppercase mb-1">Email Us</h6>
                        <span>info@example.com</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center py-2">
                <div class="d-inline-flex align-items-center">
                    <i class="bi bi-phone-vibrate fs-1 text-primary me-3"></i>
                    <div class="text-start">
                        <h6 class="text-uppercase mb-1">Call Us</h6>
                        <span>+012 345 6789</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <?php include('usernav.php'); ?>
    <!-- Navbar End -->

    <!-- Product Detail Start -->
    <div class="container-fluid py-5">
        <div class="container product-detail-container">
            <div class="row">
                <!-- Product Image -->
                <div class="col-lg-6">
                    <div class="product-image-container">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>"
                            alt="<?php echo htmlspecialchars($product['productname']); ?>"
                            class="product-image">
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-lg-6 product-info">
                    <h1 class="product-title"><?php echo htmlspecialchars($product['productname']); ?></h1>

                    <div class="product-meta">
                        <span><strong>Brand:</strong> <?php echo htmlspecialchars($product['brandname']); ?></span>
                        <span><strong>Category:</strong> <?php echo htmlspecialchars($product['categoryname']); ?></span>
                        <span><strong>Subcategory:</strong> <?php echo htmlspecialchars($product['subcategoryname']); ?></span>
                        <span><strong>For:</strong> <?php echo htmlspecialchars($product['petname']); ?></span>
                    </div>

                    <form method="POST" action="">
                        <!-- Size Selection -->
                       <!-- Size Selection Section -->
<div class="size-options">
    <h4>Select Size:</h4>
    <?php foreach ($sizes as $size): ?>
        <div class="size-box <?php echo ($selected_size && $selected_size['productsizeid'] == $size['productsizeid']) ? 'selected' : ''; ?>"
             onclick="selectSize(this, <?php echo $size['productsizeid']; ?>, <?php echo $size['price']; ?>, <?php echo $size['stock']; ?>)">
            <input type="radio" name="size_id" value="<?php echo $size['productsizeid']; ?>"
                   id="size_<?php echo $size['productsizeid']; ?>"
                   style="display: none;"
                   <?php echo ($selected_size && $selected_size['productsizeid'] == $size['productsizeid']) ? 'checked' : ''; ?>>
            <label for="size_<?php echo $size['productsizeid']; ?>">
                <?php echo htmlspecialchars($size['size']); ?> - ₹<?php echo number_format($size['price'], 2); ?>
            </label>
        </div>
    <?php endforeach; ?>
</div>

                        <!-- Quantity Selector -->
                       <!-- Quantity Selector -->
<div class="quantity-selector">
    <h4>Quantity:</h4>
    <button type="button" class="quantity-btn" onclick="changeQuantity(-1)">-</button>
    <input type="number" name="quantity" class="quantity-input"
        value="<?php echo $quantity; ?>" min="1" max="<?php echo ($selected_size) ? $selected_size['stock'] : 1; ?>">
    <button type="button" class="quantity-btn" onclick="changeQuantity(1)">+</button>
    <?php if ($selected_size): ?>
        <span style="margin-left: 15px;">Available: <?php echo $selected_size['stock']; ?></span>
    <?php endif; ?>
</div>

                        <!-- Price Display -->
                        <div class="price-section">
                            <?php if ($selected_size): ?>
                                Price: ₹<?php echo number_format($total_price, 2); ?>
                                <input type="hidden" id="base_price" value="<?php echo $selected_size['price']; ?>">
                            <?php else: ?>
                                Please select a size to see price
                            <?php endif; ?>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <button type="submit" class="btn-add-to-cart">Add to Cart</button>
                            <button type="button" class="btn-buy-now">Buy Now</button>
                        </div>
                    </form>

                    <!-- Product Description -->
                    <div class="description-section">
                        <h4>Description</h4>
                        <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Detail End -->

    <!-- Footer Start -->
    <?php include('indexfooter.php'); ?>
    <!-- Footer End -->

<script>
    // Initialize variables
    let currentPrice = <?php echo ($selected_size) ? $selected_size['price'] : 0; ?>;
    let currentStock = <?php echo ($selected_size) ? $selected_size['stock'] : 0; ?>;
    
    // Function to handle size selection
   function selectSize(element, sizeId, price, stock) {
        // Remove selected class from all size boxes
        var sizeBoxes = document.querySelectorAll('.size-box');
        sizeBoxes.forEach(function(box) {
            box.classList.remove('selected');
        });
        
        // Add selected class to clicked box
        element.classList.add('selected');
        
        // Check the corresponding radio button
        document.getElementById('size_' + sizeId).checked = true;
        
        // Update price and stock information
        document.getElementById('base_price').value = price;
        document.querySelector('input[name="quantity"]').max = stock;
        
        // Update available stock display
        var stockDisplay = document.querySelector('.quantity-selector span');
        if (stockDisplay) {
            stockDisplay.textContent = 'Available: ' + stock;
        }
        
        // Update the price display
        updatePrice();
    }
    
    // Basic quantity adjustment function
    function changeQuantity(change) {
        var input = document.querySelector('input[name="quantity"]');
        var newValue = parseInt(input.value) + change;
        var max = parseInt(input.max);
        
        if (newValue < 1) newValue = 1;
        if (max && newValue > max) newValue = max;
        
        input.value = newValue;
        updatePrice();
    }
    
    // Price update function
    function updatePrice() {
        var basePrice = parseFloat(document.getElementById('base_price').value) || 0;
        var quantity = parseInt(document.querySelector('input[name="quantity"]').value) || 1;
        var totalPrice = basePrice * quantity;
        
        var priceDisplay = document.getElementById('price-display');
        if (priceDisplay) {
            priceDisplay.textContent = basePrice > 0 ? 
                'Total Price: ₹' + totalPrice.toFixed(2) : 
                'Please select a size to see price';
        }
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Set up any pre-selected size
        var selectedSize = document.querySelector('input[name="size_id"]:checked');
        if (selectedSize) {
            var sizeBox = selectedSize.closest('.size-box');
            if (sizeBox) {
                sizeBox.classList.add('selected');
            }
            updatePrice();
        }
    });
</script>
</body>

</html>