<?php
/**
 * Created by PhpStorm.
 * User: Mely
 * Date: 2020/5/21
 * Time: 18:13
 */

namespace Joinpay\util;



class GetAddress
{
    private $lat = '';
    private $lng = '';
    private $ip = '';
    protected static $LLGetRegion= null;

    /**
     * GetAddress constructor.
     * @param array $config
     */
    private function __construct($config = array())
    {
        if(!empty($config['lat'])){
            $this->lat = $config['lat'];
        }
        if(!empty($config['lng'])){
            $this->lng = $config['lng'];
        }
        if(!empty($config['ip'])){
            $this->ip = $config['ip'];
        }
    }

    /**
     * @param array $config
     * @return GetAddress|null
     */
    public static function Initialize($config = array()){
        if(!self::$LLGetRegion instanceof self){
            self::$LLGetRegion = new self($config);
        }
        return self::$LLGetRegion;
    }

    /**
     * 修改
     * @param mixed|string $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    /**
     * @param mixed|string $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @param mixed|string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    private function __clone()
    {

    }

    /**
     * 获取地址
     * @return array|mixed
     */
    public function getUserCity(){
        if(!empty($this->lat) && !empty($this->lng)){
            //存在经纬度
            $info =  $this->getCityByLatitude();

        }else if (empty($ip)){
            return array();
        }else{
            $info =  $this->getCityByIp();

        }

        return $info;


    }

    /**
     * @param $ip
     * @return mixed
     */
    private function getCityByIp(){


        $content = file_get_contents("http://api.map.baidu.com/location/ip?ak=KzBNK81UAZ3I06fZFRfVXmYk8kpPjdRv&ip={$this->ip}&coor=bd09ll");
        $json = json_decode($content);
        if($json->status ==1  ) {
            // TODO IP定位失败
            return false;
        }
        $lng = $json->{'content'}->{'point'}->{'x'};//经度数据
        $lat =$json->{'content'}->{'point'}->{'y'};//纬度数据
        $this->setLng($lng);
        $this->setLat($lat);
        $re = $this->getCityByLatitude();
        return $re;

    }

    /**
     * 通过经纬度获取城市
     * @param $lat
     * @param $lng
     * @return array
     */
    private function getCityByLatitude(){

        $arr = $this->changeToBaidu($this->lat,$this->lng);

        $url = 'http://api.map.baidu.com/geocoder/v2/?callback=&location='.$arr['y'].','.$arr['x'].'.&output=json&pois=1&ak=KzBNK81UAZ3I06fZFRfVXmYk8kpPjdRv';

        $content = file_get_contents($url);
        $place = json_decode($content,true);

        return $place;
    }

    /**
     * 请求百度经纬度
     * @param $lat int 纬度
     * @param $lng int 经度
     * @return mixed
     */
    public function changeToBaidu($lat,$lng){
        $apiurl = 'http://api.map.baidu.com/geoconv/v1/?coords='.$lng.','.$lat.'&from=1&to=5&ak=KzBNK81UAZ3I06fZFRfVXmYk8kpPjdRv';
        $file = file_get_contents($apiurl);
        $arrpoint = json_decode($file, true);
        return $arrpoint['result'][0];
    }

}