<?php

namespace App\Http\Controllers;

use App\Question;
use App\UserAnswer;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAnswerController extends Controller
{
    public function create(Request $request){
        // dd($request->all());
        $rules = array(
            'question_id' => 'required',
            'answer' => 'required',
        );

        $validatorMesssages = array(
            'question_id.required'=>'Please Select question.',
            'answer.required'=>'Please Select Answer.',
        );

        $validator = Validator::make($request->all(), $rules, $validatorMesssages);

        if ($validator->fails()) {

            $error=json_decode($validator->errors());
            return response()->json(['status' => 401,'error1' => $error]);
        }

        $correct_ans = Question::where('id',$request->question_id)->value('answer');

        $answers = '';
        $is_correct = 0;
        // dd(count($request->answer));
        foreach ($request->answer as $key => $value) {
            $answers .= $value;
        }
        
        if(strlen($correct_ans) == count($request->answer)){
            
            $result = array_diff(str_split($answers),str_split($correct_ans));
            if(count($result) == 0){
                $is_correct = 1;
            }
        }
        $data = array(
            'user_id' => Auth::user()->id,
            'question_id' => $request->question_id,
            'exam_sitting_id' => $request->sitting_id,
            'answer' => $answers,
            'result' => $is_correct,
        );

        $check_question = UserAnswer::where('user_id', Auth::user()->id)->where('question_id',$request->question_id)->value('answer');
        if($check_question){
            return response()->json(['status' => 401, 'message' => "Answer already submitted"]);
        }
        // dd($check_question);
        UserAnswer::create($data);
       
        return response()->json(['status' => 200, 'message' => 'Answer Submit']);

    }
    
}
