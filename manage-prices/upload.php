<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file'];

    // Check if the file is a valid CSV
    if ($file['type'] !== 'text/csv') {
        echo "Please upload a valid CSV file.";
        exit;
    }

    // Create a new filename with a timestamp
    $timestamp = date('YmdHis');
    $newFilename = "sample-$timestamp.csv";
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . $newFilename;

    // Create the uploads directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Move the uploaded file to the new location
    if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
        echo "File successfully uploaded as $newFilename.";
    } else {
        echo "There was an error uploading the file.";
    }
}
?>
