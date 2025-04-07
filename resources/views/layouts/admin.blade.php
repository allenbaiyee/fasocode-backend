<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{config('app.name')}}</title>
        <!-- ================= Favicon ================== -->
        <!-- Standard -->
        <!-- Styles -->
        <link href="{{url('focus')}}/assets/css/lib/calendar2/pignose.calendar.min.css" rel="stylesheet" />
        <link href="{{url('focus')}}/assets/css/lib/chartist/chartist.min.css" rel="stylesheet" />
        <link href="{{url('focus')}}/assets/css/lib/font-awesome.min.css" rel="stylesheet" />
        <link href="{{url('focus')}}/assets/css/lib/themify-icons.css" rel="stylesheet" />
        <link href="{{url('focus')}}/assets/css/lib/owl.carousel.min.css" rel="stylesheet" />
        <link href="{{url('focus')}}/assets/css/lib/owl.theme.default.min.css" rel="stylesheet" />
        <link href="{{url('focus')}}/assets/css/lib/weather-icons.css" rel="stylesheet" />
        <link href="{{url('focus')}}/assets/css/lib/menubar/sidebar.css" rel="stylesheet" />
        <link href="{{url('focus')}}/assets/css/lib/bootstrap.min.css" rel="stylesheet" />
        <link href="{{url('focus')}}/assets/css/lib/helper.css" rel="stylesheet" />
        <link href="{{url('focus')}}/assets/css/style.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

        <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    


        <script src="{{url('sorttable.js')}}" type="text/javascript"></script>
        
        <style type="text/css">
            /* Sortable tables */
            table.sortable thead {
                background-color:#eee;
                color:#666666;
                font-weight: bold;
                cursor: default;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="{{url('fontawesome/css/all.min.css')}}">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.14/vue.esm.min.js" integrity="sha512-J5sRuI6WPgEm23Ybb0uCEzQm050Qw/vjwgHuai1m3OjgUlQTRdtbHhAa9lnlb34AkIiRwwsYWah2aatFasfu6A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.0/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>

    <body>
        <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
            <div class="nano">
                <div class="nano-content">
                    <ul>
                        <div class="logo">
                            <a href="{{ url('admin') }}">
                                <!-- <img src="{{url('focus')}}/assets/images/logo.png" alt="" /> -->
                                <!-- <span>{{config('app.name')}}</span> -->
                                @if(Auth::user()->type == 'admin')
                                <a href="{{ url('admin')}} ">
                                    <img class="label" src="{{ url('logo.png') }}" style="width: 5rem;">
                                </a>
                                @endif
                                @if(Auth::user()->type == 'school')
                                <a href="{{ route('list')}} ">
                                    <img class="label" src="{{ url('logo.png') }}" style="width: 5rem;">
                                </a>
                                @endif
                              
                            </a>
                        </div>
                        

                        <li class="label">{{trans('site.menu')}}</li>

                        {{-- <li>
                            <a href="{{url('admin')}}"><i class="far fa-tachometer-alt-slowest"></i> {{trans('site.dashboard')}} </a>
                        </li> --}}

                        @if(Auth::user()->type == 'admin')
                            <li>
                                <a href="{{url('admin')}}"><i class="far fa-tachometer-alt-slowest"></i> {{trans('site.dashboard')}} </a>
                            </li>
                            <li>
                                <a href="{{ route('list') }}"><i class="fa-regular fa-school"></i> {{trans('site.driving_schools')}} </a>
                            </li>
                            <li>
                                <a href="{{ route('code_list') }}"> <i class="fa-regular fa-right-to-bracket"></i>{{trans('site.activation_codes')}}</a>
                            </li>
                            <li>
                                <a href="{{ route('user_list') }}"><i class="fa-regular fa-user"></i> {{trans('site.register')}} </a>
                            </li>
                            <li>
                                <a href="{{url('admin/languages')}}"><i class="fa-solid fa-language"></i> {{trans('site.languages')}} </a>
                            </li>
    
                            <li>
                                <a href="{{url('admin/exams')}}"> <i class="fa-regular fa-books"></i> {{trans('site.exams')}} </a>
                            </li>
    
                            <li>
                                <a href="{{url('admin/sections')}}"> <i class="fa-regular fa-book-sparkles"></i> {{trans('site.permit_sections')}}</a>
                            </li>
    
                            <li>
                                <a href="{{url('admin/questions')}}"> <i class="fa-regular fa-messages-question"></i> {{trans('site.questions')}}</a>
                            </li>
                            <li>
                                <a href="{{ route('terms_condition_view') }}"> <i class="fa-regular fa-file-contract"></i> {{trans('Terms & Condition')}}</a>
                            </li>
                        @endif

                        @if(Auth::user()->type == 'school')
                            <li>
                                <a href="{{ route('list') }}"><i class="fa-regular fa-user"></i> {{trans('site.register')}} </a>
                            </li>
                           
                        @endif
                        
                        
                        {{-- <li>
                            <a href="{{ route('school_list') }}"> <i class="fa-regular fa-messages-question"></i> {{trans('School')}}</a>
                        </li> --}}

                        {{-- @dump(Auth::user()->type) --}}
                        {{-- @if(Auth::user()->type == 'admin')
                            <li>
                                <a href="{{ route('code_list') }}"> <i class="fa-regular fa-right-to-bracket"></i>{{trans('Activation Code')}}</a>
                            </li>
                        @endif --}}
                        
                        <li>
                            <a onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="far fa-sign-out-alt"></i> {{trans('site.logout')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /# sidebar -->

        <div class="header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="float-left">
                            <div class="hamburger sidebar-toggle">
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line"></span>
                            </div>
                        </div>
                        <div class="float-right">
                            <div class="dropdown dib">
                                <div class="header-icon" data-toggle="dropdown">
                                    <span class="user-avatar">
                                        <i class="fa-regular fa-earth-africa"></i>
                                        {{ LaravelLocalization::getCurrentLocaleName() }}
                                    </span>

                                    <div class="drop-down dropdown-profile dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-content-body">
                                            <ul>
                                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                <li>
                                                    <a class="dropdown_a" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                                        {{ $properties['native'] }}
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="dropdown dib">
                                <div class="header-icon" data-toggle="dropdown">
                                    <span class="user-avatar">
                                        @if(auth()->user()->type == 'admin')
                                            {{auth()->user()->email}} ( {{auth()->user()->name}} )
                                        @endif
                                        @if(auth()->user()->type == 'school')
                                            {{auth()->user()->email}} ( {{auth()->user()->school_name}} )
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-wrap">
            <div class="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-8 p-r-0 title-margin-right">
                            <div class="page-header">
                                <div class="page-title">
                                    <h1>{{$title}}</h1>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                        <div class="col-lg-4 p-l-0 title-margin-left">
                            <div class="page-header">
                                <div class="page-title">
                                    <ol class="breadcrumb">
                                        @if(Auth::user()->type == 'admin')
                                            <li class="breadcrumb-item"><a href="{{url('admin')}}">{{trans('site.dashboard')}} </a></li>
                                        @endif
                                       
                                        {{-- <li class="breadcrumb-item"><a href="{{url('admin')}}">{{trans('site.dashboard')}} </a></li> --}}
                                        <li class="breadcrumb-item active">{{$title}}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                    </div>
                    <!-- /# row -->

                    @yield('content')

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="footer">
                                <p>{{date('Y')}} © {{config('app.name')}}. {{trans('site.all_right_reserved')}} - <a href="{{url('/')}}">{{url('/')}}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{url('focus')}}/vendor/global/global.min.js"></script>
        <script src="{{url('focus')}}/js/quixnav-init.js"></script>
        <script src="{{url('focus')}}/js/custom.min.js"></script>

        <script src="{{url('focus')}}/assets/js/lib/jquery.min.js"></script>
        <script src="{{url('focus')}}/assets/js/lib/jquery.nanoscroller.min.js"></script>
        <!-- nano scroller -->
        <script src="{{url('focus')}}/assets/js/lib/menubar/sidebar.js"></script>
        <script src="{{url('focus')}}/assets/js/lib/preloader/pace.min.js"></script>
        <!-- sidebar -->
        <script src="{{url('focus')}}/assets/js/lib/bootstrap.min.js"></script>
        <script src="{{url('focus')}}/assets/js/scripts.js"></script>
        <!-- bootstrap -->

        <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.ckeditor').ckeditor();
            });

            $('.dropdown_a').click(function() {
                window.location = $(this).attr('href');
            })

        </script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

        <!-- jquery vendor -->
        

        <!-- scripit init-->
        <script src="{{url('focus')}}/assets/js/dashboard-1.js"></script>
        <script src="{{url('notify.js')}}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
        <script type="text/javascript">
         
             $('.show-confirm').click(function(event) {
                  var form =  $(this).closest("form");
                  var name = $(this).data("name");
                  event.preventDefault();
                  swal({
                      title: `{{trans('site.are_you_sure')}}`,
                      text: "{{trans('site.it_will_delete_forever')}}",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                      form.submit();
                    }
                  });
              });

              function showComfirmBox(ele){
                var form =  $(ele).closest("form");
                  var name = $(ele).data("name");
                  event.preventDefault();
                  swal({
                      title: `{{trans('site.are_you_sure')}}`,
                      text: "{{trans('site.it_will_delete_forever')}}",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                      form.submit();
                    }
                  });
                }
          
        </script>

        


        @if(Session::has('s'))
        <script type="text/javascript">
            $.notify("{{Session::get('s')}}", "success");
        </script>
        @endif

        @if(Session::has('e'))
        <script type="text/javascript">
            $.notify("{{Session::get('e')}}", "error");
        </script>
        @endif

    </body>
    @stack('js')

    
</html>

