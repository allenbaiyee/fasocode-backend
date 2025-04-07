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

                    {{-- <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                        <i class="fa-regular fa-circle-plus"></i> 
                    </a> --}}

                    <br/><br/>

                    <div class="table-responsive ">
                        <table class="table sortable data-table">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>{{trans('site.driving_schools')}}</th>
                                    <th>{{trans('site.fname')}}</th>
                                    <th>{{trans('site.lname')}}</th>
                                    <th>{{trans('site.phone')}}</th>
									<th>MAC</th>
                                    <th>{{trans('site.email')}}</th>
                                    <th>{{trans('site.dob')}}</th>
                                    <th>{{trans('site.gender')}}</th>
                                    <th>{{trans('site.language')}}</th>
                                    <th>{{trans('site.profession')}}</th>
                                    <th>{{trans('site.Permit')}}</th>
                                    <th>{{trans('site.activation_code')}}</th>
                                    <th>{{trans('site.start_date')}}</th>
                                    <th>{{trans('site.expiry_date')}}</th>
                                </tr>
                            </thead>
                          
                            <tbody>
                                {{-- @foreach($users as $user)
                                <tr>
                                    <td>{{$user->fname}}</td>
                                    <td>{{$user->lname}}</td>
                                    <td>{{$user->phone}}</td>
									<td>{{ $user->mac_address }}</td>
                                    <td>{{$user->email ?? '-'}}</td>
                                    <td>{{$user->token}}</td>
                                    <td>{{$user->created_at->format('Y-m-d')}}</td>
                                    <td>{{$user->expiry_date}}</td>
                                </tr>
                                @endforeach --}}
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
       
    </div>

</section>

@endsection

@push('js')

<script type="text/javascript">
    $(function () {
      
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('list.user') }}",
            columns: [
                {data: 'DT_RowIndex', name: '', orderable: false, searchable: false},
                {data: 'parent.school_name', name: 'parent.school_name'},
                {data: 'fname', name: 'fname'},
                {data: 'lname', name: 'lname'},
                {data: 'phone', name: 'phone'},
				{data: 'mac_address', name: 'mac_address'},
                {data: 'email', name: 'email'},
                {data: 'dob', name: 'dob'},
                {data: 'gender', name: 'gender'},
                {data: 'language.title', name: 'Language.title'},
                {data: 'profession_of_the_trainee', name: 'profession_of_the_trainee'},
                {data: 'type_of_driving_license', name: 'type_of_driving_license'},
                {data: 'token', name: 'token'},
                {data: 'created_at', name: 'created_at'},
                {data: 'expiry_date', name: 'expiry_date'},
            ]
        });
      
    });
</script>

@endpush 