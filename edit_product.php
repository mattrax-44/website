<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    die("Access denied.");
}

require 'functions.php';
$mysqli = dbConnect();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $stmt = $mysqli->prepare("SELECT * FROM catalog WHERE id = ?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $part_name = $_POST['PartName'];
    $part_code = $_POST['PartCode'];
    $part_image = $_POST['PartImage'];

    $stmt = $mysqli->prepare("UPDATE catalog SET PartName = ?, PartCode = ?, PartImage = ? WHERE id = ?");
    $stmt->bind_param('sssi', $part_name, $part_code, $part_image, $product_id);

    if ($stmt->execute()) {
        echo "Product updated successfully.";
    } else {
        echo "Failed to update product.";
    }

    header('Location: Catalog.php'); // Redirect back to catalog
}
?>

<form method="POST" action="edit_product.php">
    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
    <label>Part Name: <input type="text" name="PartName" value="<?php echo htmlspecialchars($product['PartName']); ?>"></label>
    <label>Part Code: <input type="text" name="PartCode" value="<?php echo htmlspecialchars($product['PartCode']); ?>"></label>
    <label>Part Image: <input type="text" name="PartImage" value="<?php echo htmlspecialchars($product['PartImage']); ?>"></label>
    <button type="submit">Update</button>
</form>
