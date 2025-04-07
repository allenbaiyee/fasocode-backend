<?php


namespace App\Helpers\General;


use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class ExamHelper {
	public static function checkQuestions($id) {
        $questions = false;
        foreach(\App\Exam::find($id)->sections as $section) {
            if($section->questions()->count() > 0) {
                $questions = true;
            }
        }
        return $questions;
    }
}
