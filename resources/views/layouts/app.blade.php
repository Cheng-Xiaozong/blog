<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="yangxin" />
    <meta name="keywords" content="兄弟博客" />
    <meta name="description" content="兄弟博客" />
    <title>Brother Blog - @yield('title')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('home/img/logo.ico')}}" media="screen" />
    <link rel="stylesheet" href="{{asset('home/css/main.css')}}">
    @section('style')

    @show
</head>
<body>
@section('header')
    <div class="home-header g-header">
        <div class="home-header-main g-header-main">
            <div class="home-header-logo g-header-logo">
                <img src="{{asset('home/img/pageHome/home-logo.png')}}"/>
            </div>
            <div class="home-header-userinfo g-header-userinfo">
                @if (Auth::guest())
                    <div class="exit g-pointer">
                        <img src="{{asset('home/img/pageHome/home-exiticon.png')}}"/>
                        <span><a href="{{ url('/register') }}">注册</a></span>
                    </div>
                    <div class="myblog g-pointer">
                        <img src="{{asset('home/img/pageHome/home-usericon.png')}}"/>
                        <span><a href="{{url('/login')}}">登录</a></span>
                    </div>
                @else
                    <div class="exit g-pointer">
                        <img src="{{asset('home/img/pageHome/home-exiticon.png')}}"/>
                        <span><a href="{{ url('/logout') }}">退出</a></span>
                    </div>
                    <div class="myblog g-pointer">
                        @if(Request::getPathInfo()=='/myblog')
                            <img src="{{asset('/home/img/pageMyblog/myblog-publishblog.png')}}"/>
                            <span><a href="{{url('ariticle/create')}}">发表博客</a></span>
                        @else
                            <img src="{{asset('home/img/pageHome/home-usericon.png')}}"/>
                            <span><a href="{{url('/myblog')}}">我的博客</a></span>
                        @endif

                    </div>
                    <div class="username g-pointer" data-userId="{{ Auth::user()->id }}">
                         用户名：{{ Auth::user()->name }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@show
@section('banner')
    <div class="home-banner">
        <div class="home-bannner-content">
            <img src="{{asset('home/img/pageHome/home-banner1.png')}}"/>
            <img src="{{asset('home/img/pageHome/home-banner2.png')}}"/>
            <img src="{{asset('home/img/pageHome/home-banner3.png')}}"/>
        </div>
    </div>
@show
@yield('content')
@section('footer')
    <div class="home-footer g-footer">
        &copy; Brother Blog，长沙市岳麓区薯仔饭餐厅
    </div>
@show
<script src="{{asset('home/js/global.js')}}"></script>
<script src="{{asset('home/js/jquery.min.js')}}"></script>
<script src="{{asset('home/js/modalDialog.js')}}"></script>
@section('javascript')

@show
</body>
</html>
@include('ariticle.message')