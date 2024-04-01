<?php

session_start();

include 'config.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View all the Products</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="./css/styles.css" />
    <link rel="stylesheet" href="./css/viewProduct.css" />
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



        <div class="view-products-container">
            <section class="display_product">
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
                                    <td><?php echo $num?></td>
                                    <td><img src="<?php echo $row['image'] ?>" alt="<?php echo $row['name'] ?>"></td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['details'] ?></td>
                                    <td><?php echo $row['price'] ?></td>
                                    <td>
                                        <a href="delete.php?delete= <?php echo $row['idProduct']?>" class="delete-product-btn" onclick="return confirm('Are you sure you want to delete ?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="update.php?edit=<?php echo $row['idProduct']?>" class="update-product-btn">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                    </td>
                                </tr>
                        <?php
                                $num++;}
                        } else {
                        echo "<td>No products found</td>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>

        </div>
</body>

</html>