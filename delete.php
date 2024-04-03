<!-- delete logic  -->

<!-- php code -->
<?php 
    include 'config.php';
    //Delete products
    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        $delete_query = mysqli_query($conn, "DELETE FROM products WHERE idProduct = '$delete_id'") or
        die("Query failed");
        if($delete_query){
            echo "Deleted successfully";
            header("Location: viewProduct.php");
        }
        else {
            echo "Failed to delete";
            header("Location: viewProduct.php");
        }
    }
    //Delete cart item
    if (isset($_GET['delete_cart'])) {
        $delete_id = $_GET['delete_cart'];
        $delete_query = mysqli_query($conn, "DELETE FROM cart WHERE id = '$delete_id'") or
        die("Query failed");
        if($delete_query){
            echo "Deleted successfully";
            header("Location: cart.php");
        }
        else {
            echo "Failed to delete";
            
        }
    }

?>