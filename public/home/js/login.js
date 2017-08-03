


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
    }
})()
