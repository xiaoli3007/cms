




var is_closed = false;

function init_guanbi(e) {
	
	//$('#guanbiz').hide();
	$('#uppage').hide();
	$(window).scroll(function(s) {
		if ($(document).scrollTop() > 600 && !is_closed) {
			//$('#guanbi').slideDown();
			//$('#guanbiz').slideDown();
			$('#uppage').slideDown();
		}
		if ($(document).scrollTop() < 600) {
			is_closed = false;
			//$('#guanbi').slideUp();
			//$('#guanbiz').slideUp();
			$('#uppage').slideUp();
		}
	});

	$(".upba").mouseover(function(){
		$(".upba").css("background","url(http://www.lengyeyu.com/statics/images/up.png)");
	});
	$(".upba").mouseout(function(){
		$(".upba").css("background","url(http://www.lengyeyu.com/statics/images/upzc.png)");
	});
	$(".upba").click(function(){
		window.toTopAni = setInterval(backToTop, 10);
	});
}



function backToTop() {
	if ($(document).scrollTop() < 10) {
		$(document).scrollTop(0);
		clearInterval(window.toTopAni);
		window.toTopAni = null;
	} else {
		var dt = Math.round($(document).scrollTop() * 0.3);
	    $(document).scrollTop($(document).scrollTop()-dt);
	}
}


$(document).ready(function(){



	init_guanbi();

});



		
	function reg(url) {
		
		alert('暂不开放注册！');
		/*window.location='reg.php';
		art.dialog.open(url,{
			width:400,
			height:320,
			padding:0,
			lock:true,
			fixed:true
		});*/
	}
	
		
	function login(url) {
		
		/*
		if(url){
		window.location='login.php?return_back='+url;	
		}else{
		window.location='login.php';
		}
			*/
			
		art.dialog.open(url,{
			width:400,
			height:320,
			padding:0,
			lock:true,
			fixed:true
		});
	}
	
	
	function huiying_people(id,userid){
		
		$('.reply_comment').show();
		
		var content=$('#rellddd_'+id+'').text();
		var nickname=$('#dangqianren_'+id+'').text();
		
		var zonng=content+'<a href="javascript:;" class="pubdate">@'+nickname+'</a>';
		$('#reply_commentss').html(zonng);
		$('#reply_id').val(id);
		$('#reply_userid').val(userid);
	
	}
	
	function huiying_people2(){
		
		$('.reply_comment').hide();
		$('#reply_commentss').text('');
		$('#reply_id').val('');
		$('#reply_userid').val('');
	
	}
	
	
	function good_comment(id,userid,url) {
	
	var comment_pl=$('#comment_pl').val();
	var reply_id=$('#reply_id').val();
	var reply_userid=$('#reply_userid').val();
	
	var DateUrl = "good_id="+id+"&user_id="+userid+"&comment_pl="+comment_pl+"&reply_id="+reply_id+"&reply_userid="+reply_userid;
	
	if(!userid){
		
		login(url);
		
	}else{
	
	if(comment_pl==''){
		
		alert('评论不能为空！');		
	}else{
		
		
		if(comment_pl.length > 250){
		
		alert('字数超过限制！');
		return false;		
		}
		
		
	$.ajax({
		type: "post",
	  url: "http://www.lengyeyu.com/detail.php?id="+id+"&&type=like_good_comment&r="+Math.random(),
  		data: DateUrl,  
		dataType: "json",
		success: function(savedata){
			if(savedata['info']==1){
				$('#comments').append(savedata['html']);
				
				$('#comment_item_f_'+savedata['ids']+'').slideDown("slow");
				$('#comment_pl').val('');
				
				huiying_people2();
				//$('#shanhaimei').html('');
				
				//alert('评论成功！');	
				
			}else{
				alert('评论失败！');		
			}
		}
	});
	
	}
	}
}




function photo_comment(id,userid,url) {
	
	var comment_pl=$('#comment_pl').val();
	var reply_id=$('#reply_id').val();
	var reply_userid=$('#reply_userid').val();
	
	var DateUrl = "good_id="+id+"&user_id="+userid+"&comment_pl="+comment_pl+"&reply_id="+reply_id+"&reply_userid="+reply_userid;
	
	if(!userid){
		
		login(url);
		
	}else{
	
	if(comment_pl==''){
		
		alert('评论不能为空！');		
	}else{
		
		
		if(comment_pl.length > 250){
		
		alert('字数超过限制！');
		return false;		
		}
		
		
	$.ajax({
		type: "post",
	  url: "http://www.lengyeyu.com/rainslide.php?id="+id+"&&type=like_good_comment&r="+Math.random(),
  		data: DateUrl,  
		dataType: "json",
		success: function(savedata){
			if(savedata['info']==1){
				$('#comments').append(savedata['html']);
				
				$('#comment_item_f_'+savedata['ids']+'').slideDown("slow");
				$('#comment_pl').val('');
				
				huiying_people2();
				//$('#shanhaimei').html('');
				
				//alert('评论成功！');	
				
			}else{
				alert('评论失败！');		
			}
		}
	});
	
	}
	}
}