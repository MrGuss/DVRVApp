<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["configID"])) {
    $configID = $_POST["configID"];

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $database = "mydb";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST["shipAddress"]) && isset($_POST["warrantyType"])) {
        $shipAddress = $_POST["shipAddress"];
        $trackingNumber = rand(1,10000);
        $warrantyType = $_POST["warrantyType"];
        $customerID = 1;

        $sql = "CALL AddOrder('$shipAddress', $trackingNumber, $configID, $customerID, $warrantyType)";
        $conn->query($sql);

        header("Location: success_page.php");
        exit();
    }

    $conn->close();
} else {
    header("Location: previous_page.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Разместить заказ</title>
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

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Разместить заказ</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input type="hidden" name="configID" value="<?php echo $configID; ?>">

        <label for="shipAddress">Адрес доставки:</label>
        <input type="text" name="shipAddress" required>

        <label for="warrantyType">Тип гарантии (1-обычная, 2-расширенная):</label>
        <input type="number" name="warrantyType" required>

        <input type="submit" value="Разместить заказ">
    </form>
</body>
</html>