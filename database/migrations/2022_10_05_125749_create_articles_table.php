<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->integer('old_id')->length(11)->nullable();
            $table->string('hex', 11)->unique();
            $table->string('user_id');
            $table->integer('category_id')->nullable();
            $table->string('sponsor_id')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->string('caption')->nullable();
            $table->text('teaser')->nullable();
            $table->longText('body')->nullable();
            $table->string('tags')->nullable();
            $table->string('image')->nullable();
            $table->text('image_caption')->nullable();
            $table->string('image_copyright')->nullable();
            $table->tinyInteger('image_cropped')->nullable();
            $table->integer('views')->nullable();
            $table->timestamps();
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
    
};
