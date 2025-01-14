<?php
session_start();
require 'database.php';



if(isset($_POST["email"]) && isset($_POST["password"])){
    $db = new Database();

    $email = $_POST["email"];
    $password = $_POST["password"];

    $db->checkUsers($email,$password);
    $db->closeConnection();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css" type="text/css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="js/login.js"></script>
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
            <a href="aboutUs.php">About us</a>
            <button id="head-button">Sell Product</button>
        </div>
        <div class="user">
            <a href="login.php"><i class="fa-regular fa-user"></i></a>
            <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <a class="remove" href="wishlist.php"><i class="fa-regular fa-heart"></i></a>

            <div id="profilepic"><img src="" alt=""></div>
        </div>
    </header>
    <div class="sidebar">
        <button class="close-btn">&times;</button>
        <a href="homepage.php">Home</a>
        <a href="aboutUs.php">Marketplace</a>
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
        <form id="form" method="post" action="login.php" onsubmit="return validateLogin()">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" id="email" name="email" placeholder="Please type your email here...">
                <span class="error" id="email-error"></span>
            </div>
            <div class="input-box">
                   <input type="password" id="password" name="password" placeholder="Please type your password here...">
                   <div class="error" id="password-error">
                </div>
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="signup-link">
                <p>Dont have an account? ? <a href="Signup.php">Sign up</a></p>
            </div>
        </form>
    </div>
    </div>
    <script ></script>
</body>
</html>