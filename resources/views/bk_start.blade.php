<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{config('app.name')}}</title>
        <link href="{{url('focus')}}/assets/css/lib/bootstrap.min.css" rel="stylesheet" />
        <!-- Bootstrap core CSS -->
        <link href="/docs/5.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

        <!-- Favicons -->
        <link rel="stylesheet" type="text/css" href="{{url('fontawesome/css/all.min.css')}}" />

        <link rel="icon" href="/docs/5.1/assets/img/favicons/favicon.ico" />
        <meta name="theme-color" content="#7952b3" />

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

            .card {
                background-color: #F6F8F9;
                border: none;
                border-bottom: 5px solid #65BF85;
            }

            .btn-primary {
                background-color: #383A92;
                border: none;
                border-radius: 1.0rem;
            }
        </style>
    </head>
    <body>
        <main>
            <section class="py-5 text-center container">
                <div class="row py-lg-5">
                    <div class="col-lg-6 col-md-8 mx-auto">
                        <a href="{{ url('/')}} ">
                            <img src="{{ url('logo.jpeg') }}" style="width: 20.0rem;">
                        </a>
                        <h1 class="fw-light">{{config('app.name')}}</h1>

                        <p class="lead text-muted">{{trans('site.select_exam_text')}}</p>
                    </div>
                </div>
            </section>

            <div class="container">
                <div class="row">
                    @foreach($exams as $exam)
                    <div class="col-md-4">
                        <div class="card mb-3" style="width: 18rem;">
                            <img src="{{ url('images/exams/'.$exam->image) }}" class="card-img-top" alt="..." />
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $exam->title }}</h5>
                                @if(App\Helpers\General\ExamHelper::checkQuestions($exam->id) == true)
                                <a href="{{ url('examination/'.$exam->id) }}" class="btn btn-sm btn-primary">{{trans('site.start_text')}}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </main>

        <footer class="text-muted py-5">
            <div class="container">
            </div>
        </footer>

        <script src="/docs/5.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>


