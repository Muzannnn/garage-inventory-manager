<?php
header('Content-Type: application/json; charset=UTF8');
include ('../class/include.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;
    if (!empty($username) && !empty($password)) {
        if (Account::IsUserExistByUsername($username)) {
            $id = Account::GetUserByUsername($username)["id"];
            if(Account::checkPassword($password, $id)) {
                Account::AuthUser($username);
                echo json_encode("success");
            }else{
                die("Your password or username is incorect");
            }
        } else {
            die("Your password or username is incorect");
        }

    } else {
        header("HTTP/1.1 500");
        die("Bad request");
    }
} else {
    header("HTTP/1.1 500");
    die("Bad request");
}
