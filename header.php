<?php
require 'functions.php';
require_once 'vendor/autoload.php'; // Make sure Composer's autoloader is included

// Set up Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false, // Disable cache for development
]);

// Render the header template
echo $twig->render('header.twig');
?>
