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

//add to favorites
if (isset($_POST['add_to_favorites'])) {
  $product_name = $_POST['product_name'];
  $product_price = $_POST['product_price'];
  $product_image = $_POST['product_image'];
  $product_id = $_POST['id'];
  $product_category = $_POST['category'];
  $user_id = $_SESSION['id']; // Assuming you have user_id in session after user login
  //Check if product exists in favorites
  $stmt = $conn->prepare("SELECT * FROM favorites WHERE id_Product = ? AND id_user = ?");
  $stmt->bind_param("ii", $product_id, $user_id);
  $stmt->execute();
  $select_favorites = $stmt->get_result();
  if (mysqli_num_rows($select_favorites) > 0) {
      echo "<script>alert('Product already added to favorites')</script>";
  } else {
      $insert_favorites = mysqli_query($conn, "INSERT INTO favorites (name, price, image, id_product, id_user, category) VALUES ('$product_name', '$product_price', '$product_image', $product_id, $user_id, '$product_category')");
  }
}


// Pagination
$start = 0;
$products_per_page = 4;


//get total nb of products
$records = mysqli_query($conn, "Select * from products ");
$nb_of_rows = $records->num_rows;
$nb_of_pages = ceil($nb_of_rows / $products_per_page);

if (isset($_GET['page-nr'])) {
  $page = $_GET['page-nr'];
  $start = ($page - 1) * $products_per_page;
} else {
  $page = 1;
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
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <!-- Custom StyleSheet -->
  <link rel="stylesheet" href="./css/styles.css" />
  <link rel="stylesheet" href="./css/about.css">
  <link rel="stylesheet" href="./css/search.css" />

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
            <a href="#" class="nav-link">
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
      <!-- All Products -->
      <section class="section all-products" id="products">
        <div class="top container">
        <form action="search.php?manage=search" method="GET">
            <input type="text" name="keyword" class="search" placeholder="Search here!">
            <input type="submit" name="search" class="submit" value="Search" style="width: 70px;
                      background-color: #2579f2;
                      color: #ffffff;
                      border-radius: 8px;
                      border: none;
                      box-shadow: 2px 2px 4px rgba(0, 0, 0, .4);">
          </form>
          <?php
          if (isset($_GET['search'])) {
            $keyword = $_GET['keyword'];
            // Sanitize the keyword
            $keyword = mysqli_real_escape_string($conn, $keyword);
            echo "Search Results for: $keyword";
          } else {
            echo "<h1>All Products</h1>";
          }

          ?>
          

          
        </div>


        <div class="product-center container">

          <?php

          // } else {
            
          $start = 0; // Define start as per your requirement
          $products_per_page = 4; // Define products_per_page as per your requirement
            


          $select_query = mysqli_query($conn, "SELECT * FROM products order by rand() limit $start, $products_per_page");
          if (isset($_GET['search'])) {
            $keyword = $_GET['keyword'];
            // Sanitize the keyword
            $keyword = mysqli_real_escape_string($conn, $keyword);

            // Modify the SQL query to get products related to the keyword
            $select_query = mysqli_query($conn, "SELECT * FROM products WHERE name LIKE '%$keyword%' OR category LIKE '%$keyword%'");
          }
          if (mysqli_num_rows($select_query) > 0) {
            while ($fetch_product = mysqli_fetch_assoc($select_query)) {
          ?>
              <div class="product-item">
                <div class="overlay">
                  <a href="productDetails.php?product_name=<?php echo urlencode($fetch_product['name']); ?>"" class="product-thumb">
                    <img src="<?php echo $fetch_product['image'] ?>" alt="" />
                  </a>
                  <span class="discount">40%</span>
                </div>
                <div class="product-info">


                  <span><?php echo $fetch_product['category'] ?></span>
                  <form action="" method="post" class="form-submit">
                    <a href="productDetails.php?product_name=<?php echo urlencode($fetch_product['name']); ?>"><?php echo $fetch_product['name']; ?></a>
                    <h4>$<?php echo $fetch_product['price'] ?></h4>

                    <input type="hidden" name="product_name" value="<?php echo $fetch_product['name'] ?>">
                    <input type="hidden" name="id" value="<?php echo $fetch_product['idProduct'] ?>">
                    <input type="hidden" name="category" value="<?php echo $fetch_product['category'] ?>">  
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

          // }
          ?>



        </div>
      </section>

      <section class="pagination">
        <div class="container">
          <h4>Showing <?php echo $page; ?> out of <?php echo $nb_of_pages ?></h4> <br>

          <?php
          if (isset($_GET['page-nr']) && $_GET['page-nr'] > 1) {
          ?>
            <a href="?page-nr=<?php echo $_GET['page-nr'] - 1 ?>"><i class="bx bx-left-arrow-alt"></i></a>
          <?php
          } else {
          ?>
            <a href=""><i class="bx bx-left-arrow-alt"></i></a>
          <?php
          }
          ?>




          <a href="?page-nr=1">1</a>
          <a href="?page-nr=2">2</a>
          <a href="?page-nr=3">3</a>
          <a href="?page-nr=4">4</a>
          <?php
          if (!isset($_GET['page-nr'])) {

          ?>
            <a href="?page-nr=2"><i class="bx bx-right-arrow-alt"></i></a>
            <?php
          } else {
            if ($_GET['page-nr'] >= $nb_of_pages) {

            ?>
              <a href=""><i class="bx bx-right-arrow-alt"></i></a>
            <?php
            } else {
            ?>
              <a href="?page-nr=<?php echo $_GET['page-nr'] + 1 ?>"><i class="bx bx-right-arrow-alt"></i></a>
          <?php
            }
          }
          ?>
        </div>
      </section>
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

    </div>
</body>

</html>