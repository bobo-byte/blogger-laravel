<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('tag');
            $table->timestamps();
        });


        //pivot table for many to many relationship.

        Schema::create('post_topic', function (Blueprint $table){
            $table->id();
            $table->foreignId('post_id');
            $table->foreignId('topic_id');

            $table->unique(['post_id', 'topic_id']);

            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->cascadeOnDelete();

            $table->foreign('topic_id')
                ->references('id')
                ->on('topics')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topics');
    }
}
