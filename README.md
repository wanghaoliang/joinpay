# 汇聚支付

这个是个人集成的汇聚支付PHP dome请注意：


- 1.非官方提供，非官方提供，非官方提供
- 2.如有不可请参照汇聚支付官网dome进行修改
- 3.如有问题可向 786689461@qq.com 发送邮件提出问题
- 4.商用请谨慎，出问题本人不负责

##安装
```$xslt
composer require xiaoliang/joinpay
```

##示例
- 1 添加分账

```
use Joinpay\Merchant;


$Merchant =new  Merchant();
$me = array();
$Merchant->setAltLoginName('78')
           ->setPhoneNo('1714568946')
            ->setLegalPerson('李四')
            ->setIdCardNo('100101199812055656')
            ->setAltMchName('个体户李四')
            ->setBankAccountNo('2164598498549')
            ->addMerchant($me);
```
