<?php
 class Pings {
     public $xmlrpc_server;
     public $xmlrpc_response;
     public $methodName;    
    public function __construct() {
         //产生一个XML-RPC的服务器端
         $this->xmlrpc_server = xmlrpc_server_create ();
         $this->run ();
     }
     
    //注册一个服务器端调用的方法rpc_server，实际指向的是ping函数
     public function rpc_server() {        
        $this->methodName = !$this->methodName ? 'weblogUpdates.extendedPing':'weblogUpdates.Ping';        
        xmlrpc_server_register_method ( $this->xmlrpc_server, $this->methodName, array (__CLASS__, "ping"));        
    }
         /**
      * 函数：提供给RPC客户端调用的函数
      * 参数：
      * $method 客户端需要调用的函数
      * $params 客户端需要调用的函数的参数数组
      * 返回：返回指定调用结果
      */    
    public function ping($method, $params) {
         $this->title = $params [0];
         $this->server = $params [1];
         $this->rss = $params [2];
         $this->tag = $params [3];
         //$a  = $this->title ? $this->update():'';
         $string = array ('flerror' => false, 'message' => 'Thanks for the ping.', 'legal' => "You agree that use of the blueidea.com ping service is governed by the Terms of Use found at www.blueidea.com." );
         return $string;
     }
     
    public function update(){
         echo '这里放更新的一些条件';
     }
         
    public function run() {    
        $this->rpc_server ();    
        $request = isset ( $GLOBALS ["HTTP_RAW_POST_DATA"] ) ? file_get_contents ( "php://input" ) : $GLOBALS ["HTTP_RAW_POST_DATA"];        
        $this->xmlrpc_response = xmlrpc_server_call_method ( $this->xmlrpc_server, $request, null );
         //把函数处理后的结果XML进行输出
         header ( 'Content-Type: text/xml' );
         echo $this->xmlrpc_response;
     }
     
    //销毁XML-RPC服务器端资源
     public function __destruct() {
         xmlrpc_server_destroy ( $this->xmlrpc_server );
     }
 }
 $Obj = new Pings ( );
 ?>