<?php

session_start();

require 'database.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new Database();

    $username = $_POST["fullName"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $db->insertNewUsers($username,$email,$password);
    $db->closeConnection();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Signup.css" type="text/css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div id="logo">
            <img src="img/LogoEB.png" alt="logo">
        </div>
        <button id="menu-btn">&#9776;</button>
        <div class="navigation">
            <a href="homepage.php" id="home">Home</a>
            <a href="marketplace.php">Marketplace</a>
            <a href="about.php">About us</a>
            <button id="head-button">Sell Product</button>
        </div>
        <div class="user">
            <a href="login.php"><i class="fa-regular fa-user"></i></a>
            <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <a class="remove" href="wishlist.php"><i class="fa-regular fa-heart"></i></a>
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

<div class="wrapper-container">
    <div class="wrapper">
        <form id="form" method="post" action="Signup.php" onsubmit="return validateForm()">
            <h1>Sign up</h1>
            <div class="input-box1">
                <input id="fullName" name="fullName" type="text" placeholder="Full Name">
                <span class="error" id="name-error"></span>
            </div>
            <div class="input-box">
                <input id="email" name="email" type="email" placeholder="Email" >
                <div class="error" id="email-error"></div>
            </div>
            <div class="input-box">
                <input id="password" name="password" type="password" placeholder="Password" >
                <div class="error" id="password-error"></div>
            </div>
            <div class="input-box">
                <input id="confirmPassword" type="password" placeholder="Confirm password" >
                <div class="error" id="confirm-password-error"></div>
            </div>
            <h2>By signing up, I agree to the Privacy Policy and the Terms of Services </h2>
            <button type="submit" class="btn">Create Account</button>
            <div class="login-link">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
</div>
<script src="js/Signup.js">
    
</script>
    
</body>
</html>
