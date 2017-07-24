var modalDialog = {
	show:function(msg,closeBtnShow, cancleBtnShow, sureBtnClick){
		var str = '<div class="modalDialog-bg">\
		<div class="modalDialog-content">\
			<img class="modalDialog-close pointer" src="img/pageIndex/cancle.png">\
			<div  class="modalDialog-top"><img src="img/pageIndex/logo.png"/></div>\
			<div  class="modalDialog-middle">'+msg+'</div>\
			<div  class="modalDialog-bottom">\
				<span class="pointer" style="background: rgba(23,22,27,1);">确定</span>\
				<span class="pointer" style="background: rgba(23,22,27,0.5);">取消</span>\
			</div>\
		</div>\
		</div>';
		
		$('body').append(str);
		$('.modalDialog-close').css('visibility', closeBtnShow?'visible':'hidden');
		$('.modalDialog-bottom span:last').css('visibility', cancleBtnShow?'visible':'hidden');
		$('.modalDialog-close').unbind('click').bind('click', removeSelf);
		$('.modalDialog-bottom span:last').unbind('click').bind('click', removeSelf);
		$('.modalDialog-bottom span:first').unbind('click').bind('click', function(){
			if (sureBtnClick) { 
				sureBtnClick();
			}
			removeSelf();
		});
		function removeSelf(){
			$('.modalDialog-bg').remove();
		}
	}
}
var sure = {
	show:function(msg,closeBtnShow, cancleBtnShow, sureBtnClick){
		var str = '<div class="modalDialog-bg">\
		<div class="modalDialog-content">\
			<img class="modalDialog-close pointer" src="img/pageIndex/cancle.png">\
			<div  class="modalDialog-top"><img src="img/pageIndex/logo.png"/></div>\
			<div  class="modalDialog-middle">'+msg+'</div>\
			<div  class="modalDialog-bottom">\
				<span class="pointer" style="background: rgba(23,22,27,1);">确定</span>\
				<span class="pointer" style="background: rgba(23,22,27,0.5);">取消</span>\
			</div>\
		</div>\
		</div>';
		
		$('body').append(str);
		$('.modalDialog-close').css('visibility', closeBtnShow?'visible':'hidden');
		$('.modalDialog-bottom span:last').css('visibility', cancleBtnShow?'visible':'hidden');
		$('.modalDialog-close').unbind('click').bind('click', removeSelf);
		$('.modalDialog-bottom span:last').unbind('click').bind('click', removeSelf);
		$('.modalDialog-bottom span:first').unbind('click').bind('click', function(){
			if (sureBtnClick) { 
				sureBtnClick();
			}
			removeSelf();
		});
		function removeSelf(){
			$('.modalDialog-bg').remove();
		}
	}
}
var remove = {
	show:function(msg,closeBtnShow, cancleBtnShow,remove,thisTitle){
		var str = '<div class="modalDialog-bg">\
		<div class="modalDialog-content">\
			<img class="modalDialog-close pointer" src="img/pageIndex/cancle.png">\
			<div  class="modalDialog-top"><img src="img/pageIndex/logo.png"/></div>\
			<div  class="modalDialog-middle">'+msg+'</div>\
			<div  class="modalDialog-bottom">\
				<span class="pointer" style="background: rgba(23,22,27,1);">确定</span>\
				<span class="pointer" style="background: rgba(23,22,27,0.5);">取消</span>\
			</div>\
		</div>\
		</div>';
		
		$('body').append(str);
		$('.modalDialog-close').css('visibility', closeBtnShow?'visible':'hidden');
		// $('.modalDialog-bottom span:last').css('visibility', cancleBtnShow?'visible':'hidden');
		$('.modalDialog-close').unbind('click').bind('click', removeSelf);
		$('.modalDialog-bottom span:last').unbind('click').bind('click', removeSelf);
		$('.modalDialog-bottom span:first').unbind('click').bind('click', function(){
			// if (sureBtnClick) { 
			// 	sureBtnClick();
			// }
			removeSelf();
			success.show("成功",false,false);
		});
		function removeSelf(){
			$('.modalDialog-bg').remove();

			if(remove){
				thisTitle.remove();
			}
		}
	}
}

var success = {
	show:function(msg,closeBtnShow, cancleBtnShow, sureBtnClick){
		var str = '<div class="modalDialog-bg">\
		<div class="modalDialog-content">\
			<img class="modalDialog-close pointer" src="img/pageIndex/cancle.png">\
			<div  class="modalDialog-top"><img src="img/pageIndex/logo.png"/></div>\
			<div  class="modalDialog-middle">'+msg+'</div>\
			<div  class="modalDialog-bottom">\
				<span class="pointer" style="background: rgba(23,22,27,1);">确定</span>\
				<span class="pointer" style="background: rgba(23,22,27,0.5);">取消</span>\
			</div>\
		</div>\
		</div>';
		
		$('body').append(str);
		$('.modalDialog-close').css('visibility', closeBtnShow?'visible':'hidden');
		$('.modalDialog-bottom span:last').css('visibility', cancleBtnShow?'visible':'hidden');
		$('.modalDialog-close').unbind('click').bind('click', removeSelf);
		$('.modalDialog-bottom span:last').unbind('click').bind('click', removeSelf);
		$('.modalDialog-bottom span:first').unbind('click').bind('click', function(){
			if (sureBtnClick) { 
				sureBtnClick();
			}
			removeSelf();
		});
		function removeSelf(){
			$('.modalDialog-bg').remove();
		}
	}
}

var fail = {
	show:function(msg,closeBtnShow, cancleBtnShow, sureBtnClick){
		var str = '<div class="modalDialog-bg">\
		<div class="modalDialog-content">\
			<img class="modalDialog-close pointer" src="img/pageIndex/cancle.png">\
			<div  class="modalDialog-top"><img src="img/pageIndex/logo.png"/></div>\
			<div  class="modalDialog-middle">'+msg+'</div>\
			<div  class="modalDialog-bottom">\
				<span class="pointer" style="background: rgba(23,22,27,1);">确定</span>\
				<span class="pointer" style="background: rgba(23,22,27,0.5);">取消</span>\
			</div>\
		</div>\
		</div>';
		
		$('body').append(str);
		$('.modalDialog-close').css('visibility', closeBtnShow?'visible':'hidden');
		$('.modalDialog-bottom span:last').css('visibility', cancleBtnShow?'visible':'hidden');
		$('.modalDialog-close').unbind('click').bind('click', removeSelf);
		$('.modalDialog-bottom span:last').unbind('click').bind('click', removeSelf);
		$('.modalDialog-bottom span:first').unbind('click').bind('click', function(){
			if (sureBtnClick) { 
				sureBtnClick();
			}
			removeSelf();
		});
		function removeSelf(){
			$('.modalDialog-bg').remove();
		}
	}
}

