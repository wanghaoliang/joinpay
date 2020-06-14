<?php
/**
 * 分账
 * User: 78668
 * Date: 2020/6/14
 * Time: 14:59
 */

namespace Joinpay;


use Joinpay\util\RequestUtil;

class Merchant
{
    protected $altLoginName = '';//登录账号
    protected $altMchName = '';//商户名称

    /**
     * @return string
     */
    protected function getAltLoginName()
    {
        return $this->altLoginName;
    }

    /**
     * @param string $altLoginName
     */
    public function setAltLoginName($altLoginName)
    {
        $this->altLoginName = $altLoginName;
    }
    /**
     * 添加商户
     * @param array $param
     * @param array $message
     * @return bool|string
     * @throws \Exception
     */
    public function addMerchant($param = array(),&$message = array()){

        $merch = array(
            'alt_login_name' => $param['alt_login_name'],//'123456',//登录账号
            'alt_mch_name' => $param['alt_mch_name'], //'个体户李四',//商户名称
            'legal_person' =>  $param['legal_person'],//'李四',//姓名
            'phone_no' =>  $param['phone_no'],//'1998888777',//手机号
            'id_card_no' => $param['id_card_no'],// '100101199410104784',//身份证
            'bank_account_no' => $param['bank_account_no'],// '6222020000000456',//银行卡（储蓄）
            'callback_url' => Config::MERGHANT_NOTIFY,
        );
        $red = RequestUtil::curl_post($merch,$message);

        return $red;
    }


}