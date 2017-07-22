/**
 * Created by xin.yang on 2017/4/19.
 * index.js
 * Login and register.
 */
;(function(){
    // loginBtn clicked
    $('#home-username').text(sessionStorage.getItem("username"));
    
    let homeBannerWidth = $('.home-banner').width();
    $('.home-bannner-content img').width(homeBannerWidth);
    $('.home-bannner-content').width(homeBannerWidth * 3);
    $('.home-bannner-content').css('left', -homeBannerWidth);

    setInterval(function(){
    	$('.home-bannner-content img').eq(0).appendTo('.home-bannner-content');
    	$('.home-bannner-content').css('left', 0);
    	$('.home-bannner-content').stop().animate({'left': -homeBannerWidth + 'px'}, 500);
    }, 3000)
})()



var showOrHide=true;
// $("#reply-click").click( function (){
//     $('.reply-content').show();
// })
$(".reply").click( function () { 
    if(showOrHide){
        $('.reply-content').show();
        showOrHide=false;
    }else{
        $('.reply-content').hide();
        showOrHide=true;
    }
});


