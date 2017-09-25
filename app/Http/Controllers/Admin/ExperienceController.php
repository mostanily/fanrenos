<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Experience;
use App\Http\Requests;
use App\Http\Requests\ExperienceCreateRequest;
use App\Http\Controllers\Controller;

class ExperienceController extends Controller
{
    protected $fieldList = [
        'icon' => '',
        'title' => '',
        'year' => '',
        'content' => '',
    ];

    public function __construct()
    {
        $this->experience = new Experience;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $experiences = $this->experience->orderBy('year','desc')->get();
        return view('admin.experience.index',['experiences'=>$experiences]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fields = $this->fieldList;
        $data = [];
        foreach ($fields as $fieldName => $fieldValue) {
            $data[$fieldName] = old($fieldName, $fieldValue);
        }

        return view('admin.experience.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExperienceCreateRequest $request)
    {
        $post = $this->experience->create($request->postFillData());

        return redirect()
                        ->route('dashboard.experience.index')
                        ->withSuccess('新的经历添加成功！');
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
        $fields = $this->fieldList;

        $experience = $this->experience->find($id);
        $fieldNames = array_keys($fields);
        $fields = ['id' => $id];
        foreach ($fieldNames as $field) {
            $fields[$field] = $experience->$field;
        }

        $data = array();
        foreach ($fields as $fieldName => $fieldValue) {
            $data[$fieldName] = old($fieldName, $fieldValue);
        }

        return view('admin.experience.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExperienceCreateRequest $request, $id)
    {
        $experience = $this->experience->findOrFail($id);
        $experience->fill($request->postFillData());
        $experience->save();

        return redirect()
                        ->route('dashboard.experience.index')
                        ->withSuccess('Post saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $experience = $this->experience->findOrFail($id);
        $experience->delete();

        return redirect()
                        ->route('dashboard.experience.index')
                        ->withSuccess('经历删除成功');
    }
}
