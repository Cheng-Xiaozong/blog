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
    <script src="{{asset('home/js/global.js')}}"></script>
    <script src="{{asset('home/js/myBlog.js')}}"></script>
    <script src="{{asset('home/js/home.js')}}"></script>
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

        $(".star").bind("click",function(){
            var zNum = $(this).find(".z-num").html();
            console.log(zNum);
            if($(this).is('.date-dz-z-click')){
                zNum--;
                $(this).removeClass('date-dz-z-click red');
                $(this).find('.z-num').html(zNum);
                $(this).find('.date-dz-z-click-red').removeClass('red');
            }else {
                zNum++;
                $(this).addClass('date-dz-z-click');
                $(this).find('.z-num').html(zNum);
                $(this).find('.date-dz-z-click-red').addClass('red');
            }
            // {"ariticle_id":3}
            
            $.ajax({
                url: urlGlobal+'/ariticle/praise',  
                type: "post",
                data:{"_token":"{{csrf_token()}}",ariticle_id:4} 
               
                // success: function(html){ 
                //     console.log(html)
                
                // },
                // error:function(err){
                     
                // }
            })
        })
    </script>
@stop

