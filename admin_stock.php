<?php
include('connection.php');

// Get product details
$productid = isset($_GET['productid']) ? intval($_GET['productid']) : 0;

// Fetch product details
$product_query = "SELECT p.*, 
                 c.categoryname, 
                 s.subcategoryname, 
                 pet.petname, 
                 b.brandname 
          FROM tblproduct p
          LEFT JOIN tblcategory c ON p.category_id = c.category_id
          LEFT JOIN tblsubcategory s ON p.subcategoryid = s.subcategoryid
          LEFT JOIN tblpet pet ON p.pet_id = pet.pet_id
          LEFT JOIN tblbrand b ON p.brand_id = b.brand_id
          WHERE p.productid = $productid";

$product_result = mysqli_query($conn, $product_query);
$product = mysqli_fetch_assoc($product_result);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['btnaddsize'])) {
        // Add new size/stock
        $size = mysqli_real_escape_string($conn, $_POST['size']);
        $stock = intval($_POST['stock']);
        $price = floatval($_POST['price']);

        $insert_query = "INSERT INTO tblproductsize (productid, size, stock, price) 
                         VALUES ($productid, '$size', $stock, $price)";
        mysqli_query($conn, $insert_query);
    } elseif (isset($_POST['btnupdatesize'])) {
        // Update size/stock
        $productsizeid = intval($_POST['productsizeid']);
        $size = mysqli_real_escape_string($conn, $_POST['size']);
        $stock = intval($_POST['stock']);
        $price = floatval($_POST['price']);

        $update_query = "UPDATE tblproductsize 
                         SET size = '$size', stock = $stock, price = $price
                         WHERE productsizeid = $productsizeid";
        mysqli_query($conn, $update_query);
    } elseif (isset($_POST['btndeletesize'])) {
        // Delete size/stock
        $productsizeid = intval($_POST['productsizeid']);
        $delete_query = "DELETE FROM tblproductsize WHERE productsizeid = $productsizeid";
        mysqli_query($conn, $delete_query);
    }

    echo "<script>window.location.href = 'adminhome.php?page=stock&productid=$productid';</script>";
    exit();
}

