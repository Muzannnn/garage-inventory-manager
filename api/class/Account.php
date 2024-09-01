<?php

use Bcrypt\Bcrypt;
/**
 * Summary of Account
 */
class Account {

    private static function reloadString($length = 100) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZs';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private static function encryptPassword($password) {
        $bcrypt = new Bcrypt();
        return $bcrypt->encrypt($password,"2a");
    }

    public static function checkPassword($password, $user) {
        $passwordtocheck = Account::GetPassword($user);
        $bcrypt = new Bcrypt();
        if($bcrypt->verify($password, $passwordtocheck)){
            return true;
        }else{
            return false;
        }
    }


    public static function CreateUser(
        $username, 
        $password){
        
        $date = time();

        $avatar = "";

        $fuck_key = Account::reloadString(15);

        $encrypted_password = Account::encryptPassword($password);

        try {
		    $GLOBALS['DB']->Insert("users", [
                "username" => $username, 
                "password" => $encrypted_password, 
                "role" => 0, 
                "offer" => 0, 
                "ban" => 0, 
                "avatar" => $avatar, 
                "fuck_key" => $fuck_key,
                "last_login_date" => $date, 
                "creation_date" => $date
            ]);
            return "success";
        }catch (Exception $e){
            return "error".$e;
        }
    }

    public static function AuthUser(
        $username){

        $date = time();
        $id = Account::GetUserByUsername($username)["id"];
        try {
            
            $GLOBALS['DB']->Update('users', ['id' => $id], [
                "last_login_date" => $date
            ]);
            $_SESSION['id'] = $id;
        }catch (Exception $e) {
            return "error";
        }
    }

    public static function IsUserExist($id){
        if ($GLOBALS['DB']->Count("users", ["id" => $id]) != 0)
        {
            return true;
        }else{
            return false;
        }
        
    }

    public static function IsUserExistByUsername($username){
        if ($GLOBALS['DB']->Count("users", ["username" => $username]) != 0)
        {
            return true;
        }else{
            return false;
        }
        
    }

    public static function PassToIdTime($user_id){
        
        return $GLOBALS['DB']->Update('users', ['discord_id' => $user_id], ['role' => '12']);
    }

    public static function GetUser($user_id = null){
        if ($user_id == null)
        {
            $user_id = $_SESSION['id'];    
        }
        
        return $GLOBALS['DB']->GetContent('users', ['id' => $user_id])[0];
    }

    public static function GetUserByFuckKey($fuck_key = null){
        if ($fuck_key == null)
        {
            return [];
        }

        return $GLOBALS['DB']->GetContent('users', ['fuck_key' => $fuck_key])[0];
    }

    public static function GetUserByUsername($username){
        return $GLOBALS['DB']->GetContent('users', ['username' => $username])[0];
    }
    
    public static function GetPassword($id = null){
        if ($id == null)
        {
            $id = $_SESSION['id'];
        }
        return Account::GetUser($id)['password'];
    }

    public static function GetUsername($id = null){
        if ($id == null)
        {
            $id = $_SESSION['id'];
        }
        return Account::GetUser($id)['username'];
    }

    public static function GetAvatar($id = null){
        if ($id == null)
        {
            $id = $_SESSION['id'];
        }
        return Account::GetUser($id)['avatar'];
    }

    public static function GetCreationDate($id = null){
        if ($id == null)
        {
            $id = $_SESSION['id'];
        }
        return Account::GetUser($id)['creation_date'];
    }

    public static function GetRole($id = null){
        if ($id == null)
        {
            $id = $_SESSION['id'];
        }
        return Account::GetUser($id)['role'];
    }
    
    public static function VisibleOnline(){
        if(Account::GetUser($_SESSION['id'])['confidentiality_visible_online'] == 1){
            return true;
        }else{
            return false;
        }
    }

    public static function NotifsDiscord($discord_id){
        if(Account::GetUser($discord_id)['notifications_authorization_discord'] == 1){
            return true;
        }else{
            return false;
        }
    }

    public static function IsAdmin($user_id = null){
        if ($user_id == null)
        {
            $user_id = $_SESSION['id'];    
        }

        if(Account::GetUser($user_id)['role'] == 80){
            return true;
        }else{
            return false;
        }
    }

    public static function IsSupport($user_id = null){
        if ($user_id == null)
        {
            $user_id = $_SESSION['id'];    
        }

        if(Account::GetUser($user_id)['role'] == 14){
            return true;
        }else{
            return false;
        }
    }

    public static function IsBanned($user_id = null){
        if ($user_id == null)
        {
            $user_id = $_SESSION['id'];    
        }

        if(Account::GetUser($user_id)['ban'] == 1){
            return true;
        }else{
            return false;
        }
    }

    public static function IsPremium($user_id = null){
        if ($user_id == null)
        {
            $user_id = $_SESSION['id'];    
        }

        if(Account::GetUser($user_id)['premium'] == 1){
            return true;
        }else{
            return false;
        }
    }

    public static function GetAllAccounts(){
        return $GLOBALS['DB']->GetContent("users");
    }

    public static function GetAllAuthorizedAccounts($role){
        return $GLOBALS['DB']->GetContent("users", ['confidentiality_profile_list_members' => 1, 'role' => $role]);
    }

    public static function GetFuckKey($id = null){
        if ($id == null)
        {
            $id = $_SESSION['id'];
        }
        return Account::GetUser($id)['fuck_key'];
    }

    public static function GetServers($fuck_key = null){
        if ($fuck_key == null)
        {
            $fuck_key = Account::GetFuckKey($_SESSION['id']);    
        }

        return $GLOBALS['DB']->GetContent("servers", ['fuck_key' => $fuck_key]);
        
    }

    public static function GetPayments($user_id = null){
        if ($user_id == null)
        {
            $user_id = $_SESSION['id'];    
        }

        return $GLOBALS['DB']->GetContent("payments", ['discord_id' => $user_id]);
        
    }

    public static function GetScripts($user_id = null){
        if ($user_id == null)
        {
            $user_id = $_SESSION['id'];    
        }
        return $GLOBALS['DB']->GetContent("scripts", ['owner' => $user_id]);
    }

    public static function GetSounds($user_id = null){
        if ($user_id == null)
        {
            $user_id = $_SESSION['id'];    
        }
        return $GLOBALS['DB']->GetContent("sounds_host", ['owner' => $user_id]);
    }

    public static function GetOnlines(){
        return $GLOBALS['DB']->GetContent("users_online");
    }

    public static function isAuthentified(){
        if(isset($_SESSION['id'])){
            if(Account::IsUserExist($_SESSION['id'])){
                return true;
            }
        }
    }

    public static function Banned(
        $id,
        $reason ){

        try {
            $GLOBALS['DB']->Update('users', ['discord_id' => $id], [
                "ban" => 1, 
                "ban_reason" => $reason
            ]);
        }catch (Exception $e) {
            return "error";
        }
    }

    public static function UnBanned($id){

        try {
            $GLOBALS['DB']->Update('users', ['discord_id' => $id], [
                "ban" => 0, 
                "ban_reason" => "none"
            ]);
        }catch (Exception $e) {
            return "error";
        }
    }

}


?>
