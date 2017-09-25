<div class="form-group">
    <label class="col-md-3 control-label">网站名称</label>
    <div class="col-md-7">
        <input type="text" class="form-control" name="name" value="{{ $name }}" autofocus required="">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">网站logo图片URL</label>
    <div class="col-md-7">
        <input type="text" class="form-control" name="link_name" value="{{ $link_name }}" placeholder="图片在线地址，需包括http/https前缀" style="width: 80%;float: left;" autofocus >
        <button type="button" class="btn btn-primary need_local_image" style="float: right;">或本地上传</button>
    </div>
</div>
<div class="form-group hidden_upload_button upload_local_image">
    <label for="page_image" class="col-md-3 control-label">
        网站logo
    </label>
    <div class="col-md-7">
        <div class="row">
            <div class="col-md-6">
                <input type="file" value="" name="image" title="支持jpg、jpeg、gif、png等常用图片格式，单文件小于5M">
            </div>
            <div class="visible-sm space-10"></div>
            <div class="col-md-4 text-right">
                    <img src="{{ page_image($image) }}" class="img img_responsive" id="page-image-preview" onclick="preview_image('{{ page_image($image) }}')" style="max-height:40px">
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">友链状态</label>
    <div class="col-md-7 icheck">
        <div class="col-md-3">
            <div class="radio">
                <input tabindex="3" id="tag-status-2" type="radio" class="flat-green" value="1" name="status" @if($status==1) checked="checked" @endif>
                <label for="tag-status-2">开启</label>
            </div>
        </div>
        <div class="col-md-3">
            <div class="radio">
                <input tabindex="3" id="tag-status-3" type="radio" class="flat-red" value="0" name="status" @if($status==0) checked="checked" @endif>
                <label for="tag-status-3">关闭</label>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">网站链接</label>
    <div class="col-md-7">
        <input type="text" class="form-control" name="link" value="{{ $link }}" autofocus>
    </div>
</div>