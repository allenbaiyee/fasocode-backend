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

                    <a href="{{ url('admin') }}" class="btn btn-secondary btn-sm">
                        <i class="fa-regular fa-circle-left"></i>
                    </a>

                    <br/><br/>

                    <p>
                       <form name="terms_condition"  method="POST" action="{{ route('terms_condition_update') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group {{ $errors->has('terms_condition') ? ' has-error' : '' }}">
                                        <label>{{trans('site.terms_condition')}}</label>
                                        <textarea class="ckeditor form-control" name="terms_condition">{{ $value->terms_condition }}</textarea>
                                        @if($errors->has('terms_condition'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('terms_condition') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            @if(Auth::user()->type == 'admin')
                            <button type="submit" class="btn btn-primary m-b-10 m-l-5">{{trans('site.save')}}</button>
                            @endif
                        </form> 
                    </p>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>

</section>

@endsection