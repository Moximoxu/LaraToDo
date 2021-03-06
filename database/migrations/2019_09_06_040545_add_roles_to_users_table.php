<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRolesToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( !Schema::hasColumn('users', 'roles')){
            Schema::table('users', function (Blueprint $table) {
            $table->string('roles');
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
        if ( Schema::hasColumn('users', 'roles')){
            Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('roles');
            });
        }
    }
}
