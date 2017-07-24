@extends('layouts.app')
@section('content')
    <div class="mblog-content g-container">
        <div class="mblog-content-main g-container-main">
            @include('ariticle.myinfo')
            <div class="g-container-right">
                <div class="g-title"><span>我的</span>博文</div>
                <div class="mblog-blogbox">
                    @if(count($ariticles)==0)
                        <p style="text-align: center;color:#ffffaa;padding:30px;">你还没有发表过博客⊙︿⊙</p>
                    @else
                        <ul class="myblog-blogul">
                            @foreach($ariticles as $ariticle)
                            <li>
                                <div class="mblog-blogdate">
                                    <p>{{date('m/d',strtotime($ariticle->created_at))}}</p>
                                    <p>{{date('Y',strtotime($ariticle->created_at))}}</p>
                                </div>
                                <div class="mblog-blogother">
                                    <div class="mblog-blog-other-title"><a class="title-hover g-pointer" href="{{url('myAriticleDetail',$ariticle->id)}}">{{$ariticle->title}}</a></div>
                                    <div class="mblog-blog-other-bloginfo">
                                        <div class="del g-pointer">
                                            <img src="{{asset('home/img/pageMyblog/mblog-delete.png')}}">
                                            <a href="{{url('ariticle/delete',['id'=>$ariticle->id])}}" onclick="if(confirm('你确定要删除这篇文章吗？') == false) return false">删除</a>
                                        </div>
                                        <div class="del g-pointer">
                                            <img src="{{asset('home/img/pageMyblog/mblog-delete.png')}}">
                                            <a href="{{url('ariticle/edit',['id'=>$ariticle->id])}}">编辑</a>
                                        </div>
                                        <div class="star g-pointer">
                                            <img src="{{asset('home/img/pageHome/home-bloginfo-star.png')}}"/>赞（99+）
                                        </div>
                                        <div class="">
                                            <img src="{{asset('home/img/pageHome/home-bloginfo-comment.png')}}"/>评论（99+）
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
    <script src="{{asset('home/js/myBlog.js')}}"></script>
    <script src="{{asset('home/js/home.js')}}"></script>
@stop

