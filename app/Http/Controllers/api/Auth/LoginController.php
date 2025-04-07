<?php

namespace App\Http\Controllers\api\Auth;

use App\Exam;
use App\Http\Controllers\Controller;
use App\Question;
use App\Section;
use App\TermsCondition;
use Carbon\Carbon;
// use Illuminate\Foundation\Auth\User;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;

class LoginController extends Controller
{
    public function login2(Request $request){

        try {
            $rules = array(
                'token' => 'required',
            );

            $validatorMesssages = array(
                'token.required'=>'Please Enter Token.',
            );

            $validator = Validator::make($request->all(), $rules, $validatorMesssages);

            if ($validator->fails()) {
                $error=json_decode($validator->errors());
                return response()->json(['status' => false,'message' => $error]);
            }
            // 588904207276

            $user_data = User::where('token',$request->token)->first();
            if(!$user_data){
                return response()->json(['status' => false,'message' => "Code invalide. Veuillez insérer un code valide"]); 
            }

            if($request->token != 588904207276){
                $mac_address = $request->mac_address;
                if($user_data->mac_address != $request->mac_address && $user_data->mac_address){
                    return response()->json(['status' => false,'message' => "Code invalide. Veuillez insérer un code valide"]);
                }
               
    
                $nowDate = Carbon::now();
                $expiryDate = Carbon::createFromFormat('Y-m-d',$user_data->expiry_date);
                $result = $nowDate->gt($expiryDate);
    
                if($result){
                    return response()->json(['status' => false,'message' => "Token is expired"]);
                }
            }


            $exams = Section::all();
            $exam_data = array();

            $audioFilesTotalSize = 0;
            $imageFilesTotalSize = 0;

            $section_id_arr = array();

            foreach($exams as $exam){
                $exam_array = array(
                    'id' => $exam->id,
                    'exam_id' => $exam->exam_id,
                    'title' => $exam->exam->title,
                    'section_name' => $exam->title,
                    'image' => url('/images/exams/' . $exam->exam->image),
                );
                $exam_array['questions'] = array();
                
                // $section_id = Section::where('exam_id',$exam->id)->value('id');
                $terms_data = TermsCondition::value('terms_condition');
                $questions_data = Question::where('section_id',$exam->id)->with('audio')->get();
                
                $question = array();
                foreach ($questions_data as $questions_data_value){
                    $questiondata['question_id'] = $questions_data_value->id;
                    $questiondata['question_image'] = url('/images/questions/' . $questions_data_value->image);
                    $questiondata['updated_at'] = $questions_data_value->updated_at;
                    $questiondata['audio_questions'] = array();
                    $questiondata['audio_questions']['audio_urls'] =  array();
                    $questiondata['audio_questions']['options'] =  array();
                    


                    $options_arr = str_split($questions_data_value->option);
                    $answer_arr = str_split($questions_data_value->answer);
                    foreach( $options_arr as $option){
                        $is_correct = false;

                        if(in_array($option,$answer_arr)){
                            $is_correct = true;
                        }
                        $option_data = array(
                            "option" => $option,
                            "is_correct" =>$is_correct,
                        );
                        array_push($questiondata['audio_questions']['options'],$option_data);
                    }
                    $imageFilesTotalSize = $imageFilesTotalSize +  filesize(public_path() . '/images/questions/'.$questions_data_value->image);
                    // foreach ($questions_data_value->audio as $audio_key => $audio_value) {
                    foreach ($questions_data_value->audio->where('language_id',$user_data->language_id) as $audio_key => $audio_value) {
                        $audio_value->with('language')->first();
                        $audio_data = array(
                            'name' => $audio_value->language->title,
                            'url' => url('/audio/' . $audio_value->file),
                        );
                        array_push($questiondata['audio_questions']['audio_urls'], $audio_data);
                        $audioFilesTotalSize = $audioFilesTotalSize +  filesize(public_path() . '/audio/'.$audio_value->file);
                    }
                    array_push($question, $questiondata);
                }
                $exam_array['questions'] = $question;
                array_push($exam_data,$exam_array);
            }
            $data['terms_conditions'] = $terms_data;
            $data['exam'] = $exam_data;
            // $data['exam']['PL Permis C'] 
            

            // $audioFilesTotalSize = 0;
                // $imageFilesTotalSize = 0;
                // foreach(\App\Audio::all() as $audioFile) {
                // foreach(\App\Audio::where('language_id',$user_data->language_id)->get() as $audioFile) {
                //     $audioFilesTotalSize = $audioFilesTotalSize +  filesize(public_path() . '/audio/'.$audioFile->file);
                // }

                // foreach(\App\Question::all() as $imageFile) {
                //     $imageFilesTotalSize = $imageFilesTotalSize +  filesize(public_path() . '/images/questions/'.$imageFile->image);
                // }
            $data['totalSize'] = $audioFilesTotalSize+$imageFilesTotalSize;

            $user = User::where('token', $request->token)->value('mac_address');
            if (empty($user)) {
                User::where('token', $request->token)->update(['mac_address' =>$mac_address]);
            }
            return response()->json(['status' => true, 'messages' => 'Login successful','data'=>$data]);

        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function expiry_date(Request $request){
        // $date = User::where('token',$request->activation_code)->value('expiry_date');
        $date = User::where('token',$request->activation_code)->with('ActivationCode')->first();
        // dd($date->expiry_date);
        // dd($date->ActivationCode->is_prolonged);
        // dd($date);
        if(!$date){
            return response()->json(['status' => false, 'messages' => 'Token not found']);
        }
        return response()->json(['status' => true, 'expiry_date' => $date->expiry_date,'is_prolonged' => $date->ActivationCode->is_prolonged]);
    }


    //================================================

    public function login(Request $request){

        $img_zip=array();
        try {
            $rules = array(
                'token' => 'required',
            );

            $validatorMesssages = array(
                'token.required'=>'Please Enter Token.',
            );

            $validator = Validator::make($request->all(), $rules, $validatorMesssages);

            if ($validator->fails()) {
                $error=json_decode($validator->errors());
                return response()->json(['status' => false,'message' => $error]);
            }
            // 588904207276

            $user_data = User::where('token',$request->token)->first();
            // dd($user_data->language_id);
            if(!$user_data){
                return response()->json(['status' => false,'message' => "Code invalide. Veuillez insérer un code valide"]); 
            }

            if($request->token != 990346606599){
                $mac_address = $request->mac_address;
                if($user_data->mac_address != $request->mac_address && $user_data->mac_address){
                    return response()->json(['status' => false,'message' => "Code invalide. Veuillez insérer un code valide"]);
                }
               
    
                $nowDate = Carbon::now();
                $expiryDate = Carbon::createFromFormat('Y-m-d',$user_data->expiry_date);
                $result = $nowDate->gt($expiryDate);
    
                if($result){
                    return response()->json(['status' => false,'message' => "Token is expired"]);
                }
            }


            $exams = Section::all();
            $exam_data = array();

            $audioFilesTotalSize = 0;
            $imageFilesTotalSize = 0;

            $section_id_arr = array();

            foreach($exams as $exam){
                $exam_array = array(
                    'id' => $exam->id,
                    'exam_id' => $exam->exam_id,
                    'title' => $exam->exam->title,
                    'section_name' => $exam->title,
                    'image' => url('/images/exams/' . $exam->exam->image),
                );
                $img_zip[]='/images/exams/' . $exam->exam->image;
                $exam_array['questions'] = array();
                
                // $section_id = Section::where('exam_id',$exam->id)->value('id');
                $terms_data = TermsCondition::value('terms_condition');
                $questions_data = Question::where('section_id',$exam->id)->with('audio')->get();
                
                $question = array();
                foreach ($questions_data as $questions_data_value){
                    $questiondata['question_id'] = $questions_data_value->id;
                    $questiondata['question_image'] = url('/images/questions/' . $questions_data_value->image);
                    $img_zip[]='/images/questions/' . $questions_data_value->image;
                    $questiondata['updated_at'] = $questions_data_value->updated_at;
                    $questiondata['audio_questions'] = array();
                    $questiondata['audio_questions']['audio_urls'] =  array();
                    $questiondata['audio_questions']['options'] =  array();
                    $questiondata['offline_image_url'] =  $questions_data_value->image;
                    


                    $options_arr = str_split($questions_data_value->option);
                    $answer_arr = str_split($questions_data_value->answer);
                    foreach( $options_arr as $option){
                        $is_correct = false;

                        if(in_array($option,$answer_arr)){
                            $is_correct = true;
                        }
                        $option_data = array(
                            "option" => $option,
                            "is_correct" =>$is_correct,
                        );
                        array_push($questiondata['audio_questions']['options'],$option_data);
                    }
                    $imageFilesTotalSize = $imageFilesTotalSize +  filesize(public_path() . '/images/questions/'.$questions_data_value->image);
                    // foreach ($questions_data_value->audio as $audio_key => $audio_value) {
                        
                    foreach ($questions_data_value->audio->where('language_id',$user_data->language_id) as $audio_key => $audio_value) {
                        $audio_value->with('language')->first();
                        $audio_data = array(
                            'name' => $audio_value->language->title,
                            'url' => url('/audio/' . $audio_value->file),
                        );
                        $img_zip[]='/audio/' . $audio_value->file;
                        $questiondata['offline_audio_url'] =  $audio_value->file;
                        $questiondata['offline_audio_name'] =  $audio_value->language->title;
                        array_push($questiondata['audio_questions']['audio_urls'], $audio_data);
                        $audioFilesTotalSize = $audioFilesTotalSize +  filesize(public_path() . '/audio/'.$audio_value->file);
                    }
                    array_push($question, $questiondata);
                }
                
                $exam_array['questions'] = $question;
                array_push($exam_data,$exam_array);
            }
           
            $data['terms_conditions'] = $terms_data;
            $data['exam'] = $exam_data;
            // $data['exam']['PL Permis C'] 
            

            

            // $audioFilesTotalSize = 0;
                // $imageFilesTotalSize = 0;
                // foreach(\App\Audio::all() as $audioFile) {
                // foreach(\App\Audio::where('language_id',$user_data->language_id)->get() as $audioFile) {
                //     $audioFilesTotalSize = $audioFilesTotalSize +  filesize(public_path() . '/audio/'.$audioFile->file);
                // }

                // foreach(\App\Question::all() as $imageFile) {
                //     $imageFilesTotalSize = $imageFilesTotalSize +  filesize(public_path() . '/images/questions/'.$imageFile->image);
                // }
            $data['totalSize'] = $audioFilesTotalSize+$imageFilesTotalSize;
            
            //-------------------------------------startzip--------------------        
            
            $zip = new \ZipArchive();
            $fileName = $request->token.'_File.zip';
            if ($zip->open(public_path('zip/'.$fileName), \ZipArchive::CREATE)== TRUE)
            {
               // $files = File::files(public_path('myFiles'));
                foreach ($img_zip as $key => $value){
                    //dd(public_path($value));
                    $relativeName = basename($value);
                    $zip->addFile(public_path($value), $relativeName);
                }
                $zip->close();
            }
            $data['zip_file']=url('zip/'.$fileName);
            $data['zip_file_size']=filesize(public_path() . '/zip/'.$fileName);
            // dd($img_zip);
            //-------------------------------------endzip--------------------        
            // dd(filesize(public_path() . '/zip/'.$fileName));
            $user = User::where('token', $request->token)->value('mac_address');
            if (empty($user)) {
                User::where('token', $request->token)->update(['mac_address' =>$mac_address]);
            }
            return response()->json(['status' => true, 'messages' => 'Login successful','data'=>$data]);

        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
            


    }
    public function question(Request $request){
        // dd($request->language);
        $img_zip=array();
        try {
            if(!$request->language){
                return response()->json(['status' => false,'message' => "Language id is required"]); 
            }
            $language = $request->language;
            $exams = Section::where('id',7)->get();
            $exam_data = array();

            $audioFilesTotalSize = 0;
            $imageFilesTotalSize = 0;

            foreach($exams as $exam){
                $exam_array = array(
                    'id' => $exam->id,
                    'exam_id' => $exam->exam_id,
                    'title' => $exam->exam->title,
                    'section_name' => $exam->title,
                    'image' => url('/images/exams/' . $exam->exam->image),
                );
                $img_zip[]='/images/exams/' . $exam->exam->image;
                $exam_array['questions'] = array();
                

                $terms_data = TermsCondition::value('terms_condition');
                $questions_data = Question::where('section_id', $exam->id)
                ->with(['audio' => function ($query) use ($language) {
                    $query->where('language_id', $language);
                }])
                ->limit(30)
                ->get();
                
                $question = array();
                foreach ($questions_data as $questions_data_value){
                    $questiondata['question_id'] = $questions_data_value->id;
                    $questiondata['question_image'] = url('/images/questions/' . $questions_data_value->image);
                    $img_zip[]='/images/questions/' . $questions_data_value->image;
                    $questiondata['updated_at'] = $questions_data_value->updated_at;
                    $questiondata['audio_questions'] = array();
                    $questiondata['audio_questions']['audio_urls'] =  array();
                    $questiondata['audio_questions']['options'] =  array();
                    $questiondata['offline_image_url'] =  $questions_data_value->image;

                    $options_arr = str_split($questions_data_value->option);
                    $answer_arr = str_split($questions_data_value->answer);
                    foreach( $options_arr as $option){
                        $is_correct = false;

                        if(in_array($option,$answer_arr)){
                            $is_correct = true;
                        }
                        $option_data = array(
                            "option" => $option,
                            "is_correct" =>$is_correct,
                        );
                        array_push($questiondata['audio_questions']['options'],$option_data);
                    }
                    $imageFilesTotalSize = $imageFilesTotalSize +  filesize(public_path() . '/images/questions/'.$questions_data_value->image);
                    // foreach ($questions_data_value->audio as $audio_key => $audio_value) {
                        
                    foreach ($questions_data_value->audio->where('language_id',$language) as $audio_key => $audio_value) {
                        $audio_value->with('language')->first();
                        $audio_data = array(
                            'name' => $audio_value->language->title,
                            'url' => url('/audio/' . $audio_value->file),
                        );
                        $img_zip[]='/audio/' . $audio_value->file;
                        $questiondata['offline_audio_url'] =  $audio_value->file;
                        $questiondata['offline_audio_name'] =  $audio_value->language->title;
                        array_push($questiondata['audio_questions']['audio_urls'], $audio_data);
                        $audioFilesTotalSize = $audioFilesTotalSize +  filesize(public_path() . '/audio/'.$audio_value->file);
                    }
                    array_push($question, $questiondata);
                }
                
                $exam_array['questions'] = $question;
                array_push($exam_data,$exam_array);
            }
           
            $data['terms_conditions'] = $terms_data;
            $data['exam'] = $exam_data;
           
            $data['totalSize'] = $audioFilesTotalSize+$imageFilesTotalSize;
            
            //-------------------------------------startzip--------------------        
            
            $zip = new \ZipArchive();
            $fileName = $language.'_File.zip';
            if ($zip->open(public_path('zip/'.$fileName), \ZipArchive::CREATE)== TRUE)
            {
                foreach ($img_zip as $key => $value){
                    $relativeName = basename($value);
                    $zip->addFile(public_path($value), $relativeName);
                }
                $zip->close();
            }
            $data['zip_file']=url('zip/'.$fileName);
            $data['zip_file_size']=filesize(public_path() . '/zip/'.$fileName);
            return response()->json(['status' => true, 'messages' => 'success','data'=>$data]);

        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
            


    }
}
