<?php
include '../config.php';

session_start();

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Box icons -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"
    />
     <!-- Bootstrap icon -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="../css/styles.css" />
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
                    
                    
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <?php 
                                if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                                    echo $_SESSION['username'];
                                }
                                else {
                                    echo "";
                                }
                                  ?>
                        </a>
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
                    <?php
                    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                      echo '<a href="../logout.php" class="icon">
                      <i class="bx bx-log-out"></i> </a>';
                    }
                    else {
                        echo ' ';
                    }
                    ?>
                    
                </div>

                <div class="hamburger">
                    <i class="bx bx-menu-alt-left"></i>
                </div>
            </div>
        </div>

    <!-- Product Details -->
    <?php
            $productId = 14; // Set the product ID you want to fetch
            $select_query = mysqli_query($conn, "SELECT * FROM products WHERE idProduct = $productId");
            $product = mysqli_fetch_assoc($select_query);
            
          ?>
    <section class="section product-detail">
      <div class="details container">
        <div class="left image-container">
          <div class="main">

            <img src="../<?php echo $product['image']; ?>" id="zoom" alt="">
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
          <form class="form">
            <input type="text" placeholder="1" />
            <a href="cart.html" class="addCart" >Add To Cart</a>
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
        <a href="#" class="view-more">View more</a>
      </div>
      <div class="product-center container">
        <?php
            $select_query = mysqli_query($conn, "SELECT * FROM products");
            if(mysqli_num_rows($select_query)>0) {
                while($fetch_product = mysqli_fetch_assoc($select_query)){
                  ?>
          <div class="product-item">
            <div class="overlay">
              <a href="productDetails.html" class="product-thumb">
                <img src="../<?php echo $fetch_product['image'] ?>" alt="" />
              </a>
              <span class="discount">40%</span>
            </div>
            <div class="product-info">
          
            
            <span><?php echo $fetch_product['category'] ?></span>
            <form action="" method="post" class="form-submit">
              <a href="productDetails.html"><?php echo $fetch_product['name'] ?></a>
              <h4>$<?php echo $fetch_product['price'] ?></h4>

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
    <script
      src="https://code.jquery.com/jquery-3.4.0.min.js"
      integrity="sha384-JUMjoW8OzDJw4oFpWIB2Bu/c6768ObEthBMVSiIx4ruBIEdyNSUQAjJNFqT5pnJ6"
      crossorigin="anonymous"
    ></script>
    <script src="./js/zoomsl.min.js"></script>
    <script>
      $(function () {
        console.log("hello");
        $("#zoom").imagezoomsl({
          zoomrange: [4, 4],
        });
      });
    </script>
  </body>
</html>
