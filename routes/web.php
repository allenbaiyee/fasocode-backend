<?php

use App\UserAnswer;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('do-work', function() {
	$user = \App\User::find(47);
	$user->password = \Hash::make('AA77mxog2Qxxavha');
	$user->save();
	return 0;
});

// routes/web.php

Route::get('fc', function() {
    // return \File::exists('logsgo.jpeg');

     $aa = \App\Audio::all();

    $qq = \App\Question::all();

     foreach($qq as $index => $q) {
        if($q->checkFile() != true) {
            // delete entries without files on the server
            // \App\Question::find($q->id)->delete();
            //echo $index;
        }
    }

    foreach($qq as $index => $q) {
        if($q->numberOfAudio() != 3) {
            // delete entries without files on the server
             \App\Question::find($q->id)->delete();
            echo $index;
        }
    }

     foreach($aa as $index => $a) {
         if($a->checkFile() != true) {
             // delete entries without files on the server
              //\App\Audio::find($a->id)->delete();
             echo $index;
       }
     }

     return 'working';

    // return \App\Question::find('6718')->numberOfAudio();
});

Route::get('importing', function() {
    $users = (new FastExcel)->import('perms.csv', function ($line) {
        return \App\CsvData::create([
            // 'exam' => $line['Name'],
            'exam' => 5,
            // 'section' => $line['Email'],
            'section' => 5,
            'question' => $line['image'],
            'fr' => $line['fr'],
            'mo' => $line['mo'],
            'dy' => $line['dy'],
        ]);
    });
});

Route::post('importing', function(\Illuminate\Http\Request $request) {

    // return $request->all();
    $tempCsvDirectory = public_path() . '/csv/';

    $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'exam' => 'required',
            'section' => 'required',
            'csv' => 'required|max:512',
        ]);

    if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


    $extension = $request->file('csv')->getClientOriginalExtension();
    $csvFile = Carbon\Carbon::now()->format('Ymd').'-'.uniqid().'.'.$extension;
    $request->file('csv')->move($tempCsvDirectory, $csvFile);

    $csvData = (new FastExcel)->import($tempCsvDirectory.$csvFile, function ($row) use ($request) {
        return \App\CsvData::create([
            'exam' => $request->input('exam'),
            'section' => $request->input('section'),
            'question' => $row['image'],
            'answer' => $row['answer'],
            'dy' => $row['dy'],
            'fr' => $row['fr'],
            'mo' => $row['mo'],
        ]);
    });

    // after import insert to various tables
    // delete csv table
    // then delete csv file
    $csvCollection = \App\CsvData::all();

    foreach($csvCollection as $csvCollect) {
        $question = new \App\Question();
        $question->section_id = $csvCollect->section;
        $question->image = $csvCollect->question;
        $question->answer = $csvCollect->answer;
        $question->save();

        // inserting audio file
        $langs = [1 => 'dy', 2 => 'fr', 3 => 'mo'];
        for ($i=1; $i < 4; $i++) {
            // code...
            $audio = new \App\Audio();

            if($i == 1){
                $audio->file = $csvCollect->dy;
            }
            if($i == 2){
                $audio->file = $csvCollect->fr;
            }
            if($i == 3){
                $audio->file = $csvCollect->mo;
            }
            $audio->language_id = $i;
            $audio->question_id = $question->id;
            $audio->save();
        }
    }

    // $csvCollection->delete();

    foreach ($csvCollection as $index => $csvCollect) {
        // code...
        $csvCollect->delete();

    }

    \File::delete($tempCsvDirectory.$csvFile);

    return redirect()->back()->with('s', 'Import successful');
});

