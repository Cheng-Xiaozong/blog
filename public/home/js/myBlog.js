
$(function(){  
	var fil=$("#photo");
	fil.bind('change',function(){  
    	var fordate=new FormData(); 
    	var fils=$("#photo").get(0).files[0];
    	fordate.append('pic',fils); 
    	var srcc=window.URL.createObjectURL(fils);
     	$("#avatar").attr({'src':srcc});  
     	$.ajax({
      		url: "xxx.php",  
      		type: "post",  
      		data: fordate,  
      		processData : false,  
      		contentType : false,   
      		success: function(html){  
        		console.log('chenggong');  
      		},

    	});
	}); 

	var info=$("#infomation");
	
	info.click(function(){
		$("#self-info").hide();
		$("#change").show();
		$("#name2").val($("#name").text());
		
		$("#name2").val($("#name").text());
		$("#intrest2").val($("#intrest").text());
		$("#maxim2").val($("#maxim").text());
		$("#self-evaluate2").text($("#self-evaluate").text());
		console.log($("#self-evaluate").text());

	})
	$("#cansle").click(function(){
		$("#self-info").show();
		$("#change").hide();

	})
	$("#upload-info").click(function(){
		var name = $("#name2").val();
		var sex =  $('input:radio[name="1"]:checked').val();
		var intrest = $("#intrest2").val();
		var maxim = $("#maxim2").val();
		var selfEvaluate = $("#self-evaluate2").text();
		$.ajax({
      		url: "xxx.php",  
      		type: "post",  
      		data: {name:name,sex:sex,intrest:intrest,maxim:maxim,selfEvaluate:selfEvaluate},  
      		processData : false,  
      		contentType : false,   
      		success: function(html){  
        		console.log(html);  
      		},
      		error:function(err){
      			console.log(err);
      		}

    	});

	})

	$('.star').bind('click', function(){
        modalDialog.show('确认删除？', false, false);
    });

    
    $('#removeArticle').bind('click', function(){
    	var _this = $(this).parent().parent(".mblog-blogother").parent("li");
        remove.show('确认删除？', false, false,true,_this);
    });
});  