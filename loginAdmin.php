<?php
session_start(); // Start the session at the beginning
include 'config.php';

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = test_input($_POST["usernameAdmin"]);
    $password = test_input($_POST["password"]);
    $select_query = mysqli_query($conn, "SELECT * FROM admin");
    $users = mysqli_fetch_all($select_query, MYSQLI_ASSOC);

    foreach($users as $user) {
        if(($user['username'] == $username) && ($user['password'] == $password)) {
            $_SESSION['loggedinAdmin'] = true;
            $_SESSION['usernameAdmin'] = $username;
            header("location: adminpage.php");
            exit; // Ensure the script stops here
        }
    }

    // If we get here, no user was found
    echo "<script language='javascript'>";
    echo "alert('WRONG INFORMATION')";
    echo "</script>";
    die();
}
?>