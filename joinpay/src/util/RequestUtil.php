<?php
/**
 * Created by PhpStorm.
 * User: 78668
 * Date: 2020/6/14
 * Time: 0:07
 */
namespace Joinpay\util;

use Joinpay\Config;

class RequestUtil
{
    /**
     * post请求
     * @param array $param
     * @param array $message
     * @return bool|string
     * @throws \Exception
     */
    public static function curl_post($param = array(),&$message = array()) {

        if (empty($param)) {
            return false;
        }

        $backtrace = debug_backtrace();
        array_shift($backtrace);

        $function_name =    array_shift($backtrace)['function'];

        $url = self::getUrl($function_name);

        if($url === false){
            throw new \Exception('缺少请求地址');
        }

        $curlPost = self::getRequestData($param,$function_name);
        $postUrl = Config::HOST_JOINPAY . $url;

        $message['host'] =  $postUrl;
        $message['request'] =  $curlPost;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HTTPHEADER,array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length:' . strlen($curlPost)
        ));//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书下同
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
        $data = curl_exec($ch);//运行curl
        if ($data === FALSE) {
            throw new \Exception('请求错误' . curl_error($ch));
        }
        curl_close($ch);

        $message['request'] =  $data;
        if(Config::IS_RESPONSE){
            return self::returnData($data);

        }
        return $data;
    }

    /**
     * 结果处理异常请参考文档
     * @param string $response
     * @return bool|mixed
     */
    public static function returnData($response = ''){

        $result = json_decode($response, true);

        if (!isset($result['resp_code']) || $result['resp_code'] != 'SUCCESS'){
            //请求异常
            return false;
        }

        if (!isset($result['biz_code']) || $result['biz_code'] != 'JS000000'){
            //请求异常
            return false;
        }

        $res = json_decode($result['data'], true);


        return $res;
    }

    /**
     * 接口映射
     * @param string $function_name
     * @return mixed
     */
    protected static function getMethod($function_name = ''){

        $method = array(
            'bankToSms' => 'fastPay.agreement.signSms',
            'verifySms' => 'fastPay.agreement.smsSign',
            'addMerchant' => 'identicalAltMch.create',
            'fastPayment' => 'fastPay.agreement.pay',
            'toUser' => 'altSettle.launch',
            'queryToAccount' => 'fastPay.query',
            'queryPayment' => 'altSettle.get',
        );
        return $method[$function_name];
    }
    /**
     * 方法映射
     * @var array
     */
    protected static $function_list = array(
        'bankToSms' => 'fastpay',
        'verifySms' => 'fastpay',
        'addMerchant' => 'altFunds',
        'fastPayment' => 'fastpay',
        'toUser' => 'altFunds',
        'queryToAccount' => 'query',
        'queryPayment' => 'altFunds',
    );
    /**
     * @param string $function_name
     * @return bool
     */
    protected static function getUrl($function_name = ''){
        if(isset(self::$function_list[$function_name])){

            return  self::$function_list[$function_name];
        }

        return false;
    }

    protected static $fields = array(
        'id_card_no',
        'bank_account_no' ,

        'payer_name',
        'id_no',
        'bank_card_no',
        'mobile_no',
        'expire_date',
        'cvv',

        'legal_person',
        'phone_no',
        'id_card_no',
        'bank_account_no',

        'bank_card_no',
        'sign_no',
    );

    public static function getRequestData($param = array(),$function_name = ''){

        $param['mch_no_trade'] = Config::MCH_NO_TRADE;

        foreach ($param as $item =>  $value){
            if(in_array($item,self::$fields)){
                $param[$item] = EncryptUtil::getAesEbcPKCSPadding($value);
            }
        }
        $rand_str = md5(uniqid());
        $response = array();
        $response['method'] = self::getMethod($function_name);
        $response['version'] = Config::VERSION;
        $response['data'] = json_encode($param);
        $response['rand_str'] = $rand_str;
        $response['sign_type'] = Config::SIGN_TYPE;
        $response['mch_no'] = Config::MCH_NO;

        $response['sign'] =EncryptUtil::createSign($response);
        $response['sec_key'] = EncryptUtil::getSecKey();

        return json_encode($response,JSON_UNESCAPED_SLASHES);
    }


}