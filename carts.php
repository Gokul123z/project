<?php
include("connection.php");
session_start();

$customer_id = $_SESSION['customer_id'];  

if (isset($_POST['add_to_cart'])) {
    $productsizeid = $_POST['productsizeid'];
    $quantity = $_POST['quantity'];

    // Optional: prevent SQL injection
    $productsizeid = mysqli_real_escape_string($conn, $productsizeid);
    $quantity = mysqli_real_escape_string($conn, $quantity);

    // 1. Check if this product already exists in the customer's cart
    $check_query = "SELECT * FROM tblcart WHERE customerid = $customer_id AND productsizeid = $productsizeid";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // 2. If it exists, update quantity
        $update_query = "UPDATE tblcart 
                         SET quantity = quantity + $quantity 
                         WHERE customerid = $customer_id AND productsizeid = $productsizeid";
        if (mysqli_query($conn, $update_query)) {
            echo "<script>alert('Cart updated successfully'); window.location.href='cart.php';</script>";
        } else {
            echo "Error updating cart: " . mysqli_error($conn);
        }
    } else {
        // 3. Else, insert new item
        $insert_query = "INSERT INTO tblcart (customerid, productsizeid, quantity) 
                         VALUES ($customer_id, $productsizeid, $quantity)";
        if (mysqli_query($conn, $insert_query)) {
            echo "<script>alert('Item added to cart'); window.location.href='cart.php';</script>";
        } else {
            echo "Error inserting into cart: " . mysqli_error($conn);
        }
    }
}
?>





<?php
include("connection.php");
session_start();

// Replace this with your actual session key if it's different
$customer_id = $_SESSION['customer_id'];  

if (isset($_POST['add_to_cart'])) {
    $productsizeid = $_POST['size_id']; // using size_id from form
    $quantity = $_POST['quantity'];

    // Prevent SQL injection
    $productsizeid = mysqli_real_escape_string($conn, $productsizeid);
    $quantity = mysqli_real_escape_string($conn, $quantity);

    // Check if this product already exists in the customer's cart
    $check_query = "SELECT * FROM tblcart WHERE customerid = $customer_id AND productsizeid = $productsizeid";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // If it exists, update quantity
        $update_query = "UPDATE tblcart 
                         SET quantity = quantity + $quantity 
                         WHERE customerid = $customer_id AND productsizeid = $productsizeid";
        if (mysqli_query($conn, $update_query)) {
            echo "<script>alert('Cart updated successfully'); window.location.href='cart.php';</script>";
        } else {
            echo "Error updating cart: " . mysqli_error($conn);
        }
    } else {
        // Else, insert new item
        $insert_query = "INSERT INTO tblcart (customerid, productsizeid, quantity) 
                         VALUES ($customer_id, $productsizeid, $quantity)";
        if (mysqli_query($conn, $insert_query)) {
            echo "<script>alert('Item added to cart'); window.location.href='cart.php';</script>";
        } else {
            echo "Error inserting into cart: " . mysqli_error($conn);
        }
    }
}
?>






<?php
include('connection.php');
session_start();

$customer_id = $_SESSION['customer_id'] ?? 0;

if (!$customer_id) {
    echo "You must be logged in to view the cart.";
    exit;
}

$query = "SELECT c.*, p.productname, ps.size, ps.price, p.image 
          FROM tblcart c
          JOIN tblproductsize ps ON c.productsizeid = ps.productsizeid
          JOIN tblproduct p ON ps.productid = p.productid
          WHERE c.customer_id = $customer_id";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
</head>
<body>
    <h2>Your Cart</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Size</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        <?php
        $grand_total = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $total = $row['price'] * $row['quantity'];
            $grand_total += $total;
            echo "<tr>
                    <td><img src='{$row['image']}' width='80'></td>
                    <td>{$row['productname']}</td>
                    <td>{$row['size']}</td>
                    <td>₹{$row['price']}</td>
                    <td>{$row['quantity']}</td>
                    <td>₹" . number_format($total, 2) . "</td>
                  </tr>";
        }
        ?>
        <tr>
            <td colspan="5" align="right"><strong>Grand Total:</strong></td>
            <td>₹<?php echo number_format($grand_total, 2); ?></td>
        </tr>
    </table>
</body>
</html>
