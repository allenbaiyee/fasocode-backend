<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CsvData extends Model
{

    protected $table = 'csv_data';

    protected $fillable = ['exam', 'section','question','fr','mo','dy','answer'];

}
