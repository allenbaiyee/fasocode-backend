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
                       <h2>{{$exam->title}}</h2>

                       <img src="{{ url('images/exams/'.$exam->image) }}" width="100">
                    </p>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>

</section>

@endsection