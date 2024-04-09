<?php
include 'config.php';

session_start();
// Add to cart
if (isset($_POST['add_to_cart'])) {
  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header('Location: login.html');
  }
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

// add to favorites
if (isset($_POST['add_to_favorites'])) {
  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    echo "<script>window.location.href='login.html'</script>";
  }
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
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Box icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
  <!-- Bootstrap icon -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <!-- Custom StyleSheet -->
  <link rel="stylesheet" href="./css/styles.css" />
  <title>Boy’s T-Shirt - Codevo</title>
</head>

<body>
  <!-- Navigation -->
  <div class="top-nav">
    <div class="container d-flex">
      <p>Order Online Or Call Us: (001) 2222-55555</p>
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
          <span class="d-flex"><?php
                                //Check logged in, if not return 0 favorites
                                if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
                                  echo 0;
                                } else {
                                  //Get favorites count
                                  $fav_num_result = mysqli_query($conn, "select count(*) as count from favorites where id_user = " . $_SESSION['id']);
                                  $fav_num = mysqli_fetch_assoc($fav_num_result);
                                  echo $fav_num['count'];
                                } ?></span>

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
  </div>

  <!-- Product Details -->
  <?php
  $product_name = $_GET['product_name'];

  // Sanitize the product name
  $product_name = mysqli_real_escape_string($conn, $product_name);
  $select_query = mysqli_query($conn, "SELECT * FROM products WHERE name = '$product_name'");
  $product = mysqli_fetch_assoc($select_query);

  ?>
  <section class="section product-detail">
    <div class="details container">
      <div class="left image-container">
        <div class="main">

          <img src="<?php echo $product['image']; ?>" id="zoom" alt="">
        </div>
      </div>


      <div class="right">

        <span><?php echo $product['category']; ?></span>
        <h1><?php echo $product['name']; ?></h1>
        <div class="price">$<?php echo $product['price']; ?></div>
        <form action="" method="post">
          <select name="size">
            <option value="Select Size">Select Size</option>
            <option value="1">32</option>
            <option value="2">42</option>
            <option value="3">52</option>
            <option value="4">62</option>
          </select>
        </form>
        <form class="form" method="post">
          <input type="hidden" name="product_name" value="<?php echo $product['name'] ?>">
          <input type="hidden" name="id" value="<?php echo $product['idProduct'] ?>">
          <input type="hidden" name="product_price" value="<?php echo $product['price'] ?>">
          <input type="hidden" name="product_image" value="<?php echo $product['image'] ?>">


          <button type="submit" class="addCart" name="add_to_cart">Add to Cart</button>
        </form>
        <h3>Product Detail</h3>
        <p>
          <?php echo $product['details']; ?>
        </p>
      </div>
    </div>
  </section>

  <!-- Related -->
  <section class="section featured">
    <div class="top container">
      <h1>Related Products</h1>
      <a href="search.php?keyword=<?php echo $product['category']; ?>&search=Search" class="view-more">View more</a>
    </div>
    <div class="product-center container">
      <?php
      $select_query = mysqli_query($conn, "SELECT * FROM products where category = '" . $product['category'] . "' limit 0,4");
      if (mysqli_num_rows($select_query) > 0) {
        while ($fetch_product = mysqli_fetch_assoc($select_query)) {
      ?>
          <div class="product-item">
            <div class="overlay">
              <a href="productDetails.php" class="product-thumb">
                <img src="<?php echo $fetch_product['image'] ?>" alt="" />
              </a>
              <span class="discount">40%</span>
            </div>
            <div class="product-info">


              <span><?php echo $fetch_product['category'] ?></span>
              <form action="" method="post" class="form-submit">
              <a href="productDetails.php?product_name=<?php echo urlencode($fetch_product['name']); ?>"><?php echo $fetch_product['name'] ?></a>
                <h4>$<?php echo $fetch_product['price'] ?></h4>

                <input type="hidden" name="product_name" value="<?php echo $fetch_product['name'] ?>">
                <input type="hidden" name="id" value="<?php echo $fetch_product['idProduct'] ?>">
                <input type="hidden" name="category" value="<?php echo $fetch_product['category'] ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_product['price'] ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_product['image'] ?>">

            </div>
            <ul class="icons">
              <li>

                <button type="submit" class="btn btn-link" class="add_to_favorites">
                  <i class="bx bx-heart"></i>
                </button>

              </li>
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
  <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha384-JUMjoW8OzDJw4oFpWIB2Bu/c6768ObEthBMVSiIx4ruBIEdyNSUQAjJNFqT5pnJ6" crossorigin="anonymous"></script>
  <script src="./js/zoomsl.min.js"></script>
  <script>
    $(function() {
      console.log("hello");
      $("#zoom").imagezoomsl({
        zoomrange: [4, 4],
      });
    });
  </script>
  <script>
      if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
    </script>
</body>

</html>