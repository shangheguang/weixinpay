<?php
/**
 * @desc 微信APP支付(服务器端完成统一下单,将数据传输给APP,APP调起返回的微信支付信息完成支付)
 * @author shangheguang@yeah.net
 * @date 2015-08-24
 */

/**
微信接口URL地址：
	https://api.mch.weixin.qq.com/pay/unifiedorder
应用场景：
	商户系统先调用该接口在微信支付服务后台生成预支付交易单，返回正确的预支付交易回话标识后再在APP里面调起支付。
微信统一下单返回的格式：
	<xml>
	   <appid>wx2421b1c4370ec43b</appid>
	   <attach>支付测试</attach>
	   <body>APP支付测试</body>
	   <mch_id>10000100</mch_id>
	   <nonce_str>1add1a30ac87aa2db72f57a2375d8fec</nonce_str>
	   <notify_url>http://wxpay.weixin.qq.com/pub_v2/pay/notify.v2.php</notify_url>
	   <out_trade_no>1415659990</out_trade_no>
	   <spbill_create_ip>14.23.150.211</spbill_create_ip>
	   <total_fee>1</total_fee>
	   <trade_type>APP</trade_type>
	   <sign>0CB01533B8C1EF103065174F50BCA001</sign>
	</xml>
**/
require_once 'Wxpay.php';

$Wxpay = new Wxpay();
$total_fee = 1; //订单总金额
$Wxpay->total_fee = intval($total_fee*100);//订单的金额 1元
$Wxpay->out_trade_no = date('YmdHis') . substr(time(), - 5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));//订单号
$Wxpay->body = '描述信息';//支付描述信息
$Wxpay->time_expire = date('YmdHis', time()+86400);//订单支付的过期时间(eg:一天过期)
$Wxpay->notify_url = 'http://www.baidu.cn/v1/wxpay/notify/';//异步通知URL(更改支付状态)

//数据以JSON的形式返回给APP
$app_response = $Wxpay->doPay();
if (isset($app_response['return_code']) && $app_response['return_code']=='FAIL') {
	$errorCode = 100;
	$errorMsg = $app_response['return_msg'];
	echoResult($errorCode, $errorMsg);
} else {
	$errorCode = 0;
	$errorMsg = 'success';
	$responseData = array(
	    'notify_url' => $Wxpay->notify_url,
	    'app_response' => $app_response,
	);
	echoResult($errorCode, $errorMsg, $responseData);
}

//接口输出
function echoResult($errorCode = 0, $errorMsg = 'success', $responseData = array()) 
{
    $arr = array(
        'errorCode' => $errorCode,
        'errorMsg' => $errorMsg,
        'responseData' => $responseData,
    );
    exit(json_encode($arr));
}