// Fetch all sizes for this product
$sizes_query = "SELECT * FROM tblproductsize WHERE productid = $productid ORDER BY size";
$sizes_result = mysqli_query($conn, $sizes_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Management</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2D9596;
            --primary-dark: #1a6b6c;
            --secondary: #9ADE7B;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --danger: #dc3545;
            --success: #28a745;
            --info: #17a2b8;
        }

        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .stock-container {
            padding: 1.5rem;
        }

        .stock-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .stock-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--light);
        }

        .stock-header h3 {
            font-size: 1.2rem;
            color: var(--primary-dark);
            margin: 0;
        }

        .back-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background-color: var(--primary);
            color: white;
            border-radius: 5px;
            transition: all 0.3s;
            text-decoration: none;
        }

        .back-btn:hover {
            background-color: var(--primary-dark);
            color: white;
            transform: translateY(-2px);
        }

        .stock-body {
            padding: 1.5rem;
        }

        .stock-management-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .product-details-card {
            flex: 1;
            min-width: 300px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
        }

        .stock-management-card {
            flex: 2;
            min-width: 300px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
        }

        .product-image-container {
            margin-bottom: 1.5rem;
        }

        .product-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 8px;
            background-color: #f8f9fa;
            border: 1px solid #eee;
        }

        .product-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .product-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .meta-item {
            background-color: var(--light);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            color: var(--dark);
        }

        .product-description {
            color: var(--gray);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .add-size-btn {
            margin-bottom: 1.5rem;
        }

        .stock-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .stock-table thead th {
            background-color: var(--primary);
            color: white;
            padding: 1rem 1.25rem;
            text-align: left;
            font-weight: 500;
            font-size: 0.9rem;
            border-bottom: 2px solid var(--primary-dark);
        }

        .stock-table tbody td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-size: 0.9rem;
            vertical-align: middle;
        }

        .stock-table tbody tr:last-child td {
            border-bottom: none;
        }

        .stock-table tbody tr:hover {
            background-color: rgba(45, 149, 150, 0.08);
        }

        .action-btns {
            display: flex;
            gap: 0.5rem;
        }

        .edit-btn {
            background-color: rgba(77, 150, 255, 0.1);
            color: var(--info);
            border: none;
            padding: 0.3rem 0.7rem;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .edit-btn:hover {
            background-color: rgba(77, 150, 255, 0.2);
        }

        .delete-btn {
            background-color: rgba(255, 107, 107, 0.1);
            color: var(--danger);
            border: none;
            padding: 0.3rem 0.7rem;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .delete-btn:hover {
            background-color: rgba(255, 107, 107, 0.2);
        }

        .no-sizes {
            text-align: center;
            padding: 2rem;
            color: var(--gray);
        }

        .no-sizes i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--secondary);
        }

        /* Modal styles */
        .modal-header {
            background-color: var(--primary);
            color: white;
            border-bottom: none;
        }

        .modal-title {
            font-weight: 600;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            padding: 0.5rem 1rem;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(45, 149, 150, 0.25);
        }

        .modal-footer {
            border-top: none;
            padding: 1rem 1.5rem;
        }

        .btn-primary {
            background-color: var(--primary);
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        @media (max-width: 768px) {
            .product-image {
                height: 200px;
            }

            .product-meta {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="stock-container">
        <div class="stock-card">
            <div class="stock-header">
                <h3><i class="fas fa-boxes"></i> Stock Management</h3>
                <a href="adminhome.php?page=product" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Back to Products
                </a>
            </div>

            <div class="stock-body">
                <?php if ($product): ?>
                    <div class="stock-management-container">
                        <!-- Left Column - Product Details Card -->
                        <div class="product-details-card">
                            <div class="product-image-container">
                                <?php if ($product['image']): ?>
                                    <img src="<?php echo $product['image']; ?>" class="product-image" alt="<?php echo $product['productname']; ?>">
                                <?php else: ?>
                                    <div class="product-image d-flex align-items-center justify-content-center">
                                        <i class="fas fa-box-open" style="font-size: 5rem; color: #ccc;"></i>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <h1 class="product-title"><?php echo $product['productname']; ?></h1>

                            <div class="product-meta">
                                <span class="meta-item"><i class="fas fa-paw"></i> <?php echo $product['petname']; ?></span>
                                <span class="meta-item"><i class="fas fa-list"></i> <?php echo $product['categoryname']; ?></span>
                                <span class="meta-item"><i class="fas fa-list-alt"></i> <?php echo $product['subcategoryname']; ?></span>
                                <span class="meta-item"><i class="fas fa-tag"></i> <?php echo $product['brandname']; ?></span>
                            </div>

                            <p class="product-description"><?php echo $product['description']; ?></p>
                        </div>

                        <!-- Right Column - Stock Management Card -->
                        <div class="stock-management-card">
                            <button type="button" class="btn btn-primary add-size-btn" data-bs-toggle="modal" data-bs-target="#addSizeModal">
                                <i class="fas fa-plus-circle"></i> Add New Size/Stock
                            </button>

                            <h4 class="mb-3"><i class="fas fa-table"></i> Current Stock</h4>

                            <?php
                            // Reset the pointer for the sizes result
                            mysqli_data_seek($sizes_result, 0);
                            if (mysqli_num_rows($sizes_result) > 0): ?>
                                <div class="table-responsive">
                                    <table class="stock-table">
                                        <thead>
                                            <tr>
                                                <th>Size</th>
                                                <th>Stock</th>
                                                <th>Price</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($size = mysqli_fetch_assoc($sizes_result)): ?>
                                                <tr>
                                                    <td><?php echo $size['size']; ?></td>
                                                    <td><?php echo $size['stock']; ?></td>
                                                    <td>$<?php echo number_format($size['price'], 2); ?></td>
                                                    <td class="action-btns">
                                                        <button type="button" class="edit-btn" data-bs-toggle="modal" data-bs-target="#editSizeModal"
                                                            data-id="<?php echo $size['productsizeid']; ?>"
                                                            data-size="<?php echo $size['size']; ?>"
                                                            data-stock="<?php echo $size['stock']; ?>"
                                                            data-price="<?php echo $size['price']; ?>">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>

                                                        <form method="POST" action="" class="d-inline">
                                                            <input type="hidden" name="productsizeid" value="<?php echo $size['productsizeid']; ?>">
                                                            <button type="submit" name="btndeletesize" class="delete-btn" onclick="return confirm('Are you sure you want to delete this size?')">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="no-sizes">
                                    <i class="fas fa-box-open"></i>
                                    <h5>No Sizes/Stock Added Yet</h5>
                                    <p>Add sizes and stock quantities using the button above.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> Product not found!
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Add Size Modal -->
    <div class="modal fade" id="addSizeModal" tabindex="-1" aria-labelledby="addSizeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSizeModalLabel"><i class="fas fa-plus-circle"></i> Add New Size/Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="size" class="form-label">Size</label>
                            <input type="text" class="form-control" id="size" name="size" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="stock" class="form-label">Stock Quantity</label>
                            <input type="number" class="form-control" id="stock" name="stock" min="0" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" min="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="btnaddsize" class="btn btn-primary">
                            <i class="fas fa-save"></i> Add Size
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Size Modal -->
    <div class="modal fade" id="editSizeModal" tabindex="-1" aria-labelledby="editSizeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSizeModalLabel"><i class="fas fa-edit"></i> Edit Size/Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <input type="hidden" id="editProductSizeId" name="productsizeid">

                        <div class="form-group mb-3">
                            <label for="editSize" class="form-label">Size</label>
                            <input type="text" class="form-control" id="editSize" name="size" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="editStock" class="form-label">Stock Quantity</label>
                            <input type="number" class="form-control" id="editStock" name="stock" min="0" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="editPrice" class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control" id="editPrice" name="price" min="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="btnupdatesize" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Edit Size Modal
        document.addEventListener('DOMContentLoaded', function() {
            const editSizeModal = document.getElementById('editSizeModal');
            if (editSizeModal) {
                editSizeModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const sizeId = button.getAttribute('data-id');
                    const size = button.getAttribute('data-size');
                    const stock = button.getAttribute('data-stock');
                    const price = button.getAttribute('data-price');

                    document.getElementById('editProductSizeId').value = sizeId;
                    document.getElementById('editSize').value = size;
                    document.getElementById('editStock').value = stock;
                    document.getElementById('editPrice').value = price;
                });
            }
        });
    </script>
</body>

</html>