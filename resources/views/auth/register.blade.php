@extends('layouts.app')
@section('title')
    注册
@stop
@section('header')
@stop
@section('banner')
@stop
@section('content')
    <div class="index-container">
        <div class="index-container-operate" id="index-container-operate">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}
                <div class="index-container-operateusername">
                    <img src="{{asset('home/img/pageIndex/icon-user.png')}}">
                    <input id="usernameInput" type="text"  placeholder="请输入名字"  name="name" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <span class="prompt prompt-error" id="loginPromptSpan">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="index-container-operateusername">
                    <img src="{{asset('home/img/pageIndex/email.jpg')}}">
                    <input id="usernEmailInput" type="text" placeholder="请输入邮箱账号" name="email" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <span class="prompt prompt-error" id="loginPromptSpan">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="index-container-operatepassword">
                    <img src="{{asset('home/img/pageIndex/icon-pwd.png')}}">
                    <input id="passwordInput" type="password"placeholder="请设置密码" name="password">
                    @if ($errors->has('password'))
                        <span class="prompt prompt-error" id="loginPromptSpan">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="index-container-operatepassword">
                    <img src="{{asset('home/img/pageIndex/cof-pwd.jpg')}}">
                    <input id="surePasswordInput" type="password" name="password_confirmation"  placeholder="请确认密码">
                    @if ($errors->has('password_confirmation'))
                        <span class="prompt prompt-error" id="loginPromptSpan">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>
                <div class="index-container-operatesure pointer" id="sureDiv">
                    <input type="submit" value="注 册">
                </div>
                <div class="index-container-cancle pointer" id="cancleDiv">
                    <span class="prompt prompt-error" id="loginPromptSpan">用户名或登录密码不正确</span>
                    <a class="back" id="cancleSpan" href="{{url('/login')}}">已有账号？去登陆</a>
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
