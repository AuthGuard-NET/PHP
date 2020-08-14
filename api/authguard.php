<?php
if (!isset($_SESSION))
    session_start();

class Guard
{
    public static function Initialize($api_key, $app_secret)
    {
        if (empty($app_secret) || empty($api_key) || !is_string($app_secret) || !is_string($api_key))
            die('Empty or non string Secret Key/API Key!');

        $_SESSION["api_key"] = $api_key;
        $_SESSION["app_secret"] = $app_secret;
        $values = 
        [
            "type" => "start", 
            "api" => $api_key, 
            "secret" => $app_secret
        ];

        $curl = curl_init(self::$API_ENDPOINT);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_PINNEDPUBLICKEY, self::$CERT_PUBLICKEY);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $values);
        $result = json_decode(curl_exec($curl)); curl_close($curl);
        switch ($result->status)
        {
            case "failed":
            die($result->info);
            break;
            case "success":
            self::$init = true;
            break;
            default:
            break;
        }
    }

    public static function Login($username, $password)
    {
        if (!self::$init)
            Guard::error('You did not call Guard::Initialize!');

        if (empty($username) || empty($password))
            Guard::error('All fields are required!');

        $values = 
        [
        "type" => "login", 
        "username" => $username, 
        "password" => $password, 
        "api" => $_SESSION["api_key"], 
        "secret" => $_SESSION["app_secret"]
        ];

        $curl = curl_init(self::$API_ENDPOINT);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_PINNEDPUBLICKEY, self::$CERT_PUBLICKEY);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $values);
        $data = json_decode(curl_exec($curl)); curl_close($curl);
        switch ($data->info)
        {
            case "time expired":
                Guard::error("Your subscription has expired!");
                return false;
            case "invalid login":
                Guard::error("Your credentials are invalid!");
                return false;
            case "user does not exist":
                Guard::error("User does not exist!");
                return false;
            case "user banned":
                Guard::error("Your account has been banned!");
                return false;
            case "success":
                $_SESSION["username"] = $data->username;
                $_SESSION["email"] = $data->email;
                $_SESSION["expiry"] = $data->expiry;
                $_SESSION["level"] = $data->level;
                $_SESSION["hwid"] = $data->hwid;
                $_SESSION["lastlogin"] = $data->lastlogin;
                return true;
            default:
            break;
        }
    }

    public static function Register($username, $password, $email, $license)
    {
        if (!self::$init)
            Guard::error('You did not call Guard::Initialize!');

        if (empty($username) || empty($password) || empty($email) || empty($license))
            Guard::error('All fields are required!');

        $values = 
        [
            "type" => "register", 
            "username" => $username, 
            "password" => $password, 
            "email" => $email, 
            "license" => $license, 
            "api" => $_SESSION["api_key"], 
            "secret" => $_SESSION["app_secret"]
        ];

        $curl = curl_init(self::$API_ENDPOINT);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_PINNEDPUBLICKEY, self::$CERT_PUBLICKEY);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $values);
        $data = json_decode(curl_exec($curl)); curl_close($curl);
        switch ($data->info)
        {
            case "invalid license":
                Guard::error("License is invalid or already used!");
                return false;
            case "user exists":
                Guard::error("Username has been taken!");
                return false;
            case "email used":
                Guard::error("Email has been taken!");
                return false;
            case "register success":
                Guard::success($username . ' has successfully registered!');
                return true;
            default:
            break;
        }
    }

    public static function UseToken($username, $password, $license)
    {
        if (!self::$init)
            Guard::error('You did not call Guard::Initialize!');

        if (empty($username) || empty($password) || empty($license))
            Guard::error('All fields are required!');

        $values = 
        [
            "type" => "extend", 
            "username" => $username, 
            "password" => $password, 
            "license" => $license, 
            "api" => $_SESSION["api_key"], 
            "secret" => $_SESSION["app_secret"]
        ];

        $curl = curl_init(self::$API_ENDPOINT);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_PINNEDPUBLICKEY, self::$CERT_PUBLICKEY);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $values);
        $data = json_decode(curl_exec($curl)); curl_close($curl);
        switch ($data->info)
        {
            case "invalid details":
                Guard::error("User to extend does not exist!");
                return false;
            case "invalid license":
                Guard::error("The license has already been used or is invalid!");
                return false;
            case "extend success":
                Guard::success($username . ' has successfully been extended!');
                return true;
            default:
                die($result);
            break;
        }
    }

    public static function error($message)
    {
        echo '<div class="alert alert-solid alert-danger mg-b-0" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <strong>Error:</strong><br>' . $message . '</b>.
          </div>';
    }
    
    public static function success($message)
    {
        echo '<div class="alert alert-solid alert-success mg-b-0" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <strong>Success:</strong><br>' . $message . '</b>.
          </div>';
    }
    
    // FIELDS
    private static $init = false;

    // CONSTANTS
    private static $CERT_PUBLICKEY = "sha256//7o5hfoky8MvnnaLcBBKjAy9cFNvCYnimjjAhkADjwbA=";
    private static $API_ENDPOINT = "https://api.authguard.net/v1/";
}
?>