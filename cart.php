<?php
include 'config.php';
session_start();

//update query 
if (isset($_POST['update_product_quantity'])) {
  $update_value = $_POST['update_quantity'];
  
  //echo $update_value;
  $update_id = $_POST['update_quantity_id'];
  //echo $update_id;
  $update_quantity_query = mysqli_query($conn, "UPDATE cart SET quantity = '$update_value' WHERE id = '$update_id'");
  
  if ($update_quantity_query) {
    echo "Quantity updated successfully";
    header("location:cart.php");
  } else {
    echo "Quantity not updated";
  }
}

//add to cart
if (isset($_POST['add_to_cart'])) {
  $product_name = $_POST['product_name'];
  $product_price = $_POST['product_price'];
  $product_image = $_POST['product_image'];
  $product_quantity = 1;

  $insert_product = mysqli_query($conn, "INSERT INTO cart (name, price, image, quantity) VALUES ('$product_name', '$product_price', '$product_image', $product_quantity)");
}
// add to favorites
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


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Box icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <!-- Custom StyleSheet -->
  <link rel="stylesheet" href="./css/styles.css" />
  <title>Your Cart</title>
</head>

<body>
  <!-- Navigation -->
  <div class="top-nav">
    <div class="container d-flex">
      <p>Order Online Or Call Us: (001) 2222-55555</p>
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
      <h1>The Culture &#127936;</h1>
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

      
    </div>
  </div>

  <!-- Cart Items -->
  <div class="container cart">
    <table>
      <?php
      $select_cart_products = mysqli_query($conn, "Select * from cart");
      if (mysqli_num_rows($select_cart_products) > 0) {
        echo "<tr>
          <th>Product</th>
          <th>Quantity</th>
          <th>Subtotal</th>
        </tr>
        <tr>";

        while ($fetch_cart_products = mysqli_fetch_assoc($select_cart_products)) {

      ?>

          <td>
            <div class="cart-info">
              <img src="<?php echo $fetch_cart_products['image'] ?>" alt="" />
              <div>
                <a style="color: #0A59CC;" href="productDetails.php?product_name=<?php echo urlencode($fetch_cart_products['name']); ?>"><?php echo $fetch_cart_products['name'] ?></a> <br>
                <span>Price: $<?php echo $fetch_cart_products['price'] ?></span> <br>
                <a href="delete.php?delete_cart= <?php echo $fetch_cart_products['id'] ?>" onclick="return confirm('Are you sure you want to delete ?');">remove</a>
              </div>
            </div>
          </td>
          <td>
            <form action="" method="post">
              <input type="hidden" value="<?php echo $fetch_cart_products['id'] ?>" name="update_quantity_id">
              <input type="number" min="1" value="<?php echo $fetch_cart_products['quantity'] ?>" name="update_quantity">
              <button type="submit" name="update_product_quantity" style="
          color: white;  
          background-color: #0A59CC;
          border: none;
          padding: 5px 8px;
          cursor: pointer;" value="update">
                Update</button>
            </form>
          </td>
          <td>$<?php $subtotal = $fetch_cart_products['quantity'] * $fetch_cart_products['price'];
                echo $subtotal; ?></td>
          </tr>
      <?php
        }
      } else {
        echo "<div class='alert alert-danger'>No product found</div>";

      }
      ?>
    </table>
    <div class="total-price">
      <table>
        <tr>
          <td>Subtotal</td>
          <?php
          $total = 0;
          $select_cart_products = mysqli_query($conn, "SELECT * FROM cart");
          while ($fetch_cart_products = mysqli_fetch_assoc($select_cart_products)) {
            $subtotal = $fetch_cart_products['quantity'] * $fetch_cart_products['price'];
            $total += $subtotal;
          }
          ?>
          <td>$<?php echo $total; ?></td>
        </tr>
        <tr>
          <td>Tax</td>
          <td>$50</td>
        </tr>
        <tr>
          <td>Total</td>
          <td>$<?php $total -= 50;
                if ($total < 0) {
                  $total = 0;
                }
                echo $total;  ?></td>
        </tr>
      </table>
      <?php
      //Check logged in
      // Check if there is any product, if not then dont let click on checkout
      $check_cart = mysqli_query($conn, "SELECT count(*) FROM cart");
      $cart_count = mysqli_fetch_assoc($check_cart);
      if ($cart_count['count(*)'] > 0) {
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
          echo '<a href="checkout.php" class="checkout btn">Proceed To Checkout</a>';
          echo '<a href="search.php" style="width: 117px" class="checkout btn">Continue Shopping</a>';
        } else {
          echo '<a href="login.html" class="checkout btn">Login To Checkout</a>';
        }
      } else {
        echo '<a href="search.php" class="checkout btn">Add Products To Cart</a>';
      }
      
       ?>
    </div>

  </div>

  <!-- Latest Products -->
  <section class="section featured">
    <div class="top container">
      <h1>Latest Products</h1>
      <a href="#" class="view-more">View more</a>
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
                <h4><?php echo $fetch_product['price'] ?></h4>

                <input type="hidden" name="product_name" value="<?php echo $fetch_product['name'] ?>">
                <input type="hidden" name="id" value="<?php echo $fetch_product['idProduct'] ?>">
                <input type="hidden" name="category" value="<?php echo $fetch_product['category']?>"> 
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
              </form>
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
</body>

</html>