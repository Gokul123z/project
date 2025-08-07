<!DOCTYPE html>
<html lang="en">

<?php
include('indexheader.php');
?>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid border-bottom d-none d-lg-block">
        <div class="row gx-0">
            <div class="col-lg-4 text-center py-2">
                <div class="d-inline-flex align-items-center">
                    <i class="bi bi-geo-alt fs-1 text-primary me-3"></i>
                    <div class="text-start">
                        <h6 class="text-uppercase mb-1">Our Office</h6>
                        <span>123 Street, New York, USA</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center border-start border-end py-2">
                <div class="d-inline-flex align-items-center">
                    <i class="bi bi-envelope-open fs-1 text-primary me-3"></i>
                    <div class="text-start">
                        <h6 class="text-uppercase mb-1">Email Us</h6>
                        <span>info@example.com</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center py-2">
                <div class="d-inline-flex align-items-center">
                    <i class="bi bi-phone-vibrate fs-1 text-primary me-3"></i>
                    <div class="text-start">
                        <h6 class="text-uppercase mb-1">Call Us</h6>
                        <span>+012 345 6789</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <?php
    include('usernav.php');
    ?>
    <!-- Navbar End -->
    
    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Products</h6>
                <h1 class="display-5 text-uppercase mb-0">Products For Your Pet</h1>
            </div>
            <div class="row g-5">
                <?php
                include('connection.php');
                $sql = "SELECT pr.*, br.brandname, ca.categoryname, pt.petname, sc.subcategoryname
                        FROM tblproduct pr 
                        JOIN tblbrand br ON pr.brand_id=br.brand_id
                        JOIN tblcategory ca ON pr.category_id = ca.category_id
                        JOIN tblpet pt ON pr.pet_id=pt.pet_id
                        JOIN tblsubcategory sc ON pr.subcategoryid= sc.subcategoryid
                        ";

                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="product-item bg-light rounded">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="<?php echo $row['image']; ?>" alt="<?php echo $row['productname']; ?>" style="height: 300px; object-fit: cover;">
                             
                            </div>
                            <div class="text-center p-4">
                                <a class="d-block h5 mb-2" href=""><?php echo $row['productname']; ?></a>
                                <div class="mb-3">
                                    <span class="text-muted">Category: <?php echo $row['categoryname']; ?></span><br>
                                    <span class="text-muted">For: <?php echo $row['petname']; ?></span><br>
                                    <span class="text-muted">Brand: <?php echo $row['brandname']; ?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                   
                                    <button class="btn btn-primary btn-sm" 
                                            onclick="window.location.href='cust_productdetails.php?id=<?php echo $row['productid']; ?>'">
                                        View Options
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
          
        </div>
    </div>
    <!-- Products End -->

    <!-- Footer Start -->
    <?php
    include('indexfooter.php');
    ?>
    <!-- Footer End -->
</body>
</html>