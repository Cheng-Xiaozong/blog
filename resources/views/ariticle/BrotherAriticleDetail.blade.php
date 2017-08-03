@extends('layouts.app')
@section('banner')
@stop
@section('style')
    <link rel="stylesheet" href="{{asset('home/css/comment.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/style.css')}}">
@show
@section('content')
    <div class="mblog-content g-container">
        <div class="mblog-content-main g-container-main">
            @include('ariticle.brotherinfo')
            <div class="g-container-right home-content-blogcontent">
                <div class="blogcontent-text g-title">博客内容</div>
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
                                {{$newAriticle->created_at}}
                            </div>

                        </div>
                        <div class="blogcontent-content">
                            <p class="content-text">{!!$newAriticle->content!!}</p>
                        </div>
                       @include('ariticle.comment')
                    </div>
            </div>

            </div>
        </div>
    </div>
@stop
@section('javascript')
    <script src="{{asset('home/js/jquery.flexText.js')}}"></script>
    <script src="{{asset('home/js/discuss.js')}}"></script>
@stop

