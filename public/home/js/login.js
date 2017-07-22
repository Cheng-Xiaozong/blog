


(function(){
    
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
        $("#mayform").checkForm();
        // $('#loginPromptSpan').css('visibility', 'visible');
    	// $.post("../php/Interface/Login.php", 
     //    	{username:$('#usernameInput').val(),password:$('#passwordInput').val()}, 
     //    	function (data) {
    	//         console.log(data);
    	//         sessionStorage.setItem("username", $('#usernameInput').val()); 
    	//         if (0 === data.statecode) {
    	//         	location.href = 'home.html';
    	//         } else {
    	//         	//modalDialog.show('请输入正确的用户名和密码!', false, false);
    	//         	$('#loginPromptSpan').css('visibility', 'visible');
    	//         }
     //    	}
     //    );
    }
})()
