<?php
return array(
//网站路径
'web_path' => '/',
//Session配置
'session_storage' => 'mysql',
'session_ttl' => 86400,
'session_savepath' => CACHE_PATH.'sessions/',
'session_n' => 0,
//Cookie配置
'cookie_domain' => '.sss.com', //Cookie 作用域
'cookie_path' => '/', //Cookie 作用路径
'cookie_pre' => 'yJGhT_', //Cookie 前缀，同一域名下安装多套系统时，请修改Cookie前缀
'cookie_ttl' => 86400, //Cookie 生命周期，0 表示随浏览器进程
//模板相关配置
'tpl_root' => 'templates/', //模板保存物理路径
'tpl_name' => 'default', //当前模板方案目录
'tpl_css' => 'default', //当前样式目录
'tpl_referesh' => 1,
'tpl_edit'=>1,//是否允许在线编辑模板

//附件相关配置 
'upload_path' => INC_PATH.'uploadfile/',
'upload_url' => '/uploadfile/', //附件路径
'attachment_stat' => '1',//是否记录附件使用状态 0 统计 1 统计， 注意: 本功能会加重服务器负担

'statics_path' => '/statics/', //statics
'js_path' => '/statics/js/', //CDN JS
'css_path' => '/statics/css/', //CDN CSS
'img_path' => '/statics/images/', //CDN img
'swf_path' => '/statics/flash/', //CDN flash

'admin_k' => '/statics/admin/', //CDN ADMIN
'admin_js' => '/statics/admin/js/', //CDN JS
'admin_css' => '/statics/admin/css/', //CDN CSS
'admin_img' => '/statics/admin/images/', //CDN img
'admin_swf' => '/statics/admin/flash/', //CDN flash

'app_path' => 'http://www.sss.com/',//动态域名配置地址
'admin_path' => '/s_admin/',//后台

'charset' => 'utf-8', //网站字符集
'timezone' => 'Etc/GMT-8', //网站时区（只对php 5.1以上版本有效），Etc/GMT-8 实际表示的是 GMT+8
'debug' => 1, //是否显示调试信息
'admin_log' => 1, //是否记录后台操作日志
'errorlog' => 0, //1、保存错误日志到 cache/error_log.php | 0、在页面直接显示
'gzip' => 1, //是否Gzip压缩后输出
'auth_key' => 'GGdNsgSOigD3imWusEGs', //密钥
'oracle_key' => 'GGFGN2gsOiEGsGSdfLTsrr23@#dg634#$', //oracle自增密钥
'lang' => 'zh-cn',  //网站语言包
'lock_ex' => '1',  //写入缓存时是否建立文件互斥锁定（如果使用nfs建议关闭）

'admin_founders' => '1', //网站创始人ID，多个ID逗号分隔
'execution_sql' => 0, //EXECUTION_SQL

'html_root' => '/html',//生成静态文件路径
'safe_card'=>'1',//是否启用口令卡

'connect_enable' => '1',	//是否开启外部通行证
'sina_akey' => '3536051867',	//sina AKEY
'sina_skey' => '13694152b7bd4c350382938ae3072072',	//sina SKEY
'qq_akey' => '',	//qq skey
'qq_skey' => '',	//qq skey

'plugin_debug' => '0',	//插件测试
'admin_url' => '',	//允许访问后台的域名
);
?>