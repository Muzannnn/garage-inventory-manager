<?php 

class Logs {
    public static function Add($type, $encodedata){

        $data = $encodedata;

        $timestamp = date("c", strtotime("now"));
        if($type == "newuser"){
            $webhook = $GLOBALS['userslogs_webhook'];
            $json_data = json_encode([
                "embeds" => [
                    [
                        "title" => "L'utilisateur " . $data['username'] . " vient de créer un compte.",
                    
                        "type" => "rich",
                    
                        "timestamp" => $timestamp,
                    
                        "color" => hexdec( "3366ff" ),
                    ]
                ]

            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        }elseif($type == "failnewuser"){
            $webhook = $GLOBALS['userslogs_webhook'];
            $json_data = json_encode([
                "embeds" => [
                    [
                        "title" => "L'utilisateur ". $data['username'] ." a essayé de créer un compte en mode dev.",
                        "type" => "rich",
                        "color" => hexdec( "FF0000" ),
                    ]
                ]

            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        }elseif($type == "keydetect"){
            $webhook = $GLOBALS['userslogs_webhook'];
            $json_data = json_encode([
                "embeds" => [
                    [
                        "title" => "L'utilisateur " . Account::GetUsername() . " (" . Account::GetGlobalName() . ") vient d'appuyer sur la touche " . $data['key'],
                        "type" => "rich",
                        "color" => hexdec( "3366ff" ),
                    ]
                ]
                        
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        }elseif($type == "loginuser"){
            $webhook = $GLOBALS['userslogs_webhook'];
            $json_data = json_encode([
                "embeds" => [
                    [
                        "title" => "L'utilisateur " . $data['username'] . " vient de connecter.",
                    
                        "type" => "rich",
                    
                        "timestamp" => $timestamp,
                    
                        "color" => hexdec( "4aff00" ),
                    ]
                ]
                        
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        }elseif($type == "logoutuser"){
            $webhook = $GLOBALS['userslogs_webhook'];
            $json_data = json_encode([
                "embeds" => [
                    [
                        "title" => "L'utilisateur " . $data['username'] . " vient de déconnecté.",
                    
                        "type" => "rich",
                    
                        "timestamp" => $timestamp,
                    
                        "color" => hexdec( "3366ff" ),
                    ]
                ]
                        
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        }elseif($type == "createserver"){
            $webhook = $GLOBALS['serverslogs_webhook'];
            $json_data = json_encode([
                "embeds" => [
                    [
                        "title" => "L'utilisateur " . Account::GetUserByFuckKey($data['owner'])['username'] . " vient d'avoir un nouveau serveur de connecté.",
                    
                        "type" => "rich",
                    
                        "timestamp" => $timestamp,
                    
                        "color" => hexdec( "4aff00" ),
                    ]
                ]
                        
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        }elseif($type == "createpayment"){
            $webhook = $GLOBALS['payments_webhook'];
            $json_data = json_encode([
                "embeds" => [
                    [
                        "title" => "L'utilisateur " . Account::GetUsername($data['discord_id']) . " vient de faire un payement.",
                    
                        "type" => "rich",
                    
                        "timestamp" => $timestamp,
                    
                        "color" => hexdec( "4aff00" ),
                    ]
                ]
                        
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        }else{
            return "error";
        }

        


        $ch = curl_init( $webhook );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec( $ch );
        // If you need to debug, or find out why you can't send message uncomment line below, and execute script.
        // echo $response;
        curl_close( $ch );
    }

}