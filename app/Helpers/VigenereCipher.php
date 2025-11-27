<?php

namespace App\Helpers;

class VigenereCipher
{
    // ======== KONFIGURASI ========
    private static $asciiMin = 32;  // spasi
    private static $asciiMax = 126; // '~'

    // ======== VIGENERE CIPHER ========
    public static function vigenereEncrypt($text, $key)
    {
        $result = '';
        $keyLength = strlen($key);

        for ($i = 0; $i < strlen($text); $i++) {
            $charCode = ord($text[$i]);
            $keyCode = ord($key[$i % $keyLength]);
            $enc = (($charCode + $keyCode - self::$asciiMin * 2)
                    % (self::$asciiMax - self::$asciiMin + 1))
                    + self::$asciiMin;
            $result .= chr($enc);
        }

        return base64_encode($result);
    }

    public static function vigenereDecrypt($text, $key)
    {
        $text = base64_decode($text);
        $result = '';
        $keyLength = strlen($key);

        for ($i = 0; $i < strlen($text); $i++) {
            $charCode = ord($text[$i]);
            $keyCode = ord($key[$i % $keyLength]);
            $dec = (($charCode - $keyCode + (self::$asciiMax - self::$asciiMin + 1))
                    % (self::$asciiMax - self::$asciiMin + 1))
                    + self::$asciiMin;
            $result .= chr($dec);
        }

        return $result;
    }

    // ======== CAESAR CIPHER ========
    public static function caesarEncrypt($text, $shift = 3)
    {
        $result = '';
        $range = self::$asciiMax - self::$asciiMin + 1;

        for ($i = 0; $i < strlen($text); $i++) {
            $charCode = ord($text[$i]);
            $enc = (($charCode - self::$asciiMin + $shift) % $range) + self::$asciiMin;
            $result .= chr($enc);
        }

        return base64_encode($result);
    }

    public static function caesarDecrypt($text, $shift = 3)
    {
        $text = base64_decode($text);
        $result = '';
        $range = self::$asciiMax - self::$asciiMin + 1;

        for ($i = 0; $i < strlen($text); $i++) {
            $charCode = ord($text[$i]);
            $dec = (($charCode - self::$asciiMin - $shift + $range) % $range) + self::$asciiMin;
            $result .= chr($dec);
        }

        return $result;
    }

    // ======== AES CIPHER (OpenSSL) ========
    public static function aesEncrypt($plainText, $key)
    {
        $cipher = "AES-256-CBC";
        $ivLength = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivLength);

        // pastikan key pas 32 byte
        $key = hash('sha256', $key, true);

        $encrypted = openssl_encrypt($plainText, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $encrypted);
    }

    public static function aesDecrypt($encryptedText, $key)
    {
        $cipher = "AES-256-CBC";
        $ivLength = openssl_cipher_iv_length($cipher);
        $data = base64_decode($encryptedText);

        $iv = substr($data, 0, $ivLength);
        $cipherText = substr($data, $ivLength);

        $key = hash('sha256', $key, true);

        $decrypted = openssl_decrypt($cipherText, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        return $decrypted;
    }

    // ======== UNIVERSAL HANDLER ========
    public static function encrypt($text, $key, $method = 'vigenere', $shift = 3)
    {
        switch (strtolower($method)) {
            case 'aes':
                return self::aesEncrypt($text, $key);
            case 'caesar':
                return self::caesarEncrypt($text, $shift);
            case 'vigenere':
            default:
                return self::vigenereEncrypt($text, $key);
        }
    }

    public static function decrypt($text, $key, $method = 'vigenere', $shift = 3)
    {
        switch (strtolower($method)) {
            case 'aes':
                return self::aesDecrypt($text, $key);
            case 'caesar':
                return self::caesarDecrypt($text, $shift);
            case 'vigenere':
            default:
                return self::vigenereDecrypt($text, $key);
        }
    }
}
