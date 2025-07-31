<?php
include('connection.php');

if (isset($_POST["btncategory"])) {
    $categoryname = $_POST['categoryname'];
    $sql = "INSERT INTO tblcategory (categoryname) VALUES ('$categoryname')";
    if (mysqli_query($conn, $sql)) { ?>
        <script type="text/javascript" src="swal/jquery.min.js"></script>
        <script type="text/javascript" src="swal/bootstrap.min.js"></script>
        <script type="text/javascript" src="swal/sweetalert2@11.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    text: 'Successfully added',
                    didClose: () => {
                        window.location.replace('adminhome.php?page=category');
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
                    icon: 'info',
                    text: 'Failed to add',
                    didClose: () => {
                        window.location.replace('adminhome.php?page=category');
                    }
                });
            });
        </script>

<?php
    }
}
if (isset($_POST['id']) && isset($_POST['ids'])) {
    $delete_id = $_POST['ids'];
    $delete_sql = "DELETE FROM tblcategory WHERE category_id = $delete_id";
    if (mysqli_query($conn, $delete_sql)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    text: 'Category deleted successfully',
                    didClose: () => {
                        window.location.href = adminhome.php?page=category;
                    }
                });
            });
        </script>";
    }
}
?>

<!-- Add Bootstrap CSS for modal functionality -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Category Page Specific Styles */
    .category-container {
        padding: 1.5rem;
    }

    .category-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .category-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: var(--light);
    }

    .category-card-header h5 {
        font-size: 1.2rem;
        color: var(--primary-dark);
        margin: 0;
    }

    .add-category-btn {
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

    .add-category-btn:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
    }

    .category-table {
        width: 100%;
        border-collapse: collapse;
    }

    .category-table thead th {
        background-color: var(--light);
        padding: 0.8rem 1rem;
        text-align: left;
        font-weight: 600;
        color: var(--dark);
        font-size: 0.9rem;
    }

    .category-table tbody td {
        padding: 0.8rem 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        font-size: 0.9rem;
    }

    .category-table tbody tr:hover {
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
    .category-modal .modal-header {
        background-color: var(--primary);
        color: white;
        border-bottom: none;
    }

    .category-modal .modal-title {
        font-weight: 600;
    }

    .category-modal .close {
        color: white;
        text-shadow: none;
        opacity: 0.8;
    }

    .category-modal .close:hover {
        opacity: 1;
    }

    .category-modal .modal-body {
        padding: 1.5rem;
    }

    .category-modal .form-group {
        margin-bottom: 1.5rem;
    }

    .category-modal .form-control {
        border-radius: 5px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        padding: 0.5rem 1rem;
    }

    .category-modal .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(45, 149, 150, 0.25);
    }

    .category-modal .input-group-text {
        background-color: var(--light);
        border-color: rgba(0, 0, 0, 0.1);
    }

    .category-modal .modal-footer {
        border-top: none;
        padding: 1rem 1.5rem;
    }

    .category-modal .btn-secondary {
        background-color: var(--gray);
        border: none;
    }

    .category-modal .btn-primary {
        background-color: var(--primary);
        border: none;
    }

    .category-modal .btn-primary:hover {
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

    /* Updated Table Styles */
    .category-table-container {
        width: 100%;
        overflow-x: auto;
    }

    .category-table {
        width: 100%;
        min-width: 600px;
        /* Ensures table doesn't get too narrow */
        border-collapse: separate;
        border-spacing: 0;
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .category-table thead th {
        background-color: var(--primary);
        color: white;
        padding: 1rem 1.25rem;
        text-align: left;
        font-weight: 500;
        font-size: 0.9rem;
        border-bottom: 2px solid var(--primary-dark);
    }

    .category-table tbody td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .category-table tbody tr:last-child td {
        border-bottom: none;
    }

    .category-table tbody tr:hover {
        background-color: rgba(45, 149, 150, 0.08);
    }

    /* Column Widths */
    .category-table th:nth-child(1),
    .category-table td:nth-child(1) {
        width: 15%;
    }

    .category-table th:nth-child(2),
    .category-table td:nth-child(2) {
        width: 65%;
    }

    .category-table th:nth-child(3),
    .category-table td:nth-child(3) {
        width: 20%;
        text-align: center;
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .category-table {
            min-width: 100%;
        }

        .category-table th:nth-child(1),
        .category-table td:nth-child(1) {
            width: 20%;
        }

        .category-table th:nth-child(2),
        .category-table td:nth-child(2) {
            width: 60%;
        }

        .category-table th:nth-child(3),
        .category-table td:nth-child(3) {
            width: 20%;
        }
    }

    @media (max-width: 768px) {

        .category-table thead th,
        .category-table tbody td {
            padding: 0.8rem;
        }
    }
</style>
</style>

<div class="category-container">
    <div class="category-card">
        <div class="category-card-header">
            <h5><i class="fas fa-list"></i> Categories Management</h5>
            <button type="button" class="add-category-btn" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="fas fa-plus"></i> Add Category
            </button>
        </div>

        <div class="card-body" style="margin-top:30px;">
            <?php
            $sql = "SELECT COUNT(*) as total FROM tblcategory";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);

            if ($row['total'] == 0): ?>
                <div class="empty-state">
                    <i class="fas fa-list-alt"></i>
                    <h5>No Categories Found</h5>
                    <p>You haven't added any categories yet. Click the "Add Category" button to get started.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="category-table">
                        <thead>
                            <tr>
                                <th>Category ID</th>
                                <th>Category Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM tblcategory ORDER BY category_id DESC";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                while ($row = mysqli_fetch_array($result)) {
                            ?>
                                    <tr>
                                        <td>#<?php echo $row['category_id'] ?></td>
                                        <td><?php echo $row['categoryname'] ?></td>
                                        <td class="action-btns">
                                            <form method="POST" action="">
                                                <input type="hidden" name="ids" value="<?php echo $row['category_id']; ?>">
                                                <button type="submit" name="id" class="delete-btn">
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
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade category-modal" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel"><i class="fas fa-plus-circle"></i> Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-list"></i></span>
                            <input type="text" class="form-control" id="categoryName" name="categoryname" placeholder="Enter category name" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="btncategory" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade category-modal" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel"><i class="fas fa-edit"></i> Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <div class="form-group mb-3">
                        <label for="editCategoryName" class="form-label">Category Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-list"></i></span>
                            <input type="text" class="form-control" id="editCategoryName" name="categoryname" placeholder="Enter category name" value="Pet Food">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="btncategory" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Bootstrap JS Bundle with Popper for modal functionality -->
<!-- Add this JavaScript code right before the closing </body> tag -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Enhanced delete confirmation with SweetAlert
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const form = this.closest('form');
                const categoryName = this.closest('tr').querySelector('td:nth-child(2)').textContent;

                Swal.fire({
                    title: 'Delete Category?',
                    html: `Are you sure you want to delete <strong>${categoryName}</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2D9596',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create a hidden input for the delete action
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'id';
                        hiddenInput.value = 'delete';
                        form.appendChild(hiddenInput);

                        // Submit the form
                        form.submit();
                    }
                });
            });
        });
    });
</script>