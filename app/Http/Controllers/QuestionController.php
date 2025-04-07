<?php

namespace App\Http\Controllers;

use App\Audio;
use App\Imports\XlsxImport;
use App\Question;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['title'] = trans('site.section_questions');
        $data['questions'] = \App\Question::paginate(50);
		if(\Request::input('section') != null) {
			
			$data['questions'] = \App\Question::where('section_id','=',\Request::input('section'))->paginate(50);
		}
        return view('admin.questions.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['title'] = trans('site.add_question');
        $data['sections'] = \App\Section::all();
        $data['languages'] = \App\Language::all();
        return view('admin.questions.create')->with($data);
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
        // return $request->file('audio-1')->getClientOriginalExtension();
        // $audioUploads = public_path() . '/audio/';

        // $extension = $request->file('audio-1')->getClientOriginalExtension();
        // $filename = Carbon::now()->format('Ymd').'-'.uniqid().'.'.$extension;

        // $request->file('audio-1')->move($audioUploads, $filename);

        // return $filename;

        // return $request->all();
        $upload = public_path() . '/images/questions/';
        $audioUploads = public_path() . '/audio/';

        $this->validate($request, [
            'image' => '|mimes:jpg,jpeg,gif,png|max:512',
            'section' => 'required',
            'answer' => 'required',
            'option' => 'required',
            'audio.*' => 'required|mimes:mp3|max:4096',
        ]);


        $imageName = date('d-H-m-s');
        Image::make($request
                ->file('image')
                ->move($upload, $imageName . "." . $request->file('image')->getClientOriginalExtension()))
            ->fit(500, 500)
            ->save();

        $question = new \App\Question();
        $question->section_id = $request->input('section');
        $question->option = $request->option;
        $question->image = $imageName . "." . $request->file('image')->getClientOriginalExtension();
        $question->save();

        foreach(\App\Language::all() as $langue) {

            $extension = $request->file('audio-'.$langue->id)->getClientOriginalExtension();
            $filename = Carbon::now()->format('Ymd').'-'.uniqid().'.'.$extension;
            $request->file('audio-'.$langue->id)->move($audioUploads, $filename);

            $audio = new \App\Audio();
            $audio->file = $filename;
            $audio->language_id = $langue->id;
            $audio->question_id = $question->id;
            $audio->save();

        }

        return redirect()->to('admin/questions')->with('s','Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
        $data['title'] = trans('site.view_question');
        return view('admin.questions.show')->with($data)->with('question', $question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $data['title'] = trans('site.edit_question');
        $data['sections'] = \App\Section::all();
        $data['languages'] = \App\Language::all();
        // $data['audio'] = Audio::where('question_id', $question->id)->get();
        return view('admin.questions.edit')->with($data)->with('question', $question);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        // dd($request->audio_1);
        $upload = public_path() . '/images/questions/';
        $audioUploads = public_path() . '/audio/';

         $this->validate($request, [
            'option' => 'required',
            'section' => 'required',
            'answer' => 'required',
        ]);

        if($request->image){
            $this->validate($request, [
                'image' => 'mimes:jpg,jpeg,gif,png|max:512',              
            ]);

            $imageName = date('d-H-m-s');
            Image::make($request
                    ->file('image')
                    ->move($upload, $imageName . "." . $request->file('image')->getClientOriginalExtension()))
                ->fit(500, 500)
                ->save();
            $question->image = $imageName . "." . $request->file('image')->getClientOriginalExtension();
        }


        $question->option = $request->option;
        $question->save();

        foreach(\App\Language::all() as $langue) {
            if($request->hasFile('audio_'.$langue->id)){
                $this->validate($request, [
                    'audio_'.$langue->id => 'mimes:mp3|max:4096',
                ]);
            }
        }
        foreach(\App\Language::all() as $langue) {
            if($request->hasFile('audio_'.$langue->id)){
                
                $audio = Audio::where('language_id',$langue->id)->where('question_id', $question->id)->first();
                $extension = $request->file('audio_'.$langue->id)->getClientOriginalExtension();
                $filename = Carbon::now()->format('Ymd').'-'.uniqid().'.'.$extension;
                $request->file('audio_'.$langue->id)->move($audioUploads, $filename);

                if(empty($audio)){
                    $audio = new Audio();
                    $audio->file = $filename;
                    $audio->language_id = $langue->id;
                    $audio->question_id = $question->id;
                }
                $audio->file = $filename;
                $audio->save();
            }
        }
        return redirect()->to('admin/questions')->with('s','Success');
    }

    public function XlsxImport(Request $request){
        $data = Excel::toArray(new XlsxImport, $request->importfile); 
        foreach ($data as $key => $value) {
            foreach ($value as $key1 => $value1) {
                if($key1 > 0) {
                    $image = $value1[1];
                    $excelOptions = $value1[2];
                    $options = "AB";
                    if($excelOptions == 3) {
                        $options .= "C";
                    }
                    if($excelOptions == 4) {
                        $options .= "CD";
                    }
                    Question::where('image', $image)->update([
                        'option' => $options
                    ]);
                }
            }
        }
        return response()->json(['status' => 200,'message' => 'Data Updated Successfully']);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
        $question->delete();
        return redirect()->to('admin/questions')->with('s',"Success");
    }
}
