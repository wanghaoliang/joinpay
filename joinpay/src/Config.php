<?php
/**
 * 配置类
 * User: 78668
 * Date: 2020/6/14
 * Time: 0:32
 */

namespace Joinpay;


class Config
{
    //公共配置
    const HOST_JOINPAY = "https://api.joinpay.com/";
    const MCH_NO = '888*********';//商户
    const MCH_NO_TRADE = '777*********';//报备商户
    const RSA_PUBLIC_KEY_PATH =  '' ; //商户公钥地址
    const RSA_PRIVATE_KEY_PATH =  '' ;//商户私钥地址
    const RSA_JOIN_PUBLIC_KEY_PATH =  '' ; //汇聚公钥地址
    const AES_KEY = 'ABCDEFGHIJK';//AES key
    const ID_CARD_TYPE = 1;//证件类型
    const VERSION = '1.0';//版本
    const SIGN_TYPE = '2';//加密类型

    //分账
    const MERGHANT_NOTIFY = 'https://123.com/merch';//添加分账回调地址
    const PAY_NOTIFY = 'https://123.com/pay';//快捷支付回调



}