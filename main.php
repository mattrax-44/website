<?php
require 'functions.php';
require_once 'vendor/autoload.php'; // Ensure Composer's autoloader is included

// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if admin is logged in
$is_admin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// Retrieve the search query from the URL (form submission)
$search_query = isset($_GET['query']) ? trim($_GET['query']) : '';

// Initialize the products array
$products = [];

if ($search_query !== '') {
    // If there's a search query, fetch products based on PartName or PartCode
    $mysqli = dbConnect();
    if ($mysqli) {
        $stmt = $mysqli->prepare("
            SELECT * 
            FROM catalog 
            WHERE PartName LIKE ? 
            OR PartCode LIKE ?
            LIMIT 10
        ");
        
        $like_query = '%' . $search_query . '%';
        $stmt->bind_param('ss', $like_query, $like_query);
        $stmt->execute();
        
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
} else {
    // No search query, show all products
    $products = getCatalogProducts(10);  // Adjust limit if needed
}

// Set up Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates'); // Path to the templates folder
$twig = new \Twig\Environment($loader, [
    'cache' => false, // Disable cache for development
]);

// Render the template with the products and search query data
echo $twig->render('main.twig', [
    'products' => $products,
    'is_admin' => $is_admin,
    'search_query' => $search_query
]);
?>
