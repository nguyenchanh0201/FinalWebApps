<?php
session_start();
include 'config.php';

$total = 0;
$select_cart_products = mysqli_query($conn, "SELECT * FROM cart");
while ($fetch_cart_products = mysqli_fetch_assoc($select_cart_products)) {
  $subtotal = $fetch_cart_products['quantity'] * $fetch_cart_products['price'];
  $total += $subtotal;
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
      <!-- Payment Information -->
      <p>Payment Information</p>
      <div class="container">
        <form action="payprocess.php" method="post">
          <div class=row>
            <?php
            $id = $_SESSION['id'];
            $sql_get_shipping = mysqli_query($conn, "SELECT * FROM shipping WHERE id = '$id'LIMIT 1");
            $count = mysqli_num_rows($sql_get_shipping);
            if ($count > 0) {
              $row_get_shipping = mysqli_fetch_array($sql_get_shipping);
              $name = $row_get_shipping['name'];
              $phone = $row_get_shipping['phone'];
              $address = $row_get_shipping['address'];
              $note = $row_get_shipping['note'];
            } else {
              $name = '';
              $phone = '';
              $address = '';
              $note = '';
            }
            ?>
            <div class="col-md-8">
              <h3>Shipping Information And Cart</h3>
              <ul>
                <li>Name: <b><?php echo $name; ?></b></li>
                <li>Phone: <b><?php echo $phone; ?></b></li>
                <li>Address: <b><?php echo $address; ?></b></li>
                <li>Note: <b><?php echo $note; ?></b></li>
              </ul>
            </div>
            <style type="text/css">
              .col-md-4.payment .form-check {
                margin-top: 11px;
              }
            </style>
            <div class="col-md-4" Payment>
              <h3>Payment</h3>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="payment" value="cash" id="exampleRadios1" checked>
                <label class="form-check-label" for="exampleRadios1">
                  Cash On Delivery
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="payment" value="cash" id="exampleRadios2" checked>
                <label class="form-check-label" for="exampleRadios2">
                  MOMO
                </label>
              </div>
              <p style="float:left;">Total amount to be paid:<?php
                                                              echo number_format($total - 50, 0, ',', '.') . '$' ?> </p>
              <br>
              <input type="submit" class="btn btn-primary" value="Place Order">
            </div>
          </div>
      </div>
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

          while ($fetch_cart_products = mysqli_fetch_array($select_cart_products)) {
        ?>
            <td>
              <div class="cart-info">
                <img src="<?php echo $fetch_cart_products['image'] ?>" alt="" />
                <div>
                  <p><?php echo $fetch_cart_products['name'] ?></p>
                  <span>Price: $<?php echo $fetch_cart_products['price'] ?></span> <br>

                </div>
              </div>
            </td>
            <td>
              <?php echo $fetch_cart_products['quantity'] ?>
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
            <td>$<?php echo $total; ?></td>
          </tr>
          <tr>
            <td>Tax</td>
            <td>$50</td>
          </tr>
          <td>Total</td>
          <td>$<?php $total -= 50;
                if ($total < 0) {
                  $total = 0;
                }
                echo $total;
                $_SESSION['total'] = $total;
                ?></td>
          </tr>
        </table>

      </div>
      </form>
  </header>

</body>