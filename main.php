<?php
require 'functions.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start a new session only if none is active
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

?>

<div class="left">
    <div class="section-title">Products</div>
    <a href="">Parts</a>
</div>

<div class="right">
    <div class="section-title">Search Results</div>

    <?php
    if (!empty($products)) {
        foreach ($products as $product) {
    ?>
    <div class="product-item">
        <div class="product-right">
            <img src="<?php echo htmlspecialchars($product['PartImage']); ?>" alt="Part Image">
        </div>

        <div class="product-left">
            <p class="product-right">
                <a href=""><?php echo htmlspecialchars($product['PartName']); ?></a>
            </p>
            <p class="PartCode">Code: <?php echo htmlspecialchars($product['PartCode']); ?></p>
            
            <?php if ($is_admin): ?>
            <div class="admin-actions">
                <!-- Delete Form -->
                <form method="POST" action="delete_product.php" style="display:inline;">
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                    <button type="submit" class="delete-button">Delete</button>
                </form>

                <!-- Edit Button -->
                <a href="edit_product.php?id=<?php echo htmlspecialchars($product['id']); ?>" class="edit-button">Edit</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
        }
    } else {
        echo "<p>No products found.</p>";
    }
    ?>
</div>
