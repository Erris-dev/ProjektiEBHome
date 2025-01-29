<?php
session_start();
require 'database.php';

    $searchQuery = isset($_POST["search"]) ? $_POST["search"] : '';
    $db = new Database();
    if(!empty($searchQuery)){
        $searchQuery = $db->conn->real_escape_string($searchQuery);
        $query = "SELECT * FROM users
                  WHERE FullName LIKE '%$searchQuery%'
                  OR UserId LIKE '%$searchQuery%'
                  OR Email LIKE '%$searchQuery%'";
        $result = $db->conn->query($query);
    } else {
    
        $result = $db->listUsers();
    }
    $db->closeConnection();
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
            font-family: Arial, sans-serif;
            margin-top:1rem;
            padding: 0;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            flex-direction:column;
            min-height: 100vh; 
            overflow-y: auto; 
        }
        table {
            border-collapse: collapse;
            width: 80%;
            max-width: 1000px;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .searchbar {
            height: 35px;
            padding: 5px;
            border-style: none;
            background-color: #e7e9e8;
        }

        .searchbutton {
            height: 35px;
            background-color: #4CAF50;
            border-style: none;
            color: #Fff;
            padding: 5px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
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
        .edit, .remove {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }
        .edit {
            background-color: #007BFF;
            color: white;
        }
        .manage {
            padding: 0;
            margin: 0;
            
        }
        .edit:hover {
            background-color: #0056b3;
        }
        .remove {
            background-color: #DC3545;
            color: white;
        }
        .remove:hover {
            background-color: #a71d2a;
        }
        @media (max-width: 768px) {
    table {
        width: 100%;
        font-size: 14px;
    }
    th, td {
        padding: 8px;
    }
    .searchbar, .searchbutton {
        width: 100%; 
    }
    }

@media (max-width: 600px) {
    .table-container {
        width: 100%;
        overflow-x: auto;
    }
    
    table {
        width: 100%;
        min-width: 600px;
    }

    th, td {
        font-size: 12px;
        padding: 6px;
    }

    .edit, .remove {
        font-size: 12px;
        padding: 6px 8px;
    }
}

@media (max-width: 400px) {
    th, td {
        font-size: 10px;
        padding: 5px;
    }
    
    .edit, .remove {
        font-size: 10px;
        padding: 4px 6px;
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
    <h2>View Users</h2>
    <div class="searc-container">
        <form method="POST" action="view_users.php">
            <input class="searchbar" type="search" name="search" placeholder="Search a user">
            <button class="searchbutton" type="submit">Search</button>
        </form>
    </div>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created At</th>
        </tr>

        <?php

        if($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["UserId"]."</td>";
                echo "<td>".$row["FullName"]."</td>";
                echo "<td>".$row["Email"]."</td>";
                echo "<td>".$row["Role"]."</td>";
                echo "<td>".$row["createdAt"]."</td>";
                echo "<td><a class=\"edit\" href='edit_movie.php?UserId=".$row["UserId"]."'>Shiko</a> | <a class=\"remove\" href='delete_user.php?UserId=".$row["UserId"]."'>Fshij</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Nuk u gjet asnje perdorues</td></tr>";
        }
        
        ?>
    </table>

    </main>
</body>
</html>
