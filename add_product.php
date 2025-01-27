<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

require 'database.php';

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = new Database();

    $productName = $_POST["productName"];
    $productDescription = $_POST["productDescription"];
    $productPrice = $_POST["productPrice"];
    $productImage = $_POST["productImage"];


    $db->insertProduct($productName, $productDescription, $productPrice, $productImage);
    $db->closeConnection();
}

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
<style>
    main {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    form {
        display: flex;
        flex-direction: column;
        width: 50%;
        padding: 40px;
        box-shadow: 2px 4px 13px rgba(0, 0, 0, 0.3);
        background-color: rgb(255, 255, 255);
    }

    form label {
        color: rgb(20, 117, 20);
        font-size: 20px;
        font-weight: 500;
    }
    form input {
        height: 40px;
        padding: 10px;
        margin-bottom: 14px;
    }

    form .add-product {
        color: rgb(20, 117, 20);
        display: flex;
        justify-content: center;
        font-size: 20px;
    }

    form .add-product-btn {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    form #submit {
        background-color: rgb(20, 117, 20);
        border-style: none;
        height: 40px;
        width: 130px;
        color: #Fff;
        border-radius: 4px;
        cursor: pointer;
    }
    form textarea {
        border-style: none;
        text-decoration: none;
        height: 150px;
        padding: 10px;
        background-color: rgb(242, 243, 243);
    }

    input[type="submit"] {
        background-color: rgb(20, 117, 20);
        border-style: none;
        color: #fff;
        cursor: pointer;
        width: 100px;

    }

    @media screen and (max-width: 765px) {
    form {
        width: 90%;
        padding: 30px; 
    }

    form label {
        font-size: 18px; 
    }

    form input, form textarea {
        font-size: 16px;
    }

    .add-product h3 {
        font-size: 24px;
    }

    form #submit {
        width: 100%;
        font-size: 18px;
    }
}
    
    </style>
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
            <a href="dashboard.php"><i class="fa-solid fa-house"></i><span>Dashboard</span></a>
            <a href="add_product.php"><i class="fa-solid fa-plus"></i><span>Add Products</span></a>
            <a href="list_products.php"><i class="fa-solid fa-list"></i><span>List Products</span></a>
            <a href="view_users.php"><i class="fa-solid fa-users"></i><span>List Users</span></a>
            <a href=""><i class="fa-solid fa-crown"></i><span>Privileges</span></a>
            <a href="homepage.php"><i class="fa-solid fa-arrow-right"></i><span>Homepage</span></a>
        </nav>
    </aside>
    <main>
        <form action="add_product.php" method="post">
            <div class="add-product">
                <h3>Add a product</h3>
            </div>
            <label for="productName">Product Name: </label>
            <input type="text" name="productName" id="productName" placeholder="Enter here..." required>
            
            <label for="productDescs">Product Description: </label>
            <textarea name="productDescription" id="productDescs" placeholder="Enter here..." required></textarea>
            
            <label for="productPrice">Product Price</label>
            <input type="text" name="productPrice" id="productPrice" placeholder="Enter here..." required>
            
            <label for="productImage">Product Image Filename</label>
            <input type="text" name="productImage" id="productImage" placeholder="Enter image filename (e.g., img.jpg)" required>
            
            <div class="add-product-btn">
                <button type="submit" id="submit">Add Product</button>
            </div>
       </form>
    </main>
</body>
</html>
