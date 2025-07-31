<?php
include('connection.php');

if (isset($_POST['productid'])) {
   
    $productid = $_POST['productid'];

    $delete_sql = "DELETE FROM tblproduct WHERE productid = $productid";
    if (mysqli_query($conn, $delete_sql)) { ?>
         <script type="text/javascript" src="swal/jquery.min.js"></script>
        <script type="text/javascript" src="swal/bootstrap.min.js"></script>
        <script type="text/javascript" src="swal/sweetalert2@11.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    text: 'Product deleted successfully',
                    didClose: () => {
                        window.location.href = 'adminhome.php?page=product';
                    }
                });
            });
        </script>
    <?php
    }
}
?>