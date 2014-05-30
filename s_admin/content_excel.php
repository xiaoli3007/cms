<?php
require dirname(__FILE__).DIRECTORY_SEPARATOR."admin_common.php";

$image = inc_base::load_sys_class('image');
inc_base::load_sys_func('dir');

inc_base::load_sys_class('db_excel_one','',0);
inc_base::load_sys_class('db_excel_two','',0);
$news_db = inc_base::load_model('news_model');
$news_data_db = inc_base::load_model('news_data_model');
$category_db = inc_base::load_model('category_model');
$admin_db = inc_base::load_model('admin_model');

$member_db = inc_base::load_model('member_model');

/*$countrys_config=array('0'=>'美国','1'=>'英国','2'=>'澳大利亚','3'=>'加拿大','4'=>'新西兰','5'=>'新加坡','6'=>'韩国','7'=>'香港','8'=>'马来西亚','9'=>'德国','10'=>'荷兰','11'=>'挪威','12'=>'瑞典','13'=>'芬兰','14'=>'丹麦','15'=>'西班牙');


$laiyuan_config=array('0'=>'400','1'=>'商桥','2'=>'短信','3'=>'免费电话','4'=>'内部推荐','5'=>'代理推荐','6'=>'其他媒介');
$leixing_config=array('0'=>'紧急','1'=>'重要','2'=>'普通','3'=>'长期','4'=>'放弃','5'=>'签约');
$xueli_config=array('0'=>'初中','1'=>'高一','2'=>'高二','3'=>'高三','4'=>'大专','5'=>'大一','6'=>'大二','6'=>'大三','6'=>'大四','6'=>'研究生');
*/

if(isset($_POST['dosubmit'])) {
	
		$upload_root = inc_base::load_config('system','upload_path');
		$file = $upload_root.'excel/'.$_POST['excel_file'];
		
		
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('utf-8');
		$data->read($file);
		
		$data=$data->sheets;
				
		//unset($data[0]['cells'][1]);
		$aa=$data[0]['cells'];
		
		
		$shuzi_image=array(1,1,'03','05','07',12,13,14,18,19,20,24,25,26,30,31,32,36,37,38,42,43,44,48,49,50,54,55,56,60,61,62,66,67,68,72,73,74,78,79,80,84,85,86,90,91,92);
		
		
		foreach($aa as $key=>$nn){
			
echo 	' <li><a href="'.$nn[2].'" ><img src="images/xianshiqianggou2014_'.$shuzi_image[$key].'.jpg" />  <label class="xs_djs">还剩 5 时 45 分 28 秒</label></a>
          
            <p><a href="'.$nn[2].'" class="xianshizhuanti_title">'.$nn[1].'</a>
            <br><span><font>￥</font>'.$nn[3].'.0<s>￥'.$nn[4].'.0</s></span><a href="'.$nn[2].'" class="xianshizhuanti_qianggou"  ></a>
            </p>
            </li>';
	
			
	
			
		}
		//print_r($aa);
		exit;
		unset($aa[1]);
		/**/
		foreach($aa as $cc){
			/*foreach($cc as $key=>$dd){
				
			}*/
			$info['first_time']=strtotime($cc[2]);
			$info['laiyuan']=$cc[3];
			$info['leixing']=$cc[4];
			$info['country']=$cc[5];
			$info['name']=$cc[6];
			$info['xueli']=$cc[7];
			$info['tel']=$cc[8];
			$info['email']=$cc[9];
			$info['ruxue_date']=strtotime($cc[10]);
			$info['qianyue_date']=strtotime($cc[11]);
			$info['diqu']=$cc[12];
			$cc[14]=trim($cc[14]);
			$asdsad =$admin_db->get_one(array('realname'=>$cc[14]));
			if($asdsad){
			$info['admin_id']=$asdsad['userid'];	
			}else{
			$info['admin_id']='';	
			}
			//$info['description']=$cc[14];
			
			$new_id=$news_db->insert($info,true);
			if($cc[17]){
				$info_data['date']=time();
				$info_data['news_id']=$new_id;
				$info_data['admin_id']=$asdsad['userid'];
				$info_data['contents']=addslashes($cc[17]);
				$news_data_db->insert($info_data,true);
			}
			if($cc[18]){
				$info_data['date']=time();
				$info_data['news_id']=$new_id;
				$info_data['admin_id']=$asdsad['userid'];
				$info_data['contents']=addslashes($cc[18]);
				$news_data_db->insert($info_data,true);
			}
			if($cc[19]){
				$info_data['date']=time();
				$info_data['news_id']=$new_id;
				$info_data['admin_id']=$asdsad['userid'];
				$info_data['contents']=addslashes($cc[19]);
				$news_data_db->insert($info_data,true);
			}
			if($cc[20]){
				$info_data['date']=time();
				$info_data['news_id']=$new_id;
				$info_data['admin_id']=$asdsad['userid'];
				$info_data['contents']=addslashes($cc[20]);
				$news_data_db->insert($info_data,true);
			}
			if($cc[21]){
				$info_data['date']=time();
				$info_data['news_id']=$new_id;
				$info_data['contents']=addslashes($cc[21]);
				$news_data_db->insert($info_data,true);
			}
			
			
		}
			
			
		/*$info['inputtime']=time();
		
		$info['admin_id'] =$_SESSION['userid'];	
		$info['description']=addslashes($info['description']);
		$info['content']=addslashes($info['content']);
		
		$news_db->insert($info);*/

		showmessage(L('operation_success'),'content_member.php',1000);
		
	}else{
	
	
	
	include $admin->admin_tpl('content_excel');

}
		
		
?>