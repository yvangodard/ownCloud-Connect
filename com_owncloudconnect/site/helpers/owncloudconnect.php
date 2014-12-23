<?php
// No direct access to this file
defined('_JEXEC') or die;
 
/**
 * HelloWorld component helper.
 */
abstract class OwncloudConnectHelper
{
	public static $key = '45rtmxcspa8w7f9ghep3i6wx1cd4fl6e4qfmnte';
	        
        /**
         * Encryptage d'une chaîne
         */
        public static function stringEncrypt($string){
        	$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(self::$key), $string, MCRYPT_MODE_CBC, md5(md5(self::$key))));
        	return $encrypted;
        }
        
        /**
         * Décryptage d'une chaîne
         */
        public static function stringDecrypt($encrypted){
        	$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(self::$key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5(self::$key))), "\0");
        	return $decrypted;
        }
}