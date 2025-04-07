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

                    <a href="{{ route('list') }}" class="btn btn-secondary btn-sm">
                        <i class="fa-regular fa-circle-left"></i>
                    </a>

                    <br/><br/>

                    <p>
                        @if (Auth::user()->type == 'school')
                        <form name="registerForm"  method="POST" action="{{ route('update') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group {{ $errors->has('fname') ? ' has-error' : '' }}">
                                        <label>{{trans('site.fname')}}</label> </label> <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="fname" value="{{ $users->fname }}" />
                                        <input type="hidden" class="form-control" name="id" value="{{ $users->id }}" />
                                        @if($errors->has('fname'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('fname') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group {{ $errors->has('lname') ? ' has-error' : '' }}">
                                        <label>{{trans('site.lname')}}</label> </label> <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="lname" value="{{ $users->lname }}" />
                                        @if($errors->has('lname'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('lname') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label>{{trans('site.email')}}</label>
                                        <input type="text" class="form-control" name="email" value="{{$users->email }}" />
                                        @if($errors->has('email'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                                        <label>{{trans('site.phone')}}</label> </label> <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="phone" value="{{ $users->phone }}" />
                                        @if($errors->has('phone'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group {{ $errors->has('name_of_registrator') ? ' has-error' : '' }}">
                                        <label>{{trans('site.name_of_registrator')}}</label>
                                        <input type="text" class="form-control" name="name_of_registrator" value="{{ $users->name_of_registrator }}" />
                                        <input type="hidden" class="form-control" name="id" value="{{ $users->id }}" />
                                        @if($errors->has('name_of_registrator'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('name_of_registrator') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group {{ $errors->has('dob') ? ' has-error' : '' }}">
                                        <label>{{trans('site.dob')}}</label> </label> <span class="text-danger">*</span>
                                        <input type="date" class="form-control" name="dob" value="{{ $users->dob }}" />
                                        @if($errors->has('dob'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('dob') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                                        <label>{{trans('site.gender')}}</label> </label> <span class="text-danger">*</span>
                                        <select class="form-control"  name="gender">
                                            <option value="{{ null }}">{{trans('site.select_gender')}}</option>
                                            <option value="Male" {{ $users->gender == "male" ? 'Selected':'' }}>{{trans('site.male')}}</option>
                                            <option value="Female" {{ $users->gender == "female" ? 'Selected':'' }}>{{trans('site.female')}}</option>
                                        </select>
                                        @if($errors->has('gender'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('gender') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group {{ $errors->has('activation_code') ? ' has-error' : '' }}">
                                        <label>{{trans('site.activation_code')}}</label> </label> <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="activation_code" value="{{$users->token }}" disabled />
                                        @if($errors->has('activation_code'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('activation_code') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group {{ $errors->has('language') ? ' has-error' : '' }}">
                                        <label>{{trans('site.language')}}</label> </label> <span class="text-danger">*</span>
                                        <select class="form-control" name="language">
                                            <option value="{{ null }}">{{trans('site.select_language')}}</option>
                                            @foreach ($languages as $language)
                                                <option value="{{ $language->id }}" {{ $users->language_id == $language->id ? 'Selected':'' }}>{{$language->title}}</option>                                                   
                                            @endforeach
                                            
                                        </select>
                                        @if($errors->has('language'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('language') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group {{ $errors->has('profession_of_the_trainee') ? ' has-error' : '' }}">
                                        <label>{{trans('site.profession_of_the_trainee')}}</label> <span class="text-danger">*</span>
                                        <select class="form-control"  name="profession_of_the_trainee">
                                            <option value="{{ null }}">{{trans('site.select_profession_of_the_trainee')}}</option>
                                            <option value="Agriculteur" {{ $users->profession_of_the_trainee == "Agriculteur" ? 'Selected':'' }}>{{trans('site.Agriculteur')}}</option>
                                            <option value="Artisan" {{ $users->profession_of_the_trainee == "Artisan" ? 'Selected':'' }}>{{trans('site.Artisan')}}</option>
                                            <option value="Commerçant" {{ $users->profession_of_the_trainee == "Commerçant" ? 'Selected':'' }}>{{trans('site.Commerçant')}}</option>
                                            <option value="Éleveur" {{ $users->profession_of_the_trainee == "Éleveur" ? 'Selected':'' }}>{{trans('site.Éleveur')}}</option>
                                            <option value="Élève" {{ $users->profession_of_the_trainee == "Élève" ? 'Selected':'' }}>{{trans('site.Élève')}}</option>
                                            <option value="Étudiant" {{ $users->profession_of_the_trainee == "Étudiant" ? 'Selected':'' }}>{{trans('site.Étudiant')}}</option>
                                            <option value="Travailleur secteur privé Travailleur fonction publique Recherche d'emploi Retraité(e)" {{ $users->profession_of_the_trainee == "Travailleur secteur privé Travailleur fonction publique Recherche d'emploi Retraité(e)" ? 'Selected':'' }}>{{trans("site.Travailleur secteur privé Travailleur fonction publique Recherche d'emploi Retraité(e)")}}</option>
                                            <option value="Femme de ménage" {{ $users->profession_of_the_trainee == "Femme de ménage" ? 'Selected':'' }}>{{trans('site.Femme de ménage')}}</option>
                                            <option value="Autre" {{ $users->profession_of_the_trainee == "Autre" ? 'Selected':'' }}>{{trans('site.Autre')}}</option>
                                        </select>
                                        @if($errors->has('profession_of_the_trainee'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('profession_of_the_trainee') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group {{ $errors->has('type_of_driving_license') ? ' has-error' : '' }}">
                                        <label>{{trans('site.type_of_driving_license')}}</label> <span class="text-danger">*</span>
                                        <select class="form-control"  name="type_of_driving_license">
                                            <option value="{{ null }}">{{trans('site.select_type_of_driving_license')}}</option>
                                            <option value="Permit B" {{ $users->type_of_driving_license == "Permit B" ? 'Selected':'' }}>{{trans('site.Permit B')}}</option>
                                            <option value="Permit C" {{ $users->type_of_driving_license == "Permit C" ? 'Selected':'' }}>{{trans('site.Permit C')}}</option>
                                        </select>
                                        @if($errors->has('type_of_driving_license'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('type_of_driving_license') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary m-b-10 m-l-5">{{trans('site.save')}}</button>
                        </form> 
                            
                        @endif

                        @if (Auth::user()->type == 'admin')
                        <form name="registerForm"  method="POST" action="{{ route('update') }}">
                             @csrf
                             <div class="row">
                                 <div class="col-lg-6">
                                     <div class="form-group {{ $errors->has('school_name') ? ' has-error' : '' }}">
                                         <label>{{trans('site.school_name')}}</label> <span class="text-danger">*</span>
                                         <input type="text" class="form-control" name="school_name" value="{{ $users->school_name }}" />
                                         <input type="hidden" class="form-control" name="id" value="{{ $users->id }}" />
                                         @if($errors->has('school_name'))
                                         <span class="help-block text-danger">
                                             <strong>{{ $errors->first('school_name') }}</strong>
                                         </span>
                                         @endif
                                     </div>
                                 </div>
                                 
                                 <div class="col-lg-6">
                                     <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                         <label>{{trans('site.email')}}</label> <span class="text-danger">*</span>
                                         <input type="text" class="form-control" name="email" value="{{ $users->email }}" />
                                         @if($errors->has('email'))
                                         <span class="help-block text-danger">
                                             <strong>{{ $errors->first('email') }}</strong>
                                         </span>
                                         @endif
                                     </div>
                                 </div>
                                 
                                 <div class="col-lg-6">
                                     <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                                         <label>{{trans('site.phone')}}</label> <span class="text-danger">*</span>
                                         <input type="text" class="form-control" name="phone" value="{{$users->phone }}" />
                                         @if($errors->has('phone'))
                                         <span class="help-block text-danger">
                                             <strong>{{ $errors->first('phone') }}</strong>
                                         </span>
                                         @endif
                                     </div>
                                 </div>
                             </div>
 
                             <button type="submit" class="btn btn-primary m-b-10 m-l-5">{{trans('site.save')}}</button>
                         </form> 
                            
                        @endif

                        
                    </p>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>

</section>

@endsection