<?php

include_once 'Core/Branches.php';

$branches = new Branches();

if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    $branches->deleteBranch($id);

    header('Location: /');
}