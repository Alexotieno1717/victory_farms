<?php
require_once 'Core/Branches.php';

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
        echo "File successfully uploaded as $newFilename.";
        try {
            echo "Extracting $newFilename.";

            if (($handle = fopen($uploadFile, "r")) !== FALSE) {
                $header = fgetcsv($handle, 1000, ","); // Assumes the first row is the header
    
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $regionName = $data[array_search('Region', $header)];
                    $size = $data[array_search('Size', $header)];
                    $newPrice = $data[array_search('Price', $header)];

                    print( $regionName .', '. $size .', '. $newPrice). '\n';  
                    // Please update in the db


                    // $csvHandler = new Branches();
                    // $csvHandler->updateAllPricesByRegion( $regionName, $size, $newPrice);  
           
                }
                fclose($handle);
            }

        } catch (\Throwable $th) {
            throw $th;
        }

    } else {
        echo "There was an error uploading the file.";
    }
}
?>
