<?php
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

    $orderSql = "SELECT * FROM Orders WHERE OrderID = $orderID";
    $orderResult = $conn->query($orderSql);

    if ($orderResult->num_rows > 0) {
        $orderRow = $orderResult->fetch_assoc();

        $shippingSql = "SELECT * FROM Shipping_logistics WHERE OrderID = $orderID";
        $shippingResult = $conn->query($shippingSql);
        $shippingRow = $shippingResult->fetch_assoc();

        $warrantySql = "SELECT * FROM Warranty_information WHERE OrderID = $orderID";
        $warrantyResult = $conn->query($warrantySql);
        $warrantyRow = $warrantyResult->fetch_assoc();

        echo "<h2>Детали заказа</h2>";
        echo "<p>ID заказа: " . $orderRow["OrderID"] . "</p>";
        echo "<p>Дата заказа: " . $orderRow["OrderDate"] . "</p>";
        echo "<p>Стоимость: " . $orderRow["SalePrice"] . "</p>";

        echo "<h3>Информация о доставке</h3>";
        echo "<p>Дата доставки: " . $shippingRow["ShipDate"] . "</p>";
        echo "<p>Адрес доставки: " . $shippingRow["ShipAddress"] . "</p>";
        echo "<p>Номер отслеживания: " . $shippingRow["TrackingNumber"] . "</p>";

        echo "<h3>Информация о гарантии</h3>";
        echo "<p>Дата начала гарантии: " . $warrantyRow["WarrantyStartDate"] . "</p>";
        echo "<p>Дата окончания гарантии: " . $warrantyRow["WarrantyEndDate"] . "</p>";

    } else {
        echo "<p>Заказов нет.</p>";
    }

} else {
    header("Location: error_page.php");
    exit();
}

$conn->close();
?>