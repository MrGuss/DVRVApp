<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "mydb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//TODO: add authorization to get this param from user
$customerID = 1;

$sql = "SELECT * FROM Orders
        INNER JOIN Cust_orders ON Orders.OrderID = Cust_orders.OrderID
        WHERE Cust_orders.CustomerID = $customerID";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказы</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4caf50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
        }

        .cancel-btn, .details-btn {
            padding: 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .cancel-btn {
            background-color: #f44336;
            color: white;
        }

        .cancel-btn:hover {
            background-color: #d32f2f;
        }

        .details-btn {
            background-color: #2196F3;
            color: white;
        }

        .details-btn:hover {
            background-color: #1565C0;
        }
    </style>
</head>
<body>
    <h2>Ваши заказы</h2>

    <?php
    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID заказа</th><th>Дата заказа</th><th>Стоимость</th><th></th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["OrderID"] . "</td>";
            echo "<td>" . $row["OrderDate"] . "</td>";
            echo "<td>" . $row["SalePrice"] . "</td>";
            echo "<td class='action-buttons'>";
            echo "<form action='cancel_order.php' method='post'>";
            echo "<input type='hidden' name='orderID' value='" . $row["OrderID"] . "'>";
            echo "<button class='cancel-btn' type='submit'>Отменить заказ</button>";
            echo "</form>";

            echo "<form action='order_details.php' method='post'>";
            echo "<input type='hidden' name='orderID' value='" . $row["OrderID"] . "'>";
            echo "<button class='details-btn' type='submit'>Детали заказа</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No orders found.</p>";
    }
    ?>

</body>
</html>
<?php
$conn->close();
?>
