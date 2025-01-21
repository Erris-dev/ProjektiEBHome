<?php
    session_start();

    require 'database.php';

    if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
        header("Location: login.php");
        exit();
    }

    $db = new Database();

    $numberOfUsers = $db->getNumberOfUsers();



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <aside class="sidebar">
        <div class="admin-container">
            <img src="img/profile.jpg" id="profile-image1" alt="1">
            <div class="admin-account">
                <h3><?php echo $_SESSION["username"]; ?></h3>
                <p>Admin</p>
            </div>
        </div>
        <nav>
            <a href="dashboard.php"><i class="fa-solid fa-house"></i>Dashboard</a>
            <a href="add_product.php"><i class="fa-solid fa-plus"></i>Add products</a>
            <a href="list_products.php"><i class="fa-solid fa-list"></i>List Products</a>
            <a href="view_users.php"><i class="fa-solid fa-list"></i>List Users</a>
            <a href=""><i class="fa-solid fa-crown"></i>Priviledges</a>
            <a href="homepage.php"><i class="fa-solid fa-arrow-right"></i>Homepage</a>
        </nav>
    </aside>
    <main>
        <div class="logo">
            <h2>New Statistics</h2>
            <img src="img/LogoEB.png" alt="logo">
        </div>
        <div class="main-keys">
            <div>
                <h3>Total Orders</h3>
                
            </div>
            <div>
                <h3>Total Users</h3>
                <p class="keyNumber"><?php echo $numberOfUsers; ?> <i> new users</i></p>
            </div>
            <div>
                <h3>Total Profit</h3>
                
            </div>
        </div>
        <div class="other-info">
            <div class="top-sales">
                <h2>Most Sold Products</h2>
                <div class="productList">

                </div>
            </div>
            <div class="traffic">
                <h2>Traffic</h2>
                <div class="trafficKey">
                    <h3>Total Visits</h3>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
