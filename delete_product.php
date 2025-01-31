<?php
session_start();

require 'database.php';
if (isset($_GET["productId"])) {

    $id = filter_var($_GET["productId"], FILTER_VALIDATE_INT);

    if ($id !== false) {
        $db = new Database();
        
        $db->removeProduct($id);

    
        $db->closeConnection();
    } else {
        echo "Product ID është i pavlefshëm.";
    }
} else {
    echo "Product ID mungon.";
}
?>