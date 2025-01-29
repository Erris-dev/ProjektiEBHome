<?php
session_start();

require 'database.php';

$db = new Database();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if(isset($_SESSION["UserId"])) {

    $userId = $_SESSION["UserId"];

    $result = $db->listCartItems($userId);
}

if($_SERVER["REQUEST_METHOD"] === 'POST'){
    $productId = $_POST["productId"];
    $delete = $db->removeFromCart($productId);
    header("Location: ".$_SERVER["PHP_SELF"]);
}

$db->closeConnection();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - EB Home</title>
    <link rel="stylesheet" href="css/aboutUs.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
table {
    border-collapse: collapse;
    width: 100%; 
    max-width: 100%; 
    margin: 3rem auto;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

table th, table td {
    font-size: 0.9em;
    word-wrap: break-word;
}

.table-wrapper {
    overflow-x: auto; 
    margin: 3rem auto; 
    max-width: 100%;
}
        
.productImg {
    height: auto; 
    width: 100%; 
    max-width: 90px; 
}
#img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
        
        .td1 {
            display: flex;
            justify-content: center;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px 1px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        td {
            color: #333;
        } 
        
        .remove {
            padding: 10px 20px;
            background-color: rgb(249, 56, 56);
            color: #fff;
            font-size: 18px;
            width: 100px;
            height: 100px;
            border-style:none;
            cursor: pointer;
            text-decoration: none;
        }

        .add {
            padding: 10px 20px;
            background-color: rgb(22, 180, 69);
            color: #fff;
            font-size: 18px;
            text-decoration: none;
        }
        
        @media (max-width: 768px) {
    table th, table td {
        padding: 8px 5px;
        font-size: 0.8em; 
    }
    
}
</style>
<body>
    <header>
        <div id="logo">
            <img src="img/LogoEB.png" alt="logo">
        </div>
        <button id="menu-btn">&#9776;</button>
        <div class="navigation">
            <a href="homepage.php" id="home">Home</a>
            <a href="marketplace.php">Marketplace</a>
            <a href="aboutUs.php">About us</a>
            <button id="head-button">Sell Product</button>
        </div>
        <div class="user">
            <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <a class="remo" href="wishlist.php"><i class="fa-regular fa-heart"></i></a>
            <div class="profile-container">
                    
                <div class="profile-image" id="profile-image">
                    <img src="img/profile.jpg" alt="Profile">
                </div>
                <div class="dropdown-menu" id="dropdown-menu">
                    <div class="user-name">
                        <img src="img/profile.jpg" id="profile-image1" alt="1">
                        <h3><?php echo $_SESSION["username"];?></h3>
                    </div>
                    <?php if($_SESSION["role"] === "admin"){
                        echo '<a href="dashboard.php"><i class="fa-solid fa-house"></i>Dashboard</a>';
                    } ?>
                    <a href="editProfile.php"><i class="fa-regular fa-user"> </i> Edit Profile</a>
                    <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a>
                </div>
            </div>

        </div>
        
    </header>

    <div class="sidebar">
        <button class="close-btn">&times;</button>
        <a href="homepage.php">Home</a>
        <a href="marketplace.php">Marketplace</a>
        <a href="aboutUs.php">About us</a>
        <button id="head-button">Sell Product</button>
        <div class="user">
            <a href="login.php"><i class="fa-regular fa-user"></i></a>
            <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <a class="remove" href="wishlist.php"><i class="fa-regular fa-heart"></i></a>
        </div>
    </div>
    <div class="table-wrapper">
        <table border="1">
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            
            <?php 

            if($result -> num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo ' <td class="td1"><div class="productImg"><img id="img" src="'.$row["productImage"].'" alt="1"></div></td>';
                    echo    '<td>'.$row["productName"].'</td>';
                    echo    '<td>'.$row["productPrice"].'</td>';
                    echo   '<td>'.$row["Quantity"].'</td>';
                    echo    '<td>'.$row["Total"].'</td>';
                    echo    '<td><form method="POST">';
                    echo    '    <input type="hidden" name="productId" value="'.$row["productId"].'">';
                    echo    '   <button type="submit" name="removeCart" class="remove"> - </button>';
                    echo    '    </form></td>';
                    echo '</tr>';
                }
            }


            
            ?>
        </table>
    </div>
    

<footer>
    <div class="footer-container">
       <div class="footer-left">
            <div class="logo-footer">
                <img src="img/LogoWhite.png" alt="Logo">
            </div>
            <div class="links">
                <a href="">Email: eb121705@gmai.com</a>
                <a href="">Adress: Lagjia Emshir Pristina</a>
                <a href=""></a>
                <br>
               <a href="aboutUs.php">About Us</a>
               <a href="#">Terms of Service</a>
               <a href="#">Privacy and Policy</a>
               <br>
                <a href="#">Returns & Refunds</a>
                <a href="#">FAQ</a>
            </div>
            <div class="links">
                <i class="fa-brands fa-instagram"></i>
                <i class="fa-brands fa-facebook"></i>
                <i class="fa-brands fa-twitter"></i>
                <i class="fa-brands fa-linkedin"></i>
            </div>
        </div>
        <div class="footer-right">
            <p>Stay Updated with our new offers</p>
            <div class="subscribe-footer">
                <input type="email" name="" id="" placeholder="Type your email...">
                <button>Subscribee</button>
            </div>
            <div class="footer-check">
            <input type="checkbox" > You agree that you are at least 13+ years old
            </div>
        </div>
        <div class="line-footer"></div>
        <p id="footer-copyright">Copyright: © [Year] EB Home. All rights reserved. Unauthorized use or reproduction is prohibited.</p>
</footer>

<script src="js/siderbar.js"></script>
<script src="js/profilemenu.js"></script>
<style>
    
</style>

</body>
</html>
