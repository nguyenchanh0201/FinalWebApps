<?php

include 'config.php';
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.html");
}

if (isset($_POST['add-product'])) {
    $product_name = $_POST['product-name'];
    $product_price = $_POST['product-price'];
    $product_details = $_POST['product-details'];
    $product_img = $_FILES['product-img']['name'];
    $product_img_temp_name = $_FILES['product-img']['tmp_name'];
    $product_img_folder = "images/" . $product_img;

    $insert_query = "INSERT INTO products (name, details, price,  image) VALUES 
('$product_name','$product_details', '$product_price' , '$product_img_folder')";

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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"rel="stylesheet"/>
    <!-- Glide js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.theme.css">
    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="./css/styles.css" />
    <link rel="stylesheet" href="./css/addProduct.css" />
    
    <title>Add products</title>
</head>

<body>
    <header class="header" id="header">
        <!-- Top Nav -->
        <div class="top-nav">
            <div class="container d-flex">
                <p>Order Online Or Call Us:(+91) 8081886430,7376550891</p>
                <ul class="d-flex">
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="contact.html">FAQ</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class="navigation">
            <div class="nav-center container d-flex">
                <a href="index.html" class="logo">
                    <h1>The Mart</h1>
                </a>

                <ul class="nav-list d-flex">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="product.html" class="nav-link">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a href="terms.xml" class="nav-link">Terms</a>
                    </li>
                    <li class="nav-item">
                        <a href="about.html" class="nav-link">About</a>
                    </li>
                    <li class="nav-item">
                        <a href="contact.html" class="nav-link">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><?php echo "Welcome " . $_SESSION['username'] ?></a>
                    </li>

                </ul>

                <div class="icons d-flex">
                    <a href="login.html" class="icon">
                        <i class="bx bx-user"></i>
                    </a>
                    <a href="search.html" class="icon">
                        <i class="bx bx-search"></i>
                    </a>
                    <div class="icon">
                        <i class="bx bx-heart"></i>
                        <span class="d-flex">0</span>
                    </div>
                    <a href="cart.html" class="icon">
                        <i class="bx bx-cart"></i>
                        <span class="d-flex">0</span>
                    </a>
                    <a href="logout.php" class="icon">
                        <i class="bx bx-log-out"></i>
                    </a>
                </div>

                <div class="hamburger">
                    <i class="bx bx-menu-alt-left"></i>
                </div>
            </div>
        </div>
    


        <div class="container-add-product">
            <section>
                <h3 class="heading">Add Products</h3>
                <form action="" class="add_product" method="post" enctype="multipart/form-data">
                    <input type="text" name="product-name" placeholder="Enter product name" class="input_fields" required>
                    <input type="number" name="product-price" min="0"  placeholder="Enter product price" class="input_fields" required>
                    <input type="text" name="product-details" placeholder="Enter product details" class="input_fields" required>
                    <input type="file" name="product-img" placeholder="Enter product image" class="input_fields" required accept="image/*">
                    <input type="submit" name="add-product" class="input_fields" required>
                </form>
            </section>
        </div>

</body>

</html>