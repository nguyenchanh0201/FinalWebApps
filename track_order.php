<?php
include 'config.php';
session_start();




?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
  <title>Your Cart</title>
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

      <div class="hamburger">

      </div>
    </div>
    </div>

    <div class="view-products-container">
      <section class="display_product">
        <h1 style="text-align: center; margin-top: 20px;">My Orders</h1>
        <table>
          <thead>
            <th>SL No</th>
            <th>Product Image</th>
            <th>Product name</th>
            <th>Product Price</th>
            <th>See more Info</th>
          </thead>
          <tbody>
            <!-- php code -->
            <?php
            $display_product = mysqli_query($conn, "SELECT * FROM favorites");
            $num = 1;
            if (mysqli_num_rows($display_product) > 0) {
              while ($row = mysqli_fetch_assoc($display_product)) {
            ?>
                <tr>
                  <td><?php echo $num ?></td>
                  <td><img src="<?php echo $row['image'] ?>" alt="<?php echo $row['name'] ?>"></td>
                  <td><?php echo $row['name'] ?></td>
                  <td>$<?php echo $row['price'] ?></td>
                  <td>
                    <a href="delete.php?delete_favorites= <?php echo $row['id'] ?>" class="delete-product-btn" onclick="return confirm('Are you sure you want to delete ?');">
                      <i class="fas fa-trash"></i>
                    </a>
                  </td>
                </tr>
            <?php
                $num++;
              }
            } else {
              echo "
                        <td> </td>
                        <td> </td>
                        <td>No products found</td>";
            }
            ?>
          </tbody>
        </table>

    </div>

    </div>