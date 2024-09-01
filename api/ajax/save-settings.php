<?php
session_start();
header('Content-Type: application/json; charset=UTF8');
include('../class/include.php');
if (!isset($_SESSION['user_id'])){
    header("HTTP/1.1 500");
    die("Bad request");
}

$id = $_SESSION['user_id'];

$GLOBALS['DB']->Update('users', ['discord_id' => $id], [
    "notifications_authorization_discord" => $_POST['notifications_authorization_discord'],
    "confidentiality_public_profile" => $_POST['confidentiality_public_profile'],
    "confidentiality_profile_list_members" => $_POST['confidentiality_profile_list_members'],
    "confidentiality_visible_online" => $_POST['confidentiality_visible_online']
]);

echo json_encode("success");
?>