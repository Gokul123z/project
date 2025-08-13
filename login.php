<?php
session_start();
include("connection.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $pwd = trim($_POST["password"]);

    $sql = "SELECT * FROM login WHERE email='$email' AND password='$pwd'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['login_id'] = $row['login_id'];
        $_SESSION['role'] = $row['role'];

        switch ($row['role']) {
            case "admin":
                header("Location: adminhome.php");
                break;
            case "customer":
                $login_id = $row['login_id'];
                $sql = "select * from customer where login_id='$login_id'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                $_SESSION['customer_id'] = $row['customer_id'];
                header("Location: cust_home.php");
                break;

            default:
                $error = "Unknown role.";
        }
        exit;
    } else {
        $error = "Invalid email or password.";
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

    <div class="container-fluid pt-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h1 class="display-5 text-uppercase mb-0">LOGIN</h1>
            </div>
            <div class="row g-5 align-items-center">
                <div class="col-lg-7">
                    <form action="" method="POST">
                        <div class="row g-3">
                            <div class="col-12">
                                <input type="email" class="form-control bg-light border-0 px-4" name="email" id="email" placeholder="Your Email" style="height: 55px;">
                            </div>
                            <div class="col-12">
                                <input type="password" class="form-control bg-light border-0 px-4" name="password" id="password" placeholder="Your Password" style="height: 55px;">
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit" name="btnsubmit">Login</button>
                            </div>
                            <div class="col-12 text-center">
                                <a href="#" class="text-primary">Forgot Password?</a>
                            </div>
                        </div>
                    </form>
                </div>




                <div class="col-lg-5">
                    <div class="bg-light p-4 h-100 d-flex flex-column align-items-center justify-content-center">
                        <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                            alt="Cute cat looking at camera"
                            class="img-fluid rounded shadow mb-3"
                            style="max-height: 350px; width: 100%; object-fit: cover;">
                        <p class="text-center text-muted lead mb-0">"Great care begins with you. Sign in and explore the joy of loving a pet!"</p>
                      
                        <p> "Enter your world of pet care, love, and loyalty. We’re happy to have you back!"
                            "Your pet’s happiness begins with your care. Let’s continue the journey!"
                            "Because pets aren’t just animals—they’re family. Welcome back!"
                            "Great care begins with you. Sign in and explore the joy of loving a pet!"
                        </p>

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