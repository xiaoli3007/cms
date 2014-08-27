<?php defined('IN_ADMIN') or exit('File does not exist.'); 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET?>" />
<title><?php echo L('message_tips');?></title>
<link href="<?php echo ADMIN_CSS?>login.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo ADMIN_JS;?>jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS;?>admin_common.js"></script>

</head>

<body>
<table width="100%" height="100%" rules="none" border="0">
    <tr>
        <td align="center">
        <div id="message">
            <div class="title">系统提示</div>
            <div class="content">
            <table width="100%" rules="none" border="0">
                <tr height="80">
                    <td align="center"><strong><?php echo $msg?></strong></td>
                </tr>
                <tr>
                    <td align="center"><!--本页面将在3秒内自动跳转，-->
                    <?php if($url_forward=='goback' || $url_forward=='') {?>
                    <a href="javascript:history.back();" >[<?php echo L('return_previous');?>]</a>
                    
                     
                    <script language="javascript">setTimeout("history.back();",<?php echo $ms?>);</script> 
                    <?php } elseif($url_forward=="close") {?>
                    <input type="button" name="close" value="<?php echo L('close');?> " onClick="window.close();">
                    <?php } elseif($url_forward=="blank") {?>
                    
                    <?php } elseif($url_forward) { 
                        if(strpos($url_forward,'?')===false){
							 $url_forward .= '?es_hash='.$_SESSION['es_hash'];
						}else{
							$url_forward .= '&es_hash='.$_SESSION['es_hash'];
						}
                    ?>
                    <a href="<?php echo ADMIN_URL.$url_forward?>">您也可以手动跳转</a>
                    <script language="javascript">setTimeout("redirect('<?php echo ADMIN_URL.$url_forward;?>');",<?php echo $ms?>);</script> 
                    <?php }?>
                    <?php if($returnjs) { ?> <script style="text/javascript"><?php echo $returnjs;?></script><?php } ?>
                    <?php if ($dialog):?><script style="text/javascript">window.top.right.location.reload();window.top.art.dialog({id:"<?php echo $dialog?>"}).close();</script><?php endif;?>
                </tr>
            </table>
            </div>
        </div>
        </td>
    </tr>
</table>
</body>

</html>