<?php
/**
 * Created by PhpStorm.
 * User: cheney
 * Date: 2017/7/22
 * Time: 17:44
 */


if(!function_exists('ajaxReturn'))
{
    function ajaxReturn($status,$message,$data=null)
    {
        return ['status'=>$status,'message'=>$message,'data'=>$data];
    }
}

