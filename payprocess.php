<?php
    session_start();
    include('config.php');
    
    $now = date('Y-m-d H:i:s');
    $id = $_SESSION['id'];
    $code_order = rand(0,9999);
    $cart_payment= $_POST['payment'];

    $sql_get_shipping = mysqli_query($conn, "SELECT * FROM shipping WHERE id = '$id' LIMIT 1");
    $row_get_shipping = mysqli_fetch_array($sql_get_shipping);

    $id_shipping = $row_get_shipping['id_shipping'];

    // Insert into `order` without id_details
    $insert_cart = "INSERT INTO `order` (id, code_cart, cart_status, cart_date, cart_payment, cart_shipping) VALUES ('".$id."','".$code_order."',1,'".$now."','".$cart_payment."','".$id_shipping."')";
    $cart_query = mysqli_query($conn, $insert_cart);

    // Get the ID of the last inserted row in the `order` table
    $order_id = mysqli_insert_id($conn);

    // Insert into `order_details` using the order_id
    $insert_order_detail = "INSERT INTO order_details (order_id, id_product, quantity, price, image) SELECT '".$order_id."', id_product, quantity, price, image FROM cart WHERE id_user = '".$id."'";
    $order_detail_query = mysqli_query($conn, $insert_order_detail);

    // Get the ID of the last inserted row in the `order_details` table
    $order_details_id = mysqli_insert_id($conn);

    // Update the `order` table with the id_details
    $update_order = "UPDATE `order` SET id_details = '".$order_details_id."' WHERE id_Cart = '".$order_id."'";
    $update_query = mysqli_query($conn, $update_order);

    if (!$update_query) {
        echo "Error: " . mysqli_error($conn);
    }
?>