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
  <link rel="stylesheet" href="./css/contact.css">


  <title>E-commerce Website</title>
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
        <a href="index.php" class="logo">
          <h1>The Mart</h1>
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
            <a href="about.php" class="nav-link">About</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Contact</a>
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

      <div class="bgc">
        <div class="container9">
          <h1 style="font-size: 50px;">Get in Touch with us....!!</h1>
          <div class="contact-info">
            <form action="">
              <h2>Write Us</h2>
              <input type="text" name="fullname"  placeholder="Full Name " required>
              <input type="email" name="email"  placeholder="Email " required>
              <input type="text" name="company"  placeholder="Issue Type " required>
              <label for="customercheck">Are you an existing customer? *</label>
              <div class="customer-check-wrap">
                <input type="radio" name="customercheck" id="customercheck" value="yes" required> Yes
                <input type="radio" name="customercheck" id="customercheck" value="No" required> No 
              </div>
              <textarea name="msg" id="msg" cols="30" rows="10" placeholder="Your Message Here..."></textarea>
              <button type="submit">Send</button>
            </form>
            <div class="details">
              <h3>Developer's info</h3>
              <p>Support available for 6am-5pm, Mon-Fri
              </p>
              <div class="expert-wrapper">
                <div class="expert">
                  <img src="./images/" />
                  <p>Nguyen Hoang Trung Chanh</p>
                </div>
                <div class="expert">
                  <img src="./images/" />
                  <p>Nguyen Tuan Kiet</p>
                </div>


              </div>

            </div>

          </div>

        </div>
      </div>

</html>
</body>

</html>