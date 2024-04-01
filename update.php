<?php
    include 'config.php';
    session_start();
    

    if (isset($_POST['update_product'])) {
        $update_product_id = $_POST['update_product_id'];
        $update_product_name = $_POST['update_product_name'];
        $update_product_price = $_POST['update_product_price'];
        $update_product_details = $_POST['update_product_details'];
        $update_product_image = $_FILES['update_product_image']['name'];
        $update_product_image_tmp_name = $_FILES['update_product_image']['tmp_name'];
        $update_product_image_folder = "images/" . $update_product_image;

        $update_query = "UPDATE products SET name = '$update_product_name', details = '$update_product_details', price = '$update_product_price', image = '$update_product_image_folder' WHERE idProduct = $update_product_id";
        $result = mysqli_query($conn, $update_query) or die("Update query failed");

        if ($result) {
            move_uploaded_file($update_product_image_tmp_name, $update_product_image_folder);
            echo "Product updated successfully";
            header("location: viewProduct.php");
        } else {
            echo "Product not updated";
        }
    
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="./css/styles.css" />
    <link rel="stylesheet" href="./css/update.css">
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"rel="stylesheet"/>
    <!-- Glide js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.theme.css">
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


        <section class="edit_container"> 
        <!-- php code -->
        <?php
        if (isset($_GET['edit'])) {
            $edit_id = $_GET['edit'];
            $edit_query = mysqli_query($conn, "SELECT * FROM products WHERE idProduct = $edit_id");
            if (mysqli_num_rows($edit_query) > 0) {
            $fetch_data=mysqli_fetch_assoc($edit_query) ;
                // $row = $fetch_data['price'];
                // echo $row;
            
        

        ?>
       

            <form action="" method="post" enctype="multipart/form-data" class="update_product product_container_box">
                <img src="<?php echo $fetch_data['image']?>" alt="" style="display: block; margin: auto;">
                <input type="hidden" value="<?php echo $fetch_data['idProduct']?>" name="update_product_id">
                <input type="text" class="input_fields fields" required placeholder="Enter Product Name" value="<?php echo $fetch_data['name']?>" name="update_product_name">
                <input type="number" class="input_fields fields" required placeholder="Enter Product Price" value="<?php echo $fetch_data['price']?>" name="update_product_price">
                <input type="text" class="input_fields fields" required placeholder="Enter Product Details" value="<?php echo $fetch_data['details']?>" name="update_product_details">
                <input type="file" class="input_fields fields" required accept="image/*" name="update_product_image">
                <div class="btns">
                    <input type="submit" class="edit_btn" value="Update Product" name="update_product">
                    <input type="reset" class="cancel_btn" id="close-edit" value="Cancel">
                </div>
            </form>
            <?php
            }
        
        }
        ?>
        </section>
</body>
</html>


