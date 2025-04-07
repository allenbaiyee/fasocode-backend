<?php

namespace App\Imports;

use App\Question;
use Maatwebsite\Excel\Concerns\ToModel;

class XlsxImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Question([
            'image' => $row[1],
            'option' => $row[4],
        ]);
    }
}
