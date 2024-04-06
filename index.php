<?php


session_start();
include 'config.php';

if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = 1;

    $insert_product = mysqli_query($conn, "INSERT INTO cart (name, price, image, quantity) VALUES ('$product_name', '$product_price', '$product_image', $product_quantity)");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />

    <!-- Glide js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.theme.css">
    <!-- Bootstrap icon -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="./css/styles.css" />
    <title>ecommerce Website</title>
</head>

<body>
    <!-- Header -->
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
                <a href="index.php" class="logo">
                    <h1>The Culture &#127936;</h1>
                </a>

                <ul class="nav-list d-flex">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="search.php" class="nav-link">Shop</a>
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


                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                        <li class="nav-item">
                            <a href="profile.php" class="nav-link">
                                <?php echo $_SESSION['username']; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>

                <div class="icons d-flex">
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>

                    <?php } else { ?>
                        <a href="login.html" class="icon">
                            <i class="bx bx-user"></i>
                        </a>
                    <?php } ?>
                    <a href="search.php" class="icon">
                        <i class="bx bx-search"></i>
                    </a>
                    <a href="favorites.php" class="icon">
                        <i class="bx bx-heart"></i>
                        <span class="d-flex"><?php $fav_num_result = mysqli_query($conn, "select count(*) as count from favorites");
                                                $fav_num = mysqli_fetch_assoc($fav_num_result);
                                                echo $fav_num['count']; ?></span>
                    </a>
                    <a href="cart.php" class="icon">
                        <i class="bx bx-cart"></i>
                        <span class="d-flex"><?php $cart_num_result = mysqli_query($conn, "select count(*) as count from cart");
                                                $cart_num = mysqli_fetch_assoc($cart_num_result);
                                                echo $cart_num['count']; ?></span>
                    </a>
                </div>



                <?php
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                    echo '<a href="logout.php" class="icon">
                        <i class="bx bx-log-out"></i> </a>';
                } else {
                    echo ' ';
                }
                ?>

            </div>



            <div class="hero">
                <div class="glide" id="glide_1">
                    <div class="glide__track" data-glide-el="track">
                        <ul class="glide__slides">
                            <li class="glide__slide">
                                <div class="center">
                                    <div class="left">
                                    <span>New Inspiration 2022</span>
                                        <h1>THE PERFECT MATCH!</h1>
                                        <p>Trending from men's and women's style collection</p>
                                        <a href="product.html" class="hero-btn">SHOP NOW</a>
                                    </div>
                                    <div class="right">
                                        <img class="img1" src="./images/kb24.png" alt="">
                                    </div>
                                </div>
                            </li>
                            <li class="glide__slide">
                                <div class="center">
                                    <div class="left">
                                        <span>New Inspiration 2022</span>
                                        <h1>THE PERFECT MATCH!</h1>
                                        <p>Trending from men's and women's style collection</p>
                                        <a href="product.html" class="hero-btn">SHOP NOW</a>
                                    </div>
                                    <div class="right">
                                        <img class="img2" src="./images/jp3.png" alt="">
                                    </div>
                                </div>
                            </li>
                            <li class="glide__slide">
                                <div class="center">
                                    <div class="left">
                                        <span>New Inspiration 2022</span>
                                        <h1>THE PERFECT MATCH!</h1>
                                        <p>Trending from men's and women's style collection</p>
                                        <a href="product.html" class="hero-btn">SHOP NOW</a>
                                    </div>
                                    <div class="right">
                                        <img class="img1" src="./images/carter.png" alt="">
                                    </div>
                                </div>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>




    </header>

    <!-- Categories Section -->
    <section class="section category">
        <div class="cat-center">
            <div class="cat">
                <a href="search.php/nike-basketball">
                <img src="./images/nike.png" alt="" />
                <div>
                    <p>NIKE</p>
                </div>
                </a>
                
            </div>
            <div class="cat">
                <img src="./images/adidas.png" alt="" />
                <div>
                    <p>ADIDAS</p>
                </div>
            </div>
            <div class="cat">
                <img src="./images/puma.png" alt="" />
                <div>
                    <p>PUMA</p>
                </div>
            </div>
            <div class="cat">
                <img src="./images/nb.png" alt="" />
                <div>
                    <p>NEW BALANCE</p>
                </div>
            </div>

        </div>
    </section>

    <!-- New Arrivals -->
    <section class="section new-arrival">
        <div class="title">
            <h1>NEW ARRIVALS</h1>
            <p>All the latest picked from designer of our store</p>
        </div>

        <div class="product-center container">
            <?php
            $select_query = mysqli_query($conn, "SELECT * FROM products");
            if (mysqli_num_rows($select_query) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_query)) {
            ?>
                    <div class="product-item">
                        <div class="overlay">
                            <a href="productDetails.html" class="product-thumb">
                                <img src="<?php echo $fetch_product['image'] ?>" alt="" />
                            </a>
                            <span class="discount">40%</span>
                        </div>
                        <div class="product-info">


                            <span><?php echo $fetch_product['category'] ?></span>
                            <form action="" method="post" class="form-submit">
                                <a href="productDetails.html"><?php echo $fetch_product['name'] ?></a>
                                <h4>$<?php echo $fetch_product['price'] ?></h4>

                                <input type="hidden" name="product_name" value="<?php echo $fetch_product['name'] ?>">
                                <input type="hidden" name="product_price" value="<?php echo $fetch_product['price'] ?>">
                                <input type="hidden" name="product_image" value="<?php echo $fetch_product['image'] ?>">

                        </div>
                        <ul class="icons">
                            <li>

                                <button type="submit" class="btn btn-link" name="add_to_favorites">
                                    <i class="bx bx-heart"></i>
                                </button>

                            </li>
                            <li>

                                <button type="submit" class="btn btn-link">
                                    <i class="bx bx-search"></i>
                                </button>

                            </li>
                            <li>

                                <button type="submit" class="btn btn-link" name="add_to_cart">
                                    <i class="bx bx-cart"></i>
                                </button>

                            </li>
                        </ul>
                        </form>


                    </div>
            <?php
                }
            } else {
                echo "<div class='alert alert-danger'>No product found</div>";
            }
            ?>



        </div>
    </section>


    <!-- Promo -->

    <section class="section banner">
        <div class="left">
            <span class="trend">Trend Design</span>
            <h1>New Collection 2022</h1>
            <p>New Arrival <span class="color">Sale 50% OFF</span> Limited Time Offer</p>
            <a href="product.html" class="btn btn-1">Discover Now</a>
        </div>
        <div class="right">
            <img src="./images/allen.png" alt="">
        </div>
    </section>




    <!-- Featured -->

    <section class="section new-arrival">
        <div class="title">
            <h1>Featured</h1>
            <p>All the latest picked from designer of our store</p>
        </div>

        <div class="product-center container">
            <?php
            $select_query = mysqli_query($conn, "SELECT * FROM products");
            if (mysqli_num_rows($select_query) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_query)) {
            ?>
                    <div class="product-item">
                        <div class="overlay">
                            <a href="productDetails.html" class="product-thumb">
                                <img src="<?php echo $fetch_product['image'] ?>" alt="" />
                            </a>
                            <span class="discount">40%</span>
                        </div>
                        <div class="product-info">


                            <span><?php echo $fetch_product['category'] ?></span>
                            <form action="" method="post" class="form-submit">
                                <a href="productDetails.html"><?php echo $fetch_product['name'] ?></a>
                                <h4>$<?php echo $fetch_product['price'] ?></h4>

                                <input type="hidden" name="product_name" value="<?php echo $fetch_product['name'] ?>">
                                <input type="hidden" name="product_price" value="<?php echo $fetch_product['price'] ?>">
                                <input type="hidden" name="product_image" value="<?php echo $fetch_product['image'] ?>">

                        </div>
                        <ul class="icons">
                            <li>

                                <button type="submit" class="btn btn-link">
                                    <i class="bx bx-heart"></i>
                                </button>

                            </li>
                            <li>

                                <button type="submit" class="btn btn-link">
                                    <i class="bx bx-search"></i>
                                </button>

                            </li>
                            <li>

                                <button type="submit" class="btn btn-link" name="add_to_cart">
                                    <i class="bx bx-cart"></i>
                                </button>

                            </li>
                        </ul>
                        </form>


                    </div>
            <?php
                }
            } else {
                echo "<div class='alert alert-danger'>No product found</div>";
            }
            ?>



        </div>

    </section>

    <!-- Contact -->
    <section class="section contact">
        <div class="row">
            <div class="col">
                <h2>EXCELLENT SUPPORT</h2>
                <p>We love our customers and they can reach us any time
                    of day we will be at your service 24/7</p>
                <a href="contact.html" class="btn btn-1">Contact</a>
            </div>
            <div class="col">
                <form action="contactEmail.php" method="post">
                    <div>
                        <input type="email" placeholder="Email Address" name="email">
                        <button type="submit" class="b-send">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="row">
            <div class="col d-flex">
                <h4>INFORMATION</h4>
                <a href="about.html">About us</a>
                <a href="contact.html">Contact Us</a>
                <a href="">Term & Conditions</a>
                <a href="">Shipping Guide</a>
            </div>
            <div class="col d-flex">
                <h4>USEFUL LINK</h4>
                <a href="">Online Store</a>
                <a href="">Customer Services</a>
                <a href="">Promotion</a>
                <a href="">Top Brands</a>
            </div>
            <div class="col d-flex">
                <span><i class='bx bxl-facebook-square'></i></span>
                <span><i class='bx bxl-instagram-alt'></i></span>
                <span><i class='bx bxl-github'></i></span>
                <span><i class='bx bxl-twitter'></i></span>
                <span><i class='bx bxl-pinterest'></i></span>
            </div>
        </div>
    </footer>


    <!-- PopUp -->
    <div class="popup hide-popup">
        <div class="popup-content">
            <div class="popup-close">
                <i class='bx bx-x'></i>
            </div>
            <div class="popup-left">
                <div class="popup-img-container">
                    <img class="popup-img" src="./images/mj23.png" alt="popup">
                </div>
            </div>
            <div class="popup-right">
                <div class="right-content">
                    <h1>Get Discount <span>50%</span> Off</h1>
                    <p>Sign up to our newsletter and save 30% for you next purchase. No spam, we promise!
                    </p>
                    <form action="subscribe.php" method="POST">
                        <input type="email" placeholder="Enter your email..." class="popup-form" name="email">
                        <button type="submit" class="btn btn-1">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/glide.min.js"></script>
<script src="./js/slider.js"></script>
<script src="./js/index.js"></script>

</html>