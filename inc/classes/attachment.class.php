<?php 
class attachment {
	var $contentid;
	var $module;
	var $catid;
	var $attachments;
	var $field;
	var $imageexts = array('gif', 'jpg', 'png');
	var $uploadedfiles = array();
	var $downloadedfiles = array();
	var $error;
	var $upload_root;
	var $siteid;
	var $site = array();
	
	function __construct($upload_dir = '') {
		inc_base::load_sys_func('dir');		
		inc_base::load_sys_class('image','','0');
		$this->upload_root = inc_base::load_config('system','upload_path');
		$this->upload_func = 'copy';
		$this->upload_dir = $upload_dir;
	}
	/**
	 * 附件上传方法
	 * @param $field 上传字段
	 * @param $alowexts 允许上传类型
	 * @param $maxsize 最大上传大小
	 * @param $overwrite 是否覆盖原有文件
	 * @param $thumb_setting 缩略图设置
	 * @param $watermark_enable  是否添加水印
	 */
	function upload($field, $alowexts = '', $maxsize = 0, $overwrite = 0,$thumb_setting = array(), $watermark_enable = 1) {
		if(!isset($_FILES[$field])) {
			$this->error = UPLOAD_ERR_OK;
			return false;
		}
		if(empty($alowexts) || $alowexts == '') {
			$alowexts = 'jpg|jpeg|gif|bmp|png|doc|docx|xls|xlsx|ppt|pptx|pdf|txt|rar|zip|swf';
		}
			
		$this->field = $field;
		$myDirDate = $this->upload_dir.date('Y/md/');
		$this->savepath = $this->upload_root.$myDirDate;
		$this->alowexts = $alowexts;
		$this->maxsize = $maxsize * 1024;
		$this->overwrite = $overwrite;

		if(!$description) $description = '';
		$file = array('tmp_name' => $_FILES[$field]['tmp_name'], 'name' => $_FILES[$field]['name'], 'type' => $_FILES[$field]['type'], 'size' => $_FILES[$field]['size'], 'error' => $_FILES[$field]['error']);

		if(!dir_create($this->savepath)) {
			$this->error = '8';
			return false;
		}
		if(!is_dir($this->savepath)) {
			$this->error = '8';
			return false;
		}
		@chmod($this->savepath, 0777);

		if(!is_writeable($this->savepath)) {
			$this->error = '9';
			return false;
		}
		
		$fileext = fileext($file['name']);
		if($file['error'] != 0) {
			$this->error = $file['error'];
			return false;				
		}
		if(!preg_match("/^(".$this->alowexts.")$/", $fileext)) {
			$this->error = '10';
			return false;
		}
		
		if($this->maxsize && $file['size'] > $this->maxsize) {
			$this->error = '11';
			return false;
		}
		if(!$this->isuploadedfile($file['tmp_name'])) {
			$this->error = '12';
			return false;
		}
		$temp_filename = $this->getname($fileext);
		$savefile = $this->savepath.$temp_filename;
		$webfile = $myDirDate.$temp_filename;
		
		$savefile = preg_replace("/(php|phtml|php3|php4|jsp|exe|dll|asp|cer|asa|shtml|shtm|aspx|asax|cgi|fcgi|pl)(\.|$)/i", "_\\1\\2", $savefile);
		$filepath = preg_replace(new_addslashes("|^".$this->upload_root."|"), "", $savefile);
		if(!$this->overwrite && file_exists($savefile)) continue;
		$upload_func = $this->upload_func;
		
	/*	@$aa=copy($file['tmp_name'],$savefile);
		
		print_r($savefile); 
		exit; */
		if(@$upload_func($file['tmp_name'], $savefile)) {
			@chmod($savefile, 0644);
			@unlink($file['tmp_name']);

		}

		return $webfile;
	}
	
	
		/**
	 * 附件上传方法
	 * @param $field 上传字段
	 * @param $alowexts 允许上传类型
	 * @param $maxsize 最大上传大小
	 * @param $overwrite 是否覆盖原有文件
	 * @param $thumb_setting 缩略图设置
	 * @param $watermark_enable  是否添加水印
	 */
	function upload_excel($field, $alowexts = '', $maxsize = 0, $overwrite = 0,$thumb_setting = array(), $watermark_enable = 1) {
		if(!isset($_FILES[$field])) {
			$this->error = UPLOAD_ERR_OK;
			return false;
		}
		if(empty($alowexts) || $alowexts == '') {
			$alowexts = 'jpg|jpeg|gif|bmp|png|doc|docx|xls|xlsx|ppt|pptx|pdf|txt|rar|zip|swf';
		}
			
		$this->field = $field;
		$myDirDate = $this->upload_dir.date('Y/md/');
		$this->savepath = $this->upload_root.'excel/'.$myDirDate;
		$this->alowexts = $alowexts;
		$this->maxsize = $maxsize * 1024;
		$this->overwrite = $overwrite;

		if(!$description) $description = '';
		$file = array('tmp_name' => $_FILES[$field]['tmp_name'], 'name' => $_FILES[$field]['name'], 'type' => $_FILES[$field]['type'], 'size' => $_FILES[$field]['size'], 'error' => $_FILES[$field]['error']);

		if(!dir_create($this->savepath)) {
			$this->error = '8';
			return false;
		}
		if(!is_dir($this->savepath)) {
			$this->error = '8';
			return false;
		}
		@chmod($this->savepath, 0777);

		if(!is_writeable($this->savepath)) {
			$this->error = '9';
			return false;
		}
		
		$fileext = fileext($file['name']);
		if($file['error'] != 0) {
			$this->error = $file['error'];
			return false;				
		}
		if(!preg_match("/^(".$this->alowexts.")$/", $fileext)) {
			$this->error = '10';
			return false;
		}
		
		if($this->maxsize && $file['size'] > $this->maxsize) {
			$this->error = '11';
			return false;
		}
		if(!$this->isuploadedfile($file['tmp_name'])) {
			$this->error = '12';
			return false;
		}
		$temp_filename = $this->getname($fileext);
		$savefile = $this->savepath.$temp_filename;
		$webfile = $myDirDate.$temp_filename;
		
		$savefile = preg_replace("/(php|phtml|php3|php4|jsp|exe|dll|asp|cer|asa|shtml|shtm|aspx|asax|cgi|fcgi|pl)(\.|$)/i", "_\\1\\2", $savefile);
		$filepath = preg_replace(new_addslashes("|^".$this->upload_root."|"), "", $savefile);
		if(!$this->overwrite && file_exists($savefile)) continue;
		$upload_func = $this->upload_func;
		
	/*	@$aa=copy($file['tmp_name'],$savefile);
		
		print_r($savefile); 
		exit; */
		if(@$upload_func($file['tmp_name'], $savefile)) {
			@chmod($savefile, 0644);
			@unlink($file['tmp_name']);

		}

		return $webfile;
	}
		/**
	 * 影集上传方法
	 * @param $field 上传字段
	 * @param $alowexts 允许上传类型
	 * @param $maxsize 最大上传大小
	 * @param $overwrite 是否覆盖原有文件
	 * @param $thumb_setting 缩略图设置
	 * @param $watermark_enable  是否添加水印
	 */
	function upload_photo($field, $alowexts = '', $maxsize = 0, $overwrite = 0,$thumb_setting = array(), $watermark_enable = 1) {
		if(!isset($_FILES[$field])) {
			$this->error = UPLOAD_ERR_OK;
			return false;
		}
		if(empty($alowexts) || $alowexts == '') {
			$alowexts = 'jpg|jpeg|gif|bmp|png|doc|docx|xls|xlsx|ppt|pptx|pdf|txt|rar|zip|swf';
		}
			
		$this->field = $field;
		$myDirDate = $this->upload_dir.date('Y/md/');
		$this->savepath = $this->upload_root.'photo/'.$myDirDate;
		$this->alowexts = $alowexts;
		$this->maxsize = $maxsize * 1024;
		$this->overwrite = $overwrite;

		if(!$description) $description = '';
		$file = array('tmp_name' => $_FILES[$field]['tmp_name'], 'name' => $_FILES[$field]['name'], 'type' => $_FILES[$field]['type'], 'size' => $_FILES[$field]['size'], 'error' => $_FILES[$field]['error']);

		if(!dir_create($this->savepath)) {
			$this->error = '8';
			return false;
		}
		if(!is_dir($this->savepath)) {
			$this->error = '8';
			return false;
		}
		@chmod($this->savepath, 0777);

		if(!is_writeable($this->savepath)) {
			$this->error = '9';
			return false;
		}
		
		$fileext = fileext($file['name']);
		if($file['error'] != 0) {
			$this->error = $file['error'];
			return false;				
		}
		if(!preg_match("/^(".$this->alowexts.")$/", $fileext)) {
			$this->error = '10';
			return false;
		}
		
		if($this->maxsize && $file['size'] > $this->maxsize) {
			$this->error = '11';
			return false;
		}
		if(!$this->isuploadedfile($file['tmp_name'])) {
			$this->error = '12';
			return false;
		}
		$temp_filename = $this->getname($fileext);
		$savefile = $this->savepath.$temp_filename;
		$webfile = $myDirDate.$temp_filename;
		
		$savefile = preg_replace("/(php|phtml|php3|php4|jsp|exe|dll|asp|cer|asa|shtml|shtm|aspx|asax|cgi|fcgi|pl)(\.|$)/i", "_\\1\\2", $savefile);
		$filepath = preg_replace(new_addslashes("|^".$this->upload_root."|"), "", $savefile);
		if(!$this->overwrite && file_exists($savefile)) continue;
		$upload_func = $this->upload_func;
		
	/*	@$aa=copy($file['tmp_name'],$savefile);
		
		print_r($savefile); 
		exit; */
		if(@$upload_func($file['tmp_name'], $savefile)) {
			@chmod($savefile, 0644);
			@unlink($file['tmp_name']);

		}

		return $webfile;
	}
	function upload_daxiao($field) {
	
		$file = array('tmp_name' => $_FILES[$field]['tmp_name'], 'name' => $_FILES[$field]['name'], 'type' => $_FILES[$field]['type'], 'size' => $_FILES[$field]['size'], 'error' => $_FILES[$field]['error']);

	$file['size']=$this->size($file['size']);
	$file['types']=fileext($file['name']);
		 


		return $file;
	}
	
