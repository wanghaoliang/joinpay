<?php
/**
 * Created by PhpStorm.
 * User: 78668
 * Date: 2020/6/14
 * Time: 15:26
 */

namespace Joinpay;


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
     * 通道绑卡 发送短信
     * @param array $param
     * @return bool|mixed|string
     */
    public function marketChannelAuth(array $param)
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

        $return_data = $this->curl_post($res);
        return $return_data;
    }
}