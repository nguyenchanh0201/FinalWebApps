<?php
include 'config.php';
session_start();
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
    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="./css/styles.css" />
    <link rel="stylesheet" href="./css/about.css">
    <title>ecommerce Website</title>
</head>

<body>
    <!-- Header -->
    <header class="header" id="header">
        <div class="top-nav">
            <div class="container d-flex">
                <p>Order Online Or Call Us:(+91) 8081886430,7376550891</p>
                <ul class="d-flex">
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="terms.xml">FAQ</a></li>
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
                </ul>

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
            </div>
            <div class="about-section">
                <h1>About Us Page</h1>
                <p>Some text about who we are and what we do.</p>
                <p class="cool">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem, quae, officia quaerat, necessitatibus est hic nulla tempora quam animi laboriosam ut excepturi. Deserunt harum, id non, sed natus tempora consequatur, sit soluta quas quae sint? Excepturi quae corporis explicabo quibusdam nostrum velit facilis, dolorum odit accusantium blanditiis laboriosam ab asperiores quam beatae maiores mollitia ratione reiciendis pariatur sapiente esse iure quasi alias nemo. Cumque aliquid, sapiente consequuntur necessitatibus quos, sunt fugit totam doloribus, deserunt eius impedit. In itaque temporibus porro commodi, nostrum nemo consequatur</p>
                <p class="cool">
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatem non quasi quia repellendus et nihil quaerat! Accusamus laboriosam neque molestias vero repudiandae tempore? Nostrum laudantium, voluptates blanditiis totam numquam ipsa. Autem, qui voluptas? Dolorem mollitia eos esse voluptatibus, suscipit voluptatem cum, laboriosam illum non error eius deleniti, vitae magni!
                </p>
            </div>
            
</body>

</html>