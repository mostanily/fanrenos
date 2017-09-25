<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label class="col-md-2 control-label">分类</label>
            <div class="col-md-10">
                <select class="form-control m-bot15" name="category_id" required>
                    <option value="">请选择分类</option>
                    @foreach($allCategory as $cate)
                        <option value="{{$cate->id}}" @if($cate->id==$category_id) selected="selected" @endif >{{$cate->name}}</option>
                    @endforeach
                </select>
             </div>
        </div>
        <div class="form-group">
            <label for="title" class="col-md-2 control-label">
                标题
            </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="title" autofocus id="title" value="{{ $title }}">
            </div>
        </div>
        <div class="form-group">
            <label for="subtitle" class="col-md-2 control-label">
                副标题
            </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="subtitle" id="subtitle" value="{{ $subtitle }}">
            </div>
        </div>
        <div class="form-group">
            <label for="page_image" class="col-md-2 control-label">
                页面图像
            </label>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-6">
                        <input type="file" value="" name="page_image" title="支持jpg、jpeg、gif、png等常用图片格式，单文件小于5M">
                    </div>
                    <div class="visible-sm space-10"></div>
                    <div class="col-md-4 text-right">
                         <img src="{{ page_image($page_image) }}" class="img img_responsive" id="page-image-preview" onclick="preview_image('{{ page_image($page_image) }}')" style="max-height:40px">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="content" class="col-md-2 control-label">
                内容
            </label>
            <div class="col-md-10">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Markdown文本编辑器</h5>
                    </div>
                    <div class="ibox-content">
                        <textarea name="content" data-provide="markdown-editable" rows="14" id="content">{{ $content }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="publish_date" class="col-md-3 control-label">
                发布日期
            </label>
            <div class="col-md-8">
                <input class="form-control" name="publish_date" id="publish_date" type="text" value="{{ $publish_date }}">
            </div>
        </div>
        <div class="form-group">
            <label for="publish_time" class="col-md-3 control-label">
                发布时间
            </label>
            <div class="col-md-8">
                <input class="form-control" name="publish_time" id="publish_time" type="text" value="{{ $publish_time }}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-8 col-md-offset-3">
                <div class="checkbox" style="width: 49%;float: left;">
                    <label>
                        <input {{ checked($is_draft) }} type="checkbox" name="is_draft" style="position: initial;">
                        是否草稿?
                    </label>
                 </div>
                 <div class="checkbox" style="width: 49%;float: left;">
                    <label>
                        <input {{ checked($is_original) }} type="checkbox" name="is_original" style="position: initial;">
                        是否原创?
                    </label>
                 </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">标签</label>
            <div class="col-md-8">
                <select class="form-control m-bot15 selectpicker" name="tags[]" required multiple="multiple">
                    @foreach ($allTags as $tag)
                        <option @if (in_array($tag, $tags)) selected="selected" @endif value="{{ $tag }}">
                            {{ $tag }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="meta_description" class="col-md-3 control-label">
                主要描述
            </label>
            <div class="col-md-8">
                <textarea class="form-control" name="meta_description" id="meta_description" rows="6">{{ $meta_description }}</textarea>
            </div>
        </div>

    </div>
</div>