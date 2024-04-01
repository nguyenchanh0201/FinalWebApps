<!-- delete logic  -->

<!-- php code -->
<?php 
    include 'config.php';
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
?>