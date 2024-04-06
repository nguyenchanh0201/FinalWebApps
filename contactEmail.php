<?php
include 'config.php'; 
$email = $_POST['email'];
// Check if email exists or not, if exist don't do anything
$check = "SELECT * FROM contactEmail WHERE email = '$email'";
$result = $conn->query($check);
if ($result->num_rows > 0) {
    header('Location: index.php');
    exit();
}
// If email does not exist, insert into database
$sql = "INSERT INTO contactEmail (email) VALUES ('$email')";

if ($conn->query($sql) === TRUE) {
    header('Location: index.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>