	/**
	 * 附件下载
	 * Enter description here ...
	 * @param $field 预留字段
	 * @param $value 传入下载内容
	 * @param $watermark 是否加入水印
	 * @param $ext 下载扩展名
	 * @param $absurl 绝对路径
	 * @param $basehref 
	 */
	function download($field, $value,$watermark = '0',$ext = 'gif|jpg|jpeg|bmp|png', $absurl = '', $basehref = '')
	{
		global $image_d;
		$this->att_db = inc_base::load_model('attachment_model');
		$upload_url = inc_base::load_config('system','upload_url');
		$this->field = $field;
		$dir = date('Y/md/');
		$uploadpath = $upload_url.$dir;
		$uploaddir = $this->upload_root.$dir;
		$string = new_stripslashes($value);
		if(!preg_match_all("/(href|src)=([\"|']?)([^ \"'>]+\.($ext))\\2/i", $string, $matches)) return $value;
		$remotefileurls = array();
		foreach($matches[3] as $matche)
		{
			if(strpos($matche, '://') === false) continue;
			dir_create($uploaddir);
			$remotefileurls[$matche] = $this->fillurl($matche, $absurl, $basehref);
		}
		unset($matches, $string);
		$remotefileurls = array_unique($remotefileurls);
		$oldpath = $newpath = array();
		foreach($remotefileurls as $k=>$file) {
			if(strpos($file, '://') === false || strpos($file, $upload_url) !== false) continue;
			$filename = fileext($file);
			$file_name = basename($file);
			$filename = $this->getname($filename);

			$newfile = $uploaddir.$filename;
			$upload_func = $this->upload_func;
			if($upload_func($file, $newfile)) {
				$oldpath[] = $k;
				$GLOBALS['downloadfiles'][] = $newpath[] = $uploadpath.$filename;
				@chmod($newfile, 0777);
				$fileext = fileext($filename);
				if($watermark){
					watermark($newfile, $newfile,$this->siteid);
				}
				$filepath = $dir.$filename;
				$downloadedfile = array('filename'=>$filename, 'filepath'=>$filepath, 'filesize'=>filesize($newfile), 'fileext'=>$fileext);
				$aid = $this->add($downloadedfile);
				$this->downloadedfiles[$aid] = $filepath;
			}
		}
		return str_replace($oldpath, $newpath, $value);
	}	
	/**
	 * 附件删除方法
	 * @param $where 删除sql语句
	 */
	function delete($where) {
		$this->att_db = inc_base::load_model('attachment_model');
		$result = $this->att_db->select($where);
		foreach($result as $r) {
			$image = $this->upload_root.$r['filepath'];
			@unlink($image);
			$thumbs = glob(dirname($image).'/*'.basename($image));
			if($thumbs) foreach($thumbs as $thumb) @unlink($thumb);
		}
		return $this->att_db->delete($where);
	}
	
