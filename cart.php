<?php
include 'config.php';

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
              <p><?php echo $fetch_cart_products['name'] ?></p>
              <span>Price: $<?php echo $fetch_cart_products['price'] ?></span> <br>
              <a href="delete.php?delete_cart= <?php echo $fetch_cart_products['id']?>" onclick="return confirm('Are you sure you want to delete ?');">remove</a>
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
        </form></td>
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
      <a href="checkout.html" class="checkout btn">Proceed To Checkout</a>
      <a href="search.php" class="checkout btn" style="width: 117px; text-align:center;">Continue Shopping</a>
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

                <input type="hidden" name="product_name">
                <input type="hidden" name="product_price">
                <input type="hidden" name="product_image">

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