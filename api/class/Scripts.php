<?php 

class Scripts {
    public static function GetScript($id){
        return $GLOBALS['DB']->GetContent('scripts', ['id' => $id])[0];
    }

    public static function GetCategorie($id){
        return $GLOBALS['DB']->GetContent('scripts_categories', ['id' => $id])[0];
    }

    public static function GetCategories(){
        return $GLOBALS['DB']->GetContent('scripts_categories');
    }

    public static function GetScriptsFromCategorie($id){
        return $GLOBALS['DB']->GetContent('scripts', ['categorie' => $id]);
    }

    public static function GetAdminScripts(){
        return $GLOBALS['DB']->GetContent('scripts', ['owner' => 0]);
    }

    public static function CheckOwner($id){
        $getid = $GLOBALS['DB']->GetContent('scripts', ['id' => $id])[0];
        if($_SESSION['user_id'] == $getid['owner']){
            return "true";
            
        }else{
            return "false";
        }
        
    }

    public static function CheckOwnerList($id){
        $getid = $GLOBALS['DB']->GetContent('scripts', ['owner' => $id])[0];
        if($_SESSION['user_id'] == $getid['owner']){
            return "true";
            
        }else{
            return "false";
        }
        
    }

    public static function DeleteScript($id){
        return $GLOBALS['DB']->Delete('scripts', ['id' => $id]);
    }

    public static function AddScript(
        $title, 
        $description, 
        $code ){
        
        $date = time();

        $pushtitle = htmlspecialchars($title);
        $pushdesc = htmlspecialchars($description);
        $pushcode = $code;
        $user = $_SESSION['user_id'];

        try {
		    $GLOBALS['DB']->Insert("scripts", [
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

    public static function AddAdminScript(
        $title, 
        $description, 
        $code,
        $categorie ){
        
        $date = time();

        $pushtitle = htmlspecialchars($title);
        $pushdesc = htmlspecialchars($description);
        $pushcode = $code;

        try {
		    $GLOBALS['DB']->Insert("scripts", [
                "name" => $pushtitle,
                "description" => $pushdesc,
                "owner" => 0,
                "content" => $pushcode,
                "categorie" => $categorie,
                "creation_date" => $date
            ]);
            return "success";
        }catch (Exception $e){
            return "error".$e;
        }
    }

    public static function EditAdminScript(
        $id,
        $title, 
        $description, 
        $code,
        $categorie ){
        
        $pushtitle = htmlspecialchars($title);
        $pushdesc = htmlspecialchars($description);
        $pushcode = $code;

        try {
            $GLOBALS['DB']->Update('scripts', ['id' => $id], [
                "name" => $pushtitle, 
                "description" => $pushdesc, 
                "categorie" => $categorie,
                "content" => $pushcode
            ]);
            return "success";
        }catch (Exception $e){
            return "error".$e;
        }
    }

    public static function EditScript(
        $id,
        $title, 
        $description, 
        $code ){
        
        $pushtitle = htmlspecialchars($title);
        $pushdesc = htmlspecialchars($description);
        $pushcode =$code;

        try {
            $GLOBALS['DB']->Update('scripts', ['id' => $id], [
                "name" => $pushtitle, 
                "description" => $pushdesc, 
                "content" => $pushcode
            ]);
            return "success";
        }catch (Exception $e){
            return "error".$e;
        }
    }
}