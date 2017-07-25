<div class="mblog-userinfo g-container-left">
    <div class="g-title">我的信息</div>
    <!-- src="img/pageHome/usericon02.png" -->
    <div id="div1"><img class="mblog-icon"  src="http://localhost/blog/public/{{$userInfo->portrait($userInfo->head_portrait)}}" id="avatar" /></div>
    <div class="mblog-update">
        <!-- <a class="g-btn">更换头像<input title=" " name="user.photo" id="photo" type="file" ></a>
        <a class="g-btn" id="infomation">修改信息</a> -->
        <form id="person-photo" enctype="multipart/form-data">
            {{ csrf_field() }}
            <a class="g-btn">更换头像
                <input title=" " name="portrait" id="photo" type="file">
            </a>
            <a class="g-btn" id="infomation">修改信息</a>
            <!-- <p style="padding-top: 20px;"><input type="button" name="" onclick="doUpload()" value="提交"></p> -->
        </form>
    </div>

    <table class="mblog-userinfoul" id="self-info" >
        <tr class="">
            <td>昵称 :</td><td id="name">{{$userInfo->name}}</td>
        </tr>
        <tr class="">
            <!-- <input id="man" type="radio" checked="checked" name="1" />男<input id="woman" type="radio"  name="1"/>女 -->
            <td>性别 :</td><td id="sex">{{$userInfo->sex($userInfo->sex)}}</td>
        </tr>
        <tr class="">
            <td>爱好 :</td><td id="intrest">{{$userInfo->hobby}}</td>
        </tr>
        <tr class="">
            <td>人生格言 :</td><td id="maxim">{{$userInfo->signature}}</td>
        </tr>
        <tr class="">
            <td>自我评价 :</td>
            <td id="self-evaluate">
               {{$userInfo->details}}
            </td>
        </tr>
    </table>
    <div  id="change">
        <!-- <form method="post" action="{{url('update')}}"> -->
           
            <table class="mblog-userinfoul">
            <!-- {{ csrf_field() }} -->
                <tr class="">
                    <td>昵称 :</td><td ><input id="name2" type="text" name=""></td>
                </tr>
                <tr class="">
                    <!-- <input id="man" type="radio" checked="checked" name="1" />男<input id="woman" type="radio"  name="1"/>女 -->
                    <td>性别 :</td>
                    <td><input id="man" type="radio" checked="checked" name="1" value="1" />男<input id="woman" type="radio"  name="1" value="0"/>女</td>
                </tr>
                <tr class="">
                    <td>爱好 :</td><td><input type="text" name="" id="intrest2"></td>
                </tr>
                <tr class="">
                    <td>人生格言 :</td><td><input type="text" name="" id="maxim2"></td>
                </tr>
                <tr class="">
                    <td>自我评价 :</td>
                    <td id="self-evaluate2-box">
                        <!-- 人，人生，在本质上是孤独的，无奈的。所以与人交往，以
                        求相互理解。然而相互理解果真是可能的嘛？不，不可能的，
                        宿命式的不可能，寻求理解的努力是徒劳的。那么何苦非努力
                        不可呢？为什么就不能转变一下态度呢--既然怎么努力都枉费
                        心机，那么不再努力就是，这样也可以获得蛮好嘛！换言之，
                        与其勉强通过与人交往来消灭孤独，化解无奈，莫如退回来
                        把玩孤独，把玩无奈。 -->
                        <textarea class="p-input" id="self-evaluate2"></textarea>
                    </td>
                </tr>
            </table>
        <!-- </form> -->
        <div class="mblog-update">
            <a class="g-btn"><input id="upload-info" name="" type="submit">确定</a>
            <a class="g-btn" id="cansle">取消</a>
        </div>
    </div>

</div>