<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once __DIR__ . '/../Core/Branches.php';

//include_once 'Core/Branches.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file'];

    // Check if the file is a valid CSV
    if ($file['type'] !== 'text/csv') {
        echo "Please upload a valid CSV file.";
        exit;
    }

    // Create a new filename with a timestamp
    $timestamp = date('YmdHis');
    $newFilename = "prices-$timestamp.csv";
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . $newFilename;

    // Create the uploads directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Move the uploaded file to the new location
    if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
        echo "File successfully uploaded as $newFilename.<br>";
        echo "Extracting $newFilename.<br>";

        if (($handle = fopen($uploadFile, "r")) !== FALSE) {
            $header = fgetcsv($handle, 1000, ","); // Assumes the first row is the header

            $csvHandler = new Branches();

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $regionName = $data[array_search('Region', $header)];
                $size = $data[array_search('Size', $header)];
                $newPrice = $data[array_search('Price', $header)];

                // Log the values for debugging
                error_log("Updating prices for Region: $regionName, Size: $size, New Price: $newPrice");

                // Update in the DB
                $csvHandler->updateAllPricesByRegion($regionName, $size, $newPrice);
            }
            fclose($handle);
        }

    } else {
        echo "There was an error uploading the file.";
    }
}

header('Location: price.php');
die();
