<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    die("Access denied.");
}

require 'functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $mysqli = dbConnect();

    if ($mysqli) {
        $stmt = $mysqli->prepare("DELETE FROM catalog WHERE id = ?");
        $stmt->bind_param('i', $product_id);

        if ($stmt->execute()) {
            echo "Product deleted successfully.";
        } else {
            echo "Failed to delete product.";
        }
    }
}
header('Location: Catalog.php'); // Redirect back to catalog
?>
