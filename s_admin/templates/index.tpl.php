<?php
defined('IN_ADMIN') or exit('File does not exist.');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" class="off">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>后台管理系统</title>
<link href="<?php echo ADMIN_CSS?>reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ADMIN_CSS?>zh-cn-system.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo ADMIN_JS;?>jquery-1.8.2.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo ADMIN_JS;?>dialog.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo ADMIN_JS;?>hotkeys.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo ADMIN_JS;?>jquery.sgallery.js"></script>
<script type="text/javascript">
var es_hash = '<?php echo $_SESSION['es_hash']?>'
</script>
<style type="text/css">
.objbody{overflow:hidden}
</style>
</head>
<body scroll="no" class="objbody">
<div class="header">

	<div class="logo lf"></div>
    
    <div class="rt-col"></div>
    
    <div class="col-auto">
    	<div class="log white cut_line">您好！<?php echo $_SESSION['username'];?>  <span>|</span><a href="admin_logout.php">[退出]</a></div>
        <ul class="nav white" id="top_menu">
        <?php
        $array = admin::admin_menu(0);
        foreach($array as $_value) {
        	if($_value['id']==1) {
        		echo '<li id="_M'.$_value['id'].'" class="on top_menu"><a href="javascript:_M('.$_value['id'].',\''.$_value['url'].'\')" hidefocus="true" style="outline:none;">'.$_value['name'].'</a></li>';
        		
        	} else {
        		echo '<li id="_M'.$_value['id'].'" class="top_menu"><a href="javascript:_M('.$_value['id'].',\''.$_value['url'].'\')"  hidefocus="true" style="outline:none;">'.$_value['name'].'</a></li>';
        	}      	
        }
        ?>
        </ul>
    </div>
</div>
<div id="content">
	<div class="col-left left_menu">
    	<div id="Scroll"><div id="leftMain"></div></div>
        <a href="javascript:;" id="openClose" style="outline-style: none; outline-color: invert; outline-width: medium;" hideFocus="hidefocus" class="open" title="展开与关闭"><span class="hidden">展开</span></a>
    </div>
	<div class="col-1 lf cat-menu" id="display_center_id" style="display:none" height="100%">
        <div class="content">
        	<iframe name="center_frame" id="center_frame" src="" frameborder="false" scrolling="auto" style="border:none" width="100%" height="auto" allowtransparency="true"></iframe>
        </div>
    </div>
    <div class="col-auto mr8">
    <div class="crumbs">
    <div class="shortcut cu-span">
    <!--<a href="javascript:;" target="right"><span>生成首页</span></a>
    <a href="javascript:;" target="right"><span>更新缓存</span></a>-->
    </div>

    当前位置：<span id="current_pos"></span></div>
    	<div class="col-1">
        	<div class="content" style="position:relative; overflow:hidden">
                <iframe name="right" id="rightMain" src="admin_public.php" frameborder="false" scrolling="auto" style="border:none; margin-bottom:30px" width="100%" height="auto" allowtransparency="true"></iframe>
                
        	</div>
        </div>
    </div>
</div>

<div class="scroll"><a href="javascript:;" class="per" title="使用鼠标滚轴滚动侧栏" onclick="menuScroll(1);"></a><a href="javascript:;" class="next" title="使用鼠标滚轴滚动侧栏" onclick="menuScroll(2);"></a></div>
<script type="text/javascript"> 
if(!Array.prototype.map)
Array.prototype.map = function(fn,scope) {
  var result = [],ri = 0;
  for (var i = 0,n = this.length; i < n; i++){
	if(i in this){
	  result[ri++]  = fn.call(scope ,this[i],i,this);
	}
  }
return result;
};

var getWindowSize = function(){
return ["Height","Width"].map(function(name){
  return window["inner"+name] ||
	document.compatMode === "CSS1Compat" && document.documentElement[ "client" + name ] || document.body[ "client" + name ]
});
}
window.onload = function (){
	if(!+"\v1" && !document.querySelector) { // for IE6 IE7
	  document.body.onresize = resize;
	} else { 
	  window.onresize = resize;
	}
	function resize() {
		wSize();
		return false;
	}
}
function wSize(){
	//这是一字符串
	var str=getWindowSize();
	var strs= new Array(); //定义一数组
	strs=str.toString().split(","); //字符分割
	var heights = strs[0]-150,Body = $('body');$('#rightMain').height(heights);   
	//iframe.height = strs[0]-46;
	if(strs[1]<980){
		$('.header').css('width',980+'px');
		$('#content').css('width',980+'px');
		Body.attr('scroll','');
		Body.removeClass('objbody');
	}else{
		$('.header').css('width','auto');
		$('#content').css('width','auto');
		Body.attr('scroll','no');
		Body.addClass('objbody');
	}
	
	var openClose = $("#rightMain").height()+39;
	$('#center_frame').height(openClose+9);
	$("#openClose").height(openClose+30);	
	$("#Scroll").height(openClose-20);
	windowW();
}
wSize();
function windowW(){
	if($('#Scroll').height()<$("#leftMain").height()){
		$(".scroll").show();
	}else{
		$(".scroll").hide();
	}
}
windowW();
//站点下拉菜单
$(function(){
	//默认载入左侧菜单
	$("#leftMain").load("admin_public.php?admintype=menu_left&menuid=1");
})

