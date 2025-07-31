<?php
include('connection.php');

if (isset($_POST["btnsubcategory"])) {
    $subcategoryname = $_POST['subcategoryname'];
    $category_id = $_POST['category_id'];
    $sql = "INSERT INTO tblsubcategory (subcategoryname,category_id) VALUES ('$subcategoryname','$category_id')";
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
                        window.location.replace('adminhome.php?page=subcategory');
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
                        window.location.replace('adminhome.php?page=subcategory');
                    }
                });
            });
        </script>
<?php
    }
}
if (isset($_POST['id']) && isset($_POST['ids'])) {
    $delete_id = $_POST['ids'];
    $delete_sql = "DELETE FROM tblsubcategory WHERE subcategoryid = $delete_id";
    if (mysqli_query($conn, $delete_sql)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    text: 'Subcategory deleted successfully',
                    didClose: () => {
                        window.location.href = window.location.pathname;
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
    /* Subcategory Page Specific Styles */
    .subcategory-container {
        padding: 1.5rem;
    }
    
    .subcategory-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .subcategory-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: var(--light);
    }
    
    .subcategory-card-header h5 {
        font-size: 1.2rem;
        color: var(--primary-dark);
        margin: 0;
    }
    
    .add-subcategory-btn {
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
    
    .add-subcategory-btn:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
    }
    
    /* Table Styles */
    .subcategory-table-container {
        width: 100%;
        overflow-x: auto;
    }
    
    .subcategory-table {
        width: 100%;
        min-width: 600px;
        border-collapse: separate;
        border-spacing: 0;
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .subcategory-table thead th {
        background-color: var(--primary);
        color: white;
        padding: 1rem 1.25rem;
        text-align: left;
        font-weight: 500;
        font-size: 0.9rem;
        border-bottom: 2px solid var(--primary-dark);
    }
    
    .subcategory-table tbody td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        font-size: 0.9rem;
        vertical-align: middle;
    }
    
    .subcategory-table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .subcategory-table tbody tr:hover {
        background-color: rgba(45, 149, 150, 0.08);
    }
    
    /* Column Widths */
    .subcategory-table th:nth-child(1),
    .subcategory-table td:nth-child(1) {
        width: 40%;
    }
    
    .subcategory-table th:nth-child(2),
    .subcategory-table td:nth-child(2) {
        width: 40%;
    }
    
    .subcategory-table th:nth-child(3),
    .subcategory-table td:nth-child(3) {
        width: 20%;
        text-align: center;
    }
    
    /* Action Buttons */
    .action-btns {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
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
    .subcategory-modal .modal-header {
        background-color: var(--primary);
        color: white;
        border-bottom: none;
    }
    
    .subcategory-modal .modal-title {
        font-weight: 600;
    }
    
    .subcategory-modal .btn-close {
        color: white;
        opacity: 0.8;
    }
    
    .subcategory-modal .btn-close:hover {
        opacity: 1;
    }
    
    .subcategory-modal .modal-body {
        padding: 1.5rem;
    }
    
    .subcategory-modal .form-group {
        margin-bottom: 1.5rem;
    }
    
    .subcategory-modal .form-control {
        border-radius: 5px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        padding: 0.5rem 1rem;
    }
    
    .subcategory-modal .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(45, 149, 150, 0.25);
    }
    
    .subcategory-modal .input-group-text {
        background-color: var(--light);
        border-color: rgba(0, 0, 0, 0.1);
    }
    
    .subcategory-modal .modal-footer {
        border-top: none;
        padding: 1rem 1.5rem;
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
</style>

<div class="subcategory-container">
    <div class="subcategory-card">
        <div class="subcategory-card-header">
            <h5><i class="fas fa-layer-group"></i> Subcategories Management</h5>
            <button type="button" class="add-subcategory-btn" data-bs-toggle="modal" data-bs-target="#addSubcategoryModal">
                <i class="fas fa-plus"></i> Add Subcategory
            </button>
        </div>
        
        <div class="card-body" style="margin-top:30px;">
            <?php
            $sql = "SELECT COUNT(*) as total FROM tblsubcategory";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            
            if ($row['total'] == 0): ?>
                <div class="empty-state">
                    <i class="fas fa-list-alt"></i>
                    <h5>No Subcategories Found</h5>
                    <p>You haven't added any subcategories yet. Click the "Add Subcategory" button to get started.</p>
                </div>
            <?php else: ?>
                <div class="subcategory-table-container">
                    <table class="subcategory-table">
                        <thead>
                            <tr>
                                <th>Subcategory Name</th>
                                <th>Category Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT tblsubcategory.*, tblcategory.categoryname 
                                    FROM tblsubcategory 
                                    JOIN tblcategory 
                                    ON tblsubcategory.category_id = tblcategory.category_id
                                    ORDER BY tblsubcategory.subcategoryid DESC";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                while ($row = mysqli_fetch_array($result)) {
                            ?>
                                    <tr>
                                        <td><?php echo $row['subcategoryname'] ?></td>
                                        <td><?php echo $row['categoryname'] ?></td>
                                        <td class="action-btns">
                                            <form method="POST" action="">
                                                <input type="hidden" name="ids" value="<?php echo $row['subcategoryid']; ?>">
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

<!-- Add Subcategory Modal -->
<div class="modal fade subcategory-modal" id="addSubcategoryModal" tabindex="-1" aria-labelledby="addSubcategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubcategoryModalLabel"><i class="fas fa-plus-circle"></i> Add New Subcategory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="" selected disabled>Select category</option>
                            <?php
                            $sql = "SELECT * FROM tblcategory";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<option value="' . $row['category_id'] . '">' . $row['categoryname'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="subcategoryName" class="form-label">Subcategory Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-list"></i></span>
                            <input type="text" class="form-control" id="subcategoryName" name="subcategoryname" placeholder="Enter subcategory name" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="btnsubcategory" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Subcategory
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Bootstrap JS Bundle with Popper for modal functionality -->
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
                const subcategoryName = this.closest('tr').querySelector('td:nth-child(1)').textContent;
                
                Swal.fire({
                    title: 'Delete Subcategory?',
                    html: `Are you sure you want to delete <strong>${subcategoryName}</strong>?`,
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