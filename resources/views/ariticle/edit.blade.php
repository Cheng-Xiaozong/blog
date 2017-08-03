@extends('layouts.app')
@section('style')
@stop
@section('banner')
@stop
@section('content')
    {{--错误处理--}}
    @if (count($errors))
    {{--
        <div>
            <ul >
                @foreach($errors->all() as $error)
                    <li>slsfsf{{ $error }}</li>
                    <script type="text/javascript">
                        console.log({{ $error }});
                    </script>
                    
                @endforeach
            </ul>
        </div>
    --}}
        <div class="modalDialog-bg" style="z-index: 1000;" >
            <div class="modalDialog-content" >
                <img class="modalDialog-close pointer" src="{{asset('home/img/pageIndex/cancle.png')}}">
                <div  class="modalDialog-top"><img src="{{asset('home/img/pageIndex/logo.png')}}"/></div>
                <div  class="modalDialog-middle">
                    @foreach($errors->all() as $error)
                        {{ $error }}；
                    @endforeach
                </div>
                <div  class="modalDialog-bottom">
                    <span class="pointer" id="delete" style="background: rgba(23,22,27,1);">确定</span>
                </div>
            </div>
        </div>
    @endif
    <div class="pblog-content g-container">
        <div class="pblog-content-main g-container-main">
            <form action="" method="post">
                {{ csrf_field() }}
                <div class="blog-titlediv">
                    <input placeholder="请输入博客标题" id="pblog-title"  name="ariticle[title]"
                           value="{{old('ariticle')['title'] ? old('ariticle')['title'] : $ariticle->title}}"/>
                </div>
                <div class="blog-contentdiv" style="width:813px;margin:30px auto;">
                    <!-- 加载编辑器的容器 -->
                    <script id="container" name="ariticle[content]" type="text/plain">
                        {!!
                            old('ariticle')['content'] ? old('ariticle')['content'] : $ariticle->content
                        !!}
                    </script>
                </div>
                <div class="blog-btndiv">
                    <div class="g-btn blogSubmit"> <input type="submit" value="保存修改" class="g-btn" id="tijiao"></div>
                </div>
            </form>
        </div>
    </div>
@stop
@section('javascript')

    <!-- 配置文件 -->
    <script type="text/javascript" src="{{asset('static/ueditor/ueditor.config.js')}}"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="{{asset('static/ueditor/ueditor.all.js')}}"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container', {
            initialFrameWidth: 810,
            initialFrameHeight: 400
        });
    </script>
    <script src="{{asset('home/js/modalDialog.js')}}"></script>
    <script src="{{asset('home/js/create-blog.js')}}"></script>
@stop

