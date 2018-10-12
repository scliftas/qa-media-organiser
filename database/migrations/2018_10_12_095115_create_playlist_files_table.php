<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaylistFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playlist_files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('playlist_id');
            $table->unsignedInteger('file_id');
            $table->integer('position');
            $table->timestamps();

            $table->foreign('playlist_id')->references('id')->on('playlists');
            $table->foreign('file_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('playlist_files');
    }
}
