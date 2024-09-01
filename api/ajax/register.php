<?php
session_start();
header('Content-Type: application/json; charset=UTF8');
include ('../class/include.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;
    if (!empty($username) && !empty($password)) {
        if (!Account::IsUserExistByUsername($username)) {
            try {
                Account::CreateUser(
                    htmlspecialchars($username),
                    $password,
                );
                echo json_encode("success");
            } catch (Exception $e) {
                header("HTTP/1.1 500");
                die("Bad request");
            }
        } else {
            die("This username is already used");
        }

    } else {
        header("HTTP/1.1 500");
        die("Bad request");
    }
} else {
    header("HTTP/1.1 500");
    die("Bad request");
}