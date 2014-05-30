<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>


<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <a href="category.php" class="add fb"><em>分类列表</em></a>　
    </div>
</div>

<script type="text/javascript">
function submit_content(){

	var catname = $("#catname").val();
	
	var cat_dir = $("#cat_dir").val();
	
	if (catname=="") { 
		alert("名称不能为空"); 
		$('#catname').focus(); 
		return false; 
	}
	
	if (cat_dir=="") { 
		alert("静态目录不能为空"); 
		$('#cat_dir').focus(); 
		return false; 
	}

	
}

</script>

<div class="common-form">

<form name="myform" id="myform" action="category.php?contenttype=<?php echo $_GET['contenttype'];?>" method="post" onSubmit="return submit_content();">
<table width="100%" class="table_form contentWrap">
      		
            
      		<tr>
                <td align="right">名称：</td>
                <td align="left"><input type="text"   name="info[catname]" id="catname"   value="<?=$r['catname']?>" class="input-text" style="width:300px;"  /></td>
            </tr>
            
            
             <tr>
                <td align="right">父级：</td>
                <td align="left">
                <?php echo form::select_category('category_model',$r['parentid'],'name="info[parentid]" id="parentid"','请选择分类') ;?>
                
                </td>
            </tr>
      
		
         <tr>
                <td align="right">静态目录（英文）：</td>
                <td align="left"><input type="text"   name="info[cat_dir]" id="cat_dir"   value="<?=$r['cat_dir']?>" class="input-text" style="width:300px;"  /></td>
            </tr>
            

            
            <tr>
                <td align="right">seo_title：</td>
                <td align="left"><input type="text"   name="info[title]" id="title"   value="<?=$r['title']?>" class="input-text" style="width:300px;"  /></td>
            </tr>
      

            
            <tr>
                <td align="right">seo_关键词：</td>
                <td align="left"><input type="text"   name="info[keywords]" id="keywords"   value="<?=$r['keywords']?>" class="input-text" style="width:300px;"  /></td>
            </tr>
            
            
            <tr>
                <td align="right">seo_简介：</td>
                <td align="left"><textarea   name="info[description]" id="description"    class="input-area" style="width:600px; height:200px; "><?=$r['description']?></textarea></td>  
            </tr> 

   <tr>
                <td align="right">链接：</td>
                <td align="left"><input type="text"   name="info[url]" id="url"   value="<?=$r['url']?>" class="input-text" style="width:300px;"  /></td>
            </tr>
          <tr>
                <td align="right">排序：</td>
                <td align="left"><input type="text"   name="info[listorder]" id="listorder"   value="<?=$r['listorder']?>" class="input-text" style="width:300px;"  /></td>
            </tr>   
 			<tr>
                <td align="right">是否显示：</td>
                <td align="left">
                
                <select  name="info[hidden]" id="hidden" >
                <option value="0"<?php if(!$r['hidden']){?> selected="selected"<?php }?>> 显示</option>
                <option value="1" <?php if($r['hidden']){?> selected="selected"<?php }?>>隐藏 </option>
                </select></td>  
            </tr> 
            
            
            
          
            <tr>
                <td align="right"></td>
                <td align="left">
                <?php if($_GET['contenttype']=='edit'){ ?>
                <input name="contenttype" type="hidden" value="edit">
                <input name="id" type="hidden" value="<?php echo $_GET['id']?>">
                <?php } ?>
                <input name="dosubmit" type="hidden" value="1">
                <input type="submit"  class="btn_sub" value="保 存" /> 
    
                </td>
            </tr>
            
            
            
          
</table>

</form>

</div>

</body>
</html>