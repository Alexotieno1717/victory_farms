<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once __DIR__ . '/../Core/Branches.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file'];

    // Check if the file is a valid CSV
    if ($file['type'] !== 'text/csv') {
        header('Location: /price.php?status=error&message=' . urlencode("Please upload a valid CSV file."));
        exit;
    }

    // Create a new filename with a timestamp
    $timestamp = date('YmdHis');
    $newFilename = "prices-$timestamp.csv";
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . $newFilename;


    // Create the uploads directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            die('Failed to create upload directory');
        } else {
            // Change permissions in case mkdir doesn't set it as expected
            chmod($uploadDir, 0777);
        }
    }
    

    // Move the uploaded file to the new location
    if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
        $message = "File successfully uploaded as $newFilename.";
        $status = 'success';

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
                $updateStatus = $csvHandler->updateAllPricesByRegion($regionName, $size, $newPrice);

                if ($updateStatus['code'] !== 'success') {
                    $message = $updateStatus['message'];
                    $status = 'error';
                    break;
                }
            }
            fclose($handle);
            if ($status === 'success') {
                $message = $updateStatus['message'];
            } else{
                $message = $updateStatus['message'];

            }
        } else {
            $message .= " There was an error EXTRACTING the file.";
            $status = 'error';
        }

    } else {
        $message = "There was an error uploading the file.";
        $status = 'error';
    }

    header('Location: ../price.php?status=' . $status . '&message=' . urlencode($message));
    exit;
}

header('Location: ../price.php');
exit;
?>
