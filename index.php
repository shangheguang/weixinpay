<?php
/**
 * @desc 微信APP支付(服务器端完成统一下单,将数据传输给APP,APP调起返回的微信支付信息完成支付)
 * @author shangheguang@yeah.net
 * @date 2015-08-24
 */

require_once 'Wxpay.php';

$Wxpay = new Wxpay();
$total_fee = 1; //订单总金额，单位为分
$Wxpay->total_fee = $total_fee*100;//订单的金额
$Wxpay->out_trade_no = date('YmdHis') . substr(time(), - 5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));//订单号
$Wxpay->body = '描述信息';//支付描述信息
$Wxpay->time_expire = date('YmdHis', time()+86400);//订单支付的过期时间(eg:一天过期)
$Wxpay->notify_url = 'http://www.baidu.cn/v1/wxpay/notify/';//异步通知URL(更改支付状态)

//数据以JSON的形式返回给APP
$responseData = array(
    'notify_url' => $Wxpay->notify_url,
    'app_response' => $Wxpay->doPay(),
);
$errorCode = 0;
$errorMsg = 'success';
echoResult($errorCode, $errorMsg, $responseData);

//接口输出
function echoResult($errorCode = 0, $errorMsg = 'success', $responseData=array()) 
{
    $arr = array(
        'errorCode' => $errorCode,
        'errorMsg' => $errorMsg,
        'responseData' => $responseData,
    );
    exit(json_encode($arr));
}

