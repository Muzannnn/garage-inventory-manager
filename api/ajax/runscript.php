<?php
session_start();
header('Content-Type: application/json; charset=UTF8');
include('../class/include.php');
if (!isset($_SESSION['user_id'])){
    header("HTTP/1.1 500");
    die("Bad request");
}
if(!Account::IsAdmin()){
    if(Servers::GetServer($_GET['id'])['fuck_key'] != Account::GetFuckKey()){
        header("HTTP/1.1 500");
        die("Bad request");
    }
}
if(Scripts::GetScript($_GET['script'])['categorie'] == 0){
    if(Scripts::CheckOwner($_GET['script']) == "false"){
        header("HTTP/1.1 500");
        die("Bad request");
    }
}

echo json_encode(Servers::RunCode($_GET['id'], Scripts::GetScript($_GET['script'])['content']), );
?>