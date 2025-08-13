<?php
include('connection.php');
include('indexheader.php');

// Get product ID from URL
/* $product_id = isset($_GET['id']) ? intval($_GET['id']) : 0; */
$product_id = 15;
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
        :root {
            --primary-color: #2874f0;
            --secondary-color: #fb641b;
            --light-gray: #f1f3f6;
            --dark-gray: #878787;
            --white: #ffffff;
            --black: #212121;
            --green: #388e3c;
        }
        
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: var(--light-gray);
            color: var(--black);
            margin: 0;
            padding: 0;
        }
        
        .product-container {
            max-width: 1200px;
            margin: 20px auto;
            background: var(--white);
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
            border-radius: 2px;
            padding: 20px;
        }
        
        .product-row {
            display: flex;
            flex-wrap: wrap;
        }
        
        .product-gallery {
            width: 45%;
            padding: 15px;
        }
        
        .main-image-container {
            border: 1px solid #f0f0f0;
            height: 450px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }
        
        .main-image {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }
        
        .thumbnail-container {
            display: flex;
            gap: 10px;
        }
        
        .thumbnail {
            width: 60px;
            height: 60px;
            border: 1px solid #f0f0f0;
            cursor: pointer;
            padding: 5px;
        }
        
        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .product-details {
            width: 55%;
            padding: 15px;
            position: relative;
        }
        
        .product-title {
            font-size: 24px;
            font-weight: 500;
            margin-bottom: 10px;
            color: var(--black);
        }
        
        .product-subtitle {
            font-size: 14px;
            color: var(--dark-gray);
            margin-bottom: 15px;
        }
        
        .rating-container {
            display: flex;
            align-items: center;
            background: var(--green);
            color: white;
            width: fit-content;
            padding: 2px 8px 2px 6px;
            border-radius: 3px;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .rating-star {
            font-size: 12px;
            margin-right: 4px;
        }
        
        .rating-count {
            color: var(--primary-color);
            margin-left: 8px;
            font-weight: 500;
            cursor: pointer;
        }
        
        .price-container {
            margin: 20px 0;
        }
        
        .current-price {
            font-size: 28px;
            font-weight: 500;
        }
        
        .original-price {
            text-decoration: line-through;
            color: var(--dark-gray);
            margin-left: 10px;
            font-size: 18px;
        }
        
        .discount-percent {
            color: var(--green);
            font-size: 18px;
            font-weight: 500;
            margin-left: 10px;
        }
        
        .tax-info {
            color: var(--green);
            font-size: 14px;
            margin-top: 8px;
        }
        
        .size-section {
            margin: 25px 0;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 15px;
            color: var(--black);
        }
        
        .size-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .size-option {
            border: 1px solid #c2c2c2;
            padding: 8px 20px;
            border-radius: 2px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .size-option.selected {
            border-color: var(--primary-color);
            background-color: #f0f8ff;
            color: var(--primary-color);
            font-weight: 500;
        }
        
        .quantity-section {
            margin: 25px 0;
        }
        
        .quantity-selector {
            display: flex;
            align-items: center;
        }
        
        .quantity-btn {
            width: 30px;
            height: 30px;
            background: #f0f0f0;
            border: 1px solid #c2c2c2;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .quantity-input {
            width: 50px;
            height: 30px;
            text-align: center;
            border-top: 1px solid #c2c2c2;
            border-bottom: 1px solid #c2c2c2;
            border-left: none;
            border-right: none;
        }
        
        .stock-info {
            font-size: 14px;
            color: var(--dark-gray);
            margin-left: 15px;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            margin: 30px 0;
        }
        
        .btn-add-to-cart {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 2px;
            cursor: pointer;
            box-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }
        
        .btn-buy-now {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 2px;
            cursor: pointer;
            box-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }
        
        .delivery-info {
            border-top: 1px dashed #e0e0e0;
            padding-top: 20px;
            margin-top: 20px;
        }
        
        .delivery-option {
            display: flex;
            margin-bottom: 15px;
        }
        
        .delivery-icon {
            margin-right: 10px;
            color: var(--primary-color);
        }
        
        .delivery-text {
            font-size: 14px;
        }
        
        .delivery-highlight {
            color: var(--green);
            font-weight: 500;
        }
        
        .product-description {
            margin-top: 40px;
        }
        
        .description-title {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 15px;
            color: var(--black);
        }
        
        .description-content {
            font-size: 14px;
            line-height: 1.5;
            color: #212121;
        }
        
        .product-meta {
            margin-top: 20px;
            font-size: 14px;
            color: var(--dark-gray);
        }
        
        .meta-item {
            margin-bottom: 5px;
        }
        
        @media (max-width: 768px) {
            .product-gallery, .product-details {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar Start -->
    <?php include('usernav.php'); ?>
    <!-- Navbar End -->

    <!-- Product Detail Start -->
    <div class="product-container">
        <div class="product-row">
            <!-- Product Gallery -->
            <div class="product-gallery">
                <div class="main-image-container">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>"
                         alt="<?php echo htmlspecialchars($product['productname']); ?>"
                         class="main-image">
                </div>
                <div class="thumbnail-container">
                    <div class="thumbnail">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Thumbnail 1">
                    </div>
                    <!-- Add more thumbnails if available -->
                </div>
            </div>

            <!-- Product Details -->
            <div class="product-details">
                <h1 class="product-title"><?php echo htmlspecialchars($product['productname']); ?></h1>
                <div class="product-subtitle"><?php echo htmlspecialchars($product['brandname']); ?></div>
                
                <div class="rating-container">
                    <span class="rating-star">★</span>
                    <span>4.2</span>
                    <span class="rating-count">12,345 Ratings</span>
                </div>
                
                <div class="price-container">
                    <span class="current-price" id="price_display">
                        <?php if ($selected_size): ?>
                            ₹<?php echo number_format($total_price, 2); ?>
                        <?php else: ?>
                            Select size to see price
                        <?php endif; ?>
                    </span>
                    <input type="hidden" id="base_price" value="<?php echo ($selected_size) ? $selected_size['price'] : 0; ?>">
                </div>
                
                <form method="POST" action="">
                    <!-- Size Selection -->
                    <div class="size-section">
                        <div class="section-title">Select Size</div>
                        <div class="size-options">
                            <?php foreach ($sizes as $size): ?>
                                <div class="size-option <?php echo ($selected_size && $selected_size['productsizeid'] == $size['productsizeid']) ? 'selected' : ''; ?>"
                                     onclick="selectSize(this, <?php echo $size['productsizeid']; ?>, <?php echo $size['price']; ?>, <?php echo $size['stock']; ?>)">
                                    <input type="radio" name="size_id" value="<?php echo $size['productsizeid']; ?>"
                                           id="size_<?php echo $size['productsizeid']; ?>"
                                           style="display: none;"
                                           <?php echo ($selected_size && $selected_size['productsizeid'] == $size['productsizeid']) ? 'checked' : ''; ?>>
                                    <label for="size_<?php echo $size['productsizeid']; ?>">
                                        <?php echo htmlspecialchars($size['size']); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Quantity Selector -->
                    <div class="quantity-section">
                        <div class="section-title">Quantity</div>
                        <div class="quantity-selector">
                            <button type="button" class="quantity-btn" onclick="changeQuantity(-1)">-</button>
                            <input type="number" name="quantity" class="quantity-input" id="quantity_input"
                                value="<?php echo $quantity; ?>" min="1" max="<?php echo ($selected_size) ? $selected_size['stock'] : 1; ?>">
                            <button type="button" class="quantity-btn" onclick="changeQuantity(1)">+</button>
                            <span class="stock-info" id="stock_display">
                                <?php if ($selected_size): ?>
                                    <?php echo $selected_size['stock']; ?> available
                                <?php else: ?>
                                    Select size to see availability
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button type="submit" class="btn-add-to-cart">ADD TO CART</button>
                        <button type="button" class="btn-buy-now">BUY NOW</button>
                    </div>
                </form>
                
                <!-- Delivery Info -->
                <div class="delivery-info">
                    
                    <div class="delivery-option">
                        <div class="delivery-icon">✓</div>
                        <div class="delivery-text">
                            <span class="delivery-highlight">7 days</span> replacement policy
                        </div>
                    </div>
                    <div class="delivery-option">
                        <div class="delivery-icon">✓</div>
                        <div class="delivery-text">
                            <span class="delivery-highlight">Cash on Delivery</span> available
                        </div>
                    </div>
                </div>
                
                <!-- Product Description -->
                <div class="product-description">
                    <div class="description-title">Description</div>
                    <div class="description-content">
                        <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                    </div>
                </div>
                
                <!-- Product Meta -->
                <div class="product-meta">
                    <div class="meta-item"><strong>Brand:</strong> <?php echo htmlspecialchars($product['brandname']); ?></div>
                    <div class="meta-item"><strong>Category:</strong> <?php echo htmlspecialchars($product['categoryname']); ?></div>
                    <div class="meta-item"><strong>Subcategory:</strong> <?php echo htmlspecialchars($product['subcategoryname']); ?></div>
                    <div class="meta-item"><strong>For:</strong> <?php echo htmlspecialchars($product['petname']); ?></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Detail End -->

    <!-- Footer Start -->
    <?php include('indexfooter.php'); ?>
    <!-- Footer End -->

    <script>
    // Function to handle size selection
    function selectSize(element, sizeId, price, stock) {
        // Remove selected class from all size options
        document.querySelectorAll('.size-option').forEach(option => {
            option.classList.remove('selected');
        });
        
        // Add selected class to clicked option
        element.classList.add('selected');
        
        // Check the corresponding radio button
        document.getElementById('size_' + sizeId).checked = true;
        
        // Update the hidden base price field
        document.getElementById('base_price').value = price;
        
        // Get the quantity input element
        const quantityInput = document.getElementById('quantity_input');
        
        // Update the max quantity allowed
        quantityInput.max = stock;
        
        // Update available stock display
        document.getElementById('stock_display').textContent = stock + ' available';
        
        // If current quantity exceeds new stock, adjust it
        if (parseInt(quantityInput.value) > stock) {
            quantityInput.value = stock;
        }
        
        // Update the price display
        updatePrice();
    }
    
    // Function to change quantity
    function changeQuantity(change) {
        const quantityInput = document.getElementById('quantity_input');
        let currentValue = parseInt(quantityInput.value) || 1;
        const maxQuantity = parseInt(quantityInput.max) || 1;
        const minQuantity = parseInt(quantityInput.min) || 1;
        
        // Calculate new value
        let newValue = currentValue + change;
        
        // Validate new value
        if (newValue < minQuantity) {
            newValue = minQuantity;
        } else if (newValue > maxQuantity) {
            newValue = maxQuantity;
        }
        
        // Update the input value
        quantityInput.value = newValue;
        
        // Update the price display
        updatePrice();
    }
    
    // Function to update price display
    function updatePrice() {
        const basePrice = parseFloat(document.getElementById('base_price').value) || 0;
        const quantity = parseInt(document.getElementById('quantity_input').value) || 1;
        const totalPrice = basePrice * quantity;
        
        const priceDisplay = document.getElementById('price_display');
        if (basePrice > 0) {
            priceDisplay.textContent = '₹' + totalPrice.toFixed(2);
        } else {
            priceDisplay.textContent = 'Select size to see price';
        }
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Set up event listener for direct quantity input changes
        document.getElementById('quantity_input').addEventListener('change', function() {
            const max = parseInt(this.max) || 1;
            const min = parseInt(this.min) || 1;
            let value = parseInt(this.value);
            
            // Validate input
            if (isNaN(value)) {
                value = min;
            } else if (value < min) {
                value = min;
            } else if (value > max) {
                value = max;
            }
            
            this.value = value;
            updatePrice();
        });
        
        // Update price if we have a selected size on page load
        if (document.getElementById('base_price').value > 0) {
            updatePrice();
        }
    });
    </script>
</body>
</html>