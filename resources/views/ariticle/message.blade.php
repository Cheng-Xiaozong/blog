<!-- 成功提示框 -->
@if(Session::has('success'))
   <script>alert('{{Session::get('success')}}');</script>
@endif

<!-- 失败提示框 -->
@if(Session::has('error'))
   <script>alert('{{Session::get('error')}}');</script>
@endif