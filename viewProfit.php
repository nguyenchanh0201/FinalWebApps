<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: loginAdmin.html');
    exit;
}



include 'config.php';

$result_day = $conn->query("SELECT DATE(cart_date) as date, SUM(total) as total_profit FROM `order` GROUP BY DATE(cart_date)");

// Query to get total profit for each month
$result_month = $conn->query("SELECT MONTH(cart_date) as month, YEAR(cart_date) as year, SUM(total) as total_profit FROM `order` GROUP BY MONTH(cart_date), YEAR(cart_date)");

// Query to get total profit for each year
$result_year = $conn->query("SELECT YEAR(cart_date) as year, SUM(total) as total_profit FROM `order` GROUP BY YEAR(cart_date)");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-top: 50px;
        }

        nav {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        ul {
            list-style-type: none;
            display: flex;
            justify-content: space-between;
            width: 50%;
        }

        li {
            background-color: #333;
            color: #fff;
            padding: 15px 20px;
            border-radius: 5px;
        }

        li a {
            color: #fff;
            text-decoration: none;
        }

        li:hover {
            background-color: #666;
        }

        .product-container,
        .add-container,
        .order-container
         {
            width: 1000px;
            margin: 50px auto;
        }

        img {
            width: 50%;
            /* Adjust this value to make the image smaller or larger */
            height: auto;
            /* This will maintain the aspect ratio of the image */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        .add_product {
            display: flex;
            flex-direction: column;
            width: 50%;
            margin: 0 auto;
        }

        .input_fields {
            margin-bottom: 20px;
            padding: 10px;
            font-size: 16px;
        }

        .heading {
            text-align: center;
            color: #333;
        }
    </style>
</head>

<body>
<h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
    <nav>
        <ul>
            <li>
                <a href="editProduct.php" class="nav-link">View Product</a>
            </li>
            <li>
                <a href="viewOrder.php" class="nav-link">View Order</a>
            </li>
            <li>
                <a href="viewCustomer.php" class="nav-link">View Customer</a>
            </li>
        </ul>
    </nav>

    <!--  -->
    <div class="product-container">
        <h2 class="heading">Total Profit for Each Day</h2>
        <table>
            <tr>
                <th>Date</th>
                <th>Total Profit</th>
            </tr>
            <?php
            if ($result_day->num_rows > 0) {
                while ($row = $result_day->fetch_assoc()) {
                    echo "<tr><td>" . $row['date'] . "</td><td>" . $row['total_profit'] . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No data found</td></tr>";
            }
            ?>
        </table>
    </div>

    <div class="product-container">
        <h2 class="heading">Total Profit for Each Month</h2>
        <table>
            <tr>
                <th>Month</th>
                <th>Year</th>
                <th>Total Profit</th>
            </tr>
            <?php
            if ($result_month->num_rows > 0) {
                while ($row = $result_month->fetch_assoc()) {
                    echo "<tr><td>" . $row['month'] . "</td><td>" . $row['year'] . "</td><td>" . $row['total_profit'] . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No data found</td></tr>";
            }
            ?>
        </table>

    </div>

    <div class="product-container">
        <h2 class="heading">Total Profit for Each Year</h2>
        <table>
            <tr>
                <th>Year</th>
                <th>Total Profit</th>
            </tr>
            <?php
            if ($result_year->num_rows > 0) {
                while ($row = $result_year->fetch_assoc()) {
                    echo "<tr><td>" . $row['year'] . "</td><td>" . $row['total_profit'] . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No data found</td></tr>";
            }
            ?>
        </table>
    </div>
    

    </body>
</html>
