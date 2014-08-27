//var divfile = '';  //全局文件路径
// 设置全局配置
$.jUploader.setDefaults({
	//cancelable: true,
	allowedExtensions: ['xls'],
	messages: {
		//upload: '上传',
		//cancel: '取消',
		emptyFile: "{file} 为空，请选择一个文件.",
		invalidExtension: "{file} 后缀名不合法. 只有 {extensions} 是允许的.",
		onLeave: "文件正在上传，如果你现在离开，上传将会被取消。"
	}
});

function file_uploader(divfile,butname,photoshow) {
	$.jUploader({
		button: butname, // 这里设置按钮id
		action: 'ajax_upload.php?dosubmit=4', // 这里设置上传处理接口

		// 开始上传事件
		onUpload: function (fileName) {
			$('#'+butname+'_tip').html('<img src="http://192.168.1.188/cescvip/ziyuan/statics/images/loadingme.gif">');
		},

		// 上传完成事件
		onComplete: function (fileName, response) {
			// response是json对象，格式可以按自己的意愿来定义，例子为： { success: true, fileUrl:'' }
			if (response.success) {
				
		 		$('#'+divfile+'').val(response.fileUrl);
				
				if(photoshow){
				
					$('#'+photoshow+'').text(response.fileUrl);
					/*$('#'+photoshow+'_type').val(response.file_type);*/
				}
				$('#'+butname+'_tip').html('<img src="http://192.168.1.188/cescvip/ziyuan/statics/images/loadingme_dui.gif" width="16" height="16">');
			} else {
				$('#'+butname+'_tip').html('<img src="http://192.168.1.188/cescvip/ziyuan/statics/images/loadingme_cuo.gif">');
			}
		},

		// 系统信息显示（例如后缀名不合法）
		showMessage: function (message) {
			$('#'+butname+'_tip').text(message);
		},

		// 取消上传事件
		onCancel: function (fileName) {
			$('#'+butname+'_tip').text(  '上传取消');
		}
	});
}