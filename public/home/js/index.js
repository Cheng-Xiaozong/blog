/**
 * Created by xin.yang on 2017/4/19.
 * index.js
 * Login and register.
 */
;(function(){
    // loginBtn clicked
    $('#loginBtn').unbind('click').bind('click', function(){
        $('#index-container-operate').css('display', 'block');
        $('#index-container-main').css('display', 'none');
    }) ;
    //registerBtn clicked
    $('#registerBtn').unbind('click').bind('click', function(){
        modalDialog.show('暂不支持注册，请联系客服开通账号!', false, false);
    });
    // cancleDiv
    $('#cancleSpan').unbind('click').bind('click', function(){
        $('#index-container-operate').css('display', 'none');
        $('#index-container-main').css('display', 'block');
    }) ;
    $('#sureDiv').unbind('click').bind('click',login);
    $('#passwordInput, #usernameInput').unbind('keydown').bind('keydown',function(e){
    	if(e && e.keyCode==13){ 
    		login();
        }
    });
    $('#passwordInput, #usernameInput').unbind('input').bind('input',function(e){
    	$('#loginPromptSpan').css('visibility', 'hidden');
    });
    function login(){
    	$.post("../php/Interface/Login.php", 
    	{username:$('#usernameInput').val(),password:$('#passwordInput').val()}, 
    	function (data) {
	        console.log(data);
	        sessionStorage.setItem("username", $('#usernameInput').val()); 
	        if (0 === data.statecode) {
	        	location.href = 'home.html';
	        } else {
	        	//modalDialog.show('请输入正确的用户名和密码!', false, false);
	        	$('#loginPromptSpan').css('visibility', 'visible');
	        }
    	}) ;
    }
})()
