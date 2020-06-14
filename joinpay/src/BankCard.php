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
    /**
     * 通道绑卡 发送短信
     * @param array $param
     * @return bool|mixed|string
     */
    public function marketChannelAuth(array $param)
    {
        $res =   array(
            "mch_order_no" => $param['order_no'],
            "order_amount" => '0.10',
            "mch_req_time" => date('Y-m-d H:i:s'),
            "payer_name" => $param['account_name'],// $param['account_name'],
            "id_type" => Config::ID_CARD_TYPE,
            "id_no" => $param['id_card'],//$param['id_card'],
            "bank_card_no" => $param['bank_number'],//$param['bank_number'],
            "mobile_no" => $param['mobile'],//$param['mobile'],
            "expire_date" => $param['effective'],//$param['effective'],
            "cvv" => $param['cvn2']//$param['cvn2'],
        );

        $return_data = $this->curl_post($res);
        return $return_data;
    }
}