<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
}

// Database connection
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "login_employee";

$conn = new mysqli($hostName, $dbUser, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all books by default
$sql = "SELECT * FROM books WHERE available = 1";

// Check if search form is submitted
if(isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm'];
    // Modify SQL query to include search criteria
    $sql = "SELECT * FROM books WHERE available = 1 AND (book_name LIKE '%$searchTerm%' OR isbn LIKE '%$searchTerm%' OR author_name LIKE '%$searchTerm%')";
}

$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<link rel="stylesheet" href="style_e.css">

<style>
    /* Custom CSS for Books Available */
    .book-container {
        background-color: #f8f9fa; /* Light grey background */
        background-color: #edf2f9; /* Light blue background */
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow */
        padding: 20px;
        margin-bottom: 20px;
    }
    .book-container img {
    max-width: 100%; /* Ensures the image does not exceed the width of its container */
    max-height: 300px; /* Sets a maximum height for the image */
    height: auto; /* Maintains the aspect ratio */
    width: auto; /* Maintains the aspect ratio */
    object-fit: cover; /* Ensures the image covers the container without stretching */
    border-radius: 5px;
}

    /* .book-container img {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
    } */

    .book-details {
        margin-top: 10px;
    }

    .book-details h2 {
        font-size: 24px;
        margin-bottom: 5px;
    }

    .book-details p {
        margin-bottom: 5px;
    }

    .book-details h3 {
        color: #007bff; /* Blue price */
        margin-bottom: 10px;
    }

    .add-to-cart-btn {
        background-color: #007bff; /* Blue button */
        color: #fff; /* White text */
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .add-to-cart-btn:hover {
        background-color: #0056b3; /* Darker blue on hover */
    }
</style>

<title>User Dashboard</title>
</head>
<body>
<div class="container">
    <h1>Welcome to User Dashboard</h1>
    <div class="contain">
    <a href="" class="btn btn-primary mb-4 mt-4">Books Available</a>
</div>
    <form method="post" action="">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search by Book Name, ISBN, or Author" name="searchTerm">
            <button class="btn btn-outline-secondary" type="submit" name="search">Search</button>
        </div>
    </form>
    <a href="logout.php" class="btn btn-warning">Logout</a>
</div>


<h1 class="text-center">Books Available</h1>
<div class="container">
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='book-container'>";
            echo "<img src='" . $row['book_image'] . "' alt='" . $row['book_name'] . "'>";
            echo "<div class='book-details'>";
            echo "<h2>" . $row['book_name'] . "</h2>";
            echo "<p>ISBN: " . $row['isbn'] . "</p>";
            echo "<p>Author: " . $row['author_name'] . "</p>";
            echo "<p>Quantity: " . $row['quantity'] . "</p>";
            echo "<h3>Price: " . $row['Price'] . "rs</h3>";
            // echo "<button class='add-to-cart-btn'>Add to Cart</button>";
            echo "<button class='add-to-cart-btn' onclick='addToCart(" . $row['Price'] . ")'>Add to Cart</button>";

            echo "</div>"; // Closing book-details div
            echo "</div>"; // Closing book-container div
        }
    } else {
        echo "No books available.";
    }
    
// echo "<button class='add-to-cart-btn' onclick='add-to-cart-btn(" . $row['Price'] . ")'>Add to Cart</button>";


// <script>
// function addToCart(price) {
//     alert("Pay $" + price + " to get the book.");
// }
// </script>




    ?>
    <script>
function addToCart(price) {
    alert("Pay " + price + "rs to get the book.");
}
 </script>
</div>
</body>
</html>
