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
            header("Location: adminPage.php");
        }
        else {
            echo "Failed to delete";
            header("Location: adminPage.php");
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
    //Delete favorites item
    if (isset($_GET['delete_favorites'])) {
        $delete_id = $_GET['delete_favorites'];
        $delete_query = mysqli_query($conn, "DELETE FROM favorites WHERE id = '$delete_id'") or
        die("Query failed");
        if($delete_query){
            echo "Deleted successfully";
            header("Location: favorites.php");
        }
        else {
            echo "Failed to delete";
            
        }
    }

?>