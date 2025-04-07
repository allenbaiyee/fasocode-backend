<?php


namespace App\Helpers\General;

use App\ActivationCode;
use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class ActivationCodeGenerate {
	public static function generateCode($school_id,$code) {

        $x = 1;

        $activation_codes = array();
        while($x <= $code) {
            $randomNumber = rand(100000000000,999999999999);

            $activation_code = ActivationCode::where('activation_code', $randomNumber)->first();

            if(empty($activation_code)){
                array_push($activation_codes,$randomNumber);
                $x++;
            }
        }
        
        return $activation_codes;

        
    }
}
