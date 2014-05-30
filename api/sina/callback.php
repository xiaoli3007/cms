<?php  session_start();


require dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."inc".DIRECTORY_SEPARATOR."common.php";

include_once( 'config.php' );

include_once( 'saetv2.ex.class.php' );

$image = inc_base::load_sys_class('image');
inc_base::load_sys_func('dir');

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

$code=$_GET['code'];
if (isset($code)) {
	
	
$keys = array();
	$keys['code'] = $code;
	$keys['redirect_uri'] = WB_CALLBACK_URL;
	try {
		$token = $o->getAccessToken( 'code', $keys ) ;
	} catch (OAuthException $e) {
	}

	
}

if ($token) {
	$_SESSION['token'] = $token;
	setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
	
	$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
$ms  = $c->home_timeline(); // done
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息

	$xin_token=$_SESSION['token']['access_token'];				//新浪从新登录个人验证码会变 


$weibo_info = $c->user_timeline_by_id( $uid,1,30);//获取用户最新微博50条


$category_db = inc_base::load_model('category_model');


	foreach($weibo_info['statuses'] as $key=>$v){
		if($v['retweeted_status']['original_pic']){
			$sina_webpic = $v['retweeted_status']['original_pic'];
			$fileext = fileext($sina_webpic);
			$upload_root = inc_base::load_config('system','upload_path');
			$myDirDate = date('Y/md/');
			$savepath = $upload_root.$myDirDate;
			$temp_filename = date('Ymdhis').rand(100, 999).'.'.$fileext;;
			
			$savefile = $savepath.$temp_filename;
			$webfile = $myDirDate.$temp_filename;
			
			if(!dir_create($savepath)) {
				die('目录不存在');
			}
	
			if($filestr=file_get_contents($sina_webpic)){
				write_file($savefile,$filestr);
			}

		
			
		$thumb_setting = array('210','210');
		$thumb_enable = is_array($thumb_setting) && ($thumb_setting[0] > 0 || $thumb_setting[1] > 0 ) ? 1 : 0;			
		$image = new image($thumb_enable);				
		$image->thumb($savefile,'',$thumb_setting[0],$thumb_setting[1],'_210x210',1);
		$picurl_210 = substr($webfile, 0, strrpos($webfile, '.')).'_210x210'.'.'.$fileext;
		
			
			
		}else{
			$webfile = '';
		}
		if($webfile){
		$infos[$key]['inputtime']=time() ;
		$infos[$key]['title']=str_cut(safe_replace($v['retweeted_status']['text']),40);
		$infos[$key]['thumb']=$webfile;
		$infos[$key]['thumb_middle']=$picurl_210;
		$infos[$key]['description']=safe_replace($v['source']['text']);
		$infos[$key]['content']=safe_replace($v['retweeted_status']['text']);
		$infos[$key]['weibo_id']=$v['id'];
		$infos[$key]['type']='sina';
		}
	}

	$news_db = inc_base::load_model('news_model');

	foreach($infos as $v){
		
		$aa=$news_db->get_one(array('weibo_id'=>$v['weibo_id']));
		if(!$aa['id']){
		$news_db->insert($v);
		}
	}
	echo "<script> alert('更新成功！');window.opener.showinfotoflash(); window.close(); </script>";

			
	exit;



	
	
	
	}
?>

