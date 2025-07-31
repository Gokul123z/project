<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Global Styles */
        :root {
            --primary: #2D9596;
            --primary-dark: #265073;
            --secondary: #9AD0C2;
            --light: #ECF4D6;
            --danger: #FF6B6B;
            --warning: #FFD93D;
            --info: #4D96FF;
            --dark: #2C3333;
            --gray: #6c757d;
            --light-gray: #f8f9fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: var(--dark);
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Dashboard Layout */
        .dashboard {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Top Navigation */
        .top-nav {
            background-color: white;
            padding: 0.8rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .brand-logo img {
            height: 40px;
        }

        .brand-logo span {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .user-controls {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .notification-bell {
            position: relative;
            cursor: pointer;
            font-size: 1.2rem;
            color: var(--gray);
        }

        .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--danger);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            cursor: pointer;
        }

        .user-profile img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }

        .logout-btn a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--gray);
            transition: color 0.3s;
        }

        .logout-btn a:hover {
            color: var(--primary);
        }

        /* Dashboard Container */
        .dashboard-container {
            display: flex;
            flex: 1;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            padding: 1.5rem 0;
            transition: all 0.3s;
        }

        .nav-menu {
            list-style: none;
        }

        .menu-header {
            padding: 0.8rem 1.5rem;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--gray);
            letter-spacing: 0.5px;
        }

        .nav-menu li a {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem 1.5rem;
            color: var(--dark);
            transition: all 0.3s;
            position: relative;
        }

        .nav-menu li a:hover {
            background-color: var(--light);
            color: var(--primary);
        }

        .nav-menu li a i {
            width: 20px;
            text-align: center;
        }

        .nav-menu li.active a {
            background-color: rgba(45, 149, 150, 0.1);
            color: var(--primary);
            border-left: 3px solid var(--primary);
        }

        .has-submenu>a {
            justify-content: space-between;
        }

        .submenu {
            list-style: none;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .has-submenu.active .submenu {
            max-height: 500px;
        }

        .submenu li a {
            padding-left: 3rem;
            font-size: 0.9rem;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 1.5rem 2rem;
            background-color: #f5f7fa;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.8rem;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
        }

        .breadcrumb {
            font-size: 0.9rem;
            color: var(--gray);
        }

        .breadcrumb a {
            color: var(--primary);
        }

        /* Stats Cards */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .card-body {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .bg-primary {
            background-color: var(--primary);
        }

        .bg-success {
            background-color: #28a745;
        }

        .bg-warning {
            background-color: var(--warning);
        }

        .bg-info {
            background-color: var(--info);
        }

        .stat-info h3 {
            font-size: 1.8rem;
            margin-bottom: 0.3rem;
            color: var(--dark);
        }

        .stat-info p {
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* Charts Section */
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .col-md-8 {
            flex: 0 0 calc(66.666% - 1.5rem);
            max-width: calc(66.666% - 1.5rem);
        }

        .col-md-4 {
            flex: 0 0 calc(33.333% - 1.5rem);
            max-width: calc(33.333% - 1.5rem);
        }

        .chart-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            height: 100%;
        }

        .card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h4 {
            font-size: 1.2rem;
            color: var(--dark);
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead th {
            background-color: var(--light);
            padding: 0.8rem 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.9rem;
        }

        table tbody td {
            padding: 0.8rem 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-size: 0.9rem;
        }

        table tbody tr:hover {
            background-color: rgba(45, 149, 150, 0.05);
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 50px;
        }

        .badge-success {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
        }

        .btn-sm {
            padding: 0.3rem 0.7rem;
            font-size: 0.8rem;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-info {
            background-color: rgba(77, 150, 255, 0.1);
            color: var(--info);
        }

        .btn-info:hover {
            background-color: rgba(77, 150, 255, 0.2);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }

            .brand-logo span,
            .menu-header,
            .nav-menu li a span,
            .has-submenu>a i:last-child {
                display: none;
            }

            .nav-menu li a {
                justify-content: center;
                padding: 0.8rem;
            }

            .submenu li a {
                padding-left: 0.8rem;
            }
        }

        @media (max-width: 768px) {

            .col-md-8,
            .col-md-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .top-nav {
                padding: 0.8rem 1rem;
            }

            .main-content {
                padding: 1rem;
            }
        }
    </style>
</head>

<body class="dashboard">
    <!-- Top Navigation Bar -->
    <nav class="top-nav">
        <div class="brand-logo">
            <img src="https://via.placeholder.com/40" alt="PetShop Admin">
            <span>PetShop Admin</span>
        </div>
        <div class="user-controls">
            <div class="notification-bell">
                <i class="fas fa-bell"></i>
                <span class="badge">5</span>
            </div>
            <div class="user-profile">
                <img src="https://via.placeholder.com/35" alt="Admin">
                <span>Admin</span>
            </div>
            <div class="logout-btn">
                <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="dashboard-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <ul class="nav-menu">
                <li class="menu-header">MAIN</li>
                <li class="active">
                    <a href="#"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
                </li>

                <li class="menu-header">PRODUCT MANAGEMENT</li>
                <li class="has-submenu">
                    <a href="#"><i class="fas fa-paw"></i> <span>Products</span> <i class="fas fa-chevron-down"></i></a>
                    <ul class="submenu">
                        <li><a href="adminhome.php?page=category"><i class="fas fa-list"></i> <span>Categories</span></a></li>
                         <li><a href="adminhome.php?page=subcategory"><i class="fas fa-layer-group"></i> <span>SubCategories</span></a></li>
                        <li><a href="adminhome.php?page=brand"><i class="fas fa-tags"></i> <span>Brands</span></a></li>
                        <li><a href="adminhome.php?page=product"><i class="fas fa-box-open"></i> <span>Products</span></a></li>
                        <li><a href="adminhome.php?page=pet"><i class="fas fa-dog"></i> <span>Pets</span></a></li>
                        <li><a href="#"><i class="fas fa-images"></i> <span>Gallery</span></a></li>
                        <li><a href="#"><i class="fas fa-warehouse"></i> <span>Stock</span></a></li>
                    </ul>
                </li>

                <li class="menu-header">SALES</li>
                <li>
                    <a href="#"><i class="fas fa-shopping-cart"></i> <span>Order Management</span></a>
                </li>

                <li class="menu-header">CUSTOMERS</li>
                <li>
                    <a href="#"><i class="fas fa-users"></i> <span>View Customers</span></a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-star"></i> <span>View Reviews</span></a>
                </li>

                <li class="menu-header">REPORTS</li>
                <li>
                    <a href="#"><i class="fas fa-chart-bar"></i> <span>Sales Reports</span></a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-chart-pie"></i> <span>Inventory Reports</span></a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
           
 <?php
        if (isset($_GET['page'])) {

            $page = $_GET['page'];
            switch ($page) {
                case 'category':
                    include('admin_category.php');
                    break;
                case 'brand':
                    include('admin_brand.php');
                    break;
                case 'pet':
                    include('admin_pet.php');
                    break;
                case 'subcategory':
                    include('admin_subcategory.php');
                    break;
                case 'product':
                    include('admin_product.php');
                    break;
                    case 'stock':
                    include('admin_stock.php');
                    break;









                default:
                    include('admin_dashboard.php');
                    break;
            }
        } else {
            include('admin_dashboard.php');
        }
        ?>






        </main>
    </div>

    <script>
        // Simple script to handle submenu toggle
        document.querySelectorAll('.has-submenu > a').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const submenu = this.nextElementSibling;
                const parent = this.parentElement;

                if (submenu.style.maxHeight) {
                    submenu.style.maxHeight = null;
                    parent.classList.remove('active');
                } else {
                    submenu.style.maxHeight = submenu.scrollHeight + 'px';
                    parent.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>