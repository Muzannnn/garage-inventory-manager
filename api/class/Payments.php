<?php

class Payments {
    public static function GetAllPayments(){
        return $GLOBALS['DB']->GetContent("payments");
    }

    public static function GetAllPaymentsPayed(){
        return $GLOBALS['DB']->GetContent("payments", ["status"=> "COMPLETE"]);
    }

    public static function EditPayment(
        $uniqid, 
        $status, 
        $updated_at ){

        try {
		    $GLOBALS['DB']->Update("payments", ['uniqid'=>$uniqid],[
                "status" => $status,
                "updated_at" => $updated_at
            ]);
            return "success";
        }catch (Exception $e){
            return "error".$e;
        }
    }

    public static function CreatePayment(
        $uniqid,
        $currency,
        $product_title,
        $gateway,
        $total,
        $status,
        $email,
        $discord_id,
        $updated_at,
        $created_at
    ){

        try {
		    $GLOBALS['DB']->Insert("payments", [
                "uniqid" => $uniqid, 
                "currency" => $currency, 
                "product_title" => $product_title,
                "gateway" => $gateway,
                "total" => $total,
                "status" => $status,
                "email" => $email, 
                "discord_id" => htmlspecialchars($discord_id), 
                "updated_at" => $updated_at, 
                "created_at" => $created_at
            ]);
            Logs::Add("createpayment", ["discord_id" => $discord_id]);
            return "success";
        }catch (Exception $e){
            return "error".$e;
        }
    }
}
