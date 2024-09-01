<?php
session_start();
header('Content-Type: application/json; charset=UTF8');
include('../class/include.php');
if (!isset($_SESSION['user_id'])){
    header("HTTP/1.1 500");
    die("Bad request");
}

if(Scripts::CheckOwner($_GET['id']) == "false"){
    header("HTTP/1.1 500");
    die("Bad request");
}

echo json_encode(Scripts::EditScript($_GET['id'], $_POST['title'], $_POST['description'], $_POST['code']));
?>