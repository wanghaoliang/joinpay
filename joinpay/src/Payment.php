<?php
/**
 * Created by PhpStorm.
 * User: Mely
 * Date: 2020/6/16
 * Time: 10:04
 */

namespace Joinpay;



use Joinpay\util\GetAddress;
use Joinpay\util\getMcc;
use Joinpay\util\RequestUtil;

class Payment
{
    //php 浮点型有问题金额用支付串表示
    protected $appLat = '';
    protected $appLng = '';
    protected $appIp = '';
    protected $rateAmount = '';
    protected $chMerCode = '';
    protected $orderAmount = '';
    protected $mchOrderNo = '';
    protected $bankCardNo = '';

    /**
     * @return string
     */
    protected function getAppLat()
    {
        return $this->appLat;
    }

    /**
     * @param string $appLat
     * @return Payment
     */
    public function setAppLat($appLat)
    {
        $this->appLat = $appLat;
        return $this;
    }

    /**
     * @return string
     */
    protected function getAppLng()
    {
        return $this->appLng;
    }

    /**
     * @param string $appLng
     * @return Payment
     */
    public function setAppLng($appLng)
    {
        $this->appLng = $appLng;
        return $this;
    }

    /**
     * @return string
     */
    protected function getAppIp()
    {
        return $this->appIp;
    }

    /**
     * @param string $appIp
     * @return Payment
     */
    public function setAppIp($appIp)
    {
        $this->appIp = $appIp;
        return $this;
    }

    /**
     * @return string
     */
    protected function getRateAmount()
    {
        return $this->rateAmount;
    }

    /**
     * @param string $rateAmount
     * @return Payment
     */
    public function setRateAmount($rateAmount)
    {
        $this->rateAmount = $rateAmount;
        return $this;
    }

    /**
     * @return string
     */
    protected function getChMerCode()
    {
        return $this->chMerCode;
    }

    /**
     * @param string $chMerCode
     * @return Payment
     */
    public function setChMerCode($chMerCode)
    {
        $this->chMerCode = $chMerCode;
        return $this;
    }

    /**
     * @return string
     */
    protected function getOrderAmount()
    {
        return $this->orderAmount;
    }

    /**
     * @param string $orderAmount
     * @return Payment
     */
    public function setOrderAmount($orderAmount)
    {
        $this->orderAmount = $orderAmount;
        return $this;
    }

    /**
     * @return string
     */
    protected function getMchOrderNo()
    {
        return $this->mchOrderNo;
    }

    /**
     * @param string $mchOrderNo
     * @return Payment
     */
    public function setMchOrderNo($mchOrderNo)
    {
        $this->mchOrderNo = $mchOrderNo;
        return $this;
    }

    /**
     * @return string
     */
    protected function getBankCardNo()
    {
        return $this->bankCardNo;
    }

    /**
     * @param string $bankCardNo
     * @return Payment
     */
    public function setBankCardNo($bankCardNo)
    {
        $this->bankCardNo = $bankCardNo;
        return $this;
    }


    /**
     * 协议支付
     * @param array $message
     * @return bool|string
     * @throws \Exception
     */
    public function fastPayment(&$message = array()){
        $GetAddress = GetAddress::Initialize();
        $GetAddress->setLat($this->appLat);
        $GetAddress->setLng($this->appLng);
        $GetAddress->setIp($this->appIp);
        $city = $GetAddress->getUserCity();

        getMcc::setCode($city['result']['addressComponent']['adcode']);
        getMcc::setProvince($city['result']['addressComponent']['province']);
        getMcc::setCity($city['result']['addressComponent']['city']);
        getMcc::setDistrict($city['result']['addressComponent']['district']);
        $mcc = getMcc::getMcc();

        $alt_info = json_encode(array(
            array(
                'alt_mch_no' => Config::MCH_NO,
                'alt_amount' => number_format($this->rateAmount,2,null,'')
            ),
            array(
                'alt_mch_no' => $this->chMerCode,
                'alt_amount' => bcsub ($this->orderAmount,$this->rateAmount,2),)
        ));
        $date_time = time();
        $message['date'] = $date_time;
        $post=array(
            'mch_order_no' =>   $this->mchOrderNo,//订单号
            'order_amount' => number_format($this->orderAmount,2,null,''),
            'mch_req_time' => date('Y-m-d H:i:s', $date_time) ,//date('Y-m-d H:i:s',$param['gp_time']),
            'order_desc' => self::chooseMcc(),
            'callback_url' => Config::PAY_NOTIFY,//商户异步通知地址
//            'callback_param' => '',//回调字符
//            'sign_no' => '',//签约 ID
//签约 ID 和银行卡号二选一必填，都填
//时以签约 ID 为准，上送时参与签名处
//理。（必须加密传输）
            'bank_card_no' =>$this->bankCardNo,//银行卡号
            'area_code' => $mcc,
            'is_alt' => '100',
            'alt_info' => $alt_info,
        );

        $res = RequestUtil::curl_post($post,$message);



        return $res;
    }

