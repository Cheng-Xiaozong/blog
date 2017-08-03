@extends('layouts.app')
@section('content')
    <div class="mblog-content g-container">
        <div class="mblog-content-main g-container-main">
            @include('ariticle.brotherinfo')
            <div class="g-container-right">
                <div class="g-title"><span>兄弟的</span>博文</div>
                <div class="mblog-blogbox">
                    @if(count($ariticles)==0)
                        <p style="text-align: center;color:#ffffaa;padding:30px;">该兄弟还没有发表过博客⊙︿⊙</p>
                    @else
                        <ul class="myblog-blogul">
                            @foreach($ariticles as $ariticle)
                            <li>
                                <div class="mblog-blogdate">
                                    <p>{{date('m/d',strtotime($ariticle->created_at))}}</p>
                                    <p>{{date('Y',strtotime($ariticle->created_at))}}</p>
                                </div>
                                <div class="mblog-blogother">
                                    <div class="mblog-blog-other-title"><a class="title-hover g-pointer" data-id="{{$ariticle->id}}" href="{{url('BrotherAriticleDetail',$ariticle->id)}}">{{$ariticle->title}}</a></div>
                                    <div class="mblog-blog-other-bloginfo">

                                        <div class="bloginfo-star">
                                            <img src="{{asset('home/img/pageHome/home-bloginfo-star.png')}}"/>
                                            赞（{{$ariticle->praise_num}}）
                                        </div>
                                        <div class="">
                                            <img src="{{asset('home/img/pageHome/home-bloginfo-comment.png')}}"/>评论（{{$ariticle->comment_mum}}）
                                        </div>
                                        <div class="">
                                            <img src="{{asset('home/img/pageHome/home-bloginfo-datetime.png')}}"/>浏览（{{$ariticle->views}}）
                                        </div>
                                    </div>
                                    <div class="mblog-blog-content">
                                      {!!mb_substr($ariticle->content,0,350,'utf-8') !!}
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="page-box mblog-pagination">
                    {{$ariticles->render()}}
                </div>
            </div>
        </div>
    </div>
@stop
@section('javascript')
    <script src="{{asset('home/js/home.js')}}"></script>
@stop

