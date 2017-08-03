$('.modalDialog-close').unbind('click').bind('click', removeSelf);
$('.pointer').unbind('click').bind('click', function(){
    $('.modalDialog-bg').remove();
});
function removeSelf(){
    $('.modalDialog-bg').remove();
}
