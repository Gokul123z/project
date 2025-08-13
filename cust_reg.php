<?php
include("connection.php");
if (isset($_POST["btnsubmit"])) {

    $customerName = $_POST['name'];
    $email = $_POST['email'];
    $contactno = $_POST['number'];
    $role = 'customer';
    $password = $_POST['password'];
    $password = $_POST['confirmpassword'];
    $sql = "SELECT * FROM login WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<script>alert("User with this email already exists. Please choose a different email.");</script>';
    } else {
        $sql = "INSERT INTO login(email,password,role) VALUES('$email','$password','$role')";
        if (mysqli_query($conn, $sql)) {
            $loginid = mysqli_insert_id($conn);
            $sql1 = "INSERT INTO customer(name,contact_no,login_id) VALUES('$customerName','$contactno','$loginid')";
            mysqli_query($conn, $sql1);
?>
            <script type="text/javascript" src="swal/jquery.min.js"></script>
            <script type="text/javascript" src="swal/bootstrap.min.js"></script>
            <script type="text/javascript" src="swal/sweetalert2@11.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        text: 'Successfully Registered',
                        didClose: () => {
                            window.location.replace('login.php');
                        }
                    });
                });
            </script>
<?php
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
    
<?php
include('indexheader.php');
?>

<body>
    <!-- Topbar Start -->
    <?php
    include('indexnav.php');
    ?>
    <!-- Navbar End -->

    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Join Our Pet Community</h6>
                <h1 class="display-5 text-uppercase mb-0">Create Your Account</h1>
            </div>
            <div class="row g-5">
                <div class="col-lg-7">
                    <form action="" method="POST">
                        <div class="row g-3">
                            <div class="col-12">
                                <input type="text" class="form-control bg-light border-0 px-4" name="name" id="name" placeholder="Your Name" style="height: 55px;" required>
                            </div>
                            <div class="col-12">
                                <input type="email" class="form-control bg-light border-0 px-4" name="email" id="email" placeholder="Your Email" style="height: 55px;" required>
                            </div>
                            <div class="col-12">
                                <input type="number" class="form-control bg-light border-0 px-4" name="number" id="number" placeholder="Contact Number" style="height: 55px;" required>
                            </div>
                            <div class="col-12">
                                <input type="password" class="form-control bg-light border-0 px-4" name="password" id="password" placeholder="Your Password" style="height: 55px;" required>
                            </div>
                            <div class="col-12">
                                <input type="password" class="form-control bg-light border-0 px-4" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" style="height: 55px;" required>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit" name="btnsubmit">Register Now</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-5">
                    <div class="bg-light mb-5 p-5 h-20 text-center">
                        <img src="https://images.unsplash.com/photo-1601758003122-53c40e686a19?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                            alt="Welcome to our pet family"
                            class="img-fluid rounded shadow-sm mb-3"
                            style="height: 250px; width: 100%; object-fit: cover;">
                        <h4 class="text-primary">Welcome Pet Lovers!</h4>
                        <p class="mb-0">Join our community of pet enthusiasts and get access to premium pet care services, products, and expert advice.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <!-- Footer Start -->
    <?php
    include('indexfooter.php');
    ?>
</body>

</html>