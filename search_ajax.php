<?php
require 'functions.php';
require_once 'vendor/autoload.php'; // Ensure Composer's autoloader is included

// Set up Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates'); // Path to the templates folder
$twig = new \Twig\Environment($loader, [
    'cache' => false, // Set to 'false' for development or provide a cache directory for production
]);

// Retrieve the search query from the AJAX request
$query = isset($_GET['query']) ? trim($_GET['query']) : '';

// Initialize results array
$results = [];

// Perform the search if the query is not empty
if (!empty($query)) {
    $mysqli = dbConnect();
    if ($mysqli) {
        // Prepare SQL to search by PartName or PartCode
        $stmt = $mysqli->prepare("
            SELECT ID, PartName, PartCode 
            FROM catalog 
            WHERE PartName LIKE ? 
            OR PartCode LIKE ? 
            LIMIT 10
        ");
        
        $like_query = '%' . $query . '%';
        $stmt->bind_param('ss', $like_query, $like_query);
        $stmt->execute();
        
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
    }
}

// Render the results using Twig
echo $twig->render('search_results.twig', [
    'results' => $results
]);
?>
