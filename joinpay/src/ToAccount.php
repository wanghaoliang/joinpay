<?php
/**
 * 到账
 * User: Mely
 * Date: 2020/6/16
 * Time: 11:34
 */

namespace Joinpay;


use Joinpay\util\RequestUtil;

class ToAccount
{
    protected $altMchNo;
    protected $bankAccountNo;
    protected $settleAmount;
    protected $rateAmount;
    protected $mchOrderNo;

    /**
     * @return mixed
     */
    protected function getAltMchNo()
    {
        return $this->altMchNo;
    }

    /**
     * @param mixed $altMchNo
     * @return ToAccount
     */
    public function setAltMchNo($altMchNo)
    {
        $this->altMchNo = $altMchNo;
        return $this;
    }

    /**
     * @return mixed
     */
    protected function getBankAccountNo()
    {
        return $this->bankAccountNo;
    }

    /**
     * @param mixed $bankAccountNo
     * @return ToAccount
     */
    public function setBankAccountNo($bankAccountNo)
    {
        $this->bankAccountNo = $bankAccountNo;
        return $this;
    }

    /**
     * @return mixed
     */
    protected function getSettleAmount()
    {
        return $this->settleAmount;
    }

    /**
     * @param mixed $settleAmount
     * @return ToAccount
     */
    public function setSettleAmount($settleAmount)
    {
        $this->settleAmount = $settleAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    protected function getRateAmount()
    {
        return $this->rateAmount;
    }

    /**
     * @param mixed $rateAmount
     * @return ToAccount
     */
    public function setRateAmount($rateAmount)
    {
        $this->rateAmount = $rateAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    protected function getMchOrderNo()
    {
        return $this->mchOrderNo;
    }

    /**
     * @param mixed $mchOrderNo
     * @return ToAccount
     */
    public function setMchOrderNo($mchOrderNo)
    {
        $this->mchOrderNo = $mchOrderNo;
        return $this;
    }


    /**
     * 商户到银行卡
     * @param $message
     * @return bool|string
     * @throws \Exception
     */
    public function toUser(&$message){
        //获取用户的商户码
        $post = array(
            'alt_mch_no'	=> $this->altMchNo,//分账方编号
            'bank_account_no'	=> $this->bankAccountNo,//结算银行卡号
            'settle_amount'	=> 	$this->settleAmount,//结算金额
            'settle_fee'	=>	 bcsub ($this->rateAmount ,Config::SERVER_MONEY,2),//平台服务费
            'mch_order_no'	=> $this->mchOrderNo,//订单编号
            'callback_url'	=> 	Config::PAY_NOTIFY        //异步通知地址
        );

        $result = RequestUtil::curl_post($post,$message);
        return $result;
    }



    /**
     * 支付订单查询
     * @param $message
     * @return bool|string
     * @throws \Exception
     */
    public function queryToAccount(&$message){
        $data = [
            'mch_order_no'=>$this->mchOrderNo,
        ];

        $res = RequestUtil::curl_post($data,$message);

        return $res;

    }
}