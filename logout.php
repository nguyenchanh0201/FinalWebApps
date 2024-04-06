<?php

session_start();
$_SESSION = array();
session_destroy();


// Check if the page that sent the logout signal is index.php
if (strpos($_SERVER['HTTP_REFERER'], 'index.php') !== false) {
    header("Location: index.php");

} if (strpos($_SERVER['HTTP_REFERER'], 'search.php') !== false) {
    header("Location: search.php");
} if (strpos($_SERVER['HTTP_REFERER'], 'cart.php') !== false) {
    header("Location: cart.php");
}
else if (strpos($_SERVER['HTTP_REFERER'], 'favorites.php') !== false) {
    header("Location: favorites.php");
} else if (strpos($_SERVER['HTTP_REFERER'], 'profile.php') !== false) {
    header("Location: index.php");


}
else if (strpos($_SERVER['HTTP_REFERER'], 'about.php') !== false) {
    header("Location: about.php");
}
 else {
    // If the logout signal was not from index.php, redirect to a different page
    header("Location: search.php");
}
