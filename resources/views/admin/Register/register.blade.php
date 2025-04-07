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
                        <form name="registerForm"  method="POST" action="{{ route('add_user') }}">
                             @csrf
                             <div class="row">
                                 <div class="col-lg-6">
                                     <div class="form-group {{ $errors->has('fname') ? ' has-error' : '' }}">
                                         <label>{{trans('site.fname')}}</label> <span class="text-danger">*</span>
                                         <input type="text" class="form-control" name="fname" value="{{ old('fname') }}" />
                                         @if($errors->has('fname'))
                                         <span class="help-block text-danger">
                                             <strong>{{ $errors->first('fname') }}</strong>
                                         </span>
                                         @endif
                                     </div>
                                 </div>
                                 <div class="col-lg-6">
                                     <div class="form-group {{ $errors->has('lname') ? ' has-error' : '' }}">
                                         <label>{{trans('site.lname')}}</label> <span class="text-danger">*</span>
                                         <input type="text" class="form-control" name="lname" value="{{ old('lname') }}" />
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
                                         <input type="text" class="form-control" name="email" value="{{ old('email') }}" />
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
                                         <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" />
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
                                        <input type="text" class="form-control" name="name_of_registrator" value="{{ old('name_of_registrator') }}" />
                                        @if($errors->has('name_of_registrator'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('name_of_registrator') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                 <div class="col-lg-6">
                                     <div class="form-group {{ $errors->has('dob') ? ' has-error' : '' }}">
                                         <label>{{trans('site.dob')}}</label> <span class="text-danger">*</span>
                                         <input type="date" class="form-control" name="dob" value="{{ old('dob') }}" />
                                         @if($errors->has('dob'))
                                         <span class="help-block text-danger">
                                             <strong>{{ $errors->first('dob') }}</strong>
                                         </span>
                                         @endif
                                     </div>
                                 </div>
                                 <div class="col-lg-6">
                                     <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                                         <label>{{trans('site.gender')}}</label> <span class="text-danger">*</span>
                                         <select class="form-control" name="gender">
                                             <option value="{{ null }}">{{trans('site.select_gender')}}</option>
                                             <option value="Male" @if(old('gender') == 'Male') selected @endif>{{trans('site.male')}}</option>
                                             <option value="Female"  @if(old('gender') == 'Female') selected @endif>{{trans('site.female')}}</option>
                                         </select>
                                         @if($errors->has('gender'))
                                         <span class="help-block text-danger">
                                             <strong>{{ $errors->first('gender') }}</strong>
                                         </span>
                                         @endif
                                     </div>
                                 </div>
                                 <div class="col-lg-6">
                                     {{-- <div class="form-group {{ $errors->has('activation_code') ? ' has-error' : '' }}">
                                         <label>{{trans('site.activation_code')}}</label>
                                         <input type="text" class="form-control" name="activation_code" value="{{ old('activation_code') }}" />
                                         @if($errors->has('activation_code'))
                                         <span class="help-block text-danger">
                                             <strong>{{ $errors->first('activation_code') }}</strong>
                                         </span>
                                         @endif
                                     </div> --}}
                                     <div class="form-group {{ $errors->has('activation_code') ? ' has-error' : '' }}">
                                         <label>{{trans('site.activation_code')}}</label> <span class="text-danger">*</span>
                                         <select class="form-control" name="activation_code">
                                             <option value="{{ null }}">{{trans('site.select_code')}}</option>
                                             @foreach ($codes as $code)
                                                 <option value="{{ $code->activation_code }}" @if(old('activation_code') == $code->activation_code) selected @endif>{{$code->activation_code}}</option>                                                   
                                             @endforeach
                                             
                                         </select>
                                         @if($errors->has('activation_code'))
                                         <span class="help-block text-danger">
                                             <strong>{{ $errors->first('activation_code') }}</strong>
                                         </span>
                                         @endif
                                     </div>
                                 </div>
                                 
                                 <div class="col-lg-6">
                                     <div class="form-group {{ $errors->has('language') ? ' has-error' : '' }}">
                                         <label>{{trans('site.language')}}</label> <span class="text-danger">*</span>
                                         <select class="form-control" name="language">
                                             <option value="{{ null }}">{{trans('site.select_language')}}</option>
                                             @foreach ($languages as $language)
                                                 <option value="{{ $language->id }}" @if(old('language') == $language->id) selected @endif>{{$language->title}}</option>                                                   
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
                                        <select class="form-control" name="profession_of_the_trainee">
                                            <option value="{{ null }}">{{trans('site.select_profession_of_the_trainee')}}</option>
                                            <option value="Agriculteur" @if(old('profession_of_the_trainee') == 'Agriculteur') selected @endif>{{trans('site.profession_agric')}}</option>
                                            <option value="Artisan" @if(old('profession_of_the_trainee') == 'Artisan') selected @endif>{{trans('site.profession_artisan')}}</option>
                                            <option value="Commerçant" @if(old('profession_of_the_trainee') == 'Commerçant') selected @endif>{{trans('site.profession_seller')}}</option>
                                            <option value="Éleveur" @if(old('profession_of_the_trainee') == 'Éleveur') selected @endif>{{trans('site.profession_graduate')}}</option>
                                            <option value="Élève" @if(old('profession_of_the_trainee') == 'Élève') selected @endif>{{trans('site.profession_student')}}</option>
                                            <option value="Étudiant" @if(old('profession_of_the_trainee') == 'Étudiant') selected @endif>{{trans('site.profession_etudiant')}}</option>
                                            <option value="Travailleur secteur privé" @if(old('profession_of_the_trainee') == "Travailleur secteur privé") selected @endif>{{trans("site.private_sector")}}</option>
                                            <option value="Travailleur fonction publique" @if(old('profession_of_the_trainee') == "Travailleur fonction publique") selected @endif>{{trans("site.function_public")}}</option>
                                            <option value="Recherche d'emploi Retraité(e)" @if(old('profession_of_the_trainee') == "Recherche d'emploi Retraité(e)") selected @endif>{{trans("site.job_hunting")}}</option>
                                            <option value="Femme de ménage" @if(old('profession_of_the_trainee') == 'Femme de ménage') selected @endif>{{trans('site.profession_women_manage')}}</option>
                                            <option value="Autre" @if(old('profession_of_the_trainee') == 'Autre') selected @endif>{{trans('site.profession_others')}}</option>
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
                                        <select class="form-control" name="type_of_driving_license">
                                            <option value="{{ null }}">{{trans('site.select_type_of_driving_license')}}</option>
                                            <option value="Permit B" @if(old('type_of_driving_license') == 'Permit B') selected @endif>{{trans('site.Permit B')}}</option>
                                            <option value="Permit C" @if(old('type_of_driving_license') == 'Permit C') selected @endif>{{trans('site.Permit C')}}</option>
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
                        <form name="registerForm"  method="POST" action="{{ route('add_user') }}">
                             @csrf
                             <div class="row">
                                 <div class="col-lg-6">
                                     <div class="form-group {{ $errors->has('school_name') ? ' has-error' : '' }}">
                                         <label>{{trans('site.school_name')}}</label> <span class="text-danger">*</span>
                                         <input type="text" class="form-control" name="school_name" value="{{ old('school_name') }}" />
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
                                         <input type="text" class="form-control" name="email" value="{{ old('email') }}" />
                                         @if($errors->has('email'))
                                         <span class="help-block text-danger">
                                             <strong>{{ $errors->first('email') }}</strong>
                                         </span>
                                         @endif
                                     </div>
                                 </div>
                                 <div class="col-lg-6">
                                     <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                         <label>{{trans('site.password')}}</label> <span class="text-danger">*</span>
                                         <input type="password" class="form-control" name="password" value="{{ old('password') }}" />
                                         @if($errors->has('password'))
                                         <span class="help-block text-danger">
                                             <strong>{{ $errors->first('password') }}</strong>
                                         </span>
                                         @endif
                                     </div>
                                 </div>
                                 <div class="col-lg-6">
                                     <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                                         <label>{{trans('site.phone')}}</label> <span class="text-danger">*</span>
                                         <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" />
                                         @if($errors->has('phone'))
                                         <span class="help-block text-danger">
                                             <strong>{{ $errors->first('phone') }}</strong>
                                         </span>
                                         @endif
                                     </div>
                                 </div>
                                 
                                 {{-- <div class="col-lg-6">
                                     <div class="form-group {{ $errors->has('activation_code') ? ' has-error' : '' }}">
                                         <label>{{trans('site.activation_code')}}</label>
                                         <input type="text" class="form-control" name="activation_code" value="{{ old('activation_code') }}" />
                                         @if($errors->has('activation_code'))
                                         <span class="help-block text-danger">
                                             <strong>{{ $errors->first('activation_code') }}</strong>
                                         </span>
                                         @endif
                                     </div>
                                     
                                 </div> --}}
                                 
                                 
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