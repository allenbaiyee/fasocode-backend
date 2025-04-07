<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['title'] = trans('site.audio_languages');
        $data['languages'] = \App\Language::paginate(20);
        return view('admin.languages.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['title'] = trans('site.add_language');
        return view('admin.languages.create')->with($data);
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
        ]);

        $language = new \App\Language();
        $language->title = $request->input('title');
        $language->save();

        return redirect()->to('admin/languages')->with('s',trans('site.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {
        //

        $data['title'] = trans('site.view_language');
        return view('admin.languages.show')->with($data)->with('language', $language);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        //
        $data['title'] = trans('site.edit_language');
        return view('admin.languages.edit')->with($data)->with('language', $language);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Language $language)
    {
        //
         $this->validate($request, [
            'title' =>'required',
        ]);
        $language->title = $request->input('title');
        $language->save();

        return redirect()->to('admin/languages')->with('s',trans('site.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        //
        $language->delete();
        return redirect()->to('admin/languages')->with('s',trans('site.success'));
    }
}
