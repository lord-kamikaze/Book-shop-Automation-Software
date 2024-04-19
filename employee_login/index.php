
<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "login_employee");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement
    $sql = "INSERT INTO books (book_image, book_name, isbn, author_name, quantity, available, price) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("sssissd", $book_image, $book_name, $isbn, $author_name, $quantity, $available, $price);

    // Set parameters
    $book_image = $_FILES['book_image']['name'];
    $book_name = $_POST['book_name'];
    $isbn = $_POST['isbn'];
    $author_name = $_POST['author_name'];
    $quantity = $_POST['quantity'];
    $available = isset($_POST['available']) ? 1 : 0; // Check if the checkbox is checked
    $price = $_POST['price'];

    // Execute the statement
    if ($stmt->execute()) {
        // echo "New book added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    // $stmt->close();
    // $conn->close();

// Check if form is submitted
// if(isset($_POST['search'])) {
//     $searchTerm = $_POST['searchTerm'];
//     // Modify SQL query to include search criteria
//     $sql = "SELECT * FROM books WHERE available = 1 AND (book_name LIKE '%$searchTerm%' OR isbn LIKE '%$searchTerm%' OR author_name LIKE '%$searchTerm%')";
// }
// Check if a book is to be deleted
if (isset($_GET['isbn'])) {
    $isbn = $_GET['isbn'];

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "login_employee");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement
    $sql = "DELETE FROM books WHERE isbn = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $isbn);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Book deleted successfully";
    } else {
        echo "Error deleting book: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
}
?>
<?php
// Check if form is submitted

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">

<!-- Your existing styles here -->
<style>
    /* Base Styles
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    padding: 20px;
}

h1 {
    color: #007bff;
    margin-bottom: 20px;
}


#bookForm {
    display: none; /* Initially hide the form 
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

label {
    margin-bottom: 10px;
    display: block;
}

input[type="text"],
input[type="number"],
input[type="file"],
input[type="checkbox"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ced4da;
    border-radius: 5px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Book Container Styles 
.book-container {
    background-color: #edf2f9; /* Light blue background 
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow 
    padding: 20px;
    margin-bottom: 20px;
}

.book-container img {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
}

.book-details {
    margin-top: 10px;
}
.book-image {
    object-fit: contain;
    max-width: 100%; /* Adjust as needed 
    max-height: 100%; /* Adjust as needed 
    width: auto;
    height: auto;
}

.book-details h2 {
    font-size: 24px;
    margin-bottom: 10px;
}

.book-details p {
    margin-bottom: 5px;
}

.book-details h3 {
    color: #007bff; /* Blue price 
    margin-bottom: 10px;
}

.add-to-cart-btn {
    background-color: #007bff; /* Blue button 
    color: #fff; /* White text 
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}
.book-table-image {
    width: 100px; /* Adjust the width as needed 
    height: auto; /* Maintain aspect ratio 
    object-fit: cover; /* Cover the area without stretching the image 
}


.add-to-cart-btn:hover {
    background-color: #0056b3; /* Darker blue on hover 
} */
body {
    font-family: 'Roboto', sans-serif;
    background-color: #f8f9fa;
    padding: 20px;
    color: #333;
}

h1 {
    color: #007bff;
    margin-bottom: 20px;
}

.container {
    max-width: 960px;
    margin: 0 auto;
}
/* .container_1{
    max-width: 840px;
    margin: 0 auto;
} */

.btn {
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 16px;
    transition: background-color 0.3s;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
    border: none;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-warning {
    background-color: #ffc107;
    color: #333;
    border: none;
}

.btn-warning:hover {
    background-color: #e0a800;
}

#bookForm {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

#bookForm label {
    margin-bottom: 10px;
    display: block;
}

#bookForm input[type="text"],
#bookForm input[type="number"],
#bookForm input[type="file"],
#bookForm input[type="checkbox"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ced4da;
    border-radius: 5px;
    box-sizing: border-box;
}

#bookForm input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

