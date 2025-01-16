<?php
    session_start();
    require 'database.php';
    $db = new Database();

    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
        exit();
    }

    $searchQuery = isset($_POST["search"]) ? $_POST["search"] : '';

    if(!empty($searchQuery)){
        $result = $db->searchProduct($searchQuery);
        $result1 = $db->searchProduct($searchQuery);
    } else {
        $result = $db->listProducts();
        $result1 = $db->newReleased();
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/homepageStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/glider.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <title>EB Home</title>
</head>

<style>
    .welcome-user{
        display: flex;
        justify-content: center;
        margin: 0;
        padding: 10px;
    }
    .welcome-user a{
        color: green;
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
            <a class="remove" href="wishlist.php"><i class="fa-regular fa-heart"></i></a>
            <div class="profile-container">
                    
                <div class="profile-image" id="profile-image">
                    <img src="img/profile.jpg" alt="Profile">
                </div>
                <div class="dropdown-menu" id="dropdown-menu">
                    <div class="user-name">
                        <img src="img/profile.jpg" id="profile-image1" alt="1">
                        <h3><?php echo $_SESSION["username"];?></h3>
                    </div>
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
            <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <a class="remove" href="wishlist.php"><i class="fa-regular fa-heart"></i></a>
        </div>
        <div class="logout">
            <?php if($_SESSION["role"] === "admin"){
                echo "<a href=\"admin_dashboard.php\">Admin Dashboard</a>";
            } ?>
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a>
            <a href="editProfile.php"><i class="fa-regular fa-user"> </i> Edit Profile</a>
        </div>
    </div>
    <div class="welcome-user">
        <h4>Miresevini, <a><?php echo $_SESSION["username"]; ?></a></h4>
    </div>
    <div class="searchbar-container">
        <div class="box">
            <a><i class="fa-solid fa-magnifying-glass"></i><a></a>
            <input id="searchbar" type="search" placeholder="Search here...">
        </div>
    </div>
    <section class="hero-section">
        <div class="left-side">
            <h1>Elevate Your Home with EB Home</h1>
            <p>Style. Comfort. Quality. <br>Discover furniture that complements your lifestyle,
                designed to make every space feel like home.</p>
            <button id="hero-button">Shop Now</button>
        </div>
        <div class="right-side">
            <div class="grid-container">
            <div class="item1"><img src="img/wardrobe.avif" alt=""></div>
            <div class="item2"><img src="img/modern-waterfall-desk-48-1-o.jpg" alt=""></div>
            <div class="item3"><img src="img/shelf.jpg" alt=""></div>
            <div class="item4"><img src="img/shelf2.png" alt=""></div>
            </div>

        </div>
    </section>
    <div class="seperator">
        <div class="market">
            <div class="line-container">
                <h1>Marketplace</h1>
                <div class="line"></div>
            </div>
            <p>Find all the product you need here</p>
        </div>
        <div class="more-link">
        <h3>For More</h3>
        <a><i class="fa-solid fa-arrow-turn-up"></i></a>
        </div>
    </div>
        <section class="product-section">
            <section class="product-container">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="product-card">';
                        echo '  <div class="product-image">';
                        echo '      <span class="discount-tag">50% off</span>';
                        echo '      <img src="'.$row["productImage"].'" alt="'.$row["productName"].'" class="product-thumb">';
                        echo '      <form method="POST" action="">';
                        echo '          <input type="hidden" name="productId" value="'.$row["productId"].'">';
                        echo '          <button type="submit" name="cart" class="card-btn">Add to Wishlist</button>';
                        echo '      </form>';
                        echo '  </div>';
                        echo '  <div class="product-info">';
                        echo '      <a href="productDetails.php?productId='.$row["productId"].'"><h2 class="product-brand">'.$row["productName"].'</h2></a>';
                        echo '      <p class="product-short-description">For comfortable play</p>';
                        echo '      <span class="price">'.$row["productPrice"].'$</span>';
                        echo '  </div>';
                        echo '</div>';
                        
                    }
                } else {
                    echo '<a class="productMissing">There are no products available</a>';
                }

                if(isset($_SESSION["UserId"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
                    $userId = $_SESSION["UserId"];
                
                
                    if(isset($_POST["cart"])) {
                        $id = $_POST["productId"];
                        $quantity = 1;
                        $addedOrNot = $db->addToCart($userId,$id,$quantity);
                        header("Location: ".$_SERVER['PHP_SELF']);
                    }
                }
                ?>
            </section>
        </section>
        <div class="marketplace-buttons">
           <button id="prev-btn-1"><i class="fa-solid fa-chevron-left"></i></button>
           <button id="next-btn-1"><i class="fa-solid fa-chevron-right"></i></button>
        </div>

<div class="seperator">
    <div class="market">
        <div class="line-container">
            <h1>New Releases</h1>
            <div class="line"></div>
        </div>
        <p>Find newly released products</p>
    </div>
</div>

<section class="product-section">
    <section class="product-container1">
        <?php
        if ($result1->num_rows > 0) {
            while ($row = $result1->fetch_assoc()) {
                echo '<div class="product-card">';
                echo '  <div class="product-image">';
                echo '      <span class="discount-tag">New</span>';
                echo '      <img src="'.$row["productImage"].'" alt="'.$row["productName"].'" class="product-thumb">';
                echo '      <button class="card-btn">Add to Wishlist</button>';
                echo '  </div>';
                echo '  <div class="product-info">';
                echo '      <a href="productDetails.php?productId='.$row["productId"].'"><h2 class="product-brand">'.$row["productName"].'</h2></a>';
                echo '      <p class="product-short-description">'.$row["productDescription"].'</p>';
                echo '      <span class="price">'.$row["productPrice"].'$</span>';
                echo '  </div>';
                echo '</div>';
            }
        } else {
            echo '<a class="productMissing">No new releases available</a>';
        }
        ?>
    </section>
</section>
    <div class="marketplace-buttons">
           <button id="prev-btn-2"><i class="fa-solid fa-chevron-left"></i></button>
           <button id="next-btn-2"><i class="fa-solid fa-chevron-right"></i></button>
        </div>

    <section class="sell-product">
        <div class="left-side1">
            <div class="img-container">
                <img src="img/discount-img.avif" alt="discount section img">
            </div>
        </div>
        <div class="right-side1">
            <h1>Give & Save With EB Home</h1>
            <p>Donate your gently used furniture to us and enjoy <br> exclusive discounts on all our products! Refresh your <br> home while making a sustainable choice—save big <br> and make a difference today.</p>
            <button>Get Your Discount</button>
        </div>
    </section>
    <div class="seperator">
        <div class="market">
            <div class="line-container">
                <h1>Offers</h1>
                <div class="line"></div>
            </div>
            <p>Don't miss out on best offers</p>
        </div>
    </div>

    <section id="offers-sec" class="offers-section">
        <div class="offer-card">
            <div class="product-image">
                <img src="img/shelf.jpg" alt="" class="product-thumb">
            </div>
            <div class="offer-info">
                <h2 class="offer-title">Limited-Time Offer: Shelf on Discount

                </h2>
                <p class="offer-description"></p>Upgrade your home or office with our premium shelf, 
                now available at a special discounted price. Built with high-quality materials for long-lasting
                 use, its modern, sleek design complements any interior. This versatile shelf is perfect for organizing books, decor, and essentials.</p>
                
                 <button><i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>
        <div class="offer-card">
            <div class="product-image">
                <img src="products/TableOffer1.jpg" alt="" class="product-thumb">
            </div>
            <div class="offer-info">
                <h2 class="offer-title">Special Offer: Tables on Discount

                </h2>
                <p class="offer-description"></p>Refresh your space with our stylish and durable tables, now available at a special discounted price. Designed for functionality and modern appeal, these tables are perfect for dining, working, or enhancing your home décor.

            </p>
            <button><i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>
        <div class="offer-card">
            <div class="product-image">
                <img src="products/ChairOffer1.jpg" alt="" class="product-thumb">
            </div>
            <div class="offer-info">
                <h2 class="offer-title">Limited-Time Offer: Chairs on Discount

                </h2>
                <p class="offer-description"></p>Upgrade your home or office with our comfortable and stylish chairs, now available at a special discounted price. Designed for both comfort and durability, they are perfect for dining, working, or adding a touch of elegance to any room.

            </p>
            <button><i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>
        <div class="offer-card">
            <div class="product-image">
                <img src="products/BedFrameOffer1.jpg" alt="" class="product-thumb">
            </div>
            <div class="offer-info">
                <h2 class="offer-title">Special Offer: Bed Frames on Discount

                </h2>
                <p class="offer-description"></p>Transform your bedroom with our premium bed frames, now available at a special discounted price. Designed for comfort, durability, and style, they provide the perfect foundation for a good night’s sleep while enhancing your bedroom décor.

            </p>
            <button><i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>
        
        
    </section>
    



    <section class="services">
        <div class="item">
            <i class="fa-solid fa-truck"></i>
            <h3>Delivery</h3>
            <p>Enjoy free delivery on all orders!
                 We’ll bring your items right to 
                 your door, with no extra charge</p>
        </div>
        <div class="item">
            <i class="fa-regular fa-credit-card"></i>
            <h3>Easy-Payment</h3>
            <p>Enjoy easy payments with flexible options! 
                Shop stress-free and pay securely your way.</p>
        </div>
        <div class="item">
            <i class="fa-solid fa-wrench"></i>
            <h3>Free Installation</h3>
            <p>Get free installation with your purchase!
                 Our team will set up your items quickly
                  and professionally, at no extra cost</p>
        </div>
        <div class="item">
            <i class="fa-solid fa-people-carry-box"></i>
            <h3>1-Year Guarantee</h3>
            <p>Enjoy peace of mind with our 1-year guarantee,
                 covering any defects or issues within the first
                  year</p>
        </div>
    </section>
    <div class="slideshowsec">
        <div class="slideshow-container">
            <img name="mySlider" id="slideshow">
            <button onclick="ndrroImg()">Next</button>
        </div>
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
                   <a href="">About Us</a>
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

    <script src="js/slider.js"></script>
    <script src="js/slideshow.js"></script>

</body>
</html>
<?php     $db->closeConnection(); ?>