<?php
session_start();

include_once 'Core/Branches.php';

$branchData = new Branches();
$branches = $branchData->getPriceList();

// Display the data in JSON format
header('Content-Type: application/json');
echo json_encode($branches);
