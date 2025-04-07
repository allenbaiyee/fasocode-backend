<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsProlongedColumnToActivationCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activation_codes', function (Blueprint $table) {
            $table->enum('is_prolonged',[0,1])->default(0)->after('is_used');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activation_codes', function (Blueprint $table) {
            //
        });
    }
}
