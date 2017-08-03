	var headImgUrl = $(".head-img").attr("imgurl");
	$(".head-img").attr("src",urlGlobal+'/'+headImgUrl);
	//头像地址
	//个人信息修改
	$("#photo").change(function(){
	    var filepath=$("#photo").val(); 
	    var extStart=filepath.lastIndexOf("."); 
	    var ext=filepath.substring(extStart,filepath.length).toUpperCase(); 
	    if(ext!=".BMP"&&ext!=".PNG"&&ext!=".GIF"&&ext!=".JPG"&&ext!=".JPEG"){ 
	        alert("图片限于bmp,png,gif,jpeg,jpg格式"); 
	        return false; 
	    } 
	    var file_size = 0;
	    file_size = this.files[0].size;
	    var size = file_size / 1024;
	    if(size > 10240){
	        alert("上传的文件大小不能超过10M！");
	        return false;
	    }
	    
	    if($("#photo").val() != ''){
	        doUpload();
	    }
	});

	function doUpload() {  
	     var portrait = new FormData($( "#person-photo")[0]);  
	     $.ajax({  
	          url: urlGlobal+'/updatePt',
	          type: 'post',
	          data: portrait,
	          success: function (data) {  
	              if (data.status == 1) {
	                $(".head-img").attr("src",urlGlobal+'/'+data.data);
	              }
	              
	          },  
	          error: function (data) {  
	              
	          }  
	     });
	}

	var info=$("#infomation");

	info.click(function(){
	    $("#self-info").hide();
	    $("#change").show();
	    if ($('#sex').html() == '男') {
	        $("input[type='radio'][value=1]").attr("checked","checked" );
	    }else{
	        $("input[type='radio'][value=0]").attr("checked","checked" );
	    }
	    $("#name2").val($("#name").text());
	    $("#intrest2").val($("#intrest").text());
	    $("#maxim2").val($("#maxim").text());
	    var evaluateVal = $("#self-evaluate").text();
	    evaVal = evaluateVal.replace("\n","").replace(/\s/g, '');
	    $("#self-evaluate2").val(evaVal);

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
	    var selfEvaluate = $("#self-evaluate2").val();

	    if (!name) {
	        alert("名字不能为空");
	        return false;
	    }
	    if (name.length<3) {
	        alert("名字长度不能少于3个字符");
	        return false;
	    }
	    if (!intrest) {
	        alert("爱好不能为空");
	        return false;
	    }
	    if (!maxim) {
	        alert("签名不能为空");
	        return false;
	    }
	    if (!selfEvaluate) {
	        alert("自我评价不能为空");
	        return false;
	    }
	    $.ajax({
	        url: urlGlobal+'/updateMyInfo',  
	        type: "post",
	        dataType:'json',  
	        data: { 
	            "_token":token,"User[name]":name,"User[sex]":sex,"User[hobby]":intrest,"User[signature]":maxim,"User[details]":selfEvaluate},
	       
	        success: function(html){ 
	            if (html.status == 1) {
	                $("#self-info").show();
	                $("#change").hide();
	                $("#name").html(name);
	                if ( sex == 0) {
	                    $("#sex").html("女");
	                }else{
	                    $("#sex").html("男");
	                }
	                $("#intrest").html(intrest)
	                $("#maxim").html(maxim);
	                $("#self-evaluate").html(selfEvaluate);

	                $("#self-info").show();
	                $("#change").hide();
	                alert("修改成功");
	            }
	            console.log(html)
	        },
	        error:function(err){
	             
	        }

	    });

	}) 
