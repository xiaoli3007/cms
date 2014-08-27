<?php 
try {
	//实例化客户端
/*If working in WSDL mode, this parameter is optional. If working in non-WSDL mode, the location and uri options must be set, where location is the URL to request and uri is the target namespace of the SOAP service.
*/
    $client = new SoapClient(null, // non-WSDL模式，不指定WSDL文件
                             array('location'  =>"http://whpark.easesite.net/api/park_info.php", 
                             'uri' => "http://whpark.easesite.net/"));

    //调用服务端方法，并打印出返回结果                         
    //echo $client->hello('lory','lory');
	
	// echo $client->queryParkList('park','PARKINGinfo168360');
	 echo $client->queryParkInfoById('park','PARKINGinfo168360','254');

} catch (SoapFault $fault){
    echo "Error: ",$fault->faultcode,", string: ",$fault->faultstring;
}
//exit();



?>
