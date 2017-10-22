<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="col-md-2 control-label">所属分类</label>
            <div class="col-md-10">
                <select class="form-control m-bot15" name="parent_id" required>
                    <option value="0">默认选择</option>
                    @foreach($allCategory as $cate)
                        <option value="{{$cate['id']}}" @if($cate['id']==$parent_id) selected="selected" @endif >{{$cate['name']}}</option>
                    @endforeach
                </select>
             </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-md-2 control-label">
                分类名称
            </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="name" autofocus id="name" value="{{ $name }}">
            </div>
        </div>
        <div class="form-group">
            <label for="path" class="col-md-2 control-label">
                分类路由
            </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="path" autofocus id="path" value="{{ $path }}">
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="col-md-2 control-label">
                主要描述
            </label>
            <div class="col-md-10">
                <textarea class="form-control" name="description" id="description" rows="6">{{ $description }}</textarea>
            </div>
        </div>
    </div>
</div>