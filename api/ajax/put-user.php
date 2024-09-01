<?php
session_start();
header('Content-Type: application/json; charset=UTF8');
include('../class/include.php');
if (!isset($_SESSION['user_id'])){
    header("HTTP/1.1 500");
    die("Bad request");
}

if(!Account::IsAdmin()){
    header("HTTP/1.1 500");
    die("Bad request");
}

if($_GET['type'] == "banned"){
    echo json_encode(Account::Banned($_GET['id'], $_POST['reason']));
}

if($_GET['type'] == "unbanned"){
    echo json_encode(Account::UnBanned($_GET['id']));
}

?>