Route::group(
[
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function(){ //...

    Route::get('/', function () {
        // return view('welcome');




        $data['title'] = config('app.name');
        $data['exams'] = \App\Exam::all();
        return view('start')->with($data);
    });

    Route::get('/examination/{id}', function ($id) {

        $paginatedQuestions  = null;

        $questions = new Illuminate\Support\Collection();
        $data['exam'] = \App\Exam::find($id);
        $ex = $data['exam'];
        $data['title'] = $data['exam']->title;

        if($paginatedQuestions == null) {

            foreach($data['exam']->sections as $index => $section) {
                if(($data['exam']->title == "Permis C") AND ($section->title == "Serie 48 - 57")) {
                    $questions = $questions->merge($section->questions()->inRandomOrder()->take(20)->get());
                }
                elseif(($data['exam']->title == "Permis C") AND ($section->title == "PL")) {
                    $questions = $questions->merge($section->questions()->inRandomOrder()->take(10)->get());
                }
                else {
                    $questions = $questions->merge($section->questions()->inRandomOrder()->take(30)->get());
                }

            }
        }

        // var_dump($paginatedQuestions);
        // return $questions;
        // build exam sitting based on random question selctions

        $examSitting = new \App\ExamSitting();
        $examSitting->exam_id = $id;
        $examSitting->content = $questions;
        $examSitting->save();

        return redirect()->to('exam/'.$examSitting->id);



        $paginatedQuestions = \App\Helpers\General\CollectionHelper::paginate($questions, 1);
        return view('question')->with($data)->with('questions',$paginatedQuestions);
    });

    Route::get('/exam/{id}', function ($id) {

        $examSitting = \App\ExamSitting::find($id);
        $questions = json_decode($examSitting->content);

        $data['exam'] = $examSitting->exam->title;
        $ex = $data['exam'];
        $data['title'] = $examSitting->exam->title;

        $questionsCollected = new Illuminate\Support\Collection();
        foreach( json_decode($examSitting->content) as $quest) {
            $questionsCollected = $questionsCollected->push(\App\Question::find($quest->id));
        }

        $paginatedQuestions = \App\Helpers\General\CollectionHelper::paginate($questionsCollected, 1);
        $user_answer = UserAnswer::where('question_id', $paginatedQuestions->first()->id)->where('user_id',Auth::user()->id )->first();

        $options_arr =  str_split($paginatedQuestions->first()->option);
        $correct_ans = str_split($paginatedQuestions->first()->answer);

        $option_data = array();
        if($user_answer)
        {
            foreach( $options_arr as $option){
                $is_correct = false;

                if(in_array($option,$correct_ans)){
                    $is_correct = true;
                }
                $option_data[] = array(
                    "option" => $option,
                    "is_correct" =>$is_correct,
                );
            }
        }

        return view('question')->with($data)->with('options',$options_arr)->with('questions',$paginatedQuestions)->with('sitting', $examSitting)->with('user_answer', $option_data)->with('your_answer', $user_answer);
    })->name('demo');

    Route::get('/make-pdf/{id}', function ($id) {

        $examSitting = \App\ExamSitting::find($id);
        $questions = json_decode($examSitting->content);

        $data['exam'] = $examSitting->exam->title;
        $ex = $data['exam'];
        $data['title'] = $examSitting->exam->title;
        $user = Auth::user();
        $questionsCollected = new Illuminate\Support\Collection();
        foreach( json_decode($examSitting->content) as $index => $quest) {
            $questionsCollected = $questionsCollected->push(\App\Question::find($quest->id));
        }
        // dd($questionsCollected);

        $dtt = [
            'questions' => $questionsCollected,
            'sitting' => $examSitting,
            'exam' => $data['exam'],
        ];
        $pdft = PDF::loadView('pdf', $dtt);
        return $pdft->download(strtolower(str_replace(' ', '-',$data['title'])).'-dgttm.pdf');
    });

});

/** OTHER PAGES THAT SHOULD NOT BE LOCALIZED **/




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/terms_condition', 'TermsConditionController@terms_condition')->name('terms_condition');


Route::group(
[
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function(){

        Route::middleware(['auth'])->prefix('admin')->group(function () {
            Route::get('/', function () {
                // Uses first & second Middleware
                $data['exams'] = \App\Exam::all();
                $data['title'] = trans('site.dashboard');

                $audioFilesTotalSize = 0;
                $imageFilesTotalSize = 0;
                $audioFiles = \App\Audio::all();
                $imageFiles = \App\Question::all();

                foreach($audioFiles as $audioFile) {
                    $audioFilesTotalSize = $audioFilesTotalSize +  filesize(public_path() . '/audio/'.$audioFile->file);
                }

                foreach($imageFiles as $imageFile) {
                    $imageFilesTotalSize = $imageFilesTotalSize +  filesize(public_path() . '/images/questions/'.$imageFile->image);
                }

                $data['imageFilesTotalSize']  = number_format(($imageFilesTotalSize/1024)/1024,2, '.', '');
                $data['audioFilesTotalSize']  = number_format(($audioFilesTotalSize/1024)/1024,2, '.', '');

                if(Auth::user()->type == 'school'){
                    return redirect()->route('list');
                    // return view('admin.Register.index')->with($data);
                }

                return view('admin.welcome')->with($data);
            });

            Route::get('get-json-database', function () {
                // return view('welcome');

                // saving json for exams
                $fpExams = fopen('database/exams.json', 'w');
                fwrite($fpExams, json_encode(\App\Exam::all()));
                fclose($fpExams);

                // saving json for sections
                $fpSections = fopen('database/sections.json', 'w');
                fwrite($fpSections, json_encode(\App\Section::all()));
                fclose($fpSections);

                // saving json for questions
                $fpQuestions = fopen('database/questions.json', 'w');
                fwrite($fpQuestions, json_encode(\App\Question::all()));
                fclose($fpQuestions);

                 // saving json for audio
                $fpAudio = fopen('database/audio.json', 'w');
                fwrite($fpAudio, json_encode(\App\Audio::all()));
                fclose($fpAudio);

                $fpLanguage = fopen('database/languages.json', 'w');
                fwrite($fpLanguage, json_encode(\App\Language::all()));
                fclose($fpLanguage);

                return redirect()->back()->with('s',trans('site.local_database_ready'));
            });

            Route::get('import', function () {
                // Uses first & second Middleware
                $data['exams'] = \App\Exam::all();
                $data['sections'] = \App\Section::all();
                $data['title'] = trans('site.import');
                return view('admin.import')->with($data);
            });


            Route::resource('languages','LanguageController');
            Route::resource('exams','ExamController');
            Route::resource('sections','SectionController');
            Route::resource('questions','QuestionController');

            Route::get('user/profile', function () {
                // Uses first & second Middleware
                return 0;
            });

            // Route::group(['prefix' => 'admin', 'as' => 'admin'], function () {
            // });

            // Register
            Route::get('/register', 'RegisterController@view')->name('register');
            Route::post('/add-user', 'RegisterController@store')->name('add_user');
            Route::get('/list', 'RegisterController@list')->name('list');
            Route::get('/userList', 'RegisterController@userList')->name('user_list');
            Route::get('/edit/{id}', 'RegisterController@edit')->name('edit');
            Route::post('/update', 'RegisterController@update')->name('update');
            Route::delete('/destroy/{id}', 'RegisterController@destroy')->name('destroy');
            

            Route::get('/user-list', 'RegisterController@index')->name('list.user');

            // Terms & Condition
            Route::get('/terms_condition_view', 'TermsConditionController@view')->name('terms_condition_view');
            Route::post('/terms_condition_update', 'TermsConditionController@update')->name('terms_condition_update');

            // User Answer
            Route::post('/insert_answer', 'UserAnswerController@create')->name('insert_answer');

            // Activation Code
            Route::get('/code_list', 'ActivationCodeController@list')->name('code_list');
            Route::get('/view_code', 'ActivationCodeController@view')->name('view_code');
            Route::post('/add_code', 'ActivationCodeController@store')->name('add_code');
            Route::get('/edit_code/{id}', 'ActivationCodeController@edit')->name('edit_code');
            Route::post('/update_code', 'ActivationCodeController@update')->name('update_code');
            Route::delete('/destroy_code/{id}', 'ActivationCodeController@destroy')->name('destroy_code');

            Route::get('/code', 'ActivationCodeController@index')->name('list.code');
            Route::post('/prolong_code', 'ActivationCodeController@prolong_code')->name('prolong_code');
            Route::post('/xlsxImport', 'QuestionController@XlsxImport')->name('xlsxImport');

            // Route::get('/xlsxExport',[ExaleGenerateController::class,'XlsxExport'])->name('xlsxExport');
        });

        Route::post('/checkEmail', 'RegisterController@checkEmail')->name('checkEmail');


});
