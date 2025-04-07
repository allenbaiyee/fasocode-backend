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

                    <a href="{{ url('admin/languages/create') }}" class="btn btn-primary btn-sm">
                        <i class="fa-regular fa-circle-plus"></i> 
                    </a>

                    <br/><br/>

                    <div class="table-responsive ">

                        <table class="table sortable ">
                            <thead>
                                <tr>
                                    <th>{{trans('site.language')}}</th>
                                    <th>{{trans('site.audio_files')}}</th>
                                    <th>{{trans('site.settings')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($languages as $language)
                                <tr>
                                    <td>{{$language->title}}</td>

                                    <td>{{$language->audio()->count()}}</td>

                                    <td>
                                        
                                        <a href="{{url('admin/languages/'.$language->id)}}" class="btn btn-sm btn-success"><i class="far fa-eye"></i></a>

                                        <a href="{{url('admin/languages/'.$language->id.'/edit')}}" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>

                                        <form  method="POST" action="{{url('admin/languages/'.$language->id)}}" style="display: inline;">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger show-confirm" ><i class="far fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {!! $languages->links() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>

</section>

@endsection