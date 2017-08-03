
//个人博客地址
var herfBlog = urlGlobal+"/brotherBlog/";

//获取自己的头像地址
var headPortrait = $(".userLoginJudge").attr("data-head_portrait");

//修改首次进入页面加载的前几个评论用户的头像
$('.comment-head-img').each(function(i){
   $(this).attr('src',urlGlobal+'/'+$(this).attr('data-face'));
});

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

//添加评论
$('.commentAll').on('click','.plBtn',function(){
    userJudge();
    var oThis = $(this);
    var oSize = $(this).siblings('.flex-text-wrap').find('.comment-input').val();
    var ariticle_id = $(".blogcontent-title").attr("data-id");
    var newComment = $(this).parents('.reviewArea').siblings('.comment-show');

    if(!oSize){
        alert("评论不能为空！");
        return
    }
    $.ajax({
      url: urlGlobal+'/createComment',
      type: 'post',
      dataType:'json',
      data: { "_token":token,"Comment[project_id]":ariticle_id,"Comment[content]":oSize},
      success: function (data) {  
          console.log(data);
          if (data.status == -1) {
            alert("评论失败");
          }
          if(data.status == 1){  
            var commentId = data["data"].id;
            var commentFloorId = data["data"].floor_id;
            var commentUserId = data["data"].user_id;
            var commentTime = data["data"].created_at;
            var commentContent = data["data"].content;

            var userName = $("#userOfName").html();
            oHtml = '<div class="comment-show-con clearfix" data-id = "'+commentId+'"><div class="comment-show-con-img pull-left"><img class="comment-head-img" src="'+urlGlobal+'/'+headPortrait+'" alt=""></div> <div class="comment-show-con-list pull-left clearfix"><div class="pl-text clearfix"> <a href="'+herfBlog+commentUserId+'" class="comment-size-name" user-id = "'+commentUserId+'">'+userName+'：</a> <span class="my-pl-con">'+ commentContent +'</span> </div> <div class="date-dz"> <span class="date-dz-left pull-left comment-time">'+commentTime+'</span> <div class="date-dz-right pull-right comment-pl-block"><a href="javascript:;" class="removeBlock removeBlockFirstFloor">删除</a> <a href="javascript:;" class="date-dz-pl pl-hf hf-con-block pull-left">回复(<i class="hfNum">0</i>)</a><span class="pull-left date-dz-line">|</span><a href="javascript:;" class="date-dz-z pull-left">赞 (<i class="z-num">0</i>)</a></div> </div><div class="hf-list-con"></div></div> </div>';

            newComment.prepend(oHtml);
            $(".no-comment").hide();
            oThis.siblings('.flex-text-wrap').find('.comment-input').prop('value','').siblings('pre').find('span').text('');

          }
      },  
      error: function (data) {  
          
      }  
    });
});




        //点击第一楼层回复显示输入框和回复评论
        $('.comment-show').on('click','.pl-hf',function(){
            // userJudge();
            var oThis = $(this);
            //获取回复人的名字
            var fhName = $(this).parents('.date-dz-right').parents('.date-dz').siblings('.pl-text').find('.comment-size-name').html();
            //回复@
            var fhN = '回复@'+fhName;
            //var oInput = $(this).parents('.date-dz-right').parents('.date-dz').siblings('.hf-con');
            var fhHtml = '<div class="hf-con pull-left"> <textarea class="content comment-input hf-input" placeholder="" onkeyup="keyUP(this)"></textarea> <a href="javascript:;" class="hf-pl">评论</a></div>';

           


            //获取楼层id
            var floorId = $(this).parents('.date-dz-right').parents('.date-dz').parents('.comment-show-con-list').parents('.comment-show-con').attr("data-id");


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
                var hfLength = oThis.parents('.date-dz-right').parents('.date-dz').siblings('.hf-list-con').children(".all-pl-con");
                var hfNum = oThis.children(".hfNum").html();
                if (hfLength.length < hfNum) {
                    toComment();
                }else{
                    oThis.parents('.date-dz-right').parents('.date-dz').siblings('.hf-list-con').children(".all-pl-con").show();
                }
                
                
            }else {
                $(this).addClass('hf-con-block');
                $(this).parents('.date-dz-right').siblings('.hf-con').remove();
                oThis.parents('.date-dz-right').parents('.date-dz').siblings('.hf-list-con').children(".all-pl-con").hide();
                
            }

            function toComment(){
                $.ajax({
                  url: urlGlobal+'/commentDetail',
                  type: 'post',
                  dataType:'json',
                  data: {"_token":token,"floor_id":floorId},
                  success: function (data) {  
                      // $("#avatar").attr({'src':returndata.data});
                      console.log(data);
                       if(data.status == 1){
                            $.each(data.data, function(i, item) {
                                //判断是否是自己的评论ID，然后显示回复的删除按钮
                                var userId = $(".userLoginJudge").attr("data-userid");
                                // var toUserId = $(this).parents('.date-dz-right').parents('.date-dz').siblings('.pl-text').children('.comment-size-name').attr("user-id");

                                
                                if (item.parent_user_id == 0 && (userId == item.user_id)) {
                                    var oHtml = '<div class="all-pl-con " hf-id = "'+item.id+'"  floor-id = "'+item.floor_id+'">'
                                                        +'<div class="twoFloorCommentImg comment-show-con-img pull-left">'
                                                                +'<img class="twoFloorCommentHeadImg" src="'+urlGlobal+'/'+item.user_portrait+'" />'
                                                        +'</div>'
                                                        +'<div class="twoFloorCommentContent pull-left">'

                                                                +'<div class="pl-text hfpl-text clearfix">'
                                                                        +'<a href="'+herfBlog+item.user_id+'" class="comment-size-name" user-id = "'+item.user_id+'">'+item.user_name+'：</a>'
                                                                        +'<span class="my-pl-con">'+item.content+'</span>'
                                                                +'</div>'
                                                                +'<div class="date-dz"> '
                                                                        +'<span class="date-dz-left pull-left comment-time">'+item.created_at+'</span> '
                                                                        +'<div class="date-dz-right pull-right comment-pl-block"> '
                                                                                +'<a href="javascript:;" class="removeBlock removeBlockTwoFloor">删除</a> '
                                                                                +'<a href="javascript:;" class="date-dz-pl hf-at hf-con-block pull-left">回复</a>'
                                                                        +'</div> '
                                                                +'</div>'
                                                        +'</div>'
                                                +'</div>';
                                }
                                if (item.parent_user_id == 0 && (userId != item.user_id)) {
                                    var oHtml = '<div class="all-pl-con " hf-id = "'+item.id+'"  floor-id = "'+item.floor_id+'"><div class="twoFloorCommentImg comment-show-con-img pull-left"><img class="twoFloorCommentHeadImg" src="'+urlGlobal+'/'+item.user_portrait+'" /></div><div class="twoFloorCommentContent pull-left"><div class="pl-text hfpl-text clearfix"><a href="'+herfBlog+item.user_id+'" class="comment-size-name" user-id = "'+item.user_id+'">'+item.user_name+'：</a><span class="my-pl-con">'+item.content+'</span></div><div class="date-dz"> <span class="date-dz-left pull-left comment-time">'+item.created_at+'</span> <div class="date-dz-right pull-right comment-pl-block">  <a href="javascript:;" class="date-dz-pl hf-at hf-con-block pull-left">回复</a></div> </div></div></div>';
                                }
                                if(item.parent_user_id != 0 && (userId == item.user_id)){
                                    var oHtml = '<div class="all-pl-con " hf-id = "'+item.id+'"  floor-id = "'+item.floor_id+'"><div class="twoFloorCommentImg comment-show-con-img pull-left"><img class="twoFloorCommentHeadImg" src="'+urlGlobal+'/'+item.user_portrait+'" /></div><div class="twoFloorCommentContent pull-left"><div class="pl-text hfpl-text clearfix"><a href="'+herfBlog+item.user_id+'" class="comment-size-name" user-id = "'+item.user_id+'">'+item.user_name+'：</a><span class= "parentBox">回复@：<a href="'+herfBlog+item.parent_user_id+'"><span class="parentIdStyle" parent-user-id="'+item.parent_user_id+'">'+item.parent_user_name+'：</span></a> </span> <span class="my-pl-con">'+item.content+'</span></div><div class="date-dz"> <span class="date-dz-left pull-left comment-time">'+item.created_at+'</span> <div class="date-dz-right pull-right comment-pl-block"> <a href="javascript:;" class="removeBlock removeBlockTwoFloor">删除</a> <a href="javascript:;" class="date-dz-pl hf-at hf-con-block pull-left">回复</a></div> </div></div></div>';
                                }
                                if(item.parent_user_id != 0 && (userId != item.user_id)){
                                    var oHtml = '<div class="all-pl-con " hf-id = "'+item.id+'"  floor-id = "'+item.floor_id+'"><div class="twoFloorCommentImg comment-show-con-img pull-left"><img class="twoFloorCommentHeadImg" src="'+urlGlobal+'/'+item.user_portrait+'" /></div><div class="twoFloorCommentContent pull-left"><div class="pl-text hfpl-text clearfix"><a href="'+herfBlog+item.user_id+'" class="comment-size-name" user-id = "'+item.user_id+'">'+item.user_name+'：</a><span class= "parentBox">回复@：<a href="'+herfBlog+item.parent_user_id+'"><span class="parentIdStyle" parent-user-id="'+item.parent_user_id+'">'+item.parent_user_name+'：</a></span> </span> <span class="my-pl-con">'+item.content+'</span></div><div class="date-dz"> <span class="date-dz-left pull-left comment-time">'+item.created_at+'</span> <div class="date-dz-right pull-right comment-pl-block"><a href="javascript:;" class="date-dz-pl hf-at hf-con-block pull-left">回复</a></div> </div></div></div>';
                                }
                                oThis.parents('.date-dz-right').parents('.date-dz').siblings('.hf-list-con').css('display','block').append(oHtml);
                            })
                        }
                  },  
                  error: function (data) {  
                      
                  }  
                });

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

            var startWord = oAllVal;

            var huifuContent = oHfVal.replace(startWord,'');

            if(!huifuContent){
                alert("回复不能为空！");
                return
            }
            $.ajax({
              url: urlGlobal+'/createFloor',
              type: 'post',
              dataType:'json',
              data: { "_token":token,"Comment[project_id]":thisAriticleId,"Comment[content]":huifuContent,"Comment[floor_id]":floorId},
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


                    //获取回复数量
                    var hfNumBox = oThis.parents('.hf-con').siblings('.date-dz-right').children(".date-dz-pl").children(".hfNum")
                    var hfNum = hfNumBox.html();
                    hfNum++;
                    hfNumBox.html(hfNum);

                    var oHtml = '<div class="all-pl-con"  hf-id="'+createFloorId+'" floor-id = "'+createFloorFloorId+'">'
                                        +'<div class="twoFloorCommentImg comment-show-con-img pull-left">'
                                                +'<img class="twoFloorCommentHeadImg" src="'+urlGlobal+'/'+headPortrait+'" />'
                                        +'</div>'
                                        +'<div class="twoFloorCommentContent pull-left">'

                                                +'<div class="pl-text hfpl-text clearfix">'
                                                        +'<a href="'+herfBlog+createFloorUserId+'" class="comment-size-name" parent-user-id="'+createFloorParentUserId+'" user-id="'+createFloorUserId+'">'+createFloorUser+': </a>'
                                                        +'<span class="my-pl-con">'+createFloorContent+'</span>'
                                                +'</div>'
                                                +'<div class="date-dz"> '
                                                        +'<span class="date-dz-left pull-left comment-time">'+createFloorTime+'</span> '
                                                        +'<div class="date-dz-right pull-right comment-pl-block"> '
                                                                +'<a href="javascript:;" class="removeBlock removeBlockTwoFloor">删除</a> '
                                                                +'<a href="javascript:;" class="date-dz-pl hf-at hf-con-block pull-left">回复</a>'
                                                        +'</div>'
                                                +' </div>'
                                        +'</div'
                                +'</div>';
                    oThis.parents('.hf-con').parents('.comment-show-con-list').find('.hf-list-con').css('display','block').append(oHtml) ;
                    oThis.siblings('.flex-text-wrap').find('.comment-input').prop('value','').siblings('pre').find('span').text('');

                  }
                  
              },  
              error: function (data) {  
                  
              }  
            });

            
        });


                //点击第二楼层回复显示输入框
        $('.comment-show').on('click','.hf-at',function(){
            userJudge();

            //判断是否回复自己
            var userId = $(".userLoginJudge").attr("data-userid");
            var toUserId = $(this).parents('.date-dz-right').parents('.date-dz').siblings('.pl-text').children('.comment-size-name').attr("user-id");
            if(userId == toUserId){
                alert("不能回复自己！");
                return;
            }

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
              data: { "_token":token,"Comment[project_id]":thisAriticleId,"Comment[content]":huifuContent,"Comment[floor_id]":floorId,"Comment[parent_user_id]":parentId},
              success: function (data) { 
                  // $("#avatar").attr({'src':returndata.data});
                  if (data.status == -1) {
                    alert("评论失败");

                  }
                  if(data.status == 1){
                    //获取回复数量
                    var hfNumBox = oThis.parents('.hf-con').parents(".date-dz").parents(".all-pl-con ").parents(".hf-list-con").siblings('.date-dz').children('.date-dz-right').children(".date-dz-pl").children(".hfNum");
                    var hfNum = hfNumBox.html();
                    hfNum++;
                    hfNumBox.html(hfNum);

                    var createFloorCommentUserId = data["data"].user_id;
                    var createFloorCommentParentId = data["data"].parent_user_id;
                    var createFloorCommentFloorId = data["data"].floor_id;
                    var createFloorCommentId = data["data"].id;
                    var createFloorCommentContent = data["data"].content;
                    var createFloorCommentTime = data["data"].created_at;
                    // var createFloorCommentUser = data["data"].user_name;
                    var createFloorCommentUser = $("#userOfName").html();
                    var toUser = oHfName;
                    var oHtml = '<div class="all-pl-con " hf-id="'+createFloorCommentId+'"  floor-id = "'+createFloorCommentFloorId+'"><div class="twoFloorCommentImg comment-show-con-img pull-left"><img class="twoFloorCommentHeadImg" src="'+urlGlobal+'/'+headPortrait+'" /></div><div class="twoFloorCommentContent pull-left"><div class="pl-text hfpl-text clearfix"><a href="'+herfBlog+createFloorCommentUserId+'" class="comment-size-name" user-id="'+createFloorCommentUserId+'" >'+createFloorCommentUser+': </a><span class="parentBox">回复@：</span><a href="'+herfBlog+createFloorCommentParentId+'"><span class="parentIdStyle" parent-user-id="'+createFloorCommentParentId+'">'+toUser+'</span></a><span class="my-pl-con">'+createFloorCommentContent+'</span></div><div class="date-dz"> <span class="date-dz-left pull-left comment-time">'+createFloorCommentTime+'</span> <div class="date-dz-right pull-right comment-pl-block"> <a href="javascript:;" class="removeBlock removeBlockTwoFloor">删除</a> <a href="javascript:;" class="date-dz-pl hf-at hf-con-block pull-left">回复</a></div> </div></div></div>';
                    oThis.parents('.hf-con').parents('.comment-show-con-list').find('.hf-list-con').css('display','block').append(oHtml) && oThis.parents('.hf-con').siblings('.date-dz-right').find('.hf-at').addClass('hf-con-block') && oThis.parents('.hf-con').remove();
                  }
                  
              },  
              error: function (data) {  
                  
              }  
            });

            
        });


        //文章点赞
        
        $('.blogcontent-bloginfo').on('click','.bloginfo-star',function(){
            var oThis = $(this);
            var projectId = $('.blogcontent-title').attr("data-id");
            $.ajax({
              url: urlGlobal+'/ariticle/praise',
              type: 'post',
              dataType:'json',
              data: { "_token":token,"ariticle_id":projectId},
              success: function (data) { 
                  console.log(data);
                  if (data.status == -1) {
                    alert("点赞失败");

                  }
                  if(data.status == 1){

                    var ariticleDzNum = oThis.children('.ariticleDz').html();
                    ariticleDzNum++;
                    oThis.children('.ariticleDz').html(ariticleDzNum);


                    oThis.css({
                        "color":"red"
                    })
                  }
                  if (data.status == 0) {
                    alert("不能重复点赞");

                  }

                  
              },  
              error: function (data) {  
                  
              }  
            });
        })

        //评论点赞
        $('.comment-show').on('click','.date-dz-z',function(){

            var oThis = $(this);
            var commentId = oThis.parents('.date-dz-right').parents('.date-dz').parents('.comment-show-con-list').parents('.comment-show-con').attr("data-id");
            $.ajax({
              url: urlGlobal+'/commentPraise',
              type: 'post',
              dataType:'json',
              data: { "_token":token,"comment_id":commentId,},
              success: function (data) { 
                  console.log(data);
                  if (data.status == -1) {
                    alert("点赞失败");

                  }
                  if(data.status == 1){

                    var dzNum = oThis.children(".z-num").html();
                    console.log(dzNum);
                    dzNum++;
                    console.log(dzNum);
                    oThis.children(".z-num").html(dzNum);
                    oThis.css({
                        "color":"red"
                    })
                  }
                  if (data.status == 0) {
                    alert("不能重复点赞");

                  }

                  
              },  
              error: function (data) {  
                  
              }  
            });

        })

        //删除主楼评论
        $('.commentAll').on('click','.removeBlockFirstFloor',function(){

            var indexComment = $(this).parents('.date-dz-right').parents('.date-dz').parents('.comment-show-con-list').parents('.comment-show-con');
            var indexCommentId = indexComment.attr("data-id");
            console.log(indexCommentId);
            $.ajax({
              url: urlGlobal+'/deleteComment',
              type: 'post',
              dataType:'json',
              data: { "_token":token,"id":indexCommentId},
              success: function (data) {  
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
        $('.commentAll').on('click','.removeBlockTwoFloor',function(){

            var indexComment = $(this).parents('.date-dz-right').parents('.date-dz').parents('.all-pl-con');
            var floorId = indexComment.attr("hf-id");
            $.ajax({
              url: urlGlobal+'/deleteFloorComment',
              type: 'post',
              dataType:'json',
              data: { "_token":token,"floor_id":floorId},
              success: function (data) {  
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
        })

        //加载更多评论
        $('.home-content-blogcontentmain').on('click','.blogcontent-loadmore',function(){

            var oThis = $(this);
            var lastId = oThis.siblings(".commentAll").children('.comment-show').children(".comment-show-con:last").attr("data-id");
            console.log(lastId);
            var projectId = $(".blogcontent-title").attr("data-id");
            $.ajax({
              url: urlGlobal+'/commentsMore',
              type: 'post',
              dataType:'json',
              data: { "_token":token,"project_id":projectId,"last_id":lastId},
              success: function (data) {  
                    console.log(data);
                  if (data.status == -1) {
                    oThis.html("我是有底线的！");
                  }
                  if(data.status == 1){

                    $.each(data.data, function(i, item) {
                        oHtml = '<div class="comment-show-con clearfix"  data-id = "'+item.id+'"><div class="comment-show-con-img pull-left"><img class="comment-head-img" src="'+urlGlobal+'/'+item.user_portrait+'" alt=""></div> <div class="comment-show-con-list pull-left clearfix"><div class="pl-text clearfix"> <a href="'+herfBlog+item.user_id+'" class="comment-size-name" user-id = "'+item.user_id+'">'+item.user_name+' : </a> <span class="my-pl-con">&nbsp;'+ item.content +'</span> </div> <div class="date-dz"> <span class="date-dz-left pull-left comment-time">'+item.created_at+'</span> <div class="date-dz-right pull-right comment-pl-block"><a href="javascript:;" class="removeBlock removeBlockFirstFloor">删除</a> <a href="javascript:;" class="date-dz-pl pl-hf hf-con-block pull-left">回复(<i class="hfNum">'+item.num+'</i>)</a><span class="pull-left date-dz-line">|</span><a href="javascript:;" class="date-dz-z pull-left">赞 (<i class="z-num">'+item.praises+'</i>)</a></div> </div><div class="hf-list-con"></div></div> </div>';

                        oThis.siblings(".commentAll").children('.comment-show').append(oHtml);
                    })
                    if (data.data.length < 5 ) {
                        oThis.html("我是有底线的！");
                    }
                    
                  }
                  
              },  
              error: function (data) {  
                  
              }  
            });
        

        })