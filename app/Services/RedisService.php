<?php
/**
 * 557 HiNewsServer.
 * @author WiconWang <WiconWang@gmail.com>
 * @copyright  2019/2/20 3:22 PM
 */

namespace App\Services;


use App\Utilities\RedisHelper;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Support\Facades\Redis;

class RedisService
{
    use MakesHttpRequests;

    public function checkCaptcha($module, $account, $captcha)
    {
        $key = RedisHelper::keyBuilder('Captcha', $module, $account);
        return Redis::get($key) == $captcha;
    }

    public function forgetCaptcha($module, $account)
    {
        $key = RedisHelper::keyBuilder('Captcha', $module, $account);
        Redis::del($key);
    }

    /**
     * @param $module
     * @param $account
     * @param string $captcha
     */
    public function addCaptcha($module, $account, $captcha = '')
    {
        if (empty($captcha)) {
            $captcha = self::randCode();
        }

        $key = RedisHelper::keyBuilder('Captcha', $module, $account);
        Redis::set($key, $captcha);
    }

    /**
     * 生成4位随机数字
     */
    public function randCode()
    {
        return sprintf('%04d', rand(1e3, 1e4 - 1));
    }

    /**
     * 向account发送短信（废用）
     *
     * @param $mobile
     * @param $vCode
     * @return int
     */
    public function sendSMS($mobile, $vCode)
    {
        $content = sprintf('【11】您的验证码是:%s ，请在10分钟内输入，并注意保密。', $vCode);
        $xurl = 'https://api.dingdongcloud.com/v1/sms/sendyzm';
        $data = [
            'apikey' => '1',
            'mobile' => $mobile,
            'content' => $content,
        ];

        $client = new Client();
        $response = $client->post($xurl, [
            'form_params' => $data,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ]);

        $respContent = $response->getBody()->getContents();
        $res = json_decode($respContent);
        if ($res->code > 1) {
            return false;
        }
        return true;
    }

    /**
     * 向account发送短信
     *
     * @param $mobile
     * @param $vCode
     * @return int
     */
    public function sendSMSNew($mobile, $vCode)
    {
        $content = '【1】您的验证码是: ' . $vCode . '，请在10分钟内输入，并注意保密。';
        $xurl = 'http://cf.51welink.com/submitdata/service.asmx/';
        $data = [
            'sname' => '1', // 1
            'spwd' => '1',
            'scorpid' => '',
            'sprdid' => '1012818',
            'sdst' => $mobile,
            'smsg' => $content
        ];
        $data1 = 'sname=dlhejd11&spwd=1&scorpid=&sprdid=1012818&sdst=' . $mobile . '&smsg=' . urlencode($content);


//        $client = new Client();
//        $response = $client->get($xurl, [
//            'g_Submit' => $data,
//            'headers' => [
//                'Content-Type' => 'application/x-www-form-urlencoded'
//            ]
//        ]);

        $url = $xurl . 'g_Submit?' . $data1;

        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        $xml_json = json_encode(simplexml_load_string($output));
        $xml_arr = json_decode($xml_json, true);
        if ($xml_arr['State'] == 0) {
            return true;
        }
        return false;


//        $respContent = $response->getBody()->getContents();
//        $res = json_decode($respContent);
//        if ($res->code > 1){
//            return false;
//        }
//        return true;
    }
}
