<?php

namespace App\Http\Controllers;

use App\Exam;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;


class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['title'] = trans('site.exams');
        $data['exams'] = \App\Exam::paginate(20);
        return view('admin.exams.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['title'] = trans('site.add_exams');
        return view('admin.exams.create')->with($data);
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
        $upload = public_path() . '/images/exams/';

        $this->validate($request, [
            'title' =>'required',
            'image' => 'required|mimes:jpg,jpeg,gif,png|max:512'
        ]);

        $imageName = date('d-H-m-s');
        Image::make($request
                ->file('image')
                ->move($upload, $imageName . "." . $request->file('image')->getClientOriginalExtension()))
            ->fit(500, 500)
            ->save();

        $exam = new \App\Exam();
        $exam->title = $request->input('title');
        $exam->image = $imageName . "." . $request->file('image')->getClientOriginalExtension();
        $exam->save();

        return redirect()->to('admin/exams')->with('s', 'Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        //
        $data['title'] = trans('site.show_exams');
        return view('admin.exams.show')->with($data)->with('exam', $exam);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        //
        $data['title'] = trans('site.edit_exams');
        return view('admin.exams.edit')->with($data)->with('exam', $exam);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        //

        $upload = public_path() . '/images/exams/';

        $this->validate($request, [
            'title' =>'required',
            'image' => 'mimes:jpg,jpeg,gif,png|max:512'
        ]);

        if($request->hasFile('image')) {
            $imageName = date('d-H-m-s');
            Image::make($request
                    ->file('image')
                    ->move($upload, $imageName . "." . $request->file('image')->getClientOriginalExtension()))
                ->fit(500, 500)
                ->save();
        }

        $exam->title = $request->input('title');
        if($request->hasFile('image')) {
            $exam->image = $imageName . "." . $request->file('image')->getClientOriginalExtension();
        }
        $exam->save();
        return redirect()->to('admin/exams')->with('s', 'Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        //
        $exam->delete();
        return redirect()->to('admin/exams')->with('s',"Success");
    }
}
