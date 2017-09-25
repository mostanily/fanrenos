<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="title" class="col-md-2 control-label">
                标题
            </label>
            <div class="col-md-8">
                <input type="text" class="form-control" name="title" autofocus id="title" value="{{ $title }}">
            </div>
        </div>
        <div class="form-group">
            <label for="subtitle" class="col-md-2 control-label">
                时间段
            </label>
            <div class="col-md-8">
                <input type="text" class="form-control" name="year" id="year" value="{{ $year }}">
            </div>
        </div>
        <link rel="stylesheet" href="{{asset('/plugins/bootstrap-iconpicker/icon-fonts/font-awesome-4.2.0/css/font-awesome.min.css')}}"/>
        <link rel="stylesheet" href="{{asset('/plugins/bootstrap-iconpicker/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css')}}"/>
        <div class="form-group">
            <label class="col-md-2 control-label">图标</label>
            <div class="col-md-6">
                <!-- Button tag -->
                <button class="btn btn-default" name="icon" data-iconset="fontawesome" data-icon="{{ $icon?$icon[0]:'fa-sliders' }}" role="iconpicker"></button>
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
</div>