<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGenderandbirthdateToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( !Schema::hasColumn('users', 'gender')){
            Schema::table('users', function (Blueprint $table) {
            $table->string('gender', 6);
            });
        }
        
        if ( !Schema::hasColumn('users', 'birthdate')){
            Schema::table('users', function (Blueprint $table) {
            $table->date('birthdate');
        });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ( Schema::hasColumn('users', 'gender')){
            Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gender');
            });
        }
        
        if ( Schema::hasColumn('users', 'birthdate')){
            Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('birthdate');
            });
        }
    }
}
