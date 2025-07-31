<?php
include('connection.php');

// Add Product
if (isset($_POST["btnproduct"])) {
    $productname = $_POST['productname'];
    $pet_id = $_POST['pet_id'];
    $category_id = $_POST['category_id'];
    $subcategoryid = $_POST['subcategoryid'];
    $brand_id = $_POST['brand_id'];
    $description = $_POST['description'];

    // Handle image upload
    $image = '';
    if (isset($_FILES['image'])) {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($file_ext, $allowed_ext)) {
            $image = "uploads/" . uniqid() . '.' . $file_ext;
            move_uploaded_file($file_tmp, $image);
        }
    }

    $sql = "INSERT INTO tblproduct (productname, pet_id, category_id, subcategoryid, brand_id, description, image) 
            VALUES ('$productname', '$pet_id', '$category_id', '$subcategoryid', '$brand_id', '$description', '$image')";

    if (mysqli_query($conn, $sql)) { ?>
        <script type="text/javascript" src="swal/jquery.min.js"></script>
        <script type="text/javascript" src="swal/bootstrap.min.js"></script>
        <script type="text/javascript" src="swal/sweetalert2@11.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    text: 'Product added successfully',
                    didClose: () => {
                        window.location.replace('adminhome.php?page=product');
                    }
                });
            });
        </script>
    <?php
    } else { ?>
        <script type="text/javascript" src="swal/jquery.min.js"></script>
        <script type="text/javascript" src="swal/bootstrap.min.js"></script>
        <script type="text/javascript" src="swal/sweetalert2@11.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    text: 'Failed to add product',
                    didClose: () => {
                        window.location.replace('adminhome.php?page=product');
                    }
                });
            });
        </script>
    <?php
    }
}

// Delete Product


// Update Product
if (isset($_POST["btnupdateproduct"])) {
    $productid = $_POST['productid'];
    $productname = $_POST['productname'];
    $pet_id = $_POST['pet_id'];
    $category_id = $_POST['category_id'];
    $subcategoryid = $_POST['subcategoryid'];
    $brand_id = $_POST['brand_id'];
    $description = $_POST['description'];

    // Handle image update
    $image = $_POST['existing_image'];
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        // Delete old image if exists
        if ($image && file_exists($image)) {
            unlink($image);
        }

        // Upload new image
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($file_ext, $allowed_ext)) {
            $image = "uploads/" . uniqid() . '.' . $file_ext;
            move_uploaded_file($file_tmp, $image);
        }
    }

    $sql = "UPDATE tblproduct SET 
            productname = '$productname',
            pet_id = '$pet_id',
            category_id = '$category_id',
            subcategoryid = '$subcategoryid',
            brand_id = '$brand_id',
            description = '$description',
            image = '$image'
            WHERE productid = $productid";

    if (mysqli_query($conn, $sql)) { ?>
        <script type="text/javascript" src="swal/jquery.min.js"></script>
        <script type="text/javascript" src="swal/bootstrap.min.js"></script>
        <script type="text/javascript" src="swal/sweetalert2@11.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    text: 'Product updated successfully',
                    didClose: () => {
                        window.location.replace('adminhome.php?page=product');
                    }
                });
            });
        </script>
    <?php
    } else { ?>
        <script type="text/javascript" src="swal/jquery.min.js"></script>
        <script type="text/javascript" src="swal/bootstrap.min.js"></script>
        <script type="text/javascript" src="swal/sweetalert2@11.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    text: 'Failed to update product',
                    didClose: () => {
                        window.location.replace('adminhome.php?page=product');
                    }
                });
            });
        </script>
<?php
    }
}
?>

