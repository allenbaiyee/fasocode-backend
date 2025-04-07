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
                       <form name="addCodeForm"  method="POST" action="{{ route('update_code') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group {{ $errors->has('school_id') ? ' has-error' : '' }}">
                                        <label>{{trans('site.school_id')}}</label>
                                        <input type="hidden" class="form-control" name="id" value="{{ $code->id }}" />
                                        <select class="form-control" name="school_id">
                                            <option value="{{ null }}">{{trans('site.select_school_id')}}</option>
                                            @foreach ($schools as $school)
                                                <option value="{{ $code->id }} " {{ $code->school_id ==  $code->User->id ? 'Selected':'' }}>{{$code->User->school_name}}</option>                                                   
                                            @endforeach
                                            
                                        </select>
                                        @if($errors->has('school_id'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('school_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group {{ $errors->has('activation_code') ? ' has-error' : '' }}">
                                        <label>{{trans('site.activation_code')}}</label>
                                        <input type="text" class="form-control" name="activation_code" value="{{ $code->activation_code }}" />
                                        @if($errors->has('activation_code'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('activation_code') }}</strong>
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