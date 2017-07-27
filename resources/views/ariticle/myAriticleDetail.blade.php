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
                        <div class="commentAll">
                            <!--评论区域 begin-->
                            <div class="reviewArea clearfix">
                                <textarea class="content comment-input" placeholder="Please enter a comment&hellip;" onkeyup="keyUP(this)"></textarea>
                                <a href="javascript:;" class="plBtn">评论</a>
                            </div>
                            <!--评论区域 end-->
                            <!--回复区域 begin-->
                            @foreach($comments as $comment)
                                <div class="comment-show">
                                    <div class="comment-show-con clearfix">
                                        <div class="comment-show-con-img pull-left"><img src="{{$comment->user_portrait}}" alt=""></div>
                                        <div class="comment-show-con-list pull-left clearfix">
                                            <div class="pl-text clearfix">
                                                <a href="#" class="comment-size-name">{{$comment->user_name}} : </a>
                                                <span class="my-pl-con">&nbsp;{{$comment->content}}</span>
                                            </div>
                                            <div class="date-dz">
                                                <span class="date-dz-left pull-left comment-time">{{$comment->created_at}}</span>
                                                <div class="date-dz-right pull-right comment-pl-block">
                                                    <a href="javascript:;" class="removeBlock">删除</a>
                                                    <a href="javascript:;" class="date-dz-pl pl-hf hf-con-block pull-left">回复</a>
                                                    <span class="pull-left date-dz-line">|</span>
                                                    <a href="javascript:;" class="date-dz-z pull-left"><i class="date-dz-z-click-red"></i>赞 (<i class="z-num">{{$comment->praises}}</i>)</a>
                                                </div>
                                            </div>
                                            <div class="hf-list-con"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="blogcontent-loadmore g-btn">加载更多精彩评论...</div>
                    </div>
            </div>

            </div>
        </div>
    </div>
@stop
@section('javascript')
    <script src="{{asset('home/js/jquery.min.js')}}"></script>
    <script src="{{asset('home/js/global.js')}}"></script>
    <script type="text/javascript" src="{{asset('home/js/jquery.flexText.js')}}"></script>
    <script type="text/javascript " src="{{asset('home/js/myBlogDiscuss.js')}}"></script>
    <script src="{{asset('home/js/myBlog.js')}}"></script>
    <script type="text/javascript">
        $("#photo").change(function(){
            var filepath=$("#photo").val(); 
            var extStart=filepath.lastIndexOf("."); 
            var ext=filepath.substring(extStart,filepath.length).toUpperCase(); 
            if(ext!=".BMP"&&ext!=".PNG"&&ext!=".GIF"&&ext!=".JPG"&&ext!=".JPEG"){ 
                alert("图片限于bmp,png,gif,jpeg,jpg格式"); 
                return false; 
            } 
            var file_size = 0;
            file_size = this.files[0].size;
            // console.log(file_size/1024/1024 + " MB");
            var size = file_size / 1024;
            if(size > 10240){
                alert("上传的文件大小不能超过10M！");
                return false;
            }
            
            if($("#photo").val() != ''){
                doUpload();
            }
        });

        function doUpload() {  
             var portrait = new FormData($( "#person-photo")[0]);  
             $.ajax({  
                  url: urlGlobal+'/updatePt',
                  type: 'post',
                  data: portrait,
                  async: false,  
                  cache: false,  
                  contentType: false,  
                  processData: false,  
                  success: function (data) {  
                      // $("#avatar").attr({'src':returndata.data});
                      if (data.status == 1) {
                        alert("修改成功");
                      }
                      
                  },  
                  error: function (data) {  
                      
                  }  
             });
        }

        var info=$("#infomation");

        info.click(function(){
            $("#self-info").hide();
            $("#change").show();
            $("#name2").val($("#name").text());
            $("#intrest2").val($("#intrest").text());
            $("#maxim2").val($("#maxim").text());
            $("#self-evaluate2").text($("#self-evaluate").text());
            console.log($("#self-evaluate").text());

        })
        $("#cansle").click(function(){
            $("#self-info").show();
            $("#change").hide();
        })
        $("#upload-info").click(function(){
            var name = $("#name2").val();
            var sex =  $('input:radio[name="1"]:checked').val();
            // console.log(sex);
            var intrest = $("#intrest2").val();
            var maxim = $("#maxim2").val();
            var selfEvaluate = $("#self-evaluate2").val();

            if (!name) {
                alert("名字不能为空");
                return false;
            }
            if (!intrest) {
                alert("爱好不能为空");
                return false;
            }
            if (!maxim) {
                alert("签名不能为空");
                return false;
            }
            if (!selfEvaluate) {
                alert("自我评价不能为空");
                return false;
            }
            $.ajax({
                url: urlGlobal+'/updateMyInfo',  
                type: "post",
                dataType:'json',  
                data: { 
                    "_token":"{{csrf_token()}}","User[name]":name,"User[sex]":sex,"User[hobby]":intrest,"User[signature]":maxim,"User[details]":selfEvaluate},
               
                success: function(html){ 
                    if (html.status == 1) {
                        $("#self-info").show();
                        $("#change").hide();
                        $("#name").html(name);
                        if ( sex == 0) {
                            $("#sex").html("女");
                        }else{
                            $("#sex").html("男");
                        }
                        $("#intrest").html(intrest)
                        $("#maxim").html(maxim);
                        $("#self-evaluate").html(selfEvaluate);
                        alert("修改成功");
                    }
                    console.log(html)
                },
                error:function(err){
                     
                }

            });
            // console.log(selfEvaluate);
            // console.log(intrest);
            // alert(selfEvaluate);
            // var User=new Array();
            // User["name"]=name;
            // User["sex"]=sex;
            // User["hobby"]=intrest;
            // User["signature"]=maxim;
            // User["details"]=selfEvaluate;
            // var User = {
            //     name : name,
            //     sex:sex,
            //     hobby:intrest,
            //     signature:maxim,
            //     details:selfEvaluate
            // }
            // "User.name":name,"User.sex":sex,"User.hobby":intrest,"User.signature":maxim,"User.details":selfEvaluate
            
             

        })     

    </script>

@stop

