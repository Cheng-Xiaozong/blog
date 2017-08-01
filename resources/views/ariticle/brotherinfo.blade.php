<div class="mblog-userinfo g-container-left">
    <div class="g-title">兄弟的信息</div>
    <div id="div1"><img class="mblog-icon"  src="http://localhost/blog/public/{{$userInfo->portrait($userInfo->head_portrait)}}" id="avatar" /></div>
    <div class="mblog-update">
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

</div>