<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleColumnToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('exam_id')->default(0)->after('id');
            $table->string('fname')->nullable()->after('name');
            $table->string('lname')->nullable()->after('fname');
            $table->string('phone')->nullable()->after('lname');
            $table->date('dob')->nullable()->after('phone');
            $table->enum('gender',['male','female'])->nullable()->after('dob');
            $table->string('token')->nullable()->after('remember_token');
            $table->string('mac_address')->nullable()->after('token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
