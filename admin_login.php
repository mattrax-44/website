<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $admin_username = 'admin';
    $admin_password = 'password123';

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: Catalog.php');
    } else {
        echo "Invalid credentials.";
    }
}
?>
