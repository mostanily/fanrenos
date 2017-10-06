<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\TagCreateRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    protected $fields = [
        'tag' => '',
        'title' => '',
        'meta_description' => '',
    ];

    public function __construct()
    {
        $this->tag = new Tag;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $soft = $this->tag->onlyTrashed()->count();
        $tags = $this->tag->all();
        foreach ($tags as $key => $value) {
            $tags[$key]->select_input = '<label><input class="all_select" type="checkbox" value="'.$value->id.'"></label>';
        }
        return view('admin.tags.index',['tags'=>$tags,'soft'=>$soft]);
    }

    /**
     * 回收站
     * @return [type] [description]
     */
    public function recycle_index(){
        $tags = $this->tag->onlyTrashed()->get();
        return view('admin.tags.recycle_index',['tags'=>$tags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        return view('admin.tags.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagCreateRequest $request)
    {

        foreach (array_keys($this->fields) as $field) {
            $this->tag->$field = $request->get($field);
        }
        $this->tag->save();

        return redirect('/dashboard/tag/index')
                        ->withSuccess("The tag ‘".$this->tag->tag."’ was created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = $this->tag->findOrFail($id);
        $data = ['id' => $id];
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $tag->$field);
        }

        return view('admin.tags.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagUpdateRequest $request, $id)
    {
        $tag = $this->tag->findOrFail($id);

        foreach (array_keys(array_except($this->fields, ['tag'])) as $field) {
            $tag->$field = $request->get($field);
        }
        $tag->save();

        return redirect("/dashboard/tag/$id/edit")
                        ->withSuccess("Changes saved.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = $this->tag->findOrFail($id);
        $tag->delete();

        return redirect('/dashboard/tag/index')
                        ->withSuccess("The ‘".$tag->tag."’ tag has been deleted.");
    }
}
