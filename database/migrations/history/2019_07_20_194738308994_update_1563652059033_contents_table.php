<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Update1563652059033ContentsTable extends Migration
{
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->longText('body')->nullable();
            $table->longText('lid')->nullable();
            $table->string('rutitr')->nullable();
            $table->string('status')->nullable();
        });
    }

    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
        });
    }
}
