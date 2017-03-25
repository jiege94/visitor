/*浏览器窗口高*/
$('.background').height($(window).height());
$(window).resize(function(){
	$('.background').height($(window).height());
})
/*左侧导航栏*/
	var img=-1;//click之后不hover
	/*$('.nav img').hover(function(){
		var i=$('.nav img').index(this);
		var _this=this;
		setTimeout(function(){
			$(_this).attr('src','../images/nav_bgA'+i+'H.png');
			$(_this).animate({
				width:'110px',
				height:'110px',
				marginLeft:'26px'
			},200)
		},100)
			
	},function(){
		var i=$('.nav img').index(this);
		if(i!=img){
			var _this=this;
			setTimeout(function(){
				$(_this).attr('src','../images/nav_bgA'+i+'.png');
				$(_this).animate({
					width:'58px',
					height:'58px',
					marginLeft:'0px'
				},200)
			},100)
		}
	});*/
/*点击左侧，滚动条滚动*/
	$('.nav li').click(function(){
		var i=$('.nav li').index(this);
		for (var a = 0; a < $('.nav img').length; a++) {
			if(a!=i){
				$('.nav img').eq(a).attr('src','../images/nav_bgA'+a+'.png');
				$('.nav img').eq(a).animate({
					width:'58px',
					height:'58px',
					marginLeft:'-26px'
				},200)
			}
		};
		img=i;
		$('.nav img').eq(i).attr('src','../images/nav_bgA'+i+'H.png');
		$('.nav img').eq(i).animate({
			width:'110px',
			height:'110px',
			marginLeft:'0px'
		},200)
		$('body').animate({
			scrollTop:$('.hello').eq(i+1).offset().top-30
		},1000)
	})
/*视频*/	
	var play=0;	
	$('.video_play').click(function(){
		if (play==0) {
			$(this).css('background','url(../images/pause.png) 0 0 no-repeat');
			$('.video video').get(0).play();
			play=1;
		}else{
			$(this).css('background','url(../images/play.png) 0 0 no-repeat');
			$('.video video').get(0).pause();
			play=0;
		}
	})
/*换背景*/
	var img_i=0;
	$(window).scroll(function(){
		var st=document.documentElement.scrollTop|| window.pageYOffset||document.body.scrollTop;
		if(st<794){
			img_i=0;
		}else if(st>=794 && st<1500){
			img_i=1;
		}else if(st>=1500&&st<2200){
			img_i=2;
		}else if(st>=2200&&st<3000){
			img_i=3;
		} else if(st>=3000&&st<3934){
		 	img_i=4;
		}else{
			img_i=5;
		}
		$('.background img').eq(img_i).fadeIn(1000).siblings().fadeOut(1000);
	})
/*输入框字数限制*/
$('#text').focus(function(){
	if($(this).val()=='分享你的旅行...'){
		$(this).val('');
	}
})
$('#text').on('input propertychange',function(){
	if($(this).val().length>200){
		alert('字数超过200');
		return false;
	}
	$('.num span').html($(this).val().length);
})
/*点击别处，login消失*/
$(document).click(function(e){
	if(node($(e.target),'login')==0){
		$('.login').css('display','none');
	}
	if($(e.target).attr('class')=='login_reg'){//点击登录注册
		$('.login').css('display','block');
		if($.cookie('username')){
			$('.login').css('display','none');
		}
	}
})
function node(target,parentClass){
	var a=0;
	for (var i = 0; i < 10; i++) {
		if(target.attr('class')==parentClass){
			return a=1;
		}
		target=target.parent();
	};
	return a=0;
}
/*进入页面 查cookie*/
// alert(111)
if($.cookie('username')){
	$('.login_reg').html($.cookie('username'));
}
/*点击退出*/
$('.back').click(function(){
	if(confirm('确定退出吗')){
		$.ajax({
			type:'post',
			url:'../php/index.php?c=Login&a=unset1',
			dataType:'json',
			success:function(data){
				if (data.code==200) {
					alert(data.message);
					$.cookie('username','');
					location.reload(true);
				};
			}
		})
	}
})
/*评论提交*/
var imgupload='';//上传图片地址
$('#shuru').submit(function(){
	//判断登录
	if($.cookie('username')==null){
		$('.login').css('display','block');
	}else{
		if ($('.diySuccess').css('display')=='block') {};
		if($('#text').val()=='' || $('#text').val()=='分享你的旅行...'){
			alert('请输入内容');
			$('#text').focus();
			return false;
		}
		if($('.diyStart').css('display')=='inline-block'){
			alert('请上传图片');
			return false;
		}
		$.ajax({
			type:'post',
			url:'../php/index.php?c=Login&a=comment',
			data:{'username':$.cookie('username'),'text':$('#text').val(),'img':imgupload},
			dataType:'json',
			success:function(data){
				if (data.code==505) {
					alert(data.message);
				}else if(data.code==200){
					alert(data.message);
					location.reload(true);//刷新页面
				}else if(data.code==404){
					alert(data.message);
				}
			}
		})
	}
	return false;
});
/*可做之事*/
$(".page3_ul2>li").not(":first").hide();
$(".page3_ul1 a").click(function() {

	if ( $("#" + this.rel).is(":hidden") ) {
		$(".page3_ul2>li").slideUp();
		$("#" + this.rel).slideDown();
	}
});
/*一进入页面，请求数据库*/
var app=angular.module('myapp',[]);
app.controller('myCtrl',function($scope,$http){
	$http.get('../php/index.php?c=Login&a=freshen').success(function(data){
		$scope.data=data;
	});
	$scope.zan=function(target){
		if(target.getAttribute('src')=='../images/zan1.png'){
			target.setAttribute('src','../images/zan2.png');
			$.cookie(target.getAttribute('id'),1)
		}else{
			target.setAttribute('src','../images/zan1.png');
			$.cookie(target.getAttribute('id'),0)
		}
	}
})

/*
 * 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
 * 其他参数同WebUploader
 */
	$('#as').diyUpload({
		url:'../php/index.php?c=Login&a=upload',
		success:function( data ) {
			imgupload1=(""+data._raw.split('}')[1]).trim();
			imgupload1=imgupload1.replace('C:/xampp/htdocs/visitor','..')
			imgupload+=imgupload1+" ";
			console.log(imgupload1);
		},
		error:function( err ) {
			console.info( err );	
		},
		buttonText : '选择文件',
		chunked:false,
		// 分片大小
		chunkSize:512 * 1024,

		//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);

		fileNumLimit:3,

		fileSizeLimit:500000 * 1024,
		fileSingleSizeLimit:50000 * 1024,
		/*accept:{
			title:"Images",
			extensions:"gif,jpg,jpeg,bmp,png",
			mimeTypes:"image/*"
		}*/
	});