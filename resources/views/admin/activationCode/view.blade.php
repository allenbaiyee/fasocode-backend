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

                    <a href="{{ route('code_list') }}" class="btn btn-secondary btn-sm">
                        <i class="fa-regular fa-circle-left"></i>
                    </a>

                    <br/><br/>

                    <p>
                       <form name="addCodeForm"  method="POST" action="{{ route('add_code') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group {{ $errors->has('school_id') ? ' has-error' : '' }}">
                                        <label>{{trans('site.school_id')}}</label>
                                        <select class="form-control" name="school_id">
                                            <option value="{{ null }}">{{trans('site.select_school_id')}}</option>
                                            @foreach ($schools as $school)
                                                <option value="{{ $school->id }}">{{$school->school_name}}</option>                                                   
                                            @endforeach
                                            
                                        </select>
                                        @if($errors->has('school_id'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('school_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group {{ $errors->has('activation_code') ? ' has-error' : '' }}">
                                        <label>{{trans('site.Enter the Number of Activation Codes')}}</label>
                                        <input type="textarea" class="form-control" name="activation_code" value="{{ old('activation_code') }}" />
                                        @if($errors->has('activation_code'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('activation_code') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                
                            </div>

                            <button type="submit" class="btn btn-primary m-b-10 m-l-5">{{trans('site.Generate the Activation Codes')}}</button>
                        </form> 
                    </p>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>

</section>

@endsection