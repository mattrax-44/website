<?php
session_start(); 
$is_admin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true; // Check if admin is logged in
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="We have a wide collection of car parts">
    <meta name="keywords" content="engine, parts, panels">
    <link rel="stylesheet" href="styles.css">
    <title>Our Catalog</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include "nav.php"; ?>

    <!-- Admin Login Button -->
    <button id="admin-login-button">
        <?php echo $is_admin ? "Logout" : "Admin Login"; ?>
    </button>

    <!-- Admin Login Popup -->
    <div id="admin-login-popup" class="popup">
        <div class="popup-content">
            <span id="close-popup">&times;</span>
            <h2>Admin Login</h2>
            <form id="admin-login-form" method="POST" action="admin_login.php">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

    <!-- Search Form -->
    <form method="GET" action="catalog.php" class="search-form">
        <input type="text" name="query" id="search-input" placeholder="Search for products..." autocomplete="off"
               value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Add New Item Button -->
    <?php if ($is_admin): ?>
        <button id="add-item-button">Add New Item</button>
    <?php endif; ?>

    <!-- Add New Item Modal -->
    <div id="add-item-modal">
        <h3>Add New Item</h3>
        <form id="add-item-form" method="POST" action="add_item.php">
            <label for="PartName">Part Name:</label>
            <input type="text" id="PartName" name="PartName" required><br><br>
            
            <label for="PartCode">Part Code:</label>
            <input type="text" id="PartCode" name="PartCode" required><br><br>
            
            <label for="PartImage">Part Image:</label>
            <input type="text" id="PartImage" name="PartImage" required><br><br>
            
            <button type="submit">Add Item</button>
            <button type="button" id="close-modal">Cancel</button>
        </form>
    </div>

    <!-- Modal Background -->
    <div id="modal-bg"></div>

    <!-- Dynamic Results Container -->
    <div id="search-results"></div>

    <main>
        <?php include "main.php"; ?>
    </main>

    <?php include "footer.php"; ?>

    <script>
        $(document).ready(function () {
            // When typing in the search input, show suggestions
            $('#search-input').on('input', function () {
                const query = $(this).val();
                if (query.length > 0) {
                    $.ajax({
                        url: 'search_ajax.php',
                        method: 'GET',
                        data: { query: query },
                        success: function (response) {
                            $('#search-results').html(response).show();
                        }
                    });
                } else {
                    $('#search-results').hide();
                }
            });

            // When a search result is clicked, populate the input field and hidden inputs
            $(document).on('click', '.search-result-item', function () {
                const selectedProduct = $(this).text();  // Get selected item text
                const partCode = $(this).data('partcode');  // Get the associated PartCode
                
                $('#search-input').val(selectedProduct);  // Set it in the search input field
                $('#PartCode').val(partCode);  // Set the PartCode in the hidden input field
                $('#search-results').hide();  // Hide the dropdown
            });

            // Hide the results if clicking outside the form
            $(document).click(function (e) {
                if (!$(e.target).closest('.search-form').length) {
                    $('#search-results').hide();
                }
            });

            // Admin login button logic
            $('#admin-login-button').on('click', function () {
                <?php if ($is_admin): ?>
                    window.location.href = 'logout.php';
                <?php else: ?>
                    $('#admin-login-popup').show();
                <?php endif; ?>
            });

            // Close admin login popup
            $('#close-popup').on('click', function () {
                $('#admin-login-popup').hide();
            });

            // Add new item modal logic
            $('#add-item-button').on('click', function () {
                $('#add-item-modal').show();
                $('#modal-bg').show();
            });

            $('#close-modal').on('click', function () {
                $('#add-item-modal').hide();
                $('#modal-bg').hide();
            });

            $('#modal-bg').on('click', function () {
                $('#add-item-modal').hide();
                $('#modal-bg').hide();
            });
        });
    </script>
</body>
</html>
