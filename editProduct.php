<?php
session_start();
if (!isset($_SESSION['loggedinAdmin']) || $_SESSION['loggedinAdmin'] !== true) {
    header('Location: loginAdmin.html');
    exit;
}



include 'config.php';


if (isset($_POST['add-product'])) {
    $product_name = $_POST['product-name'];
    $product_price = $_POST['product-price'];
    $product_details = $_POST['product-details'];
    $product_img = $_FILES['product-img']['name'];
    $product_img_temp_name = $_FILES['product-img']['tmp_name'];
    $product_img_folder = "images/" . $product_img;
    $product_categories = $_POST['product-categories'];

    $insert_query = "INSERT INTO products (name, details, price,  image, category) VALUES 
('$product_name','$product_details', '$product_price' , '$product_img_folder','$product_categories')";

    $result = mysqli_query($conn, $insert_query) or die("Insert query failed");

    if ($result) {
        move_uploaded_file($product_img_temp_name, $product_img_folder);
        echo "Product added successfully";
    } else {
        echo "Product not added";
    }
}


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
<h1>Welcome, <?php echo $_SESSION['usernameAdmin']; ?></h1>
    <nav>
        <ul>
            <li>
                <a href="viewOrder.php" class="nav-link">View Orders</a>
            </li>
            <li>
                <a href="viewCustomer.php" class="nav-link">View Customers</a>
            </li>
            <li>
                <a href="viewProfit.php" class="nav-link">View Profit</a>
            </li>
        </ul>
    </nav>
    <div class="product-container">

        <h3 class="heading">Add Products</h3>
        <form action="" class="add_product" method="post" enctype="multipart/form-data">
            <input type="text" name="product-name" placeholder="Enter product name" class="input_fields" required>
            <input type="number" name="product-price" min="0" step="0.01" placeholder="Enter product price" class="input_fields" required>
            <input type="text" name="product-details" placeholder="Enter product details" class="input_fields" required>
            <input type="file" name="product-img" placeholder="Enter product image" class="input_fields" required accept="image/*">
            <input type="text" name="product-categories" placeholder="Enter product categories" class="input_fields" required>
            <input type="submit" name="add-product" class="input_fields" required>
        </form>

    </div>
    <div class="product-container" >
        <table>
            <thead>
                <th>SL No</th>
                <th>Product Image</th>
                <th>Product name</th>
                <th>Product Details</th>
                <th>Product Price</th>
                <th>Action</th>
            </thead>
            <tbody>
                <!-- php code -->
                <?php
                $display_product = mysqli_query($conn, "SELECT * FROM products");
                $num = 1;
                if (mysqli_num_rows($display_product) > 0) {
                    while ($row = mysqli_fetch_assoc($display_product)) {
                ?>
                        <tr>
                            <td><?php echo $num ?></td>
                            <td><img src="<?php echo $row['image'] ?>" alt="<?php echo $row['name'] ?>"></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['details'] ?></td>
                            <td><?php echo $row['price'] ?></td>
                            <td>
                                <a href="delete.php?delete= <?php echo $row['idProduct'] ?>" class="delete-product-btn" onclick="return confirm('Are you sure you want to delete ?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <a href="update.php?edit=<?php echo $row['idProduct'] ?>" class="update-product-btn">
                                    <i class="fas fa-edit"></i>
                                </a>

                            </td>
                        </tr>
                <?php
                        $num++;
                    }
                } else {
                    echo "<td>No products found</td>";
                }
                ?>
            </tbody>
        </table>
    </div>

    


</body>





</html>