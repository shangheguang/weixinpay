-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-07-19 06:16:09
-- 服务器版本： 5.6.19
-- PHP Version: 7.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- 表的结构 `tb_pay_log`
--

CREATE TABLE `tb_pay_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pay_type` tinyint(4) UNSIGNED NOT NULL DEFAULT '0' COMMENT '支付渠道类型[1:支付宝,2微信]',
  `action` varchar(10) NOT NULL DEFAULT '' COMMENT '[return,notify]',
  `domain_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '来源域名(1www 2m 3ios 4android)',
  `out_trade_no` varchar(30) NOT NULL DEFAULT '' COMMENT '商家订单编号',
  `trade_no` varchar(30) NOT NULL DEFAULT '' COMMENT '平台交易号',
  `trade_status` varchar(30) NOT NULL DEFAULT '' COMMENT '交易状态',
  `trade_return_data` text NOT NULL COMMENT '平台返回数据',
  `create_ip` varchar(30) NOT NULL DEFAULT '' COMMENT '用户支付IP',
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tb_pay_log`
--

INSERT INTO `tb_pay_log` (`id`, `pay_type`, `action`, `domain_type`, `out_trade_no`, `trade_no`, `trade_status`, `trade_return_data`, `create_ip`, `create_date`) VALUES
(1, 2, 'notify', 3, '20160108230835657155974231', '1009880762201601082587876156', 'SUCCESS', '<xml><appid><![CDATA[wx2d0ec8fb1ffbbd40]]></appid>\n<attach><![CDATA[121.236.168.34]]></attach>\n<bank_type><![CDATA[CCB_CREDIT]]></bank_type>\n<cash_fee><![CDATA[47200]]></cash_fee>\n<fee_type><![CDATA[CNY]]></fee_type>\n<is_subscribe><![CDATA[N]]></is_subscribe>\n<mch_id><![CDATA[1236540002]]></mch_id>\n<nonce_str><![CDATA[vBkngd6Sc4nPWbfYwIgzf6ALtW2HOX0J]]></nonce_str>\n<openid><![CDATA[o-aWfjh-OguF2j0qo7iDhqGEFbus]]></openid>\n<out_trade_no><![CDATA[20160108230835657155974231]]></out_trade_no>\n<result_code><![CDATA[SUCCESS]]></result_code>\n<return_code><![CDATA[SUCCESS]]></return_code>\n<sign><![CDATA[25CF0BE4B485A3BE7CD8A5DA045D786A]]></sign>\n<time_end><![CDATA[20160108230853]]></time_end>\n<total_fee>47200</total_fee>\n<trade_type><![CDATA[APP]]></trade_type>\n<transaction_id><![CDATA[1009880762201601082587876156]]></transaction_id>\n</xml>', '140.207.54.75', '2016-01-08 23:08:52'),
(2, 1, 'notify', 3, '20151221230600103605339363', '2015122121001004100010912642', 'TRADE_FINISHED', 'discount=0.00&payment_type=1&subject=标题&trade_no=2015111821001004460078599104&buyer_email=243882284@qq.com&gmt_create=2015-12-18 22:01:37&notify_type=trade_status_sync&quantity=1&out_trade_no=20151218220127472878962898&seller_id=2033901888618287&notify_time=2016-03-18 22:02:34&body=主题&trade_status=TRADE_FINISHED&is_total_fee_adjust=N&total_fee=120.00&gmt_payment=2015-12-18 22:01:38&seller_email=shangheguang@yeah.com&gmt_close=2016-03-18 22:02:34&price=120.00&buyer_id=1288702326699464&notify_id=e9063f932b7bc86b85366a5b7451a27jjs&use_coupon=N&sign_type=RSA&sign=ANpF7OIJHIatkrBpbrY1dQKQqKlK8PQOlbZiOQX5r19S5FE7Eb9ArC5tN5n19X2fIEtRcD9rLctM9F1uc4VAxMOt8j+DWZa+5YuBHGMuoA+0E3WDTBeAq59veLtbno1PL1vPWpEaz8zXbRH1Nt55XC3oTCR8Wfvdt2/eTbTAjLM=', '110.75.225.147', '2016-03-21 23:06:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_pay_log`
--
ALTER TABLE `tb_pay_log`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `tb_pay_log`
--
ALTER TABLE `tb_pay_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
