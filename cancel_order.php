<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "root";
$database = "mydb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["orderID"])) {
    $orderID = $_POST["orderID"];

    // Call the stored procedure to cancel the order
    $sql = "CALL DeleteOrder($orderID)";
    $conn->query($sql);

    // Redirect back to the success page after canceling the order
    header("Location: success_page.php");
    exit();
} else {
    // Redirect to an error page if orderID is not set
    header("Location: error_page.php");
    exit();
}

$conn->close();
?>
