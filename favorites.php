<?php
include 'config.php';
session_start();

if (isset($_POST['add_to_cart'])) {
  $product_name = $_POST['product_name'];
  $product_price = $_POST['product_price'];
  $product_image = $_POST['product_image'];
  $product_quantity = 1;
  $product_id = $_POST['id'];
  $stmt = $conn->prepare("SELECT * FROM cart WHERE name = ?");
  $stmt->bind_param("s", $product_name);
  $stmt->execute();
  $select_cart = $stmt->get_result();
  if (mysqli_num_rows($select_cart) > 0) {
    $fetch_cart = mysqli_fetch_assoc($select_cart);
    $product_quantity = $fetch_cart['quantity'] + 1;
    $update_cart = mysqli_query($conn, "UPDATE cart SET quantity = $product_quantity WHERE name = '$product_name'");
  } else {
    $user_id = $_SESSION['id']; // Assuming you have user_id in session after user login
    $insert_product = mysqli_query($conn, "INSERT INTO cart (name, price, image, quantity, id_product, id_user) VALUES ('$product_name', '$product_price', '$product_image', $product_quantity, $product_id, $user_id)");
  }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.css">
  <!-- Box icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <!-- Custom StyleSheet -->
  <link rel="stylesheet" href="./css/styles.css" />
  <link rel="stylesheet" href="./css/viewProduct.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.theme.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/glide.min.js"></script>
  <title>Your Favorites</title>
</head>

<body>
  <!-- Navigation -->
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
                        <a href="about.php" class="nav-link">About</a>
                    </li>
                    <li class="nav-item">
                        <a href="contact.php" class="nav-link">Contact</a>
                    </li>


                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                        <li class="nav-item">
                            <a href="track_order.php" class="nav-link">
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
                        <span class="d-flex"><?php
                                                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                                                    $fav_num_result = mysqli_query($conn, "select count(*) as count from favorites where id_user = " . $_SESSION['id']);
                                                    $fav_num = mysqli_fetch_assoc($fav_num_result);
                                                    echo $fav_num['count'];
                                                } else {
                                                    echo 0;
                                                }
                                                ?>

                        </span>
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
                                        <span>New Inspiration 2024</span>
                                        <h1>THE PERFECT MATCH!</h1>
                                        <p>Brand new basketball shoes collection with many choices</p>
                                        <a href="search.php" class="hero-btn">SHOP NOW</a>
                                    </div>
                                    <div class="right">
                                        <img class="img1" src="./images/kb24.png" alt="">
                                    </div>
                                </div>
                            </li>
                            <li class="glide__slide">
                                <div class="center">
                                    <div class="left">
                                        <span>New Nike Basketball shoes coming out</span>
                                        <h1>BE LIKE POOLE!</h1>
                                        <p>Try out these GT CUT 3 to be shifty and "Poole" party!!!</p>
                                        <a href="search.php" class="hero-btn">SHOP NOW</a>
                                    </div>
                                    <div class="right">
                                        <img class="img2" src="./images/jp3.png" alt="">
                                    </div>
                                </div>
                            </li>
                            <li class="glide__slide">
                                <div class="center">
                                    <div class="left">
                                        <span>Vince Carter Back to Back shoes collection</span>
                                        <h1>THE DUNK OF THE YEAR</h1>
                                        <p>Pick a pair of Vince's best shoes to recreate the iconic dunk of all time!!!</p>
                                        <a href="search.php" class="hero-btn">SHOP NOW</a>
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
        </div>
              </header>



            


    <!-- Cart Items -->
    <section class="section featured">
      <div class="top container">
        <h1>Your Wish List</h1>
        <a href="search.php" class="view-more">View more</a>
      </div>
      <div class="product-center container">
        <?php
        // check logged in 
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        $display_product = mysqli_query($conn, "SELECT * FROM favorites where id_user = " . $_SESSION['id']);
        if (mysqli_num_rows($display_product) > 0) {
          while ($fetch_product = mysqli_fetch_assoc($display_product)) {
        ?>
            <div class="product-item">
              <div class="overlay">
                <a href="productDetails.php?product_name=<?php echo urlencode($fetch_product['name']); ?>" class="product-thumb">
                  <img src="<?php echo $fetch_product['image'] ?>" alt="" />
                </a>
                <span class="discount">40%</span>
              </div>
              <div class="product-info">


                <span><?php echo $fetch_product['category'] ?></span>
                <form action="" method="post" class="form-submit">
                  <a href="productDetails.php?product_name=<?php echo urlencode($fetch_product['name']); ?>" class="product-name"><?php echo $fetch_product['name'] ?></a>
                  <h4>$<?php echo $fetch_product['price'] ?></h4>

                  <input type="hidden" name="product_name" value="<?php echo $fetch_product['name'] ?>">
                  <input type="hidden" name="id" value="
                  <?php
                  $select_id = mysqli_query($conn, "SELECT idProduct FROM products WHERE image = '" . $fetch_product['image'] . "'");
                  echo $select_id->fetch_assoc()['idProduct'];
                  ?>"> <!-- id này là id của fav nên không chấp nhận -->
                  <input type="hidden" name="product_price" value="<?php echo $fetch_product['price'] ?>">
                  <input type="hidden" name="product_image" value="<?php echo $fetch_product['image'] ?>">


              </div>
              <ul class="icons">

                <li>

                  <a href="search.php?keyword=<?php echo $fetch_product['name']; ?>&search=Search" class="btn btn-link">
                    <i class="bx bx-search"></i>
                  </a>

                </li>
                <li>

                  <button type="submit" class="btn btn-link" name="add_to_cart">
                    <i class="bx bx-cart"></i>
                  </button>

                </li>
                <li>


                  <a href="delete.php?delete_favorites= <?php echo $fetch_product['id'] ?>" class="delete-product-btn" onclick="return confirm('Are you sure you want to delete ?');">
                    <i class="bx bx-trash"></i>
                  </a>


                </li>
              </ul>
              </form>


            </div>
        <?php
          }
        } else {
          echo "<div class='alert alert-danger'>No product found</div>";
        }
      } else {
        echo "<a href='login.html' class='alert alert-danger'>Please login to see your favorites</a>";
      }
        ?>



      </div>
    </section>



    <!-- Latest Products -->


    <!-- Footer -->
    <footer class="footer">
      <div class="row">
        <div class="col d-flex">
          <h4>INFORMATION</h4>
          <a href="">About us</a>
          <a href="">Contact Us</a>
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
          <span><i class="bx bxl-facebook-square"></i></span>
          <span><i class="bx bxl-instagram-alt"></i></span>
          <span><i class="bx bxl-github"></i></span>
          <span><i class="bx bxl-twitter"></i></span>
          <span><i class="bx bxl-pinterest"></i></span>
        </div>
      </div>
    </footer>

    <!-- Custom Script -->
    <script src="./js/index.js"></script>
    <script>
      if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
    </script>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/glide.min.js"></script>
<script src="./js/slider.js"></script>
<script src="./js/index.js"></script>
</html>