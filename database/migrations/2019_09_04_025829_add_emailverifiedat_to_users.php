<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailverifiedatToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( !Schema::hasColumn('users', 'email_verified_at')){
            Schema::table('users', function (Blueprint $table) {
            $table->timestamp('email_verified_at');
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
        if ( !Schema::hasColumn('users', 'email_verified_at')){
            Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email_verified_at');
            });
        }
    }
}
