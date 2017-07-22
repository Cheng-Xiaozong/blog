@extends('layouts.app')
@section('title')
    登陆
@stop
@section('header')
@stop
@section('banner')
@stop
@section('content')
    <div class="index-container">

        <div class="index-container-operate" id="index-container-operate">
            <form class="form-horizontal" role="form" method="POST" action="{{url('/login')}}">
                {{ csrf_field() }}
                <div class="index-container-operateusername">
                    <img src="{{asset('/home/img/pageIndex/email.jpg')}}">
                    <input placeholder="请输入邮箱账号" id="usernameInput" type="text" class="form-control" name="email" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <span class="prompt prompt-error" id="loginPromptSpan">
                            {{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="index-container-operatepassword">
                    <img src="{{asset('/home/img/pageIndex/icon-pwd.png')}}">
                    <input id="passwordInput" type="password" class="form-control" name="password" placeholder="输入密码">
                    @if ($errors->has('email'))
                        <span class="prompt prompt-error" id="loginPromptSpan">
                            {{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <p class="pass" style="color:#f2f2f2;font-size: 12px;padding-top: 10px;padding-left: 10px;"><input type="checkbox" name="remember" >&nbsp;&nbsp;是否记住密码</p>

                <div class="index-container-operatesure pointer" id="sureDiv">
                     <input type="submit" value="登 录">
                </div>
                <div class="index-container-cancle pointer" id="cancleDiv">
                    <span class="prompt prompt-error" id="loginPromptSpan">用户名或登录密码不正确</span>
                    <a class="back" id="cancleSpan" href="{{ url('/register') }}">还没有账号？去注册</a>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer')
@stop
@section('javascript')
    <script src="{{asset('home/js/index.js')}}"></script>
@stop