    //++++++++++++++++++++++++++++++++++++++++
    //直接支付
    //++++++++++++++++++++++++++++++++++++++++
    protected $payerName = '';
    protected $idNo = '';
    protected $mobileNo= '';
    protected $expireDate= '';
    protected $cvv= '';

    /**
     * @return mixed
     */
    public function getPayerName()
    {
        return $this->payerName;
    }

    /**
     * @param mixed $payerName
     * @return Payment
     */
    public function setPayerName($payerName)
    {
        $this->payerName = $payerName;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdNo()
    {
        return $this->idNo;
    }

    /**
     * @param string $idNo
     * @return Payment
     */
    public function setIdNo($idNo)
    {
        $this->idNo = $idNo;
        return $this;
    }

    /**
     * @return string
     */
    public function getMobileNo()
    {
        return $this->mobileNo;
    }

    /**
     * @param string $mobileNo
     * @return Payment
     */
    public function setMobileNo($mobileNo)
    {
        $this->mobileNo = $mobileNo;
        return $this;
    }

    /**
     * @return string
     */
    public function getExpireDate()
    {
        return $this->expireDate;
    }

    /**
     * @param string $expireDate
     * @return Payment
     */
    public function setExpireDate($expireDate)
    {
        $this->expireDate = $expireDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getCvv()
    {
        return $this->cvv;
    }

    /**
     * @param string $cvv
     * @return Payment
     */
    public function setCvv($cvv)
    {
        $this->cvv = $cvv;
        return $this;
    }

    /**
     * 直接支付
     * @param $message
     * @return bool|string
     * @throws \Exception
     */
    public function directPay(&$message)
    {
        $GetAddress = GetAddress::Initialize();
        $GetAddress->setLat($this->appLat);
        $GetAddress->setLng($this->appLng);
        $GetAddress->setIp($this->appIp);
        $city = $GetAddress->getUserCity();

        getMcc::setCode($city['result']['addressComponent']['adcode']);
        getMcc::setProvince($city['result']['addressComponent']['province']);
        getMcc::setCity($city['result']['addressComponent']['city']);
        getMcc::setDistrict($city['result']['addressComponent']['district']);
        $mcc = getMcc::getMcc();

        $alt_info = json_encode(array(
            array(
                'alt_mch_no' => Config::MCH_NO,
                'alt_amount' => number_format($this->rateAmount,2,null,'')
            ),
            array(
                'alt_mch_no' => $this->chMerCode,
                'alt_amount' => bcsub ($this->orderAmount, $this->rateAmount,2),)
        ));
        $date_time = time();
        $message['date'] = $date_time;
        $post=array(
            'mch_order_no' => $this->mchOrderNo,//订单号
            'order_amount' => number_format($this->orderAmount,2,null,''),//TODO 该格式未确认
            'mch_req_time' => date('Y-m-d H:i:s', $date_time) ,//date('Y-m-d H:i:s',$param['gp_time']),
            'order_desc' => self::chooseMcc(),
            'callback_url' => Config::PAY_NOTIFY,//商户异步通知地址
//            'callback_param' => '',//回调字符
//            'sign_no' => '',//签约 ID
//签约 ID 和银行卡号二选一必填，都填
//时以签约 ID 为准，上送时参与签名处
//理。（必须加密传输）

            'payer_name' => $this->payerName,//姓名
            'id_type' => Config::ID_CARD_TYPE,//证件类型
            'id_no' => $this->idNo,//证件号
            'mobile_no' => $this->mobileNo,//手机号
            'expire_date' => $this->expireDate
        ,//有效期
            'cvv' => $this->cvv,
            'bank_card_no' => $this->bankCardNo,//银行卡号
            'area_code' => $mcc,
            'is_alt' => '100',
            'alt_info' => $alt_info,
        );

        $res = RequestUtil::curl_post($post,$message);
        return $res;
    }

    /**
     * 选择商品
     * @return string
     */
    protected static function chooseMcc()
    {
        $goods = array(
            "百货",
            "食品",
            "服装",
            "餐饮",
            "娱乐",
            "洗浴按摩",
            "美容美发",
            "珠宝",
            "宾馆",
        );
        return $goods[array_rand($goods)];
    }


    protected $orgMchReqTime;

    /**
     * @return mixed
     */
    public function getOrgMchReqTime()
    {
        return $this->orgMchReqTime;
    }

    /**
     * @param mixed $orgMchReqTime
     * @return Payment
     */
    public function setOrgMchReqTime($orgMchReqTime)
    {
        $this->orgMchReqTime = $orgMchReqTime;
        return $this;
    }


    /**
     * 付款订单查询
     * @param $message
     * @return bool|string
     * @throws \Exception
     */
    public function queryToAccount(&$message){

        $data = [
            'mch_order_no'=>$this->mchOrderNo,
            'org_mch_req_time'=>$this->orgMchReqTime
        ];
        $res = RequestUtil::curl_post($data,$message);
        return $res;
    }
}