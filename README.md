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
- $me 为日志相关
- 1 添加分账

```php
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
- 2 签订协议-发送短信
```php
use Joinpay\BankCard;


$BankCard = new BankCard();
$me = array();
$info = $BankCard->setBankCardNo('622206123456')
        ->setCvv('123')
        ->setIdNo('100101199412124656')
        ->setExpireDate('23/02')
        ->setMchOrderNo('A123456')
        ->setMobileNo('17182988498')
        ->setPayerName('李四')
        ->bankToSms($me);
```
- 3 签订协议-验证短信
```php
use Joinpay\BankCard;

$BankCard = new BankCard();
$me = array();
$info=$BankCard->setMchOrderNo('A123456')
                ->setSmsCode('456456')
                ->verifySms($me);
```

- 4 协议支付
```php
use Joinpay\Payment;

$Payment = new Payment();
$me = array();

$Payment->setMchOrderNo('P4985541')
        ->setOrderAmount('10000')
        ->setAppLat('0.30549654')
        ->setAppLng('100.459544')
        ->setAppIp('124.123.122.111')
        ->setChMerCode('777777777777')
        ->setRateAmount('56')
        ->setBankCardNo('6585555989489898')
        ->fastPayment($me);

```
- 5 直接支付
```php
use Joinpay\Payment;


$Payment = new Payment();
$me = array();

$Payment->setMchOrderNo('P4985541')
        ->setOrderAmount('10000')
        ->setAppLat('0.30549654')
        ->setAppLng('100.459544')
        ->setAppIp('124.123.122.111')
        ->setRateAmount('56')
        ->setPayerName('李四')
        ->setBankCardNo('6585555989489898')
        ->setIdNo('100101199412137878')
        ->setMobileNo('18191513121')
        ->setExpireDate('42/03')
        ->setCvv('123')
        ->setChMerCode('777777777777')
        ->directPay($me);


```
- 6.查询支付
```php
use Joinpay\Payment;

$Payment = new Payment();
$me = array();
$info =  $Payment->setMchOrderNo('P4985541')
                ->setOrgMchReqTime(date('Y-m-d H:i:s'))//下单时间
                ->queryPayment($me);

```

- 7.商户到账
```php
use Joinpay\ToAccount;

$ToAccount = new ToAccount();
$me = array();
$info =  $ToAccount->setMchOrderNo('P789654')
        ->setBankAccountNo('6555555555')
        ->setAltMchNo('777777**********')
        ->setRateAmount('1')//平台服务费
        ->setSettleAmount('99')//结算金额
        ->toUser($me);

```

- 8.到账查询
```php
use Joinpay\ToAccount;

$ToAccount = new ToAccount();
$me = array();
$info =  $ToAccount->setMchOrderNo('P789654')
        ->queryToAccount($me);
```