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
    protected $legalPerson = '';//姓名
    protected $phoneNo = '';//手机号
    protected $idCardNo = '';//身份证号
    protected $bankAccountNo = '';//银行卡号

    /**
     * @return string
     */
    protected function getAltLoginName()
    {
        return $this->altLoginName;
    }

    /**
     * @param $altLoginName
     * @return $this
     */
    public function setAltLoginName($altLoginName)
    {
        $this->altLoginName = $altLoginName;
        return $this;
    }

    /**
     * @return string
     */
    protected function getAltMchName()
    {
        return $this->altMchName;

    }

    /**
     * @param $altMchName
     * @return $this
     */
    public function setAltMchName($altMchName)
    {
        $this->altMchName = $altMchName;
        return $this;

    }

    /**
     * @return string
     */
    protected function getBankAccountNo()
    {
        return $this->bankAccountNo;
    }

    /**
     * @param $bank_account_no
     * @return $this
     */
    public function setBankAccountNo($bank_account_no)
    {
        $this->bankAccountNo = $bank_account_no;
        return $this;

    }

    /**
     * @return string
     */
    protected function getIdCardNo()
    {
        return $this->idCardNo;
    }

    /**
     * @param $id_card_no
     * @return $this
     */
    public function setIdCardNo($id_card_no)
    {
        $this->idCardNo = $id_card_no;
        return $this;

    }

    /**
     * @return string
     */
    protected function getLegalPerson()
    {
        return $this->legalPerson;
    }

    /**
     * @param $legal_person
     * @return $this
     */
    public function setLegalPerson($legal_person)
    {
        $this->legalPerson = $legal_person;
        return $this;

    }

    /**
     * @return string
     */
    protected function getPhoneNo()
    {
        return $this->phoneNo;
    }

    /**
     * @param $phone_no
     * @return $this
     */
    public function setPhoneNo($phone_no)
    {
        $this->phoneNo = $phone_no;
        return $this;

    }

    /**
     * 添加商户
     * @param array $message
     * @return bool|string
     * @throws \Exception
     */
    public function addMerchant(&$message = array())
    {

        $merch = array(
            'alt_login_name' => $this->altLoginName,//'123456',//登录账号
            'alt_mch_name' => $this->altMchName, //'个体户李四',//商户名称
            'legal_person' => $this->legalPerson,//'李四',//姓名
            'phone_no' => $this->phoneNo,//'1998888777',//手机号
            'id_card_no' => $this->idCardNo,// '100101199410104784',//身份证
            'bank_account_no' => $this->bankAccountNo,// '6222020000000456',//银行卡（储蓄）
            'callback_url' => Config::MERGHANT_NOTIFY,
        );
        $red = RequestUtil::curl_post($merch, $message);

        return $red;
    }


}