<?php
/**
 * 加密类
 * User: 78668
 * Date: 2020/6/14
 * Time: 0:43
 */

namespace Joinpay\util;


use Joinpay\Config;

class EncryptUtil
{
    /**
     * AES/ECB/PKCS5Padding
     * @param string $data
     * @return string
     */
    public static function getAesEbcPKCSPadding($data = '')
    {
        return base64_encode(openssl_encrypt($data, "AES-128-ECB", Config::AES_KEY, OPENSSL_PKCS1_PADDING));
    }


    /**
     * 签名
     * @param $signData
     * @return bool|string
     */
    public static function createSign($signData)
    {
        if (!is_array($signData)) return False;

        ksort($signData);

        $requestString = '';
        foreach ($signData as $k => $v) {
            $requestString .= $k . '=' . $v . '&';
        }
        $requestString = rtrim($requestString, '&');

        $pi_key = openssl_get_privatekey(file_get_contents(Config::RSA_PRIVATE_KEY_PATH));
        openssl_sign($requestString, $binary_signature, $pi_key, OPENSSL_ALGO_MD5);
        openssl_free_key($pi_key);
        return base64_encode($binary_signature);
    }

    /**
     * 获取RSA 对AES
     * @return string
     */
    public static function getSecKey(){

        $source = Config::AES_KEY;
        $maxlength = 117;
        $output = '';
        while ($source) {
            $input = substr($source, 0, $maxlength);
            $source = substr($source, $maxlength);
            openssl_public_encrypt($input, $encrypted, file_get_contents(Config::RSA_JOIN_PUBLIC_KEY_PATH));
            $output .= $encrypted;
        }
        return  base64_encode($output);

    }

}