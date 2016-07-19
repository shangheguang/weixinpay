<?php
/**
 * @desc 微信APP支付异步通知，更改订单状态。
 * @author shangheguang@yeah.net
 * @date 2015-08-24
 */

/**
微信接口URL地址：
	https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_7&index=3
微信异步推送的结果格式：
	<xml>
		<appid><![CDATA[wx2d0ec8fb1ffb0000]]></appid>
		<attach><![CDATA[121.230.168.11]]></attach>
		<bank_type><![CDATA[CCB_CREDIT]]></bank_type>
		<cash_fee><![CDATA[47200]]></cash_fee>
		<fee_type><![CDATA[CNY]]></fee_type>
		<is_subscribe><![CDATA[N]]></is_subscribe>
		<mch_id><![CDATA[1236540002]]></mch_id>
		<nonce_str><![CDATA[vBkngd6Sc4nPWbfYwIgzf6ALtW2HOX0J]]></nonce_str>
		<openid><![CDATA[o-aWfjh-OguF2j0qo7iDhqGEFbus]]></openid>
		<out_trade_no><![CDATA[20160108230835657155974231]]></out_trade_no>
		<result_code><![CDATA[SUCCESS]]></result_code>
		<return_code><![CDATA[SUCCESS]]></return_code>
		<sign><![CDATA[25CF0BE4B485A3BE7CD8A5DA045D786A]]></sign>
		<time_end><![CDATA[20160108230853]]></time_end>
		<total_fee>47200</total_fee>
		<trade_type><![CDATA[APP]]></trade_type>
		<transaction_id><![CDATA[1009880762201601082587876156]]></transaction_id>
	</xml>
**/
require_once 'Wxpay.php';
			
$Wxpay = new Wxpay();
$verify_result = $Wxpay->verifyNotify();
if (isset($verify_result['result_code']) && $verify_result['result_code']=='SUCCESS') {
	$requestReturnData = file_get_contents("php://input");
	//商户订单号
	$out_trade_no = $verify_result['out_trade_no'];
	//交易号
	$trade_no     = $verify_result['transaction_id'];
	//交易状态
	$trade_status = $verify_result['result_code'];
	//支付金额
	$total_fee 	  = $verify_result['total_fee']/100;
	//支付过期时间
	$pay_date 	  = $verify_result['time_end'];
	//IP
	$pay_ip 	  = $verify_result['attach'];
	/* 
		@todo
		1.更改订单状态为已支付。(需自己完善)
		2.添加付款信息到数据库,方便对账。(需自己完善)
	*/
	$pay_arr = array(
		'pay_type' 			=> isset($_REQUEST['pay_type']) ? $_REQUEST['pay_type'] : '',
		'action' 			=> 'notify',
		'domain_type' 		=> isset($_REQUEST['domain_type']) ? $_REQUEST['domain_type'] : '',
		'out_trade_no' 		=> $out_trade_no,
		'trade_no' 			=> $trade_no,
		'trade_status' 		=> $trade_status,
		'trade_return_data' => $requestReturnData,
		'create_ip' 		=> $pay_ip,
	);
	//处理后同步返回给微信
	exit('<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>');
}
exit('<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[ERROR]]></return_msg></xml>');


