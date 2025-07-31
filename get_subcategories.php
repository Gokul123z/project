<?php
include('connection.php');

if(isset($_POST['category_id'])) {
    $categoryId = $_POST['category_id'];
    $sql = "SELECT * FROM tblsubcategory WHERE category_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $categoryId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $options = '';
    while($row = mysqli_fetch_assoc($result)) {
        $options .= '<option value="'.$row['subcategoryid'].'">'.$row['subcategoryname'].'</option>';
    }
    
    echo $options;
}
?>