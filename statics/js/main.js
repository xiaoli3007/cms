$(function(){
	playDelay = playDelay == "正常" ? "600000" : "3000";
	if($("#galleria").length > 0 && !(viewingPost && postType == "photo")) {
		var galleria = new Gallery("#galleria", {
			"delay" 	: playDelay,
			"loading" 	: ".ajaxloading, .ajaxloading_back_layer" 
		});
		function stopGalleria(){
			galleria.stop();
		}
		function startGalleria(){
			galleria.start();
		}
	}
	$("#search").on("click", function(){
		$(this).removeClass("searchcss");
		$("#search_form").css({
			"border-width" : 1
		}).animate({
			"width" : 120
		});
		$("#s").animate({
			"width" : 95
		}, function(){
			$(".submitsearch").show();
		});
	});
	if($(".logo img")[0]){
		var size = $(".logo img")[0].src.match(/(\d+)_(\d+)\..+?$/),
			w = size[1], h = size[2];
		if(w > h){
			w = 84/h * w;
			h = 84;
		}else{
			h = 84/w * h;
			w = 84;
		}
		$(".logo img").css({width: w, height:h});
	}
	$("#navi .menu-list").each(function(i, m){
		$(m).css({
			"top" : -$("div", m).length * 32 - 10
		});
		$(m).parent().on("mouseenter mouseleave", function(ev){
			if(ev.type == "mouseenter"){
				$(m).show();
			}else{
				$(m).hide();
			}
		});
	});
	//fix the bug in ie7
	function fixLayout(){
		if($.browser.msie && $.browser.version < 8 ){
			console.log($(".unit_gallery"));
			$(".unit_gallery").each(function(i, item){
				var len = $("img", item).length;
				if(len >= 4){
					$(item).css({"width" : 360});
				}else{
					$(item).css({"width" : len * 90});
				}
			});
		}
	}
	fixLayout();
	//注册加载更多
	if($("#infscr-loading").length != 0){
		var page = 1, numPer = 10, lock = false;
		function getMoreData(){
			if(lock) return;
			lock = true;
			var currentPostNumber = $(".list_unit").length;
			$("#infscr-loading").show();
			var data = {
				limit 	: numPer,
				offset	: currentPostNumber
			};
			if(viewtag){
				data.tags = [ decodeURIComponent(viewtag) ];
			}
			$.get("/do/getList.html", {
				"_posts" : data
			}, function(data){
				$("#infscr-loading").hide();
				$(data).appendTo("#list_wrap");
				fixLayout();
				lock = false;
			});
		}
		$(window).on("scroll", function(){
			if($(window).height() + $(window).scrollTop() + 200 > $(document).height()){
				getMoreData();
			}
		});
	}
	function getPostHtmlData(url, callback){
		if(!viewingPost){
			$.get(url, function(data){
				var html = data.match(/<\!--PostContentStart-->([\s\S]+?)<\!--PostContentEnd-->/);
				if(html){
					callback(html[1]);
				}
			});
		}else{
			$("#post-content .content_wrap").css({
				"margin-top" : 0
			}).show();
			callback("");
		}
	}
	//监听打开终端页文章事件处理
	var Event = {}, currentStatus = "list", currentType, commentHeightTimer, galleriaPosts;
	$(Event).on("view::post", function(ev, data){
		if(currentStatus == "list"){
			currentStatus = "post";
			currentType   = data.type;
			$("#page-nav").hide();
			var _top, count = 0;
			if(!viewingPost){
				if($("#logo").length != 0){
					_top = -$("#logo").height();
					$("#logo").animate({
						"opacity" : 0,
						"top" 	  : _top
					}, cb);
					count++;
				}
				if($("#footer").length != 0){
					_top = -$("#footer").height();
					$("#footer").animate({
						"opacity" : 0,
						"bottom"  : _top
					}, cb);
					count++;
				}
				if($("#line_type_wrap").length != 0){
					_top = -($("#line_type_wrap").width() + 655);
					$("#line_type_wrap").animate({
						"opacity" : 0,
						"right"   : _top
					}, cb);
					count++;
				}
				if($("#back-mask").length != 0){
					$("#back-mask").animate({
						"opacity" : 0
					}, cb);
					count++;
				}
				if($("#line_type_mask").length != 0){
					$("#line_type_mask").animate({
						"opacity" : 0
					}, cb);
					count++;
				}
				stopGalleria && (stopGalleria());
			}else{
				cb(true);
			}
			function cb(nothing){
				if(!nothing){
					$(this).hide();
					count--;
				}else{
					count = 0;
				}
				if(count == 0){
					$(".ajaxloading, .ajaxloading_back_layer").fadeIn();
					var url = $(data.target).attr("url");
					getPostHtmlData(url, function(htmlData){
						if(htmlData){
							$(htmlData).appendTo("#post-content-holder");
						}
						$(".ajaxloading, .ajaxloading_back_layer").fadeOut();
						$("#post-content-holder").show();
						$("#live-comment").on("click", function(ev){
							ev.preventDefault();
							$("#comment").slideToggle();
							$(this).toggleClass("open");
						});
						$("#live-comment-photo").on("click", function(ev){
							ev.preventDefault();
							$("#comment-photo").toggle();
							$(this).toggleClass("open");
							var origH = 0;
							function T(){
								var t = $("#post-content .gallery_tip");
								t.css({"height" : ""});
								var h = t.outerHeight();
								if(h == origH) return;
								origH = h;
								if(h > $(window).height()){
									t.css({
										"height" : $(window).height(),
										"overflow-y" : "auto"
									});
								}else{
									t.css({
										"height" : "",
										"overflow" : "hidden"
									});
								}
								t.css({
									"margin-top" : Math.round(-$("#post-content .gallery_tip").outerHeight()/2)
								});
							}

							if($(this).hasClass("open")){
								commentHeightTimer = setInterval(function(){
									T();
								}, 100);
							}
						});
						if(data.type == "photo"){
							$("html, body").css({
								"overflow" : "hidden"
							});
							$("#post-content .gallery_tip").css({
								"opacity" : 0,
								"margin-top" : -$("#post-content .gallery_tip").outerHeight()/2
							}).animate({
								"left" : 0,
								"opacity" : 1
							});
							$(".gallery_tip_wrap .desc-i").bind("mousewheel", function(event, delta, deltaX, deltaY){
								var h = $(this).parent().height(), t = parseInt($(this).css("top"),10)||0;
								var toH = $(this).height();
								deltaY = deltaY * 100;
								if(toH <= h) return;
								if(t == 0 && deltaY >= 0) return;
								if(toH - t + deltaY <= h) return;
								var to = t + deltaY;
								$(this).css({
									"top" : Math.max(h - toH, Math.min(to, 0))
								});
							});
							$("#post-content .gallery_toolbar").show().animate({
								"right" : 15
							}, function(){
								galleriaPosts = new Gallery("#galleria_posts", {
									autoplay: false,
									delay   : playDelay,
									prevUrl : $("#prevUrl").attr('url'),
									nextUrl : $("#nextUrl").attr('url'),
									autoreplay : false,
									enableClick: true,
									loading : ".ajaxloading, .ajaxloading_back_layer",
									change	: function(desc){
										if(desc){
											$("#desc-inner").html(desc);
											$("#desc-inner").show();
										}else{
											$("#desc-inner").hide();
										}
										$("#post-content .gallery_tip").css({
											"margin-top" : -$("#post-content .gallery_tip").outerHeight()/2
										});
									}
								});
								$("#galleria_posts").show();
								$("#galleria").hide();
								$("#post-content .galleria-image-nav-left").on("click", function(ev){
									ev.preventDefault();
									galleriaPosts.playPrev();
								});
								$("#post-content .galleria-image-nav-right").on("click", function(ev){
									ev.preventDefault();
									galleriaPosts.playNext();
								});
							});
							$("#post-content .tip").on("click", function(ev){
								var target = $("#post-content .gallery_tip"),
									to, toStatus;
								if(target.attr("hided") == 1){
									to = 0;
									toStatus = 0;
								}else{
									to = -460;
									toStatus = 1;
								}
								target.animate({
									"left" : to
								}, function(){
									target.attr("hided", toStatus);
								});
							});
							$("#post-content .gallery_back").on("click", function(ev){
								if(!viewingPost){
									$(Event).trigger("view::list");
								}else{
									window.location.href = url;
								}
								ev.preventDefault();
							});
							$("#post-content .gallery_play").on("click", function(ev){
								if ( $(this).hasClass("gallery_pause") ){
									 $(this).removeClass('gallery_pause');
									 galleriaPosts.updateConfig({
									 	"autoplay" : true
									 });
									 galleriaPosts.start();
								}else{
									 $(this).addClass('gallery_pause');
									 galleriaPosts.updateConfig({
									 	"autoplay" : false
									 });
									 galleriaPosts.stop();
								}
							});
						}else{
							$("#post-content .content_wrap").show().animate({
								"margin-top" : 0
							});
							$("#post-content .closeBtn").on("click", function(ev){
								ev.preventDefault();
								if(!viewingPost){
									$(Event).trigger("view::list");
								}else{
									window.location.href = url;
								}
							})
						}
					});
				}
			}
		}
	});
	$(Event).on("view::list", function(){
		if(currentStatus == "post"){
			clearInterval(commentHeightTimer);
			currentStatus = "list";
			var count = 0;
			$("#page-nav").show();
			if(currentType == "photo"){
				$("html, body").css({
					"overflow" : "auto"
				});
				galleriaPosts.stop();
				$('#galleria_posts').hide();
				$("#galleria").show();
				$("#post-content .gallery_toolbar").animate({
					"right" : -264
				}, function(){
					$(this).hide();
					cb();
				});
				count++;
				$("#post-content .gallery_tip").animate({
					"left" : -460
				}, cb);
				count++;
			}else{
				$("#post-content .content_wrap").animate({
					"margin-top" : 600,
					"opacity"	 : 0
				}, cb);
				count++;
			}
			function cb(){
				count--;
				if(count==0){
					$("#post-content-holder").html("").hide();
					startGalleria();
					$("#logo").show().animate({
						"opacity" : 1,
						"top" 	  : 40
					}, cb1);
					$("#footer").show().animate({
						"opacity" : 1,
						"bottom"  : 0
					}, cb1);
					count++;
					$("#line_type_wrap").show().animate({
						"opacity" : 1,
						"right"   : 0
					}, cb1);
					count++;
					$("#back-mask").show().animate({
						"opacity" : 1
					}, cb1);
					count++;
					$("#line_type_mask").show().animate({
						"opacity" : 1
					}, cb1);
					count++;
					function cb1(){
						count--;
						if(count == 0){

						}
					}
				}
			}
		}
	});
	$("#list_wrap").on("click", function(ev){
		var post = $(ev.target).parents("li.list_unit");
		if(post){
			if(post.hasClass("photo")){
				$(Event).trigger("view::post", { type: "photo", target: post});
			}else{
				$(Event).trigger("view::post", { type: "normal", target: post});
			}
			ev.preventDefault();
		}
	});
	if(viewingPost){
		$(Event).trigger("view::post", {
			"type" : postType == "photo" ? "photo" : "normal",
			"target": $("#post-content")
		});
	}
});