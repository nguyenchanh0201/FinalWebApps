<?php 
	include('../config.php');
	$now = date('Y-m-d H:i:s');
  session_start();

  if(isset($_GET['partnerCode'])){
		$id = $_SESSION['id'];
		$code_order = rand(0,9999);
		$partnerCode = $_GET['partnerCode'];
		$orderId = $_GET['orderId'];
		$amount = $_GET['amount'];
		$orderInfo = $_GET['orderInfo'];
		$orderType = $_GET['orderType'];
		$transId = $_GET['transId'];
		$payType = $_GET['payType'];
		$cart_payment = 'momo';

    $sql_get_shipping = mysqli_query($conn, "SELECT * FROM shipping WHERE id = '$id' LIMIT 1");
    $row_get_shipping = mysqli_fetch_array($sql_get_shipping);
    $id_shipping = $row_get_shipping['id_shipping'];

    
    

    

    $insert_momo = "INSERT INTO `momo` (partner_code, order_id, amount, order_info,order_type,trans_id,pay_type,code_cart) VALUES ('".$partnerCode."','".$orderId."','".$amount."','".$orderInfo."','".$orderType."','".$transId."','".$payType."','".$code_order."')";
    $cart_query = mysqli_query($conn, $insert_momo);

    if($cart_query){
      $insert_cart = "INSERT INTO `order` (id, code_cart, cart_status, cart_date, cart_payment, cart_shipping, total) VALUES ('".$id."','".$code_order."',1,'".$now."','".$cart_payment."','".$id_shipping."','".$amount."')";
      $cart_query = mysqli_query($conn, $insert_cart);

      // Get the ID of the last inserted row in the `order` table
    $order_id = mysqli_insert_id($conn);

    // Insert into `order_details` using the order_id
    $insert_order_detail = "INSERT INTO order_details (order_id, id_product, quantity, price, image) SELECT '".$order_id."', id_product, quantity, price, image FROM cart WHERE id_user = '".$id."'";
    $order_detail_query = mysqli_query($conn, $insert_order_detail);
    //Clear the cart
    $delete_cart = "DELETE FROM cart WHERE id_user = '".$id."'";
    $cart_query = mysqli_query($conn, $delete_cart);
    
    if (!$order_detail_query) {
      echo "Error: " . $insert_order_detail . "<br>" . mysqli_error($conn);
  } else {
      header('Location: ../track_order.php');
  }
  
    echo '<h3>Payment transaction with MOMO successful</h3>';
    
    }else{
      echo 'Pay MoMo Failed';
    }
}
    
?>