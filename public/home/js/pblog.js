/**
 * Created by shenyuting on 2017/5/5.
 * pblog.js
 * pblog Javascript File
 */

	$(function(){
		$("#tijiao").click(function(){
			var pblogUserName=$("#pblog-username").html();
		var pblogTitle=document.getElementById("pblog-title").value;
		var pblogContent=document.getElementById("pblog-content").value;
	 $.get("../php/Interface/ArticlePublish.php", 
    	{"articleAuthorId":1,"articleTitle":pblogTitle,"articleContent":pblogContent}, 
    	function (data) {
	    	alert("提交成功");
			 console.log(data); 
    	});
		});
	});
