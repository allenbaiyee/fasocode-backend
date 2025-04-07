<!DOCTYPE html>
<html lang="en" class="h-100">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ config('app.name') }}</title>
        <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/cover/" />
        <link rel="stylesheet" type="text/css" href="{{url('fontawesome/css/all.min.css')}}" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- Bootstrap core CSS -->
        <link href="{{url('focus')}}/assets/css/lib/bootstrap.min.css" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        <!-- Favicons -->
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }

            /*
 * Globals
 */
            /* Custom default button */
            .btn-secondary,
            .btn-secondary:hover,
            .btn-secondary:focus {
                color: #333;
                text-shadow: none; /* Prevent inheritance from `body` */
            }

            /*
 * Base structure
 */

            body {
                text-shadow: 0 0.05rem 0.1rem rgba(0, 0, 0, 0.5);
                box-shadow: inset 0 0 5rem rgba(0, 0, 0, 0.5);
            }

            .cover-container {
                max-width: 42em;
            }

            /*
 * Header
 */

            .nav-masthead .nav-link {
                padding: 0.25rem 0;
                font-weight: 700;
                color: rgba(255, 255, 255, 0.5);
                background-color: transparent;
                border-bottom: 0.25rem solid transparent;
            }

            .nav-masthead .nav-link:hover,
            .nav-masthead .nav-link:focus {
                border-bottom-color: rgba(255, 255, 255, 0.25);
            }

            .nav-masthead .nav-link + .nav-link {
                margin-left: 1rem;
            }

            .nav-masthead .active {
                color: #fff;
                border-bottom-color: #fff;
            }


            .correctAns:checked{
                background-color: green !important;
                border: 0;
            }
            .correctAns:focus, .label::after, label.form-check-label:focus, .correctAns::after, .correctAns:not(:disabled):not(.disabled):active:focus {
                color: black;
                outline: 0;
                border: 0;
                box-shadow: 0 0 0 0.1rem green !important;
            }

            .notCorrectAns{
                background-color: red !important;
                border: 0;
            }
            .notCorrectAns:focus, .label::after, label.form-check-label:focus, .notCorrectAns::after, .notCorrectAns:not(:disabled):not(.disabled):active:focus {
                color: black;
                outline: 0;
                border: 0;
                box-shadow: 0 0 0 0.1rem red !important;
            }

            .correct{
                color:green;
            }
            .wrong{
                color:red;
            }
        </style>
    </head>

  <body class="d-flex h-100 text-center text-dark" style="background: inherit;">
        <div class="container-fluid d-flex w-100 h-100 p-3 mx-auto flex-column" style="background: #fff;">
            <header class="mb-auto">
                <div>
                    <a href="{{ url('/')}} ">
                        <img src="{{ url('logo.jpeg') }}" style="width: 10.0rem;">
                    </a>
                    <nav class="nav nav-masthead justify-content-center float-md-end">
                    </nav>

                </div>
            </header>

            <main class="px-3">
                <div class="row" style=" background: #F6F8F9; width: 75%; margin: auto; padding: 0px;">
                    <div class="col-md-6 text-left" style="display: none;">
                        {{ $questions->first()->section->title }}
                    </div>
                    <div class="col-md-6 text-right" style="display: none;">
                        {{$questions->currentPage()}} of {{$questions->total()}}
                    </div>

                    <div class="col-md-12" style="padding: 0px; margin-top: 0px;" >
                        <img src="{{ url('images/questions/'.$questions->first()->image) }}" style="width: 100%;  ">
                    </div>
                </div>
            </main>
            
           <div class="my-4 err_answer">
                <form name="answer" onsubmit="return false;" method="POST">
                    @csrf
                    @if($user_answer)
                        @foreach ($user_answer as $user_answer_key => $user_answer_value)
                            <div class="form-check-inline">
                                <label class="form-check-label" for="check.{{ $user_answer_key +=1 }}">
                                    <input type="hidden" class="form-check-input" name="question_id" value="{{ $questions->first()->id }}">
                                    {{-- <input type="hidden" class="form-check-input" name="sitting_id" value="{{ $sitting->id }}"> --}}

                                    @if ($user_answer_value['is_correct'] && $your_answer->result)
                                    <input type="checkbox" class="form-check-input correctAns  mt-1" @if(in_array($user_answer_value['option'], str_split($your_answer['answer']))) checked @endif id="check.{{ $user_answer_key +=1 }}" name="answer[]" value={{ $user_answer_value['option'] }}>{{ $user_answer_value['option'] }}
                                    @elseif(!$user_answer_value['is_correct'] && in_array($user_answer_value['option'], str_split($your_answer['answer'])))
                                    <input type="checkbox" @if((in_array($user_answer_value['option'], str_split($your_answer['answer']))) || (in_array($user_answer_value['option'], str_split($questions->first()->answer)))) checked @endif class="form-check-input notCorrectAns  mt-1"   id="check.{{ $user_answer_key +=1 }}" name="answer[]" value={{ $user_answer_value['option'] }}>{{ $user_answer_value['option'] }}
                                    @elseif($user_answer_value['is_correct'] && !$your_answer->result)
                                    <input type="checkbox" @if((in_array($user_answer_value['option'], str_split($your_answer['answer']))) || (in_array($user_answer_value['option'], str_split($questions->first()->answer)))) checked @endif class="form-check-input @if((in_array($user_answer_value['option'], str_split($questions->first()->answer)))) correctAns @endif  mt-1"   id="check.{{ $user_answer_key +=1 }}" name="answer[]" value={{ $user_answer_value['option'] }}>{{ $user_answer_value['option'] }}
                                    @else
                                    <input type="checkbox" @if((in_array($user_answer_value['option'], str_split($your_answer['answer']))) || (in_array($user_answer_value['option'], str_split($questions->first()->answer)))) checked @endif class="form-check-input @if((in_array($user_answer_value['option'], str_split($questions->first()->answer)))) notCorrectAns @endif  mt-1"   id="check.{{ $user_answer_key +=1 }}" name="answer[]" value={{ $user_answer_value['option'] }}>{{ $user_answer_value['option'] }}
                                    @endif
                                </label>
                            </div>
                        @endforeach
                            <div class="form-check-inline">
                                <label class="label">You Select : {{ $your_answer->answer }}</label>
                            </div>
                            <div class="form-check-inline">
                                <label class="label   {{ $your_answer->result == 1 ? 'correct' : 'wrong' }}"><b>Your Answer is {{ $your_answer->result == 1 ? 'Correct' : 'Wrong' }} !</b></label>
                            </div>
                    @else
                        <input type="hidden" class="form-check-input" name="question_id" value="{{ $questions->first()->id }}">
                        <input type="hidden" class="form-check-input" name="sitting_id" value="{{ $sitting->id }}">
                        @foreach ($options as $optionskey => $optionsvalue)
                        @php $keyID = $optionskey +1; @endphp
                        <div class="form-check-inline">
                            <label class="form-check-label" for="check2">
                                <input type="checkbox" class="form-check-input mt-1" id="check{{$keyID}}" name="answer[]" value="{{$optionsvalue}}">{{$optionsvalue}}
                            </label>
                        </div>
                        @endforeach
                        {{-- <div class="form-check-inline " >
                            <label class="form-check-label" for="check1">
                                <input type="hidden" class="form-check-input" name="question_id" value="{{ $questions->first()->id }}">
                                <input type="hidden" class="form-check-input" name="sitting_id" value="{{ $sitting->id }}">

                                <input type="checkbox" class="form-check-input mt-1" id="check1" name="answer[]" value="A">A
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" for="check2">
                                <input type="checkbox" class="form-check-input mt-1" id="check2" name="answer[]" value="B">B
                            </label>
                        </div>
                        <div class="form-check-inline" for="check3">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input mt-1" id="check3" name="answer[]" value="C">C
                            </label>
                        </div>
                        <div class="form-check-inline" for="check4">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input mt-1" id="check4" name="answer[]" value="D">D
                            </label>
                        </div> --}}
                        
                    @endif
                
                    @if($user_answer)
                        {{-- <button  class="btn btn-primary btn-sm">Submit</button> --}}
                    @else
                        <button id="submit_answer" class="btn btn-primary btn-sm">Submit</button>
                    @endif
                </form>
           </div>
            

            <footer class="mt-auto text-dark-50" style="background: #fff; ">
                <div class="row" style=" background: #ffffff; width: 75%; margin: auto; padding: 0px;">
                    @foreach($questions->first()->audio()->orderBy('language_id','asc')->get() as $audio)
                    <div class="col-md-3">
                        <figure>
                            <figcaption class="text-dark">{{ $audio->language->title }}</figcaption>
                            <audio
                                controls
                                src="{{ url('audio/'.$audio->file) }}" style="margin-top: 0.5rem;background: transparent; width:12.0rem; max-height: 1.0rem;" >
                                    {{trans('site.browser_does_not_support')}}
                                    <code>audio</code>
                            </audio>
                        </figure>
                    </div>
                    @endforeach

                    <div class="col-md-3 text-right" >
                        {{$questions->currentPage()}} {{trans('site.of_text')}} {{$questions->total()}}
                        <br/>
                        @if( $questions->previousPageUrl() != null)
                        <a href="{{ $questions->previousPageUrl() }}"><i class="fa-regular fa-square-left fa-2x"></i></a>
                        @endif

                        @if( $questions->currentPage() < $questions->lastPage())
                        <a href="{{ $questions->nextPageUrl() }}"><i class="fa-regular fa-square-right fa-2x"></i></a>
                        @endif

                        @if( $questions->currentPage() == $questions->lastPage())
                        <a href="{{ url('make-pdf/'.$sitting->id) }}" class="btn btn-sm btn-primary"  style="margin-top: -1.0rem; padding: 0.1rem"><i class="fa-solid fa-file-pdf"></i> {{trans('site.print_questions_text')}} </a>
                        @endif
                    </div>
                </div>

            </footer>
        </div>

        <script>
            $('#submit_answer').on('click', function(e){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = document.answer;
                var formData = new FormData(form);
                var url = '{{ route('insert_answer') }}';

                $.ajax({
                    type: 'POST',
                    url: url,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    data: formData,
                    dataSrc: "",
                    beforeSend: function()
                    {
                        $('span.alerts').remove();
                        $("div#divLoading").addClass('show');
                    },
                    complete: function(data, status)
                    {
                        $("div#divLoading").removeClass('show');
                        if (status.indexOf('error') > -1)
                        {
                            showSwalSomethingGoesWrong();
                        }
                    },
                    success: function(data)
                    {
                        if (data.status == 401)
                        {
                            alert(data.message);
                            $.each(data.error1, function(index, value)
                            {
                                $('.err_' + index + ' input').addClass(
                                    'border border-danger');
                                $('.err_' + index).append(
                                    '<span class="small alerts text-danger">' +
                                    value + '</span>');
                            });
                        }
                        if (data.status == 200)
                        {
                            location.reload();

                        }
                    }
            });

            })
        </script>
    </body>

</html>

