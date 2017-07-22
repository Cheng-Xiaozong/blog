@extends('layouts.app')
@section('banner')
@stop
@section('content')
    <div class="mblog-content g-container">
        <div class="mblog-content-main g-container-main">
            @include('ariticle.myinfo')
            <div class="g-container-right home-content-blogcontent">
                <div class="blogcontent-text g-title">博客内容</div>
                    <div class="home-content-blogcontentmain">
                        <div class="blogcontent-title">{{$newAriticle->title}}</div>
                        <div class="blogcontent-bloginfo">
                            <div class="bloginfo-star">
                                <img src="{{asset('home/img/pageHome/home-bloginfo-star.png')}}"/>
                                赞（99）
                            </div>
                            <div class="bloginfo-comment">
                                <img src="{{asset('home/img/pageHome/home-bloginfo-comment.png')}}"/>
                                评论（88）
                            </div>
                            <div class="bloginfo-readcount">
                                <img src="{{asset('home/img/pageHome/home-bloginfo-datetime.png')}}"/>
                                浏览（{{$newAriticle->views}}）
                            </div>
                            <div class="bloginfo-datetime">
                                {{$newAriticle->author}} 发表于 {{$newAriticle->created_at}}
                            </div>

                        </div>
                        <div class="blogcontent-content">
                            <p class="content-text">{!!$newAriticle->content!!}</p>
                        </div>
                        <textarea class="blogcontent-comment">发表评论。。。</textarea>
                        <ul class="blogcontent-commentlist">
                            <li>
                                <img src="{{asset('home/img/pageHome/home-author-icon.png')}}"/>
                                <div class="commentlist-info">
                                    <p class="commentlist-infotop"><span class="commentlist-infoname g-hover g-pointer">yangxin</span><span class="commentlist-infotime">14:23:03</span></p>
                                    <p class="commentlist-infobottom">这篇文章针砭时弊，批评世俗，反思历史，解读人生，公正深刻，辛辣幽默，雅俗共赏，生动鲜活，甚是好文章哟 ！</p>
                                </div>
                            </li>
                            <li>
                                <img src="{{asset('home/img/pageHome/home-author-icon.png')}}"/>
                                <div class="commentlist-info">
                                    <p class="commentlist-infotop"><span class="commentlist-infoname g-pointer g-hover">yangxin</span><span class="commentlist-infotime">14:23:03</span></p>
                                    <p class="commentlist-infobottom">这篇文章针砭时弊，批评世俗，反思历史，解读人生，公正深刻，辛辣幽默，雅俗共赏，生动鲜活，甚是好文章哟 ！</p>
                                </div>
                            </li>
                        </ul>
                        <div class="blogcontent-loadmore g-btn">加载更多精彩评论...</div>
                    </div>
            </div>

            </div>
        </div>
    </div>
@stop
@section('javascript')
    <script src="{{asset('home/js/myBlog.js')}}"></script>
@stop

