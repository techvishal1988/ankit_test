<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define("ENCRYPTION_KEY", "abc!@#!@@");
$string = "my_name_is_khan";


/**
 * Returns an encrypted & utf8-encoded
 */
function encrypt($pure_string, $encryption_key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, $pure_string, MCRYPT_MODE_ECB, $iv);
    return $encrypted_string;
}

/**
 * Returns decrypted original string
 */
function decrypt($encrypted_string, $encryption_key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
    return $decrypted_string;
}

//echo $encrypted = encrypt($string, ENCRYPTION_KEY);
//echo "<br />";
//echo $decrypted = decrypt($encrypted, ENCRYPTION_KEY);
//die;

function getAPI($url='http://192.168.0.8/comp-ben-user-portal/index.php/api/team/employeeincrement/3/10/1')
    {
        $CI =& get_instance();
        
        $urlData = $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_URL,$urlData);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = array();
        $headers[] = 'token:'.'2c6e32d9ff0ed7ab66831951c81e4e4b';
        $headers[] = 'authname:'.'compben_user_portal_db';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $server_output = curl_exec ($ch);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        $res=  json_decode($server_output);
        return $res;

    }