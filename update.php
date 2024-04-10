<?php
    include 'config.php';
    session_start();
     if (!isset($_SESSION['loggedinAdmin']) || $_SESSION['loggedinAdmin'] !== true) {
        header('Location: loginAdmin.html');
        exit;
     }
    

    if (isset($_POST['update_product'])) {
        $update_product_id = $_POST['update_product_id'];
        $update_product_name = $_POST['update_product_name'];
        $update_product_price = $_POST['update_product_price'];
        $update_product_details = $_POST['update_product_details'];

        if($_FILES['update_product_image']['error'] == 0) {
        $update_product_image = $_FILES['update_product_image']['name'];
        $update_product_image_tmp_name = $_FILES['update_product_image']['tmp_name'];
        $update_product_image_folder = "images/" . $update_product_image;
        
        $update_query = "UPDATE products SET name = '$update_product_name', details = '$update_product_details', price = '$update_product_price', image = '$update_product_image_folder' WHERE idProduct = $update_product_id";
        } else {
            $update_query = "UPDATE products SET name = '$update_product_name', details = '$update_product_details', price = '$update_product_price' WHERE idProduct = $update_product_id";
        }
        $result = mysqli_query($conn, $update_query) or die("Update query failed");

        if ($result) {
            move_uploaded_file($update_product_image_tmp_name, $update_product_image_folder);
            echo "Product updated successfully";
            header("location: editProduct.php");
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
    
    <link rel="stylesheet" href="./css/update.css">
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"rel="stylesheet"/>
    <!-- Glide js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.theme.css">
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
                <a href="editProduct.php" class="nav-link">Back to View Products</a>
            </li>
            
        </ul>
    </nav>

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
                <input type="number" class="input_fields fields" min="0" step="0.01" required placeholder="Enter Product Price" value="<?php echo $fetch_data['price']?>" name="update_product_price">
                <input type="text" class="input_fields fields" required placeholder="Enter Product Details" value="<?php echo $fetch_data['details']?>" name="update_product_details">
                <input type="file" class="input_fields fields"  accept="image/*" name="update_product_image">
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


