<?php
error_reporting(0);
date_default_timezone_set('UTC');

if (!isset($_SESSION)) session_start();

class AuthGuard
{
    // FIELDS
    private static $api_key = 'API_Key';
    private static $user = null;
    private static $init = false;

    // CONSTANTS
    private static $API_ENDPOINT = 'https://authguard.net/api/v2.1/';
    private static $CERT_PUBLICKEY = 'sha256//NNsLiP2d63wFNZIyJ/Rcld3b6KOL7060JLlHPCVPdRo=';
    private static $USER_AGENT = 'AuthGuard Agent';

    public static function Initialize()
    {
        $api_key = self::$api_key;

        if (empty($api_key) || !is_string($api_key))
            self::error('Empty or non string API Key!');

        $result = self::performRequest('init', ['program_key' => self::$api_key]);

        switch ($result->status)
        {
            case 'invalid_request':
                self::error($result->message);
                break;
            case 'invalid_api_key':
                self::error($result->message);
                break;
            case 'application_banned':
                self::error($result->message);
                break;
            case 'application_disabled':
                self::error($result->message);
                break;
            case 'success':
                self::$init = true;
                break;
            default:
                self::error('Unknown Exception');
                break;
        }
    }

    public static function Login($username, $password)
    {
        if (!self::$init){
            self::error('You did not call AuthGuard::Initialize!');
            return false;
        }

        if (empty($username) || empty($password)){
            self::error('All fields are required!');
            return false;
        }

        $result = self::performRequest('login', [
            'program_key' => self::$api_key,
            'username' => self::xss_clean($username),
            'password' => self::xss_clean($password)
        ]);

        switch ($result->status)
        {
            case 'invalid_request':
                self::error($result->message);
                return false;
                break;
            case 'invalid_api_key':
                self::error($result->message);
                return false;
                break;
            case 'application_disabled':
                self::error($result->message);
                return false;
                break;
            case 'application_banned':
                self::error($result->message);
                return false;
                break;
            case 'invalid_creds':
                self::error($result->message);
                return false;
                break;
            case 'banned_user':
                self::error($result->message);
                return false;
                break;
            case 'subscription_expired':
                self::error($result->message);
                return false;
                break;
            case 'success':
                $_SESSION["id"] = $result->data->id;
                $_SESSION["username"] = $result->data->username;
                $_SESSION["email"] = $result->data->email;
                $_SESSION["expiry"] = $result->data->expiry;
                $_SESSION["level"] = $result->data->level;
                $_SESSION["hwid"] = $result->data->hwid;
                $_SESSION["lastlogin"] = $result->data->lastlogin;
                $_SESSION["totalclients"] = $result->data->totalclients;
                $_SESSION["variables"] = $result->data->vars;
                self::success("You have successfully logged in!");
                return true;
                break;
            default:
                self::error('Unknown Exception');
                return false;
                break;
        }

        self::$user = new User($username, $result->hwid, $result->expiration, !empty($result->otp_enabled));
    }

    public static function Register($username, $password, $email, $license)
    {
        if (!self::$init){
            self::error('You did not call AuthGuard::Initialize!');
            return false;
        }

        if (empty($username) || empty($password)  || empty($email)|| empty($license)){
            self::error('All fields are required!');
            return false;
        }

        $result = self::performRequest('register', [
            'program_key' => self::$api_key,
            'username' => self::xss_clean($username),
            'password' => self::xss_clean($password),
            'email' => self::xss_clean($email),
            'license' => self::xss_clean($license)
        ]);

        switch ($result->status)
        {
            case 'invalid_request':
                self::error($result->message);
                return false;
                break;
            case 'invalid_api_key':
                self::error($result->message);
                return false;
                break;
            case 'application_disabled':
                self::error($result->message);
                return false;
                break;
            case 'application_banned':
                self::error($result->message);
                return false;
                break;
            case 'invalid_license':
                self::error($result->message);
                return false;
                break;
            case 'used_license':
                self::error($result->message);
                return false;
                break;
            case 'invalid_username':
                self::error($result->message);
                return false;
                break;
            case 'invalid_email':
                self::error($result->message);
                return false;
                break;
            case 'bad_email':
                self::error($result->message);
                return false;
                break;
            case 'reached_max_user':
                self::error($result->message);
                return false;
                break;
            case 'success':
                self::success("Successfully Registred, ".self::xss_clean($username)."!");
                return true;
                break;
            default:
                self::error('Unknown Exception');
                return false;
                break;
        }
    }

