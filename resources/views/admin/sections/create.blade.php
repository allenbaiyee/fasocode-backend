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

                    <a href="{{ url('admin/sections') }}" class="btn btn-secondary btn-sm">
                        <i class="fa-regular fa-circle-left"></i>
                    </a>

                    <br/><br/>

                    <p>
                       <form action="{{url('admin/sections')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                        <label>{{trans('site.title')}}</label>
                                        <input type="text" class="form-control" name="title" value="{{ old('title') }}" />
                                        @if($errors->has('title'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                        <label>{{trans('site.exams')}}</label>
                                        <select class="form-control" name="exam">
                                            <option value="{{ null }}">{{trans('site.pick_exams')}}</option>
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
                            </div>

                            <button type="submit" class="btn btn-primary m-b-10 m-l-5">{{trans('site.save')}}</button>
                        </form> 
                    </p>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>

</section>

@endsection