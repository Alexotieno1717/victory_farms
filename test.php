<?php
session_start();

include_once 'Core/Branches.php';

$branchData = new Branches();
$branches = $branchData->getRegions();

// Display the data in JSON format
var_dump($branches);
