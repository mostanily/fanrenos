<div class="form-group">
    <label class="col-md-3 control-label">邮箱</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="email" value="{{ $email }}" autofocus required="">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">昵称</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="nickname" value="{{ $nickname }}" autofocus>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">网站地址</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="website" value="{{{ $website or 'http://'}}}" autofocus>
        <span class="help-block m-b-none">链接请添加http或者https前缀</span>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">个人简介</label>
    <div class="col-md-5">
        <textarea class="form-control" name="description" placeholder="简单的介绍下自己">{{$description}}</textarea>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">密码</label>
    <div class="col-md-5">
        <input type="password" class="form-control" name="password" value="" autofocus>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">密码确认</label>
    <div class="col-md-5">
        <input type="password" class="form-control" name="password_confirmation" value="" autofocus>
    </div>
</div>