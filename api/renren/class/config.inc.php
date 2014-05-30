<?php
/*
 * 总体配置文件，包括API Key, Secret Key，以及所有允许调用的API列表
 * This file for configure all necessary things for invoke, including API Key, Secret Key, and all APIs list
 *
 * @Modified by mike on 17:54 2011/12/21.
 * @Modified by Edison tsai on 16:34 2011/01/13 for remove call_id & session_key in all parameters.
 * @Created: 17:21:04 2010/11/23
 * @Author:	Edison tsai<dnsing@gmail.com>
 * @Blog:	http://www.timescode.com
 * @Link:	http://www.dianboom.com
 */

$config				= new stdClass;

$config->APIURL		= 'http://api.renren.com/restserver.do'; //RenRen网的API调用地址，不需要修改
$config->APPID		= '224983';	//你的API Key，请自行申请
$config->APIKey		= 'b6f006f8d8884d0aa925831ac8d5a23a';	//你的API Key，请自行申请
$config->SecretKey	= 'da553c9db70e45f28955603ae2871e4a';	//你的API 密钥
$config->APIVersion	= '1.0';	//当前API的版本号，不需要修改
$config->decodeFormat	= 'json';	//默认的返回格式，根据实际情况修改，支持：json,xml

$config->redirecturi= 'http://www.saibaohui.com/api/renren/accesstoken.php';//你的获取code的回调地址，也是accesstoken的回调地址
$config->scope='publish_feed,photo_upload';
?>