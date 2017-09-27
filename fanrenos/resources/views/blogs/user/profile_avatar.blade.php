@extends('layouts.base')
@section('css')
<link type="text/css" rel="stylesheet" href="{{asset('dist/amazeui.cropper.css')}}">
<style type="text/css">
#image {width: 100%;min-height: 50px;max-height: 516px;}
.img-container {margin-bottom: 10px;max-width: 100%;max-height: 100%;}
.am-img-preview {float: left;margin-right: 10px;margin-bottom: 10px;overflow: hidden;}
.preview-lg {width: 140px;height: 140px;}
.preview-md {width: 90px;height: 90px;}
.preview-sm {width: 50px;height: 50px;}
.am-modal-bd > canvas {max-width: 100%;}
</style>
@stop
@section('content')
<div class="container profile">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            {{-- <avatar src="{{ avatar_image($user->avatar,200) }}"></avatar> --}}
            <div class="am-form-group">
                <img class="avatar" src="{{ asset(avatar_image($user->avatar,200)) }}" width="140"> 
                {{-- <a style="margin-top: 10px;font-size: 14px;" class="am-btn am-btn-success am-round col-md-10" href="#" target="_blank">修改头像</a> --}}
            </div>
        </div>
        <div class="col-md-8" id="crop-avatar">
            <div class="am-g">
                <div class="am-u-md-9">
                    <div class="img-container avatar-view">
                        <img id="image" alt="选择要上传的文件">
                    </div>
                </div>
                <div class="am-u-md-3">
                    <div class="am-img-preview preview-lg am-circle"></div>
                    <div class="am-img-preview preview-md am-circle"></div>
                    <div class="am-img-preview preview-sm am-circle"></div>
                </div>
            </div>
            <div class="am-g docs-buttons">
                <fieldset>
                    <legend>头像剪裁（请使用Google或火狐浏览器，其他浏览器可能不支持！）<br>上传过程中可能会因为服务器问题而失败，请刷新页面多试几次。</legend>
                    <div class="am-form-group am-form-file">
                        <button type="button" class="am-btn am-btn-primary am-btn-sm inputButton">
                            <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                        </button>
                        <input type="file" id="inputImage" name="file">
                    </div>
                    <div class="am-form-group avatar-edit">
                        <div id="file-list"></div>
                        <button type="button"
                            class="am-btn am-btn-primary am-btn-sm"
                            data-method="zoom"
                            data-option="0.1">
                            <i class="am-icon-search-plus"></i> 放大
                        </button>
                        <button type="button" class="am-btn am-btn-primary am-btn-sm"
                            data-method="zoom"
                            data-option="-0.1">
                            <i class="am-icon-search-minus"></i> 缩小
                        </button>
                        <button type="button" class="am-btn am-btn-primary am-btn-sm"
                            data-method="rotate"
                            data-option="-30">
                            <i class="am-icon-rotate-left"></i> 左旋转
                        </button>
                        <button type="button" class="am-btn am-btn-primary am-btn-sm"
                            data-method="rotate"
                            data-option="30">
                            <i class="am-icon-rotate-right"></i> 右旋转
                        </button>
                        <button type="button" class="am-btn am-btn-primary am-btn-sm js-modal-open"
                            data-method="getCroppedCanvas">
                            <i class="am-icon-camera"></i> 截取图像
                        </button>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
<div class="am-modal am-modal-loading am-modal-no-btn" tabindex="-1" id="my-modal-loading">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">请稍等......</div>
        <div class="am-modal-bd">
            <span class="am-icon-spinner am-icon-spin"></span>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('/plugins/layer/layer.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/dist/cropper.min.js') }}"></script>
<script type="text/javascript">
$('.inputButton').click(function(){
    $('#inputImage').click();
});

$(function(){
    'use strict';

    // 初始化
    var $image = $('#image');
    $image.cropper({
        aspectRatio: '1',
        preview: '.am-img-preview',
        zoomOnWheel: false,
    });

    // 事件代理绑定事件
    $('.docs-buttons').on('click', '[data-method]', function() {
        var $this = $(this);
        var data = $this.data();
        var u = "{{url('user/profile/avatar')}}";
        var result = $image.cropper(data.method, data.option, data.secondOption);
        if(result.length==1){
            myalert('没有选择任何图片！');
            return false;
        }
        switch (data.method) {

            case 'getCroppedCanvas':
            if (result) {
                $('#my-modal-loading').modal('open');
                $image.cropper('getCroppedCanvas');

                $image.cropper('getCroppedCanvas', {
                  width: 160,
                  height: 160,
                  fillColor: '#fff',
                  imageSmoothingEnabled: false,
                  imageSmoothingQuality: 'high',
                });

                $image.cropper('getCroppedCanvas').toBlob(function (blob) {
                    var formData = new FormData();

                    formData.append('croppedImage', blob);

                    $.ajax(u, {
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (msg) {
                           if(msg.status=='success'){
                                $('#my-modal-loading').modal('close');
                                layer.msg('头像上传成功！页面即将刷新，请稍等！');
                                setTimeout(function(){
                                    toJump("{{url('/user/profile')}}");
                                },1000);
                           }else{
                                $('#my-modal-loading').modal('close');
                                myalert(msg.info);
                           }
                        },
                        error: function () {
                            $('#my-modal-loading').modal('close');
                            myalert('出错了，请稍后再试，或者联系站长！');
                        }
                    });
                });
            }
            break;
        }
        
        
    })

    // 上传图片
    var $inputImage = $('#inputImage');
    var URL = window.URL;
    var blobURL;

    if (URL) {
        $inputImage.change(function () {
            var files = this.files;
            var file;

            if (files && files.length) {
               file = files[0];

               if (/^image\/\w+$/.test(file.type)) {
                    blobURL = URL.createObjectURL(file);
                    $image.one('built.cropper', function () {

                        // Revoke when load complete
                       URL.revokeObjectURL(blobURL);
                    }).cropper('reset').cropper('replace', blobURL);
                    $inputImage.val('');
                } else {
                    window.alert('Please choose an image file.');
                }
            }

            // Amazi UI 上传文件显示代码
            var fileNames = '';
            $.each(this.files, function() {
                fileNames += '<span class="am-badge">' + this.name + '</span> ';
            });
            $('#file-list').html(fileNames);
        });
    } else {
        $inputImage.prop('disabled', true).parent().addClass('disabled');
    }
});
</script>
@stop