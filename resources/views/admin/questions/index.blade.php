@extends('layouts.admin') @section('content')

<section id="main-content">
    <div class="row">
        <!-- /# column -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-title pr"></div>

                <div class="card-body">
                    <a href="{{ url('admin/questions/create') }}" class="btn btn-primary btn-sm">
                        <i class="fa-regular fa-circle-plus"></i>
                    </a>

                    <form action="" method="get" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('section') ? ' has-error' : '' }}">
                                    <label>{{trans('site.section')}}</label>
                                    <select class="form-control" name="section" onchange='submit()'>
                                        <option value="{{ null }}">{{trans('site.pick_section')}}</option>
                                        @foreach(\App\Section::all() as $section)
                                        <option value="{{$section->id}}" {!! \Request::input('section')==$section->id ?
                                            'selected' : '' !!} >{{$section->title}} | {{$section->exam->title}}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('section'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('section') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label></label>
                                <div class="d-flex justify-content-center input-group mt-2">
                                    <div>
                                        <input type="file" name="file" class="custom-file-input import col-7" id="inputGroupFile04">
                                        <label class="custom-file-label col-6" for="inputGroupFile04">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <a class="btn btn-outline-success " id="importFile">Import Xlsx</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br />
                    <br />

                    <div class="table-responsive">
                        <table class="table sortable table-hover">
                            <thead>
                                <tr>
                                    <th>{{trans('site.image')}}</th>
                                    <th>{{trans('site.section')}}</th>
                                    <th>{{trans('site.exam')}}</th>
                                    <th>{{trans('site.audio')}}</th>
                                    <th>noms de fichiers</th>
                                    <th>{{trans('site.settings')}}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($questions as $question)
                                <tr>
                                    <td>
                                        <img src="{{ url('images/questions/'.$question->image) }}" width="75" />
                                    </td>

                                    <td>{{$question->section->title}}</td>
                                    <td>{{$question->section->exam->title}}</td>
                                    <td>{{$question->audio()->count()}}</td>
                                    <td>
                                        image : {{$question->image}}
                                        <hr>
                                        audio : | @foreach($question->audio as $aud)
                                        {{ $aud->file }} |
                                        @endforeach
                                    </td>

                                    <td>


                                        <a href="{{url('admin/questions/'.$question->id)}}"
                                            class="btn btn-sm btn-success"><i class="far fa-eye"></i></a>

                                        <a href="{{url('admin/questions/'.$question->id.'/edit')}}"
                                            class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>

                                        <form method="POST" action="{{url('admin/questions/'.$question->id)}}"
                                            style="display: inline;">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger show-confirm"><i
                                                    class="far fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {!! $questions->withQueryString()->links() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>
</section>

@endsection
@push('js')
<script>
    $('#importFile').on('click', function(e)
    {
        // console.log($('.import').prop('files')[0]);
        // alert('Import');
        var fileData = $('.import').prop('files')[0];
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = new FormData();
        formData.append('importfile',fileData);
        var url = '{{ route('xlsxImport') }}';
        $.ajax({
            type: 'POST',
            url: url,
            processData: false,
            contentType: false,
            dataType: 'json',
            data: formData,
            dataSrc: "",
            success: function(data)
            {
                alert(data.message);
            }
        });
    });


</script>
@endpush