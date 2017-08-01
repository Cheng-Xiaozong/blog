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
    <!-- <script src="{{asset('home/js/myBlogDiscuss.js')}}"></script> -->
    <!-- <script src="{{asset('home/js/myBlog.js')}}"></script> -->
    <script type="text/javascript">
        //评论

        $(function () {
            $('.content').flexText();
        });
        //是否登录
        function userJudge(){
            var userLoginJudge = $(".userLoginJudge").attr("data-userId");
            if(!userLoginJudge){
                alert("请登录后评论！");
                return ;
            }
        }
        $(".comment-input").on('click',function(){
            userJudge();
            // return true;
        })

        function keyUP(t){
            var len = $(t).val().length;
            if(len > 10){
                $(t).val($(t).val().substring(0,1001));
            }
        }


        
        $('.commentAll').on('click','.plBtn',function(){
            userJudge();
            var oThis = $(this);
            var oSize = $(this).siblings('.flex-text-wrap').find('.comment-input').val();
            var ariticle_id = $(".blogcontent-title").attr("data-id");
            var newComment = $(this).parents('.reviewArea').siblings('.comment-show');
            // ,"Comment[ariticle_id]":ariticle_id,"Comment[content]":oSize   "{{csrf_token()}}"

            
            $.ajax({
              url: urlGlobal+'/createComment',
              type: 'post',
              dataType:'json',
              data: { "_token":"{{csrf_token()}}","Comment[project_id]":ariticle_id,"Comment[content]":oSize},
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
                    oThis.siblings('.flex-text-wrap').find('.comment-input').prop('value','').siblings('pre').find('span').text('');
                  }
                  
              },  
              error: function (data) {  
                  
              }  
            });


            
            
        });

        //点击第一楼层回复显示输入框
        $('.comment-show').on('click','.pl-hf',function(){
            userJudge();
            var oThis = $(this);
            //获取回复人的名字
            var fhName = $(this).parents('.date-dz-right').parents('.date-dz').siblings('.pl-text').find('.comment-size-name').html();
            //回复@
            var fhN = '回复@'+fhName;
            //var oInput = $(this).parents('.date-dz-right').parents('.date-dz').siblings('.hf-con');
            var fhHtml = '<div class="hf-con pull-left"> <textarea class="content comment-input hf-input" placeholder="" onkeyup="keyUP(this)"></textarea> <a href="javascript:;" class="hf-pl">评论</a></div>';
            
            
            //显示回复
            if($(this).is('.hf-con-block')){
                $(this).parents('.date-dz-right').parents('.date-dz').append(fhHtml);
                $(this).removeClass('hf-con-block');
                $('.content').flexText();
                $(this).parents('.date-dz-right').siblings('.hf-con').find('.pre').css('padding','6px 15px');
                //console.log($(this).parents('.date-dz-right').siblings('.hf-con').find('.pre'))
                //input框自动聚焦
                $(this).parents('.date-dz-right').siblings('.hf-con').find('.hf-input').val('').focus().val(fhN);
                // $(".shouqi").addClass('hf-con-block')
                // $(this).parents('.date-dz-right').parents(".date-dz").siblings('.hf-list-con').removeClass('hf-con-block');
                
            }else {
                $(this).addClass('hf-con-block');
                $(this).parents('.date-dz-right').siblings('.hf-con').remove();
                
            }

        });



        //点击评论主楼层 不显示@名字 回复 提交
        $('.comment-show').on('click','.hf-pl',function(){
            userJudge();
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

            var startWord = oAllVal;

            var huifuContent = oHfVal.replace(startWord,'');


            $.ajax({
              url: urlGlobal+'/createFloor',
              type: 'post',
              dataType:'json',
              data: { "_token":"{{csrf_token()}}","Comment[project_id]":thisAriticleId,"Comment[content]":huifuContent,"Comment[floor_id]":floorId},
              success: function (data) {  
                  // $("#avatar").attr({'src':returndata.data});
                  if (data.status == -1) {
                    alert("评论失败");
                  }
                  if(data.status == 1){
                    console.log(data);
                    // console.log(data["data"].id);
                    // // $.each(data["data"],function(i,item){
                    var createFloorUserId = data["data"].user_id;
                    var createFloorParentUserId = data["data"].parent_user_id;
                    var createFloorFloorId = data["data"].floor_id;
                    var createFloorId = data["data"].id;
                    var createFloorContent = data["data"].content;
                    var createFloorTime = data["data"].created_at;
                    // var createFloorUser = data["data"].user_name;
                    var createFloorUser = $("#userOfName").html();
                    console.log(createFloorUser);
                    var oHtml = '<div class="all-pl-con" hf-id="'+createFloorId+'" floor-id = "'+createFloorFloorId+'"><div class="pl-text hfpl-text clearfix"><a href="#" class="comment-size-name" parent-user-id="'+createFloorParentUserId+'">'+createFloorUser+': </a><span class="my-pl-con">'+createFloorContent+'</span></div><div class="date-dz"> <span class="date-dz-left pull-left comment-time">'+createFloorTime+'</span> <div class="date-dz-right pull-right comment-pl-block"> <a href="javascript:;" class="removeBlock">删除</a> <a href="javascript:;" class="date-dz-pl hf-at hf-con-block pull-left">回复</a></div> </div></div>';
                    oThis.parents('.hf-con').parents('.comment-show-con-list').find('.hf-list-con').css('display','block').append(oHtml) && oThis.parents('.hf-con').siblings('.date-dz-right').find('.pl-hf').addClass('hf-con-block') && oThis.parents('.hf-con').remove();
                  }
                  
              },  
              error: function (data) {  
                  
              }  
            });

            
        });



        //点击第二楼层回复显示输入框
        $('.comment-show').on('click','.hf-at',function(){
            userJudge();
            //获取回复人的名字
            var fhName = $(this).parents('.date-dz-right').parents('.date-dz').siblings('.pl-text').find('.comment-size-name').html();
            //回复@
            var fhN = '回复@'+fhName;
            //var oInput = $(this).parents('.date-dz-right').parents('.date-dz').siblings('.hf-con');
            var fhHtml = '<div class="hf-con pull-left"> <textarea class="content comment-input hf-input" placeholder="" onkeyup="keyUP(this)"></textarea> <a href="javascript:;" class="hf-pl-two">评论</a></div>';
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
        //回复第二楼层 显示@名字
        $('.comment-show').on('click','.hf-pl-two',function(){
            userJudge();
            var oThis = $(this);
            //获取输入内容
            var oHfVal = $(this).siblings('.flex-text-wrap').find('.hf-input').val();
            
            var oHfName = $(this).parents('.hf-con').parents('.date-dz').siblings('.pl-text').find('.comment-size-name').html();
            var oAllVal = '回复@'+oHfName;

            //文章ID
            var thisAriticleId = $(".blogcontent-title").attr("data-id");
            //当前楼层的ID
            var floorId = $(this).parents('.hf-con').parents('.date-dz').parents('.comment-show-con-list').parents('.comment-show-con').attr("data-id");
            console.log(floorId);
            //parent-id
            var parentId = $(this).parents('.hf-con').parents('.date-dz').siblings('.pl-text').children(".comment-size-name").attr("user-id");

            var startWord = oAllVal;

            var huifuContent = oHfVal.replace(startWord,'');


            $.ajax({
              url: urlGlobal+'/createFloorComment',
              type: 'post',
              dataType:'json',
              data: { "_token":"{{csrf_token()}}","Comment[project_id]":thisAriticleId,"Comment[content]":huifuContent,"Comment[floor_id]":floorId,"Comment[parent_user_id]":parentId},
              success: function (data) {  
                    console.log(data);
                  // $("#avatar").attr({'src':returndata.data});
                  if (data.status == -1) {
                    alert("评论失败");

                  }
                  if(data.status == 1){
                    var createFloorCommentParentId = data["data"].parent_user_id;
                    var createFloorCommentFloorId = data["data"].floor_id;
                    var createFloorCommentId = data["data"].id;
                    var createFloorCommentContent = data["data"].content;
                    var createFloorCommentTime = data["data"].created_at;
                    // var createFloorCommentUser = data["data"].user_name;
                    var createFloorCommentUser = $("#userOfName").html();
                    var toUser = oHfName;
                    var oHtml = '<div class="all-pl-con " hf-id="'+createFloorCommentId+'"  floor-id = "'+createFloorCommentFloorId+'"><div class="pl-text hfpl-text clearfix"><a href="#" class="comment-size-name" parent-user-id="'+createFloorCommentParentId+'">'+createFloorCommentUser+': </a><span class="parentBox">回复@：</span><span class="parentIdStyle">'+toUser+'</span><span class="my-pl-con">'+createFloorCommentContent+'</span></div><div class="date-dz"> <span class="date-dz-left pull-left comment-time">'+createFloorCommentTime+'</span> <div class="date-dz-right pull-right comment-pl-block"> <a href="javascript:;" class="removeBlock">删除</a> <a href="javascript:;" class="date-dz-pl hf-at hf-con-block pull-left">回复</a></div> </div></div>';
                    oThis.parents('.hf-con').parents('.comment-show-con-list').find('.hf-list-con').css('display','block').append(oHtml) && oThis.parents('.hf-con').siblings('.date-dz-right').find('.hf-at').addClass('hf-con-block') && oThis.parents('.hf-con').remove();
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

        //删除第二楼层回复
        $('.commentAll').on('click','.removeBlock',function(){

            var indexComment = $(this).parents('.date-dz-right').parents('.date-dz').parents('.all-pl-con');
            var floorId = indexComment.attr("floor-id");
            console.log(indexCommentId);
            $.ajax({
              url: urlGlobal+'/deleteFloorComment',
              type: 'post',
              dataType:'json',
              data: { "_token":"{{csrf_token()}}","floor_id":floorId},
              success: function (data) {  
                  // $("#avatar").attr({'src':returndata.data});
                  if (data.status == -1) {
                    alert("删除失败");
                  }
                  if(data.status == 1){
                    floorId.remove();
                  }
                  
              },  
              error: function (data) {  
                  
              }  
            });
            floorId.remove();
            $(this).siblings('.flex-text-wrap').find('.comment-input').prop('value','').siblings('pre').find('span').text('');

        })

        
        //展开更多回复
        $('.comment-show').on('click','.toMore',function(){
            
            var oThis = $(this);
            var floorId = $(this).parents('.comment-show-con-list').parents('.comment-show-con').attr("data-id");
            $.ajax({
              url: urlGlobal+'/commentDetail',
              type: 'post',
              dataType:'json',
              data: {"_token":"{{csrf_token()}}","floor_id":floorId},
              success: function (data) {  
                  // $("#avatar").attr({'src':returndata.data});
                  if(data.status == 1){
                    console.log(data)
                    oThis.siblings('.hf-list-con').css('display','block').empty();
                    $.each(data.data, function(i, item) {
                        if (item.parent_user_id == 0) {
                            var oHtml = '<div class="all-pl-con " hf-id = "'+item.id+'"  floor-id = "'+item.floor_id+'"><div class="pl-text hfpl-text clearfix"><a href="#" class="comment-size-name" user-id = "'+item.user_id+'">'+item.user_name+'：</a><span class="my-pl-con">'+item.content+'</span></div><div class="date-dz"> <span class="date-dz-left pull-left comment-time">'+item.created_at+'</span> <div class="date-dz-right pull-right comment-pl-block"> <a href="javascript:;" class="removeBlock">删除</a> <a href="javascript:;" class="date-dz-pl hf-at hf-con-block pull-left">回复</a></div> </div></div>';
                        }else{
                            var oHtml = '<div class="all-pl-con " hf-id = "'+item.id+'"  floor-id = "'+item.floor_id+'"><div class="pl-text hfpl-text clearfix"><a href="#" class="comment-size-name" user-id = "'+item.user_id+'">'+item.user_name+'：</a><span class= "parentBox">回复@：<span class="parentIdStyle" parent-user-id="'+item.parent_user_id+'">'+item.parent_user_name+'：</span> </span> <span class="my-pl-con">'+item.content+'</span></div><div class="date-dz"> <span class="date-dz-left pull-left comment-time">'+item.created_at+'</span> <div class="date-dz-right pull-right comment-pl-block"> <a href="javascript:;" class="removeBlock">删除</a> <a href="javascript:;" class="date-dz-pl hf-at hf-con-block pull-left">回复</a></div> </div></div>';
                        }
                        
                        
                        oThis.siblings('.hf-list-con').css('display','block').append(oHtml);
                       
                    });
                    oThis.hide();
                    oThis.siblings(".shouqi").show();
                  }
                  
              },  
              error: function (data) {  
                  
              }  
            });
        })
        //收起回复
        $('.comment-show').on('click','.shouqi',function(){
            $(this).siblings(".toMore").show();
            $(this).siblings(".hf-list-con").empty();
            $(this).hide();

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
                
 // function loadComment(){

 //                var floorId = $(this).parents('.date-dz-right').parents('.date-dz').parents('.comment-show-con-list').parents('.comment-show-con').attr("data-id");
 //                $.ajax({
 //                  url: urlGlobal+'/commentDetail',
 //                  type: 'post',
 //                  dataType:'json',
 //                  data: {"_token":"{{csrf_token()}}","floor_id":floorId},
 //                  success: function (data) {  
 //                      // $("#avatar").attr({'src':returndata.data});
 //                      if(data.status == 1){
 //                        console.log(data);
 //                        console.log(data.data);
 //                        $.each(data.data, function(i, item) {
 //                            var oHtml = '<div class="all-pl-con " hf-id = "'+item.id+'"  floor-id = "'+item.floor_id+'"><div class="pl-text hfpl-text clearfix"><a href="#" class="comment-size-name" user-id = "'+item.user_id+'">'+item.user_name+'：</a><span class= "parentBox">回复@：<span class="parentIdStyle" parent-user-id="'+item.parent_user_id+'">'+item.parent_user_name+'：</span> </span> <span class="my-pl-con">'+item.content+'</span></div><div class="date-dz"> <span class="date-dz-left pull-left comment-time">'+item.created_at+'</span> <div class="date-dz-right pull-right comment-pl-block"> <a href="javascript:;" class="removeBlock">删除</a> <a href="javascript:;" class="date-dz-pl hf-at hf-con-block pull-left">回复</a></div> </div></div>';
 //                            if (item.parent_user_id == 0) {
 //                                $(".parentBox").css({
 //                                    "display":"none"
 //                                })
 //                            }
 //                            oThis.parents('.date-dz-right').parents('.date-dz').siblings('.hf-list-con').css('display','block').append(oHtml) && oThis.parents('.hf-con').siblings('.date-dz-right').find('.hf-at').addClass('hf-con-block') &&  oThis.parents('.hf-con').siblings('.date-dz-right').find('.pl-hf').addClass('hf-con-block')
                           
 //                        });
 //                      }
                      
 //                  },  
 //                  error: function (data) {  
                      
 //                  }  
 //                });
 //            }

    </script>
@stop