//左侧开关
$("#openClose").click(function(){
	if($(this).data('clicknum')==1) {
		$("html").removeClass("on");
		$(".left_menu").removeClass("left_menu_on");
		$(this).removeClass("close");
		$(this).data('clicknum', 0);
		$(".scroll").show();
	} else {
		$(".left_menu").addClass("left_menu_on");
		$(this).addClass("close");
		$("html").addClass("on");
		$(this).data('clicknum', 1);
		$(".scroll").hide();
	}
	return false;
});

function _M(menuid,targetUrl) {
	$("#menuid").val(menuid);
	$("#bigid").val(menuid);
	$("#paneladd").html('<a class="panel-add" href="javascript:add_panel();"><em>添加</em></a>');
	$("#leftMain").load("admin_public.php?admintype=menu_left&menuid="+menuid, {limit: 25}, function(){
	   windowW();
	});
	//$("#rightMain").attr('src', targetUrl);
	$('.top_menu').removeClass("on");
	$('#_M'+menuid).addClass("on");
	$.get("admin_public.php?admintype=current_pos&menuid="+menuid, function(data){
		$("#current_pos").html(data);
	});
	//当点击顶部菜单后，隐藏中间的框架
	$('#display_center_id').css('display','none');
	//显示左侧菜单，当点击顶部时，展开左侧
	$(".left_menu").removeClass("left_menu_on");
	$("#openClose").removeClass("close");
	$("html").removeClass("on");
	$("#openClose").data('clicknum', 0);
	$("#current_pos").data('clicknum', 1);
}
function _MP(menuid,targetUrl) {
	$("#menuid").val(menuid);
	$("#paneladd").html('<a class="panel-add" href="javascript:add_panel();"><em>添加</em></a>');

	//$("#rightMain").attr('src', targetUrl+'&menuid='+menuid+'&es_hash='+es_hash);
	$("#rightMain").attr('src', targetUrl);
	$('.sub_menu').removeClass("on fb blue");
	$('#_MP'+menuid).addClass("on fb blue");
	$.get("admin_public.php?admintype=current_pos&menuid="+menuid, function(data){
		$("#current_pos").html(data+'<span id="current_pos_attr"></span>');
	});
	$("#current_pos").data('clicknum', 1);
}

function add_panel() {
	var menuid = $("#menuid").val();
	$.ajax({
		type: "POST",
		url: "admin_public.php?admintype=ajax_add_panel",
		data: "menuid=" + menuid,
		success: function(data){
			if(data) {
				$("#panellist").html(data);
			}
		}
	});
}
function delete_panel(menuid, id) {
	$.ajax({
		type: "POST",
		url: "admin_public.php?admintype=ajax_delete_panel",
		data: "menuid=" + menuid,
		success: function(data){
			$("#panellist").html(data);
		}
	});
}

function paneladdclass(id) {
	$("#panellist span a[class='on']").removeClass();
	$(id).addClass('on')
}
setInterval("session_life()", 160000);
function session_life() {
	$.get("admin_public.php?admintype=session_life");
}


(function(){
    var addEvent = (function(){
             if (window.addEventListener) {
                return function(el, sType, fn, capture) {
                    el.addEventListener(sType, fn, (capture));
                };
            } else if (window.attachEvent) {
                return function(el, sType, fn, capture) {
                    el.attachEvent("on" + sType, fn);
                };
            } else {
                return function(){};
            }
        })(),
    Scroll = document.getElementById('Scroll');
    // IE6/IE7/IE8/Opera 10+/Safari5+
    addEvent(Scroll, 'mousewheel', function(event){
        event = window.event || event ;  
		if(event.wheelDelta <= 0 || event.detail > 0) {
				Scroll.scrollTop = Scroll.scrollTop + 29;
			} else {
				Scroll.scrollTop = Scroll.scrollTop - 29;
		}
    }, false);

    // Firefox 3.5+
    addEvent(Scroll, 'DOMMouseScroll',  function(event){
        event = window.event || event ;
		if(event.wheelDelta <= 0 || event.detail > 0) {
				Scroll.scrollTop = Scroll.scrollTop + 29;
			} else {
				Scroll.scrollTop = Scroll.scrollTop - 29;
		}
    }, false);
	
})();
function menuScroll(num){
	var Scroll = document.getElementById('Scroll');
	if(num==1){
		Scroll.scrollTop = Scroll.scrollTop - 60;
	}else{
		Scroll.scrollTop = Scroll.scrollTop + 60;
	}
}
</script>
</body>
</html>