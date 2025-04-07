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

                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                        <i class="fa-regular fa-circle-plus"></i> 
                    </a>

                    <br/><br/>

                    <div class="table-responsive ">
                        <table class="table sortable data-table">
                            @if(Auth::user()->type == 'admin')
                            <thead>
                                <tr>
                                    <th>{{trans('site.school_name')}}</th>
                                    <th>{{trans('site.email')}}</th>
                                    <th>{{trans('site.action')}}</th>
                                </tr>
                            </thead>
                            @endif
                            @if(Auth::user()->type == 'school')
                                <thead>
                                    <tr>
                                        <th>{{trans('site.fname')}}</th>
                                        <th>{{trans('site.lname')}}</th>
                                        <th>{{trans('site.phone')}}</th>
                                        <th>{{trans('site.email')}}</th>
                                        <th>{{trans('site.dob')}}</th>
                                        <th>{{trans('site.gender')}}</th>
                                        <th>{{trans('site.language')}}</th>
                                        <th>{{trans('site.profession')}}</th>
                                        <th>{{trans('site.Permit')}}</th>
                                        <th>{{trans('site.activation_code')}}</th>
                                        <th>{{trans('site.start_date')}}</th>
                                        <th>{{trans('site.expiry_date')}}</th>
                                        {{-- <th>{{trans('site.action')}}</th> --}}
                                    </tr>
                                </thead>
                            @endif
                            <tbody>
                                @if(Auth::user()->type == 'admin')

                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->school_name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            <a href="{{url('admin/edit/'.$user->id)}}" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>
                                            {{-- <form  method="POST" action="{{url('admin/destroy/'.$user->id)}}" style="display: inline;">
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="btn btn-sm btn-danger show-confirm" ><i class="far fa-trash-alt"></i></button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                @endif

                                @if(Auth::user()->type == 'school')
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->fname}}</td>
                                        <td>{{$user->lname}}</td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{$user->email ?? '-'}}</td>
                                        <td>{{$user->dob ?? '-'}}</td>
                                        <td>{{$user->gender ?? '-'}}</td>
                                        <td>{{$user->Language->title ?? '-'}}</td>
                                        <td>{{$user->profession_of_the_trainee ?? '-'}}</td>
                                        <td>{{$user->type_of_driving_license ?? '-'}}</td>
                                        <td>{{$user->token}}</td>
                                        <td>{{$user->created_at->format('Y-m-d')}}</td>
                                        <td>{{$user->expiry_date}}</td>
                                        {{-- <td> --}}
                                            {{-- <a href="{{url('admin/edit/'.$user->id)}}" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a> --}}
                                            {{-- <form  method="POST" action="{{url('admin/destroy/'.$user->id)}}" style="display: inline;">
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="btn btn-sm btn-danger show-confirm" ><i class="far fa-trash-alt"></i></button>
                                            </form> --}}
                                        {{-- </td> --}}
                                    </tr>
                                    @endforeach
                                @endif
                                
                            </tbody>
                        </table>

                        {{-- {!! $user->links() !!} --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>

</section>

@endsection

{{-- @push('js')

<script type="text/javascript">
    $(function () {
      
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('list.user') }}",
          columns: [
              {data: 'DT_RowIndex', name: '', orderable: false, searchable: false},
              {data: 'school_name', name: 'school_name'},
              {data: 'fname', name: 'fname'},
              {data: 'lname', name: 'lname'},
              {data: 'email', name: 'email'},
              {data: 'action', name: 'action', orderable: false, searchable: true},
          ]
      });
      
    });
  </script>

@endpush --}}