	/**
	 * 附件添加如数据库
	 * @param $uploadedfile 附件信息
	 */
	function add($uploadedfile) {
		$this->att_db = inc_base::load_model('attachment_model');
		$uploadedfile['module'] = $this->module;
		$uploadedfile['catid'] = $this->catid;
		$uploadedfile['siteid'] = $this->siteid;
		$uploadedfile['userid'] = $this->userid;
		$uploadedfile['uploadtime'] = SYS_TIME;
		$uploadedfile['uploadip'] = ip();
		$uploadedfile['status'] = inc_base::load_config('system','attachment_stat') ? 0 : 1;
		$uploadedfile['authcode'] = md5($uploadedfile['filepath']);
		$uploadedfile['filename'] = strlen($uploadedfile['filename'])>49 ? $this->getname($uploadedfile['fileext']) : $uploadedfile['filename'];
		$uploadedfile['isimage'] = in_array($uploadedfile['fileext'], $this->imageexts) ? 1 : 0;
		$aid = $this->att_db->api_add($uploadedfile);
		$this->uploadedfiles[] = $uploadedfile;
		return $aid;
	}
	
	function set_userid($userid) {
		$this->userid = $userid;
	}
	/**
	 * 获取缩略图地址..
	 * @param $image 图片路径
	 */
	function get_thumb($image){
		return str_replace('.', '_thumb.', $image);
	}


