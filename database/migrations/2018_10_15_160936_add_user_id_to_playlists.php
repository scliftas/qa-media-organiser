<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToPlaylists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('playlists', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->after('id');

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('playlists', function (Blueprint $table) {
            $table->deleteForeign('user_id');
            
            $table->dropColumn('user_id');
        });
    }
}
