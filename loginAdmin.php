<?php
include_once('config.php');
  
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);
    $stmt = $conn->prepare("SELECT * FROM admin");
    $stmt->execute();
    $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
     
    $loginSuccessful = false; // Flag variable to track successful login
    
    foreach($users as $user) {
        if(($user['username'] == $username) && ($user['password'] == $password)) {
            $loginSuccessful = true;
            break; // Exit the loop if successful login is found
        }
    }
    
    if ($loginSuccessful) {
        header("location: adminpage.php");
        session_start();
        $_SESSION['loggedin'] = true ;
        $_SESSION['username'] = $username;
        exit();
    } else {
        // Redirect to loginAdmin.html if login information is incorrect
        header("location: loginAdmin.html");
        exit();
    }
}
?>