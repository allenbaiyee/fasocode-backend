<?php

namespace App\Http\Controllers;

use App\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['title'] = trans('site.exam_sections');
        $data['sections'] = \App\Section::paginate(20);
        return view('admin.sections.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['title'] = trans('site.add_section');
        $data['exams'] = \App\Exam::all();
        return view('admin.sections.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $this->validate($request, [
            'title' =>'required',
            'exam' => 'required',
        ]);

        $section = new \App\Section();
        $section->title = $request->input('title');
        $section->exam_id = $request->input('exam');
        $section->save();

        return redirect()->to('admin/sections')->with('s',trans('site.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
        $data['title'] = trans('site.view_section');
        return view('admin.sections.show')->with($data)->with('section', $section);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
        $data['title'] = trans('site.edit_section');
        return view('admin.sections.edit')->with($data)->with('section', $section);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        //
         $this->validate($request, [
            'title' =>'required',
        ]);
        $section->title = $request->input('title');
        $section->save();

        return redirect()->to('admin/sections')->with('s',trans('site.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        //
        $section->delete();
        return redirect()->to('admin/sections')->with('s',trans('site.success'));
    }
}
