<?php

class Announces {
    public static function GetAnnouces() {
        $dateActuelle = time();

        $annonces = $GLOBALS['DB']->GetContent("announces");

        $annoncesRecentes = array();

        foreach ($annonces as $annonce) {
            $dateAnnonce = $annonce['expiration_date'];
            if(!$annonce['never']){
                if ($dateAnnonce > $dateActuelle) {
                    $annoncesRecentes[] = $annonce;
                }
            }else{
                $annoncesRecentes[] = $annonce;
            }
        }

        return $annoncesRecentes;
    }

    public static function GetAllAnnouces() {
        return $GLOBALS['DB']->GetContent("announces");
    }

    public static function AddAnnounce(
        $content, 
        $date, 
        $expire ){

        $expire = ($expire == "on") ? 1 : 0;

        try {
		    $GLOBALS['DB']->Insert("announces", [
                "content" => $content,
                "never" => $expire,
                "expiration_date" => $date
            ]);
            return "success";
        }catch (Exception $e){
            return "error".$e;
        }

    }

    public static function DeleteAnnounce($id){
        return $GLOBALS['DB']->Delete('announces', ['id' => $id]);
    }
}