    public static function UseLicense($username, $license)
    {
        if (!self::$init){
            self::error('You did not call AuthGuard::Initialize!');
            return false;
        }

        if (empty($username) || empty($license)){
            self::error('All fields are required!');
            return false;
        }

        $result = self::performRequest('extend', [
            'program_key' => self::$api_key,
            'username' => self::xss_clean($username),
            'license' => self::xss_clean($license)
        ]);

        switch ($result->status)
        {
            case 'invalid_request':
                self::error($result->message);
                return false;
                break;
            case 'invalid_api_key':
                self::error($result->message);
                return false;
                break;
            case 'application_disabled':
                self::error($result->message);
                return false;
                break;
            case 'application_banned':
                self::error($result->message);
                return false;
                break;
            case 'invalid_license':
                self::error($result->message);
                return false;
                break;
            case 'used_license':
                self::error($result->message);
                return false;
                break;
            case 'invalid_username':
                self::error($result->message);
                return false;
                break;
            case 'banned_user':
                self::error($result->message);
                return false;
                break;
            case 'success':
                return true;
                break;
            default:
                self::error('Unknown Exception');
                break;
        }
    }

    public static function ChangePassword($password, $newpassword)
    {
        if (!self::$init)
            self::error('You did not call AuthGuard::Initialize!');

        if (empty($password) || empty($newpassword))
            self::error('All fields are required!');

        $result = self::performRequest('change/password', [
            'program_key' => self::$api_key,
            'username' => $_SESSION["username"],
            'password' => self::xss_clean($password),
            'newpassword' => self::xss_clean($newpassword)
        ]);

        switch ($result->status)
        {
            case 'invalid_request':
                self::error($result->message);
                return false;
                break;
            case 'invalid_api_key':
                self::error($result->message);
                return false;
                break;
            case 'application_disabled':
                self::error($result->message);
                return false;
                break;
            case 'application_banned':
                self::error($result->message);
                return false;
                break;
            case 'invalid_creds':
                self::error($result->message);
                return false;
                break;
            case 'banned_user':
                self::error($result->message);
                return false;
                break;
            case 'success':
                return true;
                break;
            default:
                self::error('Unknown Exception');
                return false;
                break;
        }
    }

    private static function performRequest($endpoint, $data)
    {
        $curl = curl_init(self::$API_ENDPOINT."?type=".$endpoint);
        curl_setopt($curl, CURLOPT_PINNEDPUBLICKEY, self::$CERT_PUBLICKEY);
        curl_setopt($curl, CURLOPT_USERAGENT, self::$USER_AGENT);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result);
    }

    private static function xss_clean($data)
    {
        return htmlentities($data, ENT_QUOTES, 'UTF-8');
    }

    public static function getUser()
    {
        if (self::$user != null)
            return self::$user;

        return new User("undefined", "undefined", "undefined", false);
    }

    public static function error($message)
    {
        echo '<script>
                toastr.options = {
                  "closeButton": true,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": false,
                  "positionClass": "toast-bottom-right",
                  "preventDuplicates": false,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
                toastr.error("'.$message.'");
            </script>';
    }
    
    public static function success($message)
    {
        echo '<script>
                toastr.options = {
                  "closeButton": true,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": false,
                  "positionClass": "toast-bottom-right",
                  "preventDuplicates": false,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
                toastr.success("'.$message.'");
            </script>';
    }
}