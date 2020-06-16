<?php
/**
 * 签订协议
 * User: 78668
 * Date: 2020/6/14
 * Time: 15:26
 */

namespace Joinpay;


use Joinpay\util\RequestUtil;

class BankCard
{
    protected $mchOrderNo;
    protected $payerName;
    protected $idNo;
    protected $bankCardNo;
    protected $mobileNo;
    protected $expireDate;
    protected $cvv;

    /**
     * @param $mchOrderNo
     * @return $this
     */
    public function setMchOrderNo($mchOrderNo)
    {
        $this->mchOrderNo = $mchOrderNo;
        return $this;
    }

    /**
     * @param mixed $bankCardNo
     * @return BankCard
     */
    public function setBankCardNo($bankCardNo)
    {
        $this->bankCardNo = $bankCardNo;
        return $this;
    }

    /**
     * @param mixed $payerName
     * @return BankCard
     */
    public function setPayerName($payerName)
    {
        $this->payerName = $payerName;
        return $this;
    }

    /**
     * @param $cvv
     * @return $this
     */
    public function setCvv($cvv)
    {
        $this->cvv = $cvv;
        return $this;

    }

    /**
     * @param $expireDate
     * @return $this
     */
    public function setExpireDate($expireDate)
    {
        $this->expireDate = $expireDate;
        return $this;

    }

    /**
     * @param $idNo
     * @return $this
     */
    public function setIdNo($idNo)
    {
        $this->idNo = $idNo;
        return $this;

    }

    /**
     * @param $mobileNo
     * @return $this
     */
    public function setMobileNo($mobileNo)
    {
        $this->mobileNo = $mobileNo;
        return $this;

    }


    /**
     * @return mixed
     */
    protected function getBankCardNo()
    {
        return $this->bankCardNo;
    }

    /**
     * @return mixed
     */
    protected function getCvv()
    {
        return $this->cvv;
    }

    /**
     * @return mixed
     */
    protected function getExpireDate()
    {
        return $this->expireDate;
    }

    /**
     * @return mixed
     */
    protected function getIdNo()
    {
        return $this->idNo;
    }

    /**
     * @return mixed
     */
    protected function getMchOrderNo()
    {
        return $this->mchOrderNo;
    }

    /**
     * @return mixed
     */
    protected function getMobileNo()
    {
        return $this->mobileNo;
    }

    /**
     * @return mixed
     */
    protected function getPayerName()
    {
        return $this->payerName;
    }


    /**
     * 发送短信
     * @param array $message
     * @return bool|string
     * @throws \Exception
     */
    public function bankToSms(&$message = array())
    {
        $res =   array(
            "mch_order_no" => $this->mchOrderNo,
            "order_amount" => '0.10',
            "mch_req_time" => date('Y-m-d H:i:s'),
            "payer_name" => $this->payerName,// $param['account_name'],
            "id_type" => Config::ID_CARD_TYPE,
            "id_no" => $this->idNo,//$param['id_card'],
            "bank_card_no" => $this->bankCardNo,//$param['bank_number'],
            "mobile_no" => $this->mobileNo,//$param['mobile'],
            "expire_date" => $this->expireDate,//$param['effective'],
            "cvv" => $this->cvv//$param['cvn2'],
        );

        $return_data =RequestUtil::curl_post($res,$message);
        return $return_data;
    }

    protected $smsCode = '';

    /**
     * @return string
     */
    protected function getSmsCode()
    {
        return $this->smsCode;
    }

    /**
     * @param string $smsCode
     * @return BankCard
     */
    public function setSmsCode($smsCode)
    {
        $this->smsCode = $smsCode;
        return $this;
    }

    /**
     * 验证短信
     * @param array $message
     * @return array|bool|string
     * @throws \Exception
     */
    public function verifySms(&$message = array()){
        $res = array(
            'mch_order_no' => $this->mchOrderNo,//订单号
            'sms_code' => $this->smsCode,//短信验证码
        );

        $res = RequestUtil::curl_post($res,$message);
        return $res;
    }

}