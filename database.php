<?php
class Database {
    private $servername = "localhost";
    private $dbUsername = "root";
    private $dbPassword = "";
    private $dbname = "ebhomedb";
    public $conn;

    public function __construct(){
        $this -> connect();
    }

    public function connect(){
        $this->conn = new mysqli($this->servername, $this->dbUsername, $this->dbPassword, $this->dbname);

        if ($this->conn->connect_error){
            die("Lidhja me bazen e te dhenave ka deshtuar" . $this->conn->connect_error);
        }
    }

    public function closeConnection(){
        if($this -> conn){
            $this->conn->close();
        }
    }

    public function insertNewUsers($username,$email,$password){
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insertUserQuery = "INSERT INTO Users (FullName, Email, Password, Role) VALUES ('$username','$email','$password','user')";
        if($this->conn->query($insertUserQuery) === TRUE){
            header("Location: homepage.php");
        } else {
            echo "Gabim gjate regjistrimit te userit: ". $conn-> error;
        }
    }

    public function checkUsers($email, $password){

        $selectAdminQuery = "SELECT AdminId as UserId, FullName, Password, Email, Role FROM Admins WHERE Email = '$email'";
        $selectUserQuery = "SELECT UserId, FullName, Password, Email, Role FROM Users WHERE Email = '$email'";

        $finalQuery = "($selectAdminQuery) UNION ($selectUserQuery)";
        $result = $this->conn->query($finalQuery);

        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            if($password == $row["Password"]){
                $_SESSION["UserId"] = $row["UserId"];
                $_SESSION["email"] = $row["Email"];
                $_SESSION["username"] = $row["FullName"];
                $_SESSION["role"] = $row["Role"];
    
                if($_SESSION["role"] === "admin"){
                    header("Location: admin_dashboard.php");
                    exit();
                } else {
                    header("Location: homepage.php");
                    exit();
                }
            } else {
                echo "Fjalekalimi i pasakte!";
            }
        } else {
            echo "Perdoruesi nuk eziston. <a href='register.php'>Regjistrohu ketu!</a>";
        }

    }

    public function insertProduct($productName, $productDescription, $productPrice, $productImage){
    
        if(!isset($_SESSION["username"])){
            echo "Please log in to add a product.";
            return;
        }

        $createdBy = $_SESSION["username"];
        $imagePath = "products/".$productImage;
        
        $stmt = $this->conn->prepare("INSERT INTO products (productName, productDescription, productPrice, productImage, createdBy) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdss", $productName, $productDescription, $productPrice, $imagePath, $createdBy);

        if ($stmt->execute() === true){
            header("Location: homepage.php");
            exit();
        } else {
            echo "Error adding product: " . $stmt->error;
        }

        $stmt->close();
    }

    public function editProduct($productId,$productName, $productDescription, $productPrice,$productImage){
        if(!isset($_SESSION["username"])){
            echo "Please log in to add a product.";
            return;
        }
        $imagePath = "products/".$productImage;
        $modified = $_SESSION["username"];
        $updateMovieQuery = "UPDATE products 
                             SET 
                             productName = '$productName', 
                             productDescription = '$productDescription', 
                             productPrice = '$productPrice',
                             productImage = '$imagePath'
                             WHERE productId = $productId";

        if($this->conn->query($updateMovieQuery) === true){
            echo "<div class=\"modified\">The product was edited sucessfully by: </div>". $modified;
        } else {
            echo "Error editing the product: " . $this->conn->error;
        }

    }

    public function addToCart($userId, $id, $quantity){

        $checkCartSql = "SELECT Quantity FROM cart WHERE UserId = $userId AND productId = $id";
        $queryResult = $this->conn->query($checkCartSql);
        if ($queryResult->num_rows > 0) {
            $row = $queryResult->fetch_assoc();
            $newQuantity = $row['Quantity'] + $quantity;

            $updateCartSql = "UPDATE cart SET Quantity = $newQuantity WHERE UserId = $userId AND productId = $id";
            
            if($this->conn->query($updateCartSql) == true){
                echo "Cart is updated";
            } else {
                echo "Cart is not updated";
            }
        
        } else {
            $insertCartQuery = "INSERT INTO cart (UserId, productId, Quantity) VALUES ('$userId','$id','$quantity')";
            $result = false;

            if($this->conn->query($insertCartQuery) == true ){
                $result = true;
                return $result;
            } else {
                return $result;
            }
        }
    }

    public function listProducts(){

        $selectProductsQuery = "SELECT * FROM products";
        $result = $this->conn->query($selectProductsQuery);
        return $result;
    }

    public function newReleased(){

        $selectNewProducts = "SELECT * FROM products WHERE timeCreated > '2024-12-28'";
        $result = $this->conn->query($selectNewProducts);
        return $result;
    }

    public function listProductsDetails($id){
        $selectProductsQuery = "SELECT * FROM products WHERE productId = $id";
        $result = $this->conn->query($selectProductsQuery);
        return $result;
    }

    public function listCartItems($userId) {
        
        $selectCartItems = "SELECT p.productId, p.productImage, p.productName, p.productPrice, c.Quantity, (p.productPrice * c.Quantity) as Total
                            FROM cart c
                            JOIN users u ON c.UserId = u.UserId
                            JOIN products p ON c.productId = p.productId
                            WHERE c.UserId = $userId";
        $result = $this->conn->query($selectCartItems);
        return $result;
    }

    public function makeAComment($userId,$title,$comment,$ratings,$id) {
        $stmt = $this->conn->prepare("INSERT INTO comments (UserId, title, comment, rating, productId) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issii", $userId, $title, $comment, $ratings, $id);
        if ($stmt->execute()) {
            return true;
        } else {
            return "Failed to make a comment";
        }
    }

    public function listComments($id) {

        $selectCommentsQuery = "SELECT u.FullName, c.title, c.comment, c.rating, p.productId
                                FROM comments c
                                JOIN users u ON c.UserId = u.UserId
                                JOIN products p ON c.productId = p.productId
                                WHERE p.productId = $id";
        $result = $this->conn->query($selectCommentsQuery);
        return $result;
    }

    public function countReviews($id) {
        $selectCountQuery = "SELECT COUNT(*) as reviewCount FROM comments where productId = $id";
        $result = $this->conn->query($selectCountQuery);
        $row = $result -> fetch_assoc();
        return $row["reviewCount"];
    }

    public function averageReviews($id) {
        $selectAverageQuery = "SELECT  (SUM(rating) / COUNT(rating) ) as Average
                               FROM comments
                               WHERE productId = $id";
        $result = $this->conn->query($selectAverageQuery);
        $row = $result -> fetch_assoc();
        $rate = number_format($row["Average"],1);
        if($rate >= 4.5) {
            return 'Excellent <span>' .$rate.'</span>';
        } else if($rate >= 3.5 && $rate <= 4.4) {
            return 'Very good <span>'.$rate.'</span>';
        } else if($rate >=2.5 && $rate <= 3.4) {
            return 'Good <span>'.$rate.'</span>';
        } else if($rate >= 1.5 && $rate <= 2.4) {
            return 'Decent <span>'.$rate.'</span>';
        } else if($rate >= 1.0 && $rate <= 1.4) {
            return 'Bad <span>'.$rate.'</span>';
        } else if ($rate = null) {
            return "No ratings";
        }
    }

    public function listUsers(){

        $selectUsersQuery = "SELECT * FROM users";
        $result = $this->conn->query($selectUsersQuery);
        return $result;
    }

    public function removeProduct($id){
        $deleteProductsQuery = "DELETE FROM products WHERE productId = $id";

        if($this->conn->query($deleteProductsQuery) === true){
            echo "Produkti u fshi";
            echo '<a href="list_products.php">Kthehu tek lista e produkteve</a>';
        } else {
            echo "Gabim gjate fshirjes se filmit" . $this->conn->error;
        }
    }

    public function removeFromCart($productId) {
        $deleteCartItemQuery = "DELETE FROM cart WHERE productId = $productId";
        $result = $this->conn->query($deleteCartItemQuery);
        return $result;
    }

    public function removeUser($id) {
        $deleteUserQuery = "DELETE FROM users WHERE UserId = $id";

        if($this->conn->query($deleteUserQuery) === true ){
            echo "Perdoruesi eshte fshire.";
            echo '<a href="view_users.php">Kthehu tek lista e perdoruesve</a>';
        } else {
            echo "Gabim gjate fshirjes se filmit" . $this->conn->error;
        }
    }

    public function searchProduct($searchQuery){
        $searchQuery = $this->conn->real_escape_string($searchQuery);
        $query = "SELECT * FROM products
                  WHERE productName LIKE '%$searchQuery%'
                  OR productId LIKE '%$searchQuery%'
                  OR createdBy LIKE '%$searchQuery%'";
        $result = $this->conn->query($query);
        return $result;
    }

    public function searchUsers($searchQuery){
        $searchQuery = $this->conn->real_escape_string($searchQuery);
        $query = "SELECT * FROM users
                  WHERE FullName LIKE '%$searchQuery%'
                  OR UserId LIKE '%$searchQuery%'
                  OR Email LIKE '%$searchQuery%'";
        $result = $this->conn->query($query);
        return $result;
    }
}

?>