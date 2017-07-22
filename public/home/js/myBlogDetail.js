var showOrHide=true;
// $("#reply-click").click( function (){
//     $('.reply-content').show();
// })
$(".reply-word").click( function () { 
    if(showOrHide){
        $(this).parent(".reply-click").next().show();
        showOrHide=false;
    }else{
        $(this).parent(".reply-click").next().hide();
        showOrHide=true;
    }
});
