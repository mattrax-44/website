<?php

require "config.php";

if (!function_exists('dbConnect')) {
    function dbConnect(){
        // Use constants from config.php instead of undefined variables
        $mysqli = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);

        if ($mysqli->connect_errno != 0) {
            return FALSE; // Connection failed
        } else {
            return $mysqli; // Connection successful
        }
    }
}

if (!function_exists('getCatalogProducts')) {
    function getCatalogProducts($int){
        $mysqli = dbConnect();

        if (!$mysqli) {
            return FALSE; // Database connection failed
        }

        $query = "SELECT * FROM catalog ORDER BY rand() LIMIT $int";
        $result = $mysqli->query($query);

        if (!$result) {
            return FALSE; // Query failed
        }

        $data = []; // Initialize $data as an empty array
        while ($row = $result->fetch_assoc()) {
            $data[] = $row; // Populate $data with the result rows
        }

        return $data; // Return the populated $data array
    }
}
