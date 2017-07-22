@extends('layouts.app')
@section('style')
@stop
@section('banner')
@stop
@section('content')
    {{--错误处理--}}
    @if (count($errors))
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="pblog-content g-container">
        <div class="pblog-content-main g-container-main">
            <form action="" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="blog-titlediv">
                    <input placeholder="请选择文件" type="file" name="portrait" value="{{old('portrait')}}"/>
                </div>

                <div class="blog-btndiv">
                    <div class="g-btn"> <input type="submit" value="提交" class="g-btn" id="tijiao"></div>
                </div>
            </form>
        </div>
    </div>
@stop