<!-- Add Bootstrap CSS for modal functionality -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Product Page Specific Styles */
    .product-container {
        padding: 1.5rem;
    }

    .product-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .product-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: var(--light);
    }

    .product-card-header h5 {
        font-size: 1.2rem;
        color: var(--primary-dark);
        margin: 0;
    }

    .add-product-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background-color: var(--primary);
        color: white;
        border-radius: 5px;
        transition: all 0.3s;
        border: none;
    }

    .add-product-btn:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
    }

    .product-table {
        width: 100%;
        border-collapse: collapse;
    }

    .product-table thead th {
        background-color: var(--light);
        padding: 0.8rem 1rem;
        text-align: left;
        font-weight: 600;
        color: var(--dark);
        font-size: 0.9rem;
    }

    .product-table tbody td {
        padding: 0.8rem 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        font-size: 0.9rem;
    }

    .product-table tbody tr:hover {
        background-color: rgba(45, 149, 150, 0.05);
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

    /* Modal Styles */
    .product-modal .modal-header {
        background-color: var(--primary);
        color: white;
        border-bottom: none;
    }

    .product-modal .modal-title {
        font-weight: 600;
    }

    .product-modal .close {
        color: white;
        text-shadow: none;
        opacity: 0.8;
    }

    .product-modal .close:hover {
        opacity: 1;
    }

    .product-modal .modal-body {
        padding: 1.5rem;
    }

    .product-modal .form-group {
        margin-bottom: 1.5rem;
    }

    .product-modal .form-control {
        border-radius: 5px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        padding: 0.5rem 1rem;
    }

    .product-modal .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(45, 149, 150, 0.25);
    }

    .product-modal .input-group-text {
        background-color: var(--light);
        border-color: rgba(0, 0, 0, 0.1);
    }

    .product-modal .modal-footer {
        border-top: none;
        padding: 1rem 1.5rem;
    }

    .product-modal .btn-secondary {
        background-color: var(--gray);
        border: none;
    }

    .product-modal .btn-primary {
        background-color: var(--primary);
        border: none;
    }

    .product-modal .btn-primary:hover {
        background-color: var(--primary-dark);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: var(--gray);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: var(--secondary);
    }

    .empty-state h5 {
        margin-bottom: 0.5rem;
        color: var(--dark);
    }

    /* Product Card View */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        padding: 1.5rem;
    }

    .product-item {
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .product-item:hover {
        transform: translateY(-5px);
    }

    .product-image {
        height: 180px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-details {
        padding: 1rem;
    }

    .product-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--dark);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .product-meta span {
        font-size: 0.75rem;
        background-color: var(--light);
        padding: 0.25rem 0.5rem;
        border-radius: 50px;
        color: var(--dark);
    }

    .product-description {
        font-size: 0.85rem;
        color: var(--gray);
        margin-bottom: 1rem;
        display: -webkit-box;

        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* View Toggle */
    .view-toggle {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .view-toggle-btn {
        background-color: var(--light);
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .view-toggle-btn.active {
        background-color: var(--primary);
        color: white;
    }

    /* Updated Table Styles */
    .product-table-container {
        width: 100%;
        overflow-x: auto;
    }

    .product-table {
        width: 100%;
        min-width: 800px;
        border-collapse: separate;
        border-spacing: 0;
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .product-table thead th {
        background-color: var(--primary);
        color: white;
        padding: 1rem 1.25rem;
        text-align: left;
        font-weight: 500;
        font-size: 0.9rem;
        border-bottom: 2px solid var(--primary-dark);
    }

    .product-table tbody td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .product-table tbody tr:last-child td {
        border-bottom: none;
    }

    .product-table tbody tr:hover {
        background-color: rgba(45, 149, 150, 0.08);
    }

    .product-image-small {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .product-table {
            min-width: 100%;
        }
    }

    @media (max-width: 768px) {

        .product-table thead th,
        .product-table tbody td {
            padding: 0.8rem;
        }

        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        /* 3 columns */
        gap: 1.5rem;
        padding: 1.5rem;
    }

    .product-item {
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .product-image {
        height: 180px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }

    .product-details {
        padding: 1rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .product-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
            /* 2 columns on medium screens */
        }
    }

    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: 1fr;
            /* 1 column on small screens */
        }
    }
</style>

<div class="product-container">
    <div class="product-card">
        <div class="product-card-header">
            <h5><i class="fas fa-box"></i> Products Management</h5>
            <button type="button" class="add-product-btn" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="fas fa-plus"></i> Add Product
            </button>
        </div>
        <div class="view-toggle-container" style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">
            <div class="view-toggle">
                <button class="view-toggle-btn active" data-view="table"><i class="fas fa-table"></i> Table View</button>
                <button class="view-toggle-btn" data-view="grid"><i class="fas fa-th-large"></i> Grid View</button>
            </div>
        </div>
        <div class="card-body" style="margin-top:30px;">
            <!-- View Toggle -->


            <?php
            $sql = "SELECT COUNT(*) as total FROM tblproduct";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);

            if ($row['total'] == 0): ?>
                <div class="empty-state">
                    <i class="fas fa-box-open"></i>
                    <h5>No Products Found</h5>
                    <p>You haven't added any products yet. Click the "Add Product" button to get started.</p>
                </div>
            <?php else: ?>
                <!-- Table View -->
                <div class="product-table-container" id="tableView">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Pet</th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>Brand</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT p.*, 
                                   c.categoryname, 
                                   s.subcategoryname, 
                                   pet.petname, 
                                   b.brandname 
                            FROM tblproduct p
                            LEFT JOIN tblcategory c ON p.category_id = c.category_id
                            LEFT JOIN tblsubcategory s ON p.subcategoryid = s.subcategoryid
                            LEFT JOIN tblpet pet ON p.pet_id = pet.pet_id
                            LEFT JOIN tblbrand b ON p.brand_id = b.brand_id
                            ORDER BY p.productid DESC";

                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                while ($row = mysqli_fetch_array($result)) {
                            ?>
                                    <tr>
                                        <td>
                                            <?php if ($row['image']): ?>
                                                <img src="<?php echo $row['image']; ?>" class="product-image-small" alt="<?php echo $row['productname']; ?>">
                                            <?php else: ?>
                                                <div class="no-image">No Image</div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $row['productname'] ?></td>
                                        <td><?php echo $row['petname'] ?></td>
                                        <td><?php echo $row['categoryname'] ?></td>
                                        <td><?php echo $row['subcategoryname'] ?></td>
                                        <td><?php echo $row['brandname'] ?></td>
                                        <td class="action-btns">
                                             <a href="adminhome.php?page=stock&productid=<?php echo $row['productid']; ?>" class="edit-btn">
                                            <i class="fas fa-boxes"></i> Stock
                                        </a>
                                            <button type="button" class="edit-btn" data-bs-toggle="modal" data-bs-target="#editProductModal"
                                                data-id="<?php echo $row['productid']; ?>"
                                                data-name="<?php echo $row['productname']; ?>"
                                                data-pet="<?php echo $row['pet_id']; ?>"
                                                data-category="<?php echo $row['category_id']; ?>"
                                                data-subcategory="<?php echo $row['subcategoryid']; ?>"
                                                data-brand="<?php echo $row['brand_id']; ?>"
                                                data-description="<?php echo $row['description']; ?>"
                                                data-image="<?php echo $row['image']; ?>">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                          
                                            <form method="POST" action="delete_product.php" id="delete" name="delete">
                                                <input type="hidden" name="productid" value="<?php echo $row['productid']; ?>">
                                                <button type="submit" name="delete_product" class="delete-btn">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Grid View -->
                <div class="product-grid" id="gridView" style="display: none;">
                    <?php
                    $sql = "SELECT p.*, 
           c.categoryname, 
           s.subcategoryname, 
           pet.petname, 
           b.brandname 
    FROM tblproduct p
    LEFT JOIN tblcategory c ON p.category_id = c.category_id
    LEFT JOIN tblsubcategory s ON p.subcategoryid = s.subcategoryid
    LEFT JOIN tblpet pet ON p.pet_id = pet.pet_id
    LEFT JOIN tblbrand b ON p.brand_id = b.brand_id
    ORDER BY p.productid DESC";

                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        while ($row = mysqli_fetch_array($result)) {
                    ?>
                            <div class="product-item">
                                <div class="product-image">
                                    <?php if ($row['image']): ?>
                                        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['productname']; ?>">
                                    <?php else: ?>
                                        <i class="fas fa-box-open" style="font-size: 3rem; color: #ccc;"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="product-details">
                                    <h3 class="product-title"><?php echo $row['productname']; ?></h3>

                                    <div class="product-meta-row">
                                        <div class="product-meta-col">
                                            <span class="meta-label">Pet:</span>
                                            <span class="meta-value"><?php echo $row['petname']; ?></span>
                                        </div>
                                        <div class="product-meta-col">
                                            <span class="meta-label">Category:</span>
                                            <span class="meta-value"><?php echo $row['categoryname']; ?></span>
                                        </div>
                                    </div>

                                    <div class="product-meta-row">
                                        <div class="product-meta-col">
                                            <span class="meta-label">Subcategory:</span>
                                            <span class="meta-value"><?php echo $row['subcategoryname']; ?></span>
                                        </div>
                                        <div class="product-meta-col">
                                            <span class="meta-label">Brand:</span>
                                            <span class="meta-value"><?php echo $row['brandname']; ?></span>
                                        </div>
                                    </div>

                                    <p class="product-description"><?php echo $row['description']; ?></p>

                                    <div class="product-actions">

                                     <a href="adminhome.php?page=stock&productid=<?php echo $row['productid']; ?>" class="edit-btn">
                                            <i class="fas fa-boxes"></i> Stock
                                        </a>
                                        <button type="button" class="edit-btn" data-bs-toggle="modal" data-bs-target="#editProductModal"
                                            data-id="<?php echo $row['productid']; ?>"
                                            data-name="<?php echo $row['productname']; ?>"
                                            data-pet="<?php echo $row['pet_id']; ?>"
                                            data-category="<?php echo $row['category_id']; ?>"
                                            data-subcategory="<?php echo $row['subcategoryid']; ?>"
                                            data-brand="<?php echo $row['brand_id']; ?>"
                                            data-description="<?php echo $row['description']; ?>"
                                            data-image="<?php echo $row['image']; ?>">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                       
                                        <form method="POST" action="delete_product.php" class="d-inline">
                                            <input type="hidden" name="productid" value="<?php echo $row['productid']; ?>">
                                            <button type="submit" name="delete_product" id="delete_product" class="delete-btn">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<!-- Previous PHP code remains exactly the same until the modal forms -->

<!-- Add Product Modal -->
<!-- Previous PHP code remains exactly the same until the modal forms -->

<!-- Add Product Modal -->
<!-- Add Product Modal -->
<div class="modal fade product-modal" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel"><i class="fas fa-plus-circle"></i> Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="productName" class="form-label">Product Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-box"></i></span>
                                    <input type="text" class="form-control" id="productName" name="productname" placeholder="Enter product name" required>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="petType" class="form-label">Pet Type</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-paw"></i></span>
                                    <select class="form-control" id="petType" name="pet_id" required>
                                        <option value="">Select Pet Type</option>
                                        <?php
                                        $pet_query = "SELECT * FROM tblpet";
                                        $pet_result = mysqli_query($conn, $pet_query);
                                        while ($pet = mysqli_fetch_assoc($pet_result)) {
                                            echo "<option value='{$pet['pet_id']}'>{$pet['petname']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="productCategory" class="form-label">Category</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-list"></i></span>
                                    <select class="form-control" id="productCategory" name="category_id" required>
                                        <option value="">Select Category</option>
                                        <?php
                                        $category_query = "SELECT * FROM tblcategory";
                                        $category_result = mysqli_query($conn, $category_query);
                                        while ($category = mysqli_fetch_assoc($category_result)) {
                                            echo "<option value='{$category['category_id']}'>{$category['categoryname']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="productSubcategory" class="form-label">Subcategory</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                                    <select class="form-control" id="productSubcategory" name="subcategoryid" required>
                                        <option value="">Select Subcategory</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="productBrand" class="form-label">Brand</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <select class="form-control" id="productBrand" name="brand_id" required>
                                        <option value="">Select Brand</option>
                                        <?php
                                        $brand_query = "SELECT * FROM tblbrand";
                                        $brand_result = mysqli_query($conn, $brand_query);
                                        while ($brand = mysqli_fetch_assoc($brand_result)) {
                                            echo "<option value='{$brand['brand_id']}'>{$brand['brandname']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="productDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="productDescription" name="description" rows="5" placeholder="Enter product description"></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label for="productImage" class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="productImage" name="image" accept="image/*">
                                <small class="text-muted">Upload a product image (JPEG, PNG, GIF)</small>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="btnproduct" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade product-modal" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel"><i class="fas fa-edit"></i> Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" id="editProductId" name="productid">
                    <input type="hidden" id="editExistingImage" name="existing_image">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="editProductName" class="form-label">Product Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-box"></i></span>
                                    <input type="text" class="form-control" id="editProductName" name="productname" placeholder="Enter product name" required>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="editPetType" class="form-label">Pet Type</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-paw"></i></span>
                                    <select class="form-control" id="editPetType" name="pet_id" required>
                                        <option value="">Select Pet Type</option>
                                        <?php
                                        $pet_query = "SELECT * FROM tblpet";
                                        $pet_result = mysqli_query($conn, $pet_query);
                                        while ($pet = mysqli_fetch_assoc($pet_result)) {
                                            echo "<option value='{$pet['pet_id']}'>{$pet['petname']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="editProductCategory" class="form-label">Category</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-list"></i></span>
                                    <select class="form-control" id="editProductCategory" name="category_id" required>
                                        <option value="">Select Category</option>
                                        <?php
                                        $category_query = "SELECT * FROM tblcategory";
                                        $category_result = mysqli_query($conn, $category_query);
                                        while ($category = mysqli_fetch_assoc($category_result)) {
                                            echo "<option value='{$category['category_id']}'>{$category['categoryname']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="editProductSubcategory" class="form-label">Subcategory</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                                    <select class="form-control" id="editProductSubcategory" name="subcategoryid" required>
                                        <option value="">Select Subcategory</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="editProductBrand" class="form-label">Brand</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <select class="form-control" id="editProductBrand" name="brand_id" required>
                                        <option value="">Select Brand</option>
                                        <?php
                                        $brand_query = "SELECT * FROM tblbrand";
                                        $brand_result = mysqli_query($conn, $brand_query);
                                        while ($brand = mysqli_fetch_assoc($brand_result)) {
                                            echo "<option value='{$brand['brand_id']}'>{$brand['brandname']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="editProductDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="editProductDescription" name="description" rows="5" placeholder="Enter product description"></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label for="editProductImage" class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="editProductImage" name="image" accept="image/*">
                                <small class="text-muted">Leave blank to keep current image</small>
                                <div id="currentImageContainer" class="mt-2">
                                    <img id="currentImagePreview" src="" style="max-width: 100px; max-height: 100px;" class="img-thumbnail">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="btnupdateproduct" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Rest of the code remains exactly the same -->

<!-- Rest of the code remains exactly the same -->

<!-- Add Bootstrap JS Bundle with Popper for modal functionality -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Enhanced delete confirmation with SweetAlert
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const form = this.closest('form');
                const productName = this.closest('tr') ?
                    this.closest('tr').querySelector('td:nth-child(2)').textContent :
                    this.closest('.product-item').querySelector('.product-title').textContent;

                Swal.fire({
                    title: 'Delete Product?',
                    html: `Are you sure you want to delete <strong>${productName}</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2D9596',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // View Toggle
        const viewToggleBtns = document.querySelectorAll('.view-toggle-btn');
        const tableView = document.getElementById('tableView');
        const gridView = document.getElementById('gridView');

        viewToggleBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                viewToggleBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                if (this.dataset.view === 'table') {
                    tableView.style.display = 'block';
                    gridView.style.display = 'none';
                } else {
                    tableView.style.display = 'none';
                    gridView.style.display = 'grid';
                }
            });
        });

        // Load subcategories based on category selection (Add Product)
        $('#productCategory').change(function() {
            const categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    url: 'get_subcategories.php',
                    type: 'POST',
                    data: {
                        category_id: categoryId
                    },
                    success: function(data) {
                        $('#productSubcategory').html(data);
                    }
                });
            } else {
                $('#productSubcategory').html('<option value="">Select Subcategory</option>');
            }
        });

        // Load subcategories based on category selection (Edit Product)
        $('#editProductCategory').change(function() {
            const categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    url: 'get_subcategories.php',
                    type: 'POST',
                    data: {
                        category_id: categoryId
                    },
                    success: function(data) {
                        $('#editProductSubcategory').html(data);
                    }
                });
            } else {
                $('#editProductSubcategory').html('<option value="">Select Subcategory</option>');
            }
        });

        // Edit Product Modal
        $('#editProductModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const productId = button.data('id');
            const productName = button.data('name');
            const petId = button.data('pet');
            const categoryId = button.data('category');
            const subcategoryId = button.data('subcategory');
            const brandId = button.data('brand');
            const description = button.data('description');
            const image = button.data('image');

            const modal = $(this);
            modal.find('#editProductId').val(productId);
            modal.find('#editProductName').val(productName);
            modal.find('#editPetType').val(petId);
            modal.find('#editProductCategory').val(categoryId);
            modal.find('#editProductBrand').val(brandId);
            modal.find('#editProductDescription').val(description);
            modal.find('#editExistingImage').val(image);

            // Load current image preview
            if (image) {
                modal.find('#currentImagePreview').attr('src', image);
                modal.find('#currentImageContainer').show();
            } else {
                modal.find('#currentImageContainer').hide();
            }

            // Load subcategories for the selected category
            if (categoryId) {
                $.ajax({
                    url: 'get_subcategories.php',
                    type: 'POST',
                    data: {
                        category_id: categoryId
                    },
                    success: function(data) {
                        $('#editProductSubcategory').html(data);
                        $('#editProductSubcategory').val(subcategoryId);
                    }
                });
            }
        });
    });
</script>