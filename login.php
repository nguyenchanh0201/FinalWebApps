<?php
session_start();

//check if user is already logged in......

if (isset($_SESSION['username'])) {
    header("location: index.php");
    exit;
}

require_once "config.php";

$username = $password = "";
$username_err = $password_err = "";

//if request method is post


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
        $err = "Please enter username or password..";
    } else {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }
    
    if (empty($err)) {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;
        //Try to execute the statment
        if (mysqli_stmt_execute($stmt)) {
            //store result
            mysqli_stmt_store_result($stmt);
            //if username exists, verify password
            if (mysqli_stmt_num_rows($stmt) == 1) {
                //Bind result variables
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {
                        //this means password is correct, allow userLogin
                        session_start();
                        $_SESSION["username"] = $username;
                        $_SESSION["id"] = $id;
                        $_SESSION["loggedin"] = true;

                        //Redirect user to index page...
                        header("location: index.php");
                        
                    } else {
                        echo "Wrong username or password , login with correct credentials";
                    }
                }
            }
        }
    }
}
