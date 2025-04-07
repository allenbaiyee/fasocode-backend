@extends('layouts.admin')

@section('content')

<section id="main-content">
    <div class="row">
        {{-- <div class="col">
            <p>
                <a href="{{url('admin/import')}}" class="btn btn-lg btn-primary"><i class="fa-solid fa-file-arrow-up"></i> {{trans('site.import_csv')}}</a>
            </p>
        </div>

        <div class="col">
            <p>
                <a href="{{url('admin/get-json-database')}}" class="btn btn-lg btn-primary"><i class="fa-solid fa-database"></i> {{trans('site.build_local_databaset_csv')}}</a>
            </p>
        </div> --}}
    </div>

    <div class="row">
        <div class="col">
            <p class="">
                <h5>Total questions image file size :<br/><span class="badge bg-info"> <strong>{{$imageFilesTotalSize}} MB</strong> </span></h5>
            </p>
        </div>
        <div class="col">
        <p class="">
                <h5>Total audio file size :<br/><span class="badge bg-info"><strong> {{$audioFilesTotalSize}} MB </strong> </span></h5>
            </p>
        </div>
    </div>

    <div class="row">


        <div class="col-lg-3">
            <div class="card">
                <div class="stat-widget-one">
                    <i class="fa-solid fa-language fa-2x"></i>
                    <div class="stat-content dib">
                        <div class="stat-text">{{trans('site.languages')}}</div>
                        <div class="stat-digit">{{ \App\Language::count() }}</div>
                        <a href="{{url('admin/languages')}}" class="btn btn-sm btn-default"><i class="fa-regular fa-eye"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card">
                <div class="stat-widget-one">
                    <i class="fa-regular fa-books fa-2x"></i>
                    <div class="stat-content dib">
                        <div class="stat-text">{{trans('site.exams')}}</div>
                        <div class="stat-digit">{{ \App\Exam::count() }}</div>
                        <a href="{{url('admin/exams')}}" class="btn btn-sm btn-default"><i class="fa-regular fa-eye"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card">
                <div class="stat-widget-one">
                    <i class="fa-regular fa-book-sparkles fa-2x"></i>
                    <div class="stat-content dib">
                        <div class="stat-text">{{trans('site.sections')}}</div>
                        <div class="stat-digit">{{ \App\Section::count() }}</div>
                        <a href="{{url('admin/sections')}}" class="btn btn-sm btn-default"><i class="fa-regular fa-eye"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card">
                <div class="stat-widget-one">
                    <i class="fa-regular fa-messages-question fa-2x"></i>
                    <div class="stat-content dib">
                        <div class="stat-text">{{trans('site.questions')}}</div>
                        <div class="stat-digit">{{ \App\Question::count() }}</div>
                        <a href="{{url('admin/questions')}}" class="btn btn-sm btn-default"><i class="fa-regular fa-eye"></i></a>
                    </div>
                </div>
            </div>
        </div>



    </div>


</section>

@endsection
