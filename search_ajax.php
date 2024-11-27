<?php
require 'functions.php';

// Retrieve the search query from the AJAX request
$query = isset($_GET['query']) ? trim($_GET['query']) : '';

// Initialize results array
$results = [];

if (!empty($query)) {
    $mysqli = dbConnect();
    if ($mysqli) {
        // Prepare SQL to search by PartName or PartCode
        $stmt = $mysqli->prepare("
            SELECT PartName, PartCode 
            FROM catalog 
            WHERE PartName LIKE ? 
            OR PartCode LIKE ? 
            LIMIT 10
        ");
        
        // Prepare the LIKE query
        $like_query = '%' . $query . '%';
        
        // Bind parameters to prevent SQL injection
        $stmt->bind_param('ss', $like_query, $like_query);
        $stmt->execute();
        
        // Fetch matching products
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
    }
}

// Generate the dropdown options
if (!empty($results)) {
    foreach ($results as $result) {
        // Display both PartName and PartCode as a suggestion
        echo '<div class="search-result-item">' . htmlspecialchars($result['PartName']) . ' (' . htmlspecialchars($result['PartCode']) . ')</div>';
    }
} else {
    echo '<div class="search-result-item">No products found</div>';
}
?>