	/**
	 * 获取附件名称
	 * @param $fileext 附件扩展名
	 */
	function getname($fileext){
		return date('Ymdhis').rand(100, 999).'.'.$fileext;
	}

	/**
	 * 返回附件大小
	 * @param $filesize 图片大小
	 */
	
	function size($filesize) {
		if($filesize >= 1073741824) {
			$filesize = round($filesize / 1073741824 * 100) / 100 . ' GB';
		} elseif($filesize >= 1048576) {
			$filesize = round($filesize / 1048576 * 100) / 100 . ' MB';
		} elseif($filesize >= 1024) {
			$filesize = round($filesize / 1024 * 100) / 100 . ' KB';
		} else {
			$filesize = $filesize . ' Bytes';
		}
		return $filesize;
	}
	/**
	* 判断文件是否是通过 HTTP POST 上传的
	*
	* @param	string	$file	文件地址
	* @return	bool	所给出的文件是通过 HTTP POST 上传的则返回 TRUE
	*/
	function isuploadedfile($file) {
		return is_uploaded_file($file) || is_uploaded_file(str_replace('\\\\', '\\', $file));
	}
	
	/**
	* 补全网址
	*
	* @param	string	$surl		源地址
	* @param	string	$absurl		相对地址
	* @param	string	$basehref	网址
	* @return	string	网址
	*/
	function fillurl($surl, $absurl, $basehref = '') {
		if($basehref != '') {
			$preurl = strtolower(substr($surl,0,6));
			if($preurl=='http://' || $preurl=='ftp://' ||$preurl=='mms://' || $preurl=='rtsp://' || $preurl=='thunde' || $preurl=='emule://'|| $preurl=='ed2k://')
			return  $surl;
			else
			return $basehref.'/'.$surl;
		}
		$i = 0;
		$dstr = '';
		$pstr = '';
		$okurl = '';
		$pathStep = 0;
		$surl = trim($surl);
		if($surl=='') return '';
		$urls = @parse_url(SITE_URL);
		$HomeUrl = $urls['host'];
		$BaseUrlPath = $HomeUrl.$urls['path'];
		$BaseUrlPath = preg_replace("/\/([^\/]*)\.(.*)$/",'/',$BaseUrlPath);
		$BaseUrlPath = preg_replace("/\/$/",'',$BaseUrlPath);
		$pos = strpos($surl,'#');
		if($pos>0) $surl = substr($surl,0,$pos);
		if($surl[0]=='/') {
			$okurl = 'http://'.$HomeUrl.'/'.$surl;
		} elseif($surl[0] == '.') {
			if(strlen($surl)<=2) return '';
			elseif($surl[0]=='/') {
				$okurl = 'http://'.$BaseUrlPath.'/'.substr($surl,2,strlen($surl)-2);
			} else {
				$urls = explode('/',$surl);
				foreach($urls as $u) {
					if($u=="..") $pathStep++;
					else if($i<count($urls)-1) $dstr .= $urls[$i].'/';
					else $dstr .= $urls[$i];
					$i++;
				}
				$urls = explode('/', $BaseUrlPath);
				if(count($urls) <= $pathStep)
				return '';
				else {
					$pstr = 'http://';
					for($i=0;$i<count($urls)-$pathStep;$i++) {
						$pstr .= $urls[$i].'/';
					}
					$okurl = $pstr.$dstr;
				}
			}
		} else {
			$preurl = strtolower(substr($surl,0,6));
			if(strlen($surl)<7)
			$okurl = 'http://'.$BaseUrlPath.'/'.$surl;
			elseif($preurl=="http:/"||$preurl=='ftp://' ||$preurl=='mms://' || $preurl=="rtsp://" || $preurl=='thunde' || $preurl=='emule:'|| $preurl=='ed2k:/')
			$okurl = $surl;
			else
			$okurl = 'http://'.$BaseUrlPath.'/'.$surl;
		}
		$preurl = strtolower(substr($okurl,0,6));
		if($preurl=='ftp://' || $preurl=='mms://' || $preurl=='rtsp://' || $preurl=='thunde' || $preurl=='emule:'|| $preurl=='ed2k:/') {
			return $okurl;
		} else {
			$okurl = preg_replace('/^(http:\/\/)/i','',$okurl);
			$okurl = preg_replace('/\/{1,}/i','/',$okurl);
			return 'http://'.$okurl;
		}
	}
	
	/**
	 * 返回错误信息
	 */
	function error() {
		$UPLOAD_ERROR = array(
		0 => L('att_upload_succ'),
		1 => L('att_upload_limit_ini'),
		2 => L('att_upload_limit_filesize'),
		3 => L('att_upload_limit_part'),
		4 => L('att_upload_nofile'),
		5 => '',
		6 => L('att_upload_notemp'),
		7 => L('att_upload_temp_w_f'),
		8 => L('att_upload_create_dir_f'),
		9 => L('att_upload_dir_permissions'),
		10 => L('att_upload_limit_ext'),
		11 => L('att_upload_limit_setsize'),
		12 => L('att_upload_not_allow'),
		13 => L('att_upload_limit_time'),
		);
		
		return iconv(CHARSET,"utf-8",$UPLOAD_ERROR[$this->error]);
	}
	
}
?>