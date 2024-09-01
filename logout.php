<?php

include("api/class/include.php");
if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
}
session_destroy();
header("Location: index.php");

