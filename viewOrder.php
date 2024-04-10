<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: loginAdmin.html');
    exit;
}



include 'config.php';



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-top: 50px;
        }

        nav {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        ul {
            list-style-type: none;
            display: flex;
            justify-content: space-between;
            width: 50%;
        }

        li {
            background-color: #333;
            color: #fff;
            padding: 15px 20px;
            border-radius: 5px;
        }

        li a {
            color: #fff;
            text-decoration: none;
        }

        li:hover {
            background-color: #666;
        }

        .product-container,
        .add-container,
        .order-container
         {
            width: 1000px;
            margin: 50px auto;
        }

        img {
            width: 50%;
            /* Adjust this value to make the image smaller or larger */
            height: auto;
            /* This will maintain the aspect ratio of the image */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        .add_product {
            display: flex;
            flex-direction: column;
            width: 50%;
            margin: 0 auto;
        }

        .input_fields {
            margin-bottom: 20px;
            padding: 10px;
            font-size: 16px;
        }

        .heading {
            text-align: center;
            color: #333;
        }
    </style>
</head>

<body>
<h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
    <nav>
        <ul>
            <li>
                <a href="editProduct.php" class="nav-link">View Product</a>
            </li>
            <li>
                <a href="viewCustomer.php" class="nav-link">View Customers</a>
            </li>
            <li>
                <a href="viewProfit.php" class="nav-link">View Profit</a>
            </li>
        </ul>
    </nav>

    <div class="order-container">
        <table>
            <thead>
                <th>SL No</th>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Phone Number</th>
                <th>Order Date</th>
                <th>Order Status</th>
                <th>Payment Method</th>
                <th>Total</th>
                <th>Action</th>
            </thead>
            <tbody>
                <!-- php code -->
                <?php
                $display_order = mysqli_query($conn, "SELECT * FROM `order`");
                $num = 1;
                if (mysqli_num_rows($display_order) > 0) {
                    while ($row = mysqli_fetch_assoc($display_order)) {
                ?>
                        <tr>
                            <td><?php echo $num ?></td>
                            <td><?php echo $row['id_cart'] ?></td>
                            <td>
                                <?php
                                //Get customer name from id , linked shipping table
                                $customer_id = $row['id'];
                                $customer_query = mysqli_query($conn, "SELECT * FROM shipping WHERE id = '$customer_id'");
                                $customer_row = mysqli_fetch_assoc($customer_query);
                                echo $customer_row['name'];
                                ?>
                            </td>
                            <td>
                                <?php echo $customer_row['phone'] ?>
                            </td>
                            <td>
                                <?php echo $row['cart_date'] ?>
                            </td>
                            <td>
                                <?php
                                if ($row['cart_status'] == 1)
                                    echo "Success";
                                ?>
                            </td>
                            <td>
                                <?php echo $row['cart_payment']; ?>
                            </td>
                            <td>
                                $<?php echo $row['total'] ?>
                            </td>
                            <td>
                                <form action="" method="post">
                                    <button type="submit" style="border:none; background-color:white;" name="see_details">
                                        <a href="" class="view-order">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </button>
                                    <input type="hidden" name="id_order" value="<?php echo $row['id_cart'] ?>">
                                </form>
                            </td>
                        </tr>
                <?php
                        $num++;
                    }
                } else {
                    echo "<td> </td>
                <td> </td>
                <td>No products found</td>";
                }
                ?>
        </table>

    </div>

    <div class="order-container">
      <section class="display_product">
          <h1 style="text-align: center; margin-top: 20px;">Order Details</h1>
          <table>
            <thead>
              <th>SL No</th>
              <th>Product Name</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Image</th>
            </thead>
            <tbody>
              <!-- php code -->
              <?php
              
              if (isset($_POST['see_details'])) {
                $id_order = $_POST['id_order'];
                $display_order_details = mysqli_query($conn, "SELECT * FROM order_details WHERE order_id = '$id_order'");
              
              
              
              $num = 1;
              if (mysqli_num_rows($display_order_details) > 0) {
                while ($row = mysqli_fetch_assoc($display_order_details)) {
              ?>
                  <tr>
                    <td><?php echo $num ?></td>
                    <td>
                      <?php
                        $productId = $row['id_product'];
                        $productQuery = mysqli_query($conn, "SELECT name FROM products WHERE idProduct = '$productId'");
                        $productRow = mysqli_fetch_assoc($productQuery);
                        echo $productRow['name'];
                      ?>
                    </td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td>$<?php echo $row['price']; ?></td>
                    <td><img src="<?php echo $row['image']; ?>" alt="product image"></td>
                  </tr>
              <?php
                  $num++;
                }

              }
               else {
                echo "
                        <td> </td>
                        <td> </td>
                        <td>No products found</td>";
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
        

      </section>

    </div>


</body>





</html>