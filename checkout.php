<?php
session_start();
include 'config.php';
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
<!------------------SHIPPING---------------->
        <h4>Shipping Information</h4>
        <?php
          if(isset($_POST['addshipping'])){
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $note = $_POST['note'];
            $id = $_SESSION['id'];
            $sql_addshipping = mysqli_query($conn, "INSERT INTO shipping (name,phone, address,note,id) VALUES ('$name', '$phone', '$address', '$note','$id')");
            if($sql_addshipping){
              echo "<script>alert('Shipping Information Added Successfully')</script>";
          }
        }elseif(isset($_POST['updateshipping'])){
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $note = $_POST['note'];
            $id = $_SESSION['id'];
            $sql_updateshipping = mysqli_query($conn, "UPDATE shipping SET name = '$name', phone = '$phone', address = '$address', note = '$note' WHERE id = '$id'");
            if($sql_updateshipping){
              echo "<script>alert('Shipping Information Updated Successfully')</script>";
          }
        }
        ?>
        <div class = "row">
            <?php
            $id = $_SESSION['id'];
            $sql_get_shipping = mysqli_query($conn, "SELECT * FROM shipping WHERE id = '$id'LIMIT 1");
            $count = mysqli_num_rows($sql_get_shipping);
            if($count > 0){
                $row_get_shipping = mysqli_fetch_array($sql_get_shipping);
                $name = $row_get_shipping['name'];
                $phone = $row_get_shipping['phone'];
                $address = $row_get_shipping['address'];
                $note = $row_get_shipping['note'];
            }else{
                $name = '';
                $phone = '';
                $address = '';
                $note = '';
            }
            ?>
            <div class = "col-md-12">
                <form action="" autocomplete="off" method="POST">
                <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name?> " placeholder="your name">
                </div>
                <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $phone?> " placeholder="...">
                </div>
                <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" class="form-control" value="<?php echo $address?> " placeholder="...">
                </div>
                <div class="form-group">
                <label for="name">Note:</label>
                <input type="text" name="note" class="form-control" value="<?php echo $note?> " placeholder="...">
                </div>
                <?php
                if($name=='' && $phone ==''){
                ?>
                <button type="submit" name = "addshipping" class="btn btn-primary">Add Shipping</button>
                <?php
                }elseif($name!='' && $phone !=''){
                ?>
                <button type="submit" name = "updateshipping" class="btn btn-success">Update Shipping</button>
                <?php
                }
                ?>
                </form>
            </div> 
        </div>
        
    </header>

<!---------------- Cart  ---------------->
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
    <a href='payinfor.php' class='checkout btn' style="width:30%; background-color:green;">Payment</a>
  </div>
</div>


</body>
<!---------------- Footer ---------------->    
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/glide.min.js"></script>
<script src="./js/slider.js"></script>
<script src="./js/index.js"></script>

</html>