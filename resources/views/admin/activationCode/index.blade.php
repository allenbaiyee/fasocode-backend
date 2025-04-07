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

                    <a href="{{ route('view_code') }}" class="btn btn-primary btn-sm">
                        <i class="fa-regular fa-circle-plus"></i> 
                    </a>

                    <br/><br/>

                    <div class="table-responsive ">
                        <table class="table sortable data-table" >
                            <thead>
                                <tr>
                                    <th>{{trans('Id')}}</th>
                                    <th>{{trans('School Name')}}</th>
                                    <th>{{trans('Student Name')}}</th>
                                    <th>{{trans('site.activation_code')}}</th>
                                    <th>{{trans('site.start_date')}}</th>
                                    <th>{{trans('site.expiry_date')}}</th>
                                    <th>{{trans('site.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>

</section>

@endsection

@push('js')

<script type="text/javascript">
    $(function () {
    
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('list.code') }}",
          columns: [
              {data: 'DT_RowIndex', name: '', orderable: false, searchable: false},
              {data: 'user.school_name', name: 'User.school_name'},
              {data: 'student_name', name: 'student_name'},
              {data: 'activation_code', name: 'activation_code'},
              {data: 'user.created_at', name: 'User.created_at'},
              {data: 'user.expiry_date', name: 'User.expiry_date'},
              {data: 'action', name: 'action', orderable: false, searchable: true},
          ]
      });
    });

    function prolongCode(code){

        swal({
            title: `{{trans('site.are_you_sure_prolong_code')}}`,
            text: "{{trans('site.it_will_prolonged')}}",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var url = '{{ route('prolong_code') }}';
                    $.ajax({
                        type: 'POST',
                        url: url,
                        dataType: 'json',
                        data: {code},
                        success: function(data)
                        {
                            if(data.status){
                                $('.data-table').DataTable().ajax.reload()

                            }
                        }
                });
            }
        });

        

    }
  </script>

@endpush