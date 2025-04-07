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

                    <a href="{{ url('admin/exams/create') }}" class="btn btn-primary btn-sm">
                        <i class="fa-regular fa-circle-plus"></i> 
                    </a>

                    <br/><br/>

                    <div class="table-responsive ">
                        <table class="table sortable ">
                            <thead>
                                <tr>
                                    <th>{{trans('site.title')}}</th>
                                    <th>{{trans('site.sections')}}</th>
                                    <th>{{trans('site.settings')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exams as $exam)
                                <tr>
                                    <td>{{$exam->title}}</td>

                                    <td>{{$exam->sections()->count()}}</td>

                                    <td>
                                        

                                        <a href="{{url('admin/exams/'.$exam->id)}}" class="btn btn-sm btn-success"><i class="far fa-eye"></i></a>

                                        <a href="{{url('admin/exams/'.$exam->id.'/edit')}}" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>

                                        <form  method="POST" action="{{url('admin/exams/'.$exam->id)}}" style="display: inline;">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger show-confirm" ><i class="far fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {!! $exams->links() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>

</section>

@endsection