<?php
include('connection.php');

if (isset($_POST["btnbrand"])) {
    $brandname = $_POST['brandname'];
    $sql = "INSERT INTO tblbrand(brandname) VALUES ('$brandname')";
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
                        window.location.replace('adminhome.php?page=brand');
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
                        window.location.replace('adminhome.php?page=brand');
                    }
                });
            });
        </script>
<?php
    }
}
if (isset($_POST['id']) && isset($_POST['ids'])) {
    $delete_id = $_POST['ids'];
    $delete_sql = "DELETE FROM tblbrand WHERE brand_id = $delete_id";
    if (mysqli_query($conn, $delete_sql)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    text: 'Brand deleted successfully',
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
    /* Brand Page Specific Styles */
    .brand-container {
        padding: 1.5rem;
    }
    
    .brand-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .brand-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: var(--light);
    }
    
    .brand-card-header h5 {
        font-size: 1.2rem;
        color: var(--primary-dark);
        margin: 0;
    }
    
    .add-brand-btn {
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
    
    .add-brand-btn:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
    }
    
    /* Table Styles */
    .brand-table-container {
        width: 100%;
        overflow-x: auto;
    }
    
    .brand-table {
        width: 100%;
        min-width: 600px;
        border-collapse: separate;
        border-spacing: 0;
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .brand-table thead th {
        background-color: var(--primary);
        color: white;
        padding: 1rem 1.25rem;
        text-align: left;
        font-weight: 500;
        font-size: 0.9rem;
        border-bottom: 2px solid var(--primary-dark);
    }
    
    .brand-table tbody td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        font-size: 0.9rem;
        vertical-align: middle;
    }
    
    .brand-table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .brand-table tbody tr:hover {
        background-color: rgba(45, 149, 150, 0.08);
    }
    
    /* Column Widths */
    .brand-table th:nth-child(1),
    .brand-table td:nth-child(1) {
        width: 80%;
    }
    
    .brand-table th:nth-child(2),
    .brand-table td:nth-child(2) {
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
    .brand-modal .modal-header {
        background-color: var(--primary);
        color: white;
        border-bottom: none;
    }
    
    .brand-modal .modal-title {
        font-weight: 600;
    }
    
    .brand-modal .btn-close {
        color: white;
        opacity: 0.8;
    }
    
    .brand-modal .btn-close:hover {
        opacity: 1;
    }
    
    .brand-modal .modal-body {
        padding: 1.5rem;
    }
    
    .brand-modal .form-group {
        margin-bottom: 1.5rem;
    }
    
    .brand-modal .form-control {
        border-radius: 5px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        padding: 0.5rem 1rem;
    }
    
    .brand-modal .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(45, 149, 150, 0.25);
    }
    
    .brand-modal .input-group-text {
        background-color: var(--light);
        border-color: rgba(0, 0, 0, 0.1);
    }
    
    .brand-modal .modal-footer {
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

<div class="brand-container">
    <div class="brand-card">
        <div class="brand-card-header">
            <h5><i class="fas fa-tag"></i> Brand Management</h5>
            <button type="button" class="add-brand-btn" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                <i class="fas fa-plus"></i> Add Brand
            </button>
        </div>
        
        <div class="card-body" style="margin-top:30px;">
            <?php
            $sql = "SELECT COUNT(*) as total FROM tblbrand";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            
            if ($row['total'] == 0): ?>
                <div class="empty-state">
                    <i class="fas fa-tags"></i>
                    <h5>No Brands Found</h5>
                    <p>You haven't added any brands yet. Click the "Add Brand" button to get started.</p>
                </div>
            <?php else: ?>
                <div class="brand-table-container">
                    <table class="brand-table">
                        <thead>
                            <tr>
                                <th>Brand Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM tblbrand ORDER BY brand_id DESC";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                while ($row = mysqli_fetch_array($result)) {
                            ?>
                                    <tr>
                                        <td><?php echo $row['brandname'] ?></td>
                                        <td class="action-btns">
                                            <form method="POST" action="">
                                                <input type="hidden" name="ids" value="<?php echo $row['brand_id']; ?>">
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

<!-- Add Brand Modal -->
<div class="modal fade brand-modal" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBrandModalLabel"><i class="fas fa-plus-circle"></i> Add New Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="brandName" class="form-label">Brand Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            <input type="text" class="form-control" id="brandName" name="brandname" placeholder="Enter brand name" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="btnbrand" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Brand
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
                const brandName = this.closest('tr').querySelector('td:nth-child(1)').textContent;
                
                Swal.fire({
                    title: 'Delete Brand?',
                    html: `Are you sure you want to delete <strong>${brandName}</strong>?`,
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