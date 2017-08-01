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
    <script type="text/javascript">
        //个人信息修改
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
            if (name.length<3) {
                alert("名字长度不能少于3个字符");
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

                        $("#self-info").show();
                        $("#change").hide();
                        alert("修改成功");
                    }
                },
                error:function(err){
                     
                }

            });

        }) 
    </script>

    <script type="text/javascript">
        //评论

        $(function () {
            $('.content').flexText();
        });


        function keyUP(t){
            var len = $(t).val().length;
            if(len > 10){
                $(t).val($(t).val().substring(0,1001));
            }
            userJudge();
        }


        
        $('.commentAll').on('click','.plBtn',function(){
            
            var oSize = $(this).siblings('.flex-text-wrap').find('.comment-input').val();
            var ariticle_id = $(".blogcontent-title").attr("data-id");
            var newComment = $(this).parents('.reviewArea').siblings('.comment-show');
            // ,"Comment[ariticle_id]":ariticle_id,"Comment[content]":oSize   "{{csrf_token()}}"

            
            $.ajax({
              url: urlGlobal+'/createComment',
              type: 'post',
              dataType:'json',
              data: { "_token":"{{csrf_token()}}","Comment[ariticle_id]":ariticle_id,"Comment[content]":oSize},
              success: function (data) {  
                  // $("#avatar").attr({'src':returndata.data});
                  if (data.status == -1) {
                    alert("评论失败");
                  }
                  if(data.status == 1){
                    console.log(data["data"]);
                    console.log(data["data"].id);
                    // $.each(data["data"],function(i,item){
                    var commentId = data["data"].id;
                    var commentTime = data["data"].created_at;
                    // var commentName = data["data"].user_name;
                    // var commentHeadImg = data["data"].user_portrait;
                    var commentContent = data["data"].content;
                    // var commentPraises = data["data"].praises;
                    // var commentNum = data["data"].num;

                    // window.location.reload();
                    oHtml = '<div class="comment-show-con clearfix" data-id = "'+commentId+'"><div class="comment-show-con-img pull-left"><img class="comment-head-img" src="" alt=""></div> <div class="comment-show-con-list pull-left clearfix"><div class="pl-text clearfix"> <a href="#" class="comment-size-name">我 : </a> <span class="my-pl-con">&nbsp;'+ commentContent +'</span> </div> <div class="date-dz"> <span class="date-dz-left pull-left comment-time">'+commentTime+'</span> <div class="date-dz-right pull-right comment-pl-block"><a href="javascript:;" class="removeBlock">删除</a> <a href="javascript:;" class="date-dz-pl pl-hf hf-con-block pull-left">回复</a><span class="pull-left date-dz-line">|</span><a href="javascript:;" class="date-dz-z pull-left">赞 <i class="z-num"></i></a></div> </div><div class="hf-list-con"></div></div> </div>';

                    newComment.prepend(oHtml);
                    $(".no-comment").hide();
                  }
                  
              },  
              error: function (data) {  
                  
              }  
            });


            
            
        });
        //点击回复显示输入框
        $('.comment-show').on('click','.pl-hf',function(){
            //获取回复人的名字
            var fhName = $(this).parents('.date-dz-right').parents('.date-dz').siblings('.pl-text').find('.comment-size-name').html();
            //回复@
            var fhN = '回复@'+fhName;
            //var oInput = $(this).parents('.date-dz-right').parents('.date-dz').siblings('.hf-con');
            var fhHtml = '<div class="hf-con pull-left"> <textarea class="content comment-input hf-input" placeholder="" onkeyup="keyUP(this)"></textarea> <a href="javascript:;" class="hf-pl">回复</a></div>';
            //显示回复
            if($(this).is('.hf-con-block')){
                $(this).parents('.date-dz-right').parents('.date-dz').append(fhHtml);
                $(this).removeClass('hf-con-block');
                $('.content').flexText();
                $(this).parents('.date-dz-right').siblings('.hf-con').find('.pre').css('padding','6px 15px');
                //console.log($(this).parents('.date-dz-right').siblings('.hf-con').find('.pre'))
                //input框自动聚焦
                $(this).parents('.date-dz-right').siblings('.hf-con').find('.hf-input').val('').focus().val(fhN);
            }else {
                $(this).addClass('hf-con-block');
                $(this).parents('.date-dz-right').siblings('.hf-con').remove();
            }
        });

        //点击将 回复 提交

        $('.comment-show').on('click','.hf-pl',function(){
            var oThis = $(this);
            //获取输入内容
            var oHfVal = $(this).siblings('.flex-text-wrap').find('.hf-input').val();
            console.log(oHfVal)
            var oHfName = $(this).parents('.hf-con').parents('.date-dz').siblings('.pl-text').find('.comment-size-name').html();
            var oAllVal = '回复@'+oHfName;

            //文章ID
            var thisAriticleId = $(".blogcontent-title").attr("data-id");
            //当前楼层的ID
            var floorId = $(this).parents('.hf-con').parents('.comment-show-con-list').parents('.comment-show-con').attr("data-id");
            console.log(floorId);


            $.ajax({
              url: urlGlobal+'/createFloor',
              type: 'post',
              dataType:'json',
              data: { "_token":"{{csrf_token()}}","Comment[ariticle_id]":thisAriticleId,"Comment[content]":oHfVal,"Comment[floor_id]":floorId},
              success: function (data) {  
                  // $("#avatar").attr({'src':returndata.data});
                  if (data.status == -1) {
                    alert("评论失败");
                  }
                  if(data.status == 1){
                    console.log(data["data"]);
                    // console.log(data["data"].id);
                    // // $.each(data["data"],function(i,item){
                    var createFloorContent = data["data"].content;
                    var createFloorTime = data["data"].created_at;
                    var oHtml = '<div class="all-pl-con"><div class="pl-text hfpl-text clearfix"><a href="#" class="comment-size-name">我的名字 : </a><span class="my-pl-con">'+createFloorContent+'</span></div><div class="date-dz"> <span class="date-dz-left pull-left comment-time">'+createFloorTime+'</span> <div class="date-dz-right pull-right comment-pl-block"> <a href="javascript:;" class="removeBlock">删除</a> <a href="javascript:;" class="date-dz-pl pl-hf hf-con-block pull-left">回复</a></div> </div></div>';
                    oThis.parents('.hf-con').parents('.comment-show-con-list').find('.hf-list-con').css('display','block').append(oHtml) && oThis.parents('.hf-con').siblings('.date-dz-right').find('.pl-hf').addClass('hf-con-block') && oThis.parents('.hf-con').remove();
                  }
                  
              },  
              error: function (data) {  
                  
              }  
            });

            
        });

        //删除主楼评论
        $('.commentAll').on('click','.removeBlock',function(){

            var indexComment = $(this).parents('.date-dz-right').parents('.date-dz').parents('.comment-show-con-list').parents('.comment-show-con');
            var indexCommentId = indexComment.attr("data-id");
            console.log(indexCommentId);
            $.ajax({
              url: urlGlobal+'/deleteComment',
              type: 'post',
              dataType:'json',
              data: { "_token":"{{csrf_token()}}","id":indexCommentId},
              success: function (data) {  
                  // $("#avatar").attr({'src':returndata.data});
                  if (data.status == -1) {
                    alert("删除失败");
                  }
                  if(data.status == 1){
                    indexComment.remove();
                  }
                  
              },  
              error: function (data) {  
                  
              }  
            });
            indexComment.remove();
            $(this).siblings('.flex-text-wrap').find('.comment-input').prop('value','').siblings('pre').find('span').text('');

        })

        //加载更多评论
        $('.commentAll').on('click','.blogcontent-loadmore',function(){

            // var indexComment = $(this).parents('.date-dz-right').parents('.date-dz').parents('.comment-show-con-list').parents('.comment-show-con').parents('.comment-show');
            // var indexCommentId = indexComment.attr("data-id");
            // console.log(indexCommentId);

            // var loadMoreTitelId = $(".blogcontent-title").attr("data-id");
            // var lastId = '';
            // $.ajax({
            //   url: urlGlobal+'/deleteComment',
            //   type: 'post',
            //   dataType:'json',
            //   data: { "_token":"{{csrf_token()}}","id":indexCommentId},
            //   success: function (data) {  
            //       // $("#avatar").attr({'src':returndata.data});
            //       if (data.status == -1) {
            //         alert("删除失败");
            //       }
            //       if(data.status == 1){
            //         indexComment.remove();
            //       }
                  
            //   },  
            //   error: function (data) {  
                  
            //   }  
            // });
            // indexComment.remove();

        })
    </script>
    <script type="text/javascript">
        
        //头像
        $(".head-img").attr("src",urlGlobal+"/{{$userInfo->portrait($userInfo->head_portrait)}}");

        // $(".comment-head-img").each(function(url){
        //     $(this).attr("src",urlGlobal+"/"+url);
        // })
        // var commentImgUrl;
        // function commentHeadImg(commentImgUrl){
        //     // $(this).attr("src",urlGlobal+'/'+commentImgUrl);
        //     document.images.imgInit.src=urlGlobal+'/'+commentImgUrl;
        // }

    </script>

@stop

