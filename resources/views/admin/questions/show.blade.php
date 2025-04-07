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

                    <a href="{{ url('admin/questions') }}" class="btn btn-secondary btn-sm">
                        <i class="fa-regular fa-circle-left"></i>
                    </a>

                    <form id="form-delete-{{$question->id}}" class="form form-inline" action="{{url('admin/questions/'.$question->id)}}" method="post">
                                            @csrf @method('delete')
                                        </form>

                                        <a
                                            href=""
                                            class="btn btn-lg btn-danger float-right"
                                            onclick="event.preventDefault();
                                                     document.getElementById('form-delete-{{$question->id}}').submit();"
                                        >
                                            <i class="far fa-trash-alt"></i>
                                        </a>

                    <div class="row">

                        <div class="col">
                            <p>
                                <h4>{{trans('site.exam')}} : {{$question->section->exam->title}}</h4>
                            </p>


                            <p>
                                <h5>{{trans('site.section')}} : {{$question->section->title}}</h5>
                            </p>

                            <h4>{{trans('site.audio_files')}} :</h4>

                                @foreach($question->audio as $audio)
                                <figure>
                                    <figcaption>{{ $audio->language->title }}</figcaption>
                                    <audio
                                        controls
                                        src="{{ url('audio/'.$audio->file) }}">
                                            {{trans('site.browser_does_not_support')}}
                                            <code>audio</code>
                                    </audio>
                                </figure>

                                @endforeach
                        </div>

                        <div class="col">
                        
                            <p>
                               <img src="{{ url('images/questions/'.$question->image) }}" width="100%">
                            </p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>

</section>

@endsection