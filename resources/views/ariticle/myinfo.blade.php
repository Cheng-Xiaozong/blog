<div class="mblog-userinfo g-container-left">
    <div class="g-title">我的信息</div>
    <div id="div1"><img class="mblog-icon  head-img" imgurl="{{$userInfo->portrait($userInfo->head_portrait)}}" src="" id="avatar" /></div>
    <div class="mblog-update">
        <form id="person-photo" enctype="multipart/form-data">
            {{ csrf_field() }}
            <a class="g-btn">更换头像
                <input title=" " name="portrait" id="photo" type="file">
            </a>
            <a class="g-btn" id="infomation">修改信息</a>
        </form>
    </div>

    <table class="mblog-userinfoul" id="self-info" >
        <tr class="">
            <td>昵称 :</td><td id="name">{{$userInfo->name}}</td>
        </tr>
        <tr class="">
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
           
        <table class="mblog-userinfoul">
            <tr class="">
                <td>昵称 :</td><td ><input id="name2" type="text" name=""></td>
            </tr>
            <tr class="">
                <td>性别 :</td>
                <td><input id="man" type="radio"  name="1" value="1" />男<input id="woman" type="radio"  name="1" value="0"/>女</td>
            </tr>
            <tr class="">
                <td>爱好 :</td><td><textarea class="p-input" id="intrest2"></textarea></td>
            </tr>
            <tr class="">
                <td>人生格言 :</td><td><textarea class="p-input" id="maxim2"></textarea></td>
            </tr>
            <tr class="">
                <td>自我评价 :</td>
                <td id="self-evaluate2-box">
                    <textarea class="p-input" id="self-evaluate2"></textarea>
                </td>
            </tr>
        </table>
        <div class="mblog-update">
            <a class="g-btn"><input id="upload-info" name="" type="submit">确定</a>
            <a class="g-btn" id="cansle">取消</a>
        </div>
    </div>

</div>