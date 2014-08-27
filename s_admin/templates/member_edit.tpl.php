<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>

<script type="text/javascript" src="<?php echo ADMIN_JS;?>jquery.jUploader-1.0.min.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS;?>uploader.js"></script>
<style type="text/css">
	.jUploader-button {background:url(<?php echo ADMIN_IMG;?>up.gif) no-repeat 0 0; height:23px; width:43px; border:0;padding:0px; margin:0px; cursor:pointer;}
	.jUploader-button-hover {background-color:#111111; color:#fff;}
</style>

<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <a href="member.php?es_hash=<?php echo $es_hash;?>" class="add fb"><em>用户列表</em></a>　
    </div>
</div>

<script type="text/javascript">
function submit_content(){

	var newpass = $("#newpass").val();
	var twopass = $("#twopass").val();
	
	if (newpass!="") {
		
		if (newpass.length<6) { 
			alert("新密码不能少于6位！"); 
			$('#newpass').focus(); 
			return false; 
		}if (twopass==""){
			alert("请确认新密码！");
			$('#twopass').focus(); 
			return false;
		}elseif(twopass != newpass){
			alert("两次密码输入不一致！");
			$('#newpass').focus(); 
			return false;
		} 
	}
	
	
	
	
}


</script>

<div class="common-form">

<form name="myform" id="myform" action="?" method="post" onSubmit="return submit_content();">
<table width="100%" class="table_form contentWrap">
      		
            <tr>
                <td align="right">用户名：</td>
                <td align="left"><?php echo $r['username'];?></td>
                
            </tr>
            <tr>
                <td align="right">新密码：</td>
                <td align="left"><input type="text" name="newpass" id="newpass" /></td>
            </tr>
            
            <tr>
                <td align="right">确认新密码：</td>
                <td align="left"><input type="text" name="twopass" id="twopass"></td>
            </tr>
            
      		<tr>
                <td align="right">昵称：</td>
                <td align="left"><?php echo $r['nickname'];?></td>
            </tr>
            
            <tr>
                <td align="right">性别：</td>
                <td align="left"><?php if($r['sex'] ==1){ echo "男";}elseif($r['sex']==2){ echo "女";}else{ echo "保密";}?></td>
            </tr>
            
            <tr>
                <td align="right">邮箱：</td>
                <td align="left"><?php echo $r['email'];?></td>
            </tr>
            
            <tr>
                <td align="right">联系方式：</td>
                <td align="left"><?php echo $r['mobile'];?></td>
            </tr>
            
            <tr>
                <td align="right">所在地区：</td>
                <td align="left">
				<?php 
					$province = $linkage_db->get_one(array('linkageid'=>$r['province']));
					$city = $linkage_db->get_one(array('linkageid'=>$r['city']));
					echo $province['name']."&nbsp;".$city['name'];
				?>
                </td>
            </tr>
            
     

            
          
            <tr>
                <td align="right"></td>
                <td align="left">
                <input name="contenttype" type="hidden" value="edit">
                <input name="id" type="hidden" value="<?php echo $_GET['id']?>">
                <input name="dosubmit" type="hidden" value="1">
                <input type="submit"  class="btn_sub" value="保 存" /> 
                </td>
            </tr>
            
            
            
          
</table>

</form>

</div>

</body>
</html>