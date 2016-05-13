<?php

class WxPayHelper{
	
    /**
     * 验证签名
     * @param array $data
     * @param string $key
     * @return string
     */
	function getVerifySign($data, $key) 
	{
		$String = $this->formatParameters($data, false);
		//签名步骤二：在string后加入KEY
		$String = $String . "&key=" . $key;
		//签名步骤三：MD5加密
		$String = md5($String);
		//签名步骤四：所有字符转为大写
		$result = strtoupper($String);
		return $result;
	}
	
	function formatParameters($paraMap, $urlencode) 
	{
		$buff = "";
		ksort($paraMap);
		foreach ($paraMap as $k => $v) {
			if($k=="sign"){
				continue;
			}
			if ($urlencode) {
				$v = urlencode($v);
			}
			$buff .= $k . "=" . $v . "&";
		}
		$reqPar;
		if (strlen($buff) > 0) {
			$reqPar = substr($buff, 0, strlen($buff) - 1);
		}
		return $reqPar;
	}
	
	/**
	 * 得到签名
	 * @param object $obj
	 * @param string $api_key
	 * @return string
	 */
    function getSign($obj, $api_key)
    {
        foreach ($obj as $k => $v)
        {
            $Parameters[strtolower($k)] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //签名步骤二：在string后加入KEY
        $String = $String."&key=".$api_key;
        //签名步骤三：MD5加密
        $result = strtoupper(md5($String));
        return $result;
    }

    /**
     * 获取指定长度的随机字符串
     * @param int $length
     * @return Ambigous <NULL, string>
     */
    function getRandChar($length){
       $str = null;
       $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
       $max = strlen($strPol)-1;
       for($i=0;$i<$length;$i++){
            $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
       }
       return $str;
    }

    /**
     * 数组转xml
     * @param array $arr
     * @return string
     */
    function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
             if (is_numeric($val))
             {
                $xml.="<".$key.">".$val."</".$key.">"; 

             }
             else
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";  
        }
        $xml.="</xml>";
        return $xml; 
    }
	
	/**
     * 以post方式提交xml到对应的接口url
     *
     * @param string $xml  需要post的xml数据
     * @param string $url  url
     * @param bool $useCert 是否需要证书，默认不需要
     * @param int $second   url执行超时时间，默认30s
     * @throws WxPayException
     */
	function postXmlCurl($xml, $url, $second=30, $useCert=false, $sslcert_path='', $sslkey_path='')
	{
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch,CURLOPT_URL, $url);

		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
	
		if($useCert == true){
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
			curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
			//设置证书
			//使用证书：cert 与 key 分别属于两个.pem文件
			curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLCERT, $sslcert_path);
			curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLKEY, $sslkey_path);
		}
		//post提交方式
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		//运行curl
		$data = curl_exec($ch);
		 
		//返回结果
		if($data){
			curl_close($ch);
			return $data;
		} else {
			$error = curl_errno($ch);
	
			curl_close($ch);
			return false;
		}
	}
	
	/**
	 * 获取当前服务器的IP
	 * @return Ambigous <string, unknown>
	 */
    function get_client_ip()
    {
        if ($_SERVER['REMOTE_ADDR']) {
            $cip = $_SERVER['REMOTE_ADDR'];
        } elseif (getenv("REMOTE_ADDR")) {
            $cip = getenv("REMOTE_ADDR");
        } elseif (getenv("HTTP_CLIENT_IP")) {
            $cip = getenv("HTTP_CLIENT_IP");
        } else {
            $cip = "unknown";
        }
        return $cip;
    }
 
    /**
     * 将数组转成uri字符串
     * @param array $paraMap
     * @param bool $urlencode
     * @return string
     */
    function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v)
        {
            if($urlencode)
            {
               $v = urlencode($v);
            }
            $buff .= strtolower($k) . "=" . $v . "&";
        }
        $reqPar;
        if (strlen($buff) > 0) 
        {
            $reqPar = substr($buff, 0, strlen($buff)-1);
        }
        return $reqPar;
    }
    
    /**
     * XML转数组
     * @param unknown $xml
     * @return mixed
     */
    function xmlToArray($xml) 
    {
    	//将XML转为array
    	$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    	return $array_data;
    }
	
}
	
	
?>