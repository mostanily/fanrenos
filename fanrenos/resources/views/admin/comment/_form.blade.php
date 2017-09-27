<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="title" class="col-md-2 control-label">
                评论的文章标题
            </label>
            <div class="col-md-10">
                <span class="form-control">{{ $comment->article->title }}</span>
            </div>
        </div>
        <div class="form-group">
            <label for="subtitle" class="col-md-2 control-label">
                评论人
            </label>
            <div class="col-md-10">
                <span class="form-control">{{{ $comment->user->nickname or $comment->user->name }}}</span>
            </div>
        </div>
        <div class="form-group">
            <label for="content" class="col-md-2 control-label">
                评论内容
            </label>
            <div class="col-md-10">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Markdown文本编辑器</h5>
                    </div>
                    <div class="ibox-content">
                        <textarea name="content" data-provide="markdown-editable" rows="14" id="content">{{ $comment->content_raw }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>