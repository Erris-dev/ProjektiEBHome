<?php 

session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

require 'database.php';

if (!isset($_SESSION["username"])) {
    echo "Session not set!";
} else {
    echo "Session UserId: " . $_SESSION["email"];
}

$db = new Database();
$id = $_GET["productId"];
$result = $db->listProductsDetails($id);

$commentList = $db->listComments($id);

$counter = $db->countReviews($id);

$average = $db->averageReviews($id);



if($result -> num_rows > 0){
    $row = $result->fetch_assoc();
}

if(isset($_SESSION["UserId"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_SESSION["UserId"];


    if(isset($_POST["cart"])) {
        $quantity = $_POST["quantity"];
        $addedOrNot = $db->addToCart($userId,$id,$quantity);
    } else if (isset($_POST["submit-comment"])) {
        $title = $_POST["comment-title"];
        $comment = $_POST["comment"];
        $ratings = $_POST["rating"];
        $commentResult = $db->makeAComment($userId,$title,$comment,$ratings,$id);
        
        if($commentResult === true) {
            header("Location: productDetails.php?productId=$id");
        }
    }

}

$db->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProductDetail</title>
    <link rel="stylesheet" href="css/productDetails.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    .review-container {
    background-color: #ffffff;
    border-top: 3px solid #f4f4f4;
    width:100%;
    padding: 1rem;
}

.make-a-comment {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.user-info {
    background-color: #f9f7f7;
    border-radius: 0 20px 20px;
    flex: 1; 
    padding: 1rem;
}

.name {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.user-info label {
    font-weight: 600;
}

.reviews {
    padding: 1rem 2rem;
    color: #4CAF50;
    text-align: center;
}

.comment {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.user-info .commenti {
    height: 30px;
    padding: 10px;
    width: 100%;
    border-style: none;
}

.user-info #submit-button {
    height: 30px;
    width: 100px;
    padding: 5px;
    border-style: none;
    border-radius: 5px;
    background-color: #45a049;
    color: #fff;
}

.comments {
    display: flex;
    align-items: center;
    padding: 2rem;
    gap: 1rem;
    flex-wrap: wrap; 
    justify-content: center;
}

.comments h3 {
    color: #4CAF50;
}

.image-box {
    display: flex;
    align-items: center;
    height: 50px;
    width: 50px;
    flex-shrink: 0; 
}

.image-box img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    border-radius: 50%; 
}

.comment1 h4 {
    color: #4CAF50;
}

.star-rating {
    direction: rtl;
    display: inline-flex;
}

.star-rating input {
    display: none;
}

.star-rating label {
    font-size: 2rem;
    color: lightgray;
    cursor: pointer;
}

.star-rating input:checked ~ label {
    color: gold;
}

.stars label {
    font-size: 2rem;
    color: gold;
}

.star-rating label:hover,
.star-rating label:hover ~ label {
    color: gold;
}

.comment-card {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    flex-wrap: wrap; 
}


@media screen and (max-width: 768px) {
    .product-page{
        padding: 1rem;
    }
    .product-container {
        flex-direction: column;
    }

    .right-side {
        margin-top: 2rem;
    }

    .make-a-comment {
        flex-direction: column; 
    }

    .comments {
        flex-direction: column; 
    }

    .comment-card {
        flex-direction: column; 
    }

    .user-info #submit-button {
        width: 100%; 
    }
}
@media (max-width: 480px) {
    .reviews h2 {
        font-size: 1.5rem; 
    }

    .comments {
        padding: 1rem;
    }

    .user-info {
        padding: 0.5rem;
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
            <a href="aboutUs.html">About us</a>
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
        <main class="product-page">
            <div class="product-container">
                <div class="left-side2">
                    <div class="img-container1">
                    <?php echo '<img src="'.$row["productImage"].'" alt="foto1">'; ?>
                    </div>
                    
                </div>
                <div class="right-side">
                    <h1><?php echo $row["productName"]; ?></h1>
                    <p class="rating"><?php echo $average; ?> <span>/ 5</span></p>

                    <p class="price"><strong>Price:</strong> <a><?php echo $row["productPrice"]; ?></a></p>

                    <h2>About this product:</h2>
                    <p class="description">
                    <?php echo $row["productDescription"]; ?>
                    </p>
                    <h3>Payment Method: </h3>
                    <div class="payment-cards">
                        <img src="img/Raiffaisen.png" alt="1">
                        <img src="img/paypal1.png" alt="2">
                        <img src="img/paysera.png" alt="3">
                        <img src="img/bkt.png" alt="4">
                    </div>
                    <div class="line">

                    </div>       
                    <div class="payment-section">
                        <label for="quantity">Choose quantity:</label>
                        <div class="box"> 
                            <form method="POST" action="productDetails.php?productId= <?php echo $_GET["productId"]?>">
                                <input type="number" id="quantity" name="quantity" min="1" value="1" required>
                        </div>
                    </div>

                    <div class="buttons">
                        <button class="purchase-btn" name="purchase">Purchase Item</button>
                        <button type="submit" class="wishlist-btn" name="cart">Add to cart</button>
                    </div>
                  </form>
                </div>
                <div class="review-container">
                    <div class="reviews">
                        <h2>Reviews</h2>
                    </div>
                    <div class="make-a-comment">
                        <div class="image-box">
                            <img src="img/slenderman.jpg" alt="1">
                        </div>
                        <form method="POST" action="productDetails.php?productId= <?php echo $_GET["productId"]?>">
                            <div class="user-info">
                                <div class="name">
                                    <label for="name"><?php echo $_SESSION["username"]  ?></label>
                                    <div class="star-rating">
                                        <input type="radio" id="star5" name="rating" value="5">
                                        <label for="star5">★</label>
                                        <input type="radio" id="star4" name="rating" value="4">
                                        <label for="star4">★</label>
                                        <input type="radio" id="star3" name="rating" value="3">
                                        <label for="star3">★</label>
                                        <input type="radio" id="star2" name="rating" value="2">
                                        <label for="star2">★</label>
                                        <input type="radio" id="star1" name="rating" value="1">
                                        <label for="star1">★</label>
                                    </div>
                                </div>
                                <div class="comment">
                                    <input type="text" name="comment-title" class="commenti" placeholder="Enter title...">
                                    <input type="text" name="comment" class="commenti" placeholder="Enter your comment...">
                                    <input type="submit" name="submit-comment" id="submit-button" value="Comment">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="comments">
                        <h3>Comments</h3>
                        <p><?php echo $counter; ?> reviews</p>
                    </div>
                    <div class="list-comments">
                        <?php 
                        if($commentList->num_rows > 0) {
                            while ($commentRow = $commentList->fetch_assoc()) {
                                echo '<div class="comment-card">';
                                echo '    <div class="image-box">';
                                echo '       <img src="img/slenderman.jpg" alt="1">';
                                echo '   </div>';
                                echo '   <div class="user-info">';
                                echo '       <div class="name">';
                                echo '           <label for="name">'.$commentRow["FullName"].'</label>';
                                echo '              <div class="stars">';
                                for ($i = 0; $i < $commentRow["rating"]; $i++) {    
                                    echo '    <label for="star'. ($i + 1) .'">★</label>';
                                }
                                echo '              </div>';
                                echo '       </div>';
                                echo '       <div class="comment1">';
                                echo '          <h4>'.$commentRow["title"].'</h4>';
                                echo '           <p>'.$commentRow["comment"].'</p>';
                                echo '       </div>';
                                echo '   </div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>No comments available.</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </main>
    <script src="js/siderbar.js"></script>
    <script src="js/profilemenu.js"></script>
</body>
</html>