<!-- 成功提示框 -->
@if(Session::has('success'))
	<div class="modalDialog-bg" style="z-index: 1000;">
      <div class="modalDialog-content">
          <img class="modalDialog-close pointer" src="{{asset('home/img/pageIndex/cancle.png')}}">
          <div  class="modalDialog-top"><img src="{{asset('home/img/pageIndex/logo.png')}}"/></div>
          <div  class="modalDialog-middle">
          	{{Session::get('success')}}
          </div>
          <div  class="modalDialog-bottom">
              <span class="pointer" style="background: rgba(23,22,27,1);">确定</span>
          </div>
      </div>
  </div>
  <script>
    $(".pointer").click(function(){
    	$(".modalDialog-bg").hide();
    })
 </script>
@endif

<!-- 失败提示框 -->
@if(Session::has('error'))
   <script>
   
   	alert("{{Session::get('error')}}");
  
   </script>]

@endif