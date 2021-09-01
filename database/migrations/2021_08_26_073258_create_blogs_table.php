<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
//    public function up()
//    {
//        Schema::create('blogs', function (Blueprint $blogs) {
//            $blogs->id();
//            $blogs->string('title')->default("")->comment('タイトル');
//            $blogs->text('content')->nullable()->comment('内容');
//            $blogs->timestamps();
//        });
//    }

    public function up()
    {
        Schema::create('blogs', function (Blueprint $blogs) {
            $blogs->integer('user_id')->default("0");
            $blogs->string('picture')->nullable();
            $blogs->integer('all_count')->nullable();
            $blogs->boolean('active')->default("false");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
