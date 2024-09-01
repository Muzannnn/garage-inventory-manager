<?php

require 'vendor/autoload.php';
include ('api/class/include.php');
if(Account::isAuthentified()){
    header('Location: dashboard.php');
}
?>
<!doctype html>
<html class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShadowAccess - Register</title>
    <link rel="stylesheet" href="style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap');
    </style>
    <?php include "api/head.php"; ?>
</head>

<body class="bg-gray-dark text-white font-sans h-full flex flex-col">



    <section class="p-1 lg:p-12 mt-auto mb-auto flex flex-col">
        <div class="flex gap-5 flex-col lg:flex-row justify-center mx-auto">
            <div class="p-6 bg-gray w-[20rem] lg:w-[25rem] rounded-[4px]">
                <div class="mb-3 flex gap-2 w-full">
                    <h1 class="mt-1 text-2xl text-center w-full">
                        ShadowAccess Register
                    </h1>
                </div>
                    <p class="mb-1">Username</p>
                    <input type="text" name="username"
                        class="pr-2 pl-2 pt-1 pb-1 w-full bg-gray-dark duration-300 text-white focus:outline-none font-normal"
                        id="username">
                    <p class="mb-1 mt-5">Password</p>
                    <input type="password" name="password"
                        class="pr-2 pl-2 pt-1 pb-1 w-full bg-gray-dark duration-300 text-white focus:outline-none font-normal"
                        id="password">
                    <p class="mb-1 mt-5">Repeat Password</p>
                    <input type="password" name="repeat_password"
                        class="pr-2 pl-2 pt-1 pb-1 w-full bg-gray-dark duration-300 text-white focus:outline-none font-normal"
                        id="repeat_password">
                    <button type="submit" onclick="register()"
                        class="mr-auto ml-auto w-full mt-[2rem] p-[0.6rem] w-[75%] mx-auto border-2 border-purple hover:bg-purple hover:border-purple-light rounded-[6px] duration-300">
                        Create account</button>
                    <p class="text-[.9rem] mt-3 text-center">You have already account ? <br><a href="#">Login</a></p>

            </div>

        </div>
    </section>

</body>
<?php include "api/bottom.php"; ?>
<script src="api/js/register.js"></script>

</html>