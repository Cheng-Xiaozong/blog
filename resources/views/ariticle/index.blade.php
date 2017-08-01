@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{asset('home/css/comment.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/style.css')}}">

@show
@section('content')
    <div class="home-content g-container">
        <div class="home-content-main g-container-main">
            <div class="home-content-bloglist g-container-left">
                <div class="bloglist-title g-title">
                    博文列表
                </div>
                @if(count($ariticles))
                    <ul class="bloglist-list">
                        @foreach($ariticles as $ariticle)
                            <li class="g-pointer"><a href="{{url('ariticle/detail',['id'=>$ariticle->id])}}">{{$ariticle->title}}</a></li>
                        @endforeach
                    </ul>
                    <div class="page-box">
                        {{$ariticles->render()}}
                    </div>
                @else
                    <p style="text-align: center;color:#ffffaa;padding:30px;">还没有人发表过博客⊙︿⊙</p>
                @endif
            </div>
            <div class="g-container-right home-content-blogcontent">
                <div class="blogcontent-text g-title">{{Request::getPathInfo()=='/' ? '最新发表' : '博客内容'}}</div>
                @if(count($newAriticle)==0)
                    <p style="text-align: center;color:#ffffaa;padding:30px;">还没有人发表过博客⊙︿⊙</p>
                @else
                <div class="home-content-blogcontentmain">
                    <div class="blogcontent-title" data-id="{{$newAriticle->id}}">{{$newAriticle->title}}</div>
                    <div class="blogcontent-bloginfo">
                        <div class="bloginfo-star">
                            <img src="{{asset('home/img/pageHome/home-bloginfo-star.png')}}"/>
                            赞（{{$newAriticle->praise_num}}）
                        </div>
                        <div class="bloginfo-comment">
                            <img src="{{asset('home/img/pageHome/home-bloginfo-comment.png')}}"/>
                            评论（{{$newAriticle->comment_mum}}）
                        </div>
                        <div class="bloginfo-readcount">
                            <img src="{{asset('home/img/pageHome/home-bloginfo-datetime.png')}}"/>
                            浏览（{{$newAriticle->views}}）
                        </div>
                        <div class="bloginfo-datetime">
                            <a href="{{url('brotherBlog',['user_id'=>$newAriticle->user_id])}}">{{$newAriticle->author}}</a> 发表于 {{$newAriticle->created_at}}
                        </div>

                    </div>
                    <div class="blogcontent-content">
                        <p class="content-text">{!!$newAriticle->content!!}</p>
                    </div>
                    @include('ariticle.comment')
                </div>
                @endif
            </div>
        </div>
    </div>
    
@stop
@section('javascript')
    <script src="{{asset('home/js/jquery.min.js')}}"></script>
    <script src="{{asset('home/js/home.js')}}"></script>
    <script src="{{asset('home/js/global.js')}}"></script>
    <script src="{{asset('home/js/jquery.flexText.js')}}"></script>
    <script src="{{asset('home/js/myBlogDiscuss.js')}}"></script>
    <script src="{{asset('home/js/myBlog.js')}}"></script>
@stop

