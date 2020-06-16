<?php
/**
 * 商户测试
 * User: 78668
 * Date: 2020/6/14
 * Time: 14:39
 */
namespace  Joinpay{

}
namespace Joinpay\Tests{

    use Joinpay\Merchant;

    /**
     * Class MerchantT
     * @package Joinpay\Tests
     */
    class MerchantT extends \PHPUnit_Framework_TestCase{
        protected $Merchant;
        public function __construct()
        {
            $this->Merchant = new Merchant();

        }

        /**
         *
         * @throws \Exception
         */
        public function testAddMerch(){
            $me = array();
           $re = $this->Merchant
                ->setAltLoginName('123456')
                ->setAltMchName('个体户李四')
                ->setBankAccountNo('123456')
                ->setIdCardNo('1000320312')
                ->setLegalPerson('李四')
                ->setPhoneNo('19188887777')->addMerchant($me);
            var_dump($re,$me);die;
        }

    }
}