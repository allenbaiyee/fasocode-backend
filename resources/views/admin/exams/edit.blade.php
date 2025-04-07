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

                    <a href="{{ url('admin/exams') }}" class="btn btn-secondary btn-sm">
                        <i class="fa-regular fa-circle-left"></i>
                    </a>

                    <br/><br/>

                    <p>
                       <form action="{{url('admin/exams/'.$exam->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                        <label>{{trans('site.title')}}</label>
                                        <input type="text" class="form-control" name="title" value="{{ old('title')!=null ? old('title') : $exam->title }}" />
                                        @if($errors->has('title'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-lg-5">
                                    <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                        <label>{{trans('site.image')}}</label>
                                        <input type="file" class="form-control" name="image" value="{{ old('title') }}" />
                                        @if($errors->has('title'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                </div>
                                <div class="col-lg-2">
                                    <img src="{{ url('images/exams/'.$exam->image) }}" width="100%">
                                </div>
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