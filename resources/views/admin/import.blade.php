@extends('layouts.admin')

@section('content')

<section id="main-content">
    <div class="row">
        <div class="col">
            <!-- <p>
                <a href="" class="btn btn-lg btn-primary"><i class="fa-solid fa-file-arrow-up"></i> Import .csv</a>
                <br/><br/>
                <a href="" class="btn btn-sm btn-secondary">please download sample import file .csv</a>
            </p> -->
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{url('importing')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                
                                <div class="col-lg-12">
                                    <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                        <label>{{trans('site.exams')}}</label>
                                        <select class="form-control" name="exam">
                                            <option value="{{ null }}">{{trans('site.pick_exam')}}</option>
                                            @foreach($exams as $exam)
                                            <option value="{{$exam->id}}" {!! old('exam') == $exam->id ? 'selected' : '' !!} >{{$exam->title}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('exam'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('exam') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                        <label>{{trans('site.section')}}</label>
                                        <select class="form-control" name="section">
                                            <option value="{{ null }}">{{trans('site.pick_section')}}</option>
                                            @foreach($sections as $section)
                                            <option value="{{$section->id}}" {!! old('section') == $section->id ? 'selected' : '' !!} >{{$section->title}} | {{$section->exam->title}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('section'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('section') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group {{ $errors->has('csv') ? ' has-error' : '' }}">
                                        <label>{{trans('site.import_csv_file')}}</label>
                                        <input type="file" class="form-control" name="csv" />
                                        @if($errors->has('csv'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('csv') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary m-b-10 m-l-5"><i class="fa-solid fa-file-arrow-up"></i> {{trans('site.import')}}</button>
                        </form> 
            </div>
        </div>
    </div>
</section>



@endsection