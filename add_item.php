<?php
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $PartName = isset($_POST['PartName']) ? trim($_POST['PartName']) : '';
    $PartCode = isset($_POST['PartCode']) ? trim($_POST['PartCode']) : '';
    $PartImage = isset($_POST['PartImage']) ? trim($_POST['PartImage']) : '';

    if (!empty($PartName) && !empty($PartCode) && !empty($PartImage)) {
        $mysqli = dbConnect();
        if ($mysqli) {
            $stmt = $mysqli->prepare("
                INSERT INTO catalog (PartName, PartCode, PartImage) 
                VALUES (?, ?, ?)
            ");
            $stmt->bind_param('sss', $PartName, $PartCode, $PartImage);
            $stmt->execute();
            $stmt->close();
            $mysqli->close();
            header('Location: catalog.php?message=Item added successfully');
            exit;
        } else {
            echo "Database connection failed.";
        }
    } else {
        echo "All fields are required.";
    }
}
?>
