<?php
//session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );
//require("../api/global.php");

$aa='2.00rHxqECbYUo8C0e5d59e3aajsl2RB';


function sina_timemachine($timetoken,$timetext,$image){				//时光机发送定时器
global $db,$pre;
		
$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,  $timetoken );
$ms  = $c->home_timeline(); // done
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息
$picadd=$webdb['photo_url']."/".$image;
$ret = $c->upload( $timetext,$picadd);	//发送微博

return $ret;
}



function sina_post($timetext,$timetoken	,$imagess){				//发送海报
global $db,$pre;
		
$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,  $timetoken );
$ms  = $c->home_timeline(); // done
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息

$ret = $c->upload( $timetext,$imagess);	//发送微博

return $ret['id'];
}


function sina_friend($timetoken,$next=0){				//获取好友
global $db,$pre;
	
$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,  $timetoken );
$ms  = $c->home_timeline(); // done
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息

$followers=$c->followers_by_id($uid,$next,200);

foreach($followers['users'] as $key=>$v){
	
	$fensi['users'][$key]['name_full']=$v['name'];
	//$fensi['users'][$key]['name']=$v['name'];
	$fensi['users'][$key]['name']=get_word($v['name'],10);
	$fensi['users'][$key]['tou']=$v['profile_image_url'];

	}
	$fensi['previous_cursor'] = $followers['previous_cursor'];
	$fensi['next_cursor'] = $followers['next_cursor'];

	return $fensi;
}



?>