<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "mydb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h1 {
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

        .order-btn {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .order-btn-disabled {
            background-color: #b5b5b5;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .order-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Каталог</h1>

    <?php
    $sql = "SELECT DISTINCT ConfigID FROM Assembly_config;";
    $result = $conn->query($sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<table><tr><th>Ticketron-" . $row["ConfigID"] . "</th></tr>";

        $sql_in = "CALL DescribeConfig(" . $row["ConfigID"] . ");";
        $result_in = $conn->multi_query($sql_in);

        do {
            if ($result_set = $conn->store_result()) {
                while ($row_in = $result_set->fetch_assoc()) {
                    echo "<tr><td>" . $row_in["PartName"] . "</td><td>" . $row_in["PartDescription"] . "</td></tr>";
                }
                $result_set->free();
            }
        } while ($conn->next_result());
        $sql_in2 = "SELECT CanProduceF(" . $row["ConfigID"] . ") c;";
        $result_in2 = $conn->multi_query($sql_in2);
        $result_set = $conn->store_result();
        echo "</table>";
        // Button to place an order
        echo "<form action='order_page.php' method='post'>\n";
        echo "<input type='hidden' name='configID' value='" . $row["ConfigID"] . "'>\n";
        if ($result_set->fetch_assoc()["c"] == "1"){
            echo "<button class='order-btn' type='submit'>Разместить заказ</button>\n";
        }
        else{
            echo "<button class='order-btn-disabled' type='submit' disabled title='Временно недоступны для заказа'>Разместить заказ</button>\n";
        }
        $result_set->free();
        echo "</form>";
    }

    $conn->close();
    ?>
</body>
</html>
