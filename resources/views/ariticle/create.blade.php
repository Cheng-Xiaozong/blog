@extends('layouts.app')
@section('style')

@stop
@section('banner')
@stop
@section('content')
    {{--错误处理--}}
    @if (count($errors))
        
        <div class="modalDialog-bg" style="z-index: 1000;">
            <div class="modalDialog-content">
                <img class="modalDialog-close pointer" src="{{asset('home/img/pageIndex/cancle.png')}}">
                <div  class="modalDialog-top"><img src="{{asset('home/img/pageIndex/logo.png')}}"/></div>
                <div  class="modalDialog-middle">
                @foreach($errors->all() as $error)
                    {{ $error }};
                @endforeach
                </div>
                <div  class="modalDialog-bottom">
                    <span class="pointer" style="background: rgba(23,22,27,1);">确定</span>
                    <!-- <span class="pointer" style="background: rgba(23,22,27,0.5);">取消</span> -->
                </div>
            </div>
        </div>
    @endif
    <div class="pblog-content g-container">
        <div class="pblog-content-main g-container-main">
            <form action="" method="post">
                {{ csrf_field() }}
                <div class="blog-titlediv"><input placeholder="请输入博客标题" id="pblog-title"  name="ariticle[title]" value="{{old('ariticle')['title']}}"/></div>
                <div class="blog-contentdiv" style="width:813px;margin:30px auto;">
                    <!-- 加载编辑器的容器 -->
                    <script id="container" name="ariticle[content]" type="text/plain">
                        {!!
                            old('ariticle')['content'] ? old('ariticle')['content'] : '点击右上角可进<em><strong><span style="color: rgb(255, 0, 0);">全屏编辑</span></strong></em>，在此编写你的博客吧...'
                        !!}
                    </script>
                </div>
                <div class="blog-btndiv">

                    <div class="g-btn"> 
                        <!-- <input type="submit" value="提交" class="g-btn" id="js-first-judge"> -->
                        <input type="submit" value="提交" class="g-btn" id="tijiao" >
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('javascript')
    <script src="{{asset('home/js/jquery.min.js')}}"></script>
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

    <script type="text/javascript">
        // $('.modalDialog-close').css('visibility', closeBtnShow?'visible':'hidden');
        // $('.modalDialog-bottom span:last').css('visibility', cancleBtnShow?'visible':'hidden');
        $('.modalDialog-close').unbind('click').bind('click', removeSelf);
        $('.pointer').unbind('click').bind('click', function(){
            $('.modalDialog-bg').remove();
        });
        function removeSelf(){
            $('.modalDialog-bg').remove();
        }

        // $("#js-first-judge").click(function(){
            // if(!$("#pblog-title").val()){
            //     $("#tijiao").hide();
            //     $("#js-first-judge").show();
            //     $("#js-first-judge").click(function(){
            //         alert("标题不为空")
            //     })
            // }else{
            //     $("#tijiao").show();
            //     $("#js-first-judge").hide();
            // }
        // })
        
    </script>
@stop





