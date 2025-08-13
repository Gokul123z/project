 
<?php
session_start();
include('connection.php');
include('indexheader.php');


$customer_id = $_SESSION['customer_id'] ?? 1;  
 
$query = "SELECT 
            c.cart_id,
            c.quantity,
            p.productid,
            p.productname,
            p.image,
            ps.size,
            ps.price,
            b.brandname
          FROM tblcart c
          JOIN tblproduct p ON c.productid = p.productid
          JOIN tblproductsize ps ON c.productsizeid = ps.productsizeid
          JOIN tblbrand b ON p.brand_id = b.brand_id
          WHERE c.customer_id = $customer_id";


?>

