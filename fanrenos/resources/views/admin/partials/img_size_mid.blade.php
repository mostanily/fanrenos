<div class="form-group">
    <label class="">图片尺寸限制(w*h:px像素)，传商品图时，请选择尺寸</label>
    <div class="">
        <div class="input-group form-control">
            <select class="form-control m-bot15" name="small_img">
                <option value="">默认空</option>
                @foreach($img_size['img-small'] as $small)
                    <option value="{{$small}}">{{$small}}</option>
                @endforeach
            </select>
            <span class="input-group-addon">small</span>
            <select class="form-control m-bot15" name="middle_img">
                <option value="">默认空</option>
                @foreach($img_size['img-middle'] as $middle)
                    <option value="{{$middle}}">{{$middle}}</option>
                @endforeach
            </select>
            <span class="input-group-addon">middle</span>
            <select class="form-control m-bot15" name="big_img">
                <option value="">默认空</option>
                @foreach($img_size['img-big'] as $big)
                    <option value="{{$big}}">{{$big}}</option>
                @endforeach
            </select>
            <span class="input-group-addon">big</span>
        </div>
    </div>
</div>