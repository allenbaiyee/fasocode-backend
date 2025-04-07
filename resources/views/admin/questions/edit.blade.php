@extends('layouts.admin')

@section('content')

<section id="main-content">

    <div class="row">
        <!-- /# column -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-title pr">

                </div>

                <div class="card-body">

                    <a href="{{ url('admin/questions') }}" class="btn btn-secondary btn-sm">
                        <i class="fa-regular fa-circle-left"></i>
                    </a>

                    <br/><br/>

                    <p>
                       <form action="{{url('admin/questions/'.$question->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                        <label>{{trans('site.section')}}</label>
                                        <select class="form-control" name="section">
                                            <option value="{{ null }}">{{trans('site.pick_section')}}</option>
                                            @foreach($sections as $section)
                                                <option value="{{$section->id}}" {{$question->section_id == $section->id ? 'selected' : '' }} >{{$section->title}} | {{$section->title}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('section'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('section') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group {{ $errors->has('answer') ? ' has-error' : '' }}">
                                        <label>{{trans('site.answer')}}</label>
                                        <input type="text" class="form-control" name="answer" value="{{$question->answer }}" />
                                        @if($errors->has('answer'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('answer') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-lg-5">
                                    <div class="form-group {{ $errors->has('option') ? ' has-error' : '' }}">
                                        <label>{{trans('site.option')}}</label>
                                        <select class="form-control" name="option">
                                            <option value="{{ null }}">{{trans('site.option')}}</option>
                                            <option value="AB" {{ $question->option == 'AB' ? 'Selected':'' }}>2</option>
                                            <option value="ABC" {{ $question->option == 'ABC' ? 'Selected':'' }}>3</option>
                                            <option value="ABCD" {{ $question->option == 'ABCD' ? 'Selected':'' }}>4</option>
                                        </select>
                                        @if($errors->has('option'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('option') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-5">
                                    <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
                                        <label>{{trans('site.image')}}</label>
                                        <input type="file" class="form-control" name="image" value="{{ old('image') }}" />
                                        @if($errors->has('image'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <img src="{{ url('images/questions/'.$question->image) }}" width="100%">
                                </div>

                                {{-- @dump($audio) --}}
                                @foreach($languages as $index=>$language)

                                <div class="col-lg-4">
                                    <div class="form-group {{ $errors->has('audio') ? ' has-error' : '' }}">
                                        <label>{{trans('site.audio')}} {{$index+1}} ({{$language->title}})</label>
                                        <input type="file" class="form-control" name="audio_{{$language->id}}"  />
                                        @if($errors->has('audio'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('audio') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary m-b-10 m-l-5">{{trans('site.update')}}</button>
                        </form> 
                    </p>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>

</section>

@endsection