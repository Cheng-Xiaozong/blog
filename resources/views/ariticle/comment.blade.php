<div class="commentAll">
    <!--评论区域 begin-->
    <div class="reviewArea clearfix">
        <textarea class="content comment-input" placeholder="请输入评论....&hellip;" onkeyup="keyUP(this)"></textarea>
        <a href="javascript:;" class="plBtn">评论</a>
    </div>
    <!--评论区域 end-->
    <!--回复区域 begin-->
    @if(count($comments))
    @foreach($comments as $comment)
        <div class="comment-show" data-id="{{$comment->id}}">
            <div class="comment-show-con clearfix">
                <div class="comment-show-con-img pull-left"><img src="{{$comment->user_portrait}}" alt=""></div>
                <div class="comment-show-con-list pull-left clearfix">
                    <div class="pl-text clearfix">
                        <a href="#" class="comment-size-name" data-userId="{{$comment->user_id}}">{{$comment->user_name}} : </a>
                        <span class="my-pl-con">&nbsp;{{$comment->content}}</span>
                    </div>
                    <div class="date-dz">
                        <span class="date-dz-left pull-left comment-time">{{$comment->created_at}}</span>
                        <div class="date-dz-right pull-right comment-pl-block">
                            @if(!Auth::guest() && $comment->user_id == Auth::user()->id)
                                <a href="javascript:;" class="removeBlock">删除</a>
                            @endif
                            <a href="javascript:;" class="date-dz-pl pl-hf hf-con-block pull-left">回复({{$comment->num}})</a>
                            <span class="pull-left date-dz-line">|</span>
                            <a href="javascript:;" class="date-dz-z pull-left"><i class="date-dz-z-click-red"></i>赞 (<i class="z-num">{{$comment->praises}}</i>)</a>
                        </div>
                    </div>
                    <div class="hf-list-con"></div>
                </div>
            </div>
        </div>
    @endforeach
    @else
        <div class="blogcontent-loadmore g-btn">暂无评论！</div>
    @endif
</div>
@if($newAriticle->comment_mum>2)
    <div class="blogcontent-loadmore g-btn">加载更多精彩评论...</div>
@endif