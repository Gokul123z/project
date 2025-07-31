<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop Pro - Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #8B5CF6;
            --primary-light: #C4B5FD;
            --secondary: #EC4899;
            --accent: #F59E0B;
            --dark: #111827;
            --darker: #0F172A;
            --light: #F3F4F6;
            --card-bg: #1E293B;
            --sidebar-width: 280px;
        }

        body {
            background-color: var(--darker);
            color: var(--light);
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        .sidebar {
            background-color: var(--dark);
            height: 100vh;
            position: fixed;
            width: var(--sidebar-width);
            padding: 20px 0;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sidebar-brand {
            color: var(--light);
            font-size: 1.4rem;
            font-weight: 600;
            padding: 15px 25px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand i {
            color: var(--primary);
            margin-right: 12px;
            font-size: 1.6rem;
        }

        .nav-link {
            color: var(--light);
            margin: 8px 15px;
            border-radius: 50px;
            padding: 12px 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
            opacity: 0.9;
            font-weight: 500;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, var(--primary), var(--secondary));
            transform: scaleY(0);
            transition: transform 0.3s ease;
            border-radius: 0 4px 4px 0;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(139, 92, 246, 0.1);
            color: var(--primary-light);
            transform: translateX(8px);
            opacity: 1;
        }

        .nav-link.active::before {
            transform: scaleY(1);
        }

        .nav-link i {
            margin-right: 12px;
            width: 24px;
            text-align: center;
            font-size: 1.1rem;
            transition: all 0.3s;
        }

        .nav-link:hover i,
        .nav-link.active i {
            color: var(--primary-light);
            transform: scale(1.1);
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 25px;
            transition: all 0.3s;
        }

        .card {
            background-color: var(--card-bg);
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            margin-bottom: 25px;
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
        }

        .card-header {
            background: linear-gradient(to right, rgba(30, 41, 59, 0.8), rgba(30, 41, 59, 0.95));
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-weight: 600;
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-card {
            text-align: center;
            padding: 25px 15px;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .stat-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            transition: transform 0.3s;
        }

        .stat-card:hover i {
            transform: scale(1.1);
        }

        .stat-card h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
            background: linear-gradient(to right, var(--light), var(--primary-light));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .stat-card p {
            opacity: 0.8;
            font-size: 0.9rem;
            color: var(--primary-light);
        }

        .table {
            color: var(--light);
            margin-bottom: 0;
        }

        .table th {
            border-color: rgba(255, 255, 255, 0.1);
            font-weight: 500;
            background-color: rgba(0, 0, 0, 0.2);
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: var(--primary-light);
        }

        .table td {
            border-color: rgba(255, 255, 255, 0.05);
            vertical-align: middle;
        }

        .badge {
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 6px;
        }

        .btn-primary {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border: none;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.4);
        }

        .btn-outline-primary {
            color: var(--primary-light);
            border-color: var(--primary);
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-outline-primary:hover {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
        }

        .top-bar {
            background-color: var(--card-bg);
            padding: 15px 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .search-box {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 50px;
            padding: 10px 20px;
            width: 300px;
            transition: all 0.3s;
        }

        .search-box:focus {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(139, 92, 246, 0.25);
        }

        .user-profile {
            display: flex;
            align-items: center;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 12px;
            object-fit: cover;
            border: 2px solid var(--primary);
            transition: all 0.3s;
        }

        .user-profile:hover img {
            transform: scale(1.1);
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.3);
        }

        .notification-bell {
            position: relative;
            margin-right: 20px;
            font-size: 1.2rem;
            color: var(--light);
            transition: all 0.3s;
        }

        .notification-bell:hover {
            color: var(--primary-light);
            transform: scale(1.1);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--secondary);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(236, 72, 153, 0.3);
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .top-bar {
                padding: 12px 15px;
            }

            .search-box {
                width: 200px;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(var(--primary), var(--secondary));
            border-radius: 4px;
        }

        /* Animation for sidebar items */
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 0.9;
                transform: translateX(0);
            }
        }

        .nav-item {
            animation: fadeInLeft 0.5s ease forwards;
            opacity: 0;
        }

        .nav-item:nth-child(1) {
            animation-delay: 0.1s;
        }

        .nav-item:nth-child(2) {
            animation-delay: 0.15s;
        }

        .nav-item:nth-child(3) {
            animation-delay: 0.2s;
        }

        .nav-item:nth-child(4) {
            animation-delay: 0.25s;
        }

        .nav-item:nth-child(5) {
            animation-delay: 0.3s;
        }

        .nav-item:nth-child(6) {
            animation-delay: 0.35s;
        }

        .nav-item:nth-child(7) {
            animation-delay: 0.4s;
        }

        .nav-item:nth-child(8) {
            animation-delay: 0.45s;
        }

        .nav-item:nth-child(9) {
            animation-delay: 0.5s;
        }

        .nav-item:nth-child(10) {
            animation-delay: 0.55s;
        }

        .nav-item:nth-child(11) {
            animation-delay: 0.6s;
        }

        .nav-item:nth-child(12) {
            animation-delay: 0.65s;
        }

        .nav-item:nth-child(13) {
            animation-delay: 0.7s;
        }

        .nav-item:nth-child(14) {
            animation-delay: 0.75s;
        }

        .nav-item:nth-child(15) {
            animation-delay: 0.8s;
        }

        .nav-item:nth-child(16) {
            animation-delay: 0.85s;
        }

        /* Pulse animation for notifications */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .notification-badge {
            animation: pulse 2s infinite;
        }

        /* Hover effect for table rows */
        .table-hover tbody tr {
            transition: all 0.2s;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(139, 92, 246, 0.1);
            transform: translateX(5px);
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <i class="fas fa-paw"></i>
                <span>PetShop Pro</span>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="adminhome.php?page=category">
                        <i class="fas fa-list"></i> Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="adminhome.php?page=subcategory">
                        <i class="fas fa-layer-group"></i> Sub-Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="adminhome.php?page=brand">
                        <i class="fas fa-tags"></i> Brands
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="adminhome.php?page=pet">
                        <i class="fas fa-utensils"></i> Pets
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="adminhome.php?page=product">
                        <i class="fas fa-boxes"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="adminhome.php?page=stock">
                        <i class="fas fa-warehouse"></i> Stock Management
                    </a>






                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-tshirt"></i> Accessories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-cut"></i> Grooming Tools
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-gamepad"></i> Toys
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-dog"></i> Collars & Leashes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-images"></i> Product Gallery
                    </a>
                </li>
                
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-shopping-cart"></i> Order Management
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-star"></i> Reviews
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-users"></i> Customers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-chart-pie"></i> Reports
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link" href="#">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->

        <!-- Main Content Row -->



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




        <!-- Second Row -->


    </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Auto-close sidebar on mobile when clicking a link
        if (window.innerWidth < 992) {
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    document.getElementById('sidebar').classList.remove('active');
                });
            });
        }

        // Add animation to stats cards
        document.querySelectorAll('.stat-card').forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });

        // Active link highlighting
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>

</html>