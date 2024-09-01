<?php 

class SoundsHost {

    public static function GetSound($id){
        return $GLOBALS['DB']->GetContent('sounds_host', ['id' => $id])[0];
    }



    public static function CheckOwner($id){
        $getid = $GLOBALS['DB']->GetContent('sounds_host', ['id' => $id])[0];
        if($_SESSION['user_id'] == $getid['owner']){
            return "true";
            
        }else{
            return "false";
        }
        
    }

    public static function DeleteSound($id){
        return $GLOBALS['DB']->Delete('sounds_host', ['id' => $id]);
    }

    public static function AddSound(
        $title, 
        $description, 
        $code ){
        
        $date = time();

        $pushtitle = htmlspecialchars($title);
        $pushdesc = htmlspecialchars($description);
        $pushcode = $code;
        $user = $_SESSION['user_id'];

        try {
		    $GLOBALS['DB']->Insert("sounds_host", [
                "name" => $pushtitle,
                "description" => $pushdesc,
                "owner" => $user,
                "content" => $pushcode,
                "categorie" => 0,
                "creation_date" => $date
            ]);
            return "success";
        }catch (Exception $e){
            return "error".$e;
        }
    }

}