#bookForm input[type="submit"]:hover {
    background-color: #0056b3;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.table th,
.table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.table th {
    background-color: #f2f2f2;
    color: #333;
    font-weight: bold;
}

.table tr:hover {
    background-color: #f5f5f5;
}

.book-table-image {
    width: 100px;
    height: auto;
    object-fit: cover;
    border-radius: 5px;
}

.btn-danger {
    background-color: #dc3545;
    color: #fff;
    border: none;
}

.btn-danger:hover {
    background-color: #c82333;
}

#bookForm {
    display: none;
}

</style>
<title>User Dashboard</title>
</head>
<body>
<div class="container">
    <h1>Welcome to Employee Dashboard</h1>
    <a href="logout.php" class="btn btn-warning">Logout</a>
    <div class="contain">
    <div class="row justify-content-end">
        <div class="col-auto">
            
            <button id="toggleFormBtn" class="btn btn-primary">Add Book</button>
            <!-- <h1 class="text-center mr-4">Books Available</h1> -->
        </div>
    </div>
</div>
</div>
<!-- Button to toggle form -->
<!-- <button id="toggleFormBtn" class="btn btn-primary">Add Book</button> -->
<!-- <div class="container">
    <div class="row justify-content-end">
        <div class="col-auto">
            
            <button id="toggleFormBtn" class="btn btn-primary">Add Book</button>
            <h1 class="text-center mr-4">Books Available</h1> 
        </div>
    </div>
</div>-->

<!-- Form -->
<form id="bookForm" action="" method="post" enctype="multipart/form-data">
    <!-- Your existing form fields here -->
<label for="book_image">Book Image:</label>
    <input type="file" name="book_image" id="book_image" class="book-image" required><br>
    <label for="book_name">Book Name:</label>
    <input type="text" name="book_name" id="book_name" required><br>
    <label for="isbn">ISBN:</label>
    <input type="text" name="isbn" id="isbn" required><br>
    <label for="author_name">Author Name:</label>
    <input type="text" name="author_name" id="author_name" required><br>
    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" id="quantity" required><br>
    <label for="available">Available:</label>
    <input type="checkbox" name="available" id="available"><br>
    <label for="price">Price:</label>
    <input type="number" name="price" id="price" required><br>
    <input type="submit" value="Add Book">
</form>
<!-- <form method="post" action="">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search by Book Name, ISBN, or Author" name="searchTerm">
            <button class="btn btn-outline-secondary" type="submit" name="search">Search</button>
        </div>
    </form> -->
<h1 class="text-center mt-4">Books Available</h1>

<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Book Image</th>
                <th>Book Name</th>
                <th>ISBN</th>
                <th>Author</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Available</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $conn = new mysqli("localhost", "root", "", "login_employee");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            $sql = "SELECT * FROM books";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    // echo "<td><img src='" . $row['book_image'] . "' alt='" . $row['book_name'] . "'></td>";
                    echo "<td><img src='" . $row['book_image'] . "' alt='" . $row['book_name'] . "' class='book-table-image'></td>";

                    echo "<td>" . $row['book_name'] . "</td>";
                    echo "<td>" . $row['isbn'] . "</td>";
                    echo "<td>" . $row['author_name'] . "</td>";
                    echo "<td>" . $row['quantity'] . "</td>";
                    echo "<td>" . $row['Price'] . "</td>";
                    echo "<td>" . ($row['available'] ? 'Yes' : 'No') . "</td>";
                    echo "<td><a href='edit_book.php?isbn=" . $row['isbn'] . "' class='btn btn-primary'>Edit</a> <a href='delete_book.php?isbn=" . $row['isbn'] . "' class='btn btn-danger'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No books available</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
    
</div>



<script>
var formVisible = false;

document.getElementById("toggleFormBtn").addEventListener("click", function() {
    if (!formVisible) {
        document.getElementById("bookForm").style.display = "block";
    } else {
        document.getElementById("bookForm").style.display = "none";
    }
    formVisible = !formVisible;
});
</script>

</body>

</form>
</html>
